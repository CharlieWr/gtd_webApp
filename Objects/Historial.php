<?php
    

    class Historial {
        
        private $idHistorial;
        private $completado;
        private $fechaHistorial;
        
        function __construct($idHistorial, $completado, $fechaHistorial) {
            $this->idHistorial = $idHistorial;
            $this->completado = $completado;
            $this->fechaHistorial = $fechaHistorial;
        }

        public function getIdHistorial() {
            return $this->idHistorial;
        }

        private function setIdHistorial($idHistorial) {
            $this->idHistorial = $idHistorial;
        }

        public function getCompletado() {
            return $this->completado;
        }

        public function setCompletado($completado) {
            $this->completado = $completado;
        }

        public function getFechaHistorial() {
            return $this->fechaHistorial;
        }

        public function setFechaHistorial($fechaHistorial) {
            $this->fechaHistorial = $fechaHistorial;
        }


    }
?>
