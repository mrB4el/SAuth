<?php
	//<errors>
	ini_set('error_reporting', E_ALL);
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	//</errors>
	
	//<includes>
	include 'API.php';
	//</includes>
	
	//Инициализация классов
	$MySQLConnect_Class = new MySQLConnect_Class();
	$crypto = new Cryptography_Class();
	$json = new JSON_class();
	$api = new API();
		
	
	
	
	//Получаемые параметры
	if ($api->issetParam("type")) $type = $api->getParam("type");
			
	//Кухня
	if($type == "token_generate") {
		$api->token_generate();
	}
	
	if($type == "registration") {
		$api->device_reg();
	}
	
	if($type == "get_time") {
		$api->get_time();
	}
	
	if($type == "check_pin") {
		$api->check_pin( "111111" );
	}
?>
