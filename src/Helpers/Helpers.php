<?php
if (!function_exists('get_config')) {
    function get_config($config_name)
    {
        $base_path = str_replace('Helpers', '', __DIR__);
        $path = "{$base_path}Config" . DIRECTORY_SEPARATOR . "{$config_name }.php";

        return require_once $path;
    }
}

if (!function_exists('base_url')) {
    function base_url(){
        if(isset($_SERVER['HTTPS'])){
            $protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
        }
        else{
            $protocol = 'http';
        }
        return $protocol . "://" . $_SERVER['HTTP_HOST'];
    }
}