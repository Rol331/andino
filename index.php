<?php
// Punto de entrada principal de la aplicación
session_start();

// Configuración de la aplicación
define('APP_NAME', 'EduFix');
define('APP_VERSION', '1.0.0');
define('BASE_URL', 'http://localhost/cole/');

// Incluir archivos de configuración
require_once 'config/database.php';
require_once 'config/config.php';

// Incluir clases principales
require_once 'app/controllers/Controller.php';
require_once 'app/models/Model.php';
require_once 'app/views/View.php';

// Router simple
$request = $_SERVER['REQUEST_URI'];
$path = parse_url($request, PHP_URL_PATH);
$path = str_replace('/cole/', '', $path);

// Debug del enrutamiento
error_log("Request URI: " . $request);
error_log("Parsed path: " . $path);

// Rutas de la aplicación
$routes = [
    '' => 'HomeController@index',
    'home' => 'HomeController@index',
    'about' => 'HomeController@about',
    'courses' => 'HomeController@courses',
    'events' => 'HomeController@events',
    'blog' => 'HomeController@blog',
    'contact' => 'HomeController@contact',
    'admin' => 'AdminController@index',
    'admin/login' => 'AdminController@login',
    'admin/logout' => 'AdminController@logout',
    'admin/dashboard' => 'AdminController@dashboard',
    'admin/users' => 'AdminController@users',
    'admin/posts' => 'AdminController@posts',
    'admin/courses' => 'AdminController@courses',
    'admin/content' => 'ContentController@index',
    'admin/content/edit' => 'ContentController@edit',
    'admin/content/update' => 'ContentController@update',
    'admin/content/preview' => 'ContentController@preview',
    'api/posts' => 'ApiController@posts',
    'api/users' => 'ApiController@users'
];

// Procesar la ruta
$matched = false;
foreach ($routes as $route => $handler) {
    if ($path === $route) {
        // Ruta exacta
        $matched = true;
        $routeHandler = $handler;
        break;
    } elseif (strpos($route, '/') !== false && strpos($path, $route) === 0) {
        // Ruta con parámetros (ej: admin/content/edit/home)
        $matched = true;
        $routeHandler = $handler;
        $param = substr($path, strlen($route) + 1); // Obtener parámetro
        break;
    }
}

if ($matched) {
    list($controller, $method) = explode('@', $routeHandler);
    
    error_log("Route found: $routeHandler");
    error_log("Controller: $controller, Method: $method");
    
    $controllerFile = "app/controllers/{$controller}.php";
    if (file_exists($controllerFile)) {
        require_once $controllerFile;
        $controllerInstance = new $controller();
        
        // Pasar parámetro si existe
        if (isset($param)) {
            $controllerInstance->$method($param);
        } else {
            $controllerInstance->$method();
        }
    } else {
        error_log("Controller file not found: $controllerFile");
        http_response_code(404);
        include 'app/views/errors/404.php';
    }
} else {
    error_log("Route not found for path: $path");
    http_response_code(404);
    include 'app/views/errors/404.php';
}
?>
