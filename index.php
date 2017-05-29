<?php

include_once 'config.php';
include_once 'Connection.php';
include_once 'Dispatcher.php';
include_once 'View.php';
include_once 'Controller.php';


$dispatcher = new Dispatcher();
$connection = $dispatcher->getConnection(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
$action = $dispatcher->getAtcion();

$controller = new Controller($connection);

switch ($action) {
    case 'login':
        call_user_func_array([$controller, $action], []);
        break;
    case 'register':
        call_user_func_array([$controller, $action], []);
        break;
    case 'home':
        call_user_func_array([$controller, $action], []);
        break;
    default: call_user_func_array([$controller, 'index'], []);
}
