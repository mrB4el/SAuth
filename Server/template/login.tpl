<div class="block login">
     <form method="POST" action="index.php">
            <input name="do" value="login" type="hidden"/>
            <input name="type" value="user_login" type="hidden"/>
            
            Заполняем поля для передачи информации:
            <br/><br/>
            Логин: <input name="login" type="text" maxlength="20" size="15" placeholder="Ваш логин"/>
            <br/><br/> 
            Пароль: <input name="password" type="text" maxlength="20" size="15" placeholder="Ваш пароль"/>
            <br/><br/> 
   
            <input type="submit" value="Передать информацию" />
     </form>
</div>