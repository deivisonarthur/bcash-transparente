<?php

class DSpalenzaDArthur_Bcash_TestController extends Mage_Core_Controller_Front_Action
{

	public function indexAction()
	{
		/* ---------------------------------------------------------------------------------- */
		/* ------------ DADOS REQUERIDOS DO LOJISTA PARA UTILIZAR OS WEBSERVICES ------------ */
		/* ---------------------------------------------------------------------------------- */

		$consumerKey = '1f5c18f0e65699f2568ca2751654fa7fc5ce94b0'; 
		$sellerMail  = 'lojamodelo@pagamentodigital.com.br';
		$token       = '2948208E715B986F25A5E';


		/* ------------------------------------------------------------------------------------------------- */
		/* ------------ CRIANDO ARRAY CONTENDO TODOS OS DADOS DO PEDIDO, PAGAMENTO E CONSUMIDOR ------------ */
		/* ------------------------------------------------------------------------------------------------- */

		$order[0]->PRODUCT_CODE 		         		  = "1";
		$order[0]->PRODUCT_DESCRIPTION 		      		  = "Smartphone Samsung Galaxy";
		$order[0]->PRODUCT_AMOUNT 		          	 	  = 1;
		$order[0]->PRODUCT_VALUE 	              		  = 1550.00;
		$order[0]->PRODUCT_EXTRA_DESCRIPTION      		  = "Descrição Extra do Produto";
		$order[0]->PRODUCT_EXTENDEDWARRANTY_MONTHWARRANTY = '';
		$order[0]->PRODUCT_EXTENDEDWARRANTY_AMOUNT		  = '';
		$order[0]->PRODUCT_EXTENDEDWARRANTY_TOKEN 		  = '';
		$order[0]->PRODUCT_EXTENDEDWARRANTY_USE 		  = "YES"; /* Define se comprará garantia estendida do produto X = 'YES' ou não = 'NO' */
		$order[0]->FREIGHT                       		  = "0.00";
		$order[0]->FREIGHT_TYPE		              		  = "Tipo de Frete";
		$order[0]->CUSTOMER_ADDRESS		  	      		  = "Endereço Consumidor";
		$order[0]->CUSTOMER_ADDRESS_NUMBER		  		  = "2635";
		$order[0]->CUSTOMER_ADDRESS_COMPLEMENT	  		  = "Complemento Endereço Consumidor";
		$order[0]->CUSTOMER_ADDRESS_NEIGHBORHOOD  		  = "Bairro Consumidor";
		$order[0]->CUSTOMER_ADDRESS_CITY		  		  = "Cidade Consumidor";
		$order[0]->CUSTOMER_ADDRESS_STATE		  		  = "SP";
		$order[0]->CUSTOMER_ADDRESS_ZIPCODE		  		  = "17516000";
		$order[0]->CUSTOMER_MAIL		          		  = "teste_bcash@hotmail.com";
		$order[0]->CUSTOMER_NAME		          		  = "Nome Consumidor";
		$order[0]->CUSTOMER_PHONE		          		  = "1434141414";
		$order[0]->CUSTOMER_CELLPHONE		      		  = "1497777777";
		$order[0]->CUSTOMER_GENDER		          		  = "M"; 
		$order[0]->CUSTOMER_BIRTHDATE		      		  = "21/09/1988";
		$order[0]->CUSTOMER_IS_A_COMPANY         		  = 'NO'; /* Define se o consumidor é Pessoa Física = 'NO' ou Pessoa Jurídica = 'YES' */
		$order[0]->CUSTOMER_CPF		  	          		  = "34248820706";
		$order[0]->CUSTOMER_RG		              		  = "435627842";
		$order[0]->DEPENDENT_TRANSACTIONS_EMAIL    		  = "email@dependente.com.br";
		$order[0]->DEPENDENT_TRANSACTIONS_VALUE   		  = "5.00";
		$order[0]->CUSTOMER_RG		              		  = "435627842";
		$order[0]->STATUS			  			  		  = "";   /* Se a transação for criada com sucesso (httpCode = 200) nesta variável será armazenado o código do status para atualizar o pedido em seu admin */
		$order[0]->STATUS_DESCRIPTION			  		  = "";   /* Se a transação for criada com sucesso (httpCode = 200) nesta variável será armazenada descrição do status para atualizar o pedido em seu admin */
		$order[0]->PAYMENT_METHOD 				  		  = "37"; /* Define o meio de pagamento a ser utilizado pelo consumidor para finalizar a transação */

		/* Validando se o consumidor é Pessoa Jurídica, caso afirmativo, incluir o CNPJ e Razão Social no array */
			if ( $order[0]->CUSTOMER_IS_A_COMPANY == 'YES' ) {
				$order[0]->CUSTOMER_CNPJ		= "51636253000197";
				$order[0]->CUSTOMER_COMPANYNAME	= "Razao Social Consumidor";
			}

		/* Exemplo de validação de meios de pagamento e cartões */
		$pgto_prazo = true;
			switch( $order[0]->PAYMENT_METHOD ) {
				case '10':
					/* BOLETO */
					$pgto_prazo = false;
					break;
				case '58':
					/* TEF BANCO DO BRASIL */
					$pgto_prazo = false;
					break;
				case '59':
					/* TEF BRADESCO */
					$pgto_prazo = false;
					break;
				case '60':
					/* TEF ITAÚ */
					$pgto_prazo = false;
					break;
				case '61':
					/* TEF BANRISUL */
					$pgto_prazo = false;
					break;
				case '62':
					/* TEF HSBC */
					$pgto_prazo = false;
					break;	
			}
			
		$parcelamentoInvalido = false;

		if($pgto_prazo){
			$order[0]->INSTALLMENTS   = "12"; /* Define parcelamento para os cartões de crédito, valores aceitos entre 1 (mínimo) à 24 (máximo) */
			
			/* Cartão AURA em até 24x, AMEX até 15x e demais bandeiras de cartão (default) em 12x */
			$parcelaLimiteOperadora = 12;
			$nomeOperadora = "";
			
			
			switch( $order[0]->PAYMENT_METHOD ) {
				case '37': /* AMEX */
					$parcelaLimiteOperadora = 15;
					$nomeOperadora = "AMEX";
					$parcelamentoInvalido = $this->verificaParcelamentoInvalido( $order[0]->INSTALLMENTS, $parcelaLimiteOperadora );
					break;
				case '45': /* AURA */
					$parcelaLimiteOperadora = 24;
					$nomeOperadora = "AURA";
					$parcelamentoInvalido = $this->verificaParcelamentoInvalido( $order[0]->INSTALLMENTS, $parcelaLimiteOperadora );
					break;
				default:
					$parcelamentoInvalido = $this->verificaParcelamentoInvalido( $order[0]->INSTALLMENTS, $parcelaLimiteOperadora );
			}
			
			if ( $parcelamentoInvalido ){
				echo utf8_encode("Parcelamento Inválido! Máximo de $parcelaLimiteOperadora parcelas para bandeira de cartão selecionada $nomeOperadora");
			}
			
			/* DADOS DE CARTÃO SEPARADOS PELO CARACTERE "§" */
			$creditCardNumber        = "379848835505327";
			$creditCardHolder        = "Teste Bcash";
			$creditCardMaturityMonth = "03";
			$creditCardMaturityYear  = "2017";
			$creditCardSecurityCode  = "1234";

			$order[0]->CARD_DATA     = "$creditCardNumber"."§"."$creditCardHolder"."§"."$creditCardMaturityMonth"."§"."$creditCardMaturityYear"."§"."$creditCardSecurityCode"; 
		}

		$orderId = ""; /* Número de pedido gerado por seu ecommerce */



		/* -------------------------------------------------------------------- */
		/* ------------ INSTANCIANDO FUNÇÕES DO CÓDIGO/WEBSERVICES ------------ */
		/* -------------------------------------------------------------------- */

		if ( ($parcelamentoInvalido == false) && ($this->dataAccountLookup($order[0]->CUSTOMER_CPF,$sellerMail, $token, $order) == true) ){

			$x = 0;
			foreach( $order as $consultarGarantia ) {
				$garantia['products'][ $x ]['description'] 	= $consultarGarantia->PRODUCT_DESCRIPTION;
				$garantia['products'][ $x ]['value'] 		= $consultarGarantia->PRODUCT_VALUE;
				$x++;
			}

			$respostaConsulta = $this->consultarGarantia( $garantia, $sellerMail, $token );
			$temp = json_decode($respostaConsulta);

			$valorTotalGarantiaEstendida = 0;
			/* Para disponibilizar valor da garantia e descrição do produto que a contém ao usuário abaixo estão as informações */
			foreach( $temp->products as $product ){
				if ( $product->extendedWarranty == 'true'){
					echo "Produto com Garantia Estendida!<BR>";
					echo urldecode($product->description)."<BR>";
					echo urldecode($product->valueExtendedWarranty)."<BR>";
					echo urldecode($product->token)."<BR><BR>";
					$x= 0;
					foreach ( $order as $compararGarantia ){
						if( ( $compararGarantia->PRODUCT_DESCRIPTION == urldecode($product->description) ) && ($order[$x]->PRODUCT_EXTENDEDWARRANTY_USE == "YES") ){
							$order[$x]->PRODUCT_EXTENDEDWARRANTY_MONTHWARRANTY = "12"; /* Quantidade em meses da garantia estendida */
							$order[$x]->PRODUCT_EXTENDEDWARRANTY_AMOUNT		  = "1";  /* Quantidade adquirida da garantia estendida deste produto */
							$order[$x]->PRODUCT_EXTENDEDWARRANTY_TOKEN 		  = urldecode($product->token); /* Token retornado na garantia */
							$valorTotalGarantiaEstendida = $product->valueExtendedWarranty * $order[$x]->PRODUCT_EXTENDEDWARRANTY_AMOUNT;
						}
						$x++;
					}
				}
			}
			
			$valorTotalPostarGarantiaEstendida = 0;
			foreach($order as $valor){
				$valorTotalPostarGarantiaEstendida = $valorTotalPostarGarantiaEstendida + ($valor->PRODUCT_AMOUNT * $valor->PRODUCT_VALUE);
			}
			
			$valorTotalPostarGarantiaEstendida = $valorTotalPostarGarantiaEstendida + $valorTotalGarantiaEstendida;
			
			$post = "<!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.01//EN' 'http://www.w3.org/TR/html4/strict.dtd'>
							 <html>
								<header>
									<title>Formulário de Integração Bcash</title>
								<header>
								<body>
									<form action='https://www.bcash.com.br/services/wallet' method='post' >
									<input type='hidden' name='email_loja' value='".$sellerMail."'/>
									<input type='hidden' name='valor' value='".$valorTotalPostarGarantiaEstendida."'/>
									<input type='hidden' name='cpf' value='".$order[0]->CUSTOMER_CPF."'/>
									<input type='hidden' name='url_retorno' value='http://172.18.33.16/APi/exemplo_api_bcash_php_criacao_transacao.php'/>
									<input type='submit' value=”Enviar” /></form>
									<SCRIPT LANGUAGE='JavaScript'>
										document.getElementById('bcash').submit();
									</SCRIPT>
								</body>
							</html>";
							
			$fp = fopen("form_bcash.html", "a");
			$escreve = fwrite($fp, $post);
			fclose($fp);
			
			$fp = fopen("form_bcash.html", "w");
			$escreve = fwrite($fp, $post);
			fclose($fp);

			/* Após consumidor optar pela garantia estendida de um produto incluir no JSON para o webservice de criação de transação o token retornado */
			/* Desta forma o Bcash entenderá que devemos aplicar a garantia e o Bcash irá incluir o valor automaticamente */
			
			$data  = $this->arrayBuilder($order, $sellerMail, $orderId);
			$oAuth = $this->grantAccess($consumerKey);

			//Mage::log($data, null, '$data');
			//Mage::log($oAuth, null, '$oAuth');

			echo urldecode($this->creatingTransaction($data, $oAuth));
		}
	}




	/* -------------------------------------------------------------------- */
	/* ------------------  FUNÇÕES DO CÓDIGO/WEBSERVICES ------------------ */
	/* -------------------------------------------------------------------- */

	public function verificaParcelamentoInvalido( $parcelas, $parcelaLimiteOperadora){
		$parcelamentoInvalido = false;

		if ( $parcelas > $parcelaLimiteOperadora ){
				$parcelamentoInvalido = true;
		}
		
		return $parcelamentoInvalido;
	}

	public function dataAccountLookup($cpf,$sellerMail, $token, $order){
	/* -------------------------------------------------------------------------- */
	/* ------------ INICIANDO WEBSERVICE DE CONSULTAR DADOS DE CONTA ------------ */
	/* -------------------------------------------------------------------------- */

		$success = false;
		$urlPost = "https://api.bcash.com.br/service/searchAccount/json";
		$search = "{'cpf':'$cpf'}"; 
		$version = '1.0'; 
		$encode = 'UTF-8'; 
		$searchData = array("data"=>$search,"version"=>$version,"encode"=>$encode); 

		ob_start(); 
		$ch = curl_init(); 
		curl_setopt($ch, CURLOPT_URL, $urlPost); 
		curl_setopt($ch, CURLOPT_POST, 1); 
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($searchData, '', '&')); 
		curl_setopt($ch, CURLOPT_HTTPHEADER, array("Authorization: Basic ".base64_encode($sellerMail. ":".$token))); 
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE ); /* Se seu domínio possuir SSL, remover esta linha de código */
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE ); /* Se seu domínio possuir SSL, remover esta linha de código */
		curl_exec($ch);

		$result = ob_get_contents(); 
		ob_end_clean(); 

		$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE); 
		curl_close($ch); 

		if($httpCode != "200")
		{ 
			echo "Data Account Lookup - There was an error! $httpCode"."<BR>";
		}else
		{
			$json = json_decode($result);
			
			switch( $json->{'code'} ) {
			case '1': /* Uma conta encontrada - Conferir se há compatibilidade entre o email que possui do consumidor e o email que Bcash retornou */
				$mailReturned = urldecode($json->{'accounts'}[0]->mail);

				if ($order[0]->CUSTOMER_MAIL != $mailReturned){
					$order[0]->CUSTOMER_MAIL = $mailReturned;
				}
				$success = true;
				break;
				
			case '2': /* Mais de uma conta encontrada - Conferir se há compatibilidade entre o email que possui do consumidor e cada email que Bcash retornou */
				$limit = preg_replace("/[^0-9]/", "", urldecode($json->{'message'}));
				$success = false;
				
				for ($inc=0; $inc < $limit; $inc++){
					$mailReturned = urldecode($json->{'accounts'}[$inc]->mail);
					if ($order[0]->CUSTOMER_MAIL == $mailReturned){
						$success = true;
						break;
					}
				}
				
				if($success == true){
					echo "Consultar dados de Transação - Successo!"."<BR><BR>";
				}else {
					echo "Consultar dados de Transação - Incompatibilidade entre emails de sua conta Bcash e informado na loja virtual!"."<BR><BR>";
				}
				break;
			
			case '3': /* Nenhuma conta encontrada - Prosseguir diretamente para webservice de Criação da Transação  */
				$success = true;
				break;
			}
		}
		return $success;
	}


	public function consultarGarantia( $garantia, $email, $token ){

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


	public function arrayBuilder($order, $sellerMail, $orderId){
	/* ------------------------------------------------------ */
	/* ------------ CONSTRUINDO O ARRAY DE DADOS ------------ */
	/* ------------------------------------------------------ */


		$data    = NULL; /* Setando $data como default = NULL para limpar a variável */
		$x       =  0;   /* Setando $x como default = 0 para foreach abaixo em vendas com multi-produtos */


		/* Preenchendo array $data com todos os produtos encontrados no array $order */

		foreach( $order as $products ) {
			$data['dependentTransactions'][ $x ]['email']			 	 = $products->DEPENDENT_TRANSACTIONS_EMAIL;
			$data['dependentTransactions'][ $x ]['value']			 	 = $products->DEPENDENT_TRANSACTIONS_VALUE;
			$data['products'][ $x ]['extendedWarranty']['amount'] 		 = $products->PRODUCT_EXTENDEDWARRANTY_AMOUNT;
			$data['products'][ $x ]['extendedWarranty']['monthwarranty'] = $products->PRODUCT_EXTENDEDWARRANTY_MONTHWARRANTY;
			$data['products'][ $x ]['extendedWarranty']['amount'] 		 = $products->PRODUCT_EXTENDEDWARRANTY_AMOUNT;
			$data['products'][ $x ]['extendedWarranty']['token'] 		 = $products->PRODUCT_EXTENDEDWARRANTY_TOKEN;
			$data['products'][ $x ]['code'] 			 				 = $products->PRODUCT_CODE;
			$data['products'][ $x ]['description'] 					     = $products->PRODUCT_DESCRIPTION;
			$data['products'][ $x ]['amount'] 			 				 = $products->PRODUCT_AMOUNT;
			$data['products'][ $x ]['value'] 			 			     = $products->PRODUCT_VALUE;
			$data['products'][ $x++ ]['extraDescription'] 				 = $products->PRODUCT_EXTRA_DESCRIPTION;
		}

		/* Definindo Tipo de Frete e valor */
		if ( $order[0]->FREIGHT > 0 ) {
			$data['freight']     = $order[0]->FREIGHT;
			$data['freightType'] = strtoupper( $order[0]->FREIGHT_TYPE );
		}

		/* Dados do Consumidor e seus Dados de Entrega */
		$data['buyer']['address']['address'] 	  = $order[0]->CUSTOMER_ADDRESS;
		$data['buyer']['address']['number'] 	  = $order[0]->CUSTOMER_ADDRESS_NUMBER;
		$data['buyer']['address']['complement']   = $order[0]->CUSTOMER_ADDRESS_COMPLEMENT;
		$data['buyer']['address']['neighborhood'] = $order[0]->CUSTOMER_ADDRESS_NEIGHBORHOOD;
		$data['buyer']['address']['city'] 		  = $order[0]->CUSTOMER_ADDRESS_CITY;
		$data['buyer']['address']['state'] 		  = $order[0]->CUSTOMER_ADDRESS_STATE;
		$data['buyer']['address']['zipCode'] 	  = preg_replace( '/([0-9]{5})([0-9]{3})/', '$1-$2', str_pad( $order[0]->CUSTOMER_ADDRESS_ZIPCODE, 8, '0', STR_PAD_LEFT ) ); //Brazillian ZipCode must be in format: 17516000 or 17516-000
		$data['buyer']['mail'] 					  = $order[0]->CUSTOMER_MAIL;
		$data['buyer']['name'] 					  = $order[0]->CUSTOMER_NAME;
		$data['buyer']['phone'] 				  = $order[0]->CUSTOMER_PHONE;
		$data['buyer']['cellPhone'] 			  = $order[0]->CUSTOMER_CELLPHONE;
		$data['buyer']['gender'] 				  = $order[0]->CUSTOMER_GENDER;
		$data['buyer']['birthDate'] 			  = $order[0]->CUSTOMER_BIRTHDATE;
		$data['buyer']['cpf']  = $order[0]->CUSTOMER_CPF;
		$data['buyer']['rg']   = $order[0]->CUSTOMER_RG;
			
		/* Validando se o consumidor é uma empresa, caso afirmativo, incluir o CNPJ e Razão Social no array */
		if ( $order[0]->CUSTOMER_IS_A_COMPANY == 'YES' ) {
			$data['buyer']['cnpj']        = $order[0]->CUSTOMER_CNPJ;
			$data['buyer']['companyName'] = $order[0]->CUSTOMER_COMPANYNAME;
		}

		/* Dados meios de pagamento e cartões */
		$pgto_prazo = true;
		
		switch( $order[0]->PAYMENT_METHOD ) {
			case '10':
				$data['paymentMethod']['code'] = 10; /* BOLETO */
				$pgto_prazo = false;
				break;
			case '58':
				$data['paymentMethod']['code'] = 58; /* TEF BANCO DO BRASIL */
				$pgto_prazo = false;
				break;
			case '59':
				$data['paymentMethod']['code'] = 59; /* TEF BRADESCO */
				$pgto_prazo = false;
				break;
			case '60':
				$data['paymentMethod']['code'] = 60; /* TEF ITAÚ */
				$pgto_prazo = false;
				break;
			case '61':
				$data['paymentMethod']['code'] = 61; /* TEF BANRISUL */
				$pgto_prazo = false;
				break;
			case '62':
				$data['paymentMethod']['code'] = 62; /* TEF HSBC */
				$pgto_prazo = false;
				break;	
		}
		
		/* Conferindo se meio de pagamento é parcelado, incluir dados de cartão no array caso afirmativo */
		
		if($pgto_prazo){
			$data['paymentMethod']['code'] = $order[0]->PAYMENT_METHOD;
			
			$creditCardData = preg_split( '/\§/', $order[0]->CARD_DATA );
		
			$data['creditCard']['number'] 		 = $creditCardData[0];
			$data['creditCard']['holder'] 		 = $creditCardData[1];
			$data['creditCard']['maturityMonth'] = $creditCardData[2];
			$data['creditCard']['maturityYear']  = $creditCardData[3];
			$data['creditCard']['securityCode']  = $creditCardData[4];

			$data['installments'] = $order[0]->INSTALLMENTS;
		}
		
		$data['sellerMail'] 	  = $sellerMail;
		$data['orderId'] 	      = $orderId;
		$data['acceptedContract'] = 'S'; /* Ambos acceptedContract e viewedContract devem possuir por default 'N', porque o consumidor deve aceitar os termos de pagamento Bcash, caso consumidor aceitar os termos, alterar para 'S' */
		$data['viewedContract']   = 'S'; /* Muitos de nossos clientes utilizam de um simples checkbox para conferir se o consumidor aceitou os termos de pagamento Bcash */
		$data['urlNotification']  = 'http://www.seudominio.com.br/notificacao_loja.php'; /* Esta url receberá as informações para atualização de seus pedidos a cada mudança de status no Bcash, sendo os dados enviados no padrão URL de Aviso */
		$data['urlReturn']  = 'http://www.seudominio.com.br/retorno_cliente.php'; /* Caso não informar o input 'urlNotification' esta url receberá as informações para atualização de seus pedidos a cada mudança de status no Bcash, sendo os dados enviados no padrão URL de Retorno, porém caso informe ambas URLs, esta será a página ao qual encaminharemos o consumidor ao finalizar o pagamento */

		return $data;
	}


	public function grantAccess($consumerKey){
	/* --------------------------------------------------------------------------------- */
	/* ------------ PROVENDO ACESSO PARA WEBSERVICE DE CRIAÇÃO DE TRANSAÇÃO ------------ */
	/* --------------------------------------------------------------------------------- */

		$time 	     = time()*1000;
		$microtime   = microtime();
		$rand        = mt_rand();
		$urlPost     = 'https://api.bcash.com.br/service/createTransaction/json/';

		$signature = array(
			'oauth_consumer_key' 		=> $consumerKey, 				
			'oauth_nonce' 				=> md5( $microtime . $rand ),	
			'oauth_signature_method'	=> 'PLAINTEXT',					
			'oauth_timestamp' 			=> $time,						
			'oauth_version' 			=> '1.0'						
		);

		/* Encoding dos parâmetros */
		$signature = base64_encode( http_build_query( $signature, '', '&' ) );

		$oAuth = array( 
			'Authorization: OAuth realm=' . $urlPost .
			',oauth_consumer_key=' . $consumerKey .
			',oauth_nonce=' . md5( $microtime . $rand ) .
			',oauth_signature=' . $signature .
			',oauth_signature_method=PLAINTEXT' .
			',oauth_timestamp=' . $time .
			',oauth_version=1.0' ,
			'Content-Type:application/x-www-form-urlencoded; charset=utf-8'
		);
		return $oAuth;
	}


	public function creatingTransaction($data, $oAuth){
	/* ---------------------------------------------------------------------------------------------------- */
	/* ------------ PREPARANDO JSON E ENVIANDO AO BCASH VIA WEBSERVICE DE CRIAÇÃO DE TRANSAÇÃO ------------ */
	/* ---------------------------------------------------------------------------------------------------- */

		$data = json_encode( $data );  /* Encoding $data em formato JSON */
		
		/* Descomente esta linha abaixo para debugar o JSON gerado e dados do array */
		//echo '<pre>'.$data.'</pre><pre>'.print_r( json_decode( $data, true ), true).'</pre>';

		$version = "1.0";   /* Versão atual utilizada 1.0 */
		$encode  = "UTF-8"; /* Encoding disponíveis atualmente: UTF-8 ou ISO-8859-1 */
		$urlPost     = 'https://api.bcash.com.br/service/createTransaction/json/';
		$params  = array("data"=>$data,"version"=>$version,"encode"=>$encode);
			
		ob_start();
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);	
		curl_setopt($ch, CURLOPT_URL, $urlPost);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params, '', '&'));
		curl_setopt($ch, CURLOPT_HTTPHEADER, $oAuth);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE ); /* Se seu domínio possuir SSL, remover esta linha de código */
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE ); /* Se seu domínio possuir SSL, remover esta linha de código */
		curl_exec($ch);

		/* XML ou Json retornado pelo Bcash */
		$resposta = ob_get_contents();
		ob_end_clean();

		/* Obtendo httpCode para verificar erros ou successo */
		$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

		if($httpCode != "200"){
			/* Se httpCode é diferente de 200, a variável $resposta contém a descrição e código de erro para auxiliá-lo a identificar a situação e saná-la */
			return("Creating Transaction - Error! :<br /><br />$resposta");
		} else {
			/* Se httpCode é igual a 200, houve sucesso ao criar uma nova transação e a variável $resposta contém o número da transação (gerado pelo Bcash), número do pedido (enviado pela loja virtual) e o status desta transação */
			$temp = json_decode($resposta);
			$order[0]->STATUS			  	 = urldecode($temp->{'status'});
			$order[0]->STATUS_DESCRIPTION	 = urldecode($temp->{'descriptionStatus'});
			return("Creating Transaction - Success! :<br /><br />$resposta");
		}

	}




}