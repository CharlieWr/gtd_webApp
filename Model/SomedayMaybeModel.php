<?php
    require_once 'database_config.php';
    require_once '../Objects/SomedayMaybe.php';
    require_once 'StuffModel.php';

    class SomedayMaybeModel {
        
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
            * @param SomedayMaybe $nextSM
          * 
          * @return Devueluve ID de objeto insertado
            */
         public function insertarSomedayMaybe($nextSM){
             if(!is_a($nextSM, 'SomedayMaybe')){
                 die("Objeto no es de clase SomedayMaybe");
             }
             else{
               
              
               global $dbh;  
               $this->abrirConexion();
               $sth = $dbh->prepare("INSERT INTO SomedayMaybe (plazo,idStuff) 
                   value (:plazo, :idStuff)"); 
               
               $data = array('plazo' => $nextSM->getPlazo(),  'idStuff' => $nextSM->getIdStuff());
               
               $sth->execute($data);  
               $id = $dbh->lastInsertID();
                $this->cerrarConexion();
                
                
               //Actualizamos la base de datos del Stuff y cambiamos su TypeStuff a 'S'
               $stuffModel = new StuffModel();
               $stuff = $stuffModel->selectStuffById($nextSM->getIdStuff());
               $stuff->setTypeStuff("S");
               $stuffModel->updateStuff($stuff);
               
              
               
               return $id;
               
             }
             
         }
        
         public function selectSomedayMaybeById($id){
             if(!is_numeric($id)){
                 die("ID SomedayMaybe no es un entero");
             }
             else{
               global $dbh;  
               $this->abrirConexion();
               
               
                 $sth = $dbh->query("SELECT * FROM SomedayMaybe sm WHERE sm.idSomedayMaybe = {$id} LIMIT 1");  
                 $sth->setFetchMode(PDO::FETCH_CLASS, 'SomedayMaybe');  

                 $somedayM = $sth->fetch();
//                 while($obj = $STH->fetch()) {  
//                     echo $obj->addr;  
//                 }
             
               $this->cerrarConexion();
               return $somedayM;
             }
             
         }
         
             public function selectSomedayMaybeByStuffId($id){
             if(!is_numeric($id)){
                 die("ID Stuff no es un entero");
             }
             else{
               global $dbh;  
               $this->abrirConexion();
               
               
                 $sth = $dbh->query("SELECT * FROM SomedayMaybe sm WHERE sm.idStuff = {$id} LIMIT 1");  
                 $sth->setFetchMode(PDO::FETCH_CLASS, 'SomedayMaybe');  

                 $somedayM = $sth->fetch();
//                 while($obj = $STH->fetch()) {  
//                     echo $obj->addr;  
//                 }
             
               $this->cerrarConexion();
               return $somedayM;
             }
             
         }
         
         public function selectAllSomedayMaybe(){
             
             global $dbh;
              $this->abrirConexion();
               
               
                 $sth = $dbh->query("SELECT * FROM SomedayMaybe");  
                 $sth->setFetchMode(PDO::FETCH_CLASS, 'SomedayMaybe');  

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
            * @param SomedayMaybe $newSM
            */
         public function updateSomedayMaybe($newSM){
             if(!is_a($newSM, 'SomedayMaybe')){
                 die("Objeto no es de clase Next Action");
             }
             else{
                 
                  //Actualizamos la fecha de modificacion de Stuff
               $date1 = date('y/m/d H:i:s',time());
               $newSM->setFecha($date1);
           
               
               global $dbh;  
               $this->abrirConexion();
              
              
               $sth = $dbh->prepare("UPDATE SomedayMaybe SET plazo = :plazo WHERE idSomedayMaybe = :idSomedayMaybe"); 
               
               $data = array('plazo' => $newSM->getPlazo() ,'idSomedayMaybe' => $newSM->getIdSomedayMaybe());
               
               $sth->execute($data);  
                      
               $this->cerrarConexion();
               
                //Actualizamos fecha de modificacion de Stuff
               $stuffModel = new StuffModel();
               $stuff = $stuffModel->selectStuffById($newSM->getIdStuff());
               $stuff->setFecha($date1);
               $stuffModel->updateStuff($stuff);
               
             }
             
         }
         
         public function deleteSomedayMaybeById($idSM){
              if(!is_numeric($idSM)){
                 die("ID SomedayMaybe no es un entero");
             }
             else{
                 
                global $dbh;  
                $this->abrirConexion();
              
              
                $sth = $dbh->prepare("DELETE FROM SomedayMaybe WHERE idSomedayMaybe =:idSomedayMaybe" );
                $sth->bindParam(":idSomedayMaybe", $idSM);
                $sth->execute();
                
                $this->cerrarConexion();
             }
             
         }
         
              public function deleteSomedayMaybeByStuffId($idSt){
              if(!is_numeric($idSt)){
                 die("ID SomedayMaybe no es un entero");
             }
             else{
                 
                global $dbh;  
                $this->abrirConexion();
              
              
                $sth = $dbh->prepare("DELETE FROM SomedayMaybe WHERE idStuff =:idStuff" );
                $sth->bindParam(":idStuff", $idSt);
                $sth->execute();
                
                $this->cerrarConexion();
             }
             
         }
         
    }
?>
