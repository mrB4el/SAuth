<?php

    class Auth
    {
        function checkAuth($login, $password) 
        {
            // Если нет логина или пароля, возвращаем false
            if(!$login || !$password)   return false;
            
            // Проверяем зарегистрирован ли такой пользователь
            // Подключаемся к СУБД
            connect();
            
            // Составляем строку запроса
            $sql = "SELECT `id` FROM `users` WHERE `login`='".$login."' AND `password`='".$password."'";

            // Выполняем запрос
            $query = mysql_query($sql) or die("<p>Невозможно выполнить запрос: " . mysql_error() . ". Ошибка произошла в строке " . __LINE__ . "</p>");
            
            // Если пользователя с такими данными нет, возвращаем false;
            if(mysql_num_rows($query) == 0) {

                return false;

            }

            // Не забываем закрывать соединение с базой данных

            mysql_close(); 

            // Иначе возвращаем true
            return true;
        }
        
        function check_new_connection()
        {
            if(isset($_SESSION['login']) && $_SESSION['login'] && isset($_SESSION['password']) && $_SESSION['password']) 
            {
                // Если проверка существующих данных завершается неудачей
                if(!checkAuth($_SESSION['login'], $_SESSION['password'])) {
                    // Переадресовываем пользователя на страницу авторизации
                    header('location: login.php');
                    // Прекращаем выполнение скрипта
                    exit;
                }
            }
        }
    }

?>