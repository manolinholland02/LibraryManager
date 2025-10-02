<?php
require_once(__DIR__ . '/../models/library.php');
require_once(__DIR__ . '/../router/patternRouter.php');
session_start();

$uri = trim($_SERVER['REQUEST_URI'], '/');


//Всички раутове на проекта
$routes = [
    'home' => [
        'controller' => 'libraryController',
        'method' => 'index',
        'children' => [
            'search' => [
                'controller' => 'libraryController',
                'method' => 'search',
            ]
        ]
    ],
    'search' => [
        'controller' => 'libraryController',
        'method' => 'search'
    ],
    'literaryWork' => [
        'controller' => 'literaryWorkController',
        'method' => 'index',
        'children' => [
            'add' => [
                'controller' => 'literaryWorkController',
                'method' => 'addLiteraryWork',
            ],
            'delete' => [
                'controller' => 'literaryWorkController',
                'method' => 'deleteLiteraryWork',
            ]
        ]
    ],
    'libraryUser' => [
        'controller' => 'libraryUserController',
        'method' => 'index',
        'children' => [
            'add' => [
                'controller' => 'libraryUserController',
                'method' => 'addLibraryUser',
            ],
            'delete' => [
                'controller' => 'libraryUserController',
                'method' => 'deleteLibraryUser',
            ],
            'borrow' => [
                'controller' => 'libraryUserController',
                'method' => 'borrowWork',
            ],
            'return' => [
                'controller' => 'libraryUserController',
                'method' => 'returnWork',
            ]
        ]
    ]
];

//Викане на сингелтон рутера
$router = PatternRouter::getInstance($routes);
$router->route($uri);