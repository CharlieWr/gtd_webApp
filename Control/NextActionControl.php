<?php


    require_once '../Objects/NextAction.php';
    require_once '../Objects/Stuff.php';
    require_once '../Model/NextActionModel.php';
    
    class NextActionControl {
        
        public function getNextActionByStuffId($stuffId){
            if(!is_numeric($stuffId)){
                die("id Stuff no es numero entero valido.");
            }
            else{
                $naModel = new NextActionModel();
                $na = $naModel->selectNextActionByStuffId($stuffId);
                
                return $na;
            }
        }
    }
?>
