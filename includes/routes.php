<?php

$routes = [
    '' => [
        'GET' => [
            'controller' => 'HomeController',
            'action' => 'home',
        ],
    ],
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
