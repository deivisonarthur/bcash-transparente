<?php

class Address {

	public $address;

	public $number;

	public $complement;

	public $neighborhood;

	public $city;

	public $state;

	public $zipCode;

	
	
	/**
	 * Endereço do comprador<br>
	 * <i>Tamanho máximo: 100 caracteres</i><br>
	 *
	 * @return address
	 *            , ex.: Av. Tiradentes
	 */
	public function getAddress() {

		return $this->address;
	}
	
	/**
	 * Endereço do comprador<br>
	 * <i>Tamanho máximo: 100 caracteres</i><br>
	 * <b>Campo obrigatório</b>
	 *
	 * @param address
	 *            , ex.: Av. Tiradentes
	 */
	public function setAddress($address) {

		$this->address = $address;
	}


	/**
	 * Número do endereço<br>
	 * <i>Tamanho máximo: 10 caracteres</i><br>
	 *
	 * @return number
	 *            , ex.: 1254
	 */
	public function getNumber() {

		return $this->number;
	}


	/**
	 * Número do endereço<br>
	 * <i>Tamanho máximo: 10 caracteres</i><br>
	 * <b>Campo obrigatório</b>
	 *
	 * @param number
	 *            , ex.: 1254
	 */
	public function setNumber($number) {

		$this->number = $number;
	}


	/**
	 * Complemento do endereço do comprador<br>
	 * <i>Tamanho máximo: 80 caracteres</i><br>
	 *
	 * @return complement
	 *            , ex.: Apartamento 10
	 */
	public function getComplement() {

		return $this->complement;
	}


	/**
	 * Complemento do endereço do comprador<br>
	 * <i>Tamanho máximo: 80 caracteres</i><br>
	 *
	 * @param complement
	 *            , ex.: Apartamento 10
	 */
	public function setComplement($complement) {

		$this->complement = $complement;
	}


	/**
	 * Bairro do comprador<br>
	 * <i>Tamanho máximo: 50 caracteres</i><br>
	 *
	 * @return neighborhood
	 *            , ex.: Centro
	 */
	public function getNeighborhood() {

		return $this->neighborhood;
	}


	/**
	 * Bairro do comprador<br>
	 * <i>Tamanho máximo: 50 caracteres</i><br>
	 * <b>Campo obrigatório</b>
	 *
	 * @param neighborhood
	 *            , ex.: Centro
	 */
	public function setNeighborhood($neighborhood) {

		$this->neighborhood = $neighborhood;
	}


	/**
	 * Cidade do comprador<br>
	 * <i>Tamanho máximo: 255 caracteres</i><br>
	 *
	 * @return city
	 *            , ex.: São Paulo
	 */
	public function getCity() {

		return $this->city;
	}


	/**
	 * Cidade do comprador<br>
	 * <i>Tamanho máximo: 255 caracteres</i><br>
	 * <b>Campo obrigatório</b>
	 *
	 * @param city
	 *            , ex.: São Paulo
	 */
	public function setCity($city) {

		$this->city = $city;
	}


	/**
	 * Estado do comprador<br>
	 * <i>Tamanho máximo: 2 caracteres</i><br>
	 * <br>
	 * *Vide enum: {@link StateEnum}
	 *
	 * @return state
	 */
	public function getState() {

		return $this->state;
	}


	/**
	 * Estado do comprador<br>
	 * <i>Tamanho máximo: 2 caracteres</i><br>
	 * <b>Campo obrigatório</b><br>
	 * <br>
	 * *Vide enum: {@link StateEnum}
	 *
	 * @param state
	 */
	public function setState($state ) {

		$this->state = $state;
	}

	
	/**
	 * CEP do comprador<br>
	 * <i>Tamanho máximo: 9 caracteres</i><br>
	 *
	 * @return zipCode
	 *            , ex.: 17500000
	 */
	public function getZipCode() {

		return $this->zipCode;
	}


	/**
	 * CEP do comprador<br>
	 * <i>Tamanho máximo: 9 caracteres</i><br>
	 * <b>Campo obrigatório</b>
	 *
	 * @param zipCode
	 *            , ex.: 17500000
	 */
	public function setZipCode($zipCode) {

		$this->zipCode = $zipCode;
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
