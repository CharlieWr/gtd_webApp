<?php
    require_once '../Objects/Proyecto.php';
    require_once '../Model/ProyectoModel.php';
    require_once '../Model/StuffModel.php';

    
    class ProyectoControl {
        
    public function getAllProyectoByIdUsuario($idUsuario){
        if(!is_numeric($idUsuario)){
            die("Id Usuario no es tipo entero valido.");
        }
        else{
            $stuffModel = new StuffModel();
            $stuffList = $stuffModel->selectStuffByUduarioId($idUsuario);
            
            $projectModel = new ProyectoModel();
            $projectList = $projectModel->selectAllProyecto();
            
            $res = array();
            foreach($stuffList as $stf){
              
                foreach($projectList as $prj){
                    //Nos quedamos solo con los proyectos de los Stuff de un usuario especifico
                    if($prj->getIdStuff() == $stf->getIdStuff()){
                        $res[]=$prj;
                    }
                }
            }
            
            return $res;
            
        }
    }
    
    public function getProyectoByStuffId($idStuff){
         if(!is_numeric($idStuff)){
            die("Id Stuff no es tipo entero valido.");
        }
        else{
            $proyModel = new ProyectoModel();
            $proyecto = $proyModel->selectProyectoStuffById($idStuff);
            return $proyecto;
        }
    }
    
    
    public function getStuffByProyectoId($idProj){
         if(!is_numeric($idProj)){
            die("Id Proyecto no es tipo entero valido.");
        }{
            $proyectoModel = new ProyectoModel();
            $proj = $proyectoModel->selectProyectoById($idProj);
            $idStuffProj = $proj->getIdStuff();
            $stuffModel = new StuffModel();
            return $stuffModel->selectStuffById($idStuffProj);
        }
    }
    public function getActividadesAsociadas($idProj){
          if(!is_numeric($idProj)){
            die("Id Proyecto no es tipo entero valido.");
        }
        else{
            $proyectoModel = new ProyectoModel();
            return $proyectoModel->obtenerActividadesDeProyecto($idProj);
        }
    }
    }
?>
