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
class Quack_Itau_Helper_Data extends Mage_Core_Helper_Abstract {
	public function getStatusMessage($status) {
		$message = "situação desconhecida {$status}";
		switch ($status) {
			case '00': $message = "pagamento efetuado."; break;
			case '01': $message = "situação de pagamento não finalizada"; break;
			case '02': $message = "erro no processamento da consulta"; break;
			case '03': $message = "pagamento não localizado"; break;
			case '04': $message = "boleto emitido com sucesso"; break;
			case '05': $message = "pagamento efetuado, aguardando compensação"; break;
			case '06': $message = "pagamento não compensado"; break;
		}
		return $message;
	}
	
	public function getTypeMessage($type) {
		$message = "método de pagamento desconhecido {$type}";
		switch ($type) {
			case '00': $message = "pagamento ainda não escolhido"; break;
			case '01': $message = "pagamento à vista (TEF e CDC)"; break;
			case '02': $message = "boleto bancário"; break;
			case '03': $message = "cartão de crédito"; break;
		}
		return $message;
	}
	
	public function strtoascii($str) {
		setlocale(LC_ALL, 'pt_BR.utf8');
		return iconv('UTF-8', 'ASCII//TRANSLIT', $str);
	}
	
	/**
	 * @param mixed Quack_Itau_Model_Shopline|Quack_Itau_Model_Consulta $object
	 * @return string
	 */
	public function encrypt($object) {
		$java = null;
		$classpath = Mage::getBaseDir('lib') . "/Java";
		if ($object instanceof Quack_Itau_Model_Shopline) {
			/* @var $object Quack_Itau_Model_Shopline */
			$java = "java -classpath {$classpath} Cripto '{$object->getCodEmp()}' '{$object->getPedido()}' '{$object->getValor()}' '{$object->getObservacao()}' '{$object->getChave()}' '{$object->getNomeSacado()}' '{$object->getCodigoInscricao()}' '{$object->getNumeroInscricao()}' '{$object->getEnderecoSacado()}' '{$object->getBairroSacado()}' '{$object->getCepSacado()}' '{$object->getCidadeSacado()}' '{$object->getEstadoSacado()}' '{$object->getDataVencimento()}' '{$object->getUrlRetorna()}' '{$object->getObsAdicional1()}' '{$object->getObsAdicional2()}' '{$object->getObsAdicional3()}'";
			$java = $this->strtoascii($java);
		} elseif ($object instanceof Quack_Itau_Model_Consulta) {
			/* @var $object Quack_Itau_Model_Consulta */
			$java = "java -classpath {$classpath} Consulta '{$object->getCodEmp()}' '{$object->getPedido()}' '{$object->getFormato()}' '{$object->getChave()}'";
		}
		exec($java, $DC);
		return $DC[0];
	}
	
	/**
	 * @param string $dados
	 * @param string $chave
	 * @return array
	 */
	public function decrypt($dados, $chave) {
		$chave = strtoupper($chave);
		$java = "java -classpath {$classpath} Decripto '{$dados}' '{$chave}'";
		exec($java, $DC);
		return array(
			substr($DC[0], 0, 26),
			substr($DC[0], 26, 8),
			substr($DC[0], 34, 2),
		);
	}
	
}
?>
