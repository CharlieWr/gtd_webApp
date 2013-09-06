<?php

class Tag {
    private $idTag;
    private $idStuff;
    private $nombreTag;
    
    public function getIdTag() {
        return $this->idTag;
    }

    public function setIdTag($idTag) {
        $this->idTag = $idTag;
    }

    public function getIdStuff() {
        return $this->idStuff;
    }

    public function setIdStuff($idStuff) {
        $this->idStuff = $idStuff;
    }

    public function getNombreTag() {
        return $this->nombreTag;
    }

    public function setNombreTag($nombreTag) {
        $this->nombreTag = $nombreTag;
    }


    
}
?>
