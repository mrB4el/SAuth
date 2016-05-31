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
            
            $res = true;
            
            if ($mysqli->connect_errno) {
                echo "Не удалось подключиться к MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
                $res = false;
            }
            return $res;    
        }    
    
        public function set_token($name, $value)
        {
            $mysqli = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
            
            $name = mysqli_real_escape_string($mysqli, $name);
            $value = mysqli_real_escape_string($mysqli, $value);
                             
            if($mysqli->query("INSERT into 'TOKEN_BASE' (name, token) VALUES ('$name', '$value')")){
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
        
        public function set_device_info($name, $uid, $hash)
        {
            $mysqli = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
            
            $uid = mysqli_real_escape_string($mysqli, $uid);
            $name = mysqli_real_escape_string($mysqli, $name);
            $hash = mysqli_real_escape_string($mysqli, $hash);
                             
            if($mysqli->query("INSERT into devices (uid, name, hash) VALUES ('$uid', '$name', '$hash')")){
                printf("%d строк вставлено.\n", mysqli_affected_rows($mysqli));
            }
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