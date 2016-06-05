<?php
include('lib/full/qrlib.php');

if(isset($_GET["cont"])){
	$val = $_GET["cont"];
	
	$val = base64_decode($val);
	
	
	$svgCode = QRcode::png($val); 
     
    echo $svgCode; 
}
?>