<?php
   require_once 'database_config.php';
    require_once '../Objects/Historial.php';

    class HistorialModel {
        
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
            * @param Historial $historial
            */
         public function insertarHistorial($historial){
             if(!is_a($historial, 'Historial')){
                 die("Objeto no es de clase Historial");
             }
             else{
                 
               //Actualizamos la fecha de modificacion
               $date1 = date('y/m/d H:i:s',time());
               $historial->setFechaHistorial($date1);
               
               
               global $dbh;  
               $this->abrirConexion();
               $sth = $dbh->prepare("INSERT INTO Historial (completado,fechaHistorial) 
                   value (:completado,:fechaHistorial)"); 
               
               $data = array('completado' => $historial->getCompletado(), 'fechaHistorial' => $historial->getFechaHistorial());
               
               $sth->execute($data);  
               $id = $dbh->lastInsertID();
               $this->cerrarConexion();
               
               return $id;
               
             }
             
         }
         
         public function selectHistorialById($id){
             if(!is_numeric($id)){
                 die("ID Historial no es un entero");
             }
             else{
               global $dbh;  
               $this->abrirConexion();
               
               
                 $sth = $dbh->query("SELECT * FROM Historial h WHERE h.idHistorial = {$id} LIMIT 1");  
                 $sth->setFetchMode(PDO::FETCH_CLASS, 'Historial');  

                 $historial = $sth->fetch();
//                 while($obj = $STH->fetch()) {  
//                     echo $obj->addr;  
//                 }
             
               $this->cerrarConexion();
               return $historial;
             }
             
         }
         
         public function selectAllHistorial(){
             
             global $dbh;
              $this->abrirConexion();
               
               
                 $sth = $dbh->query("SELECT * FROM Historial");  
                 $sth->setFetchMode(PDO::FETCH_CLASS , 'Historial');  

//                 $stuff = $sth->fetch();
                 $res = array();
                 while($obj = $sth->fetch()) { 
                     $res[] = $obj;
//                     echo $obj->addr;  
                 }
             
               $this->cerrarConexion();
               return $res;
         }
         
         
         public function updateHistorial($newHistorial){
             if(!is_a($newHistorial, 'Historial')){
                 die("Objeto no es de clase Historial");
             }
             else{
                 
               //Actualizamos la fecha de modificacion
               $date1 = date('y/m/d H:i:s',time());
               $newHistorial->setFechaHistorial($date1);
               
               global $dbh;  
               $this->abrirConexion();
              
              
               $sth = $dbh->prepare("UPDATE Historial SET completado = :completado"); 
               
               $completado =  $newHistorial->getCompletado();
                $sth->bindParam(":completado",$completado);
                $sth->execute();
               
               $this->cerrarConexion();
               
                 
             }
             
         }
         
         public function deleteHistorialById($idHistorial){
              if(!is_numeric($idHistorial)){
                 die("ID Historial no es un entero");
             }
             else{
                 
                global $dbh;  
                $this->abrirConexion();
              
              
                $sth = $dbh->prepare("DELETE FROM Historial WHERE idHistorial =:idHistorial" );
                $sth->bindParam(":idHistorial", $idHistorial);
                $sth->execute();
                
                $this->cerrarConexion();
             }
             
         }
         
    }
?>
