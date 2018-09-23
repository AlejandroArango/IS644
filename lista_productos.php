<?PHP
   session_start ();
?>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title>Listado De Productos</title>
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
			if (isset($_POST['eliminar']))
			{
				require('config.php');

				// Obtener número de elementos a borrar
				$borrar = $_POST['borrar'];
				$nfilas = count ($borrar);

				// Mostrar mostrar producto a borrar
				for ($i=0; $i<$nfilas; $i++)
				{
					// Obtener datos de la producto i-ésima
					$query = "SELECT * FROM producto WHERE id_prod = $borrar[$i]";
					$resultado = mysqli_query ($link, $query) or die ("Fallo en la consulta");
					
					$extraido = mysqli_fetch_array ($resultado);

				  // Mostrar datos del Producto i-ésimo		 
					//echo ("<Producto eliminado:</label><br><br>");
						  // Mostrar datos del Producto i-ésimo
					 echo "Producto eliminado:";
					 echo "<UL>";
					 echo "   <LI>Nombre: " . $extraido['nom_prod'];
					 echo "   <LI>Precio: " . $extraido['pre_prod'];
					 echo "   <LI>Tamaño: " . $extraido['tam_prod'];
					 echo "   <LI>Existencias: " . $extraido['exi_prod'];
					 echo "</UL>";
				  // Eliminar eliminar
					 $instruccion = "DELETE FROM producto WHERE id_prod = $borrar[$i]";
					 $consulta = mysqli_query ($link, $instruccion)
						or die ("Fallo en la eliminación");
				  }
				  echo "<P>Número total de productos eliminados: " . $nfilas . "</P>";

			   // Cerrar conexión
				  mysqli_close ($link);

				  echo "<P>[ <A HREF='lista_productos.php'>Eliminar más productos</A> ]</P>";
			}
			else
			{
				//Conexion al servidor y base de datos
				require('config.php');

				// Establecer el número de filas por página y la fila inicial
				$num = 10; // número de filas por página
				if (!isset($_GET['comienzo'])) 
					$comienzo = 0;
				else
					$comienzo = $_GET['comienzo'];

			   // Calcular el número total de filas de la tabla
				$instruccion = "SELECT * FROM producto";
				$consulta = mysqli_query ($link, $instruccion) or die ("Fallo en la consulta");
				$nfilas = mysqli_num_rows ($consulta);

				if ($nfilas > 0)
				{

					// Mostrar números inicial y final de las filas a mostrar
					print ("<P>Mostrando productos " . ($comienzo + 1) . " a ");
					if (($comienzo + $num) < $nfilas)
						print ($comienzo + $num);
					else
						print ($nfilas);
					print (" de un total de $nfilas.\n");

				  // Mostrar botones anterior y siguiente
					 $estapagina = $_SERVER['PHP_SELF'];
					 if ($nfilas > $num)
					 {
						if ($comienzo > 0)
						   print ("[ <A HREF='$estapagina?comienzo=" . ($comienzo - $num) . "'>Anterior</A> | ");
						else
						   print ("[ Anterior | ");
						   
						if ($nfilas > ($comienzo + $num))
						   print ("<A HREF='$estapagina?comienzo=" . ($comienzo + $num) . "'>Siguiente</A> ]\n");
						else
						   print ("Siguiente ]\n");
					 }
					 print ("</P>\n");

				}

				$query="SELECT * FROM producto
				INNER JOIN proveedores ON producto.nit=proveedores.nit
				ORDER BY id_prod limit $comienzo, $num";

				$resultado=mysqli_query($link, $query);
				?>
				<form ACTION='lista_productos.php' METHOD='post'>
				<div class="panel panel-primary">
				<div class="panel-heading">Lista de Productos</div>
				<table class="table ">
				<tr><td><b>Nombre</b></td>
					<td><b>Precio</b></td>
					<td><b>Tamaño</b></td>
					<td><b>Existencias</b></td>
					<td><b>Proveedor</b></td>
					<td><b>Imagen</b></td>
					<td><b>Editar/Borrar</b></td>
				</tr>
				<?php
				while($extraido= mysqli_fetch_array($resultado))
				//foreach($resultado as $key => $extraido)
				{
				?>
				<tr>
					<td><?php echo $extraido['nom_prod']?></td>
					<td><?php echo $extraido['pre_prod']?></td>
					<td><?php echo $extraido['tam_prod']?></td>
					<td><?php echo $extraido['exi_prod']?></td>	
					<td><?php echo $extraido['nom_prov']?></td>	
					<td>
						<a href=" <?php echo $extraido['img_prod']?> ">
							<img style="heigth:48px; width:48px;" src="
							<?php echo $extraido['img_prod']?> ">
						</a>
					</td>	
					<td>
						<input type="button" class="btn btn-default" name="bedit" value="Editar"	
							Onclick="window.location.href = 'edit_producto.php?id_prod=<?php echo $extraido['id_prod']?>'" >
						
						<input type="checkbox" name="borrar[]" value="<?php echo $extraido['id_prod'] ?>">
						
					</td>
				</tr>
				<?php 
				}
				?>
				</table>
					</div>
					<BR>
					<input type='submit' class="btn btn-info" name='eliminar' value='Eliminar productos marcados'>
				</form>
				<?PHP
			}
		}
		else
		{				
				require('menu2.php');
				$num = 10; // número de filas por página
				if (!isset($_GET['comienzo'])) 
					$comienzo = 0;
				else
					$comienzo = $_GET['comienzo'];

			   // Calcular el número total de filas de la tabla
				$instruccion = "SELECT * FROM producto";
				$consulta = mysqli_query ($link, $instruccion) or die ("Fallo en la consulta");
				$nfilas = mysqli_num_rows ($consulta);

				if ($nfilas > 0)
				{

					// Mostrar números inicial y final de las filas a mostrar
					print ("<P>Mostrando productos " . ($comienzo + 1) . " a ");
					if (($comienzo + $num) < $nfilas)
						print ($comienzo + $num);
					else
						print ($nfilas);
					print (" de un total de $nfilas.\n");

				  // Mostrar botones anterior y siguiente
					 $estapagina = $_SERVER['PHP_SELF'];
					 if ($nfilas > $num)
					 {
						if ($comienzo > 0)
						   print ("[ <A HREF='$estapagina?comienzo=" . ($comienzo - $num) . "'>Anterior</A> | ");
						else
						   print ("[ Anterior | ");
						   
						if ($nfilas > ($comienzo + $num))
						   print ("<A HREF='$estapagina?comienzo=" . ($comienzo + $num) . "'>Siguiente</A> ]\n");
						else
						   print ("Siguiente ]\n");
					 }
					 print ("</P>\n");

				}

			$query="SELECT * FROM producto
			INNER JOIN proveedores ON producto.nit=proveedores.nit
			ORDER BY id_prod limit $comienzo, $num";

			$resultado=mysqli_query($link, $query);
			?>
			<form ACTION='lista_productos.php' METHOD='post'>
			<div class="panel panel-primary">
			<div class="panel-heading">Lista de Productos</div>
			<table class="table ">
			<tr><td><b>Nombre</b></td>
				<td><b>Precio</b></td>
				<td><b>Tamaño</b></td>
				<td><b>Existencias</b></td>
				<td><b>Proveedor</b></td>
				<td><b>Imagen</b></td>
			</tr>
			<?php
			while($extraido= mysqli_fetch_array($resultado))
			//foreach($resultado as $key => $extraido)
			{
			?>
			<tr>
				<td><?php echo $extraido['nom_prod']?></td>
				<td><?php echo $extraido['pre_prod']?></td>
				<td><?php echo $extraido['tam_prod']?></td>
				<td><?php echo $extraido['exi_prod']?></td>	
				<td><?php echo $extraido['nom_prov']?></td>	
				<td>
					<a href=" <?php echo $extraido['img_prod']?> ">
						<img style="heigth:48px; width:48px;" src="
						<?php echo $extraido['img_prod']?> ">
					</a>
				</td>
			</tr>
			<?php 
			}
			?>
			</table>
				</div>
				<BR>
			</form>
			<?PHP
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