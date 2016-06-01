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
	if (isset($_GET["login"])) $login = $_GET['login'];
	if (isset($_GET["password"])) $password = $_GET['password'];
	
	$internal_MySQL = new internal_MySQL();
	$crypto = new CryptoClass;
	$json = new JSON_class();
	
	if($type == "get")
	{
		// admin 
		// http://localhost/test/index.php?type=get&login=admin&password=e10adc3949ba59abbe56e057f20f883e
		
		if( ($login == 'admin') && ($password == 'e10adc3949ba59abbe56e057f20f883e') ){
			$publickey = $crypto->get_publickey();
		
			$token = md5('fuck you');
			
			$plain_data = array('publickey' => $publickey, 'token' => $token);
			$json_data = $json->send_reg_data($plain_data);
			
			echo $json_data;			
		}
		else {
			echo'fail';
		}
		
	}
	if($type == "set")
	{
		if (isset($_GET["cipherdata"])) $cipherdata = $_GET['cipherdata'];
		
		//echo $cipherdata;
		//echo "<br/><br/><br/><br/>";
		
		//$cipherdata = base64_decode($cipherdata);
		//lCFLPFRzJiUiaWbolRoksQK8Hbbt9MiHcLnbs2B79BF0OrIF3lVMorLaP/tdVHzIz3Dqtu2Ds8CBmPCAd7PGR0Y9MRdsa/BBQSGoLbLbpPmjNq5exroyl3uv6ZoueyqOBaLlSBBYkKHbdSh3PD6AY8yQA0XlMpSEDPaDK6vZhUk=
		//lCFLPFRzJiUiaWbolRoksQK8Hbbt9MiHcLnbs2B79BF0OrIF3lVMorLaP/tdVHzIz3Dqtu2Ds8CBmPCAd7PGR0Y9MRdsa/BBQSGoLbLbpPmjNq5exroyl3uv6ZoueyqOBaLlSBBYkKHbdSh3PD6AY8yQA0XlMpSEDPaDK6vZhUk=
		$cipherdata = "PYTbYxI4ttWpt3lkVVq/yUHA1los1pazaKUqKKmaz8hEf+XwdfW2IZizhEOAMHtunLjWSCf3vDSvK4/wftI74KN/ZjyvldsKUq3NKpCLFRq7ZmEBwNrzXD5TPtp6dr1020uLobfZhadVgLfkqOUqgJgy/Fx3ip3axKDBSgQhloQ=";
		$cipherdata = base64_decode($cipherdata);	
		echo $cipherdata;
		echo "<br/><br/><br/><br/>";
		
		$cipherdata = $crypto->decrypt($cipherdata);
		if(empty($cipherdata))
		{
			echo "Fail";
		}
		else
		{
			echo "NOt";
		}
		echo $cipherdata;
		echo "<br/><br/><br/><br/>";
		
		
		$cipherdata = $crypto->encrypt("hello");
		echo $cipherdata;
		echo "<br/><br/><br/><br/>";
		
		$cipherdata = base64_encode($cipherdata);
		echo $cipherdata;
		echo "<br/><br/><br/><br/>";
		
		$cipherdata = base64_decode($cipherdata);
		echo $cipherdata;
		echo "<br/><br/><br/><br/>";
		
		$plaindata = $crypto->decrypt($cipherdata);
		echo $plaindata;
	}
	if($type == "post")
	{
		if (isset($_GET["token"])) $token = $_GET['token'];
		if (isset($_GET["devicename"])) $devicename = $_GET['devicename'];
		
		echo "Your token is:".$token;
		echo "<br/><br/>";
		echo "Device name is: ".$devicename;
		echo "<br/><br/>";
	}
	//$setMode->set_Mode($type, FALSE);
	//$setMode->check_Mode(FALSE);
	
	

	
	//$result = new Result( $mysqli, array('ss', $login, $pass), array('count'), "SELECT COUNT(`id`) FROM `users` WHERE `login` = ? AND `password` = ?" );
    //$field = $result->getResult();
	
	
	
?>
