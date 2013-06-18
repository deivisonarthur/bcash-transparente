<?php
//	Email registered in Pagamento Digital 
   $email = "lojamodelo@pagamentodigital.com.br"; 

//	Get your TOKEN by accessing the Tools menu in Pagamento Digital 
   $token = "2948208E715B986F25A5E"; 

   $urlPost = "https://api.bcash.com.br/service/searchAccount/xml";
   $data = "{'cpf':'31170845843'}";
   $version = "1.0";
   $encode = "UTF-8";

   $params = array("data"=>$data,"version"=>$version,"encode"=>$encode);

   ob_start();
   $ch = curl_init();
   curl_setopt($ch, CURLOPT_URL, $urlPost);
   curl_setopt($ch, CURLOPT_POST, 1);
   curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params, '', '&'));
   curl_setopt($ch, CURLOPT_HTTPHEADER, array("Authorization: Basic ".base64_encode($email. ":".$token)));
   curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE ); 
   curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE );
   curl_exec($ch);

   /* XML or Json Return */ 
   $resposta = ob_get_contents();

   ob_end_clean();

   /* Capturing the HTTP code to handle errors in request */ 
   $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
   curl_close($ch);

   if($httpCode != "200"){
	var_dump($resposta);
   /* Handle error messages */
   }else{
   var_dump($resposta);
   /* Process the response data */
   }
?>