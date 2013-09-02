<?php
    require_once '../Model/ProyectoModel.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Test Proyecto</title>
    </head>
    <body>
         <h1>Stuff Test</h1>
        <?php
           //Modelo Stuff
            $proyectoModel = new ProyectoModel();
            
            
            
            function rellenaTablaProyecto(){
                global $proyectoModel;
                
                $proyecto1 = new Proyecto();
                $proyecto1->rellenaProyecto("Casa","proyecto; casa; familia",3);
                //NULL tags
                $proyecto2 = new Proyecto();
                $proyecto2->rellenaProyecto("Oficina",NULL,2);
                 //NULL CONTEXTO
                $proyecto3 = new Proyecto();
                $proyecto3->rellenaProyecto(NULL,"proyecto",5);
               
                $proyectoID1 = $proyectoModel->insertarProyecto($proyecto1);
                $proyectoID2 = $proyectoModel->insertarProyecto($proyecto2);
                $proyectoID3 = $proyectoModel->insertarProyecto($proyecto3);
            
            }
            
            function testStuffById(){
                global $stuffModel;
                for($i = 1; $i<4; $i++){
                    $stuffId = $stuffModel->selectStuffById($i);

                    echo '<pre>';
                    var_dump($stuffId);
                    echo '</pre>'. '<br/>';
                }
            }
            
            function testAllProyecto(){
                global $proyectoModel;
                $arrayProyecto = $proyectoModel->selectAllProyecto();
                foreach($arrayProyecto as $singleProyecto){
                    
                    echo '<pre>';
                    var_dump($singleProyecto);
                    echo '</pre>'. '<br/>';
                }
                
            }
            
            
           
            function testUpdateStuff(){
                global $stuffModel;
                /////////////////
                
                $stuff = $stuffModel->selectStuffById(1);
                
                
                 echo '<pre>';
                 echo '<h6>Stuff Viejo</h6><br/>';
                 var_dump($stuff);
                 echo '</pre>'. '<br/>';
                 
                 
                $stuff->setNombre("Llamar a Nadie");
                $stuff->setDescripcion("No debo llamar a nadie");
                
                $stuffModel->updateStuff($stuff);
                $stuffId = $stuffModel->selectStuffById(1);
                 echo '<pre>';
                  echo '<h6>Stuff Nuevo</h6><br/>';
                 var_dump($stuffId);
                 echo '</pre>'. '<br/>';
            }
            
            
            function testDeleteStuff(){
                global $stuffModel;
                
                $stuffModel->deleteStuffById(1);
                
            }
            echo "<h3>Select All  Proyecto</h3> <br/>";
            
          

        ?>
    </body>
</html>
