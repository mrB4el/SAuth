<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
		<meta charset="utf-8">
		<meta name="viewport" content="initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="description" content="Two-factor-authentication">
        <title><?=$this->title?></title>
        <link rel="stylesheet" href="/template/styles.css"/>
    </head>

    <body>
        <center>Hello <?=$this->main['name']?> <?=$this->main['surname']?>!</center>
        <?=$this->system_messages?>
        <?=$this->content?>
        <?=$this->login?>
        <?=$this->device_registration?>
    </body>
</html>