<?php

class PagamentoDigitalApi {
	
	private static $currentPath;
	
	private function __construct() {
		self::init();
	}
	
	public final static function init(){
		self::$currentPath = (dirname(__FILE__));
		
		$dirs = array(
			'config',
			'domain',
			'exception',
			'service',
			'serviceImpl'
		);
		
		foreach ($dirs as $d) {
			$directory = self::$currentPath.DIRECTORY_SEPARATOR.$d.DIRECTORY_SEPARATOR;
			$dir = opendir($directory);
			while($arq = readdir($dir)) { 
				$arq = $directory.$arq;
				if (file_exists($arq) && is_file($arq)) {
					require_once($arq);
				}
			}
			closedir($dir);
		}
	}
	
	public final static function getCurrentPath(){
		return self::$currentPath;
	}
	
}

PagamentoDigitalApi::init();
?>