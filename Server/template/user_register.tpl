<div class="registration user">
    <h1>Регистрация пользователя</h1>
    <div class="text">Устаревший подход, но от этого не менее надёжный. Не забудьте повторить пароль дважды.</div>
    <div class="contblock">
        <form method="POST" action="index.php">
            <input name="do" value="registration" type="hidden"/>
            <input name="type" value="user_registration" type="hidden"/>
                Логин: <input name="login" type="text" maxlength="20" size="15" placeholder="Ваш логин"/>
                <br/><br/> 
                Пароль: <input name="password1" type="text" maxlength="20" size="15" placeholder="Ваш пароль"/>
                <br/><br/>
                Пароль: <input name="password2" type="text" maxlength="20" size="15" placeholder="Повторите пароль"/>
                <br/><br/>             
            <input type="submit" value="Передать информацию" />
        </form>
    </div>
</div>