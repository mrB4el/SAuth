<?php
    //<errors>
	ini_set('error_reporting', E_ALL);
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	//</errors>
    require 'engine/template.php';
    require 'config.php';
    
    
    $tpl = Tpl::instance(array(
        // путь к папке с шаблонами
        'dir' => './template',
        // расширение файлов шаблонов
        'ext' => 'tpl',
    ));
    $main = array(
        'name' => "user",
        'surname' => "userov"
    );
        
    $tpl->main = $main;
    
    $tpl->title = $config["title"];
    
    
    echo $tpl->render('main');
?>