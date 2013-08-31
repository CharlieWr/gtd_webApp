<?php 
    require_once '../Objects/nextAction.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Next Actions</title>
    </head>
    <body>
        <?php
        // put your code here
        $nextAction = new nextAction(1,"nextAction1","descripcionNA","08/'8/2013",
                1,11,"casa",array("next Action","trabajo"));
     
        echo "<pre>";
        var_dump($nextAction);
        echo "</pre>";
        ?>
    </body>
</html>
