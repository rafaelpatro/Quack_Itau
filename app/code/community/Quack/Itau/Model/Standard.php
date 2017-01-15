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
class Quack_Itau_Model_Standard extends Mage_Payment_Model_Method_Abstract {
	const PAYMENT_TYPE_AUTH = 'AUTHORIZATION';
	const PAYMENT_TYPE_SALE = 'SALE';
	protected $_code = 'itau_standard';
	protected $_formBlockType = 'itau/standard_form';
	protected $_allowCurrencyCode = array ('BRL');
	protected $_canUseInternal = true;
	protected $_canCapture = true;
	protected $_canUseForMultishipping = true;
	protected $_order = null;
	
	public function getSession() {
		return Mage::getSingleton( 'itau/session' );
	}
	
	/**
	 * Get checkout session namespace
	 *
	 * @return Mage_Checkout_Model_Session
	 */
	public function getCheckout() {
		return Mage::getSingleton( 'checkout/session' );
	}
	
	/**
	 * Get current quote
	 *
	 * @return Mage_Sales_Model_Quote
	 */
	public function getQuote() {
		return $this->getCheckout()->getQuote();
	}
	
	public function createFormBlock($name) {
		$block = $this->getLayout()
			->createBlock( 'itau/standard_form', $name )
			->setMethod( 'itau_standard' )
			->setPayment( $this->getPayment () )
			->setTemplate( 'itau/standard/form.phtml' );
		return $block;
	}
	
	public function getTransactionId() {
		return $this->getSessionData( 'transaction_id' );
	}
	
	public function setTransactionId($data) {
		return $this->setSessionData( 'transaction_id', $data );
	}
	
	public function validate() {
		parent::validate ();
		$currency_code = $this->getQuote()->getBaseCurrencyCode();
		if ($currency_code == '') {
			$currency_code = Mage::getSingleton('adminhtml/session_quote')->getQuote()->getBaseCurrencyCode();
		}
		if (! in_array( $currency_code, $this->_allowCurrencyCode )) {
			Mage::throwException( Mage::helper ( 'itau' )->__( 'A moeda selecionada (' . $currency_code . ') não é compatível com o método de pagamento escolhido' ) );
		}
		return $this;
	}
	
	public function getOrderPlaceRedirectUrl() {
        if ($this->getConfigData('allowredirect') == 1) {
            return Mage::getUrl('itau/standard/redirect');
        }
        return;
	}
	
	/**
	 * @param Mage_Sales_Model_Order $order
	 * @return Quack_BB_Model_Standard
	 */
	public function setOrder($order) {
		$this->_order = $order;
		return $this;
	}
	
	/**
	 * @return Mage_Sales_Model_Order
	 */
	public function getOrder() {
		if (!($this->_order instanceof Mage_Sales_Model_Order)) {
			$this->_order = Mage::getModel( 'sales/order' );
			$orderIncrementId = $this->getCheckout()->getLastRealOrderId();
			$this->_order->loadByIncrementId( $orderIncrementId );
		}
		return $this->_order;
	}
		
	/**
	 * @param Mage_Sales_Model_Order $order
	 * @return array
	 */
	public function getRedirectFields() {
		$this->log("Quack_Itau_Model_Standard::getRedirectFields() started");
		$order = $this->getOrder();
		$a = $order->getBillingAddress();
		$a_date = explode( "-", substr( $order->getCreatedAt(), 0, 10 ) );
		$s_dt_vencimento = date( "dmY", mktime( 0, 0, 0, $a_date[1], $a_date[2] + $this->getConfigData( 'dias_vencimento' ), $a_date[0] ) );
		$digits = new Zend_Filter_Digits();
		$cpfCnpj = $digits->filter( $order->getData( 'customer_taxvat' ) );
		/* @var $shopline Quack_Itau_Model_Shopline */
		$shopline = Mage::getModel('itau/shopline');
		$shopline
			->setCodEmp(strtoupper($this->getConfigData( 'codigo_loja' )))
			->setPedido($order->getData('entity_id'))
			->setValor(number_format( $order->getGrandTotal(), 2, ',', '' ))
			->setObservacao($this->getConfigData( 'tp_obs' ))
			->setChave(strtoupper($this->getConfigData( 'chave' )))
			->setNomeSacado(substr( $a->getFirstname() . ' ' . $a->getLastname(), 0, 30 ))
			->setCodigoInscricao((strlen($cpfCnpj) == 14) ? '02' : '01')
			->setNumeroInscricao(str_pad( $cpfCnpj, 14, '0', STR_PAD_LEFT ))
			->setEnderecoSacado(substr( $a->getStreet( 1 ) . ' ' . $a->getStreet( 2 ), 0, 40 ))
			->setBairroSacado(substr( $a->getStreet( 4 ), 0, 15 ))
			->setCepSacado($digits->filter( $a->getPostcode() ))
			->setCidadeSacado(substr( $a->getCity(), 0, 15 ))
			->setEstadoSacado($a->getRegionCode())
			->setDataVencimento($s_dt_vencimento)
			->setUrlRetorna($this->getConfigData( 'retorno' ))
			->setObsAdicional1($this->getConfigData( 'obs1' ))
			->setObsAdicional2($this->getConfigData( 'obs2' ))
			->setObsAdicional3($this->getConfigData( 'obs3' ));
		$dados = $this->getHelper()->encrypt($shopline);
		return array( 'DC' => $dados );
	}
	
	public function getRequestUrl() {
		return 'https://shopline.itau.com.br/shopline/shopline.aspx';
	}
	
	public function getItauConsultaUrl() {
		return 'https://shopline.itau.com.br/shopline/consulta.aspx';
	}
	
	/**
	 * @return Quack_Itau_Helper_Data
	 */
	public function getHelper() {
		return Mage::helper('itau/data');
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Mage_Payment_Model_Method_Abstract::capture()
	 */
	public function capture(Varien_Object $payment, $amount) {
		parent::capture($payment, $amount);
		$this->log("Quack_Itau_Model_Standard::capture() started");
		try {
			/* @var $request Quack_Itau_Model_Consulta */
			$request = Mage::getModel('itau/consulta')
				->setCodEmp($this->getConfigData('codigo_loja'))
				->setChave($this->getConfigData('chave'))
				->setPedido($payment->getParentId())
				->setFormato('1');
			$dados = $this->getHelper()->encrypt($request);
			$consulta = $this->consulta($dados);
			$this->getInfoInstance()
				->setAdditionalInformation('tipPag', (string)$consulta->getTipPag())
				->setAdditionalInformation('sitPag', (string)$consulta->getSitPag())
				->save();
		} catch (Exception $e) {
			Mage::throwException($e->getMessage());
		}
		if ($consulta->getSitPag() != '00') {
			$typeMsg = $this->getHelper()->getTypeMessage($consulta->getTipPag());
			$statMsg = $this->getHelper()->getStatusMessage($consulta->getSitPag());
			Mage::throwException("{$typeMsg}: {$statMsg}");
		}
		return $this;
	}
	
	/**
	 * @param string $dados
	 * @return Quack_Itau_Model_Consulta
	 */
	public function consulta($dados) {
		$this->log("Quack_Itau_Model_Standard::consulta() started");
		$this->log("DC=$dados");
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $this->getItauConsultaUrl());
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, "DC=$dados");
		$result = curl_exec($ch);
		curl_close($ch);
		$this->log($result);
		
		$consulta = Mage::getModel('itau/consulta'); /* @var $consulta Quack_Itau_Model_Consulta */
		$xml = simplexml_load_string($result);
		if (isset($xml->PARAMETER)) {
    		foreach ($xml->PARAMETER->children() as $PARAM) {
    			$consulta->setDataUsingMethod($PARAM['ID'], (string)$PARAM['VALUE']);
    		}
		}
		return $consulta;
	}
	
	/**
	 * @param string $message
	 * @return Quack_Itau_Model_Standard
	 */
	public function log($message) {
		Mage::log($message, null, 'itau.log');
		return $this;
	}
}
