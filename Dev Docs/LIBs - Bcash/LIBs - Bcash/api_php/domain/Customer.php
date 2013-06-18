<?php

class Customer {

	public $mail;

	public $name;

	public $cpf;

	public $phone;

	public $cellPhone;

	public $address;

	public $gender;

	public $birthDate;

	public $rg;

	public $issueRgDate;

	public $organConsignorRg;

	public $stateConsignorRg;

	public $companyName;

	public $cnpj;

	public $searchToken;



	/**
	 * E-mail do comprador<br>
	 * <i>Tamanho máximo: 80 caracteres</i><br>
	 *
	 * @return mail
	 *            , ex.: cliente@provedor.com
	 */
	public function getMail() {

		return $this->mail;
	}


	/**
	 * E-mail do comprador<br>
	 * <i>Tamanho máximo: 80 caracteres</i><br>
	 * <b>Campo obrigatório</b>
	 *
	 * @param mail
	 *            , ex.: cliente@provedor.com
	 */
	public function setMail($mail) {

		$this->mail = $mail;
	}


	/**
	 * Nome do comprador<br>
	 * <i>Tamanho máximo: 80 caracteres</i><br>
	 *
	 * @return name
	 *            , ex.: Antonio Junior
	 */
	public function getName() {

		return $this->name;
	}


	/**
	 * Nome do comprador<br>
	 * <i>Tamanho máximo: 80 caracteres</i><br>
	 * <b>Campo obrigatório</b>
	 *
	 * @param name
	 *            , ex.: Antonio Junior
	 */
	public function setName($name) {

		$this->name = $name;
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
	 * Telefone do comprador: DDD + número telefônico<br>
	 * <i>Tamanho máximo: 20 caracteres</i><br>
	 *
	 * @return phone
	 *            , ex.: 1126267469
	 */
	public function getPhone() {

		return $this->phone;
	}


	/**
	 * Telefone do comprador: DDD + número telefônico<br>
	 * <i>Tamanho máximo: 20 caracteres</i><br>
	 * <b>Campo obrigatório, caso não seja informado o campo cellPhone</b>
	 *
	 * @param phone
	 *            , ex.: 1126267469
	 */
	public function setPhone($phone) {

		$this->phone = $phone;
	}


	/**
	 * Celular do comprador: DDD + número telefônico<br>
	 * <i>Tamanho máximo: 20 caracteres</i><br>
	 *
	 * @return cellPhone
	 *            , ex.: 1199990000
	 */
	public function getCellPhone() {

		return $this->cellPhone;
	}


	/**
	 * Celular do comprador: DDD + número telefônico<br>
	 * <i>Tamanho máximo: 20 caracteres</i><br>
	 * <b>Campo obrigatório, caso não seja informado o campo phone</b>
	 *
	 * @param cellPhone
	 *            , ex.: 1199990000
	 */
	public function setCellPhone($cellPhone) {

		$this->cellPhone = $cellPhone;
	}


	/**
	 * Sexo do comprador<br>
	 * <i>Tamanho máximo: 1 caracteres</i><br>
	 * <br>
	 * *Vide enum: {@link GenderEnum}
	 *
	 * @return gender
	 *            , ex.: GenderEnum::MALE
	 */
	public function getGender() {

		return $this->gender;
	}


	/**
	 * Sexo do comprador<br>
	 * <i>Tamanho máximo: 1 caracteres</i><br>
	 * <b>Campo obrigatório</b><br>
	 * <br>
	 * *Vide enum: {@link GenderEnum}
	 *
	 * @param gender
	 *            , ex.: GenderEnum::MALE
	 */
	public function setGender($gender) {

		$this->gender = $gender;
	}


	/**
	 * Data de Nascimento do comprador<br>
	 *
	 *
	 * @return birthDate
	 *            , ex.: date("d/m/Y");
	 */
	public function getBirthDate() {

		return $this->birthDate;
	}


	/**
	 * Data de Nascimento do comprador<br>
	 *
	 *
	 * @param birthDate
	 *            , ex.: date("d/m/Y");
	 */
	public function setBirthDate($birthDate) {

		$this->birthDate = $birthDate;
	}


	/**
	 * RG do comprador<br>
	 * <i>Tamanho máximo: 17 caracteres</i><br>
	 *
	 * @return rg
	 *            , ex.: 999999999
	 */
	public function getRg() {

		return $this->rg;
	}


	/**
	 * RG do comprador<br>
	 * <i>Tamanho máximo: 17 caracteres</i><br>
	 *
	 * @param rg
	 *            , ex.: 999999999
	 */
	public function setRg($rg) {

		$this->rg = $rg;
	}


	/**
	 * Data da emissão do RG do comprador<br>
	 *
	 * @return issueRgDate
	 *            , ex.: date("d/m/Y");
	 */
	public function getIssueRgDate() {

		return $this->issueRgDate;
	}


	/**
	 * Data da emissão do RG do comprador<br>
	 *
	 * @param issueRgDate
	 *            , ex.: date("d/m/Y");
	 */
	public function setIssueRgDate($issueRgDate) {

		$this->issueRgDate = $issueRgDate;
	}


	/**
	 * Orgão Emissor do RG do comprador<br>
	 * <i>Tamanho máximo: 15 caracteres</i><br>
	 *
	 * @return organConsignorRg
	 *            , ex.: SSP
	 */
	public function getOrganConsignorRg() {

		return $this->organConsignorRg;
	}


	/**
	 * Orgão Emissor do RG do comprador<br>
	 * <i>Tamanho máximo: 15 caracteres</i><br>
	 *
	 * @param organConsignorRg
	 *            , ex.: SSP
	 */
	public function setOrganConsignorRg($organConsignorRg) {

		$this->organConsignorRg = $organConsignorRg;
	}


	/**
	 * Estado emissor do RG do comprador<br>
	 * <i>Tamanho máximo: 2 caracteres</i><br>
	 * <br>
	 * *Vide enum: {@link StateEnum}
	 *
	 * @return stateConsignorRg
	 *            , ex.: StateEnum::MINAS_GERAIS
	 */
	public function getStateConsignorRg() {

		return $this->stateConsignorRg;
	}


	/**
	 * Estado emissor do RG do comprador<br>
	 * <i>Tamanho máximo: 2 caracteres</i><br>
	 * <br>
	 * *Vide enum: {@link StateEnum}
	 *
	 * @param stateConsignorRg
	 *            , ex.: StateEnum::MINAS_GERAIS
	 */
	public function setStateConsignorRg($stateConsignorRg) {

		$this->stateConsignorRg = $stateConsignorRg;
	}


	/**
	 * Razão social do comprador. Enviado somente quando a conta do cliente for
	 * conta Jurídica<br>
	 * <i>Tamanho máximo: 255 caracteres</i>
	 *
	 * @return companyName
	 *            , ex.: Razão Social da minha empresa
	 */
	public function getCompanyName() {

		return $this->companyName;
	}


	/**
	 * Razão social do comprador. Enviado somente quando a conta do cliente for
	 * conta Jurídica<br>
	 * <i>Tamanho máximo: 255 caracteres</i>
	 *
	 * @param companyName
	 *            , ex.: Razão Social da minha empresa
	 */
	public function setCompanyName($companyName) {

		$this->companyName = $companyName;
	}


	/**
	 * CNPJ do comprador. Enviado somente quando a conta do cliente for conta
	 * Jurídica<br>
	 * <i>Tamanho máximo: 30 caracteres</i>
	 *
	 * @return cnpj
	 *            , ex.: 99999999999999
	 */
	public function getCnpj() {

		return $this->cnpj;
	}


	/**
	 * CNPJ do comprador. Enviado somente quando a conta do cliente for conta
	 * Jurídica<br>
	 * <i>Tamanho máximo: 30 caracteres</i>
	 *
	 * @param cnpj
	 *            , ex.: 99999999999999
	 */
	public function setCnpj($cnpj) {

		$this->cnpj = $cnpj;
	}


	/**
	 * Objeto {@link Address}<br>
	 * <b>Campo obrigatório</b>
	 *
	 * @return address
	 */
	public function getAddress() {

		return $this->address;
	}


	/**
	 * Objeto {@link Address}<br>
	 * <b>Campo obrigatório</b>
	 *
	 * @param address
	 */
	public function setAddress(Address $address) {

		$this->address = $address;
	}


	/**
	 * Token gerado apartir do serviço de consulta de conta<br>
	 * <br>
	 * *Vide {@link AccountService}
	 *
	 * @return searchToken
	 */
	public function getSearchToken() {

		return $this->searchToken;
	}


	/**
	 * Token gerado apartir do serviço de consulta de conta<br>
	 * <br>
	 * *Vide {@link AccountService}
	 *
	 * @param searchToken
	 */
	public function setSearchToken($searchToken) {

		$this->searchToken = $searchToken;
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