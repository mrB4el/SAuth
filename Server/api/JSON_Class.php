<?php
    class JSON_class
    {
        static function get_reg_data($json_data)
        {
            $obj = json_decode($json_data, true);
            return $obj;
        }
        static function send_reg_data($plain_data)
        {
            $json_data = json_encode($plain_data);
            return $json_data;
        }
    }
?>