<?php

session_start();

include_once 'config.php';
include_once 'Core/Connection.php';
include_once 'Core/Dispatcher.php';
include_once 'Core/View.php';
include_once 'Core/Controller.php';


$dispatcher = new Dispatcher();
$connection = $dispatcher->getConnection(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
$action = $dispatcher->getAction();

$controller = new Controller($connection, $dispatcher);

$dispatcher->callController($controller, $action);

