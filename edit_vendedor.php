<?PHP
   session_start ();
?>
<html lang="es">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<title>Editar Vendedor</title>
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
			{	require('menu1.php');		
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
						 $errores["ced_vend"] = "¡La cedula es requerida!";
						 $error = true;
					  }
					  else
						 $errores["ced_vend"] = "";	
					// Nombre
					  if (empty($nom_vend))
					  {
						 $errores["nom_vend"] = "¡El nombre es requerido!";
						 $error = true;
					  }
					  else
						 $errores["nom_vend"] = "";
					// Apellido
					  if (empty($ape_vend))
					  {
						 $errores["ape_vend"] = "¡El apellido es requerido!";
						 $error = true;
					  }
					  else
						 $errores["ape_vend"] = "";	 
					// Telefono
					  if (empty($tel_vend) || (!is_numeric($tel_vend)))
					  {
						 $errores["tel_vend"] = "¡El telefono es requerido!";
						 $error = true;
					  }
					  else
						 $errores["tel_vend"] = "";
				}//fin de errores

				if (isset($_POST['insertar']) && $error==false)
				{
					echo ("<label>Estos son los datos modificados:</label><br><br>");
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
					//Modificar datos a la Tabla vendedor

					$query = "UPDATE vendedor SET nom_vend='$nom_vend', ape_vend='$ape_vend', tel_vend=$tel_vend
					WHERE ced_vend=$ced_vend";

					mysqli_query($link, $query) or die 

					("<P><center><b>No se pudo actualizar información</b><br>
					<A HREF='lista_vendedores.php'>Volver</A> 		</center></P>");

					echo ("<P>[ <A HREF='lista_vendedores.php'>Modificar otro vendedor</A> ]</P><br>");
				}
				else
				{					
					if(isset($_GET['ced_vend']))
					{
						$ced_vend=$_GET['ced_vend'];
						require('config.php');
						$query="SELECT * FROM vendedor WHERE ced_vend = $ced_vend";
						
						$resultado=mysqli_query($link, $query);
						$extraido= mysqli_fetch_array($resultado);
					}
				?>

				<H1>Actualizacion de vendedor</H1>

				<form CLASS="form" ACTION="edit_vendedor.php" METHOD="POST">

					<div class="form group">
						<div class="row">
							<div class="col-md-4">
								<label>Cedula:</label>
							</div>
							<div class="col-md-8">
								<input type="text" class="form-control" name="ced_vend"
									<?php
									   if (isset($_POST['insertar']))
										  print ("VALUE =$ced_vend><br>");
									   else
									   {
										  if (isset($_GET['ced_vend']))
												print ("VALUE=$extraido[ced_vend] >");
									   }  
									   if ($errores["ced_vend"] != "")
										  print ("<br><br><SPAN class='alert alert-danger'>" . $errores["ced_vend"] . "</SPAN>");
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
									<?php
									   if (isset($_POST['insertar']))
										  print (" VALUE='$nom_vend'><br>");
									   else
										  if (isset($_GET['ced_vend']))
												print ("VALUE=$extraido[nom_vend]>");
									   if ($errores["nom_vend"] != "")
										  print ("<br><br><SPAN class='alert alert-danger'>" . $errores["nom_vend"] . "</SPAN>");
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
									<?php
									   if (isset($_POST['insertar']))
										  print (" VALUE='$ape_vend'><br>");
									   else
										  if (isset($_GET['ced_vend']))
												print ("VALUE=$extraido[ape_vend]>");
									   if ($errores["ape_vend"] != "")
										  print ("<br><br><SPAN class='alert alert-danger'>" . $errores["ape_vend"] . "</SPAN>");
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
									<?php
									   if (isset($_POST['insertar']))
										  print (" VALUE='$tel_vend'><br>");
									   else
										  if (isset($_GET['ced_vend']))
												print ("VALUE=$extraido[tel_vend]>");
									   if ($errores["tel_vend"] != "")
										  print ("<br><br><SPAN class='alert alert-danger'>" . $errores["tel_vend"] . "</SPAN>");
									?>
							</div>
						</div>
					</div>

				<p><input class="btn btn-info" type="submit" name="insertar" value="Modificar Vendedor"></P>

				</form>
				<?PHP
				}
			}		
			else
			{
				require('menu2.php');
				echo "<div align=center>NO TIENE PERMISOS DE ADMINISTRADOR</div>";
				echo "<div align=center><a href='login.php'>Ingresar</a></div>";
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