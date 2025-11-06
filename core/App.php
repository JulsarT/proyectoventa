<?php
// core/App.php
require_once __DIR__ . '/../configuracion/config.php';

class App {
    private $controller = CONTROLLER_DEFAULT;
    private $action = ACTION_DEFAULT;
    private $params = [];

    public function __construct() {
        $this->parseUrl();
        $this->dispatch();
    }

    private function parseUrl() {
        if (isset($_GET['url'])) {
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);

            $this->controller = !empty($url[0]) ? ucfirst($url[0]) : CONTROLLER_DEFAULT;
            $this->action = !empty($url[1]) ? $url[1] : ACTION_DEFAULT;
            $this->params = array_slice($url, 2);
        }
    }

    private function dispatch() {
        $controllerFile = PATH_CONTROLLERS . $this->controller . 'Controller.php';
        if (file_exists($controllerFile)) {
            require_once $controllerFile;
            $controllerClass = $this->controller . 'Controller';
            if (class_exists($controllerClass)) {
                $controller = new $controllerClass();
                if (method_exists($controller, $this->action)) {
                    call_user_func_array([$controller, $this->action], $this->params);
                } else {
                    die("Acción no encontrada: {$this->action}");
                }
            } else {
                die("Controlador no encontrado: $controllerClass");
            }
        } else {
            die("Archivo de controlador no encontrado: $controllerFile");
        }
    }
}