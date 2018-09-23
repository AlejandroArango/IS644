<?PHP
   session_start ();
?>
<html lang="es">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<title>Insertar Vendedor</title>
		<link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
		<link rel="stylesheet" type="text/css" href="estilo.css">
	</head>
	<body>	
		<?php
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
				
				//Cargar Bases de Datos
				$errores["ced_vend"] = "";
				$errores["nom_vend"] = "";
				$errores["ape_vend"] = "";
				$errores["tel_vend"] = "";
				$error = false;
				if (isset($_POST['insertar']))
				{
					//Cargar las variable
					$ced_vend = $_POST['ced_vend'];
					$nom_vend = $_POST['nom_vend'];
					$ape_vend = $_POST['ape_vend'];
					$tel_vend = $_POST['tel_vend'];  
					// Comprobar errores	
					// Cedula Vendedor
					  if (empty($ced_vend) || (!is_numeric($ced_vend)))
					  {
						 $errores["ced_vend"] = "¡Cedula requerida!";
						 $error = true;
					  }
					  else
						 $errores["ced_vend"] = "";	
					// Nombre
					  if (empty($nom_vend))
					  {
						 $errores["nom_vend"] = "¡Nombre requerido!";
						 $error = true;
					  }
					  else
						 $errores["nom_vend"] = "";
					// Apellido
					  if (empty($ape_vend))
					  {
						 $errores["ape_vend"] = "¡Apellido requerido!";
						 $error = true;
					  }
					  else
						 $errores["ape_vend"] = "";	 
					// Telefono
					  if (empty($tel_vend) || (!is_numeric($tel_vend)))
					  {
						 $errores["tel_vend"] = "¡Telefono requerido!";
						 $error = true;
					  }
					  else
						 $errores["tel_vend"] = "";
				}//fin de errores
				if (isset($_POST['insertar']) && $error==false)
				{     
					require('config.php');	
					echo ("<label>Estos son los datos introducidos:</label><br><br>");
					?>	
					<div class="form group" center>
						<div class="row">
							<div class="col-md-2">
								<label>Cedula:</label>
							</div>
							<div class="col-md-10">
								<?php echo ("   <label> $ced_vend </label>");?>
							</div>	
						</div>
					</div>	

					<div class="form group" center>
						<div class="row">
							<div class="col-md-2">
								<label>Nombre:</label>
							</div>
							<div class="col-md-10">
								<?php echo ("   <label> $nom_vend </label>");?>
							</div>	
						</div>
					</div>
					
					<div class="form group" center>
						<div class="row">
							<div class="col-md-2">
								<label>Apellido:</label>
							</div>
							<div class="col-md-10">
								<?php echo ("   <label> $ape_vend </label>");?>
							</div>	
						</div>
					</div>

					<div class="form group" center>
						<div class="row">
							<div class="col-md-2">
								<label>Telefono:</label>
							</div>
							<div class="col-md-10">
								<?php echo ("   <label> $tel_vend </label>");?>
							</div>	
						</div>
					</div>
					<?php
					//Consulta a la base de datos
					$query = "INSERT INTO vendedor (ced_vend,nom_vend, ape_vend, tel_vend) 
					VALUES ($ced_vend,'$nom_vend','$ape_vend',$tel_vend)";
					//Ejecucion de la Consulta
					mysqli_query($link, $query) 
					or die 
					("<P><center><b>No se pudo insertar información</b><br>
					 [ <A HREF='insertarvendedor.php'>Volver</A> ]</P></center");
						 
					echo ("<P>[ <A HREF='insertarvendedor.php'>Insertar otro vendedor</A> ]</P><br>");
					
				}
				else
				{
					?>
					<H1>Inserci&oacuten De Vendedor</H1>

					<form CLASS="form" ACTION="insertarvendedor.php" METHOD="POST">

						<div class="form group">
							<div class="row">
								<div class="col-md-4">
									<label>Cedula:</label>
								</div>
								<div class="col-md-8">
									<input type="text" class="form-control" name="ced_vend"
										<?PHP
										   if (isset($_POST['insertar']))
											  print (" VALUE='$ced_vend'><br>");
										   else
											  print ("><br>");
										   if ($errores["ced_vend"] != "")
											  print ("<SPAN class='alert alert-danger'>" . $errores["ced_vend"] . "</SPAN><br><br>");
										?>
								</div>
							</div>
						</div>	
						
						<div class="form group">
							<div class="row">
								<div class="col-md-4">
									<label>Nombre:</label>
								</div>
								<div class="col-md-8">
									<input type="text" class="form-control" name="nom_vend"	
										<?PHP
										   if (isset($_POST['insertar']))
											  print (" VALUE='$nom_vend'><br>");
										   else
											  print ("><br>");
										   if ($errores["nom_vend"] != "")
											  print ("<SPAN class='alert alert-danger'>" . $errores["nom_vend"] . "</SPAN><br><br>");
										?>
								</div>
							</div>
						</div>
						
						<div class="form group">
							<div class="row">
								<div class="col-md-4">
									<label>Apellido:</label>
								</div>
								<div class="col-md-8">
									<input type="text" class="form-control" name="ape_vend"	
										<?PHP
										   if (isset($_POST['insertar']))
											  print (" VALUE='$ape_vend'><br>");
										   else
											  print ("><br>");
										   if ($errores["ape_vend"] != "")
											  print ("<SPAN class='alert alert-danger'>" . $errores["ape_vend"] . "</SPAN><br><br>");
										?>
								</div>	
							</div>
						</div>
						
						<div class="form group">
							<div class="row">
								<div class="col-md-4">
									<label>Telefono:</label>
								</div>
								<div class="col-md-8">
									<input type="text" class="form-control" name="tel_vend"	
										<?PHP
										   if (isset($_POST['insertar']))
											  print (" VALUE='$tel_vend'><br>");
										   else
											  print ("><br>");
										   if ($errores["tel_vend"] != "")
											  print ("<SPAN class='alert alert-danger'>" . $errores["tel_vend"] . "</SPAN><br>");
										?>
								</div>
							</div>
						</div>
						<p><input class="btn btn-info" type="submit" name="insertar" value="Insertar Vendedor"></P>

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