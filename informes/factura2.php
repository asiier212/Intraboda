<?php
require_once("dompdf/dompdf_config.inc.php");

session_start();
$base_url="http://www.desmassan.com/intranet/";

$link = mysql_connect("82.98.134.18", "bilbodj", "bilbodj");
mysql_select_db("bilbodj", $link);



$result = mysql_query("SELECT * FROM clientes where id = " . $_GET['id_cliente'], $link);
while ($fila = mysql_fetch_assoc($result)) {
	if($_SESSION[id_dj]=='admin') //Comprobamos que el usuario admin es el que ejecuta la factura
	{
    
		$html = '<html><head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		</head><body>
	 
<table width="100%" border="1" style="border-collapse:collapse;">
<tr><td align="center" colspan="2"><font size="+3"><b>FACTURA</b></font></td></tr>
  <tr>
    <td width="40%">
    	<table width="100%" border="0" style="border-collapse:collapse;">
      		<tr><td>
                <img src="imagenes/logo_bilbodj.jpg" width="139" align="top" /></td>
                </tr>
                <tr><td>&#161;Haz tu día el día de todos&#33;</td>
                </tr>
                <tr><td>
                Calle Luzarra nº3</td>
                </tr>
                <tr><td>
                48014, Bilbao</td>
                </tr>
                <tr><td>
                Bizkaia</td>
                </tr>
                <tr><td>
                94 652 18 39</td>
                </tr>
                <tr><td>
                <a href="http://www.bilbodj.com" target="_blank">www.bilbodj.com</a></td>
                </tr>
                <tr><td>
                <a href="mailto:info@exeleventos.com" target="_blank">info@exeleventos.com</td>
      			</tr>
      	</table>
     </td>
     <td>
     <table width="100%">
      <tr>
        <td width="30%"><font>Nº de factura:</font></td>
        <td width="70%"><font></font></td>
      </tr>
      <tr>
        <td><font>Fecha de factura:</font></td>
        <td><font>'.date("d-m-Y").'</font></td>
        </tr>
      <tr>
        <td><font">Facturar a:</font></td>
        <td<font>'.utf8_encode($fila[nombre_novio].' '.$fila[apellidos_novio]).'</font></td>
        </tr>
      <tr>
        <td><font>CIF, NIF:</font></td>
        <td><font>xx</font></td>
        </tr>
      <tr>
        <td><font>Direcci&#243;n:</font></td>
        <td><font>'.utf8_encode($fila[direccion_novio].' - '.$fila[poblacion_novio]).'</font></td>
        </tr>
      <tr>
        <td><font>Tel&#233;fono:</font></td>
        <td><font>'.$fila[telefono_novio].'<br />'.$fila[telefono_novia].'</font></td>
        </tr>
      <tr>
        <td><font>Correo electr&#243;nico:</font></td>
        <td><font>'.$fila[email_novio].'<br />'.$fila[email_novia].'</font></td>
      </tr>
     
     </table>

  </tr>

<tr>
<td colspan="2">
<br />

<table width="100%">
  <tr bgcolor="#CCCCCC">
  <td colspan="3" width="55%">Descripci&#243;n</td>
  <td width="15%" align="center">Importe</td>
  </tr>';
  
  $arr_servicios = unserialize($fila['servicios'] );
  $total = array_sum($arr_servicios);
  $arr_serv_keys = array_keys($arr_servicios);
  
  $result_servicios = mysql_query("SELECT * FROM servicios", $link);
  while ($fila_servicios = mysql_fetch_assoc($result_servicios)) {
	   in_array($fila_servicios['id'], $arr_serv_keys) ? 
	   $html=$html.'<tr>
  		<td colspan="3" width="55%">'.$fila_servicios['nombre'].'</td>':'';
		in_array($fila_servicios['id'], $arr_serv_keys) ?
		$html=$html.
		'<td width="15%" align="right">'.number_format($arr_servicios[$fila_servicios['id']],2,',','.').' &#8364;' : number_format($fila_servicios['precio'],2,',','.').'  &#8364;</td>
  		</tr>';
		  	   
  }
  
  
  
  
  $html = $html .'
  <tr bgcolor="#CCCCCC">
  <td colspan="4"></td>
  </tr>
  <tr>
  <td colspan="3" width="15%" align="right"><b>Subtotal de factura</b></td>
  <td width="15%" align="right">'.number_format($total,2,',','.').' &#8364;</td>
  </tr>
  <tr>
  <td colspan="3" width="15%" align="right">Descuento</td>';
  if($fila['descuento'] != '' && $fila['descuento'] != '0' )
  {
	  $descuento=$fila['descuento'];
  }
  else
  {
	  $descuento=0;
  }
  $html=$html.'<td width="15%" align="right">'.number_format($descuento,2,',','.').' &#8364;</td>
  </tr>
  <tr bgcolor="#CCCCCC">
  <td colspan="4"></td>
  </tr>
  <tr>
  <td colspan="3" width="15%" align="right">Tasa de impuestos</td>
  <td width="15%" align="right">21,00 &#37;</td>
  </tr>
  <tr>
  <td colspan="3" width="15%" align="right">I.V.A.</td>
  <td width="15%" align="right">'.number_format((($total-$descuento)*0.21),2,',','.').' &#8364;</td>
  </tr>
  <tr bgcolor="#CCCCCC">
  <td colspan="3" width="15%" align="right"><b>TOTAL</b></td>
  <td width="15%" align="right">'.number_format(($total-$descuento),2,',','.').' &#8364;</td>
  </tr>
  <tr>
  <td colspan="3" width="15%" align="right">Ingreso recibido</td>';
  $result_pagos = mysql_query("SELECT SUM(valor) FROM pagos where cliente_id = ". $fila['id'], $link);
  $fila_pagos = mysql_fetch_row($result_pagos);
  $ingresos_recibidos=$fila_pagos[0];
	  
  $html=$html.'<td width="15%" align="right">'.number_format($ingresos_recibidos,2,',','.').' &#8364;</td>
  </tr>
  <tr bgcolor="#CCCCCC">
  <td colspan="3" width="15%" align="right"><b>PENDIENTE</b></td>';
  $html=$html.'<td width="15%" align="right">'.number_format($total-$descuento-$ingresos_recibidos,2,',','.').' &#8364;</td>
  </tr>
</table>

<br />

<table width="100%">
<tr>
<td><b>Realizar trasferencia al siguiente n&#250;mero de cuenta BBK:</b><br />
2095 0010 40 9110245150
</td>
<td><b>Titular:</b> BILBO DJ<br />
<b>Concepto:</b>
</td>
</tr>
<tr>
<td colspan="2" align="center"><font color="#0000FF"><b>&#161;Muchas gracias por confiar en BILBO DJ&#33;</b></font></td>
</tr>
</table>

</tr>
</td>

</tr>
</tr>
</table>


	 </body></html>';
     
    $dompdf = new DOMPDF();
    $dompdf->load_html($html);
    ini_set("memory_limit","32M");
    $dompdf->render();
	//$dompdf->stream("Ficha_".$fila[nombre_novio]."_".$fila[nombre_novia]."_".$fila[fecha_boda].".pdf", array("Attachment" => 0));
    $pdf = $dompdf->output();
    file_put_contents("../uploads/facturas/Factura_".date("Y-m-d")."_".trim($fila[nombre_novio])."_".trim($fila[nombre_novia]).".pdf", $pdf);
	//echo $html;
	//$insert_presupuesto="INSERT INTO presupuestos VALUES("",'.$_GET[id_cliente].','1',".date("Y-m-d").",Factura_".date("Y-m-d")."'_'".$fila[nombre_novio]."'_'".$fila[nombre_novia].".pdf'");
	$archivo="Factura_".date("Y-m-d")."_".trim($fila[nombre_novio])."_".trim($fila[nombre_novia]).".pdf";
	mysql_query("INSERT INTO facturas VALUES ('','0','".$_GET[id_cliente]."','".date('Y-m-d H:m:s')."','".$archivo."')", $link);
	header( 'Location: '.$base_url.'admin/clientes/view/'.$_GET['id_cliente']);
	}
	else
	{
		header( 'Location: '.$base_url.'admin/login');
	}
}
?>

