<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
		<meta charset="utf-8">
		<meta name="viewport" content="initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="description" content="Two-factor-authentication">
        <title> <?=$this->title?> </title>
    </head>

    <body>

        <center>Hello <?=$this->main['name']?> <?=$this->main['surname']?>!</center>

        <form method="POST" action="api/index.php">
        <input name="type" value="token_generate" type="hidden"/>
        
        Заполняем поля для передачи информации:
        <br><br>
        Логин: <input name="login" type="text" maxlength="20" size="25" value="admin" />
        <br><br> 
        Пароль: <input name="password" type="text" maxlength="2" size="3" value="e10adc3949ba59abbe56e057f20f883e" />
        <br><br> 
        
        
        <input type="submit" value="Передать информацию">
        </form>
        
    </body>
</html>