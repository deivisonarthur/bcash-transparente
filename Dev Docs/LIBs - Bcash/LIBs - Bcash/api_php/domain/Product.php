<?php

class Product{

	public $code;

	public $description;

	public $amount;

	public $value;

	public $extraDescription;

	/**
	 * Código que identifica o produto em sua loja<br>
	 * <i>Tamanho máximo: 50 caracteres</i><br>
	 *
	 * @return code
	 *            , ex.: 446
	 */
	public function getCode() {

		return $this->code;
	}


	/**
	 * Código que identifica o produto em sua loja<br>
	 * <i>Tamanho máximo: 50 caracteres</i><br>
	 * <b>Campo obrigatório</b>
	 *
	 * @param code
	 *            , ex.: 446
	 */
	public function setCode($code) {

		$this->code = $code;
	}


	/**
	 * Descrição ou nome do(s) produto comprado. Será visualizada pelo cliente<br>
	 * <i>Tamanho máximo: 255 caracteres</i><br>
	 *
	 * @return description
	 *            , ex.: Camiseta da seleção brasileira
	 */
	public function getDescription() {

		return $this->description;
	}


	/**
	 * Descrição ou nome do(s) produto comprado. Será visualizada pelo cliente<br>
	 * <i>Tamanho máximo: 255 caracteres</i><br>
	 * <b>Campo obrigatório</b>
	 *
	 * @param description
	 *            , ex.: Camiseta da seleção brasileira
	 */
	public function setDescription($description) {

		$this->description = $description;
	}


	/**
	 * Quantidade comprada deste produto<br>
	 *
	 * @return amount
	 *            , ex.: 2
	 */
	public function getAmount() {

		return $this->amount;
	}


	/**
	 * Quantidade comprada deste produto<br>
	 * <b>Campo obrigatório</b>
	 *
	 * @param amount
	 *            , ex.: 2
	 */
	public function setAmount($amount) {

		$this->amount = $amount;
	}


	/**
	 * Valor unitário do produto<br>
	 *
	 * @return value
	 *            , ex.: 10.95
	 */
	public function getValue() {

		return $this->value;
	}


	/**
	 * Valor unitário do produto<br>
	 * <b>Campo obrigatório</b>
	 *
	 * @param value
	 *            , ex.: 10.95
	 */
	public function setValue($value) {

		$this->value = $value;
	}


	/**
	 * Descrição adicional do produto<br>
	 * <i>Tamanho máximo: 255 caracteres</i>
	 *
	 * @return extraDescription
	 */
	public function getExtraDescription() {

		return $this->extraDescription;
	}


	/**
	 * Descrição adicional do produto<br>
	 * <i>Tamanho máximo: 255 caracteres</i>
	 *
	 * @param extraDescription
	 */
	public function setExtraDescription($extraDescription) {

		$this->extraDescription = $extraDescription;
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