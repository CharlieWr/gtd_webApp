<?php
    require_once '../Model/ContextoModel.php';
    class ContextoControl{

        public function getAllContexto(){
            $contextoModel = new ContextoModel();

            $contextList = $contextoModel->selectAllContexto();
            
            return $contextList;
        }
        
        public function getContextoById($id){
            if(!is_numeric($id)){
                die("Id contexto no es valor entero valido.");
            }
            else{
                $contextoModel = new ContextoModel();
                $cont = $contextoModel->selectContextoById($id);
                return $cont;

            }
        }

    }
    
    public function insertContexto($contexto){
        
    }
?>
