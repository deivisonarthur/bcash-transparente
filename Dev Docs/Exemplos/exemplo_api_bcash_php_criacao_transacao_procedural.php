<?php
	$time = time()*1000;
	$microtime = microtime();
	$rand = mt_rand();
	
	$signature = array( "oauth_consumer_key"=>"1f5c18f0e65699f2568ca2751654fa7fc5ce94b0", "oauth_nonce"=>md5( $microtime . $rand ), "oauth_signature_method"=>"PLAINTEXT", "oauth_timestamp"=>$time, "oauth_version"=>"1.0", );
	$signature = base64_encode(http_build_query($signature, '', '&'));

	$oAuth = array("Authorization: OAuth realm=https://api.bcash.com.br/service/createTransaction/xml/". 
	",oauth_consumer_key="."1f5c18f0e65699f2568ca2751654fa7fc5ce94b0". 
	",oauth_nonce=".md5( $microtime. $rand ). 
	",oauth_signature=".$signature. 
	",oauth_signature_method=PLAINTEXT". 
	",oauth_timestamp=".$time. 
	",oauth_version=1.0", 
	"Content-Type:application/x-www-form-urlencoded;".
	"charset="."ISO-8859-1", );
	
	$data = "{'products':[{'code':'1','description':'Teste','amount':'1','value':'0.01','extraDescription':''}],'buyer':{'address':{'address':'a','number':'1','complement':'sdasd','neighborhood':'aasda','city':'Cachoeirinha','state':'RS','zipCode':'94970-825'},'mail':'email@consumidor.com','name':'Loja 2','phone':'5133258626','cellPhone':'','gender':'M','birthDate':'','cpf':'57279548512','rg':''},'paymentMethod':{'code':'1'},'creditCard':{'number':'4111111111111111','holder':'Teste Bcash','maturityMonth':'03','maturityYear':'2017','securityCode':'123'},'installments':'1','sellerMail':'lojamodelo@pagamentodigital.com.br','orderId':'1','platformId':'423','acceptedContract':'S','viewedContract':'S'}";
	
	echo $data."<BR><BR>";
	$urlPost = "https://api.bcash.com.br/service/createTransaction/xml/";
	$params = array("data"=>$data,"version"=>"1.0","encode"=>"ISO-8859-1");

	ob_start();
	$ch = curl_init(); 
	curl_setopt($ch, CURLOPT_URL, $urlPost);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params, '', '&')); 
	curl_setopt($ch, CURLOPT_HTTPHEADER, $oAuth); 
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); 
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
	curl_exec($ch); 
	/* XML ou Json de retorno */ 
	$resposta = ob_get_contents(); 
	ob_end_clean();
	$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE); 
	curl_close($ch); 

	/* TRATAMENTO DE RETORNO LOJA VIRTUAL EM CASO DE SUCESSO OU FALHA NA CRIAÇÃO DE TRANSAÇÃO */
	if($httpCode == "200"){ 
		echo "Sucesso! <BR>$resposta";
	}else{ 
		echo "Falha! httpCode = $httpCode<BR>$resposta";
	}
?>