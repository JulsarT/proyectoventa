<?php
// core/Controller.php
require_once __DIR__ . '/../configuracion/config.php';

class Controller {
    protected function view($view, $data = []) {
        extract($data);
        $viewPath = PATH_VIEWS . str_replace('.', '/', $view) . '.php';
        if (file_exists($viewPath)) {
            require_once PATH_VIEWS . 'layout/header.php';
            require_once $viewPath;
            require_once PATH_VIEWS . 'layout/footer.php';
        } else {
            die("Vista no encontrada: $view");
        }
    }
    protected function requireAuth($requiredRole = null) {
        //session_start();
        if (!isset($_SESSION['user_id'])) {
            header("Location: " . BASE_URL . "usuario/login");
            exit;
        }
        if ($requiredRole && $_SESSION['user_type'] !== $requiredRole) {
            header("Location: " . BASE_URL);
            exit;
        }
    }
    protected function redirect($controller = '', $action = '') {
        $url = BASE_URL . ($controller ? "$controller/$action" : '');
        header("Location: $url");
        exit;
    }
}