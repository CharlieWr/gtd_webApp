<?php
    require_once 'database_config.php';
    require_once '../Objects/Proyecto.php';
    require_once 'StuffModel.php';

    class ProyectoModel {
        
        private $dbh;
        
        private function abrirConexion(){
           
            $userName = $GLOBALS['userName'];
            $hostName = $GLOBALS['hostName'];
            $password = $GLOBALS['password'];
//            echo $userName."</br>";
//            echo $hostName."</br>";
//            echo $password."</br>";
           
            global $dbh;
              try {
                $dbh = new PDO("mysql:host={$hostName};dbname=pfc_gtd", $userName, $password);

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
               
               $data = array('contexto' => $newProyecto->getContexto(), 'tags' => $newProyecto->getTags());
               
               $sth->execute($data);  
                      
               $this->cerrarConexion();
               
                //Actualizamos fecha de modificacion de Stuff
               $stuffModel = new StuffModel();
               $stuff = $stuffModel->selectStuffById($proyecto->getIdStuff());
               $stuff->setFecha($date1);
               $stuffModel->updateStuff($stuff);
               
             }
             
         }
         
         public function deleteStuffById($idStuff){
              if(!is_numeric($idStuff)){
                 die("ID Usuario no es un entero");
             }
             else{
                 
                global $dbh;  
                $this->abrirConexion();
              
              
                $sth = $dbh->prepare("DELETE FROM Stuff WHERE idStuff =:idStuff" );
                $sth->bindParam(":idStuff", $idStuff);
                $sth->execute();
                
                $this->cerrarConexion();
             }
             
         }
         
    }
?>
