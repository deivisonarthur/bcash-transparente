<?php

class HttpResponse{

	public $code;
	public $response;

	public function getCode(){
		return $this->code;
	}

	public function getResponse(){
		return $this->response;
	}

	public function setCode($code){
		$this->code = $code;
	}

	public function setResponse($response){
		$this->response = $response;

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