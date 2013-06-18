<?php

class HttpServiceImpl implements HttpService{

	public static function post($url, $params, $auth){
		try{
			if ( !function_exists("curl_init") &&
			!function_exists("curl_setopt") &&
			!function_exists("curl_exec") &&
			!function_exists("curl_close")) {
				throw new Exception('CURL is required.');
			}

			$data = array("data"=>$params->getJSONEncode(),"version"=>Config::version);
				
			$httpResponse = new HttpResponse();
			ob_start();
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, self::get_furl($url));
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data, '', '&'));
			curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, '0');
			curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, '0');
			curl_setopt($ch, CURLOPT_HTTPHEADER, $auth );
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, Config::timeout );
			curl_exec($ch);
			$httpResponse->setResponse(urldecode(ob_get_contents()));
			$httpResponse->setCode(curl_getinfo($ch, CURLINFO_HTTP_CODE));
			ob_end_clean();
			
			if(curl_errno($ch)){
			    curl_close($ch);
				throw new Exception(curl_error($ch));
			}
            curl_close($ch);
			return $httpResponse;

		} catch (Exception $e) {
			curl_close($ch);
			throw new HttpException($e->getMessage());
		}

	}

	public static function get_furl($url)
	{
	    $furl = false;
	   
	    // First check response headers
	    $headers = get_headers($url);
	   
	    // Test for 301 or 302
	    if(preg_match('/^HTTP\/\d\.\d\s+(301|302)/',$headers[0]))
	    {
	        foreach($headers as $value)
	        {
	            if(substr(strtolower($value), 0, 9) == "location:")
	            {
	                $furl = trim(substr($value, 9, strlen($value)));
	            }
	        }
	    }
	    // Set final URL
	    $furl = ($furl) ? $furl : $url;
	
	    return $furl;
	}
}


?>