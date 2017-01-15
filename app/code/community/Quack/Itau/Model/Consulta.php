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
class Quack_Itau_Model_Consulta extends Varien_Object {
	/**
	 * @var string
	 */
	protected $CodEmp;
	/**
	 * @var string
	 */
	protected $Pedido;
	/**
	 * @var string
	 */
	protected $Valor;
	/**
	 * @var string
	 */
	protected $tipPag;
	/**
	 * @var string
	 */
	protected $sitPag;
	/**
	 * @var string
	 */
	protected $dtPag;
	/**
	 * @var string
	 */
	protected $codAut;
	/**
	 * @var string
	 */
	protected $numId;
	/**
	 * @var string
	 */
	protected $compVend;
	/**
	 * @var string
	 */
	protected $tipCart;
	/**
	 * @var string
	 */
	protected $Formato;
	/**
	 * @var string
	 */
	protected $Chave;
	
	/**
	 *
	 * @return string
	 */
	public function getCodEmp() {
		return $this->CodEmp;
	}
	
	/**
	 *
	 * @param
	 *        	$CodEmp
	 */
	public function setCodEmp($CodEmp) {
		$this->CodEmp = $CodEmp;
		return $this;
	}
	
	/**
	 *
	 * @return string
	 */
	public function getPedido() {
		return $this->Pedido;
	}
	
	/**
	 *
	 * @param
	 *        	$Pedido
	 */
	public function setPedido($Pedido) {
		$this->Pedido = $Pedido;
		return $this;
	}
	
	/**
	 *
	 * @return string
	 */
	public function getValor() {
		return $this->Valor;
	}
	
	/**
	 *
	 * @param
	 *        	$Valor
	 */
	public function setValor($Valor) {
		$this->Valor = $Valor;
		return $this;
	}
	
	/**
	 *
	 * @return string
	 */
	public function getTipPag() {
		return $this->tipPag;
	}
	
	/**
	 *
	 * @param
	 *        	$tipPag
	 */
	public function setTipPag($tipPag) {
		$this->tipPag = $tipPag;
		return $this;
	}
	
	/**
	 *
	 * @return string
	 */
	public function getSitPag() {
		return $this->sitPag;
	}
	
	/**
	 *
	 * @param
	 *        	$sitPag
	 */
	public function setSitPag($sitPag) {
		$this->sitPag = $sitPag;
		return $this;
	}
	
	/**
	 *
	 * @return string
	 */
	public function getDtPag() {
		return $this->dtPag;
	}
	
	/**
	 *
	 * @param
	 *        	$dtPag
	 */
	public function setDtPag($dtPag) {
		$this->dtPag = $dtPag;
		return $this;
	}
	
	/**
	 *
	 * @return string
	 */
	public function getCodAut() {
		return $this->codAut;
	}
	
	/**
	 *
	 * @param
	 *        	$codAut
	 */
	public function setCodAut($codAut) {
		$this->codAut = $codAut;
		return $this;
	}
	
	/**
	 *
	 * @return string
	 */
	public function getNumId() {
		return $this->numId;
	}
	
	/**
	 *
	 * @param
	 *        	$numId
	 */
	public function setNumId($numId) {
		$this->numId = $numId;
		return $this;
	}
	
	/**
	 *
	 * @return string
	 */
	public function getCompVend() {
		return $this->compVend;
	}
	
	/**
	 *
	 * @param
	 *        	$compVend
	 */
	public function setCompVend($compVend) {
		$this->compVend = $compVend;
		return $this;
	}
	
	/**
	 *
	 * @return string
	 */
	public function getTipCart() {
		return $this->tipCart;
	}
	
	/**
	 *
	 * @param
	 *        	$tipCart
	 */
	public function setTipCart($tipCart) {
		$this->tipCart = $tipCart;
		return $this;
	}
	
	/**
	 *
	 * @return string
	 */
	public function getFormato() {
		return $this->Formato;
	}
	
	/**
	 *
	 * @param
	 *        	$Formato
	 */
	public function setFormato($Formato) {
		$this->Formato = $Formato;
		return $this;
	}
	
	/**
	 *
	 * @return string
	 */
	public function getChave() {
		return $this->Chave;
	}
	
	/**
	 *
	 * @param
	 *        	$Chave
	 */
	public function setChave($Chave) {
		$this->Chave = $Chave;
		return $this;
	}
	
}