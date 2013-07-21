<?php
/**
 * Tiago Sampaio
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License (AFL 3.0)
 * that is bundled with this package in the file LICENSE_AFL.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/afl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@tiagosampaio.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.tiagosampaio.com for more information.
 *
 * @category    DSpalenzaDArthur
 * @package     DSpalenzaDArthur_Bcash
 * @author      Tiago Sampaio (tiago@tiagosampaio.com)
 * @copyright   Copyright (c) 2012 Tiago Sampaio. (http://tiagosampaio.com)
 * @license     http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 */
class DSpalenzaDArthur_Bcash_Model_Connection extends DSpalenzaDArthur_Bcash_Model_Abstract
{

	const ERROR_MESSAGE_PREFIX 	= 'Some error has occurred when trying to place your order.';
	const ERROR_MESSAGE_SUFIX	= 'Please correct any information if needed and try again or contact us for help.';


	/**
	 * Available Transaction Responses
	 */

	/**
	 * BCash: Informação processada com sucesso
	 */
	const RESULT_HTTP_CODE_SUCCESS = '200';

	/**
	 * BCash: Requisição com parâmetros obrigatórios vazios ou inválidos
	 */
	const RESULT_HTTP_CODE_INVALID = '400';

	/**
	 * BCash: Falha na autenticação ou sem acesso para usar o serviço
	 */
	const RESULT_HTTP_CODE_AUTHFAIL = '401';

	/**
	 * BCash: Método não permitido, o serviço suporta apenas POST
	 */
	const RESULT_HTTP_CODE_UNSUPPORTED_METHOD = '405';

	/**
	 * BCash: Content-Type não suportado
	 */
	const RESULT_HTTP_CODE_UNSUPPORTED_CONTENT_TYPE = '415';

	/**
	 * BCash: Erro fatal na aplicação, executar a solicitação mais tarde
	 */
	const RESULT_HTTP_CODE_ERROR = '500';

	/**
	 * BCash: Serviço está indisponível
	 */
	const RESULT_HTTP_CODE_UNAVAILABLE = '503';
	

	/**
	 * Available Transaction Statuses
	 */

	/**
	 * BCash: “Em andamento” = Aguardando a confirmação de pagamento
	 */
	const TRANSACTION_STATUS_PENDING 	= '1';	

	/**
	 * BCash: “Em andamento” = Aguardando aprovação de risco
	 */
	const TRANSACTION_STATUS_PROCESSING = '2';

	/**
	 * BCash: “Aprovada” = Transação aprovada
	 */
	const TRANSACTION_STATUS_APPROVED 	= '3';

	/**
	 * BCash: “Concluído” = Transação concluída
	 */
	const TRANSACTION_STATUS_FINISHED 	= '4';

	/**
	 * BCash: “Cancelada” = Transação cancelada
	 * @comment: In integration manual it's 5
	 */
	const TRANSACTION_STATUS_CANCELED 	= '7';



	/**
	 * Creates the transaction
	 * 
	 * @param array $data
	 * - It must be in json encoded format already
	 * 
	 * @return string | array
	 */
	public function createTransaction($data = array())
	{
		$result = $this->_makeRequest($data);

		if($result->getHttpCode() != self::RESULT_HTTP_CODE_SUCCESS) {
			Mage::throwException($this->_getBeautifiedErrorMessage($result->getContent()));
		} else {
			/**
			 * If the result of HTTP Code is 200 then the transaction was sucessfully created and the result has informations like
			 * transaction id, order number and transaction status.
			 */
			$data = json_decode(urldecode($result->getContent()));
			
			return($data);
		}
	}


	/**
	 * Makes the real request for creating the transaction
	 * 
	 * @author Tiago Sampaio
	 * 
	 * @param array $data
	 * 
	 * @return Varien_Object
	 */
	protected function _makeRequest($data = array())
	{
		$oAuth = $this->_grantAccess();

		$params  = array(
			'data'		=> $data,
			'version'	=> '1.0',
			'encode'	=> 'UTF-8'
		);
			
		ob_start();

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);	
		curl_setopt($ch, CURLOPT_URL, $this->_getTransactionUrl());
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params, '', '&'));
		curl_setopt($ch, CURLOPT_HTTPHEADER, $oAuth);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE ); /* If your domain is SSL, remove this line */
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE ); /* If your domain is SSL, remove this line */
		curl_exec($ch);

		/**
		 * XML ou Json returned by BCash!
		 */
		$body = ob_get_contents();
		ob_end_clean();

		/**
		 * Get httpCode for error or success verification
		 */
		$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

		$data = array(
			'http_code' => $httpCode,
			'content' 	=> $body
		);

		$result = new Varien_Object($data);

		return $result;
	}


	/**
	 * Beautify the error message for display to customer
	 * 
	 * @param string $body
	 * 
	 * @return string
	 */
	protected function _getBeautifiedErrorMessage($body = null)
	{
		$prefix = $this->_getConfig('error_message_prefix');
		if(!$prefix) {
			$prefix = $this->_helper()->__(self::ERROR_MESSAGE_PREFIX);
		}

		$content = json_decode( urldecode($body) );

		$message = $this->_helper()->__('The errors are described right below:')."\n\n";

		foreach($content->list as $list) {
			$message .= $this->_helper()->__('%s: %s', $list->code, $list->description) . "\n";
		}

		$sufix = $this->_getConfig('error_message_sufix');
		if(!$sufix) {
			$sufix = $this->_helper()->__(self::ERROR_MESSAGE_SUFIX);
		}

		return sprintf("%s\n%s\n%s", $prefix, $message, $sufix);
	}


	/**
	 * Get credentials object
	 * 
	 * @return DSpalenzaDArthur_Bcash_Model_Credentials
	 */
	protected function _getCredentials()
	{
		return Mage::getSingleton('bcash/credentials');
	}


	/**
	 * Grant access for the transaction creation
	 * 
	 * @return mixed
	 */
	protected function _grantAccess()
	{
		$time = time()*1000;
		
		$signature = array(
			'oauth_consumer_key' 		=> $this->_getCredentials()->getConsumerKey(),
			'oauth_nonce' 				=> $this->_getUniqueKey(),
			'oauth_signature_method'	=> 'PLAINTEXT',
			'oauth_timestamp' 			=> $time,
			'oauth_version' 			=> '1.0'
		);

		$signature = base64_encode(http_build_query($signature, '', '&'));

		$oAuth = array( 
			'Authorization: OAuth realm=' . $this->_getTransactionUrl() .
			',oauth_consumer_key=' . $this->_getCredentials()->getConsumerKey() .
			',oauth_nonce=' . $this->_getUniqueKey() .
			',oauth_signature=' . $signature .
			',oauth_signature_method=PLAINTEXT' .
			',oauth_timestamp=' . $time .
			',oauth_version=1.0' ,
			'Content-Type:application/x-www-form-urlencoded; charset=utf-8'
		);

		return $oAuth;
	}


	/**
	 * Get a unique key for each transaction.
	 * The same key will never be used twice.
	 * 
	 * @return string
	 */
	protected function _getUniqueKey()
	{
		$key = 'bcash_current_unique_key';

		if(!Mage::registry($key)) {
			Mage::register($key, md5(microtime().mt_rand()));
		}

		return Mage::registry($key);
	}


	/**
	 * Get the transaction URL
	 * 
	 * @return string
	 */
	protected function _getTransactionUrl()
	{
		$urlPrefix = $this->_getConfig('transaction_url');
		if(!$urlPrefix) {
			$urlPrefix = 'https://api.bcash.com.br/service/createTransaction/';
		}

		$urlType = $this->_getConfig('transaction_url_type');
		if(!$urlType) {
			$urlType = 'json';
		}

		return sprintf('%s%s/', $urlPrefix, $urlType);
	}

}