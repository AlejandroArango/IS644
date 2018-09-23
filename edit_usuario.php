<?PHP
   session_start ();
?>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
   <title>Editar Usuario</title>
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
				echo "admin";//si es admin haga esto
				$errores["cod_usuario"] = "";
				$errores["usuario"] = "";
				$errores["clave"] = "";
				$errores["rol"] = "";
				$error = false;
				if (isset($_POST['insertar']))
				{
					print_r($_POST);
					//Cargar las variable
					$cod_usuario = $_POST['cod_usuario'];
					$usuario = $_POST['usuario'];
					$clave = $_POST['clave'];
					$rol = $_POST['rol'];
					
					// Comprobar errores
					// Nombre del producto
					  if (empty($usuario))
					  {
						 $errores["usuario"] = "¡Nombre requerido!";
						 $error = true;
					  }
					  else
						 $errores["usuario"] = "";	
					// Precio del producto
					  if (empty($rol) || (!is_numeric($rol)))
					  {
						 $errores["rol"] = "¡Rol requerido!";
						 $error = true;
					  }
					  else
						 $errores["rol"] = "";	
					// Tamaño del producto
					  if (empty($clave))
					  {
						 $errores["clave"] = "¡Clave requerida!";
						 $error = true;
					  }
					  else
						 $errores["clave"] = "";	 	
				}//fin de errores

				if (isset($_POST['insertar']) && $error==false)
				{
					require('config.php');
					//$clave= md5($clave); //TENER ENCUENTA SI SE QUIERE CIFRAR LA CLAVE
					echo ("<label>Estos son los datos modificados:</label><br><br>");
				?>
					
					<div class="form group" center>
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
								<label>Clave:</label>
							</div>
							<div class="col-md-10">
								<?php echo ("   <label> $clave </label>");?>
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
									echo ("   <label>Vendedor</label>");?>
							</div>	
						</div>
					</div>	
						
					<?php 
					//Modificar datos a la Tabla vendedor

					$query = "UPDATE usuarios SET usuario='$usuario', rol=$rol, clave='$clave' WHERE cod_usuario=$cod_usuario";

					mysqli_query($link, $query) or die 

					("<P><center><b>No se pudo actualizar información</b><br>
					<A HREF='lista_usuarios.php'>Volver</A> 		</center></P>");

					echo ("<P>[ <A HREF='lista_usuarios.php'>Modificar otro usuario</A> ]</P>\n");
				}
				else
				{					
					if(isset($_GET['cod_usuario']))
					{
						$cod_usuario=$_GET['cod_usuario'];
						require('config.php');
						$query="SELECT * FROM usuarios WHERE cod_usuario = $cod_usuario";
						
						$resultado=mysqli_query($link, $query);
						$extraido= mysqli_fetch_array($resultado);
					}
				?>

				<H1>Actualizacion de usuario</H1>

				<form CLASS="form" ACTION="edit_usuario.php" METHOD="POST">

					<div class="form group">
						<div class="row">
							<div class="col-md-4">
								<label>Codigo:</label>
							</div>
							<div class="col-md-8">
								<input type="text" class="form-control" name="cod_usuario" READONLY
									<?php
									   if (isset($_POST['insertar']))
										  print (" VALUE='$cod_usuario'>\n");
									   else
										  if (isset($_GET['cod_usuario']))
												print ("VALUE=$extraido[cod_usuario]>");
									   if ($errores["cod_usuario"] != "")
										  print ("<br><br><br><SPAN class='alert alert-danger'>" . $errores["cod_usuario"] . "</SPAN>");
									?>
							</div>
						</div>
					</div>
				<br>
					<div class="form group">
						<div class="row">
							<div class="col-md-4">
								<label>Usuario:</label>
							</div>
							<div class="col-md-8">
								<input type="text" class="form-control" name="usuario"
									<?php
										if (isset($_GET['cod_usuario']))
											print ("VALUE=$extraido[usuario]>");
										if ($errores["usuario"] != "")
											print ("<br><br><SPAN class='alert alert-danger'>" . $errores["usuario"] . "</SPAN>");
									?>
							</div>
						</div>
					</div>
				<br>
					<div class="form group">
						<div class="row">
							<div class="col-md-4">
								<label>Clave:</label>
							</div>
							<div class="col-md-8">
								<input type="password" class="form-control" name="clave"
									<?php
									   if ($errores["clave"] != "")
										  print ("<br><br><SPAN class='alert alert-danger'>" . $errores["clave"] . "</SPAN>");
									?>
							</div>
						</div>
					</div>
					<br>
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
											print ("<br><SPAN class='alert alert-danger'>" . $errores["rol"] . "</SPAN>");
									?>
							</div>		
						</div>			
					</div>

				<input class="btn btn-info" type="submit" name="insertar" value="Modificar Usuario">
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
			<BR><BR>
			<P ALIGN='CENTER'>Acceso no autorizado</P>
			<P ALIGN='CENTER'>[ <A HREF='login.php' TARGET='_top'>Conectar</A> ]</P>
			<?php
		}
		?>
		</div>
		<script src="http://code.jquery.com/jquery.js"></script>
		<script src="js/bootstrap.min.js"></script>
	</body>
</html>