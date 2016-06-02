<?php
    //$privatekey = file_get_contents('private.key');
    //$publickey = file_get_contents('public.key');
    
            
    class CryptoConfig
    {
        public $publickey_path = "public.pem";
        public $privatekey_path = "private.pem";
        public $passphrase = "FD2534r1";
        
        function get_value($name = 0)
        {
            return $name;
        }
    }
         
    class CryptoClass
    {
        function execute()
        {
              
        }
              
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
        
        function encrypt($plaintext)
        {
            $config = new CryptoConfig();
            
            $fp = fopen($config->publickey_path ,"r");
		
            $pub_key=fread ($fp,8192);
            fclose($fp);

            $PK="";
            $PK=openssl_get_publickey($pub_key);

            
            openssl_public_encrypt($plaintext,  $cyphertext, $PK);
            
            return $cyphertext;
        }
        
        function decrypt($ciphertext)
        {
            $config = new CryptoConfig();
            $rsa = new Crypt_RSA();
            
            $fp=fopen($config->privatekey_path,"r");
            $priv_key=fread($fp,8192);
            fclose($fp);
            
            $passphrase = $config->passphrase;
            $res = openssl_get_privatekey($priv_key, $passphrase);
           
            openssl_private_decrypt($ciphertext, $plaintext, $res);
                      
            return $plaintext;
        }
        
        function get_publickey()
        {
            $config = new CryptoConfig();
            return file_get_contents($config->publickey_path);
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