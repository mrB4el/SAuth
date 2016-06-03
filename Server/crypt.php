<?php
    include 'api/Cryptography_Class.php';
    include 'api/API.php';
    
    if (API::issetParam("ciphertext")) $ciphertext = API::getParam("ciphertext");
    echo $ciphertext;
    echo "<br/><br/><br/>";    
    
    $ciphertext = base64_decode($ciphertext);
    echo $ciphertext;
    echo "<br/><br/><br/>";
      
    //N/7kieYygJBaCZGfiM/lBCNUOrIR6dyfczVV66X9jKxx4zrCpW0zw8eX24jAbSl238JOqVEDIH+dp4B13QrXvV+newHSSGe83gf7ReGSqe+enz1ExuHWCTm/KCYw2Dy/onwPaX/YmK64UCmcwC+lYU6dbDqr/opXdaE7TQB0ces=
    
    $plaintext = Cryptography_Class::decrypt($ciphertext);
    echo $plaintext;
    echo "<br/><br/><br/>";
?>