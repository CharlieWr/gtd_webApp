<?php
    require_once 'database_config.php';
    require_once '../Objects/Tag.php';
  

    class TagModel {
        
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
            * @param Tag $tag
            */
         public function insertarTag($tag){
             if(!is_a($tag, 'Tag')){
                 die("Objeto no es de clase Tag");
             }
             else{
                 //Cambiar fecha de Stuff de creacion Tag
              
               global $dbh;  
               $this->abrirConexion();
               $sth = $dbh->prepare("INSERT INTO Tag (idStuff, nombreTag) 
                   value (:idStuff, :nombreTag)"); 
               
               $data = array('idStuff' => $tag->getIdStuff(), 'nombreTag' => $tag->getNombreTag());
               
               $sth->execute($data);  
               $id = $dbh->lastInsertID();
                $this->cerrarConexion();
               
              
               
               return $id;
               
             }
             
         }
        
         public function selectTagById($id){
             if(!is_numeric($id)){
                 die("ID Tag no es un entero");
             }
             else{
               global $dbh;  
               $this->abrirConexion();
               
               
                 $sth = $dbh->query("SELECT * FROM Tag t WHERE t.idTag = {$id} LIMIT 1");  
                 $sth->setFetchMode(PDO::FETCH_CLASS, 'Tag');  

                 $nextAction = $sth->fetch();
//                 while($obj = $STH->fetch()) {  
//                     echo $obj->addr;  
//                 }
             
               $this->cerrarConexion();
               return $nextAction;
             }
             
         }
         
        public function selectTagByStuffId($id){
             if(!is_numeric($id)){
                 die("ID Stuff no es un entero");
             }
             else{
               global $dbh;  
               $this->abrirConexion();
               
               
                 $sth = $dbh->query("SELECT * FROM Tag t WHERE t.idStuff = {$id}");  
                 $sth->setFetchMode(PDO::FETCH_CLASS, 'Tag');  

                 $res = array();
                 while($obj = $sth->fetch()) { 
                     $res[] = $obj;
//                     echo $obj->addr;  
                 }
               $this->cerrarConexion();
               return $res;
             }
             
         }
         
         
     
         public function selectAllTag(){
             
             global $dbh;
              $this->abrirConexion();
               
               
                 $sth = $dbh->query("SELECT * FROM Tag");  
                 $sth->setFetchMode(PDO::FETCH_CLASS, 'Tag');  

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
            * @param Tag $newTag
            */
         public function updateTag($newTag){
             if(!is_a($newTag, 'Tag')){
                 die("Objeto no es de clase Tag");
             }
             else{
                 
               global $dbh;  
               $this->abrirConexion();
              
              
               $sth = $dbh->prepare("UPDATE Tag SET nombreTag = :nombreTag WHERE idTag = :idTag"); 
               
               $data = array('nombreTag' => $newTag->getNombreTag(), 'idTag' => $newTag->getIdTag());
               
               $sth->execute($data);  
                      
               $this->cerrarConexion();
               
               
             }
             
         }
         
         public function deleteTagById($idTag){
              if(!is_numeric($idTag)){
                 die("ID Tag no es un entero");
             }
             else{
                 
                global $dbh;  
                $this->abrirConexion();
              
              
                $sth = $dbh->prepare("DELETE FROM Tag WHERE idTag =:idTag" );
                $sth->bindParam(":idTag", $idTag);
                $sth->execute();
                
                $this->cerrarConexion();
             }
             
         }
         
         public function deleteTagByIdStuff($idStuff){
             if(!is_numeric($idStuff)){
                 die("ID Stuff no es un entero");
             }
             else{
                 
                global $dbh;  
                $this->abrirConexion();
              
              
                $sth = $dbh->prepare("DELETE FROM Tag WHERE idStuff =:idStuff" );
                $sth->bindParam(":idStuff", $idStuff);
                $sth->execute();
                
                $this->cerrarConexion();
             }
         }
         
         
         
    }
?>
