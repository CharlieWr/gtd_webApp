<?php
    require_once 'database_config.php';
    require_once '../Objects/Stuff.php';

    class StuffModel {
        
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
            * @param Stuff $stuff
            */
         public function insertarStuff($stuff){
             if(!is_a($stuff, 'Stuff')){
                 die("Objeto no es de clase Stuff");
             }
             else{
                 
                     //Actualizamos la fecha de modificacion
               $date1 = date('y/m/d H:i:s',time());
               $stuff->setFecha($date1);
               
               
               global $dbh;  
               $this->abrirConexion();
               $sth = $dbh->prepare("INSERT INTO Stuff (nombre,descripcion,fecha,typeStuff,idUsuario,idHistorial) 
                   value (:nombre, :descripcion,:fecha, :typeStuff, :idUsuario, :idHistorial)"); 
               
               $data = array('nombre' => $stuff->getNombre(), 'descripcion' => $stuff->getDescripcion()
                       , 'fecha' => $stuff->getFecha(), 'typeStuff' => $stuff->getTypeStuff(),
                   'idUsuario' => $stuff->getIdUsuario(), 'idHistorial' => $stuff->getIdHistorial());
               
               $sth->execute($data);  
               $id = $dbh->lastInsertID();
               $this->cerrarConexion();
               
               return $id;
               
             }
             
         }
         
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
