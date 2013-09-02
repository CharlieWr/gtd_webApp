<?php
    require_once '../Model/NextActionModel.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Test Next Action</title>
    </head>
    <body>
         <h1>Next Action Test</h1>
        <?php
           //Modelo Next Action
            $nextActionModel = new NextActionModel();
            
            
            
            function rellenaTablaNextAction(){
                global $nextActionModel;
                
                $nextAction1 = new NextAction();
                $nextAction1->rellenaNextAction("EmbajadaNA","NA; Valencia; familia",4);
                //NULL tags
                $nextAction2 = new NextAction();
                $nextAction2->rellenaNextAction("Oficina",NULL,6);
                 //NULL CONTEXTO
                $nextAction3 = new NextAction();
                $nextAction3->rellenaNextAction(NULL,"ir a super mercado",7);
               
                $nextActionID1 = $nextActionModel->insertarNextAction($nextAction1);
                $nextActionID2 = $nextActionModel->insertarNextAction($nextAction2);
                $nextActionID3 = $nextActionModel->insertarNextAction($nextAction3);
            
            }
            
            function testNextActionById(){
                global $nextActionModel;
//                for($i = 1; $i<4; $i++){
//                    $nextActionId = $nextActionModel->selectNextActionById($i);
//
//                    echo '<pre>';
//                    var_dump($nextActionId);
//                    echo '</pre>'. '<br/>';
//                }
                $nextActionId = $nextActionModel->selectNextActionById(1);

                    echo '<pre>';
                    var_dump($nextActionId);
                    echo '</pre>'. '<br/>';
                }
            
            function testAllNextAction(){
                global $nextActionModel;
                $arrayNextAction = $nextActionModel->selectAllNextAction();
                foreach($arrayNextAction as $singleNextAction){
                    
                    echo '<pre>';
                    var_dump($singleNextAction);
                    echo '</pre>'. '<br/>';
                }
                
            }
            
            
           
            function testUpdateNextAction(){
                global $nextActionModel;
      
                
                $nextAction = $nextActionModel->selectNextActionById(1);
                
                
                 echo '<pre>';
                 echo '<h6>NextAction Viejo</h6><br/>';
                 var_dump($nextAction);
                 echo '</pre>'. '<br/>';
                 
               
                $nextAction->setContexto("Universidad Suecia");
                $nextAction->setTags("PFC; Erasmus; Estudios;");
                
                $nextActionModel->updateNextAction($nextAction);
                $nextActionId = $nextActionModel->selectNextActionById(1);
                 echo '<pre>';
                  echo '<h6>NextAction Nuevo</h6><br/>';
                 var_dump($nextActionId);
                 echo '</pre>'. '<br/>';
            }
            
            
            function testDeleteNextAction(){
                global $nextActionModel;
                
                $nextActionModel->deleteNextActionById(1);
                
            }
            
            echo  "<h3>Rellena Next Action</h3> <br/>";
            rellenaTablaNextAction();
            echo "<h3>Next Action id 1</h3><br/>";
            testNextActionById();
            echo "<h3>All Next Action</h3><br/>";
            testAllNextAction();
            echo "<h3>Update Action 1</h3><br/>";
            testUpdateNextAction();
            echo "<h3>Delete Action 1</h3><br/>";
            testDeleteNextAction();
            echo "<h3>All Next Action</h3><br/>";
            testAllNextAction();
        ?>
    </body>
</html>
