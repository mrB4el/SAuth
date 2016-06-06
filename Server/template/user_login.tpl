<div class="login user">
    <h1>Запрос PIN-кода</h1>
    <div class="text">Введите в поле ниже код, который отображается у вас на экране устрйоства.</div>
    <div class="contblock">
        <form method="POST" action="index.php">
            <input name="do" value="login" type="hidden"/>
            <input name="type" value="device_login" type="hidden"/>
            <input name="login" value="<?=$this->ul_login?>" type="hidden"/>
            <input name="password" value="<?=$this->ul_password?>" type="hidden"/>
            
            Введите PIN с устройства:
            <br/><br/>
            PIN: <input name="pin" type="text" maxlength="20" size="15" placeholder="6 цифр"/>            
            
            <input type="submit" value="Передать информацию" />
        </form>
    </div>
</div>