<?php 
    require_once '../Control/StuffControl.php';
    require_once '../Control/UsuarioControl.php';
    require_once '../Control/ContextoControl.php';
    require_once '../Control/TagControl.php';
    
    session_start();
    $idUsuario = $_SESSION['idUsuario'];
    $usuarioControl = new UsuarioControl();
    $stuffControl = new StuffControl();
     $tagControl = new TagControl();
     
    $user = $usuarioControl->getUsuarioById($idUsuario);
    $stuffName = "Selecciona Stuff";
    $stuffDescription = "";
    
        //Si se ha hecho click en Aceptar (Guardar Stuff)
      if(isset($_POST['saveStuff'])){
          $newNombre = $_POST['stuffName'];
          $newDescripcion = $_POST['stuffDescription'];
          $newIdContexto = $_POST['stuffContext']==""? NULL : $_POST['stuffContext'];
          $newTags = $_POST['stuffTag'];
          $newIdStuff = $_POST['idStuffForm'];
          $newInfo = array("nombre" => $newNombre, "descripcion" => $newDescripcion, "idContexto" => $newIdContexto,
              "tag" => $newTags, "idStuff" => $newIdStuff, "idUsuario"=>$idUsuario,"typeStuff" => NULL,"idHistorial" => NULL);
          $stuffControl->insertStuff($newInfo);
      }
       
    
    $listStuff = $stuffControl->getAllStuffByUsuarioId($idUsuario);
    
    $contextControl = new ContextoControl();
    $contextList = $contextControl->getAllContexto();
    
   
    $tagList = NULL;
    
    $stuffAssoc = NULL;
    
    $stuffSeleccionada = false;
    //Si hay algun stuff seleccionado
       if(isset($_GET['idSt'])){
           //Stuff asociada a Usuario
           $stuffAssoc = $stuffControl->getStuffById($_GET['idSt']);
           $stuffSeleccionada = true;
           //Seleccionamos el nombre del Stuff
           $stuffName=$stuffAssoc->getNombre();
           $stuffDescription = $stuffAssoc->getDescripcion();
           $tagList = $tagControl->getTagByStuffId($_GET['idSt']);
       }
       
       //Si es un nuevo Stuff
       if(isset($_GET['new'])){
           $stuffSeleccionada = true;
           $newStuff = new Stuff();
           $newStuff->setNombre("Nuevo Stuff");
           //Se inserta al inicio de Array nuevo Stuff vacio
           array_unshift($listStuff,$newStuff);
           
       }
       
  
?> 
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
        <link rel="stylesheet" href="./Style/generalStyle.css">
        <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
        <title>Process</title>
    </head>
    <body>
<!--        <script>
            $(document).ready(function(){
            $('#deleteForm').submit(function() {
                alert('Delete Form');
                return false;
              });
              });
//            $('#acceptForm').submit(function() {
//                alert('Accept Form');
//                return false;
//              });
        </script>-->
        <div id="content">
            
            <header >
                 Header
            </header>
            <h1>Process</h1>
       
         
            <div id="stuffBox">
                <div id="listaStuff">
                    <div id="listaTitulo">
                        <h2>Inbox</h2>
                        <a href="ProcessView.php?new=1">
                            <p><strong>+</strong></p>
                        </a>
                        
                    </div>
                       <ul>
                            <?php 
                            
                                    foreach ($listStuff as $st){
                                      
                                        //Si hay stuff seleccionada cambiamos el estilo
                                        if($stuffAssoc && $st->getIdStuff() == $stuffAssoc->getIdStuff()){
                                            echo '<li id="itemStuff" style="background-color: steelblue;color: aliceblue; border: 3px aliceblue solid;">'.$st->getNombre()."</li>";
                                        }
                                        //Si se esta creando un nuevo Stuff y esta ese seleccionado
                                        elseif (isset($newStuff) && $st->getNombre()=="Nuevo Stuff") {
                                             echo '<li id="itemStuff" style="background-color: steelblue;color: aliceblue; border: 3px aliceblue solid;">'.$st->getNombre()."</li>";
                                            
                                         }
                                         else{
                                               echo '<a href="ProcessView.php?idSt='.$st->getIdStuff().'">';
                                               echo '<li id="itemStuff">'.$st->getNombre()."</li>";
                                                echo '</a>';
                                         }
                                       
                                    }
                            ?>
                        </ul>
                </div>
                
                <div id="detalleStuff">
                    <div id="detalleTitulo">
                        <h3><?php echo $stuffName?></h3>
                     
                        
                    </div>
                   
                    <form id='modifyStuff' action='ProcessView.php' method='post' accept-charset='UTF-8'>
                        <table>
                            <tr>
                                <td>
                                    <p>Nombre:</p>
                                </td>
                                <td>
                                    <input type="text" name="stuffName" required="required" maxlength="255" value="<?php 
                                    echo $stuffName=="Selecciona Stuff"? "": $stuffName;?>" <?php echo $stuffSeleccionada? "" : 'readonly'?>>
                                </td>
                                <td>
                                    <p><?php echo $stuffAssoc==NULL? date("d/m/Y H:i:s", time()) : date("d/m/Y H:i:s",  strtotime($stuffAssoc->getFecha()));?></p>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p>Descripcion:</p>
                                </td>
                                <td>
                                    <textarea name="stuffDescription" rows="3" cols="25" maxlength="255" <?php echo $stuffSeleccionada? "" : 'readonly'?> ><?php 
                                                echo $stuffDescription;
                                              ?></textarea>
                                 </td>
                           
                            </tr>
                            <tr>
                                <td>
                                    <p>Contexto:</p>
                                </td>
                                <td>
                                    <select type="select" name="stuffContext">
                                        <?php
                                                  echo '<option value = "" ></option>';
                                                  foreach ($contextList as $auxCont){
                                                      //Si la stuff a añadir es la que tiene asociada la stuff selecionada
                                                      if($stuffSeleccionada && $auxCont->getIdContexto()==$stuffAssoc->getIdContexto()){
                                                            echo '<option value="'.$auxCont->getIdContexto().'" selected>';
                                                            echo $auxCont->getNombreContexto().'</option>';
                                                      }
                                                      else{
                                                          echo '<option value="'.$auxCont->getIdContexto().'">';
                                                          echo $auxCont->getNombreContexto().'</option>';
                                                      
                                                      }
                                                  }
                                        ?>
                                    </select>
                               </td>
                            
                            </tr>
                            <tr>
                                <td>
                                    <p>Tags:</p>
                                </td>
                                <td>
                                    
                                    <?php
                                    echo '<input type="text" name="stuffTag" title="Separa Tags con Punto y Coma ( ; )" value="';
                                    if($tagList){
                                        foreach($tagList as $singleTag){
                                            echo $singleTag->getNombreTag().'; ';
                                        }
                                    }
                                   
//                                    echo '"';
                                    //Si no hay stuff seleccionada nada es editable
                                    echo $stuffSeleccionada? '">' : '" readonly>'
                                ?>
                                </td>
                        </tr>
                        <tr >
                            <td>
                                <?php 
                                   //Mostramos solo botones input si hay stuff seleccionada
                                if($stuffSeleccionada){
                                    echo ' <input type="submit"  name="deleteStuff" value="Delete" />';
                                }
                                
                                ?>
                               
                            </td>
                            <td>
                                <input type="hidden" name="idStuffForm" value="<?php echo isset($stuffAssoc)? $stuffAssoc->getIdStuff() : NULL;?>">
                            </td>
                            <td>
                                <?php 
                                       //Mostramos solo botones input si hay stuff seleccionada
                                    if($stuffSeleccionada){
                                     echo '<input type="submit"  name="saveStuff" value="Save" />';
                                    }  
                                ?>
                            </td>
                        </tr>
                        
                        
                       </table> 
                    </form>
                </div>
            </div>
              <footer>
                Footer
             </footer>
        </div>
      
    </body>
</html>
