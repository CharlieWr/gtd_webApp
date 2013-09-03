<?php
    require_once '../Control/UsuarioControl.php';
    session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Home Page</title>
    </head>
    <body>
        <h3>Usuario</h3><br/>
        
        <p>Id: <?php $idUsuario =  $_SESSION['idUsuario']; echo $idUsuario; ?></p><br/>
        <?php 
            $usuarioControl = new UsuarioControl();
            $usuario = $usuarioControl->getUsuarioById($idUsuario);
            var_dump($usuario);
        ?>
        
        
        <a href="StuffView.php">Stuff</a>
        
    </body>
</html>
