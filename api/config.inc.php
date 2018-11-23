<?php

//Defining constants
############################
## Develop BY:SURAJ KUMAR MAURYA
############################

if ($_SERVER['HTTP_HOST'] == 'localhost') {
    $host_name = 'localhost';
    $host_username = 'root';
    $host_password = '';
    $host_dbname = 'slimapi';
    $base_url = 'http://localhost/tutorials/slim3.0-for-api/';
    $base_path = 'D:\xampp\htdocs\tutorials\slim3.0-for-api/';
} else {
    //put here server details
    $host_name = 'localhost';
    $host_username = 'root';
    $host_password = '';
    $host_dbname = 'slimapi';
    $base_url = 'http://localhost/tutorials/slim3.0-for-api/';
    $base_path = 'D:\xampp\htdocs\tutorials\slim3.0-for-api/';
}

define('MYSQL_HOSTNAME', $host_name);
define('MYSQL_USERNAME', $host_username);
define('MYSQL_PASSWORD', $host_password);
define('MYSQL_DATABASE', $host_dbname);

define('BASE_URL', $base_url);
define('BASE_PATH', $base_path);
define('API_URL', BASE_URL . 'api/');
define('API_PATH', BASE_PATH . 'api/');
define('UPLOADS_URL', BASE_URL . 'uploads/');
define('UPLOADS_PATH', BASE_PATH . 'uploads/');

define('STATUS_OK', 200);
define('STATUS_BAD_REQUEST', 400);
define('STATUS_UNAUTHORIZED', 401);
define('STATUS_CONFLICT', 409);
define('STATUS_INTERNAL_SERVER_ERROR', 500);

?>