<?php
	//<errors>
	ini_set('error_reporting', E_ALL);
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	//</errors>
	
	//<includes>
	include 'MySQLConnect_Class.php';
	include 'Cryptography_class.php';
	include 'JSON_Class.php';
	include 'API.php';
	//</includes>
	
	//Инициализация классов
	$internal_MySQL = new internal_MySQL();
	$crypto = new CryptoClass;
	$json = new JSON_class();
	$main = new MainAPI();
		
	class MainAPI {
		/*
			<<Token generate>>
			query template: /index.php?type=token_generate&login=admin&password=e10adc3949ba59abbe56e057f20f883e
		*/
		function token_generate() {
			if (API::issetParam("login")) $login = API::getParam("login");
			if (API::issetParam("password")) $password = API::getParam("password");
			
			$token = "";
			
			//masterkey = 3021e68df9a7200135725c6331369a22;
			
			if( ($login == 'admin') && ($password == 'e10adc3949ba59abbe56e057f20f883e') ) {
				//$publickey = $crypto->get_publickey();
				
				$publickey = "somepublickey";
				
				$uid = 5;
							
				$check = internal_MySQL::get_token($uid); 
				if(empty($check)) {
					echo $token;
					
					$token = md5(rand() + $uid);
					
					internal_MySQL::set_token($uid, $token);
					$token = internal_MySQL::get_token($uid);
				}
				else {
					$token = $check;
				}
				
				$today = date("Y-m-d H:i:s"); 
										
				$plain_data = array('publickey' => $publickey, 'token' => $token, 'date' => $today);
				$json_data = JSON_class::send_reg_data($plain_data);
				
				echo $json_data;			
			}
			else {
				echo 'fail';
			}
		}
		
		/*
			<<Device registration>>
			query template: 
		*/
		function device_reg() {
			if (API::issetParam("devicename")) $devicename = API::getParam("devicename");
			if (API::issetParam("secret")) $secret = API::getParam("secret");
			if (API::issetParam("token")) $token = API::getParam("token");
			
			$uid = internal_MySQL::check_token($token);
			
			if(empty($uid))	{
				echo "Token is not valid or expired";
				echo "<br/><br/>";
			}
			else {			
				echo "Your token is: ".$token;
				echo "<br/><br/>";
				echo "Device name is: ".$devicename;
				echo "<br/><br/>";
				echo "Device secret is: ".$secret;
				echo "<br/><br/>";
				echo "Your uid is: ".$uid;
				echo "<br/><br/>";
				
				internal_MySQL::close_token($token);
				internal_MySQL::set_device_info($uid, $devicename, $secret);
			}
		}
	}
	
	
	//Получаемые параметры
	if (API::issetParam("type")) $type = API::getParam("type");
			
	//Кухня
	if($type == "token_generate") {
		$main->token_generate();
	}
	
	if($type == "registration") {
		$main->device_reg();
	}
?>
