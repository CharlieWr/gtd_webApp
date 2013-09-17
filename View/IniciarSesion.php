<?php
	require_once("../Control/funciones.php");
	require_once("../Control/UsuarioControl.php");
        
        session_start();
        session_destroy();
	
	if (isset($_POST['submit'])) {
		// form was submitted
		$username = $_POST["username"];
		$password = $_POST["password"];

                
                //VALIDAR DATOS Y COMPROBAR CON BASE DE DATOS
                $usuarioControl = new UsuarioControl();
                $idUsuario = $usuarioControl->comprobarUsuario($username, $password);
		if ($idUsuario) {
			// successful login
                    
                        session_start();
                        $_SESSION['idUsuario'] = $idUsuario;
                        $_SESSION['fecha'] = "d/m/Y H:i:s";
			redirect_to("Home.php");
		} else {
			$message = "Hay errores";
		}
	} else {
		$username = "";
		$message = "Inicia Sesion";
	}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Iniciar Sesion</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
          <link rel="stylesheet" href="./Style/generalStyle.css">
        
    </head>
    <body>
        <div id="content">
            <a href="Home.php"><img src="images/todolist.png " /></a>
            <h1 id="logo">Getting Things Done!</h1><br/>

            
            <h3 style="margin-left: 20px;"><?php echo $message; ?></h3>
            <!--Se redirige a la misma pagina para comprobar los datos introducidos-->
            <form id='login' action='IniciarSesion.php' method='post' accept-charset='UTF-8'>
                <fieldset >
                <legend>Login</legend>
          
                <table>
                    <tr>
                        <td><label for='username' >Nombre de Usuario:</label></td>
                    <!--Se codifica lo que el usuario introduce por caracteres especiales html-->
                    <td> <input type='text' name='username'  maxlength="50" required="required" value="<?php echo htmlspecialchars($username); ?>"/></td>
                    </tr>   
                    <tr>
                        <td> <label for='password' >Password:</label></td>
                        <td> <input type='password' name='password' required="required" maxlength="50" /></td>
                    </tr>
                    <tr>
                        <td> <input type='submit' name='submit' value='Iniciar Sesion' style="width: auto;" /></td> 
                    </tr>
                </table>
                </fieldset>
            </form>
        </div>
    </body>
</html>
