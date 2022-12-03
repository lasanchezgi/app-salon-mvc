<?php
    namespace Controllers;

    use Model\AdminCita;
    use MVC\Router;

    class AdminController {
        public static function index(Router $router) {

            session_start();

            // Validar si es el administrador
            isAdmin();

            // Se le solicita una fecha, sino toma la fecha actual
            $fecha = $_GET['fecha'] ?? date('Y-m-d');
            // Separa la fecha por año, mes y dia
            $fechas = explode('-', $fecha);

            // La funcion checkdate revisa que se le ingresen valores validos de fecha, en caso de que la fecha NO sea valida se redirecciona el usuario a la pagina 404
            if (!checkdate($fechas[1], $fechas[2], $fechas[0])) {
                header('Location: /404');
            }

            // Consultar la BD
            $consulta = "SELECT citas.id, citas.hora, CONCAT( usuarios.nombre, ' ', usuarios.apellido) as cliente, ";
            $consulta .= " usuarios.email, usuarios.telefono, servicios.nombre as servicio, servicios.precio  ";
            $consulta .= " FROM citas  ";
            $consulta .= " LEFT OUTER JOIN usuarios ";
            $consulta .= " ON citas.usuarioid=usuarios.id  ";
            $consulta .= " LEFT OUTER JOIN citasservicios ";
            $consulta .= " ON citasservicios.citaid=citas.id ";
            $consulta .= " LEFT OUTER JOIN servicios ";
            $consulta .= " ON servicios.id=citasservicios.servicioid ";
            $consulta .= " WHERE fecha =  '${fecha}' ";

            $citas = AdminCita::SQL($consulta);

            $router->render('admin/index', [
                'nombre' => $_SESSION['nombre'],
                'citas' => $citas, 
                'fecha' => $fecha
            ]);
        }
    }