<?php

/**
 * Implementação da interface @{AccountService}
 *
 */
class AccountServiceImpl implements AccountService{

	private static $RESPONSE_OK = 200;

	public function searchAccounts($cpf){

		try{

			$auth = $this->genereteAuthenticationBasic();

			$searchRequest = new SearchRequest();
			$searchRequest->setCpf($cpf);

			$httpResponse = HttpServiceImpl::post(Config::accountHost, $searchRequest, $auth);

			if($httpResponse->getCode() != self::$RESPONSE_OK){
				throw new Exception($httpResponse->getResponse(),$httpResponse->getCode());
			}
				
			$searchResponse = json_decode($httpResponse->getResponse());
			return $searchResponse;

		} catch (HttpException $e) {
			throw new HttpException($e->getMessage());
		} catch (Exception $e) {
			throw new AccountException($e->getMessage(), $e->getCode());
		}

	}

	private function genereteAuthenticationBasic(){
		return array(
		              'Authorization: Basic '.base64_encode(Config::credentialsEmail.':'.Config::credentialsToken), 
		              "Content-Type: application/x-www-form-urlencoded; charset=".Config::accountCharset);
	}

}


?>