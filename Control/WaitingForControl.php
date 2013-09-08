<?php
    require_once '../Objects/WaitingFor.php';
    require_once '../Model/WaitingForModel.php';
    
    class WaitingForControl {
        
        public function getWFByStuffId($idStuff){
            if(!is_numeric($idStuff)){
                die("Stuff Id WF debe ser entero valido.");
            }else{
                
                $wfModel = new WaitingForModel();
                $wf = $wfModel->selectWaitingForByStuffId($idStuff);
                
                return $wf;
            }
        }
    }
?>
