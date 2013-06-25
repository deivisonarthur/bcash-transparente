<?php

class PaymentMethod{

	public $code;

	/**
	 * Meio de Pagamento utilizado para processar a transação<br>
	 * *Vide enum: {@link PaymentMethodEnum}
	 *
	 * @return code
	 *            , ex.: PaymentMethodEnum::VISA
	 */
	public function getCode() {

		return $this->code;
	}


	/**
	 * Meio de Pagamento utilizado para processar a transação<br>
	 * <b>Campo obrigatório</b> <br>
	 * *Vide enum: {@link PaymentMethodEnum}
	 *
	 * @param code
	 *            , ex.: PaymentMethodEnum::VISA
	 */
	public function setCode($code) {

		$this->code = $code;
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