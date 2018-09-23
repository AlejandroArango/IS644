<?PHP
   session_start ();
?>
<HTML LANG="es">
	<head>
		<link rel="stylesheet" type="text/css" href="estilo.css">
		<link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<title>Listado De Clientes</title>
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
				$errores["cedula"] = "";
				$errores["nombre"] = "";
				$errores["apellido"] = "";
				$errores["direccion"] = "";
				$errores["fecha"] = "";
				$errores["telefono"] = "";
				$errores["email"] = "";
				$error = false;
				if (isset($_POST['insertar']))
				{
				   //Cargar las variable
				   $ced_cli = $_POST['ced_cli'];
				   $nom_cli = $_POST['nom_cli'];
				   $ape_cli = $_POST['ape_cli'];
				   $dir_cli = $_POST['dir_cli'];
				   $fe_naci = $_POST['fe_naci'];
				   $tel_cli = $_POST['tel_cli'];
				   $email_c = $_POST['email_c'];
			
				   // Comprobar errores
				   // codigo
					if (empty($ced_cli) || (!is_numeric($ced_cli)))
					{
						$errores["cedula"] = "¡Se requiere cédula del cliente!";
						$error = true;
					}
					else
						$errores["cedula"] = "";
					   
				   // Nombre
					if (empty($nom_cli))
					{
						$errores["nombre"] = "¡El nombre es requerido!";
						$error = true;
					}
					else
						$errores["nombre"] = "";

				   // Apellido
					if (empty($ape_cli))
					{
						$errores["apellido"] = "¡El apellido es requerido!";
						$error = true;
					}
					else
						$errores["apellido"] = "";     

					// Dirección
					if (empty($dir_cli))
					{
						$errores["direccion"] = "¡La dirección es requerida!";
						$error = true;
					}
					else
						$errores["direccion"] = "";
					
					// Fecha nacimiento
					if (empty($fe_naci))
					{
						$errores["fecha"] = "¡La fecha es requerida!";
						$error = true;
					}
					else
						$errores["fecha"] = "";

					// Telefono
					if (empty($tel_cli) || (!is_numeric($tel_cli)))
					{
						$errores["telefono"] = "¡Se requiere telefono del cliente!";
						$error = true;
					}
					else
						$errores["telefono"] = "";

					// Email
					if (empty($email_c))
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
				require('config.php');

				echo ("<P>Estos son los datos introducidos:</P>\n");
				echo ("<UL>\n");
				echo ("\n   <LI>Codigo: $ced_cli");
				echo ("\n   <LI>Nombre: $nom_cli");
				echo ("\n   <LI>Apellido: $ape_cli");
				echo ("\n   <LI>Dirección: $dir_cli");
				echo ("\n   <LI>Fecha De Nac: $fe_naci");
				echo ("\n   <LI>Telefono: $tel_cli");
				echo ("\n   <LI>Email: $email_c");
				echo ("</UL>");
			   
			   //Insertar datos a la Tabla Medicos
			   
			   $query = "INSERT INTO cliente (ced_cli, nom_cli, ape_cli, dir_cli, fe_naci,  tel_cli, email_c) 
				   VALUES ($ced_cli,'$nom_cli','$ape_cli','$dir_cli', '$fe_naci',$tel_cli, '$email_c')";   
			   
				mysqli_query($link, $query) or die 
				 
				("<P><center><b>No se pudo insertar información</b><br>
				<A HREF='clientes.php'>Volver</A>       </center></P>");
			   
				echo ("<P>[ <A HREF='clientes.php'>Insertar otro Cliente</A> ]</P>\n");
				}
				else
				{
				?>

				<H1><BR>Inserción de Clientes</H1>

				<h4><P>Introduzca los datos del Cliente:</P></h4>
				<DIV>
				<FORM CLASS="form" ACTION="clientes.php" METHOD="POST" ENCTYPE="multipart/form-data">

				<div class="form group">
					<div class="row">
						<div class="col-md-4">
						<label>Cédula:</label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="ced_cli"
							<?PHP 
							   if (isset($_POST['insertar']))
								  print (" VALUE='$ced_cli'>\n");
							   else
								  print (">\n");
							   if ($errores["cedula"] != "")
								  print ("<BR><SPAN class='alert alert-danger'>" . $errores["cedula"] . "</SPAN>");
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
							<input type="text" class="form-control" name="nom_cli"
							<?PHP 
							   if (isset($_POST['insertar']))
								  print (" VALUE='$nom_cli'>\n");
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
						<label>Apellido:</label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="ape_cli"
							<?PHP 
							   if (isset($_POST['insertar']))
								  print (" VALUE='$ape_cli'>\n");
							   else
								  print (">\n");
							   if ($errores["apellido"] != "")
								  print ("<BR><SPAN class='alert alert-danger'>" . $errores["apellido"] . "</SPAN>");
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
							<input type="text" class="form-control" name="dir_cli"
							<?PHP 
							   if (isset($_POST['insertar']))
								  print (" VALUE='$dir_cli'>\n");
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
						<label>Fecha Nacimiento:</label>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control" name="fe_naci" placeholder="AAAA-MM-DD"
							<?PHP 
							   if (isset($_POST['insertar']))
								  print (" VALUE='$fe_naci'>\n");
							   else
								  print (">\n");
							   if ($errores["fecha"] != "")
								  print ("<BR><SPAN class='alert alert-danger'>" . $errores["fecha"] . "</SPAN>");
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
							<input type="text" class="form-control" name="tel_cli"
							<?PHP 
							   if (isset($_POST['insertar']))
								  print (" VALUE='$tel_cli'>\n");
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
							<input type="text" class="form-control" name="email_c"
							<?PHP 
							   if (isset($_POST['insertar']))
								  print (" VALUE='$email_c'>\n");
							   else
								  print (">\n");
							   if ($errores["email"] != "")
								  print ("<BR><SPAN class='alert alert-danger'>" . $errores["email"] . "</SPAN>");
							?>
						</div>
					</div>
				</div>
				<br>

				<P><INPUT TYPE="submit" class="btn btn-primary" NAME="insertar" VALUE="Insertar Cliente"></P>
				</FORM>
			<?php
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