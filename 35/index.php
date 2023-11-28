<?php

use App\Controllers\HomeController;

require_once __DIR__.'/vendor/autoload.php';
require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/routes.php';
require_once __DIR__.'/core/includes/functions.php';

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

$controller = new HomeController;
$controller->notFound();
