<?php
    require_once 'database_config.php';
    require_once '../Objects/Usuario.php';

    class UsuarioModel {
        
        private $dbh;
        
        private function abrirConexion(){
           
            $userNameDB = $GLOBALS['userNameDB'];
            $hostNameDB = $GLOBALS['hostNameDB'];
            $passwordDB = $GLOBALS['passwordDB'];
//            echo $userName."</br>";
//            echo $hostName."</br>";
//            echo $password."</br>";
           
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
            * @param Usuario $usuario
            */
         public function insertarUsuario($usuario){
             if(!is_a($usuario, 'Usuario')){
                 die("Objeto no es de clase Usuario");
             }
             else{
                 
            
               global $dbh;  
               $this->abrirConexion();
               $sth = $dbh->prepare("INSERT INTO Usuario (userName,password,nombre,apellido) 
                   value (:userName, :password,:nombre, :apellido)"); 
               
               $data = array('userName' => $usuario->getUserName(), 'password' => $usuario->getPassword()
                       , 'nombre' => $usuario->getNombre(), 'apellido' => $usuario->getApellido());
               
               $sth->execute($data);  
               $id = $dbh->lastInsertID();
               $this->cerrarConexion();
               
               return $id;
               
             }
             
         }
         
         public function selectUsuarioById($id){
             if(!is_numeric($id)){
                 die("ID Usuario no es un entero");
             }
             else{
               global $dbh;  
               $this->abrirConexion();
               
               
                 $sth = $dbh->query("SELECT * FROM Usuario u WHERE u.idUsuario = {$id} LIMIT 1");  
                 $sth->setFetchMode(PDO::FETCH_CLASS, 'Usuario');  

                 $usuario = $sth->fetch();
//                 while($obj = $STH->fetch()) {  
//                     echo $obj->addr;  
//                 }
             
               $this->cerrarConexion();
               return $usuario;
             }
             
         }
         
         public function selectAllUsuario(){
             
             global $dbh;
              $this->abrirConexion();
               
               
                 $sth = $dbh->query("SELECT * FROM Usuario");  
                 $sth->setFetchMode(PDO::FETCH_CLASS, 'Usuario');  

//                 $usuario = $sth->fetch();
                 $res = array();
                 while($obj = $sth->fetch()) { 
                     $res[] = $obj;
//                     echo $obj->addr;  
                 }
             
               $this->cerrarConexion();
               return $res;
         }
         //Comprueba que existe un usuario en la base de datos con $username y $password
         //devuelve false si no existe o el usuario
         public function comprobarUsuario($userName, $password){
                 global $dbh;
             
                 $this->abrirConexion();
             
                 
                $sth = $dbh->prepare("SELECT * FROM Usuario u WHERE u.userName = :userName AND u.password = :password LIMIT 1");
                
                $data = array("userName" => $userName, "password" => $password);
                $sth->setFetchMode(PDO::FETCH_CLASS, 'Usuario');  
                $sth->execute($data);

                $usuario = $sth->fetch();
    //                 while($obj = $STH->fetch()) {  
    //                     echo $obj->addr;  
    //                 }

                $this->cerrarConexion();
                return $usuario;
             
         }
         public function updateUsuario($newUsuario){
             if(!is_a($newUsuario, 'Usuario')){
                 die("Objeto no es de clase Usuario");
             }
             else{
                
               global $dbh;  
               $this->abrirConexion();
              
              
               $sth = $dbh->prepare("UPDATE Usuario SET userName = :userName,
                   password = :password, nombre= :nombre, apellido= :apellido WHERE idUsuario = :idUsuario"); 
               
               $data = array('userName' => $newUsuario->getUserName(), 'password' => $newUsuario->getPassword()
                       , 'nombre' => $newUsuario->getNombre(), 'apellido' => $newUsuario->getApellido(),
                   'idUsuario' => $newUsuario->getIdUsuario());
               
               $sth->execute($data);  
               
               $this->cerrarConexion();
               
                 
             }
             
         }
         
         public function deleteUsuarioById($idUsuario){
              if(!is_numeric($idUsuario)){
                 die("ID Usuario no es un entero");
             }
             else{
                 
                global $dbh;  
                $this->abrirConexion();
              
              
                $sth = $dbh->prepare("DELETE FROM Usuario WHERE idUsuario =:idUsuario" );
                $sth->bindParam(":idUsuario", $idUsuario);
                $sth->execute();
                
                $this->cerrarConexion();
             }
             
         }
         
    }
?>
