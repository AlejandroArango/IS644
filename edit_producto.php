<?PHP
   session_start ();
?>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
   <title>Editar Producto</title>
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
				$errores["id_prod"] = "";
				$errores["nom_prod"] = "";
				$errores["pre_prod"] = "";
				$errores["tam_prod"] = "";
				$errores["exi_prod"] = "";
				$errores["nit"] = "";
				$error = false;
				if (isset($_POST['insertar']))
				{
					//Cargar las variable
					$id_prod = $_POST['id_prod'];
					$nom_prod = $_POST['nom_prod'];
					$pre_prod = $_POST['pre_prod'];
					$tam_prod = $_POST['tam_prod'];
					$exi_prod = $_POST['exi_prod']; 
					$nit = $_POST['nit'];
					$nit = explode("_",$nit);
					
					// Comprobar errores
					// Nombre del producto
					  if (empty($nom_prod))
					  {
						 $errores["nom_prod"] = "¡Nombre requerido!";
						 $error = true;
					  }
					  else
						 $errores["nom_prod"] = "";	
					// Precio del producto
					  if (empty($pre_prod) || (!is_numeric($pre_prod)))
					  {
						 $errores["pre_prod"] = "¡Precio requerido!";
						 $error = true;
					  }
					  else
						 $errores["pre_prod"] = "";	
					// Tamaño del producto
					  if (empty($tam_prod))
					  {
						 $errores["tam_prod"] = "¡Tamaño requerido!";
						 $error = true;
					  }
					  else
						 $errores["tam_prod"] = "";	 
					// Existencias del producto
					  if (empty($exi_prod) || (!is_numeric($exi_prod)))
					  {
						 $errores["exi_prod"] = "¡Existencia requerida!";
						 $error = true;
					  }
					  else
						 $errores["exi_prod"] = "";
					 // nit del producto
					 //nit
					  if (empty($nit) || sizeof($nit) != 2)
					  {
						 $errores["nit"] = "¡Proveedor requerido!";
						 $error = true;
					  }
					  else
						 $errores["nit"] = "";	
				}//fin de errores

				if (isset($_POST['insertar']) && $error==false)
				{
					require('config.php');

					echo ("<label>Estos son los datos modificados:</label><br><br>");
				?>
					
					<div class="form group" center>
						<div class="row">
							<div class="col-md-2">
								<label>Nombre:</label>
							</div>
							<div class="col-md-10">
								<?php echo ("   <label> $nom_prod </label>");?>
							</div>	
						</div>
					</div>	

					<div class="form group">
						<div class="row">
							<div class="col-md-2">
								<label>Precio:</label>
							</div>
							<div class="col-md-10">
								<?php echo ("   <label> $pre_prod </label>");?>
							</div>	
						</div>
					</div>	
					
					<div class="form group">
						<div class="row">
							<div class="col-md-2">
								<label>Tamaño:</label>
							</div>
							<div class="col-md-10">
								<?php echo ("   <label> $tam_prod </label>");?>
							</div>	
						</div>
					</div>	
					
					<div class="form group">
						<div class="row">
							<div class="col-md-2">
								<label>Existencias:</label>
							</div>
							<div class="col-md-10">
								<?php echo ("   <label> $exi_prod </label>");?>
							</div>	
						</div>
					</div>	
					
					<div class="form group">
						<div class="row">
							<div class="col-md-2">
								<label>Proveedor:</label>
							</div>
							<div class="col-md-10">
								<?php echo ("   <label> $nit[1] </label>");?>
							</div>	
						</div>
					</div>	
					<?php 
					//Modificar datos a la Tabla vendedor

					$query = "UPDATE producto SET 
					nom_prod='$nom_prod', pre_prod=$pre_prod, tam_prod='$tam_prod', exi_prod=$exi_prod, nit=$nit[0]
					WHERE id_prod=$id_prod";

					mysqli_query($link, $query) or die 

					("<P><center><b>No se pudo actualizar información</b><br>
					<A HREF='lista_productos.php'>Volver</A> 		</center></P>");

					echo ("<P>[ <A HREF='lista_productos.php'>Modificar otro producto</A> ]</P><br>");
				}
				else
				{					
					if(isset($_GET['id_prod']))
					{
						$id_prod=$_GET['id_prod'];
						require('config.php');
						$query="SELECT * FROM producto WHERE id_prod = $id_prod";
						
						$resultado=mysqli_query($link, $query);
						$extraido= mysqli_fetch_array($resultado);
					}
				?>

				<H1>Actualizacion de productos</H1>

				<form CLASS="form" ACTION="edit_producto.php" METHOD="POST">

					<div class="form group">
						<div class="row">
							<div class="col-md-4">
								<label>ID:</label>
							</div>
							<div class="col-md-8">
								<input type="text" class="form-control" name="id_prod" READONLY
									<?php
									   if (isset($_POST['insertar']))
										  print ("VALUE ='$id_prod'><br>");
									   else
									   {
										  if (isset($_GET['id_prod']))
												print ("VALUE=$extraido[id_prod] ><br>");
									   }  
									   if ($errores["id_prod"] != "")
										  print ("<SPAN class='alert alert-danger'>" . $errores["id_prod"] . "</SPAN><br>");
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
								<input type="text" class="form-control" name="nom_prod"
									<?php
									   if (isset($_POST['insertar']))
										  print (" VALUE='$nom_prod'><br>");
									   else
										  if (isset($_GET['id_prod']))
												print ("VALUE=$extraido[nom_prod]><br>");
									   if ($errores["nom_prod"] != "")
										  print ("<SPAN class='alert alert-danger'>" . $errores["nom_prod"] . "</SPAN><br>");
									?>
							</div>
						</div>
					</div>
				<br>
					<div class="form group">
						<div class="row">
							<div class="col-md-4">
								<label>Precio:</label>
							</div>
							<div class="col-md-8">
								<input type="text" class="form-control" name="pre_prod"
									<?php
									   if (isset($_POST['insertar']))
										  print (" VALUE='$pre_prod'><br>");
									   else
										  if (isset($_GET['id_prod']))
												print ("VALUE=$extraido[pre_prod]><br>");
									   if ($errores["pre_prod"] != "")
										  print ("<SPAN class='alert alert-danger'>" . $errores["pre_prod"] . "</SPAN><br>");
									?>
							</div>
						</div>
					</div>
				<br>
					<div class="form group">
						<div class="row">
							<div class="col-md-4">
								<label>Tamaño:</label>
							</div>
							<div class="col-md-8">
								<input type="text" class="form-control" name="tam_prod"
									<?php
									   if (isset($_POST['insertar']))
										  print (" VALUE='$tam_prod'><br>");
									   else
										  if (isset($_GET['id_prod']))
												print ("VALUE=$extraido[tam_prod]>");
									   if ($errores["tam_prod"] != "")
										  print ("<SPAN class='alert alert-danger'>" . $errores["tam_prod"] . "</SPAN><br>");
									?>
							</div>
						</div>
					</div>
				<br>
					<div class="form group">
						<div class="row">
							<div class="col-md-4">
								<label>Existencias:</label>
							</div>
							<div class="col-md-8">
								<input type="text" class="form-control" name="exi_prod"
									<?php
									   if (isset($_POST['insertar']))
										  print (" VALUE='$exi_prod'><br>");
									   else
										  if (isset($_GET['id_prod']))
												print ("VALUE=$extraido[exi_prod]>");
									   if ($errores["exi_prod"] != "")
										  print ("<SPAN class='alert alert-danger'>" . $errores["exi_prod"] . "</SPAN><br>");
									?>
							</div>
						</div>
					</div>
				<br>
					<div class="form group">
						<div class="row">
							<div class="col-md-4">
								<label>Proveedor:</label>
							</div>
							<div class="col-md-8">
								<select class="form-control" name="nit">
									<?php
										require ('config.php');
										$query="SELECT proveedores.nom_prov, proveedores.nit FROM proveedores 
												ORDER BY nom_prov";
										$resultado1=mysqli_query($link, $query);
										
										echo "<option value=''>Seleccione</option>";
										while($extraido1= mysqli_fetch_array($resultado1))  
										{	
											if($extraido[nit] == $extraido1[nit]){
												echo "<option value='$extraido1[nit]_$extraido1[nom_prov]' selected>$extraido1[nom_prov]</option>";
											}
											else{
												echo "<option value='$extraido1[nit]_$extraido1[nom_prov]' >$extraido1[nom_prov]</option>";
											}
										}
									?>
								</select>				
								<?php
									if ($errores["nit"] != "")
										print ("<br><SPAN class='alert alert-danger'>" . $errores["nit"] . "</SPAN>");
								?>
							</div>
						</div>
					</div>



				<p><input class="btn btn-info" type="submit" name="insertar" value="Modificar Producto"></p>
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