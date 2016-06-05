<?php
    //$privatekey = file_get_contents('private.key');
    //$publickey = file_get_contents('public.key');
    
            
    class CryptoConfig
    {
        static $publickey_path = "public.pem";
        static $privatekey_path = "private.pem";
        static $passphrase = "FD2534r1";
        
        function get_value($name = 0)
        {
            return $name;
        }
    }
         
    class Cryptography_Class
    {              
        function generate_keypair()
        {
            $config = new CryptoConfig();
            $rsa = new Crypt_RSA();
            
            $rsa->setPrivateKeyFormat(CRYPT_RSA_PRIVATE_FORMAT_PKCS1);
            $rsa->setPublicKeyFormat(CRYPT_RSA_PUBLIC_FORMAT_PKCS1);
            
            extract($rsa->createKey());
            file_put_contents($config->publickey_path, $publickey);
            file_put_contents($config->privatekey_path, $privatekey); 
             
        }    
        
        static function encrypt($plaintext)
        {
            $config = new CryptoConfig();
            
            $fp = fopen("public.pem" ,"r");
		    $pub_key=fread ($fp,8192);
            fclose($fp);

            $PK="";
            $PK=openssl_get_publickey($pub_key);

            openssl_public_encrypt($plaintext, $ciphertext, $PK, 1);
            return $ciphertext;
        }
        
        static function decrypt($ciphertext)
        {
            $config = new CryptoConfig();
            
            $fp=fopen("private.pem","r");
            $priv_key=fread($fp,8192);
            fclose($fp);
            
            //$passphrase = $config->passphrase;
            $res = openssl_get_privatekey($priv_key, "FD2534r1");
           
            openssl_private_decrypt($ciphertext, $plaintext, $res, 1);
            
            
            /*$output = '';
            for ($i = 0, $j = count($plaintext); $i < $j; ++$i) {
                $output .= chr($plaintext[$i]);
            }*/
            //$plaintext = mb_convert_encoding($plaintext, 'utf-8');
            
            return $plaintext;
        }
        
        static function get_publickey()
        {
            $config = new CryptoConfig();
            return file_get_contents($config->publickey_path);
        }
        static function magic($MD5hash, $size)
		{
			$result = "";

            $MD5hash = str_replace("a", "1", $MD5hash);
			$MD5hash = str_replace("b", "2", $MD5hash);
			$MD5hash = str_replace("c", "3", $MD5hash);
			$MD5hash = str_replace("d", "4", $MD5hash);
			$MD5hash = str_replace("e", "5", $MD5hash);
			$MD5hash = str_replace("f", "6", $MD5hash);
			$MD5hash = str_replace("g", "7", $MD5hash);
			
			$size = -1*$size;
			$result = substr($MD5hash, $size); 
			
            return $result;
		}
    }
/*
    $crypto->generate_keypair();
    
    $plaintext = 'kek';
    echo $plaintext;
    echo "\n";
     
    $ciphertext = $crypto->encrypt($plaintext);
    echo $ciphertext;
    echo "\n";
     
    $newplaintext = $crypto->decrypt($ciphertext);
    echo $newplaintext;
    echo "\n";
	
	echo $crypto->get_publickey();
    echo "\n";
*/
//$crypto = new CryptoClass();
//$crypto->generate_keypair();
?>