<?php
    require_once 'database_config.php';
    require_once '../Objects/Usuario.php';

    class UsuarioModel {
        
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
            * @param Usuario $usuario
            */
         public function insertarUsuario($usuario){
             if(!is_a($usuario, 'Usuario')){
                 die("Objeto no es de clase Usuario");
             }
             else{
               global $dbh;  
               $this->abrirConexion();
               $sth = $dbh->prepare("INSERT INTO Usuario (userName,password,nombre,apellido) value (:userName, :password,
                   :nombre, :apellido)"); 
               
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
         
    }
?>
