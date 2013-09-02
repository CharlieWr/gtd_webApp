<?php
require_once 'Stuff.php';
class NextAction extends stuff {

    private $idNextAction;
    private $contexto;
    private $tags;
    private $idStuff;
    
    
    function rellenaNextAction($contexto, $tags, $idStuff   ) {
        $this->contexto = $contexto;
        $this->tags = $tags;
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
