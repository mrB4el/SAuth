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
		function token_generate() {
			if ($this->issetParam("login")) $login = $this->getParam("login");
			if ($this->issetParam("password")) $password = $this->getParam("password");
			
			$token = "";
			
			//masterkey = 3021e68df9a7200135725c6331369a22;
			
			if( ($login == 'admin') && ($password == 'e10adc3949ba59abbe56e057f20f883e') ) {
				//$publickey = $crypto->get_publickey();
				
				$publickey = "somepublickey";
				
				$uid = 5;
							
				$check = MySQLConnect_Class::get_token($uid); 
				if(empty($check)) {
					echo $token;
					
					$token = md5(rand() + $uid);
					
					MySQLConnect_Class::set_token($uid, $token);
					$token = MySQLConnect_Class::get_token($uid);
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
			query template: /index.php?&type=registration&token=cd49f7f7616e5661b97901dc688b4385&devicename=WIN10-PC&secret=7f8e0eb8de4e20c5ddb64b884bf3b9b3
		*/
		function device_reg() {
			if ($this->issetParam("devicename")) $devicename = $this->getParam("devicename");
			if ($this->issetParam("secret")) $secret = $this->getParam("secret");
			if ($this->issetParam("token")) $token = $this->getParam("token");
			
			$uid = MySQLConnect_Class::check_token($token);
			
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
				
				MySQLConnect_Class::close_token($token);
				MySQLConnect_Class::set_device_info($uid, $devicename, $secret);
			}
		}
        
        /*
			<<Time sync>>
			query template: 
		*/
		function get_time() {
            $today = date("Y-m-d H:i:s");
			$plain_data = array('time' => $today);
			$json_data = JSON_class::send_reg_data($plain_data);
			
			echo $json_data;
		}
        
		
        function check_pin( $pin ) {
                   
            $interval1 = date("H:i"); ;
            $nextWeek = time() + (1 * 60);
            $interval2 = date("H:i", $nextWeek);
            echo $interval1;
            echo "<br/>";
            echo $interval2;
            echo "<br/>";
            
           // $date->add(new DateInterval('P0Y0M0DT0H0M30S'));
            
            //$interval2 = $date->format("d.m.Y H:m:s");
            $secret = MySQLConnect_Class::get_device_info("5");
            
            $str = $secret.$interval1;
            $md5_temp = MD5($str);
            
            $md5_temp = Cryptography_Class::magic($md5_temp, 6);
            
         
            echo $md5_temp;
            echo "<br/>";
        }
	}
?>