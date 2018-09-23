<?PHP
   session_start ();
?>
<html lang="es">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<title>Insertar Producto</title>
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
				$errores["nom_prod"] = "";
				$errores["pre_prod"] = "";
				$errores["tam_prod"] = "";
				$errores["exi_prod"] = "";
				$errores["nit"] = "";
				$error = false;
				if (isset($_POST['insertar']))
				{
					//Cargar las variable
					$nom_prod = $_POST['nom_prod'];
					$pre_prod = $_POST['pre_prod'];
					$tam_prod = $_POST['tam_prod'];
					$exi_prod = $_POST['exi_prod']; 
					$nit = $_POST['nit'];
					$nit = explode("_",$nit);
					// Para garantizar la unicidad del nombre se añade una marca de tiempo
					if (is_uploaded_file ($_FILES['imagen']['tmp_name']))
					{
						$nombreDirectorio = "img/";
						$nombreArchivo = $_FILES['imagen']['name'];
						$copiarArchivo = true;

						// Si ya existe un fichero con el mismo nombre, renombrarlo
						$nombreCompleto = $nombreDirectorio . $nombreArchivo;
						if (is_file($nombreCompleto))
						{
							$idUnico = time();
							$nombreArchivo = $idUnico . "-" . $nombreArchivo;
						}
					}
					// El fichero introducido supera el límite de tamaño permitido
					else if ($_FILES['imagen']['error'] == UPLOAD_ERR_FORM_SIZE)
					{
						$maxsize = $_POST['MAX_FILE_SIZE'];
						$errores["imagen"] = "¡El tamaño del fichero supera el límite permitido ($maxsize bytes)!";
						$error = true;
					}// No se ha introducido ningún fichero
					else if ($_FILES['imagen']['name'] == "")
					{
						$nombreArchivo = '';
						$errores["imagen"] = "¡No se ha podido subir el fichero!";
						$error = true;
					}
					// Comprobar errores		 
					// Nombre
					if (empty($nom_prod))
					{
						$errores["nom_prod"] = "¡Nombre requerido!";
						$error = true;
					}
					else
					$errores["nom_prod"] = "";
					// Precio
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
					// Mover foto a su ubicación definitiva
					if ($copiarArchivo)
							move_uploaded_file ($_FILES['imagen']['tmp_name'], $nombreDirectorio . $nombreArchivo);
					$img_prod=$nombreDirectorio . $nombreArchivo;
					//print_r($nombreDirectorio . $nombreArchivo)	;
					$query="SELECT max(id_prod) as id_prod FROM producto
						WHERE nom_prod = '$nom_prod'";		 
					$resultado=mysqli_query($link, $query);
					$extraido=mysqli_fetch_array($resultado);	
					echo ("<label>Estos son los datos introducidos:</label><br><br>");
					?>						
						<div class="form group">
							<div class="row">
								<div class="col-md-2">
									<label>Nombre:</label>
								</div>
								<div class="col-md-10">
									<?php echo ("<label> $nom_prod </label>");?>
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
						
						//Consulta a la base de datos
						$query = "INSERT INTO producto(nom_prod, pre_prod, tam_prod, exi_prod, nit, img_prod) 
								  VALUES
								  ('$nom_prod',$pre_prod,'$tam_prod',$exi_prod,$nit[0], '$img_prod')";
						//Ejecucion de la Consulta
						mysqli_query($link, $query) 
						or die 
						("<P><center><b>No se pudo insertar información</b><br>
						 [ <A HREF='insertarproducto.php'>Volver</A> ]</P></center");
							 
						echo ("<div class='alert alert-success' role='alert' align='center'>[ <A HREF='insertarproducto.php'>Insertar otro producto</A> ]</div>");
						
				}
				else
				{
					?>
					<H1>Inserción de Productos</H1>

					<form CLASS="form" ACTION="insertarproducto.php" METHOD="POST" ENCTYPE="multipart/form-data">

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
										  print ("><br>");
									   if ($errores["nom_prod"] != "")
										  print ("<SPAN class='alert alert-danger'>" . $errores["nom_prod"] . "</SPAN><br>");
									?>
								</div>
							</div>
						</div>	
						<br>
						<div class="form-group">
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
										  print ("><br>");
									   if ($errores["pre_prod"] != "")
										  print ("<SPAN class='alert alert-danger'>" . $errores["pre_prod"] . "</SPAN><br>");
									?>
								</div>
							</div>
						</div>			

						<div class="form-group">
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
										  print ("><br>");
									   if ($errores["tam_prod"] != "")
										  print ("<SPAN class='alert alert-danger'>" . $errores["tam_prod"] . "</SPAN><br>");
									?>
								</div>	
							</div>	
						</div>

						<div class="form-group">
							<div class="row">
								<div class="col-md-4">
									<label>Existencias:</label>
								</div>
								<div class="col-md-8">
									<input type="text" class="form-control" name="exi_prod"
									<?php
									   if (isset($_POST['exi_prod']))
										  print (" VALUE='$exi_prod'><br>");
									   else
										  print ("><br>");
									   if ($errores["exi_prod"] != "")
										  print ("<SPAN class='alert alert-danger'>" . $errores["exi_prod"] . "</SPAN><br>");
									?>
								</div>
							</div>
						</div>	

						<div class="form-group">
							<div class="row">
								<div class="col-md-4">
									<label>Proveedor:</label>
								</div>
								<div class="col-md-8">	
										<SELECT NAME="nit" class="form-control" >
										<?php
											$query="SELECT proveedores.nom_prov, proveedores.nit FROM proveedores 
													ORDER BY nom_prov";
											$resultado1=mysqli_query($link, $query);
											
											echo "<option value=''>Seleccione</option>";
											while($extraido1= mysqli_fetch_array($resultado1))  
											{	
												echo "<option value='$extraido1[nit]_$extraido1[nom_prov]'>$extraido1[nom_prov]</option>";
											}
										?>
										</SELECT>
										<?php
											if ($errores["nit"] != "")
												print ("<br><SPAN class='alert alert-danger'>" . $errores["nit"] . "</SPAN><br>");
										?>
								</div>		
							</div>			
						</div>				
						
						<div class="form-group">
							<div class="row">
								<div class="col-md-4">
									<label for="imagen">Subir imagen:</label>
								</div>
								<div class="col-md-8">
									<input class="" type="hidden" name="MAX_FILE_SIZE" value="2000000" />
									<input class="btn btn-default" type="file" name="imagen"  />
								</div>
							</div>
						</div>


					<P><INPUT TYPE="submit" class="btn btn-info" NAME="insertar" VALUE="Insertar Producto"></P>

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