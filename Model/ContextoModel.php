<?php
    require_once 'database_config.php';
    require_once '../Objects/Contexto.php';
  

    class ContextoModel {
        
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
            * @param Contexto $contexto
            */
         public function insertarContexto($contexto){
             if(!is_a($contexto, 'Contexto')){
                 die("Objeto no es de clase Contexto");
             }
             else{
                
              
               global $dbh;  
               $this->abrirConexion();
               $sth = $dbh->prepare("INSERT INTO Contexto (nombreContexto) 
                   value (:nombreContexto)"); 
               
               $data = array('nombreContexto' => $contexto->getNombreContexto());
               
               $sth->execute($data);  
               $id = $dbh->lastInsertID();
                $this->cerrarConexion();
               
              
               
               return $id;
               
             }
             
         }
        
         public function selectContextoById($id){
             if(!is_numeric($id)){
                 die("ID Contexto no es un entero");
             }
             else{
               global $dbh;  
               $this->abrirConexion();
               
               
                 $sth = $dbh->query("SELECT * FROM Contexto t WHERE t.idContexto = {$id} LIMIT 1");  
                 $sth->setFetchMode(PDO::FETCH_CLASS, 'Contexto');  

                 $nextAction = $sth->fetch();
//                 while($obj = $STH->fetch()) {  
//                     echo $obj->addr;  
//                 }
             
               $this->cerrarConexion();
               return $nextAction;
             }
             
         }
         
      
         
     
         public function selectAllContexto(){
             
             global $dbh;
              $this->abrirConexion();
               
               
                 $sth = $dbh->query("SELECT * FROM Contexto");  
                 $sth->setFetchMode(PDO::FETCH_CLASS, 'Contexto');  

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
            * @param Contexto $newContexto
            */
         public function updateContexto($newContexto){
             if(!is_a($newContexto, 'Contexto')){
                 die("Objeto no es de clase Contexto");
             }
             else{
                 
               global $dbh;  
               $this->abrirConexion();
              
              
               $sth = $dbh->prepare("UPDATE Contexto SET nombreContexto = :nombreContexto WHERE idContexto = :idContexto"); 
               
               $data = array('nombreContexto' => $newContexto->getNombreContexto(), 'idContexto' => $newContexto->getIdContexto());
               
               $sth->execute($data);  
                      
               $this->cerrarConexion();
               
               
             }
             
         }
         
         public function deleteContextoById($idContexto){
              if(!is_numeric($idContexto)){
                 die("ID Contexto no es un entero");
             }
             else{
                 
                global $dbh;  
                $this->abrirConexion();
              
              
                $sth = $dbh->prepare("DELETE FROM Contexto WHERE idContexto =:idContexto" );
                $sth->bindParam(":idContexto", $idContexto);
                $sth->execute();
                
                $this->cerrarConexion();
             }
             
         }
         
         
         
    }
?>
