<?php
include('lib/full/qrlib.php');

if(isset($_GET["cont"])){
	$val = $_GET["cont"];
	
	$val = base64_decode($val);
	
	
	$svgCode = QRcode::svg($val); 
     
    echo $svgCode; 
}
?>