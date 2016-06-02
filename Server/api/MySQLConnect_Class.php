<?php
	define ("DBHOST", "localhost"); 
	define ("DBNAME", "2step");
	define ("DBUSER", "2step");
	define ("DBPASS", "123456");
    
    define ("TOKEN_BASE", "tokens"); 
    
    
    class internal_MySQL
    {
        public function check_connect(){
            $mysqli = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
            
            $result = true;
            
            if ($mysqli->connect_errno) {
                echo "Не удалось подключиться к MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
                $result = false;
            }
            return $result;    
        }    
        
        public function check_token($token)
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
        
        public function close_token($token)
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
        
        public function set_token($uid, $token)
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
        
        public function get_token($uid)
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
        
        public function set_device_info($uid, $devicename, $secret)
        {
            $mysqli = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
            
            $uid = mysqli_real_escape_string($mysqli, $uid);
            $devicename = mysqli_real_escape_string($mysqli, $devicename);
            $secret = mysqli_real_escape_string($mysqli, $secret);
            
            //$uid = intval($uid);
            
            $query = "INSERT into devices (uid, devicename, hash) VALUES ('$uid', '$devicename', '$secret')";
            
            if($query = $mysqli->prepare($sql)){
                $query->execute();
            }else{
                var_dump($mysqli->error);
            }
            
        }
        
        public function get_device_info($uid)
        {
            $result = "0";
            
            $mysqli = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
            
            $uid = mysqli_real_escape_string($mysqli, $uid);
            
            $query = "SELECT hash FROM devices WHERE uid = '$uid'";
            
            if($query = $mysqli->prepare($sql)){
                $query->execute();
                $res = $query->get_result();
                $row = $res->fetch_assoc();
                $result = $row["hash"];
            }else{
                var_dump($mysqli->error);
            }
            

            
            return $result;
        }
    }
    
    /*
        $internal_MySQL->check_connect();
        $internal_MySQL->set_token("test", "123456");
        $res = $internal_MySQL->get_token(1);
 
        
        $res = $internal_MySQL->get_device_info(1);
    */
?>