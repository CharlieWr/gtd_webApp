<?php
    require_once '../Objects/Historial.php';
    require_once '../Model/HistorialModel.php';
    require_once '../Model/StuffModel.php';
    
    class HistorialControl{
        
        public function deleteHistorialByIdStuff($idStuff){
            if(!is_numeric($idStuff)){
                die("Id Stuff Historial no es entero valido.");
            }
            else{
                
                $stuffModel = new StuffModel();
                $stuff = $stuffModel->selectStuffById($idStuff);
                $idHistorial = $stuff->getIdHistorial();
                
                $historialModel = new HistorialModel();
                $historialModel->deleteHistorialById($idHistorial);
                $stuffModel->deleteStuffById($idStuff);
            }
        }
    }
?>
