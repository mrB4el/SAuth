<?php
    //<errors>
	ini_set('error_reporting', E_ALL);
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	//</errors>
    require 'engine/template.php';
    require 'engine/MySQL_Class.php';
    require 'config.php';
    require 'api/API.php';
    
    $mysql = new MySQL_Class();
    
    $error = array(
        'title' => "Ошибка такая-то",
        'content' => "Косяк в том-то"
    );
        
    $main = array(
        'name' => "user",
        'surname' => "userov"
    );
        
    $tpl->main = $main;
    
    $tpl->title = $config["title"];
    
    
    
    $do = "main";
    
    //Получаемые параметры
	if ($api->issetParam("do")) $do = $api->getParam("do");
			
	//Кухня
    if($do == "main") {
        $tpl->content = $tpl->render('main');
    }
	if($do == "login") {
		$tpl->content = $tpl->render('login');
	}
    
    if($do == "registration") {
		$tpl->content = $tpl->render('register');
        
        $type = "user_registration";
        
        if ($api->issetParam("type")) $type = $api->getParam("type");
        
        
        // /index.php?do=registration&type=user_registration&login=mrB4el&password1=123456&password2=123456
        if($type == "user_registration") {
            $login = "Guest";
            $password1 = "";
            $password2 = "";
            
            if ($api->issetParam("login")) $login = $api->getParam("login");
            //сделать проверку логина
            if ($api->issetParam("password1")) $password1 = $api->getParam("password1");
            if ($api->issetParam("password2")) $password2 = $api->getParam("password2");
            
            if ($password1 == $password2)
            {
                $mysql->register($login, $password1, "admin@admin.com");
                echo 'success';
            }
            else {
                $error['title'] = "Ошибка с паролями";
                $error['content'] = "Пароли не совпадают";
                $tpl->error = $error;
                $tpl->system_messages = $tpl->render('error');
            }
        }
        // /index.php?do=registration&type=device_registration&login=mrB4el&password=e10adc3949ba59abbe56e057f20f883e
        if($type == "device_registration") {
        
            $tpl->content = $tpl->render('register');
            $type = "user_registration";
            
            if ($api->issetParam("type")) $type = $api->getParam("type");
            if ($api->issetParam("login")) $login = $api->getParam("login");
                //сделать проверку логина
            if ($api->issetParam("password")) $password = $api->getParam("password");
            
            $uid = $mysql->check_login($login, $password);
            if($uid == 0)
            {
                $error['title'] = "Ошибка с профилем";
                $error['content'] = "Такой пары пользователь/пароль не существует";
                $tpl->error = $error;
                $tpl->system_messages = $tpl->render('error');
            }
            else {
                $qr_url = $api->token_generate($login, $password);
                
                $qr_url = base64_encode($qr_url);
                
                //$qr_url = "<img src=\"qr/index.php?cont=".$qr_url.".svg\" class=\"QR\"/>";
               
                $qr_url = "<object data=\"qr/index.php?cont=".$qr_url.".svg\" type=\"image/svg+xml\"></object>">

                
                $tpl->device_registration = $qr_url;
                
            }
            $tpl->content = $tpl->render('device_registration');
        }
        
	}

    echo $tpl->render('index');
    
?>