<?php

    class API
    {
        static function issetParam($name) {
            return isset($_GET[$name]) || isset($_POST[$name]);
        }
        static function getParam($name, $defaultValue = "") {
            return isset($_POST[$name]) ? $_POST[$name] : (isset($_GET[$name]) ? $_GET[$name] : $defaultValue);
        }      
    }
?>