<?php
/*
echo '<pre>';
var_export($_SERVER);
die();
echo '</pre>';
*/
require './vendor/autoload.php';
$dotenv = \Dotenv\Dotenv::create(__DIR__);
$dotenv->load();
$router = require './src/Routes/index.php';
