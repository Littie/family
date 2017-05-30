<?php

session_start();

include_once 'config.php';
include_once 'Connection.php';
include_once 'Dispatcher.php';
include_once 'View.php';
include_once 'Controller.php';


$dispatcher = new Dispatcher();
$connection = $dispatcher->getConnection(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
$action = $dispatcher->getAction();

$controller = new Controller($connection, $dispatcher);

$dispatcher->callController($controller, $action);

