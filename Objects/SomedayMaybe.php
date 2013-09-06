<?php
    require_once 'Stuff.php';
    
    class SomedayMaybe extends Stuff{
        
        private $idSomedayMaybe;
    
        private $plazo;
        private $idStuff;
        
        function rellenaSomedayMaybe( $plazo, $idStuff) {

            $this->plazo = $plazo;
            $this->idStuff = $idStuff;
        }

                public function getIdSomedayMaybe() {
            return $this->idSomedayMaybe;
        }

        public function setIdSomedayMaybe($idSomedayMaybe) {
            $this->idSomedayMaybe = $idSomedayMaybe;
        }

        

        public function getPlazo() {
            return $this->plazo;
        }

        public function setPlazo($plazo) {
            $this->plazo = $plazo;
        }

        public function getIdStuff() {
            return $this->idStuff;
        }

        public function setIdStuff($idStuff) {
            $this->idStuff = $idStuff;
        }

  
    }

?>
