<?php 
    require_once '../Control/StuffControl.php';
    require_once '../Control/UsuarioControl.php';
    session_start();
    $idUsuario = $_SESSION['idUsuario'];
    $usuarioControl = new UsuarioControl();
    $user = $usuarioControl->getUsuarioById($idUsuario);
    $stuffName = "Selecciona Stuff";
    $stuffDescription = "";
    
    $stuffControl = new StuffControl();
    $listStuff = $stuffControl->getAllStuffByUsuarioId($idUsuario);
    //Si hay algun stuff seleccionado
       if(isset($_GET['idSt'])){
           //Stuff asociada a Usuario
           $stuffAssoc = $stuffControl->getStuffById($_GET['idSt']);
           
           //Seleccionamos el nombre del Stuff
           $stuffName=$stuffAssoc->getNombre();
           $stuffDescription = $stuffAssoc->getDescripcion();
       }
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
                                        echo '</a>';
                                    }
                            ?>
                        </ul>
                </div>
                
                <div id="detalleStuff">
                    <div id="detalleTitulo">
                        <h3><?php echo $stuffName?></h3>
                        
                    </div>
                    <form>
                        <?php
//                            if(isset($_GET['idSt'])){
//                                $stuffAssoc = $stuffControl->getStuffById($_GET['idSt']);
//                                var_dump($stuffAssoc);
//                            }
                        ?>
                        <p>Nombre: 
                        <input type="text" name="stuffName" required="required" maxlength="255" value="<?php echo $stuffName=="Selecciona Stuff"? "": $stuffName?>">
                        </p>
                        <p>Descripcion: 
                            <textarea name="stuffDescription" rows="3" cols="25" maxlength="255" ><?php 
                                        echo $stuffDescription;
                                      ?></textarea>
                        </p>
                        <select type="select" name="stuffContext">
                            <?php
                                if(isset($stuffAssoc)){
                                    
                                }
                            ?>
                        </select>
                        
                    </form>
                </div>
            </div>
              <footer>
                Footer
             </footer>
        </div>
      
    </body>
</html>
