<?php
    require_once 'database_config.php';
    require_once '../Objects/Proyecto.php';
    require_once 'StuffModel.php';

    class ProyectoModel {
        
        private $dbh;
        
           private function abrirConexion(){
           
            $userNameDB = $GLOBALS['userNameDB'];
            $hostNameDB = $GLOBALS['hostNameDB'];
            $passwordDB = $GLOBALS['passwordDB'];
//            echo $userNameDB."</br>";
//            echo $hostNameDB."</br>";
//            echo $passwordDB."</br>";
           
            global $dbh;
              try {
                $dbh = new PDO("mysql:host={$hostNameDB};dbname=pfc_gtd", $userNameDB, $passwordDB);

                 // Enseñar errores DB
                $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            }catch (PDOException $e) {
                 echo "ERROR: " . $e->getMessage();
            }
         }
         
         private function cerrarConexion(){
             global $dbh;
             $dbh = null;
         }
         
         /**
            * @param Proyecto $proyecto
            */
         public function insertarProyecto($proyecto){
             if(!is_a($proyecto, 'Proyecto')){
                 die("Objeto no es de clase Proyecto");
             }
             else{
                 //Cambiar fecha de Stuff de creacion Proyecto
              
               global $dbh;  
               $this->abrirConexion();
               $sth = $dbh->prepare("INSERT INTO Proyecto (contexto,tags,idStuff) 
                   value (:contexto, :tags,:idStuff)"); 
               
               $data = array('contexto' => $proyecto->getContexto(), 'tags' => $proyecto->getTags()
                       , 'idStuff' => $proyecto->getIdStuff());
               
               $sth->execute($data);  
               $id = $dbh->lastInsertID();
                $this->cerrarConexion();
                
                
               //Actualizamos la base de datos del Stuff y cambiamos su TypeStuff a 'P'
               $stuffModel = new StuffModel();
               $stuff = $stuffModel->selectStuffById($proyecto->getIdStuff());
               $stuff->setTypeStuff("P");
               $stuffModel->updateStuff($stuff);
               
              
               
               return $id;
               
             }
             
         }
        
         public function selectProyectoById($id){
             if(!is_numeric($id)){
                 die("ID Proyecto no es un entero");
             }
             else{
               global $dbh;  
               $this->abrirConexion();
               
               
                 $sth = $dbh->query("SELECT * FROM Proyecto p WHERE p.idProyecto = {$id} LIMIT 1");  
                 $sth->setFetchMode(PDO::FETCH_CLASS, 'Proyecto');  

                 $proyecto = $sth->fetch();
//                 while($obj = $STH->fetch()) {  
//                     echo $obj->addr;  
//                 }
         
               $this->cerrarConexion();
               return $proyecto;
             }
             
         }
         
         public function selectAllProyecto(){
             
             global $dbh;
              $this->abrirConexion();
               
               
                 $sth = $dbh->query("SELECT * FROM Proyecto");  
                 $sth->setFetchMode(PDO::FETCH_CLASS, 'Proyecto');  

//                 $stuff = $sth->fetch();
                 $res = array();
                 while($obj = $sth->fetch()) { 
                     $res[] = $obj;
//                     echo $obj->addr;  
                 }
             
               $this->cerrarConexion();
               return $res;
         }
         
          /**
            * @param Proyecto $newProyecto
            */
         public function updateProyecto($newProyecto){
             if(!is_a($newProyecto, 'Proyecto')){
                 die("Objeto no es de clase Proyecto");
             }
             else{
                 
                  //Actualizamos la fecha de modificacion de Stuff
               $date1 = date('y/m/d H:i:s',time());
               $newProyecto->setFecha($date1);
           
               
               global $dbh;  
               $this->abrirConexion();
              
              
               $sth = $dbh->prepare("UPDATE Proyecto SET contexto = :contexto,
                   tags = :tags WHERE idProyecto = :idProyecto"); 
               
               $data = array('contexto' => $newProyecto->getContexto(), 'tags' => $newProyecto->getTags(), 'idProyecto' => $newProyecto->getIdProyecto());
               
               $sth->execute($data);  
                      
               $this->cerrarConexion();
               
                //Actualizamos fecha de modificacion de Stuff
               $stuffModel = new StuffModel();
               $stuff = $stuffModel->selectStuffById($newProyecto->getIdStuff());
               $stuff->setFecha($date1);
               $stuffModel->updateStuff($stuff);
               
             }
             
         }
         
         public function deleteProyectoById($idProyecto){
              if(!is_numeric($idProyecto)){
                 die("ID Proyecto no es un entero");
             }
             else{
                 
                global $dbh;  
                $this->abrirConexion();
              
              
                $sth = $dbh->prepare("DELETE FROM Proyecto WHERE idProyecto =:idProyecto" );
                $sth->bindParam(":idProyecto", $idProyecto);
                $sth->execute();
                
                $this->cerrarConexion();
             }
             
         }
         
         //Inserta Next Action asociada a un Proyecto
         public function insertActividadAProyecto($proy, $act){
             if(!is_a($proy,'Proyecto') || !is_a($act,'NextAction')){
                 die("proyecto o actividad no son de una clase Proyecto/NextAction valida");
             }
             else{
                global $dbh;  
                $this->abrirConexion();
                
                
               $sth = $dbh->prepare("INSERT INTO Proyecto_has_Next_Action (idProyecto,idNextAction) 
                   value (:idProyecto, :idNextAction)"); 
               
               $data = array('idProyecto' => $proy->getIdProyecto(), 'idNextAction' => $act->getIdNextAction());
               
               $sth->execute($data);  
               $id = $dbh->lastInsertID();
               $this->cerrarConexion();
                
                return $id;
                 
             }
         }
         
         public function eliminarActividadAProyecto($idProy, $idAct){
             if(!is_numeric($idProy) || !is_numeric($idAct)){
                 die("Id Proyecto o Id Next Action no es un numero entero");
             }
             else{
                 
                global $dbh;  
                $this->abrirConexion();
                     
                $sth = $dbh->prepare("DELETE FROM Proyecto_has_Next_Action WHERE idProyecto = :idProyecto AND
                    idNextAction = :idNextAction" );
                $sth->bindParam(":idProyecto", $idProy);
                $sth->bindParam(":idNextAction", $idAct);
                $sth->execute();
                
                
                $this->cerrarConexion();
                
             }
         }
         
         
         //Dado un id de Proyecto devuelve Array de id Actividades asociadas
         public function obtenerActividadesDeProyecto($idProy){
             if(!is_numeric($idProy) ){
                 die("id proyecto no es de  tipo entero");
             }
             else{
                 global $dbh;  
                 $this->abrirConexion();
               
               
                 $sth = $dbh->query("SELECT * FROM Proyecto_had_Next_Action pna WHERE pna.idProyecto = {$idProy} LIMIT 1");  
                 $sth->setFetchMode(PDO::FETCH_ASSOC); 

                $actividades =  array();
                while($row = $sth->fetch()) {  
                    $actividades[]=$row['idNextAction']; 
                }  
         
               $this->cerrarConexion();
               return $actividades;
             }
         }
         
    }
?>
