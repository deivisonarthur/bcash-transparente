<?php

/**
 * Cliente para serviços de criação de transação
 *
 */
interface TransactionService{

	/**
     * Cria uma transação a partir dos dados informados.
     * 
     * @param request
     *            Objeto que contém informações para a criação da transação
     */
	public function createTransaction(TransactionRequest $transactionRequest);

}


?>