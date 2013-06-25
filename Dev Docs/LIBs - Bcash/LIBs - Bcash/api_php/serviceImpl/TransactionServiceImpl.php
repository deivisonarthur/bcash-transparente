<?php

/**
 * Implementação da interface @{TransactionService}
 *
 */
class TransactionServiceImpl implements TransactionService{

	private static $RESPONSE_OK = 200;

	public function createTransaction(TransactionRequest $transactionRequest){
		try{

			$oAuth = $this->genereteAuthenticationOAuth();

			$httpResponse = HttpServiceImpl::post(Config::transactionHost, $transactionRequest, $oAuth);

			if($httpResponse->getCode() != self::$RESPONSE_OK){
				throw new Exception($httpResponse->getResponse(),$httpResponse->getCode());
			}

			$transactionResponse = json_decode($httpResponse->getResponse());
			return $transactionResponse;

		} catch (HttpException $e) {
			throw new HttpException($e->getMessage());
		} catch (Exception $e) {
			throw new TransactionException($e->getMessage(), $e->getCode());
		}
	}


	private function genereteAuthenticationOAuth(){

		$time = time()*1000;
		$microtime = microtime();
		$rand = mt_rand();

		$signature = array(
		      "oauth_consumer_key"=>Config::oAuthConsumerKey, 
		      "oauth_nonce"=>md5( $microtime . $rand ), 
		      "oauth_signature_method"=>Config::oAuthSignatureMethod, 
		      "oauth_timestamp"=>$time, 
		      "oauth_version"=>Config::oAuthVersion, 
		);

		$signature = base64_encode(http_build_query($signature, '', '&'));

		$oAuth = array("Authorization: OAuth realm=".Config::oAuthRealm.
		      ",oauth_consumer_key=".Config::oAuthConsumerKey. 
		      ",oauth_nonce=".md5( $microtime. $rand ). 
		      ",oauth_signature=".$signature. 
		      ",oauth_signature_method=".Config::oAuthSignatureMethod. 
		      ",oauth_timestamp=".$time. 
              ",oauth_version=".Config::oAuthVersion,  
		      "Content-Type:application/x-www-form-urlencoded; charset=".Config::transactionCharset,
		);
		return $oAuth;
	}
}


?>