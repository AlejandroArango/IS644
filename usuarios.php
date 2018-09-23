<?PHP
   session_start ();
?>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title>Insertar Usuario</title>
	<link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
	<link rel="stylesheet" type="text/css" href="estilo.css">
</head>
<body>	
		<?PHP
		require('config.php');
		if (isset($_SESSION["usuario_valido"]))
		{
			//verifica si es administrador o usuario
			$admin=$_SESSION["usuario_valido"];
			$query1="SELECT * FROM usuarios WHERE usuario = '$admin'";		
			$resultado1=mysqli_query($link, $query1);
			$extraido1= mysqli_fetch_array($resultado1);
			//verifica si es admin o no
			if($extraido1['rol']==1)
			{
				require('menu1.php');
				$errores["usuario"] = "";
				$errores["clave"] = "";
				$errores["rol"] = "";
				$error = false;
				if (isset($_POST['insertar']))
				{
					//Cargar las variable
					
					$usuario = $_POST['usuario'];
					$clave = $_POST['clave'];
					$rol = $_POST['rol'];
					// Comprobar errores
						 
				   // Habitacion
					  if (empty($usuario))
					  {
						 $errores["usuario"] = "¡Usuario requerido!";
						 $error = true;
					  }
					  else
						 $errores["usuario"] = "";
					 // clave
					 if (empty($clave))
					  {
						 $errores["clave"] = "¡Clave requerida!";
						 $error = true;
					  }
					  else
						 $errores["clave"] = "";
					 // rol 
					 if (empty($rol))
					  {
						 $errores["rol"] = "¡Rol requerido!";
						 $error = true;
					  }
					  else
						 $errores["rol"] = "";
					 }	 

				// si el formulario ha sido enviado y los datos son correctos
				// Procesar los datos

				if (isset($_POST['insertar']) && $error==false)
				{
						 //Cargar Bases de Datos
						require('config.php');
						 
						 //Encriptar calve
						//$clave= md5($clave);
						 
						 //Insertar datos a la Tabla Usuarios
						 //INSERT INTO usuarios (usuario, clave ) VALUES ('alejo', '1234')
						 $query = "INSERT INTO usuarios (usuario, clave, rol) 
							  VALUES ('$usuario', '$clave', $rol)";	  
						 
						 //echo $query;
						 mysqli_query($link, $query) or die 
							
							("<P><center><b>No se pudo insertar usuario</b><br>
							<A HREF='insertarusuario.php'>Volver</A> 		</center></P>");
						
						 $query="SELECT max(cod_usuario) as cod_usuario FROM usuarios WHERE usuario='$usuario'";
						 
						 
						 $resultado=mysqli_query($link, $query);
						 $extraido=mysqli_fetch_array($resultado);
						
						echo ("<label>Estos son los datos introducidos:</label><br><br>");
					?>
					<div class="form group">
						<div class="row">
							<div class="col-md-2">
								<label>Usuario:</label>
							</div>
							<div class="col-md-10">
								<?php echo ("   <label> $usuario </label>");?>
							</div>	
						</div>
					</div>	
					<div class="form group">
						<div class="row">
							<div class="col-md-2">
								<label>Rol:</label>
							</div>
							<div class="col-md-10">
								<?php 
								if($rol==1)
									echo ("   <label>Administrador</label>");
								else
									echo ("   <label>Vendedor</label>");
								?>
							</div>	
						</div>
					</div>	
					<?php
						echo ("<div class='alert alert-success' role='alert' align='center'>[ <A HREF='usuarios.php'>Insertar otro Usuario</A> ]</div>");
						}
				else
				{
				?>

				<H1>Inserción de Usuarios</H1>

				<P>Introduzca los datos del Usuario:</P>

				<form CLASS="form" ACTION="usuarios.php" METHOD="POST">
					<div class="form-group">
						<div class="row">
							<div class="col-md-4">
								<label>Usuario:</label>
							</div>
							<div class="col-md-8">
								<input type="text" class="form-control" name="usuario"
									<?PHP
									   if (isset($_POST['insertar']))
										  print (" VALUE='$usuario'>\n");
									   else
										  print (">\n");
									   if ($errores["usuario"] != "")
										  print ("<br><br><SPAN CLASS='error'>" . $errores["usuario"] . "</SPAN>");
									?>
							</div>
						</div>
					</div>
					
					<div class="form-group">
						<div class="row">
							<div class="col-md-4">
								<label>Clave:</label>
							</div>
							<div class="col-md-8">
								<input type="password" class="form-control" name="clave"
									<?PHP
									   if (isset($_POST['insertar']))
										  print (" VALUE='$clave'>\n");
									   else
										  print (">\n");
									   if ($errores["clave"] != "")
										  print ("<br><br><SPAN CLASS='error'>" . $errores["clave"] . "</SPAN>");
									?>
							</div>
						</div>
					</div>
					
					<div class="form-group">
						<div class="row">
							<div class="col-md-4">
								<label>Rol:</label>
							</div>
							<div class="col-md-8">	
									<select name="rol" class="form-control" >
										<option value="">seleccione</option>
										<option value="1">Administradador</option>
										<option value="2">Vendedor</option>
									</select>
									<?php
										if ($errores["rol"] != "")
											print ("<br><br><SPAN class='alert alert-danger'>" . $errores["rol"] . "</SPAN>");
									?>
							</div>		
						</div>			
					</div>
					
				<p><input type="submit" name="insertar" value="Insertar Usuario"></p>

				</form>

				<?PHP
				}
			}
			else
			{
				require('menu2.php');
				echo "<div align=center>NO TIENE PERMISOS DE ADMINISTRADOR</div>";
				echo "<div align=center><a href='login.php'>Ingresar</a></div>";
				//si es vendedor haga esto	
			}			

		}
		else
		{
			?>
			<br>
			<br>
			<p align='center'>Acceso no autorizado</p>
			<p align='center'>[ <a href='login.php' target='_top'>Conectar</a> ]</p>
			<?php
		}
		?>
		</div>
		<script src="http://code.jquery.com/jquery.js"></script>
		<script src="js/bootstrap.min.js"></script>
	</body>
</html>