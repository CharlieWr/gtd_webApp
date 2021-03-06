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
            $idProyecto = NULL;
           
                
            //Si ya existe en la base de datos se actualiza
            if($id!="" && $stuffModel->existeStuff($id)){
               
                if($infoStuff['idProyecto']){
                    $projModel = new ProyectoModel();
                    $idProyecto = $projModel->selectProyectoStuffById($infoStuff['idProyecto']);
                }
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
                        //Obtener Actividades Asociadas
                        $proyecto = $proyectoModel->selectProyectoStuffById($id);
                        $actProyecto = $proyectoModel->obtenerActividadesDeProyecto($proyecto->getIdProyecto());
                        //Cambiar Base de Datos para OnCascade NULL de Next Actions
                        //Restaurar al crear idActividades con nuevo id Proyecto
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
                       //Si esta asociada o no a un proyecto (habra null si no)
                        $pr =  $idProyecto? $idProyecto->getIdProyecto() : NULL;
                        $newNA->setIdProyecto($pr);
                        $newNA->setActiva($infoStuff['activa']);
                        $nextActionModel->insertarNextAction($newNA);
                        break;
                    case "P":
                        //se agrega nuevo Proyecto
                        $proyectoModel = new ProyectoModel();
                        $newProy = new Proyecto();
                        $newProy->asignaStuff($newStuff);
                        $idNewProj = $proyectoModel->insertarProyecto($newProy);
                        //Asociamos nuevo id a actividades asociadaas antes de eliminar
                        $nextActionModel = new NextActionModel();
                        foreach($actProyecto as $act){
                            $act->setIdProyecto($idNewProj);
                            $nextActionModel->updateNextAction($act);
                        }
                        break;
                    case "S":
                        //Bse agrega nuevo SomedayMaybe
                        $smModel = new SomedayMaybeModel();
                        $newSm = new SomedayMaybe();
                        $plnewsm = isset($infoStuff['plazo'])? $infoStuff['plazo'] : NULL;
                        $newSm->setPlazo($plnewsm);
                        $newSm->asignaStuff($newStuff);
                        $smModel->insertarSomedayMaybe($newSm);
                        break;
                    case "W":
                        //se agrega nuevo Waiting For
                        $wfModel = new WaitingForModel();
                        $newWf = new WaitingFor();
                        $cpnewwf = isset($infoStuff['contacto'])? $infoStuff['contacto'] : NULL;
                        $newWf->setContactoPersona($cpnewwf);
                        $newWf->asignaStuff($newStuff);
                        $wfModel->insertarWaitingFor($newWf);
                        break;
                            //Accion no activa
//                    case NULL:
//                         //se agrega nuevo Next Action
//                        $nextActionModel = new NextActionModel();
//                        $newNA = new NextAction();
//                        $newNA->asignaStuff($newStuff);
//                        //Si esta asociada o no a un proyecto
//                        $pr = ($infoStuff['idProyecto'] == "")? NULL : $infoStuff['idProyecto'];
//                        $newNA->setIdProyecto($pr);
//                        $newNA->setActiva(false);
//                        
//                        $nextActionModel->insertarNextAction($newNA);
//                        break;
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
                $newStuff->setIdStuff($id);
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
                
                if($infoStuff['idProyecto']){
                    $projModel = new ProyectoModel();
                    $idProyecto = $projModel->selectProyectoStuffById($infoStuff['idProyecto']);
                }
                //Se añade en cada tabla 'hijo' de Stuff el nuevo tipo
                switch($typeStuff){
                    case "N":
                        //se agrega nuevo Next Action
                        $nextActionModel = new NextActionModel();
                        $newNA = new NextAction();
                        $newNA->asignaStuff($newStuff);
                        //Si esta asociada o no a un proyecto
                        $pr =  $idProyecto? $idProyecto->getIdProyecto() : NULL;
                        $newNA->setIdProyecto($pr);
                        $newNA->setActiva($infoStuff['activa']);
                        
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
                        $newSm->setPlazo($infoStuff['plazo']);
                        $newSm->asignaStuff($newStuff);
                        $smModel->insertarSomedayMaybe($newSm);
                        break;
                    case "W":
                        //se agrega nuevo Waiting For
                        $wfModel = new WaitingForModel();
                        $newWf = new WaitingFor();
                        $newWf->setContactoPersona($infoStuff['contacto']);
                        $newWf->asignaStuff($newStuff);
                        $wfModel->insertarWaitingFor($newWf);
                        break;
                    //Accion no activa
//                    case NULL:
//                         //se agrega nuevo Next Action
//                        $nextActionModel = new NextActionModel();
//                        $newNA = new NextAction();
//                        $newNA->asignaStuff($newStuff);
//                        //Si esta asociada o no a un proyecto
//                        $pr = ($infoStuff['idProyecto'] == "")? NULL : $infoStuff['idProyecto'];
//                        $newNA->setIdProyecto($pr);
//                        $newNA->setActiva(false);
//                        
//                        $nextActionModel->insertarNextAction($newNA);
//                        break;
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
        
        
        public function restoreStuff($idStuff){
               //Creamos un stuff nueva con todos los campos
                $stuffModel = new StuffModel();       
                $stuff = $stuffModel->selectStuffById($idStuff);
                
                $idHistorial = $stuff->getIdHistorial();
                
                $historialModel = new HistorialModel();
                $historialModel->deleteHistorialById($idHistorial);
            
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
                
                //Si es de tipo Next Action se elimina proyecto asociados
                 if($typeStuff == "N"){
                     $naModel = new NextActionModel();
                     $na = $naModel->selectNextActionByStuffId($infoStuff['idStuff']);
                     $na->setIdProyecto(NULL);
                     $naModel->updateNextAction($na);
                 }
//                Si es un proyecto hay que enviar a historial actividades asociadas
                if($typeStuff == "P"){
                    $proyModel = new ProyectoModel();
                    $pr = $proyModel->selectProyectoStuffById($infoStuff['idStuff']);
                    $actList = $proyModel->obtenerActividadesDeProyecto($pr->getIdProyecto());
                    
                    foreach($actList as $act){
                        $stf = $stuffModel->selectStuffById($act->getIdStuff());
                        //Ponemos a todas las actividades el mismo Id Historial
                        $stf->setIdHistorial($idHistorial);
                        $stuffModel->updateStuff($stf);
                        }
                    
                    
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
