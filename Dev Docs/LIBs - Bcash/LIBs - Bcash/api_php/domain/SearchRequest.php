<?php

class SearchRequest{


	public $cpf;


	/**
	 * CPF do comprador<br>
	 * <i>Tamanho máximo: 17 caracteres</i><br>
	 * <b>Campo obrigatório</b>
	 *
	 * @param cpf
	 *            , ex.: 99999999999
	 */
	public function setCpf($cpf) {

		$this->cpf = $cpf;
	}


	/**
	 * CPF do comprador<br>
	 * <i>Tamanho máximo: 17 caracteres</i><br>
	 *
	 * @return cpf
	 *            , ex.: 99999999999
	 */
    public function getCpf() {

        return $this->cpf;
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