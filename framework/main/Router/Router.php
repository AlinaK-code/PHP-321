<?php

namespace main\Router;

use main\Router\IncludePages;

class Router
{
    private static $patterns = [
        '~^$~' => [IncludePages::class, 'main'],       // http://localhost/
        '~^/$~' => [IncludePages::class, 'main'],       // http://localhost/
        '~^edit/(\d+)$~' => [IncludePages::class, 'edit'],       // http://localhost/ed
        '~^delete/(\d+)$~' => [IncludePages::class, 'delete'],       // http://localhost/delete/123
        '~^deleteComment/(\d+)$~' => [IncludePages::class, 'deleteComment'],       // http://localhost/deleteComment/123
        '~^articles/(\d+)$~' => [IncludePages::class, 'viewArticle'],       // http://localhost/articles/123
    ];

    public function onRoute()
    {
        // Получаем текущий маршрут из .htaccess
        if (isset($_GET['route'])) {
            $route = trim($_GET['route'], '/');
        } else {
            $route = trim($_SERVER['REQUEST_URI'], '/');
        }
        $findRoute = false;

        foreach (self::$patterns as $pattern => $controllerAndAction) {
            if (preg_match($pattern, $route, $matches)) {
                $findRoute = true; // для выхода из цикла и подтверждения что маршрут найден
                unset($matches[0]);// удаляет первый элемент массива
                $action = $controllerAndAction[1]; // sayHello
                $controller = new $controllerAndAction[0];// main\Models\Page\Window
                $controller->$action(...$matches);
                break;
            }
        }
        if (!$findRoute) {
            header("HTTP/1.1 404 Страница не найдена");
            (new IncludePages())->error404();
            exit();
        }
    }
}