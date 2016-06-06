<div class="login">
     <h1>Регистрация устройства</h1>
     <div class="text">Введите логин и пароль</div>
     
     <div class="contblock">
        <form method="POST">
                <input name="do" value="registration" type="hidden"/>
                <input name="type" value="device_registration" type="hidden"/>
                <input name="login" type="text" maxlength="20" size="15" placeholder="Ваш логин"/>
                 <input name="password" type="text" maxlength="20" size="15" placeholder="Ваш пароль"/>
                 
                <input class="next_but" type="submit" value="Передать информацию" />
        </form>
     </div>
</div>