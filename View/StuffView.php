<?php 
    require_once '../Control/StuffControl.php';
    require_once '../Control/UsuarioControl.php';
    session_start();
    $idUsuario = $_SESSION['idUsuario'];
    $usuarioControl = new UsuarioControl();
    $user = $usuarioControl->getUsuarioById($idUsuario);
    
    $stuffControl = new StuffControl();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Stuff Page</title>
    </head>
    <body>
        <h2>Lista Stuff de <?php echo $user->getNombre()." ".$user->getApellido(); ?></h2><br/>
        <?php
            $stuffList = $stuffControl->getStuffById($idUsuario);
            var_dump($stuffList);
        ?>
    </body>
</html>
