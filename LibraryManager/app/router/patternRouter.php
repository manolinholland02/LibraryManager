<?php

class PatternRouter
{
    private $routes;
    private static $instance = null;

    private function __construct($routes)
    {
        $this->routes = $routes;
    }

    //Имплементирам сингелтон за рутера, защото ми трябва само 1 инстанция на рутера в целия проект
    public static function getInstance($routes)
    {
        if (self::$instance === null) {
            self::$instance = new self($routes);
        }
        return self::$instance;
    }

    //Метода е прайвет, за да спазя сингелтона
    private function __clone()
    {
    }

    //Полувавам предупреждение, че метода трябва задължително да е публичен, затова го правя публичен и хвърлам ексепшън ако се калне
    public function __wakeup()
    {
        throw new \Exception("Cannot unserialize a Singleton.");
    }

    //Метод за рутиране на заявка
    public function route($uri)
    {
        $uri = $this->stripParameters($uri);
        $segments = explode('/', $uri);

        // Въртя през всеки сегмент на URI-то, за да намеря съвпадащия раут
        $route = $this->routes;
        foreach ($segments as $segment) {
            if (isset($route['children'][$segment])) {
                $route = $route['children'][$segment];
            } else if (isset($route[$segment])) {
                $route = $route[$segment];
            } else {
                // Няма съвадение, няма раут
                $this->handle404();
            }
        }
        
        $controllerName = $route['controller'];
        $methodName = isset($route['method']) ? $route['method'] : 'index';

        $filename = __DIR__ . '/../controllers/' . $controllerName . '.php';

        //Проверка дали съществъва такъв файл (за контролера)
        if (file_exists($filename)) {
            require($filename);
            try {
                $controllerObj = new $controllerName();
                $controllerObj->$methodName();
            } catch (Error $e) {
                echo "Failed to execute $methodName in $controllerName: " . $e->getMessage();
                http_response_code(500);
                exit;
            }
        } else {
            //Няма файл - 404
            $this->handle404();
        }
    }

    private function stripParameters($uri)
    {
        if (str_contains($uri, '?')) {
            $uri = substr($uri, 0, strpos($uri, '?'));
        }
        return $uri;
    }

    private function handle404()
    {
        http_response_code(404);
        //Отива към къстъм 404 страница, която направих
        require_once(__DIR__ . '/../views/errors/404.php');
        exit;
    }
}
