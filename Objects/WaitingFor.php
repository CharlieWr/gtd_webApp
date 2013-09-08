<?php
    require_once 'Stuff.php';
    
    class WaitingFor extends Stuff {
        
        private $idWaitingFor;

        private $contactoPersona;
        private $idStuff;
        


        public function getIdWaitingFor() {
            return $this->idWaitingFor;
        }

        public function setIdWaitingFor($idWaitingFor) {
            $this->idWaitingFor = $idWaitingFor;
        }

         public function asignaStuff($stuff){
            
            parent::asignaStuff($stuff);
            $this->idStuff = $stuff->getIdStuff();
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
