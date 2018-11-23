<?php

date_default_timezone_set("Asia/Kolkata");
header('Content-Type: application/json');

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require_once 'vendor/autoload.php';
require_once "config.inc.php";
require_once "models/Database.php";
require_once "controllers/common.php";
require_once "controllers/user.php";

$app = new \Slim\App;

$app->get('/', function ($request, $response, $args) {
    sendResponse(array(), STATUS_OK, 'Welcome');
});

$app->post('/postSignup', function ($request, $response, $args) {
    openRequest($request, $response, $args, 'postSignup');
});

$app->post('/postLogin', function ($request, $response, $args) {
    openRequest($request, $response, $args, 'postLogin');
});

$app->get('/getProfile', function ($request, $response, $args) {
    tokenRequest($request, $response, $args, 'getProfile');
});

$app->run();
