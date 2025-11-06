<?php
// controlador/UsuarioController.php
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../modelo/Usuario.php';

class UsuarioController extends Controller {
    private $usuarioModel;

    public function __construct() {
        $this->usuarioModel = new Usuario();
    }

    public function index() {
        $this->requireAuth(); // Cualquier usuario autenticado puede ver la lista
        $data['usuarios'] = $this->usuarioModel->getAll();
        $data['title'] = 'Lista de Usuarios';
        $this->view('usuario.index', $data);
    }

    public function inactivos() {
        $this->requireAuth('administrador'); // Solo admin puede ver inactivos
        $data['usuarios'] = $this->usuarioModel->getAll(true); // Solo inactivos
        $data['title'] = 'Usuarios Inactivos';
        $this->view('usuario.inactivos', $data);
    }

    public function crear() {
        // Público o cualquier usuario autenticado (ajusta según prefieras)
        $data['title'] = 'Crear Usuario';
        $this->view('usuario.crear', $data);
    }

    public function guardar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $password = $_POST['password'];
            // Validación de contraseña segura
            $passwordError = null;
            if (
                strlen($password) < 8 ||
                !preg_match('/[A-Z]/', $password) ||
                !preg_match('/[a-z]/', $password) ||
                !preg_match('/[0-9]/', $password) ||
                !preg_match('/[^a-zA-Z0-9]/', $password)        
            ) {
                $passwordError = 'La contraseña debe tener al menos 8 caracteres, incluir mayúsculas, minúsculas, números y un carácter especial.';
            }

            if ($passwordError) {
                $data = $_POST;
                $data['error'] = $passwordError;
                $data['title'] = 'Crear Usuario';
                $this->view('usuario.crear', $data);
                return;
            }

            $data = [
                'nombre' => filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_STRING),
                'apellido_paterno' => filter_input(INPUT_POST, 'apellido_paterno', FILTER_SANITIZE_STRING),
                'apellido_materno' => filter_input(INPUT_POST, 'apellido_materno', FILTER_SANITIZE_STRING),
                'email' => filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL),
                'password' => $password, // Asegúrate de que el modelo lo hashee
                'tipo_usuario' => filter_input(INPUT_POST, 'tipo_usuario', FILTER_SANITIZE_STRING)
            ];

            if ($this->usuarioModel->create($data)) {
                $this->redirect('usuario');
            } else {
                $data['error'] = 'Error al crear el usuario';
                $this->view('usuario.crear', $data);
            }
        }
    }

    public function editar($id) {
        $this->requireAuth('administrador'); // Solo admin puede editar
        $data['usuario'] = $this->usuarioModel->getById($id);
        $data['title'] = 'Editar Usuario';
        if ($data['usuario']) {
            $this->view('usuario.editar', $data);
        } else {
            $this->redirect('usuario');
        }
    }

    public function actualizar($id) {
        $this->requireAuth('administrador'); // Solo admin puede actualizar
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'nombre' => filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_STRING),
                'apellido_paterno' => filter_input(INPUT_POST, 'apellido_paterno', FILTER_SANITIZE_STRING),
                'apellido_materno' => filter_input(INPUT_POST, 'apellido_materno', FILTER_SANITIZE_STRING),
                'email' => filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL),
                'password' => $_POST['password'], // Asegúrate de que el modelo lo hashee
                'tipo_usuario' => filter_input(INPUT_POST, 'tipo_usuario', FILTER_SANITIZE_STRING)
            ];

            if ($this->usuarioModel->update($id, $data)) {
                $this->redirect('usuario');
            } else {
                $data['error'] = 'Error al actualizar el usuario';
                $data['usuario'] = $this->usuarioModel->getById($id);
                $this->view('usuario.editar', $data);
            }
        }
    }

    public function desactivar($id) {
        $this->requireAuth('administrador'); // Solo admin puede desactivar
        if ($this->usuarioModel->setInactive($id)) {
            $this->redirect('usuario');
        } else {
            $this->redirect('usuario');
        }
    }

    public function activar($id) {
        $this->requireAuth('administrador'); // Solo admin puede activar
        if ($this->usuarioModel->setActive($id)) {
            $this->redirect('usuario/inactivos');
        } else {
            $this->redirect('usuario/inactivos');
        }
    }

    public function eliminar($id) {
        $this->requireAuth('administrador'); // Solo admin puede eliminar
        if ($this->usuarioModel->delete($id)) {
            $this->redirect('usuario/inactivos');
        } else {
            $this->redirect('usuario/inactivos');
        }
    }

    public function generarPDF() {
        $this->requireAuth();
        $usuarios = $this->usuarioModel->getAll();
        require_once __DIR__ . '/../vendor/pdf/usuarioPdf.php';
        $pdf = new UsuarioPDF($usuarios);
        $pdf->generate();
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

            $user = $this->usuarioModel->login($email, $password);
            if ($user) {
                $_SESSION['user_id'] = $user['id_usuario'];
                $_SESSION['user_type'] = $user['tipo_usuario'];
                $_SESSION['user_email'] = $user['email'];
                $this->redirect('home', 'dashboard'); // Redirige a la vista de dashboard
            } else {
                $data['error'] = 'Credenciales incorrectas';
                $data['title'] = 'Iniciar Sesión';
                $this->view('usuario.login', $data);
            }
        } else {
            $data['title'] = 'Iniciar Sesión';
            $this->view('usuario.login', $data);
        }
    }

    public function logout() {
        session_destroy();
        $this->redirect();
    }
}