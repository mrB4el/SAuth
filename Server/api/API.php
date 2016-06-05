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
	//</includes>
   	
    class API
    {
        static function issetParam( $name ) {
            return isset($_GET[$name]) || isset($_POST[$name]);
        }
        static function getParam( $name, $defaultValue = "" ) {
            return isset($_POST[$name]) ? $_POST[$name] : (isset($_GET[$name]) ? $_GET[$name] : $defaultValue);
        }      
		
		/*
			<<Token generate>>
			query template: /index.php?type=token_generate&login=admin&password=e10adc3949ba59abbe56e057f20f883e
		*/
		function token_generate($username = "", $password = "") {
			if ($this->issetParam("username")) $username = $this->getParam("username");
			if ($this->issetParam("password")) $password = $this->getParam("password");
			
			$token = "";
			
			//masterkey = 3021e68df9a7200135725c6331369a22;
			
			$result = "0";
            
            $mysqli = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
                      
            $username = mysqli_real_escape_string($mysqli, $username);
            $password = mysqli_real_escape_string($mysqli, $password);
              
            $sql = "SELECT id FROM users WHERE username = '$username' AND password = '$password'";
            
            if($query = $mysqli->prepare($sql)){
                $query->execute();
                $res = $query->get_result();
                $row = $res->fetch_assoc();
                
                $uid = $row["id"];
            }else{
                var_dump($mysqli->error);
            }
			
			if( ($uid != "0") OR ($uid != "") ) {
				//$publickey = $crypto->get_publickey();
				
				$publickey = "somepublickey";
				
							
				$check = MySQLConnect_Class::get_token($uid); 
				if(empty($check)) {				
					$token = md5(rand() + $uid);
					
					MySQLConnect_Class::set_token($uid, $token);
					$token = MySQLConnect_Class::get_token($uid);
				}
				else {
					$token = $check;
				}
				
				$today = date("Y-m-d H:i:s"); 
										
				$plain_data = array('publickey' => $publickey, 'token' => $token);
				$json_data = JSON_class::send_data($plain_data);
			}
			else {
				$plain_data = array("status" => "failed");
			}
			
			$json_data = JSON_class::send_data($plain_data);	
			
			return $json_data;
		}
		
		/*
			<<Device registration>>
			query template: /index.php?&type=registration&token=cd49f7f7616e5661b97901dc688b4385&devicename=WIN10-PC&secret=7f8e0eb8de4e20c5ddb64b884bf3b9b3
		*/
		function device_reg() {
			if ($this->issetParam("devicename")) $devicename = $this->getParam("devicename");
			if ($this->issetParam("secret")) $secret = $this->getParam("secret");
			if ($this->issetParam("token")) $token = $this->getParam("token");
			
			$uid = MySQLConnect_Class::check_token($token);
			
			if(empty($uid))	{
				$plain_data = array("status" => "failed");
			}
			else {						
				MySQLConnect_Class::close_token($token);
				MySQLConnect_Class::set_device_info($uid, $devicename, $secret);
				
				$plain_data = array("status" => "success");
			}
			
			$json_data = JSON_class::send_data($plain_data);	
			
			return $json_data;
		}
        
        /*
			<<Time sync>>
			query template: 
		*/
		function get_time() {
            $today = date("Y-m-d H:i:s");
			$plain_data = array('time' => $today);
			$json_data = JSON_class::send_data($plain_data);
			
			return $json_data;
		}
        
		 /*
			<<Chech time pin code>>
			query template: /index.php?type=check_pin&uid=5&pin=518974
		*/
        function check_pin($uid = "0", $pin = "000000", $pinsize = "6") {
			
			if ($this->issetParam("uid")) $uid = $this->getParam("uid");
			if ($this->issetParam("pin")) $pin = $this->getParam("pin");
			if ($this->issetParam("pinsize")) $pinsize = $this->getParam("pinsize");
			       
            $date = date("H:i"); ;
            //$nextMin = time() + (1 * 60);
            //$interval2 = date("H:i", $nextMin);
            
            $secret = MySQLConnect_Class::get_device_info($uid);
            
            $str = $secret.$date;
            $md5_temp = MD5($str);
            $md5_temp = Cryptography_Class::magic($md5_temp, $pinsize);

			$status = strcmp($pin, $md5_temp);
			
			$plain_data = array('status' => $status);
			$json_data = JSON_class::send_data($plain_data);
			
			return $json_data;
        }
	}
	
	//Инициализация классов
	$mysqlConnect_Class = new MySQLConnect_Class();
	$crypto = new Cryptography_Class();
	$json_class = new JSON_class();
	$api = new API();
?>