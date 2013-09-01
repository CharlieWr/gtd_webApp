<?php
//    echo date('d') .' / '. date('m') .' / '. date('Y')."<br/>";
            echo date('d/m/y H:i:s') .'<br/>';
            $date1 = date('Y').'/'.date('m').'/'.date('d H:i:s');
            $date2 = date('Y/m/d H:i:s',  mktime(7, 6, 2, 9, 2, 2013));
            $date3 = date('Y/m/d H:i:s',mktime(17,22,18, 9, 5, 2013));
            
            echo $date1 . "<br/>";
            echo $date2 . "<br/>";
            echo $date3 . "<br/>";
    

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
