<?php

class Contexto {
    private $idContexto;
    private $nombreContexto; 
    
    public function getIdContexto() {
        return $this->idContexto;
    }

    public function setIdContexto($idContexto) {
        $this->idContexto = $idContexto;
    }

    public function getNombreContexto() {
        return $this->nombreContexto;
    }

    public function setNombreContexto($nombreContexto) {
        $this->nombreContexto = $nombreContexto;
    }


    
}
?>
