<?php
	//<errors>
	ini_set('error_reporting', E_ALL);
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	//</errors>
	
	
	
	//includes
	
	include 'MySQLConnect_Class.php';
	include 'Cryptography_class.php';
	include 'JSON_Class.php';
	
	
	class SetMode{
		
		private $mode = '0';
		
		function set_Mode( $type = 'set', $debug = FALSE ){
			
			if( $type == 'set' ){ 
				$this->mode = 0; 
			} elseif( $type == 'get' ){ 
				$this->mode = 1; 
			} else { 
				echo'<br/>Uncorrect mode type<br/>'; 
			}

			//Debug Mode
			if( $debug ) 
				echo '<br/>'. __FUNCTION__.' executed, result:<br/> mode: '.$this->mode.'<br/> type: '.$type;
		}
		
		function check_Mode( $debug = FALSE ){
			
			//Debug Mode
			if( $debug ) 
				echo '<br/>'. __FUNCTION__.' executed, result: '.$this->mode.'<br/>';
		}
	}

	$setMode = new SetMode;

	
	$type = 'set';
	$login = '';
	$password = '';
	
	//Получаемые параметры
	if (isset($_GET["type"])) $type = $_GET['type'];
	if (isset($_GET["token"])) $token = $_GET['token'];
	
	
	$internal_MySQL = new internal_MySQL();
	$crypto = new CryptoClass;
	$json = new JSON_class();
	
	if($type == "token_generate")
	{
		if (isset($_GET["login"])) $login = $_GET['login'];
		if (isset($_GET["password"])) $password = $_GET['password'];
		
		$token = "";
		
		//masterkey = 3021e68df9a7200135725c6331369a22;
		
		if( ($login == 'admin') && ($password == 'e10adc3949ba59abbe56e057f20f883e') ){
			//$publickey = $crypto->get_publickey();
			
			$publickey = "somepublickey";
			
			$uid = 5;
						
			$check = $internal_MySQL->get_token($uid); 
			if(empty($check))
			{
				echo $token;
				
				$token = md5(rand() + $uid);
				
				$internal_MySQL->set_token($uid, $token);
				$token = $internal_MySQL->get_token($uid);
			}
			else 
			{
				$token = $check;
			}
			
			$today = date("Y-m-d H:i:s"); 
									
			$plain_data = array('publickey' => $publickey, 'token' => $token, 'date' => $today);
			$json_data = $json->send_reg_data($plain_data);
			
			echo $json_data;			
		}
		else {
			echo 'fail';
		}
		// /index.php?type=token_generate&login=admin&password=e10adc3949ba59abbe56e057f20f883e
	}
	if($type == "registration")
	{
		if (isset($_GET["token"])) $token = $_GET['token'];
		if (isset($_GET["devicename"])) $devicename = $_GET['devicename'];
		if (isset($_GET["secret"])) $secret = $_GET['secret'];
		
		$uid = $internal_MySQL->check_token($token);
		
		if(empty($uid))
		{
			echo "Token is not valid or expired";
			echo "<br/><br/>";
		}
		else
		{			
			echo "Your token is: ".$token;
			echo "<br/><br/>";
			echo "Device name is: ".$devicename;
			echo "<br/><br/>";
			echo "Device secret is: ".$secret;
			echo "<br/><br/>";
			echo "Your uid is: ".$uid;
			echo "<br/><br/>";
			
			//$internal_MySQL->close_token($token);
			$internal_MySQL->set_device_info($uid, $devicename, $secret);
		}
	}
	//$setMode->set_Mode($type, FALSE);
	//$setMode->check_Mode(FALSE);
	
	

	
	//$result = new Result( $mysqli, array('ss', $login, $pass), array('count'), "SELECT COUNT(`id`) FROM `users` WHERE `login` = ? AND `password` = ?" );
    //$field = $result->getResult();
	
	
	
?>
