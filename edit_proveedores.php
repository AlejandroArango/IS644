<?PHP
	session_start ();
?>
<html lang="es">
	<head>
		<title>Modificar de Proveedores</title>
		<link rel="stylesheet" type="text/css" href="estilo.css">
		<link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
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
				$errores["codigo"] = "";
				$errores["nombre"] = "";
				$errores["direccion"] = "";
				$errores["telefono"] = "";
				$errores["email"] = "";
				$error = false;
				if (isset($_POST['insertar']))
				{
					//Cargar las variable
					$nit = $_POST['nit'];
					$nom_prov = $_POST['nom_prov'];
					$dir_prov = $_POST['dir_prov'];
					$tel_prov = $_POST['tel_prov'];
					$email_p = $_POST['email_p']; 

					// Comprobar errores

					if (empty($nom_prov))
					{
						 $errores["nombre"] = "¡Nombre requerido!";
						 $error = true;
					}
					else
						$errores["nombre"] = "";	
					// Precio del producto
					if (empty($dir_prov))
					{
						 $errores["direccion"] = "¡Dirección requerida!";
						 $error = true;
					}
					else
					$errores["direccion"] = "";	
					// Telefono
					if (empty($tel_prov))
					{
						 $errores["telefono"] = "Teléfono requerido!";
						 $error = true;
					}
					else
						$errores["telefono"] = "";	 
					// Existencias del producto
					if (empty($email_p))
					{
						 $errores["email"] = "Teléfono requerido!";
						 $error = true;
					}
					else
						$errores["email"] = "";	
				}//fin de errores
				if (isset($_POST['insertar']) && $error==false)
				{
					//Cargar Bases de Datos					 
					echo ("<P>Estos son los datos introducidos:</P>\n");
					echo ("<UL>\n");
					echo ("   <LI>NIT: $nit");
					echo ("   <LI>Nombre: $nom_prov");
					echo ("   <LI>Dirección: $dir_prov");
					echo ("   <LI>Teléfono: $tel_prov");
					echo ("   <LI>Correo: $email_p");
					echo ("</UL>");
					 
					//Modificar datos a la Tabla
					 
					$query = "UPDATE proveedores SET nom_prov='$nom_prov', dir_prov='$dir_prov', tel_prov='$tel_prov', email_p='$email_p' WHERE nit=$nit";	  
					 
					mysqli_query($link, $query) or die 
						
						("<P><center><b>No se pudo actualizar información</b><br>
						<A HREF='edit_proveedores.php'>Volver</A> 		</center></P>");
					 
					 echo ("<P>[ <A HREF='lista_proveedores.php'>Regresar</A> ]</P>\n");
				}
				else
				{
					if (isset($_GET['nit']))
					{
						$nit=$_GET['nit'];
						require('config.php');
						$query="SELECT * FROM proveedores WHERE nit=$nit";
						$resultado=mysqli_query($link, $query);
						$extraido=mysqli_fetch_array($resultado);
					}

					?>

					<H1>Modificar Proveedores</H1>

					<P>Introduzca los datos del proveedor:</P>

					<FORM CLASS="borde" ACTION="edit_proveedores.php" METHOD="POST">

						<div class="form group">
							<div class="row">
								<div class="col-md-4">
									<label>NIT:</label>
								</div>
								<div class="col-md-8">
									<input type="text" class="form-control" name="nit" READONLY
										<?PHP
										   if (isset($_POST['insertar']))
												print ("VALUE ='$nit'>\n");
										   else
										   {
												if (isset($_GET['nit']))
													print (" VALUE=$extraido[nit]>");
											}  
										   if ($errores["codigo"] != "")
												print ("<BR><SPAN CLASS='error'>" . $errores["codigo"] . "</SPAN>");
										?>
								</div>
							</div>
						</div>
					<br>

					<div class="form group">
						<div class="row">
							<div class="col-md-4">
								<label>Nombre:</label>
							</div>
							<div class="col-md-8">
								<input type="text" class="form-control" name="nom_prov"
									<?PHP
									if (isset($_POST['insertar']))
										print (" VALUE='$nom_prov'>\n");
									else
										if (isset($_GET['nit']))
											print ("VALUE=$extraido[nom_prov]>");
									if ($errores["nombre"] != "")
										print ("<BR><SPAN CLASS='error'>" . $errores["nombre"] . "</SPAN>");
									?>
							</div>
						</div>
					</div>
					<br>

					<div class="form group">
						<div class="row">
							<div class="col-md-4">
								<label>Dirección:</label>
							</div>
							<div class="col-md-8">
								<input type="text" class="form-control" name="dir_prov"
									<?PHP
									if (isset($_POST['insertar']))
									   print (" VALUE='$dir_prov'>\n");
									else
									  if (isset($_GET['nit']))
										  print ("VALUE=$extraido[dir_prov]>");
									if ($errores["direccion"] != "")
									   print ("<BR><SPAN CLASS='error'>" . $errores["direccion"] . "</SPAN>");
									?>
							</div>
						</div>
					</div>
					<br>

					<div class="form group">
						<div class="row">
							<div class="col-md-4">
								<label>Teléfono:</label>
							</div>
							<div class="col-md-8">
								<input type="text" class="form-control" name="tel_prov"
									<?PHP
									if (isset($_POST['insertar']))
										print (" VALUE='$tel_prov'>\n");
									else
									  if (isset($_GET['nit']))
										print ("VALUE=$extraido[tel_prov]>");
									if ($errores["telefono"] != "")
										print ("<BR><SPAN CLASS='error'>" . $errores["telefono"] . "</SPAN>");
									?>
							</div>
						</div>
					</div>
					<br>

					<div class="form group">
						<div class="row">
							<div class="col-md-4">
								<label>Correo electrónico:</label>
							</div>
							<div class="col-md-8">
								<input type="text" class="form-control" name="email_p"
									<?PHP
									if (isset($_POST['insertar']))
										print (" VALUE='$email_p'>\n");
									else
									  if (isset($_GET['nit']))
										print ("VALUE=$extraido[email_p]>");
									if ($errores["email"] != "")
										print ("<BR><SPAN CLASS='error'>" . $errores["email"] . "</SPAN>");
									?>
							</div>
						</div>
					</div>
					<br>

					<P><INPUT TYPE="submit" class="btn btn-primary" NAME="insertar" VALUE="Insertar Proveedores"></P>
					</FORM>
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