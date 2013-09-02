<?php
    require_once '../Model/SomedayMaybeModel.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Test Someday Maybe</title>
    </head>
    <body>
         <h1>Someday Maybe Test</h1>
        <?php
           //Modelo Someday Maybe
            $somedayMaybeModel = new SomedayMaybeModel();
            
            
            
            function rellenaTablaSomedayMaybe(){
                global $somedayMaybeModel;
                
                $somedayMaybe1 = new SomedayMaybe();
                $somedayMaybe1->rellenaSomedayMaybe("Vaje en Familia","Familia; Viaje;","Medio",1);
                //NULL tags
                $somedayMaybe2 = new SomedayMaybe();
                $somedayMaybe2->rellenaSomedayMaybe("Aprender Aleman",NULL,"Largo",8);
                 //NULL CONTEXTO
                $somedayMaybe3 = new SomedayMaybe();
                $somedayMaybe3->rellenaSomedayMaybe(NULL,"Comprar movil nuevo","Corto",9);
               
                $somedayMaybeID1 = $somedayMaybeModel->insertarSomedayMaybe($somedayMaybe1);
                $somedayMaybeID2 = $somedayMaybeModel->insertarSomedayMaybe($somedayMaybe2);
                $somedayMaybeID3 = $somedayMaybeModel->insertarSomedayMaybe($somedayMaybe3);
            
            }
            
            function testSomedayMaybeById(){
                global $somedayMaybeModel;
//                for($i = 1; $i<4; $i++){
//                    $somedayMaybeId = $somedayMaybeModel->selectSomedayMaybeById($i);
//
//                    echo '<pre>';
//                    var_dump($somedayMaybeId);
//                    echo '</pre>'. '<br/>';
//                }
                $somedayMaybeId = $somedayMaybeModel->selectSomedayMaybeById(1);

                    echo '<pre>';
                    var_dump($somedayMaybeId);
                    echo '</pre>'. '<br/>';
                }
            
            function testAllSomedayMaybe(){
                global $somedayMaybeModel;
                $arraySomedayMaybe = $somedayMaybeModel->selectAllSomedayMaybe();
                foreach($arraySomedayMaybe as $singleSomedayMaybe){
                    
                    echo '<pre>';
                    var_dump($singleSomedayMaybe);
                    echo '</pre>'. '<br/>';
                }
                
            }
            
            
           
            function testUpdateSomedayMaybe(){
                global $somedayMaybeModel;
      
                
                $somedayMaybe = $somedayMaybeModel->selectSomedayMaybeById(1);
                
                
                 echo '<pre>';
                 echo '<h6>SomedayMaybe Viejo</h6><br/>';
                 var_dump($somedayMaybe);
                 echo '</pre>'. '<br/>';
                 
               
                $somedayMaybe->setContexto("Universidad");
                $somedayMaybe->setTags("PFC; Erasmus;");
                $somedayMaybe->setPlazo("Corto");
                
                $somedayMaybeModel->updateSomedayMaybe($somedayMaybe);
                $somedayMaybeId = $somedayMaybeModel->selectSomedayMaybeById(1);
                 echo '<pre>';
                  echo '<h6>SomedayMaybe Nuevo</h6><br/>';
                 var_dump($somedayMaybeId);
                 echo '</pre>'. '<br/>';
            }
            
            
            function testDeleteSomedayMaybe(){
                global $somedayMaybeModel;
                
                $somedayMaybeModel->deleteSomedayMaybeById(1);
                
            }
            
            echo  "<h3>Rellena Next Action</h3> <br/>";
            rellenaTablaSomedayMaybe();
            echo "<h3>Next Action id 1</h3><br/>";
            testSomedayMaybeById();
            echo "<h3>All Next Action</h3><br/>";
            testAllSomedayMaybe();
            echo "<h3>Update Action 1</h3><br/>";
            testUpdateSomedayMaybe();
            echo "<h3>Delete Action 1</h3><br/>";
            testDeleteSomedayMaybe();
            echo "<h3>All Next Action</h3><br/>";
            testAllSomedayMaybe();
        ?>
    </body>
</html>
