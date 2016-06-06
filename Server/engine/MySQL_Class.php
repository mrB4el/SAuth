<?php
    class MySQL_Class{  
        function register($username, $password, $email)
        {
            $uid = 0;
            
            $mysqli = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
                
            $password = md5($password);
                
            $username = mysqli_real_escape_string($mysqli, $username);
            $email = mysqli_real_escape_string($mysqli, $email);
            $password = mysqli_real_escape_string($mysqli, $password);  
                            
            $sql = "INSERT into users (username, email, password) VALUES ('$username', '$email', '$password')";
            
            if($query = $mysqli->prepare($sql)){
                $query->execute();
            }else{
                var_dump($mysqli->error);
            }
        }
        function check_login($username, $password)
        {
            $result = "0";
            
            $mysqli = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
                      
            $username = mysqli_real_escape_string($mysqli, $username);
            $password = mysqli_real_escape_string($mysqli, $password);
              
            $sql = "SELECT id FROM users WHERE username = '$username' AND password = '$password'";
            
            if($query = $mysqli->prepare($sql)){
                $query->execute();
                $res = $query->get_result();
                $row = $res->fetch_assoc();
                
                $result = $row["id"];
            }else{
                var_dump($mysqli->error);
            }
            return $result;
        }
        function get_uid($username)
        {
            $mysqli = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
                      
            $username = mysqli_real_escape_string($mysqli, $username);
              
            $sql = "SELECT id FROM users WHERE username = '$username'";
            
            if($query = $mysqli->prepare($sql)){
                $query->execute();
                $res = $query->get_result();
                $row = $res->fetch_assoc();
                
                $result = $row["id"];
            }else{
                var_dump($mysqli->error);
            }
            return $result;
        }
    }
?>