<?php
    include 'api/Cryptography_Class.php';
    include 'api/API.php';
    
    if (API::issetParam("ciphertext")) $ciphertext = API::getParam("ciphertext");
    //echo $ciphertext;
    //echo "<br/><br/><br/>";    
    
    //$ciphertext = base64_decode($ciphertext);
    $ciphertext = hex2bin($ciphertext);
    
    echo "Original cipher: ".$ciphertext;
    echo "<br/><br/><br/>";
    
    //echo $ciphertext;
    //echo "<br/><br/><br/>";
      
    //N/7kieYygJBaCZGfiM/lBCNUOrIR6dyfczVV66X9jKxx4zrCpW0zw8eX24jAbSl238JOqVEDIH+dp4B13QrXvV+newHSSGe83gf7ReGSqe+enz1ExuHWCTm/KCYw2Dy/onwPaX/YmK64UCmcwC+lYU6dbDqr/opXdaE7TQB0ces=
    
    //EWBgJfzaXRG03fd+fcxjI3VXfyAJD/pD+1q9WV1RKIxFHP85LA5RxvisPpTD1RQ4lpUYOUH1+5SepcaIgp9g4+x8GL+RxosbuegdUYivnBbYd18oZATNNjdjfzykWQ64PIMQxLL0Z67rELkv8zgYyQ7+uHlZCil/rhhoTouLsjY=
    
    $plaintext = Cryptography_Class::decrypt($ciphertext);
    //$plaintext = implode("UTF-8", $plaintext);
    
    echo "Decoded cipher: ".$plaintext;
    echo "<br/><br/><br/>";
    //print_r($plaintext);
    //echo "<br/><br/><br/>";
    
    $test = Cryptography_Class::encrypt("Hello kitty");
    echo "Encoded: ".$test;
    echo "<br/><br/><br/>";
    
    $test = Cryptography_Class::decrypt($test);
    echo "Decoded: ".$test;
    echo "<br/><br/><br/>";
?>