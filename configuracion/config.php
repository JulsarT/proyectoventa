<?php
// configuracion/config.php

// Definir constantes para rutas
define('BASE_URL', 'http://localhost/ProyectoVenta/');
define('CONTROLLER_DEFAULT', 'Home');
define('ACTION_DEFAULT', 'index');

// Configuración de zona horaria
date_default_timezone_set('America/La_Paz');

// Configuración de sesiones
//session_start();

// Directorios principales
define('PATH_CONTROLLERS', __DIR__ . '/../controlador/');
define('PATH_MODELS', __DIR__ . '/../modelo/');
define('PATH_VIEWS', __DIR__ . '/../vista/');
define('PATH_PUBLIC', __DIR__ . '/../public/');