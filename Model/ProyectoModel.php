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
         //TODO HACER
         public function selectStuffById($id){
             if(!is_numeric($id)){
                 die("ID Usuario no es un entero");
             }
             else{
               global $dbh;  
               $this->abrirConexion();
               
               
                 $sth = $dbh->query("SELECT * FROM Stuff s WHERE s.idStuff = {$id} LIMIT 1");  
                 $sth->setFetchMode(PDO::FETCH_CLASS, 'Stuff');  

                 $stuff = $sth->fetch();
//                 while($obj = $STH->fetch()) {  
//                     echo $obj->addr;  
//                 }
             
               $this->cerrarConexion();
               return $stuff;
             }
             
         }
         
         public function selectAllStuff(){
             
             global $dbh;
              $this->abrirConexion();
               
               
                 $sth = $dbh->query("SELECT * FROM Stuff s");  
                 $sth->setFetchMode(PDO::FETCH_CLASS, 'Stuff');  

//                 $stuff = $sth->fetch();
                 $res = array();
                 while($obj = $sth->fetch()) { 
                     $res[] = $obj;
//                     echo $obj->addr;  
                 }
             
               $this->cerrarConexion();
               return $res;
         }
         
         
         public function updateStuff($newStuff){
             if(!is_a($newStuff, 'Stuff')){
                 die("Objeto no es de clase Stuff");
             }
             else{
                 
                  //Actualizamos la fecha de modificacion
               $date1 = date('y/m/d H:i:s',time());
               $newStuff->setFecha($date1);
               
               global $dbh;  
               $this->abrirConexion();
              
              
               $sth = $dbh->prepare("UPDATE Stuff SET nombre = :nombre,
                   descripcion = :descripcion, fecha = :fecha, typeStuff = :typeStuff WHERE idStuff = :idStuff"); 
               
               $data = array('nombre' => $newStuff->getNombre(), 'descripcion' => $newStuff->getDescripcion()
                       , 'fecha' => $newStuff->getFecha(), 'typeStuff' => $newStuff->getTypeStuff(), 'idStuff' => $newStuff->getIdStuff());
               
               $sth->execute($data);  
               
               $this->cerrarConexion();
               
                 
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
