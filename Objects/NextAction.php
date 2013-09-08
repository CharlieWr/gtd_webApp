<?php
require_once 'Stuff.php';
class NextAction extends Stuff {

    private $idNextAction;
    private $idStuff;
    
    
    function rellenaNextAction($idStuff   ) {

        $this->idStuff = $idStuff;
    }

    public  function asignaStuff($stuff){
            
            parent::asignaStuff($stuff);
                        $this->idStuff = $stuff->getIdStuff();

        }
    public function getIdNextAction() {
        return $this->idNextAction;
    }

    public function setIdNextAction($idNextAction) {
        $this->idNextAction = $idNextAction;
    }

   
    public function getIdStuff() {
        return $this->idStuff;
    }

    public function setIdStuff($idStuff) {
        $this->idStuff = $idStuff;
    }




}


?>
