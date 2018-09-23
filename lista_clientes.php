<?PHP
	session_start ();
?>
<html>
	<head>
		<title>Listado de Clientes</title>
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
				// Obtener número de clientes a borrar
				$borrar = $_POST['borrar'];
				$nfilas = count ($borrar);

				// Mostrar clientes a borrar
				for ($i=0; $i<$nfilas; $i++)
				{
					// Obtener datos de la clientes i-ésima
					$query = "select * from cliente where ced_cli = $borrar[$i]";
					$resultado = mysqli_query ($link, $query) or die ("Fallo en la consulta");

					$extraido = mysqli_fetch_array ($resultado);

					// Mostrar datos
					echo "Cliente eliminado:";
					echo "<UL>";
					echo "   <LI>Cédula: " . $extraido['ced_cli'];
					echo "   <LI>Nombre: " . $extraido['nom_cli'];
					echo "   <LI>Apellido: " . $extraido['ape_cli'];
					echo "   <LI>Dirección: " . $extraido['dir_cli'];
					echo "   <LI>Fecha nacimiento: " . $extraido['fe_naci'];
					echo "   <LI>Teléfono: " . $extraido['tel_cli'];
					echo "   <LI>Email: " . $extraido['email_c'];         
					echo "</UL>";

					// Eliminar Cliente
					$instruccion = "delete from cliente where ced_cli = $borrar[$i]";
					$consulta = mysqli_query ($link, $instruccion)
					or die ("Fallo en la eliminación");
				}
				echo "<P>Número total de clientes eliminados: " . $nfilas . "</P>";

				// Cerrar conexión
				mysqli_close ($link);

				echo "<P>[ <A HREF='lista_clientes.php'>Eliminar más Clientes</A> ]</P>";
			}
			else
			{
				//Conexion al servidor y base de datos
				require('config.php');

				// Establecer el número de filas por página y la fila inicial
				$num = 5; // número de filas por página
				if (!isset($_GET['comienzo'])) 
					$comienzo = 0;
				else
					$comienzo = $_GET['comienzo'];

				// Calcular el número total de filas de la tabla
				$instruccion = "select * from cliente";
				$consulta = mysqli_query ($link, $instruccion) or die ("Fallo en la consulta");
				$nfilas = mysqli_num_rows ($consulta);

				if ($nfilas > 0)
				{
					// Mostrar números inicial y final de las filas a mostrar
					print ("<P><BR>Mostrando Clientes " . ($comienzo + 1) . " a ");
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

				$query="SELECT * FROM cliente ORDER BY ced_cli limit $comienzo, $num";
				$resultado=mysqli_query($link, $query);
				?>
				<FORM ACTION='lista_clientes.php' METHOD='post'>
					<div class="panel panel-primary">
						<div class="panel-heading">
							Lista de Productos
						</div>
						<table class="table ">
							<tr><td>Cédula</td>
							<td>Nombre</td>
							<td>Apellido</td>
							<td>Dirección</td>
							<td>Fecha</td>
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
								<td><?php echo $extraido['ced_cli']?></td>
								<td><?php echo $extraido['nom_cli']?></td>
								<td><?php echo $extraido['ape_cli']?></td>
								<td><?php echo $extraido['dir_cli']?></td>
								<td><?php echo $extraido['fe_naci']?></td>
								<td><?php echo $extraido['tel_cli']?></td>
								<td><?php echo $extraido['email_c']?></td>
								<td>
								<input type="button" name="bedit" value="Editar"	
								Onclick="window.location.href = 'edit_clientes.php?ced_cli=<?php echo $extraido['ced_cli']?>'" >
								</td>
								<td><INPUT TYPE="CHECKBOX" NAME="borrar[]" VALUE="<?php echo $extraido['ced_cli'] ?>"</td>
								</tr>
							<?php 
							}
							?>
						</table>
					</div>
					<BR>
					<INPUT TYPE='SUBMIT' class="btn btn-info" NAME='eliminar' VALUE='Eliminar Cliente'>
				</FORM>
				<?PHP
			}
		}
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
			$instruccion = "select * from cliente";
			$consulta = mysqli_query ($link, $instruccion) or die ("Fallo en la consulta");
			$nfilas = mysqli_num_rows ($consulta);

			if ($nfilas > 0)
			{

				// Mostrar números inicial y final de las filas a mostrar
				print ("<P><BR>Mostrando Clientes " . ($comienzo + 1) . " a ");
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

			$query="SELECT * FROM cliente ORDER BY ced_cli limit $comienzo, $num";
			$resultado=mysqli_query($link, $query);
			?>
			<FORM ACTION='lista_clientes.php' METHOD='post'>
				<div class="panel panel-primary">
					<div class="panel-heading">
						Lista de Productos
					</div>
					<table class="table ">
						<tr><td>Cédula</td>
						<td>Nombre</td>
						<td>Apellido</td>
						<td>Dirección</td>
						<td>Fecha</td>
						<td>Teléfono</td>
						<td>Email</td>
						</tr>
						<?php
						while($extraido= mysqli_fetch_array($resultado))
						//foreach($resultado as $key => $extraido)
						{
						?>
						<tr>
							<td><?php echo $extraido['ced_cli']?></td>
							<td><?php echo $extraido['nom_cli']?></td>
							<td><?php echo $extraido['ape_cli']?></td>
							<td><?php echo $extraido['dir_cli']?></td>
							<td><?php echo $extraido['fe_naci']?></td>
							<td><?php echo $extraido['tel_cli']?></td>
							<td><?php echo $extraido['email_c']?></td>
						</tr>
						<?php 
						}
						?>
					</table>
				</div>
			<BR>
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