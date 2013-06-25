<?php

/**
 * Classe de configuração responsável por armazenar as informações de conexão do cliente com a API </br>
 * Responsável também por armazenar as configurações de utilização da API desejadas, como por exemplo a versão. 
 *
 */
class Config{
	
	#Account config
	const credentialsEmail = "email@email.com";
	const credentialsToken  = "your_token_here";
	
	#Api config
	const transactionHost = "https://api.bcash.com.br/service/createTransaction/json/";
	const transactionCharset =  "UTF-8"; // UTF-8 or ISO-8859-1

	const accountHost = "https://api.bcash.com.br/service/searchAccount/json/";
	const accountCharset =  "UTF-8"; // UTF-8 or ISO-8859-1
	
	const version = "1.0";
	const timeout = 20;
	
	#Oauth config
	const oAuthConsumerKey = "your_consumer_key";
	const oAuthRealm = "https://api.bcash.com.br/checkout/xml/";
	const oAuthSignatureMethod = "PLAINTEXT";
	const oAuthVersion = "1.0";
	
}

?>

