<?php
/**
 * Este arquivo é parte do programa Quack Itaú
 *
 * Quack Itaú é um software livre; você pode redistribuí-lo e/ou
 * modificá-lo dentro dos termos da Licença Pública Geral GNU como
 * publicada pela Fundação do Software Livre (FSF); na versão 3 da
 * Licença, ou (na sua opinião) qualquer versão.
 *
 * Este programa é distribuído na esperança de que possa ser  útil,
 * mas SEM NENHUMA GARANTIA; sem uma garantia implícita de ADEQUAÇÃO
 * a qualquer MERCADO ou APLICAÇÃO EM PARTICULAR. Veja a
 * Licença Pública Geral GNU para maiores detalhes.
 *
 * Você deve ter recebido uma cópia da Licença Pública Geral GNU junto
 * com este programa, Se não, veja <http://www.gnu.org/licenses/>.
 *
 * @category   Quack
 * @package    Quack_Itau
 * @author     Rafael Patro <rafaelpatro@gmail.com>
 * @copyright  Copyright (c) 2017 Rafael Patro (rafaelpatro@gmail.com)
 * @license    http://www.gnu.org/licenses/gpl.txt
 * @link       https://github.com/rafaelpatro/Quack_Itau
 */
?>
<?php
class Quack_Itau_Model_Observer {
	const PAYMENT_METHOD = 'itau_standard';
	/**
	 * Set additional payment information in frontend order view page.
	 * 
	 * @param Varien_Event_Observer $observer
	 */
	public function setFrontendPaymentInfo(Varien_Event_Observer $observer) {
		$block     = $observer->getEvent()->getBlock();     /* @var $block Mage_Payment_Block_Info */
		$payment   = $observer->getEvent()->getPayment();   /* @var $payment Mage_Payment_Model_Info */
		$transport = $observer->getEvent()->getTransport(); /* @var $transport Varien_Object */
		if ($block->getBlockAlias() == 'payment_info' && $payment->getMethodInstance()->getCode() == self::PAYMENT_METHOD) {
			$order = $payment->getOrder();
			if ($order instanceof Mage_Sales_Model_Order) {
				$orderId = $order->getData('entity_id');
				$baseUrl = Mage::getBaseUrl();
				$url     = "{$baseUrl}itau/standard/redirect/order_id/{$orderId}";
				$state   = $order->getData('state');
                $isAllowBankTransfer = ($payment->getMethodInstance()->getConfigData('allowbanktransfer') == 1);
                $cmsBankTransferPage = $payment->getMethodInstance()->getConfigData('cms_banktransfer_page');
				$transport->setData(array(
					'Método' => Mage::helper('itau/data')->getTypeMessage( $payment->getAdditionalInformation('tipPag') ),
					'Situação' => Mage::helper('itau/data')->getStatusMessage( $payment->getAdditionalInformation('sitPag') )
				));
				if ($state==Mage_Sales_Model_Order::STATE_NEW) {
					$itauBlock = $block->getLayout()->createBlock('payment/info'); /* @var $itauBlock Mage_Payment_Block_Info */
					$itauBlock->setData('shoplineurl', $url);
                    $itauBlock->setData('allowbanktransfer', $isAllowBankTransfer);
                    $itauBlock->setData('cmsbanktransferpage', $cmsBankTransferPage);
					$itauBlock->setTemplate("itau/info/pending.phtml");
					$block->setChild('itau_try_again', $itauBlock);
				}
			}
		} elseif ($block->getBlockAlias() == 'payment.info.'.self::PAYMENT_METHOD) {
			// Checkout Payment Info Block
			$transport->setData('.::Transação bancária via Itaú Shopline:');
		}
		return;
	}
	
	/**
	 * Set additional payment information in backend order view page.
	 * 
	 * @param Varien_Event_Observer $observer
	 */
	public function setBackendPaymentInfo(Varien_Event_Observer $observer) {
		$payment  = $observer->getEvent()->getPayment(); /* @var $payment Mage_Payment_Model_Info */
		if ($payment->getMethodInstance()->getCode() == self::PAYMENT_METHOD) {
			$observer->getEvent()->getTransport()->setData(array(
					'Método' => Mage::helper('itau/data')->getTypeMessage( $payment->getAdditionalInformation('tipPag') ),
					'Situação' => Mage::helper('itau/data')->getStatusMessage( $payment->getAdditionalInformation('sitPag') )
			));
		}
		return;
	}
	
	public function checkPayment() {
		$order = Mage::getModel('sales/order'); /* @var $order Mage_Sales_Model_Order */
		$capturedPaymentsCounter = 0;
		$collection = self::loadPending();
		foreach ($collection as $entity) {
			$order->load($entity->getParentId());
			if ($order->canInvoice()) {
				$invoice = $order->prepareInvoice();
				$invoice->setRequestedCaptureCase(Mage_Sales_Model_Order_Invoice::CAPTURE_ONLINE);
				try {
					$invoice->register();
				} catch (Exception $e) {
					Mage::log("{$e->getMessage()}");
					unset($invoice);
					unset($order);
					$order = Mage::getModel('sales/order');
					continue;
				}
				$invoice->getOrder()->setIsInProcess(true);
				$order->addStatusHistoryComment('Pagamento capturado automaticamente');
				$transaction = Mage::getModel('core/resource_transaction')
					->addObject($invoice)
					->addObject($invoice->getOrder());
				$transaction->save();
				$invoice->sendEmail(true);
				$capturedPaymentsCounter++;
			}
		}
		$pendingPaymentsCounter = count($collection);
		return "{$capturedPaymentsCounter} payments captured of {$pendingPaymentsCounter} pending";
	}
	
	public function loadPending() {
		/* @var $order Mage_Sales_Model_Order */
		$order = Mage::getModel('sales/order');
		$table = $order->getResource()->getTable('sales/order');
		/* @var $collection Mage_Sales_Model_Mysql4_Order_Payment_Collection */
		$collection = Mage::getModel('sales/order_payment')->getCollection();
		$collection->getSelect()->join($table, "main_table.parent_id = {$table}.entity_id", array());
		$collection
			->addAttributeToFilter('method', self::PAYMENT_METHOD)
			->addAttributeToFilter('amount_paid', array('null' => true))
			->addAttributeToFilter('state', $order::STATE_NEW);
		return $collection;
	}
	
}