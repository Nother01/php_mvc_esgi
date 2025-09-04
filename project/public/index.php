<?php

require_once __DIR__ . '/../app/Controllers/UserController.php';
require_once __DIR__ . '/../app/Controllers/TaskController.php';

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = rtrim($uri, '/');
$uri = $uri ?: '/';

switch ($uri) {
    case '/':
    case '/login':
        $controller = new UserController();
        $controller->login();
        break;
    default:
        http_response_code(404);
        echo "Page non trouvée";
        break;
}