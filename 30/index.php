<?php

require_once 'includes/common.php';

$routes = [
    'create-user' => [
        'GET' => [
            'controller' => 'UserController',
            'action' => 'createForm',
        ],
        'POST' => [
            'controller' => 'UserController',
            'action' => 'create',
        ],
    ],
    'users' => [
        'GET' => [
            'controller' => 'UserController',
            'action' => 'list',
        ],
    ],
    'update-user' => [
        'GET' => [
            'controller' => 'UserController',
            'action' => 'updateForm',
        ],
        'POST' => [
            'controller' => 'UserController',
            'action' => 'update',
        ],
    ],
    'delete-user' => [
        'GET' => [
            'controller' => 'UserController',
            'action' => 'delete',
        ],
    ],
    'send-message' => [
        'GET' => [
            'controller' => 'MessageController',
            'action' => 'sendForm',
        ],
        'POST' => [
            'controller' => 'MessageController',
            'action' => 'send',
        ],
    ],
    'messages' => [
        'GET' => [
            'controller' => 'MessageController',
            'action' => 'list',
        ],
    ],
    'hide-message' => [
        'GET' => [
            'controller' => 'MessageController',
            'action' => 'hide',
        ],
    ],
    'register' => [
        'GET' => [
            'controller' => 'AuthController',
            'action' => 'registerForm',
        ],
        'POST' => [
            'controller' => 'AuthController',
            'action' => 'register',
        ],
    ],
    'login' => [
        'GET' => [
            'controller' => 'AuthController',
            'action' => 'loginForm',
        ],
        'POST' => [
            'controller' => 'AuthController',
            'action' => 'login',
        ],
    ],
    'logout' => [
        'GET' => [
            'controller' => 'AuthController',
            'action' => 'logout',
        ],
    ],
    'confirm' => [
        'GET' => [
            'controller' => 'AuthController',
            'action' => 'confirm',
        ],
    ],
];

$uri = $_SERVER['REQUEST_URI'];
$requestMethod = $_SERVER['REQUEST_METHOD'];

$requestedRoute = substr_replace($uri, '', 0, strlen(SITE_FOLDER.'/'));
$requestedRoute = explode('?', $requestedRoute);
$requestedRoute = $requestedRoute[0];

$controllerClass = 'App\\Controllers\\'.($routes[$requestedRoute][$requestMethod]['controller'] ?? null);
$action = $routes[$requestedRoute][$requestMethod]['action'] ?? null;

if (null !== $action) {
    $controller = new $controllerClass;
    $controller->{$action}();

    exit;
}

redirectIfNotLogged();

$error = isset($_GET['error']) ? $_GET['error'] : '';
$message = isset($_GET['message']) ? $_GET['message'] : '';

include 'views/home.html.php';
