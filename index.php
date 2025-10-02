<?php
// Punto de entrada principal de la aplicación
session_start();

// Configuración de la aplicación
define('APP_NAME', 'EduFix');
define('APP_VERSION', '1.0.0');

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
$path = ltrim($path, '/');

// Si es un archivo estático (CSS, JS, imágenes), no procesar con el router
if (preg_match('/\.(css|js|png|jpg|jpeg|gif|ico|svg|woff|woff2|ttf|eot)$/i', $path)) {
    // Dejar que Apache sirva el archivo estático directamente
    return false;
}

// Debug del enrutamiento
error_log("Request URI: " . $request);
error_log("Parsed path: " . $path);

// Rutas de la aplicación (ordenadas de más específicas a menos específicas)
$routes = [
    '' => 'HomeController@index',
    'home' => 'HomeController@index',
    'about' => 'HomeController@about',
    'courses' => 'HomeController@courses',
    'events' => 'HomeController@events',
    'blog' => 'HomeController@blog',
    'contact' => 'HomeController@contact',
    'admin/login' => 'AdminController@login',
    'admin/logout' => 'AdminController@logout',
    'admin/dashboard' => 'AdminController@dashboard',
    'admin/users' => 'AdminController@users',
    'admin/users/create' => 'AdminController@createUser',
    'admin/users/store' => 'AdminController@storeUser',
    'admin/users/edit' => 'AdminController@editUser',
    'admin/users/update' => 'AdminController@updateUser',
    'admin/users/delete' => 'AdminController@deleteUser',
    'admin/users/reset-password' => 'AdminController@resetPassword',
    'admin/posts' => 'AdminController@posts',
    'admin/posts/create' => 'AdminController@createPost',
    'admin/posts/store' => 'AdminController@storePost',
    'admin/posts/edit' => 'AdminController@editPost',
    'admin/posts/update' => 'AdminController@updatePost',
    'admin/posts/delete' => 'AdminController@deletePost',
    'admin/courses' => 'AdminController@courses',
    'admin/courses/create' => 'AdminController@create',
    'admin/courses/store' => 'AdminController@store',
    'admin/courses/edit' => 'AdminController@edit',
    'admin/courses/update' => 'AdminController@update',
    'admin/courses/delete' => 'AdminController@delete',
    'admin/events' => 'AdminController@events',
    'admin/events/create' => 'AdminController@createEvent',
    'admin/events/store' => 'AdminController@storeEvent',
    'admin/events/edit' => 'AdminController@editEvent',
    'admin/events/update' => 'AdminController@updateEvent',
    'admin/events/delete' => 'AdminController@deleteEvent',
    'admin/content/edit' => 'ContentController@edit',
    'admin/content/update' => 'ContentController@update',
    'admin/content/preview' => 'ContentController@preview',
    'admin/content' => 'ContentController@index',
    'admin' => 'AdminController@index',
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
