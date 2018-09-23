<?PHP
   session_start ();
?>
<html lang="es">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<title>Listado De Vendedores</title>
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
				if (isset($_POST['eliminar']))
				{
					// Obtener número de especialidades a borrar
					$borrar = $_POST['borrar'];
					$nfilas = count ($borrar);

					// Mostrar especialidades a borrar
					for ($i=0; $i<$nfilas; $i++)
					{
						// Obtener datos de la especialidad i-ésima
						$query = "SELECT * FROM vendedor WHERE ced_vend = $borrar[$i]";
						$resultado = mysqli_query ($link, $query) or die ("Fallo en la consulta");

						$extraido = mysqli_fetch_array ($resultado);

						// Mostrar datos del vendedor i-ésimo
						echo "Vendedor eliminado:";
						echo "<UL>";
						echo "   <LI>Cedula: " . $extraido['ced_vend'];
						echo "   <LI>Nombre: " . $extraido['nom_vend'];
						echo "   <LI>Apellido: " . $extraido['ape_vend'];
						echo "   <LI>Telefono: " . $extraido['tel_vend'];
						echo "</UL>";
						// Eliminar especialidad
						$instruccion = "DELETE FROM vendedor WHERE ced_vend = $borrar[$i]";
						$consulta = mysqli_query ($link, $instruccion)
						or die ("Fallo en la eliminación");
					}
					echo "<P>Número total de vendedores eliminados: " . $nfilas . "</P>";

					// Cerrar conexión
					mysqli_close ($link);

					echo "<P>[ <A HREF='lista_vendedores.php'>Eliminar más vendedores</A> ]</P>";
				}
				else
				{
					// Establecer el número de filas por página y la fila inicial
					$num = 10; // número de filas por página
					if (!isset($_GET['comienzo'])) 
						$comienzo = 0;
					else
						$comienzo = $_GET['comienzo'];

					// Calcular el número total de filas de la tabla
					$instruccion = "SELECT * FROM vendedor";
					$consulta = mysqli_query ($link, $instruccion) or die ("Fallo en la consulta");
					$nfilas = mysqli_num_rows ($consulta);

					if ($nfilas > 0)
					{

						// Mostrar números inicial y final de las filas a mostrar
						print ("<P>Mostrando vendedores " . ($comienzo + 1) . " a ");
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

					$query="SELECT * FROM vendedor ORDER BY ced_vend limit $comienzo, $num";
					$resultado=mysqli_query($link, $query);
					?>
					<form ACTION='lista_vendedores.php' METHOD='post'>
						<div class="panel panel-primary">
							<div class="panel-heading">
								Lista de Vendedores
							</div>
							<table class="table ">
								<tr><td><b>Cedula</b></td>
								<td><b>Nombre</b></td>
								<td><b>Apellidos</b></td>
								<td><b>Telefono</b></td>
								<td><b>Editar/Borrar</b></td>
								</tr>
								<?php
								while($extraido= mysqli_fetch_array($resultado))
								//foreach($resultado as $key => $extraido)
								{
									?>
									<tr>
									<td><?php echo $extraido['ced_vend']?></td>
									<td><?php echo $extraido['nom_vend']?></td>
									<td><?php echo $extraido['ape_vend']?></td>
									<td><?php echo $extraido['tel_vend']?></td>	
									<td>
									<input class="btn btn-default" type="button" name="bedit" value="Editar"	
									Onclick="window.location.href = 'edit_vendedor.php?ced_vend=<?php echo $extraido['ced_vend']?>'" >

									<input type="checkbox" name="borrar[]" value="<?php echo $extraido['ced_vend'] ?>"
									</td>	
									</tr>
								<?php 
								}
								?>
							</table>
						</div>
						<BR>
						<input class="btn btn-info" type='submit' name='eliminar' value='Eliminar Vendedores marcados'>
					</form>
					<?php 
				}
			}
			else///////////////////////////////////////////////////////////////////////////////////
			{
				require('menu2.php');
				// Establecer el número de filas por página y la fila inicial
				$num = 10; // número de filas por página
				if (!isset($_GET['comienzo'])) 
					$comienzo = 0;
				else
					$comienzo = $_GET['comienzo'];

				// Calcular el número total de filas de la tabla
				$instruccion = "SELECT * FROM vendedor";
				$consulta = mysqli_query ($link, $instruccion) or die ("Fallo en la consulta");
				$nfilas = mysqli_num_rows ($consulta);

				if ($nfilas > 0)
				{

					// Mostrar números inicial y final de las filas a mostrar
					print ("<P>Mostrando vendedores " . ($comienzo + 1) . " a ");
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

				$query="SELECT * FROM vendedor ORDER BY ced_vend limit $comienzo, $num";
				$resultado=mysqli_query($link, $query);
				?>
				<form ACTION='lista_vendedores.php' METHOD='post'>
					<div class="panel panel-primary">
						<div class="panel-heading">
							Lista de Vendedores
						</div>
						<table class="table ">
							<tr><td><b>Cedula</b></td>
							<td><b>Nombre</b></td>
							<td><b>Apellidos</b></td>
							<td><b>Telefono</b></td>
							</tr>
							<?php
							while($extraido= mysqli_fetch_array($resultado))
							//foreach($resultado as $key => $extraido)
							{
								?>
								<tr>
								<td><?php echo $extraido['ced_vend']?></td>
								<td><?php echo $extraido['nom_vend']?></td>
								<td><?php echo $extraido['ape_vend']?></td>
								<td><?php echo $extraido['tel_vend']?></td>	
								</tr>
							<?php 
							}
							?>
						</table>
					</div>
					<BR>
				</form>
				<?php 
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