<?php
    class JSON_class
    {
        function get_reg_data($json_data)
        {
            $obj = json_decode($json_data, true);
            return $obj;
        }
        function send_reg_data($plain_data)
        {
            $json_data = json_encode($plain_data);
            return $json_data;
        }
    }
   
    
    //$json_data = '{"foo-bar": 12345, "fu-bar": 123456}';
    //$obj = $json->get_reg_data($json_data);
    
    //$plain_data = array('a' => 1, 'b' => 2, 'c' => 3, 'd' => 4, 'e' => 5);
    //$json_data = $json->send_reg_data($plain_data);
?>