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
class Quack_Itau_Model_Shopline extends Varien_Object {
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
	protected $Chave;
	/**
	 * @var string
	 */
	protected $NomeSacado;
	/**
	 * @var string
	 */
	protected $CodigoInscricao;
	/**
	 * @var string
	 */
	protected $NumeroInscricao;
	/**
	 * @var string
	 */
	protected $EnderecoSacado;
	/**
	 * @var string
	 */
	protected $BairroSacado;
	/**
	 * @var string
	 */
	protected $CepSacado;
	/**
	 * @var string
	 */
	protected $CidadeSacado;
	/**
	 * @var string
	 */
	protected $EstadoSacado;
	/**
	 * @var string
	 */
	protected $DataVencimento;
	/**
	 * @var string
	 */
	protected $UrlRetorna;
	/**
	 * @var string
	 */
	protected $ObsAdicional1;
	/**
	 * @var string
	 */
	protected $ObsAdicional2;
	/**
	 * @var string
	 */
	protected $ObsAdicional3;
	/**
	 * @var string
	 */
	protected $Observacao;
	
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
	
	/**
	 *
	 * @return string
	 */
	public function getNomeSacado() {
		return $this->NomeSacado;
	}
	
	/**
	 *
	 * @param
	 *        	$NomeSacado
	 */
	public function setNomeSacado($NomeSacado) {
		$this->NomeSacado = Mage::helper('core')->removeAccents($NomeSacado);
		return $this;
	}
	
	/**
	 *
	 * @return string
	 */
	public function getCodigoInscricao() {
		return $this->CodigoInscricao;
	}
	
	/**
	 *
	 * @param
	 *        	$CodigoInscricao
	 */
	public function setCodigoInscricao($CodigoInscricao) {
		$this->CodigoInscricao = $CodigoInscricao;
		return $this;
	}
	
	/**
	 *
	 * @return string
	 */
	public function getNumeroInscricao() {
		return $this->NumeroInscricao;
	}
	
	/**
	 *
	 * @param
	 *        	$NumeroInscricao
	 */
	public function setNumeroInscricao($NumeroInscricao) {
		$this->NumeroInscricao = $NumeroInscricao;
		return $this;
	}
	
	/**
	 *
	 * @return string
	 */
	public function getEnderecoSacado() {
		return $this->EnderecoSacado;
	}
	
	/**
	 *
	 * @param
	 *        	$EnderecoSacado
	 */
	public function setEnderecoSacado($EnderecoSacado) {
		$this->EnderecoSacado = Mage::helper('core')->removeAccents($EnderecoSacado);
		return $this;
	}
	
	/**
	 *
	 * @return string
	 */
	public function getBairroSacado() {
		return $this->BairroSacado;
	}
	
	/**
	 *
	 * @param
	 *        	$BairroSacado
	 */
	public function setBairroSacado($BairroSacado) {
		$this->BairroSacado = Mage::helper('core')->removeAccents($BairroSacado);
		return $this;
	}
	
	/**
	 *
	 * @return string
	 */
	public function getCepSacado() {
		return $this->CepSacado;
	}
	
	/**
	 *
	 * @param
	 *        	$CepSacado
	 */
	public function setCepSacado($CepSacado) {
		$this->CepSacado = $CepSacado;
		return $this;
	}
	
	/**
	 *
	 * @return string
	 */
	public function getCidadeSacado() {
		return $this->CidadeSacado;
	}
	
	/**
	 *
	 * @param
	 *        	$CidadeSacado
	 */
	public function setCidadeSacado($CidadeSacado) {
		$this->CidadeSacado = Mage::helper('core')->removeAccents($CidadeSacado);
		return $this;
	}
	
	/**
	 *
	 * @return string
	 */
	public function getEstadoSacado() {
		return $this->EstadoSacado;
	}
	
	/**
	 *
	 * @param
	 *        	$EstadoSacado
	 */
	public function setEstadoSacado($EstadoSacado) {
		$this->EstadoSacado = Mage::helper('core')->removeAccents($EstadoSacado);
		return $this;
	}
	
	/**
	 *
	 * @return string
	 */
	public function getDataVencimento() {
		return $this->DataVencimento;
	}
	
	/**
	 *
	 * @param
	 *        	$DataVencimento
	 */
	public function setDataVencimento($DataVencimento) {
		$this->DataVencimento = $DataVencimento;
		return $this;
	}
	
	/**
	 *
	 * @return string
	 */
	public function getUrlRetorna() {
		return $this->UrlRetorna;
	}
	
	/**
	 *
	 * @param
	 *        	$UrlRetorna
	 */
	public function setUrlRetorna($UrlRetorna) {
		$this->UrlRetorna = $UrlRetorna;
		return $this;
	}
	
	/**
	 *
	 * @return string
	 */
	public function getObsAdicional1() {
		return $this->ObsAdicional1;
	}
	
	/**
	 *
	 * @param
	 *        	$ObsAdicional1
	 */
	public function setObsAdicional1($ObsAdicional1) {
		$this->ObsAdicional1 = Mage::helper('core')->removeAccents($ObsAdicional1);
		return $this;
	}
	
	/**
	 *
	 * @return string
	 */
	public function getObsAdicional2() {
		return $this->ObsAdicional2;
	}
	
	/**
	 *
	 * @param
	 *        	$ObsAdicional2
	 */
	public function setObsAdicional2($ObsAdicional2) {
		$this->ObsAdicional2 = Mage::helper('core')->removeAccents($ObsAdicional2);
		return $this;
	}
	
	/**
	 *
	 * @return string
	 */
	public function getObsAdicional3() {
		return $this->ObsAdicional3;
	}
	
	/**
	 *
	 * @param
	 *        	$ObsAdicional3
	 */
	public function setObsAdicional3($ObsAdicional3) {
		$this->ObsAdicional3 = Mage::helper('core')->removeAccents($ObsAdicional3);
		return $this;
	}
	
	/**
	 *
	 * @return string
	 */
	public function getObservacao() {
		return $this->Observacao;
	}
	
	/**
	 *
	 * @param
	 *        	$Observacao
	 */
	public function setObservacao($Observacao) {
		$this->Observacao = Mage::helper('core')->removeAccents($Observacao);
		return $this;
	}
	
}