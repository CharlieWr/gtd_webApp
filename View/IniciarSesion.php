<?php
	require_once("../Control/funciones.php");
	require_once("../Control/UsuarioControl.php");
	
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
			redirect_to("Home.php");
		} else {
			$message = "Hay errores.";
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
        
    </head>
    <body>
        <div>
            <h1>Iniciar Sesion</h1>

            
            <?php echo $message; ?><br />
            <!--Se redirige a la misma pagina para comprobar los datos introducidos-->
            <form id='login' action='IniciarSesion.php' method='post' accept-charset='UTF-8'>
                <fieldset >
                <legend>Login</legend>
          

                <label for='username' >Nombre de Usuario:</label>
                <!--Se codifica lo que el usuario introduce por caracteres especiales html-->
                <input type='text' name='username'  maxlength="50" required="required" value="<?php echo htmlspecialchars($username); ?>"/><br/>

                <label for='password' >Password:</label>
                <input type='password' name='password' required="required" maxlength="50" /><br/>

                <input type='submit' name='submit' value='Submit' />

                </fieldset>
            </form>
        </div>
    </body>
</html>
