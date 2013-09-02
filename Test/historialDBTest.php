<?php
    require_once '../Model/HistorialModel.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
        <?php
           //Modelo Historial
            $historialModel = new HistorialModel();
            
            
            
            function rellenaTablaHistorial(){
                global $historialModel;
                //no hace nada ya que la fecha se pone al insertar
                $date1 = date('y/m/d H:i:s',  mktime(15,20, 40,8,19,2013));
                $date2 = date('y/m/d H:i:s',  mktime(15, 13, 23, 7, 1, 2013));
                $date3 = date('y/m/d H:i:s', mktime(9, 10, 11, 9, 2, 2013));
                $historial1 = new Historial();
                $historial1->rellenaHistorial(true, $date1);
                $historial2 = new Historial();
                $historial2->rellenaHistorial(false,$date2);
                $historial3 = new Historial();
                $historial3->rellenaHistorial(true, $date3);

                $historialID1 = $historialModel->insertarHistorial($historial1);
                $historialD2 = $historialModel->insertarHistorial($historial2);
                $historialD3 = $historialModel->insertarHistorial($historial3);
            
            }
            
            function testHitorialById(){
                global $historialModel;
                for($i = 1; $i<4; $i++){
                    $historialId = $historialModel->selectHistorialById($i);

                    echo '<pre>';
                    var_dump($historialId);
                    echo '</pre>'. '<br/>';
                }
            }
            
            function testAllHistorial(){
                global $historialModel;
                $arrayHistorial = $historialModel->selectAllHistorial();
                foreach($arrayHistorial as $singleHistorial){
                    
                    echo '<pre>';
                    var_dump($singleHistorial);
                    echo '</pre>'. '<br/>';
                }
                
            }
            
            
           
            function testUpdateHistorial(){
                global $historialModel;
                
                
                $historial = $historialModel->selectHistorialById(1);
                
                
                 echo '<pre>';
                 echo '<h6>Historial Viejo</h6><br/>';
                 var_dump($historial);
                 echo '</pre>'. '<br/>';
                 
                 
                $historial->setCompletado(true);
                
                
                $historialModel->updateHistorial($historial);
                $historialId = $historialModel->selectHistorialById(1);
                 echo '<pre>';
                  echo '<h6>Stuff Nuevo</h6><br/>';
                 var_dump($historialId);
                 echo '</pre>'. '<br/>';
            }
            
            
            function testDeleteHistorial(){
                global $historialModel;
                
                $historialModel->deleteHistorialById(3);
                
            }
            
            rellenaTablaHistorial();
//            echo "<h3>Delete Historial</h3> <br/>";
//            
//            
//            testAllHistorial();
//            testDeleteHistorial();
//            
//            echo '<br/> ================== <br/>';
            testAllHistorial();
            
//             $date1 = drellenaTablaHistorialate('y/m/d H:i:s', mktime(19, 10, 11, 10, 2, 2013));
//             $historial1 = new Historial(true,$date1);
//             $historialID1 = $historialModel->insertarHistorial($historial1);
        ?>
    </body>
</html>
