<html lang="es">
	<head>
		<title>Autenticación de Usuarios</title>
		<link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
		<link rel="stylesheet" href="css/reset.css">
		<link rel="stylesheet" href="css/stylelogin.css">
		<script src="js/prefixfree.min.js"></script>
	</head>
	<body>
		<?php
		session_start();
		if (isset($_POST['usuario']) &&  isset($_POST['clave']))
		{			
			require('config.php');
			$usuario = $_POST['usuario'];
			$clave = $_POST['clave'];
			//Encriptar calve
			//$clave= md5($clave);
			//Insertar datos a la Tabla Usuarios
			$query = "SELECT usuario, clave FROM usuarios WHERE usuario='$usuario' AND clave='$clave'";
			$resultado=mysqli_query($link, $query)  or die ("Usuario invalidos");
			$nfilas = mysqli_num_rows($resultado);
			mysqli_close($link);
			//Datos correctos
			if($nfilas==1)
			{
				$usuario_valido = $usuario;
				$_SESSION["usuario_valido"] = $usuario_valido;		
				header('location:index.html');				
			}
			else
			{
				echo "<div align=center>Usuario o contraseña invalida</div>";
				echo "<div align=center><a href='login.php'>Reintentar</a></div>";
			}
		}
	else
	?>
		<div class="login">
			<H1>Iniciar Sesion</H1>
			<FORM CLASS="form" ACTION="login.php" METHOD="POST">
				<P class="field">
				<INPUT TYPE="TEXT" NAME="usuario" placeholder="Nombre de Usuario" required/>
				<i class="fa fa-user"></i>
				</P>
				<P class="field">
				<INPUT type="password" name="clave" placeholder="Clave" required/>
				<i class="fa fa-lock"></i>
				</P>
				<P class="submit"><input type="submit" name="insertar" value="Iniciar Sesion"></P>
			</form>
		</div>
	</body>
</html>