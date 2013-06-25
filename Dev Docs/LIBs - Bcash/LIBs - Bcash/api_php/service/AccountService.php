<?php

/**
 * Cliente para busca de contas
 *
 */
interface AccountService{

 	/**
     * Busca todas a contas vinculadas com o CPF informado.
     * 
     * @param cpf
     *           CPF utilizado para a busca.
     * @return Objeto que contém informações da busca e uma lista de contas
     * @throws AccountException
     *             exceção em caso de de erro na busca da conta.
     */
	public function searchAccounts($cpf);

}


?>