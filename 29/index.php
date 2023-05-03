<?php

require_once 'includes/common.php';

$routes = [
    'users' => [
        'GET' => 'list'
    ]
];

$uri = $_SERVER['REQUEST_URI'];
$requestMethod = $_SERVER['REQUEST_METHOD'];

$requestedRoute = substr_replace($uri, '', 0, strlen(SITE_FOLDER.'/'));
$controllerClass = 'App\\Controllers\\'.ucfirst(
    substr_replace($requestedRoute, '', strlen($requestedRoute) - 1, 1)
).'Controller';
$action = $routes[$requestedRoute][$requestMethod] ?? null;

if (null !== $action) {
    $controller = new $controllerClass;
    $controller->{$action}();

    exit;
}

redirectIfNotLogged();

$error = isset($_GET['error']) ? $_GET['error'] : '';
$message = isset($_GET['message']) ? $_GET['message'] : '';

include 'views/home.html.php';
