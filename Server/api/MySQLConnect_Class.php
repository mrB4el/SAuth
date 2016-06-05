<?php
	define ("DBHOST", "localhost"); 
	define ("DBNAME", "2step");
	define ("DBUSER", "2step");
	define ("DBPASS", "123456");
    
    define ("TOKEN_BASE", "tokens"); 
    
    
    class MySQLConnect_Class
    {
        static function check_connect(){
            $mysqli = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
            
            $result = true;
            
            if ($mysqli->connect_errno) {
                echo "Не удалось подключиться к MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
                $result = false;
            }
            return $result;    
        }    
        
        static function check_token($token)
        {
            $result = 0;
            
            $mysqli = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
            $token = mysqli_real_escape_string($mysqli, $token);
            
            $sql = "SELECT uid, expired FROM tokens WHERE token = '$token'";
            if($query = $mysqli->prepare($sql)){
                $query->execute();
                $res = $query->get_result();
                $row = $res->fetch_assoc();
                
                if($row["expired"] == 0)
                {
                    $result = $row["uid"];
                }
            }else{
                var_dump($mysqli->error);
            }
            return $result;
        }
        
        static function close_token($token)
        {
            $mysqli = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
            $token = mysqli_real_escape_string($mysqli, $token);

            $sql = "UPDATE tokens SET expired=1 WHERE token = '$token'";
            
            if($query = $mysqli->prepare($sql)){
                $query->execute();
            }else{
                var_dump($mysqli->error);
            }
        }
        
        static function set_token($uid, $token)
        {
            $mysqli = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
            
            $uid = mysqli_real_escape_string($mysqli, $uid);
            $token = mysqli_real_escape_string($mysqli, $token);
                             
            $sql = "INSERT into tokens (uid, token, expired) VALUES ('$uid', '$token', 0)";
            
            if($query = $mysqli->prepare($sql)){
                $query->execute();
            }else{
                var_dump($mysqli->error);
            }
        }
        
        static function get_token($uid)
        {
            $result = "0";
            
            $mysqli = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
                        
            $sql = "SELECT token FROM tokens WHERE uid = '$uid' AND expired = 0";
            
            if($query = $mysqli->prepare($sql)){
                $query->execute();
                $res = $query->get_result();
                $row = $res->fetch_assoc();
                
                $result = $row["token"];
            }else{
                var_dump($mysqli->error);
            }
            return $result;
        }
        
        static function set_device_info($uid, $devicename, $secret)
        {
            $mysqli = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
            
            $uid = mysqli_real_escape_string($mysqli, $uid);
            $devicename = mysqli_real_escape_string($mysqli, $devicename);
            $secret = mysqli_real_escape_string($mysqli, $secret);
            
            //$uid = intval($uid);
            
            $sql = "INSERT into devices (uid, devicename, secret) VALUES ('$uid', '$devicename', '$secret')";
            
            if($query = $mysqli->prepare($sql)){
                $query->execute();
            }else{
                var_dump($mysqli->error);
            }
            
        }
        
        static function get_device_info($uid)
        {
            $result = "0";
            
            $mysqli = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
            
            $uid = mysqli_real_escape_string($mysqli, $uid);
            
            $sql = "SELECT secret FROM devices WHERE uid = '$uid'";
            
            if($query = $mysqli->prepare($sql)){
                $query->execute();
                $res = $query->get_result();
                $row = $res->fetch_assoc();
                $result = $row["secret"];
            }else{
                var_dump($mysqli->error);
            }
            return $result;
        }
       
    }

?>