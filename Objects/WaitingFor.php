<?php
    require_once 'stuff.php';
    
    class WaitingFor extends Stuff {
        
        private $idWaitingFor;
        private $contexto;
        private $tags;
        private $contactoPersona;
        private $idStuff;
        
        function __construct($idWaitingFor, $idStuff) {
            $this->idWaitingFor = $idWaitingFor;
            $this->idStuff = $idStuff;
        }

        public function getIdWaitingFor() {
            return $this->idWaitingFor;
        }

        private function setIdWaitingFor($idWaitingFor) {
            $this->idWaitingFor = $idWaitingFor;
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

        public function getContactoPersona() {
            return $this->contactoPersona;
        }

        public function setContactoPersona($contactoPersona) {
            $this->contactoPersona = $contactoPersona;
        }

        public function getIdStuff() {
            return $this->idStuff;
        }

        public function setIdStuff($idStuff) {
            $this->idStuff = $idStuff;
        }


        
    }

?>
