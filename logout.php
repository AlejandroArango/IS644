<?php
   session_start ();
?>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title>Desconectar</title>
	<link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
	<link rel="stylesheet" type="text/css" href="estilo.css">
</head>
<body>
<?php
   if (isset($_SESSION["usuario_valido"]))
   {
      SESSION_DESTROY ();
      print ("<br><br><p align='center'>conexión finalizada</p>\n");
      print ("<p align='center'>[ <a href='login.php'>conectar</a> ]</p>\n");
   }
   else
   {
      print ("<br><br>\n");
      print ("<p align='center'>no existe una conexión activa</p>\n");
      print ("<p align='center'>[ <a href='login.php'>conectar</a> ]</p>\n");
   }
?>
	</div>
<script src="http://code.jquery.com/jquery.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>
