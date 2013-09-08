<?php
    require_once '../Objects/SomedayMaybe.php';
    require_once '../Model/SomedayMaybeModel.php';
    
    class SomedayMaybeControl{

        public function getSMByStuffId($idStuff){
            if(!is_numeric($idStuff)){
                die("Stuff Id SM debe ser entero valido.");
            }else{
                
                $smModel = new SomedayMaybeModel();
                $sm = $smModel->selectSomedayMaybeByStuffId($idStuff);
                
                return $sm;
            }
        }
    }
?>
