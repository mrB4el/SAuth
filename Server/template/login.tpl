<div class="">
     <form method="POST" action="api/index.php">
            <input name="type" value="token_generate" type="hidden"/>
            
            Заполняем поля для передачи информации:
            <br/><br/>
            Логин: <input name="login" type="text" maxlength="20" size="15" placeholder="Ваш логин"/>
            <br/><br/> 
            Пароль: <input name="password" type="text" maxlength="20" size="15" placeholder="Ваш пароль"/>
            <br/><br/> 
            
            
            <input type="submit" value="Передать информацию" />
     </form>
</div>