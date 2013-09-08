<?php
require_once 'Stuff.php';

    class Proyecto extends Stuff{
        private $idProyecto;

        private $idStuff;
        
        function rellenaProyecto($idStuff) {

            $this->idStuff = $idStuff;
  }

        
        public function asignaStuff($stuff){
            
            parent::asignaStuff($stuff);
                        $this->idStuff = $stuff->getIdStuff();

        }
        public function getIdProyecto() {
            return $this->idProyecto;
        }

        public function setIdProyecto($idProyecto) {
            $this->idProyecto = $idProyecto;
        }

    

        public function getIdStuff() {
            return $this->idStuff;
        }

        public function setIdStuff($idStuff) {
            $this->idStuff = $idStuff;
        }




    }

?>
