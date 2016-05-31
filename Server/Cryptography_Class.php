<?php
    //$privatekey = file_get_contents('private.key');
    //$publickey = file_get_contents('public.key');
    
    class CryptoConfig
    {
        public $publickey_path = "public.key";
        public $privatekey_path = "private.key";
        
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
            include 'Crypt/RSA.php';
            
            $config = new CryptoConfig();
            $rsa = new Crypt_RSA();
            
            extract($rsa->createKey());
            file_put_contents($config->publickey_path, $publickey);
            file_put_contents($config->privatekey_path, $privatekey); 
        }    
        
        function encrypt($plaintext)
        {
            $config = new CryptoConfig();
            $rsa = new Crypt_RSA();
             
            $publickey = file_get_contents($config->publickey_path);
            $rsa->loadKey($publickey);
            $cyphertext = $rsa->encrypt($plaintext);
            
            return $cyphertext;
        }
        
        function decrypt($ciphertext)
        {
            $config = new CryptoConfig();
            $rsa = new Crypt_RSA();
             
            $privatekey = file_get_contents($config->privatekey_path);
            $rsa->loadKey($privatekey);
            $plaintext = $rsa->decrypt($ciphertext);
            
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
?>