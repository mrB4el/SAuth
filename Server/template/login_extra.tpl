<div class="login">
     <h1>Авторизация пользователя</h1>
     <div class="text">Просто введите ваш логин и ПИН-код</div>
     
     <div class="contblock">
        <form method="POST">
                <input name="do" value="login" type="hidden"/>
                <input name="type" value="device_login" type="hidden"/>
                
                <input name="login" type="text" maxlength="20" size="15" placeholder="Ваш логин"/>
                <input name="pin" type="text" maxlength="20" size="15" placeholder="PIN 6 цифр"/> 
                
                <input class="next_but" type="submit" value="Передать информацию" />
        </form>
     </div>
</div>
