<?php
    namespace Controllers;

    use Model\CitaServicio;
    use Model\Cita;
    use Model\Servicio;

    class APIController {
        public static function index() {
            $servicios = Servicio::all();
            // Los arreglos asociativos de PHP NO existen en JavaScript, asi que esta función lo convierte a JSON (que es una serie de objetos)
            // Basicamente un arreglo asociativo es lo mismo que un objeto en JavaScript, de esta forma estas dos tecnologias se pueden comunicar
            echo json_encode($servicios);
        }

        // Guardar datos en el servidor
        public static function guardar() {
            // Almacena la cita y devuelve el id
            $cita = new Cita($_POST);
            // Guardar en la BD
            $resultado = $cita->guardar();

            $id = $resultado['id'];

            // Almacena los servicios con el id de la cita
            // Separar los servicios, de string a arreglo
            $idServicios = explode(",",$_POST['servicios']);

            // Instancia cuantos idServicios haya disponibles
            // Itera y va guardando cada uno de los servicios con la referencia de la cita
            foreach ($idServicios as $idServicio) {
                $args = [
                    'citaid' => $id,
                    'servicioid' => $idServicio
                ];
                // Crea una nueva instancia
                $citaServicio = new CitaServicio($args);
                // Agrega a la BD
                $citaServicio->guardar();
            }

            echo json_encode(['resultado' => $resultado]);
        }

        // Función para eliminar citas
        public static function eliminar() {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $id = $_POST['id'];
                $cita = Cita::find($id);
                $cita->eliminar();
                header('Location:' . $_SERVER['HTTP_REFERER']);
            }
        }
    }