<?php
require_once("dompdf/dompdf_config.inc.php");

session_start();
$base_url="http://www.desmassan.com/intranet/";

$link = mysql_connect("desmassan.com", "bilbodj", "bilbodj");
mysql_select_db("bilbodj", $link);



$result = mysql_query("SELECT * FROM clientes where id = " . $_GET['id_cliente'], $link);
while ($fila = mysql_fetch_assoc($result)) {
	if(($fila[dj] == $_SESSION[id_dj]) || $_SESSION[id_dj]=='admin') //Comprobamos que el DJ tiene derechos sobre el cliente
	{
		$html =
     '
	 <html>
		<head>
		</head>
		<body>
	 
<table width="100%" border="1" style="border-collapse:collapse;">
  <tr>
    <td><table width="100%" border="1" style="border-collapse:collapse;">
      <tr>
        <td width="24%" rowspan="10"><img src="imagenes/logo_bilbodj.jpg" width="239" height="205" align="top" /></td>
        <td bgcolor="#CD9AFF" colspan="4" align="center"><font size="3" color="#FFFFFF">DATOS DEL CLIENTE</font></td>
      </tr>
      <tr>
        <td width="8%"><font size="2">Nombre:</font></td>
        <td width="27%"><font size="2">'.$fila[nombre_novio].'</font></td>
        <td width="8%"><font size="2">Apellidos:</font></td>
        <td width="33%"><font size="2">'.$fila[apellidos_novio].'</font></td>
      </tr>
      <tr>
        <td><font size="2">Nombre:</font></td>
        <td><font size="2">'.$fila[nombre_novia].'</font></td>
        <td><font size="2">Apellidos:</font></td>
        <td><font size="2">'.$fila[apellidos_novia].'</font></td>
        </tr>
      <tr>
        <td><font size="2">Población:</font></td>
        <td colspan="3"><font size="2">'.$fila[poblacion_novio].'</font></td>
        </tr>
      <tr>
        <td><font size="2">Teléfono:</font></td>
        <td><font size="2">'.$fila[telefono_novio].'</font></td>
        <td><font size="2">E-mail:</font></td>
        <td><font size="2">'.$fila[email_novio].'</font></td>
        </tr>
      <tr>
        <td bgcolor="#CD9AFF" colspan="4" align="center"><font size="3" color="#FFFFFF">DATOS DEL LUGAR DEL EVENTO</font></td>
      </tr>
      <tr>
        <td><font size="2">Local:</font></td>
        <td><font size="2">'.$fila[restaurante].'</font></td>
        <td><font size="2">Teléfono:</font></td>
        <td><font size="2">'.$fila[telefono_restaurante].'</font></td>
        </tr>
      <tr>
        <td><font size="2">Dirección:</font></td>
        <td colspan="3"><font size="2">'.$fila[direccion_restaurante].'</font></td>
        </tr>
      <tr>
        <td bgcolor="#CD9AFF" colspan="4" align="center"><font size="3" color="#FFFFFF">HORA DE INICIO / SERVICIOS CONTRATADOS</font></td>
      </tr>
      <tr>
        <td colspan="4"><table width="100%" border="0">
          <tr>
		  ';
		  $servicios=explode(",",$fila[servicios]);
		  $count = count($servicios);
		  for ($i = 0; $i < $count; $i++) {
			  //$s_contratados=$s_contratados.$servicios[$i];
			  $result_servicios = mysql_query("SELECT * FROM servicios where id = " . $servicios[$i], $link);
			  while ($fila_servicios = mysql_fetch_assoc($result_servicios)) {
				  if($i==0)
				  {
				  	$s_contratados=$fila_servicios[nombre];
				  }
				  else
				  {
				  	$s_contratados=$s_contratados."+".$fila_servicios[nombre];
				  }
			  }
		  }

          $html= $html.
		  
		  '<td width="100%"><font size="2">'.$fila[fecha_boda].'///'.$s_contratados.'</font></td>
            
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
  <td bgcolor="#CD9AFF" align="center"><font size="3" color="#FFFFFF">LISTADO DE CANCIONES</font></td>
  </tr>
  <tr>
  <td valign="top"><font size="2">
  <table width="100%">
  <tr>
  <td valign="top">
  ';
  
  //necesito saber la el número de momentos de la boda
  $result_cont_momentos = mysql_query("SELECT COUNT(nombre) FROM momentos_espec where cliente_id = " . $fila[id], $link);
  $fila_cont_momentos = mysql_fetch_row($result_cont_momentos);
  $cont_momentos=$fila_cont_momentos[0];
  
  //Divido en dos columnas los momentos de la boda
  $mitad_columna_momentos=round(($cont_momentos/2));
  //contador de momentos
  $cont=0;
  
  $result_momentos = mysql_query("SELECT * FROM momentos_espec where cliente_id = " . $fila[id], $link);
  while ($fila_momentos = mysql_fetch_assoc($result_momentos)) {
	  if($cont==$mitad_columna_momentos)
	  {
		  $html=$html.'</td><td valign="top">';
		  $cont=0;
	  }
	  $html=$html.'
	  <table width="100%" border="1" style="border: 1px solid #000;">
	  <tr>
	  <td>
		  <table width="100%">
		  <tr>
		  <td align="center"><font size="2"><b>'.strtoupper($fila_momentos[nombre]).'</b></font></td>
		  </tr>';
		  $result_canciones = mysql_query("SELECT * FROM canciones where client_id = " . $fila[id] . " and momento_id = " . $fila_momentos[id]." order by orden", $link);
		  while ($fila_canciones = mysql_fetch_assoc($result_canciones)) {
			  $html=$html.'
			  <tr>
			  <td><font size="2">'.$fila_canciones[nombre].'</font></td>
			  </tr>';
		  }
		  $html=$html.'
		  </table>
	  </td>
	  </tr>
	  </table>';
	  $cont++;
  }
  $html=$html.'
  </td>
  </tr>
  </table>
  </td>
  </tr>
  <tr>
  <td bgcolor="#CD9AFF" align="center"><font size="3" color="#FFFFFF">LISTADO DE OBSERVACIONES CLIENTE</font></td>
  </tr>
  <tr>
  <td valign="top"><font size="2">
  ';
  $result_momento_canciones_ob = mysql_query("SELECT distinct(momento_id) FROM canciones_observaciones where client_id = " . $fila[id], $link);
  while ($fila_momento_canciones_ob = mysql_fetch_row($result_momento_canciones_ob)) {
	  
	  $html=$html.'
	  <table width="100%">
		  <tr>
		  <td align="center">
	  ';
	  
	  //$html=$html.$fila_momento_canciones_ob[0];
	  $result_nombre_momento = mysql_query("SELECT * FROM momentos_espec where id = " .$fila_momento_canciones_ob[0], $link);
	  while ($fila_momento = mysql_fetch_assoc($result_nombre_momento)) {
		  
		  $html=$html.'
		  <font size="2"><b>'.strtoupper($fila_momento_[nombre]).'</b></font>';
	  }
	  
	  $html=$html.'</td>
		  </tr>';
		  
	  $result_canciones_ob = mysql_query("SELECT * FROM canciones_observaciones where client_id = " . $fila[id] . " and momento_id = " . $fila_momento_canciones_ob[0], $link);
		  while ($fila_canciones_ob = mysql_fetch_assoc($result_canciones_ob)) {
			  $html=$html.'
			  <tr>
			  <td><font size="2">- '.$fila_canciones_ob[comentario].'</font></td>
			  </tr>';
		  }
	  $html=$html.'
	  </table>';
  }
  
  $html=$html.'
  </td>
  </tr>
  <tr>
  <td bgcolor="#CD9AFF" align="center"><font size="3" color="#FFFFFF">LISTADO DE OBSERVACIONES BILBODJ</font></td>
  </tr>
  <tr>
  <td valign="top"><font size="2">
  <table width="100%">
  ';
  $result_observaciones_bilbodj = mysql_query("SELECT * FROM observaciones where id_cliente = " . $_GET['id_cliente'], $link);
  while ($fila_observaciones_bilbodj = mysql_fetch_assoc($result_observaciones_bilbodj)) {
	  $html=$html.'
	  <tr><td>'.$fila_observaciones_bilbodj[comentario].'</td></tr>';
  }
  $html=$html.'
  </table>
  </td>
  </tr>
  <tr>
  <td bgcolor="#CD9AFF" align="center"><font size="3" color="#FFFFFF">INFORME DE INCIDENCIAS</font></td>
  </tr>
  <tr>
    <td><table width="100%" border="1" style="border-collapse:collapse;">
      <tr>
        <td width="5%"><font size="2">Hora:</font></td>
        <td width="11%">&nbsp;</td>
        <td width="12%"><font size="2">Dj animador:</font></td>
        <td width="26%">&nbsp;</td>
        <td width="12%"><font size="2">Acompañante:</font></td>
        <td width="34%">&nbsp;</td>
        </tr>
      <tr>
        <td valign="top" height="133" colspan="6"><font size="2">Indique brevemente la incidencia:</font></td>
        </tr>
      <tr>
        <td bgcolor="#E6E6E6" colspan="6" align="center"><font size="3">* A CONTINUACIÓN DESARROLLE LA INCIDENCIA EN EL CAMPO QUE CREA OPORTUNO  *</font></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td bgcolor="#CD9AFF" align="center"><font size="3" color="#FFFFFF">INCIDENCIA TÉCNICA</font></td>
  </tr>
  <tr>
    <td><table width="100%" border="1" style="border-collapse:collapse;">
      <tr>
        <td width="35%"><font size="2">Equipo afectado (familia y modelo):</font></td>
        <td width="65%">&nbsp;</td>
        </tr>
      <tr>
        <td><font size="2">Posible causa (caída, desfallecimiento):</font></td>
        <td>&nbsp;</td>
        </tr>
      <tr>
        <td><font size="2">¿Se ha podido continuar el evento?:</font></td>
        <td>&nbsp;</td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td bgcolor="#CD9AFF" align="center"><font size="3" color="#FFFFFF">INCIDENCIA CON PERSONA FÍSICA</font></td>
  </tr>
  <tr>
  <td><table width="100%" border="1" style="border-collapse:collapse;">
    <tr>
      <td width="40%"><font size="2">Persona con la que transcurre la incidencia (novio, metre, invitado):</font></td>
      <td width="60%">&nbsp;</td>
    </tr>
    <tr>
      <td valign="top" height="358" colspan="2"><font size="2">Indique lo más detalladamente posible la  incidencia: </font></td>
      </tr>
  </table></td>
  </tr>
</table>

	 </body></html>
	 ';
	$dompdf = new DOMPDF();
	$dompdf->load_html($html);
	$dompdf->render();
	$dompdf->stream("Ficha_".$fila[nombre_novio]."_".$fila[nombre_novia]."_".$fila[fecha_boda].".pdf", array("Attachment" => 0));
	//echo $html;
	}
	else
	{
		header( 'Location: '.$base_url.'dj/login');
	}

}
?>
