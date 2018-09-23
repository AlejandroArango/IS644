<?PHP
   session_start ();
?>

<HTML LANG="es">
	<HEAD>
		<TITLE>Modificar Clientes</TITLE>
		<LINK REL="stylesheet" TYPE="text/css" HREF="estilo.css">
		<link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	</HEAD>
	<BODY>
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
				
					if (empty($nom_cli))
					{
						$errores["nombre"] = "¡Nombre requerido!";
						$error = true;
					}
					else
					$errores["nombre"] = "";
					//Apellido

					if (empty($ape_cli))
					{
						$errores["apellido"] = "Apellido requerido!";
						$error = true;
					}
					else
						$errores["apellido"] = "";

					// Precio del producto
					if (empty($dir_cli))
					{
						$errores["direccion"] = "¡Dirección requerida!";
						$error = true;
					}
					else
						$errores["direccion"] = "";	
					// Precio del producto
					if (empty($fe_naci))
					{
						$errores["fecha"] = "¡Fecha requerida!";
						$error = true;
					}
					else
						$errores["fecha"] = "";   


					// Telefono
					if (empty($tel_cli))
					{
						$errores["telefono"] = "Teléfono requerido!";
						$error = true;
					}
					else
						$errores["telefono"] = "";	 
					// Correo electrónico
					if (empty($email_c))
					{
						$errores["email"] = "Teléfono requerido!";
						$error = true;
					}
					else
						$errores["email"] = "";	
				}//fin de errores
				if (isset($_POST['insertar']) && $error==false)
				{					 
					echo ("<P>Estos son los datos guardados:</P>\n");
					echo ("<UL>\n");
					echo ("   <LI>NIT: $ced_cli");
					echo ("   <LI>Nombre: $nom_cli");
					echo ("   <LI>Nombre: $ape_cli");
					echo ("   <LI>Dirección: $dir_cli");
					echo ("   <LI>Nombre: $fe_naci");
					echo ("   <LI>Teléfono: $tel_cli");
					echo ("   <LI>Correo: $email_c");
					echo ("</UL>");
					 
					//Modificar datos a la Tabla

					$query = "UPDATE cliente SET nom_cli='$nom_cli', ape_cli='$ape_cli', dir_cli='$dir_cli', fe_naci='$fe_naci', tel_cli='$tel_cli', email_c='$email_c' WHERE ced_cli=$ced_cli";	  

					mysqli_query($link, $query) or die 

					("<P><center><b>No se pudo actualizar información</b><br>
					<A HREF='edit_clientes.php'>Volver</A> 		</center></P>");

					echo ("<P>[ <A HREF='lista_clientes.php'>Regresar</A> ]</P>\n");
				}
				else
				{
					if (isset($_GET['ced_cli']))
					{
						$ced_cli=$_GET['ced_cli'];
						$query="SELECT * FROM cliente WHERE ced_cli=$ced_cli";
						$resultado=mysqli_query($link, $query);
						$extraido=mysqli_fetch_array($resultado);
					}

	?>

			<H1>Modificar Clientes</H1>

			<P>Introduzca los datos del cliente:</P>

			<FORM CLASS="borde" ACTION="edit_clientes.php" METHOD="POST">

			   <div class="form group">
				  <div class="row">
					 <div class="col-md-4">
					 <label>Cédula:</label>
					 </div>
					 <div class="col-md-8">
						<input type="text" class="form-control" name="ced_cli" READONLY
						<?PHP
						   if (isset($_POST['insertar']))
							  print ('VALUE ="$ced_cli">\n');
						   else
						   {
						   if (isset($_GET['ced_cli']))
							  print (" VALUE=$extraido[ced_cli]>");
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
						<input type="text" class="form-control" name="nom_cli"
						<?PHP
						   if (isset($_POST['insertar']))
							  print (" VALUE='$nom_cli'>\n");
						   else
							 if (isset($_GET['ced_cli']))
								 print ("VALUE=$extraido[nom_cli]>");
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
					 <label>Apellido:</label>
					 </div>
					 <div class="col-md-8">
						<input type="text" class="form-control" name="ape_cli"
						<?PHP
						   if (isset($_POST['insertar']))
							  print (" VALUE='$ape_cli'>\n");
						   else
							 if (isset($_GET['ced_cli']))
								 print ("VALUE=$extraido[ape_cli]>");
						   if ($errores["apellido"] != "")
							  print ("<BR><SPAN CLASS='error'>" . $errores["apellido"] . "</SPAN>");
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
							 if (isset($_GET['ced_cli']))
								 print ("VALUE=$extraido[dir_cli]>");
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
					 <label>Fecha Nacimiento:</label>
					 </div>
					 <div class="col-md-8">
						<input type="text" class="form-control" name="fe_naci"
						   <?PHP
							  if (isset($_POST['insertar']))
								 print (" VALUE='$fe_naci'>\n");
							  else
								if (isset($_GET['ced_cli']))
									print ("VALUE=$extraido[fe_naci]>");
							  if ($errores["fecha"] != "")
								 print ("<BR><SPAN CLASS='error'>" . $errores["fecha"] . "</SPAN>");
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
								if (isset($_GET['ced_cli']))
									print ("VALUE=$extraido[tel_cli]>");
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
						<input type="text" class="form-control" name="email_c"
						   <?PHP
							  if (isset($_POST['insertar']))
								 print (" VALUE='$email_c'>\n");
							  else
								if (isset($_GET['ced_cli']))
									print ("VALUE=$extraido[email_c]>");
							  if ($errores["email"] != "")
								 print ("<BR><SPAN CLASS='error'>" . $errores["email"] . "</SPAN>");
						   ?>
					 </div>
				  </div>
			   </div>
			   <br>


			<P><INPUT TYPE="submit" class="btn btn-primary" NAME="insertar" VALUE="Guardar Datos"></P>
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