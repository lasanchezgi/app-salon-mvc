<?php

    namespace Model;

    class Usuario extends ActiveRecord {
        // Base de datos
        protected static $tabla = 'usuarios';
        // Deben coincidir exactamente con las columnas de la BD
        protected static $columnasDB = ['id', 'nombre', 'apellido', 'email', 'password','telefono','admin','confirmado','token'];
        // Atributo por cada una de las columnas de la BD, al ser public se pueden acceder en la clase misma y en el objeto una vez este instanciado
        public $id;
        public $nombre;
        public $apellido;
        public $email;
        public $password;
        public $telefono;
        public $admin;
        public $confirmado;
        public $token;

        // Constructor
        // Toma argumentos, pero por default toma un arreglo vacio
        // Se agregan los argumentos con los atributos de la clase
        public function __construct($args = [])
        {
            $this->id = $args['id'] ?? null;
            $this->nombre = $args['nombre'] ?? '';
            $this->apellido = $args['apellido'] ?? '';
            $this->email = $args['email'] ?? '';
            $this->password = $args['password'] ?? '';
            $this->telefono = $args['telefono'] ?? '';
            $this->admin = $args['admin'] ?? '0';
            $this->confirmado = $args['confirmado'] ?? '0';
            $this->token = $args['token'] ?? '';
        }

        // Mensajes de validación para la creación de una cuenta
        public function validarNuevaCuenta () {
            if (!$this->nombre) {
                self::$alertas['error'][] = 'El nombre es obligatorio';
            }
            if (!$this->apellido) {
                self::$alertas['error'][] = 'El apellido es obligatorio';
            }
            if (!$this->email) {
                self::$alertas['error'][] = 'El e-mail es obligatorio';
            }
            if (!$this->password) {
                self::$alertas['error'][] = 'El password es obligatorio';
            }
            // Para asegurarse de que el password tenga la longitud de 6 caracteres
            if(strlen($this->password) < 6) {
                self::$alertas['error'][] = 'El password debe contener al menos 6 caracteres';
            }
            return self::$alertas;
        }

        // Validar LOGIN 
        public function validarLogin() {
            if (!$this->email) {
                self::$alertas['error'][] = 'El e-mail es obligatorio';
            }
            if (!$this->password) {
                self::$alertas['error'][] = 'El password es obligatorio';
            }
            return self::$alertas;
        }

        // Validar  E-MAIL
        public function validarEmail() {
            if (!$this->email) {
                self::$alertas['error'][] = 'El e-mail es obligatorio';
            }
            return self::$alertas;
        }

        // Validar password
        public function validarPassword() {
            if (!$this->password) {
                self::$alertas['error'][] = 'El password es obligatorio';
            }
            if (strlen($this->password) < 6) {
                self::$alertas['error'][] = 'El password debe tener al menos 6 caracteres';
            }
            return self::$alertas;
        }

        // Revisa si el usuario ya existe
        public function existeUsuario() {
            $query = " SELECT * FROM " . self::$tabla . " WHERE email = '" . $this->email . "' LIMIT 1";
            $resultado = self::$db->query($query);

            // Si ya esta registrado
            if ($resultado->num_rows) {
                self::$alertas['error'][] = 'El usuario ya esta registrado';
            }
            return $resultado;
        }

        // Hasear password
        public function hashPassword() {
            $this->password = password_hash($this->password, PASSWORD_BCRYPT);
        }

        // Crear token
        public function crearToken() {
            // Función de PHP que genera id unicos de 13 digitos
            $this->token = uniqid();
        }

        // Comprobar que existe el password y que el usuario este verificado
        public function comprobarPasswordVerificado($password) {
            // Funcion de PHP para verificar el password que ha ingresado el usuario respecto al registrado en la BD
            $resultado = password_verify($password, $this->password);

            // No se le dice directamente al usuario que le falta
            if (!$resultado || !$this->confirmado) {
                self::$alertas['error'][] = 'Password incorrecto o tu cuenta no ha sido confirmada';
            } else {
                return true;
            }
        }
    }