<?PHP
	session_start ();
?>
<html lang="es">
	<head>
		<title>Inserción de Proveedores</title>
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
					// codigo
					if (empty($nit) || (!is_numeric($nit)))
					{
						$errores["codigo"] = "¡Se requiere NIT del proveedor!";
						$error = true;
					}
					else
						$errores["codigo"] = "";
					// Nombre
					if (empty($nom_prov))
					{
						$errores["nombre"] = "¡El nombre es requerido!";
						$error = true;
					}
					else
						$errores["nombre"] = "";
					// Dirección
					if (empty($dir_prov))
					{
						$errores["direccion"] = "¡La dirección es requerida!";
						$error = true;
					}
					else
						$errores["direccion"] = "";
					// Telefono
					if (empty($tel_prov) || (!is_numeric($tel_prov)))
					{
						$errores["telefono"] = "¡Se requiere telefono del proveedor!";
						$error = true;
					}
					else
						$errores["telefono"] = "";
					// Email
					if (empty($email_p))
					{
						$errores["email"] = "¡El correo electrónico es requerido!";
						$error = true;
					}
					else
						$errores["email"] = "";
				}
				// si el formulario ha sido enviado y los datos son correctos
				// Procesar los datos
				if (isset($_POST['insertar']) && $error==false)
				{
					//Cargar Bases de Datos       
					echo ("<P>Estos son los datos introducidos:</P>\n");
					echo ("<UL>\n");
					echo ("   <LI>Codigo: $nit");
					echo ("   <LI>Nombre: $nom_prov");
					echo ("   <LI>Dirección: $dir_prov");
					echo ("   <LI>Telefono: $tel_prov");
					echo ("   <LI>Email: $email_p");
					echo ("</UL>");
					//Insertar datos a la Tabla Proveedor
					$query = "INSERT INTO proveedores (nit, nom_prov, dir_prov, tel_prov, email_p) 
					VALUES ($nit,'$nom_prov','$dir_prov', $tel_prov, '$email_p')";   
					mysqli_query($link, $query) or die 
					("<P><center><b>No se pudo insertar información</b><br>
					<A HREF='proveedores.php'>Volver</A>       </center></P>");
					echo ("<P>[ <A HREF='proveedores.php'>Insertar otro proveedor</A> ]</P>\n");
				}
				else
				{
				?>
				<H1><BR>Inserción de Proveedores</H1>
				<h4><P>Introduzca los datos del Proveedor:</P></h4>
				<FORM CLASS="borde" ACTION="proveedores.php" METHOD="POST" ENCTYPE="multipart/form-data">
				<div class="form group">
					<div class="row">
						<div class="col-md-4">
							<label>NIT:</label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="nit"
							<?PHP 
							if (isset($_POST['insertar']))
								print (" VALUE='$nit'>\n");
							else
								print (">\n");
							if ($errores["codigo"] != "")
								print ("<BR><SPAN class='alert alert-danger'>" . $errores["codigo"] . "</SPAN>");
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
									print (">\n");
								if ($errores["nombre"] != "")
									print ("<BR><SPAN class='alert alert-danger'>" . $errores["nombre"] . "</SPAN>");
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
								print (">\n");
							if ($errores["direccion"] != "")
								print ("<BR><SPAN class='alert alert-danger'>" . $errores["direccion"] . "</SPAN>");
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
								print (">\n");
							if ($errores["telefono"] != "")
								print ("<BR><SPAN class='alert alert-danger'>" . $errores["telefono"] . "</SPAN>");
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
							print (">\n");
								if ($errores["email"] != "")
							print ("<BR><SPAN class='alert alert-danger'>" . $errores["email"] . "</SPAN>");
							?>
						</div>
					</div>
				</div>
				<br>
				<P><INPUT TYPE="submit" class="btn btn-primary" NAME="insertar" VALUE="Insertar Proveedor"></P>
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