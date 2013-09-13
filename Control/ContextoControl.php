<?php
    require_once '../Model/ContextoModel.php';
    require_once '../Objects/Contexto.php';
    
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

        public function deleteContextoById($id){
            if(!is_numeric($id)){
                die("Id contexto no es entero valido.");
            }
            else{
                $contextoModel = new ContextoModel();
                $contextoModel->deleteContextoById($id);
            }
        }
        public function insertContexto($contexto){
            if(!is_a($contexto,'Contexto'))  {
                die("Objeto no es de tipo Contexto.");
            } 
           else{
               $idCt = $contexto->getIdContexto();
               $contextoModel = new ContextoModel();

               //Si es un contexto que existe
               if($idCt){
                   $contextoModel->updateContexto($contexto);
               }
               else{
                    $contextoModel->insertarContexto($contexto);
               }
           }
        }
    }
    
?>
