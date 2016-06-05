<?php
	//<errors>
	ini_set('error_reporting', E_ALL);
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	//</errors>
	
	//<includes>
	include 'API.php';
	//</includes>

	
	//Получаемые параметры
	if ($api->issetParam("type")) $type = $api->getParam("type");
			
	//Кухня
	if($type == "token_generate") {
		echo $api->token_generate();
	}
	
	if($type == "registration") {
		echo $api->device_reg();
	}
	
	if($type == "get_time") {
		echo $api->get_time();
	}
	
	if($type == "check_pin") {
		echo $api->check_pin(  );
	}
?>
