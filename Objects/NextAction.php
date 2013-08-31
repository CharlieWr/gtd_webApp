<?php
require_once 'stuff.php';
class NextAction extends stuff {

    private $idNextAction;
    private $contexto;
    private $tags;
    private $idStuff;
    
    function __construct($idNextAction, $idStuff) {
        $this->idNextAction = $idNextAction;
        $this->idStuff = $idStuff;
    }
    public function getIdNextAction() {
        return $this->idNextAction;
    }

    private function setIdNextAction($idNextAction) {
        $this->idNextAction = $idNextAction;
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
