<?php
/* Dados de autenticação para consumo do serviço */
$email 	 = "lojamodelo@pagamentodigital.com.br"; 
$token 	 = "2948208E715B986F25A5E"; 


/* Dados dos produtos para consumo do serviço */
/* Observação: Máximo de três produtos simultâneos por consulta! */
$consultar[0]->PRODUCT_DESCRIPTION		 = "iPhone 4S";
$consultar[0]->PRODUCT_VALUE	      	 = "1550.00";


$x = 0;
foreach( $consultar as $products ) {
	$garantia['products'][ $x ]['description'] 	= $products->PRODUCT_DESCRIPTION;
	$garantia['products'][ $x ]['value'] 		= $products->PRODUCT_VALUE;
	$x++;
}

$respostaConsulta = consultarGarantia( $garantia, $email, $token );
$temp = json_decode($respostaConsulta);


/* Para disponibilizar valor da garantia e descrição do produto que a contém ao usuário abaixo estão as informações */
foreach( $temp->products as $product ){
	if ( $product->extendedWarranty == 'true' ){
		echo "Produto contém Garantia Estendida! <BR>";
		echo urldecode($product->description)."<BR>";
		echo urldecode($product->valueExtendedWarranty)."<BR>";
		echo urldecode($product->token)."<BR><BR>";
	}
}

/* Após consumidor optar pela garantia estendida de um produto incluir no JSON para o webservice de criação de transação o token retornado */
/* Desta forma o Bcash entenderá que devemos aplicar a garantia e o Bcash irá incluir o valor automaticamente */

function consultarGarantia( $garantia, $email, $token ){

	$data = json_encode( $garantia );
	
	/* Dados de utilização para consumo do serviço */
	$urlPost = "https://api.bcash.com.br/service/searchExtendedWarranty/json/"; 
	$version = "1.0";   /* Padrão version = 1.0 */
	$encode  = "UTF-8"; /* Padrão encode = UTF-8    também disponível em ISO-8859-1 */
			
	$params  = array("data"=>$data,"version"=>$version,"encode"=>$encode); 

	ob_start(); 
	$ch = curl_init(); 
	curl_setopt($ch, CURLOPT_URL, $urlPost); 
	curl_setopt($ch, CURLOPT_POST, 1); 
	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params, '', '&')); 
	curl_setopt($ch, CURLOPT_HTTPHEADER, array("Authorization: Basic ".base64_encode($email.":".$token)));
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE );
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE );
	curl_exec($ch);

	/* XML ou Json de retorno */ 
	$resposta = ob_get_contents(); 
	ob_end_clean(); 

	/* Capturando o http code para tratamento dos erros na requisição*/ 
	$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE); 
	curl_close($ch); 

	if($httpCode != "200"){ 
	//Tratamento das mensagens de erro
		echo "Erro! $httpCode <BR><BR>";
	}else{ 
	//Tratamento dos dados de resposta da consulta.
		//echo "Sucesso! $httpCode <BR><BR>";
		return $resposta;
	}
}
?>