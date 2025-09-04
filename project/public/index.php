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
        
    case '/register':
        $controller = new UserController();
        $controller->register();
        break;

    case '/logout':
        $controller = new UserController();
        $controller->logout();
        break;
        
    case '/tasks':
        $controller = new TaskController();
        $controller->index();
        break;
        
    default:
        $parts = explode('/', trim($uri, '/'));
        
        if (count($parts) == 3 && $parts[0] == 'tasks') {
            $action = $parts[1];
            $id = $parts[2];
            
            if (is_numeric($id)) {
                $controller = new TaskController();
                
                if ($action == 'edit') {
                    $controller->edit($id);
                } elseif ($action == 'delete') {
                    $controller->delete($id);
                } else {
                    http_response_code(404);
                    echo "Page non trouvée";
                }
            } else {
                http_response_code(404);
                echo "Page non trouvée";
            }
        } else {
            http_response_code(404);
            echo "Page non trouvée";
        }
        break;
}