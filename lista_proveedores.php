<?PHP
session_start ();
?>
<html>
	<head>
		<title>Listado de Proveedores</title>
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
			if (isset($_POST['eliminar']))
			{

				// Obtener número de proveedores a borrar
				$borrar = $_POST['borrar'];
				$nfilas = count ($borrar);

				// Mostrar proveedores a borrar
				for ($i=0; $i<$nfilas; $i++)
				{
					// Obtener datos de la proveedores i-ésima
					$query = "select * from proveedores where nit = $borrar[$i]";
					$resultado = mysqli_query ($link, $query) or die ("Fallo en la consulta");

					$extraido = mysqli_fetch_array ($resultado);

					// Mostrar datos
					 echo "Proveedor eliminado:";
					 echo "<UL>";
					 echo "   <LI>NIT: " . $extraido['nit'];
					 echo "   <LI>Nombre: " . $extraido['nom_prov'];
					 echo "   <LI>Dirección: " . $extraido['dir_prov'];
					 echo "   <LI>Teléfono: " . $extraido['tel_prov'];
					 echo "   <LI>Email: " . $extraido['email_p'];         
					 echo "</UL>";

					// Eliminar proveedores
					 $instruccion = "delete from proveedores where nit = $borrar[$i]";
					 $consulta = mysqli_query ($link, $instruccion)	or die ("Fallo en la eliminación");
					}
					echo "<P>Número total de Proveedores eliminados: " . $nfilas . "</P>";

					// Cerrar conexión
					mysqli_close ($link);

					echo "<P>[ <A HREF='lista_proveedores.php'>Eliminar más Proveedores</A> ]</P>";
				}
				else
				{
				// Establecer el número de filas por página y la fila inicial
				$num = 5; // número de filas por página
				if (!isset($_GET['comienzo'])) 
					$comienzo = 0;
				else
					$comienzo = $_GET['comienzo'];

				// Calcular el número total de filas de la tabla
				$instruccion = "select * from proveedores";
				$consulta = mysqli_query ($link, $instruccion) or die ("Fallo en la consulta");
				$nfilas = mysqli_num_rows ($consulta);

				if ($nfilas > 0)
				{

					// Mostrar números inicial y final de las filas a mostrar
					print ("<P><BR>Mostrando Proveedores " . ($comienzo + 1) . " a ");
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
				$query="SELECT * FROM proveedores ORDER BY nit limit $comienzo, $num";
				$resultado=mysqli_query($link, $query);
				?>
				<FORM ACTION='lista_proveedores.php' METHOD='post'>
					<div class="panel panel-primary">
						<div class="panel-heading">
							Lista de Productos
						</div>
						<table class="table ">
							<tr><td>NIT</td>
							<td>Nombre</td>
							<td>Dirección</td>
							<td>Teléfono</td>
							<td>Email</td>
							<td>Acciones</td>
							</tr>
							<?php
							while($extraido= mysqli_fetch_array($resultado))
							//foreach($resultado as $key => $extraido)
							{
								?>
								<tr>
								<td><?php echo $extraido['nit']?></td>
								<td><?php echo $extraido['nom_prov']?></td>
								<td><?php echo $extraido['dir_prov']?></td>
								<td><?php echo $extraido['tel_prov']?></td>
								<td><?php echo $extraido['email_p']?></td>
								<td>
								<input type="button" name="bedit" value="Editar"	
								Onclick="window.location.href = 'edit_proveedores.php?nit=<?php echo $extraido['nit']?>'" >
								</td>
								<td><INPUT TYPE="CHECKBOX" NAME="borrar[]" VALUE="<?php echo $extraido['nit'] ?>"</td>
								</tr>
								<?php 
							}
							?>
						</table>
						<BR>
					</div>
					<INPUT TYPE='SUBMIT' class="btn btn-info" NAME='eliminar' VALUE='Eliminar Proveedores Marcados'>
				</FORM>
				<?PHP
			}
		}
		///////////////////////////////////////////////////////////////////////////////////////////
		else	
		{	
			require('menu2.php');
			// Establecer el número de filas por página y la fila inicial
			$num = 5; // número de filas por página
			if (!isset($_GET['comienzo'])) 
				$comienzo = 0;
			else
				$comienzo = $_GET['comienzo'];

			// Calcular el número total de filas de la tabla
			$instruccion = "select * from proveedores";
			$consulta = mysqli_query ($link, $instruccion) or die ("Fallo en la consulta");
			$nfilas = mysqli_num_rows ($consulta);
			if ($nfilas > 0)
			{
				// Mostrar números inicial y final de las filas a mostrar
				print ("<P><BR>Mostrando Proveedores " . ($comienzo + 1) . " a ");
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

			$query="SELECT * FROM proveedores ORDER BY nit limit $comienzo, $num";
			$resultado=mysqli_query($link, $query);
			?>
			<FORM ACTION='lista_proveedores.php' METHOD='post'>
				<div class="panel panel-primary">
					<div class="panel-heading">
						Lista de Productos
					</div>
					<table class="table ">
						<tr><td>NIT</td>
						<td>Nombre</td>
						<td>Dirección</td>
						<td>Teléfono</td>
						<td>Email</td>
						</tr>
						<?php
						while($extraido= mysqli_fetch_array($resultado))
						//foreach($resultado as $key => $extraido)
						{
							?>
							<tr>
							<td><?php echo $extraido['nit']?></td>
							<td><?php echo $extraido['nom_prov']?></td>
							<td><?php echo $extraido['dir_prov']?></td>
							<td><?php echo $extraido['tel_prov']?></td>
							<td><?php echo $extraido['email_p']?></td>
							<?php 
						}
						?>
					</table>
					<BR>
				</div>
			</FORM>
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