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
            
            $stmt = $mysqli->prepare("SELECT uid, expired FROM tokens WHERE token = '$token'");
            $stmt->execute();
            $res = $stmt->get_result();
            $row = $res->fetch_assoc();
            
            if($row["expired"] == 0)
            {
                $result = $row["uid"];
            }
            
            return $result;
        }
        
        public function close_token($token)
        {
            $mysqli = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
            $token = mysqli_real_escape_string($mysqli, $token);
            
            $stmt = $mysqli->prepare("UPDATE tokens SET expired=1 WHERE token = '$token'");
            $stmt->execute();
            
        }
        
        public function set_token($uid, $name, $value)
        {
            $mysqli = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
            
            $uid = mysqli_real_escape_string($mysqli, $uid);
            $name = mysqli_real_escape_string($mysqli, $name);
            $value = mysqli_real_escape_string($mysqli, $value);
                             
            if($mysqli->query("INSERT into 'TOKEN_BASE' (uid, name, token, expired) VALUES ('$uid', $name', '$value', '0')")){
                printf("%d строк вставлено.\n", mysqli_affected_rows($mysqli));
            }
        }
        
        public function get_token($uid)
        {
            $mysqli = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
            
            $stmt = $mysqli->prepare("SELECT name, token FROM tokens WHERE uid = '$uid'");
            $stmt->execute();
            $res = $stmt->get_result();
            $row = $res->fetch_assoc();
            
            return $row["token"];
        }
        
        public function set_device_info($uid, $devicename, $secret)
        {
            $mysqli = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
            
            $uid = mysqli_real_escape_string($mysqli, $uid);
            $devicename = mysqli_real_escape_string($mysqli, $devicename);
            $secret = mysqli_real_escape_string($mysqli, $secret);
            
            //$uid = intval($uid);
            
            $stmt = $mysqli->prepare("INSERT into devices (uid, devicename, hash) VALUES ('$uid', '$devicename', '$secret')");
            $stmt->execute();
        }
        
        public function get_device_info($uid)
        {
            $mysqli = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
            
            $uid = mysqli_real_escape_string($mysqli, $uid);
            
            $stmt = $mysqli->prepare("SELECT hash FROM devices WHERE uid = '$uid'");
           
            $stmt->execute();
            $res = $stmt->get_result();
            $row = $res->fetch_assoc();
            
            return $row["hash"];
        }
    }
    
    /*
        $internal_MySQL->check_connect();
        $internal_MySQL->set_token("test", "123456");
        $res = $internal_MySQL->get_token(1);
 
        
        $res = $internal_MySQL->get_device_info(1);
    */
?>