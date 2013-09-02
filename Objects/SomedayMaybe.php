<?php
    require_once 'Stuff.php';
    
    class SomedayMaybe extends Stuff{
        
        private $idSomedayMaybe;
        private $contexto;
        private $tags;
        private $plazo;
        private $idStuff;
        
        function rellenaSomedayMaybe($contexto, $tags, $plazo, $idStuff) {
            $this->contexto = $contexto;
            $this->tags = $tags;
            $this->plazo = $plazo;
            $this->idStuff = $idStuff;
        }

                public function getIdSomedayMaybe() {
            return $this->idSomedayMaybe;
        }

        private function setIdSomedayMaybe($idSomedayMaybe) {
            $this->idSomedayMaybe = $idSomedayMaybe;
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
