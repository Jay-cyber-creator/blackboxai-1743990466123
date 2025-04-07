<?php
require_once 'config.php';
require_once 'db.php';

// Autoload classes
spl_autoload_register(function($className) {
    require_once 'models/' . $className . '.php';
});

// Initialize database connection
$db = new Database();

// Get URL parameters
$url = isset($_GET['url']) ? $_GET['url'] : 'home';
$urlParts = explode('/', $url);

// Route the request
$controllerName = ucfirst($urlParts[0]) . 'Controller';
$methodName = isset($urlParts[1]) ? $urlParts[1] : 'index';

// Include controller file
$controllerFile = 'controllers/' . $controllerName . '.php';
if(file_exists($controllerFile)) {
    require_once $controllerFile;
    $controller = new $controllerName($db);
    if(method_exists($controller, $methodName)) {
        $controller->{$methodName}();
    } else {
        // Method doesn't exist - show 404
        require_once 'views/errors/404.php';
    }
} else {
    // Controller doesn't exist - show 404
    require_once 'views/errors/404.php';
}