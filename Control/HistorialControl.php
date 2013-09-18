<?php
    require_once '../Objects/Historial.php';
    require_once '../Model/HistorialModel.php';
    require_once '../Model/StuffModel.php';
    require_once '../Control/ProyectoControl.php';
    
    class HistorialControl{
        
        public function deleteHistorialByIdStuff($idStuff){
            if(!is_numeric($idStuff)){
                die("Id Stuff Historial no es entero valido.");
            }
            else{
                
                $stuffModel = new StuffModel();
                $historialModel = new HistorialModel();
                $stuff = $stuffModel->selectStuffById($idStuff);
                $idHistorial = $stuff->getIdHistorial();
                $typeStuff = $stuff->getTypeStuff();
                //Si se elimina un proyecto
                if($typeStuff == "P"){
                    $proyectoControl = new ProyectoControl();
                    $prj = $proyectoControl->getProyectoByStuffId($idStuff);
                    $actPrj = $proyectoControl->getActividadesAsociadas($prj->getIdProyecto());
                    //Borramos todas las actividades asociadas
                    foreach($actPrj as $act){
                        $idStuffAct = $act->getIdStuff();
                        $stuffModel->deleteStuffById($idStuffAct);
                    }
                    //Borramos el proyecto
                    $historialModel->deleteHistorialById($idHistorial);
                    $stuffModel->deleteStuffById($idStuff);
                }
                else{
                    
                    $historialModel->deleteHistorialById($idHistorial);
                    $stuffModel->deleteStuffById($idStuff);
                }
            }
        }
    }
?>
