<?php 
    require_once '../Control/StuffControl.php';
    require_once '../Control/UsuarioControl.php';
    session_start();
    $idUsuario = $_SESSION['idUsuario'];
    $usuarioControl = new UsuarioControl();
    $user = $usuarioControl->getUsuarioById($idUsuario);
    
    $stuffControl = new StuffControl();
    $listStuff = $stuffControl->getAllStuffByUsuarioId($idUsuario);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" href="./Style/generalStyle.css">
        <title>Process</title>
    </head>
    <body>
        <?php
        // put your code here
        ?>
     
        <div id="content">
            
            <header >
                 Header
            </header>
            <h1>Process</h1>
            <div id="stuffBox">
                <div id="listaStuff">
                    <div id="listaTitulo">
                     
                    </div>
                       <ul>
                            <?php 
                                    foreach ($listStuff as $st){
                                        echo '<a href="ProcessView.php?idSt='.$st->getIdStuff().'">';
                                        echo '<li id="itemStuff">'.$st->getNombre()."</li>";
                                    }
                            ?>
                        </ul>
                </div>
                
                <div id="detalleStuff">
                    <div id="detalleTitulo">
                        
                    </div>
                    <?php
                        if(isset($_GET['idSt'])){
                            $stuffAssoc = $stuffControl->getStuffById($_GET['idSt']);
                            var_dump($stuffAssoc);
                        }
                    ?>
                </div>
            </div>
              <footer>
                Footer
             </footer>
        </div>
      
    </body>
</html>
