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
        
        public function getAllStuffByUsuarioId($idUsuario){
            $stuffModel = new StuffModel();
            
            $stuff = $stuffModel->selectStuffByUduarioId($idUsuario);
            
            return $stuff;
        }
        
        
        public function insertStuff($infoStuff){
            $stuffModel = new StuffModel();
            $id = $infoStuff['idStuff'];
            $tagModel = new TagModel();
             
             
            $newStuff = new Stuff();
            $newStuff->setDescripcion($infoStuff['descripcion']);
            $newStuff->setNombre($infoStuff['nombre']);
            $newStuff->setIdContexto($infoStuff['idContexto']);
            $newStuff->setIdStuff($infoStuff['idStuff']);

                
            //Si ya existe en la base de datos se actualiza
            if($stuffModel->existeStuff($id)){
                //Se borra entrada de Stuff en Tags
               
                $tagModel->deleteTagByIdStuff($id);
                
                //Crea array de tags segun delimitador
                $tagList = explode(";",$infoStuff['tag']);
                
                foreach($tagList as $singleTag){
                    //Removemos posibles espacios en blanco al principio y final de nombre tag
                    $nombreTag = trim($singleTag);
                    //Se añade cada tag  a la tabla tag
                  if($nombreTag != "" || $nombreTag != NULL){
                    $tag = new Tag();
                    $tag->setIdStuff($id);
                    $tag->setNombreTag($nombreTag);
                    $tagModel->insertarTag($tag);

                    }
                }
              
                
                //Se hace update en Stuff

                $stuffModel->updateStuff($newStuff);
            }
            //Si es un nuevo Stuff
            else{
                //Crear nueva entrada en tabla tags por cada tag
                //
                ////Crea array de tags segun delimitador
                $tagList = explode(";",$infoStuff['tag']);
                
                foreach($tagList as $singleTag){
                    //Removemos posibles espacios en blanco al principio y final de nombre tag
                    $nombreTag = trim($singleTag);
                      //Se añade cada tag  a la tabla tag
                    if($nombreTag != "" || $nombreTag != NULL){
                        $tag = new Tag();
                        $tag->setIdStuff($id);
                        $tag->setNombreTag($nombreTag);
                        $tagModel->insertarTag($tag);

                    }
                }
                //Insertar en Stuff
                $newStuff->setIdHistorial($infoStuff['idHistorial']);
                $newStuff->setIdUsuario($infoStuff['idUsuario']);
                $newStuff->setTypeStuff($infoStuff['typeStuff']);
                $stuffModel->insertarStuff($newStuff);
                
            }
            
            
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
