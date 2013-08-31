<?php
require_once 'stuff.php';

    class Proyecto extends Stuff{
        private $idProyecto;
        private $contexto;
        private $tags;
        private $idStuff;
        
        function __construct($idProyecto, $idStuff) {
            $this->idProyecto = $idProyecto;
            $this->idStuff = $idStuff;
        }

        public function getIdProyecto() {
            return $this->idProyecto;
        }

        private function setIdProyecto($idProyecto) {
            $this->idProyecto = $idProyecto;
        }

        public function getContexto() {
            return $this->contexto;
        }

        public function setContexto($contexto) {
            $this->contexto = $contexto;
        }

        public function getTags() {
            return $this->tags;
        }

        public function setTags($tags) {
            $this->tags = $tags;
        }

        public function getIdStuff() {
            return $this->idStuff;
        }

        public function setIdStuff($idStuff) {
            $this->idStuff = $idStuff;
        }


    }

?>
