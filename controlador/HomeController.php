<?php
// controlador/HomeController.php
require_once __DIR__ . '/../core/Controller.php';

class HomeController extends Controller {
    public function index() {
        $data = [
            'title' => 'Bienvenido al Sistema de Venta de Accesorios'
        ];
        // Renderiza directamente la vista sin el layout
        $viewPath = PATH_VIEWS . 'home/landing.php';
        if (file_exists($viewPath)) {
            extract($data);
            require_once $viewPath;
        } else {
            die("Vista no encontrada: home.landing");
        }
    }

    public function dashboard() {
        $this->requireAuth(); // Requiere que el usuario esté logueado
        $data = [
            'title' => 'Dashboard - Sistema de Venta de Accesorios'
        ];
        $this->view('home.index', $data); // Usa el layout con header y footer
    }
}