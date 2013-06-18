<?php

class CreditCard{

	public $holder;

	public $number;

	public $securityCode;

	public $maturityMonth;

	public $maturityYear;

	/**
	 * Nome do titular do cartão de crédito<br>
	 * <i>Tamanho máximo: 100 caracteres</i><br>
	 *
	 * @return holder
	 *            , ex.: João D. F. Silva
	 */
	public function getHolder() {

		return $this->holder;
	}


	/**
	 * Nome do titular do cartão de crédito<br>
	 * <i>Tamanho máximo: 100 caracteres</i><br>
	 * <b>Campo obrigatório</b>
	 *
	 * @param holder
	 *            , ex.: João D. F. Silva
	 */
	public function setHolder($holder) {

		$this->holder = $holder;
	}


	/**
	 * Número do cartão de crédito do cliente<br>
	 * <i>Tamanho máximo: 30 caracteres</i><br>
	 *
	 * @return number
	 *            , ex.: 4111111111111110
	 */
	public function getNumber() {

		return $this->number;
	}


	/**
	 * Número do cartão de crédito do cliente<br>
	 * <i>Tamanho máximo: 30 caracteres</i><br>
	 * <b>Campo obrigatório</b>
	 *
	 * @param number
	 *            , ex.: 4111111111111110
	 */
	public function setNumber($number) {

		$this->number = $number;
	}


	/**
	 * Código de segurança do cartão de crédito, geralmente encontra-se no verso
	 * do cartão<br>
	 *
	 * @return securityCode
	 */
	public function getSecurityCode() {

		return $this->securityCode;
	}


	/**
	 * Código de segurança do cartão de crédito, geralmente encontra-se no verso
	 * do cartão<br>
	 * <b>Campo obrigatório</b>
	 *
	 * @param securityCode
	 */
	public function setSecurityCode($securityCode) {

		$this->securityCode = $securityCode;
	}


	/**
	 * Mês de vencimento do cartão de crédito<br>
	 *
	 * @return maturityMonth
	 */
	public function getMaturityMonth() {

		return $this->maturityMonth;
	}


	/**
	 * Mês de vencimento do cartão de crédito<br>
	 * <b>Campo obrigatório</b>
	 *
	 * @param maturityMonth
	 */
	public function setMaturityMonth($maturityMonth) {

		$this->maturityMonth = $maturityMonth;
	}


	/**
	 * Ano de vencimento do cartão de crédito <b>Campo obrigatório</b>
	 *
	 * @return maturityYear
	 */
	public function getMaturityYear() {

		return $this->maturityYear;
	}


	/**
	 * Ano de vencimento do cartão de crédito <b>Campo obrigatório</b>
	 *
	 * @param maturityYear
	 */
	public function setMaturityYear($maturityYear) {

		$this->maturityYear = $maturityYear;
	}

	/**
	 * Retorna um json dos atributos da classe
	 *
	 * @return Json da classe
	 *
	 */
	public function getJSONEncode() {
		return json_encode(get_object_vars($this));
	}

}


?>