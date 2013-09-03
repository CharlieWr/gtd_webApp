<?php
    require_once '../Model/UsuarioModel.php';
    require_once '../Objects/Usuario.php';
    
    class UsuarioControl {
        
        
        //Dado un userName y password comprueba que existe en la base de datos y devuelve
        //su Id en caso de que exista o Null en caso contrario
        public function comprobarUsuario($userName, $password){
            $usuarioModel = new UsuarioModel();
            
            $usuario = $usuarioModel->comprobarUsuario($userName, $password);
            
            if($usuario){
                return $usuario->getIdUsuario();
            }
            else{
                
                return NULL;
            }
            
        }
        
        
        public function getUsuarioById($id){
            if(!is_numeric($id)){
                die("Id debe ser numero entero valido");
            }
            else{
                $usuarioModel = new UsuarioModel();
                $usuario = $usuarioModel->selectUsuarioById($id);
                return $usuario;
            }
            
        }
        
    }
?>
