<?php
    require_once '../Model/ContextoModel.php';
    class ContextoControl{

        public function getAllContexto(){
            $contextoModel = new ContextoModel();

            $contextList = $contextoModel->selectAllContexto();
            
            return $contextList;
        }

    }
?>
