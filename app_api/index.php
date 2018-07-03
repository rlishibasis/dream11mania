<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require 'vendor/autoload.php';
require './src/config/config.php';

$con = connectdb();

$app = new \Slim\App;

//Admin
require('./src/routes/admin.php');

//User Routes
require('./src/routes/user.php');

$app->run();