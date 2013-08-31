<?php
    class Usuario
    {
        private  $idUsuario;
        private $userName;
        private $password;
        private $nombre;
        private $apellido;


        
    function __construct($idUsuario, $userName, $password, $nombre, $apellido) {
        $this->idUsuario = $idUsuario;
        $this->userName = $userName;
        $this->password = $password;
        $this->nombre = $nombre;
        $this->apellido = $apellido;
    }

    public function getIdUsuario() {
            return $this->idUsuario;
        }

        private function setIdUsuario($idUsuario) {
            $this->idUsuario = $idUsuario;
        }

        public function getUserName() {
            return $this->userName;
        }

        public function setUserName($userName) {
            $this->userName = $userName;
        }

        public function getPassword() {
            return $this->password;
        }

        public function setPassword($password) {
            $this->password = $password;
        }

        public function getNombre() {
            return $this->nombre;
        }

        public function setNombre($nombre) {
            $this->nombre = $nombre;
        }

        public function getApellido() {
            return $this->apellido;
        }

        public function setApellido($apellido) {
            $this->apellido = $apellido;
        }


    }