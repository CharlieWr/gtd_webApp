<?php
    require_once '../Model/StuffModel.php';
    require_once '../Model/HistorialModel.php';

    class StuffControl {
        
        
        //Dado un Id obtener su Stuff asociado
        public function getStuffById($id){
            if(!is_numeric($id)){
                die("Id Stuff no es un numero entero valido");

            }
            else{
                $stuffModel = new StuffModel();

                $stuff = $stuffModel->selectStuffById($id);

                return $stuff;

            }
        }
        
        
        //Obtener array de todos los Stuff
        public function getAllStuff(){
            $stuffModel = new StuffModel();
            
            $stuff = $stuffModel->selectAllStuff();
            
            return $stuff;
        }
        
        public function updateStuff($stuff){
            if(!is_a($stuff,'Stuff')){
                die("Objeto Stuff no es de clase Stuff valida");
            }
            else{
            
                $stuffModel = new StuffModel();

                $stuffModel->updateStuff($stuff);
            }
            
        }
        
        public function deleteStuff($stuff){
            if(!is_a($stuff,'Stuff')){
                die("Objeto no es de clase Stuff valida");
            }
            else{
                $stuffModel = new StuffModel();
                $id = $stuff->getIdStuff();
                $stuffModel->deleteStuffById($id);
                
            }
        }
        
        
        //al completar o eliminar un stuff hay que añadir su entrada al historial
        public function  addAHistorial($stuff, $completado){
            $stuffModel = new StuffModel();
            $historialModel = new HistorialModel();
            
            
            //Creamos Historial
            $historial = new Historial();
            $historial->setCompletado($completado);
            //Añadir entrada a tabla Historial con booleano $completado
            //la fecha del historial se añade en el modelo con la fecha actual
            $idHistorial = $historialModel->insertarHistorial($historial);
            
            
            //Asociar Stuff con Historial creado
            $stuff->setIdHistorial($idHistorial);
            $stuffModel->insertarStuff($stuff);
        }
        
        
        
    }
?>
