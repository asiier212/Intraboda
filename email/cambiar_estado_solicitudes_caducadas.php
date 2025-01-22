<?php
include("../application/config/config2.php");

$link = mysql_connect($host, $usuario, $pass);
mysql_select_db($database, $link);


/*Actualizamos a NO INTERESADO todas las solicitudes cuyo estado de solicitud NO SEA FIRMADO y la fecha de la boda ya haya pasado*/
mysql_query("UPDATE solicitudes SET estado_solicitud='5' WHERE fecha_boda<NOW() AND estado_solicitud<>'2'", $link);

?>

