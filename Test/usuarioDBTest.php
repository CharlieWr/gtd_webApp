<?php

require_once '../Model/UsuarioModel.php';


$modelo = new UsuarioModel();
function rellenaTablaUsuarios(){
    
    global $modelo;
    $user = new Usuario();
    $user->rellenaUsuario("carlosrg", "pswdCarlos", "Carlos", "Ruiz");
    $user2 = new Usuario();
    $user2->rellenaUsuario("danielm", "pswdDaniel", "Daniel", "Machado");
    $user3 = new Usuario();
    $user3->rellenaUsuario("raulra", "pswdRaul", "Raul", "Rodriguez");
    $user4 = new Usuario();
    $user4->rellenaUsuario("laurarg", "pswdLaura", "Laura", "Ruiz");
    $user5 = new Usuario();
    $user5->rellenaUsuario("claudiarg", "pswdClaudia", "Claudia", "Ruiz");

    


    $lastID = $modelo->insertarUsuario($user);
    echo $lastID . '<br/>';
    echo '<pre>'.print_r($user)."</pre>".'<br/>';

    $lastID = $modelo->insertarUsuario($user2);
    echo $lastID . '<br/>';
    echo '<pre>'.print_r($user2)."</pre>".'<br/>';


    $lastID = $modelo->insertarUsuario($user3);
    echo $lastID . '<br/>';
    echo '<pre>'.print_r($user3)."</pre>".'<br/>';


    $lastID = $modelo->insertarUsuario($user4);
    echo $lastID . '<br/>';
    echo '<pre>'.print_r($user4)."</pre>".'<br/>';


    $lastID = $modelo->insertarUsuario($user5);
    echo $lastID . '<br/>';
    echo '<pre>'.print_r($user5)."</pre>".'<br/>';
}



function showUsuarios(){
    for($i = 1; $i<=5;$i++){
        $usuario = $modelo->selectUsuarioById($i);
        echo "<pre>";
        print_r($usuario);
        echo "</pre>";
    }
}
rellenaTablaUsuarios();

?>

