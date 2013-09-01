<?php
    require_once '../Model/StuffModel.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Stuff Test</title>
    </head>
    <body>
        <h1>Stuff Test</h1>
        <?php
           //Modelo Stuff
            $stuffModel = new StuffModel();
            
            
            
            function rellenaTablaStuff(){
                global $stuffModel;
                $date1 = date('y/m/d H:i:s',time());
                $date2 = date('y/m/d H:i:s',  mktime(13, 13, 13, 3, 2, 2013));
                $date3 = date('y/m/d H:i:s', mktime(9, 9, 9, 9, 9, 2013));
                $stuff1 = new Stuff();
                $stuff1->rellenaStuff("Llamar Daniel","Debo llamar a Daniel",$date1,NULL,1,NULL);
                $stuff2 = new Stuff();
                $stuff2->rellenaStuff("Hacer Tarea",NULL,$date2,NULL,2,NULL);
                $stuff3 = new Stuff();
                $stuff3->rellenaStuff("Llamar Raul","Debo llamar a Raul",$date3,NULL,3,NULL);

                $stuffID1 = $stuffModel->insertarStuff($stuff1);
                $stuffID2 = $stuffModel->insertarStuff($stuff2);
                $stuffID3 = $stuffModel->insertarStuff($stuff3);
            
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
            
            function testAllStuff(){
                global $stuffModel;
                $arrayStuff = $stuffModel->selectAllStuff();
                foreach($arrayStuff as $singleStuff){
                    
                    echo '<pre>';
                    var_dump($singleStuff);
                    echo '</pre>'. '<br/>';
                }
                
            }
            
            
           
            function testUpdateStuff(){
                global $stuffModel;
                
                
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
            echo "<h3>Delete Stuff</h3> <br/>";
            
//            testAllStuff();
//            testDeleteStuff();
//             testAllStuff();
//            
            
//                 $date1 = date('y/m/d H:i:s', mktime(2, 9, 10, 8, 9, 2013));
//                $stuff1 = new Stuff();
//                $stuff1->rellenaStuff("Hacer esto ","Debo trabajar",$date1,NULL,1,3);
//                $stuffID1 = $stuffModel->insertarStuff($stuff1);
                
                
                testAllStuff();
                
                

        ?>
    </body>
</html>
