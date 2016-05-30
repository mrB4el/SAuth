<?php
	//<errors>
	ini_set('error_reporting', E_ALL);
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	//</errors>
	
	define ("DBHOST", "localhost"); 
	define ("DBNAME", "2step");
	define ("DBUSER", "2step");
	define ("DBPASS", "123456");  
	
	
	//includes
	
		
	class SetMode{
		
		private $mode = '0';
		
		function set_Mode( $type = 'lol', $debug = FALSE ){
			
			if( $type == 'set' ){ 
				$this->mode = 0; 
			} elseif( $type == 'get' ){ 
				$this->mode = 1; 
			} else { 
				echo'<br/>Uncorrect mode type<br/>'; 
			}

			//Debug Mode
			if( $debug ) 
				echo '<br/>'. __FUNCTION__.' executed, result:<br/> mode: '.$this->mode.'<br/> type: '.$type;
		}
		
		function check_Mode( $debug = FALSE ){
			
			//Debug Mode
			if( $debug ) 
				echo '<br/>'. __FUNCTION__.' executed, result: '.$this->mode.'<br/>';
		}
	}

	$setMode = new SetMode;

	
	$type = 'set';

	//Получаемые параметры
	if (isset($_GET["type"])) $type = $_GET['type'];
	if (isset($_GET["token"])) $type = $_GET['token'];
	
	$setMode->set_Mode($type, FALSE);
	$setMode->check_Mode(FALSE);
	
	$mysqli = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
    
	if ($mysqli->connect_errno) {
        echo "Не удалось подключиться к MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    }
	
	include 'MySQLConnect_Class.php';
	
	$result = new Result( $mysqli, array('ss', $login, $pass), array('count'), "SELECT COUNT(`id`) FROM `users` WHERE `login` = ? AND `password` = ?" );
    $field = $result->getResult();
	
?>
