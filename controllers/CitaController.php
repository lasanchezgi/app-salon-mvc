<?php
    // Namespace
    namespace Controllers;

    use MVC\Router;

    class CitaController {
        public static function index (Router $router) {
            // Iniciar sesión
            session_start();

            // Para comprobar si el usuario esta autenticado
            isAuth();

            $router->render('cita/index', [
                'nombre' => $_SESSION['nombre'],
                'id' => $_SESSION['id']
            ]);
        }
    }
