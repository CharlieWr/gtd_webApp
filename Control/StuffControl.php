<?php
    require_once '../Model/StuffModel.php';
    require_once '../Model/HistorialModel.php';
    require_once '../Model/NextActionModel.php';
    require_once '../Model/ProyectoModel.php';
    require_once '../Model/SomedayMaybeModel.php';
    require_once '../Model/WaitingForModel.php';

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
            $typeStuff = ($infoStuff['typeStuff']=="")? NULL : $infoStuff['typeStuff'];
            $newStuff->setTypeStuff($typeStuff);
                
            //Si ya existe en la base de datos se actualiza
            if($id && $stuffModel->existeStuff($id)){
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
              
                //Luego de insertar en Stuff hay que revisar si ese id pertenecia a otro 'hijo', borrarlo de alli y agregarlo a la tabla que pertenece
                //Obtengo el tipo del Stuff anterior
                $oldStuff = $stuffModel->selectStuffById($id);
                $oldType = $oldStuff->getTypeStuff();
                switch($oldType){
                    case "N":
                        //Borro de Next Action ese stuff
                        $nextActionModel = new NextActionModel();
                        $nextActionModel->deleteNextActionByStuffId($id);
                        break;
                    case "P":
                        //Borro de Proyecto ese stuff
                        $proyectoModel = new ProyectoModel();
                        $proyectoModel->deleteProyectoByStuffId($id);
                        break;
                    case "S":
                        //Borro de SomedayMaybe ese stuff
                        $smModel = new SomedayMaybeModel();
                        $smModel->deleteSomedayMaybeByStuffId($id);
                        break;
                    case "W":
                        //Borro de Waiting For ese stuff
                        $wfModel = new WaitingForModel();
                        $wfModel->deleteWaitingForByStuffId($id);
                        break;
                }
                //Se hace update en Stuff

                $stuffModel->updateStuff($newStuff);
                
                //Se añade en cada tabla 'hijo' de Stuff el nuevo tipo
                switch($typeStuff){
                    case "N":
                        //se agrega nuevo Next Action
                        $nextActionModel = new NextActionModel();
                        $newNA = new NextAction();
                        $newNA->asignaStuff($newStuff);
                        $nextActionModel->insertarNextAction($newNA);
                        break;
                    case "P":
                        //se agrega nuevo Proyecto
                        $proyectoModel = new ProyectoModel();
                        $newProy = new Proyecto();
                        $newProy->asignaStuff($newStuff);
                        $proyectoModel->insertarProyecto($newProy);
                        break;
                    case "S":
                        //Bse agrega nuevo SomedayMaybe
                        $smModel = new SomedayMaybeModel();
                        $newSm = new SomedayMaybe();
                        $newSm->asignaStuff($newStuff);
                        $smModel->insertarSomedayMaybe($newSm);
                        break;
                    case "W":
                        //se agrega nuevo Waiting For
                        $wfModel = new WaitingForModel();
                        $newWf = new WaitingFor();
                        $newWf->asignaStuff($newStuff);
                        $wfModel->insertarWaitingFor($newWf);
                        break;
                }
            }
            //Si es un nuevo Stuff
            else{
                //Crear nueva entrada en tabla tags por cada tag
                //
                ////Crea array de tags segun delimitador
                $tagList = explode(";",$infoStuff['tag']);
                //Insertar en Stuff
                $newStuff->setIdHistorial($infoStuff['idHistorial']);
                $newStuff->setIdUsuario($infoStuff['idUsuario']);
                
                $id = $stuffModel->insertarStuff($newStuff);
                
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
                
                
                //Se añade en cada tabla 'hijo' de Stuff el nuevo tipo
                switch($typeStuff){
                    case "N":
                        //se agrega nuevo Next Action
                        $nextActionModel = new NextActionModel();
                        $newNA = new NextAction();
                        $newNA->asignaStuff($newStuff);
                        $nextActionModel->insertarNextAction($newNA);
                        break;
                    case "P":
                        //se agrega nuevo Proyecto
                        $proyectoModel = new ProyectoModel();
                        $newProy = new Proyecto();
                        $newProy->asignaStuff($newStuff);
                        $proyectoModel->insertarProyecto($newProy);
                        break;
                    case "S":
                        //Bse agrega nuevo SomedayMaybe
                        $smModel = new SomedayMaybeModel();
                        $newSm = new SomedayMaybe();
                        $newSm->asignaStuff($newStuff);
                        $smModel->insertarSomedayMaybe($newSm);
                        break;
                    case "W":
                        //se agrega nuevo Waiting For
                        $wfModel = new WaitingForModel();
                        $newWf = new WaitingFor();
                        $newWf->asignaStuff($newStuff);
                        $wfModel->insertarWaitingFor($newWf);
                        break;
                }
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
        
        public function deleteStuffById($id){
             if(!is_numeric($id)){
                die("Id Stuff no es de tipo entero valido.");
            }
            else{
                $stuffModel = new StuffModel();
                
                $stuffModel->deleteStuffById($id);
                
            }
        }
        
        public function sendStuffHistorial($infoStuff){
          
                //Creamos un stuff nueva con todos los campos
                $stuffModel = new StuffModel();       
                $newStuff = new Stuff();
                $newStuff->setDescripcion($infoStuff['descripcion']);
                $newStuff->setNombre($infoStuff['nombre']);
                $newStuff->setIdContexto($infoStuff['idContexto']);
                $newStuff->setIdStuff($infoStuff['idStuff']);
                $typeStuff = ($infoStuff['typeStuff']=="")? NULL : $infoStuff['typeStuff'];
                $newStuff->setTypeStuff($typeStuff);
                
                //Creamos nueva entrada en historial y le asignamos el id al Stuff
                $historialModel = new HistorialModel();
                
                $historial = new Historial();
                $historial->setCompletado(false);
                
                $idHistorial = $historialModel->insertarHistorial($historial);
                
                $newStuff->setIdHistorial($idHistorial);
                
                //Actualizamos el Stuff
                $stuffModel->updateStuff($newStuff);
                
                
                
            
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
