<?php

    namespace Model;

    class CitaServicio extends ActiveRecord {
        // Base de datos
        protected static $tabla = 'citasservicios';
        protected static $columnasDB = ['id', 'citaid', 'servicioid'];

        // Atributos
        public $id;
        public $citaid;
        public $servicioid;

        // Constructor
        public function __construct($args = [])
        {
            $this->id = $args['id'] ?? null;
            $this->citaid = $args['citaid'] ?? '';
            $this->servicioid = $args['servicioid'] ?? '';
        }

    }