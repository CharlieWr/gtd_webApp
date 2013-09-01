<?php
 
    try {
         $dbh = new PDO("mysql:host=$hostname;dbname=mysql", $username, $password);
         
         // Enseñar errores DB
         $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
     $dbh = null;
        }
    catch(PDOException $e)
      {
        echo "ERROR: " .  $e->getMessage();
       }
?>
