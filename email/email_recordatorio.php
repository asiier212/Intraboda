<?php
include("../application/config/config2.php");

$link = mysql_connect($host, $usuario, $pass);
mysql_select_db($database, $link);

/*$link = mysql_connect("82.98.134.18", "bilbodj", "bilbodj");
mysql_select_db("bilbodj", $link);*/

//mysql_query("UPDATE pruebas_cron SET estado=2 WHERE id_prueba=1", $link);
//$hoy=date("Y-m-d");
$hoy=date("Y-m-d");
$fecha = strtotime ('-15 day',strtotime($hoy));
$fecha2 = strtotime ('-45 day',strtotime($hoy));

$fecha = date ( 'Y-m-d' , $fecha );
$fecha2 = date ( 'Y-m-d' , $fecha2 );


//
// EMAIL RECORDATORIO PARA LAS SOLICITUDES NORMALES
//

$result = mysql_query("select * from solicitudes where (DATE(fecha)='".$fecha."' or DATE(fecha)='".$fecha2."') and (estado_solicitud='1' or estado_solicitud='6')", $link);
while ($fila = mysql_fetch_assoc($result)) {
	
	$result2 = mysql_query("select id_oficina from comerciales where id='".$fila['id_comercial']."'", $link);
	while ($fila2 = mysql_fetch_assoc($result2)) {
		$id_oficina=$fila2['id_oficina'];
	}
	
	$result2 = mysql_query("select nombre, email, logo_mail from oficinas where id_oficina='".$id_oficina."'", $link);
	while ($fila2 = mysql_fetch_assoc($result2)) {
		$nombre_oficina=$fila2['nombre'];
		$email_oficina=$fila2['email'];
		$logo_mail_oficina=$fila2['logo_mail'];
	}

$cabeceras  = 'MIME-Version: 1.0' . "\r\n";
$cabeceras .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
$cabeceras .= 'From: '.$email_oficina;

$asunto='Actualiza tu solicitud de presupuesto';
$mensaje='<table border="0" width="100%">
<tr>
	<td>
		<img src="http://www.bilbodj.com/intranetv3/img/img_mail/cabecera.jpg" width="100%">
	</td>
</tr>
<tr>
    <td align="justify"><p>Buenos días <b>'.utf8_encode($fila['nombre']).' '.utf8_encode($fila['apellidos']).'</b>.</p>
 
        <p>Tras la solicitud de presupuesto que nos hiciste el <b>'.$fila['fecha'].'</b>, queremos confirmar si habéis valorado la propuesta que os pasamos y si estáis interesados en reservar la fecha.</p>
         
        <p>El periodo de validez de vuestro presupuesto expira en los próximos 5 días. Indica una de las siguientes opciones para actualizar el estado de vuestra solicitud y poder informaros del siguiente paso para hacer efectiva la reserva.</p>
         
        <p>¡Recibe un cordial saludo!<br>
        El Equipo '.strtoupper($nombre_oficina).'</p>
    </td>
    </tr>
</table>
<table border="0" width="100%">
    <tr>
    <td align="center">
        <table border="0" width="100%">
        <tr>
        <td align="center"><a href="'.$url.'email/actualiza_estado_email.php?id_solicitud='.$fila['id_solicitud'].'&email='.html_entity_decode($fila['email']).'&estado_actualizado=3"><img src="'.$url.'img/logos_mail/btn_estamos_interesados.jpg"></a></td>
        <td align="center"><a href="'.$url.'email/actualiza_estado_email.php?id_solicitud='.$fila['id_solicitud'].'&email='.html_entity_decode($fila['email']).'&estado_actualizado=6"><img src="'.$url.'img/logos_mail/btn_estamos_valorando_otras_propuestas.jpg"></a></td>
        </tr>
        </table>
    </td>
    </tr>
    <tr>
    <td colspan="2" align="center"><a href="'.$url.'email/actualiza_estado_email.php?id_solicitud='.$fila['id_solicitud'].'&email='.html_entity_decode($fila['email']).'&estado_actualizado=5"><img src="'.$url.'img/logos_mail/btn_no_estamos_interesados.jpg"></a></td>
    </tr>
	<tr>
		<td align="center"><img src="http://www.bilbodj.com/intranetv3/img/img_mail/pie.jpg" width="100%"></td>
	</tr>
</table>';

$asunto=html_entity_decode($asunto);
$mensaje=html_entity_decode($mensaje);

	//mail($fila['email'], $asunto, $mensaje, $cabeceras);
    sendEmail('info@exeleventos.com', [$fila['email']], $asunto, $mensaje);
}

//
// FIN EMAIL RECORDATORIO PARA LAS SOLICITUDES NORMALES
//


//
// EMAIL RECORDATORIO PARA LOS PRESUPUESTOS EN EVENTOS
//
$result = mysql_query("select * from presupuesto_eventos where (DATE(fecha_alta)='".$fecha."' or DATE(fecha_alta)='".$fecha2."') and (estado_solicitud='1' or estado_solicitud='6')", $link);
while ($fila = mysql_fetch_assoc($result)) {
	
	$result2 = mysql_query("select id_oficina from comerciales where id='".$fila['id_comercial']."'", $link);
	while ($fila2 = mysql_fetch_assoc($result2)) {
		$id_oficina=$fila2['id_oficina'];
	}
	
	$result2 = mysql_query("select nombre, email, logo_mail from oficinas where id_oficina='".$id_oficina."'", $link);
	while ($fila2 = mysql_fetch_assoc($result2)) {
		$nombre_oficina=$fila2['nombre'];
		$email_oficina=$fila2['email'];
		$logo_mail_oficina=$fila2['logo_mail'];
	}

$cabeceras  = 'MIME-Version: 1.0' . "\r\n";
$cabeceras .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
$cabeceras .= 'From: '.$email_oficina;

$asunto='Actualiza tu solicitud de presupuesto';
$mensaje='<table border="0" width="100%">
<tr>
	<td>
		<img src="http://www.bilbodj.com/intranetv3/img/img_mail/cabecera.jpg" width="100%">
	</td>
</tr>
<tr>
    <td align="justify"><p>Buenos días <b>'.utf8_encode($fila['nombre']).' '.utf8_encode($fila['apellidos']).'</b>.</p>
 
        <p>Tras la solicitud de presupuesto que nos hiciste el <b>'.$fila['fecha_alta'].'</b>, queremos confirmar si habéis valorado la propuesta que os pasamos y si estáis interesados en reservar la fecha.</p>
         
        <p>El periodo de validez de vuestro presupuesto expira en los próximos 5 días. Indica una de las siguientes opciones para actualizar el estado de vuestra solicitud y poder informaros del siguiente paso para reservar la fecha.</p>
         
        <p>¡Recibe un cordial saludo!<br>
        El Equipo '.strtoupper($nombre_oficina).'</p>
    </td>
    </tr>
</table>
<table border="0" width="100%">
    <tr>
    <td align="center">
        <table border="0" width="100%">
        <tr>
        <td align="center"><a href="'.$url.'email/actualiza_estado_presupuesto_eventos_email.php?id_presupuesto='.$fila['id_presupuesto'].'&email='.html_entity_decode($fila['email']).'&estado_actualizado=3"><img src="'.$url.'img/logos_mail/btn_estamos_interesados.jpg"></a></td>
        <td align="center"><a href="'.$url.'email/actualiza_estado_presupuesto_eventos_email.php?id_presupuesto='.$fila['id_presupuesto'].'&email='.html_entity_decode($fila['email']).'&estado_actualizado=6"><img src="'.$url.'img/logos_mail/btn_estamos_valorando_otras_propuestas.jpg"></a></td>
        </tr>
        </table>
    </td>
    </tr>
    <tr>
    <td colspan="2" align="center"><a href="'.$url.'email/actualiza_estado_presupuesto_eventos_email.php?id_presupuesto='.$fila['id_presupuesto'].'&email='.html_entity_decode($fila['email']).'&estado_actualizado=5"><img src="'.$url.'img/logos_mail/btn_no_estamos_interesados.jpg"></a></td>
    </tr>
	<tr>
		<td align="center">
			<img src="http://www.bilbodj.com/intranetv3/img/img_mail/pie.jpg" width="100%">
		</td>
	</tr>
</table>';

$asunto=html_entity_decode($asunto);
$mensaje=html_entity_decode($mensaje);

	//mail($fila['email'], $asunto, $mensaje, $cabeceras);
    sendEmail('info@exeleventos.com', [$fila['email']], $asunto, $mensaje);
}
//
// FIN EMAIL RECORDATORIO PARA LOS PRESUPUESTOS EN EVENTOS
//


/*EMAIL RECORDATORIO DE LOS PAGOS*/
/*EMAIL RECORDATORIO DE LOS PAGOS*/

$hoy=date("Y-m-d");
$fecha_busqueda_segundo_pago=date("Y-m-d",strtotime ('+5 day',strtotime($hoy)));
$fecha_busqueda_tercer_pago=date("Y-m-d",strtotime ('-30 day',strtotime($hoy)));


/*SEGUNDO PAGO*/
/*El segundo pago es del 50% del total y se manda el e-mail 5 días antes de la boda*/
$result =mysql_query("SELECT id, email_novio, email_novia, servicios, descuento, DATE_FORMAT(fecha_boda, '%Y-%m-%d') as fecha_boda FROM clientes WHERE DATE_FORMAT(fecha_boda, '%Y-%m-%d')='".$fecha_busqueda_segundo_pago."' AND enviar_emails='S'", $link);
while ($fila = mysql_fetch_assoc($result)) {
	$arr_servicios = unserialize( $fila['servicios'] );
	$total = array_sum($arr_servicios);
	$total_con_descuento=$total-$fila['descuento'];
	$fecha_boda=$fila['fecha_boda'];
	$email_novio=$fila['email_novio'];
	$email_novia=$fila['email_novia'];
	//echo "Fecha de la boda: ".$fecha_boda."<br>";
	//echo "Total: ".$total_con_descuento."&euro;<br>";
	//echo "Fecha segundo pago: ".$fecha_busqueda_segundo_pago."<br>";
	
	$result =mysql_query("SELECT SUM(valor) as pagado, COUNT(valor) as num_pagos FROM pagos WHERE cliente_id='".$fila['id']."'", $link);
	while ($fila = mysql_fetch_assoc($result)) {
		if($fila['num_pagos']==""){
				$fila['num_pagos']=0;
		}
		if($fila['pagado']==""){
				$fila['pagado']=0;
		}
		if($fila['num_pagos']==1){
			$falta_por_pagar=$total_con_descuento-$fila['pagado'];
			//echo "Pagado: ".$fila['pagado']."&euro;<br>";
			//$importe_segundo_pago=(($total_con_descuento*50)/100)-$fila['pagado'];
			$importe_segundo_pago=($total_con_descuento/2)-$fila['pagado'];
			//echo "Numero de pagos: ".$fila['num_pagos']."<br>";
			//echo "Importe segundo pago: ".$importe_segundo_pago."&euro;<br>";
			
			$cabeceras  = 'MIME-Version: 1.0' . "\r\n";
			$cabeceras .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
			$cabeceras .= 'From: info@exeleventos.com';
				
			$asunto='Recordatorio segundo pago';
			$mensaje='<table border="0" width="100%">
						<tr>
							<td>
								<img src="http://www.bilbodj.com/intranetv3/img/img_mail/cabecera.jpg" width="100%">
							</td>
						</tr>
						<tr>
							<td align="justify">
							
							<p>¡¡Hola!!</p>
											 
							<p>Os informamos de que estáis en el plazo para realizar el segundo pago de <strong>'.$importe_segundo_pago.' €</strong>.</p>
								
							<p>Este mensaje es automático y meramente informativo. Si ya habéis realizado dicho pago, comprobad que esté actualizado en vuestro perfil IntraBoda.</p>
								 
							<p>Para cualquier cuestión, podéis contactar con nosotros en el 94 652 18 39 o en info@exeleventos.com</p>
								
							<p>¡Gracias por confiar en EXEL Eventos S.L.!</p>
								
							<p>Atentamente Administración EXEL Eventos
</p>
								 
							</td>
							</tr>
							<tr>
								<td align="center"><img src="http://www.bilbodj.com/intranetv3/img/img_mail/pie.jpg" width="100%"></td>
							</tr>
						</table>';
			$asunto=html_entity_decode($asunto);
			$mensaje=html_entity_decode($mensaje);
		
			//mail($email_novio, $asunto, $mensaje, $cabeceras);
            //mail($email_novia, $asunto, $mensaje, $cabeceras);
           sendEmail('info@exeleventos.com', [$email_novio, $email_novia], $asunto, $mensaje);
        }
	}
}

/*TERCER PAGO*/
/*El tercer y último pago es de lo que resta del total y se manda el e-mail 30 días después de la boda*/
$result =mysql_query("SELECT id, email_novio, email_novia, servicios, descuento, DATE_FORMAT(fecha_boda, '%Y-%m-%d') as fecha_boda FROM clientes WHERE DATE_FORMAT(fecha_boda, '%Y-%m-%d')='".$fecha_busqueda_tercer_pago."' AND enviar_emails='S'", $link);
while ($fila = mysql_fetch_assoc($result)) {
	$arr_servicios = unserialize( $fila['servicios'] );
	$total = array_sum($arr_servicios);
	$total_con_descuento=$total-$fila['descuento'];
	$fecha_boda=$fila['fecha_boda'];
	$email_novio=$fila['email_novio'];
	$email_novia=$fila['email_novia'];
	//echo "Fecha de la boda: ".$fecha_boda."<br>";
	//echo "Total: ".$total_con_descuento."&euro;<br>";
	//echo "Fecha tercer pago: ".$fecha_busqueda_tercer_pago."<br>";
	

	$result =mysql_query("SELECT SUM(valor) as pagado, COUNT(valor) as num_pagos FROM pagos WHERE cliente_id='".$fila['id']."'", $link);
	while ($fila = mysql_fetch_assoc($result)) {
		if($fila['num_pagos']==""){
				$fila['num_pagos']=0;
		}
		if($fila['pagado']==""){
				$fila['pagado']=0;
		}
		if($fila['num_pagos']==2){
			$falta_por_pagar=$total_con_descuento-$fila['pagado'];
			//echo "Pagado: ".$fila['pagado']."&euro;<br>";
			//echo "Numero de pagos: ".$fila['num_pagos']."<br>";
			//echo "Importe segundo pago: ".$falta_por_pagar."&euro;<br>";
			
			$cabeceras  = 'MIME-Version: 1.0' . "\r\n";
			$cabeceras .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
			$cabeceras .= 'From: info@exeleventos.com';
				
			$asunto='Recordatorio tercer pago';
			$mensaje='<table border="0" width="100%">
						<tr>
							<td>
								<img src="http://www.bilbodj.com/intranetv3/img/img_mail/cabecera.jpg" width="100%">
							</td>
						</tr>
						<tr>
							<td align="justify">
							
							<p>¡¡Hola!!</p>
											 
							<p>Os informamos de que en los próximos días expira el plazo para realizar el último pago.</p>
								
							<p>Este mensaje es automático y meramente informativo. Si ya habéis realizado dicho pago, comprobad que esté actualizado en vuestro perfil IntraBoda.</p>
								 
							<p>Para cualquier cuestión, podéis contactar con nosotros en el 94 652 18 39 o en info@exeleventos.com</p>
								
							<p>¡Gracias por confiar en EXEL Eventos S.L.!</p>
								
							<p>Atentamente Administración EXEL Eventos
</p>
								 
							</td>
							</tr>
							<tr>
								<td align="center"><img src="http://www.bilbodj.com/intranetv3/img/img_mail/pie.jpg" width="100%"></td>
							</tr>
						</table>';
			$asunto=html_entity_decode($asunto);
			$mensaje=html_entity_decode($mensaje);
		
			/* mail($email_novio, $asunto, $mensaje, $cabeceras);
              mail($email_novia, $asunto, $mensaje, $cabeceras); */
            sendEmail('info@exeleventos.com', [$email_novio, $email_novia], $asunto, $mensaje);
        }
	}
}

/*FIN EMAIL RECORDATORIO DE LOS PAGOS*/
/*FIN EMAIL RECORDATORIO DE LOS PAGOS*/


/*EMAIL RECORDATORIO 75 Y 30 DIAS ANTES DE LA BODA*/
/*EMAIL RECORDATORIO 75 Y 30 DIAS ANTES DE LA BODA*/

$hoy=date("Y-m-d");
$fecha_busqueda_75dias_antes=date("Y-m-d",strtotime ('+75 day',strtotime($hoy)));
$fecha_busqueda_30dias_antes=date("Y-m-d",strtotime ('+30 day',strtotime($hoy)));

/*E-MAIL AUTOMÁTICO 75 DÍAS ANTES DE LA BODA*/
/*Se realiza exclusivamente SÓLO si NO se ha realizado al encuesta*/
$result =mysql_query("SELECT id, email_novio, email_novia FROM clientes WHERE DATE_FORMAT(fecha_boda, '%Y-%m-%d')='".$fecha_busqueda_75dias_antes."' AND enviar_emails='S'", $link);
while ($fila = mysql_fetch_assoc($result)) {
	$email_novio=$fila['email_novio'];
	$email_novia=$fila['email_novia'];
	
	$result2 =mysql_query("SELECT COUNT(id_respuesta) as num_respuestas FROM respuestas_encuesta_datos_boda WHERE id_cliente='".$fila['id']."'", $link);
	while ($fila2 = mysql_fetch_assoc($result2)) {
		//SI es 0 significa que NO han realizado la encuesta y deberemos mandar el e-mail
		if($fila2['num_respuestas']==0){
			$cabeceras  = 'MIME-Version: 1.0' . "\r\n";
			$cabeceras .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
			$cabeceras .= 'From: info@exeleventos.com';
				
			$asunto='Acordaros de acceder a Intraboda';
			$mensaje='<table border="0" width="100%">
						<tr>
							<td>
								<img src="http://www.bilbodj.com/intranetv3/img/img_mail/cabecera.jpg" width="100%">
							</td>
						</tr>
						<tr>
							<td align="justify">
							
							<p>¡Hola pareja!</p>
											 
							<p>Se va acercando la fecha y vemos que aún no habéis comenzado a personalizar vuestro perfil IntraBoda.</p>
								
							<p>Podéis acceder para completar la encuesta que nos facilitará asignar al DJ que mejor se adapte a vuestra boda y a los invitados.</p>
								 
							<p>Si tenéis cualquier duda al respecto, contactad con nosotros a través del 946521839 y os atenderemos encantados.</p>
								
							<p>¡Un saludo! </p>
								 
							</td>
							</tr>
							<tr>
								<td align="center"><img src="http://www.bilbodj.com/intranetv3/img/img_mail/pie.jpg" width="100%"></td>
							</tr>
						</table>';
			$asunto=html_entity_decode($asunto);
			$mensaje=html_entity_decode($mensaje);
		
			/* mail($email_novio, $asunto, $mensaje, $cabeceras);
              mail($email_novia, $asunto, $mensaje, $cabeceras); */
            sendEmail('info@exeleventos.com', [$email_novio, $email_novia], $asunto, $mensaje);
        }
	}
}


/*E-MAIL AUTOMÁTICO 30 DÍAS ANTES DE LA BODA*/
/*Se realiza SIEMPRE 30 días antes de la boda*/
$result =mysql_query("SELECT id, email_novio, email_novia FROM clientes WHERE DATE_FORMAT(fecha_boda, '%Y-%m-%d')='".$fecha_busqueda_30dias_antes."' AND enviar_emails='S'", $link);
while ($fila = mysql_fetch_assoc($result)) {
	$email_novio=$fila['email_novio'];
	$email_novia=$fila['email_novia'];
	
	$cabeceras  = 'MIME-Version: 1.0' . "\r\n";
	$cabeceras .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
	$cabeceras .= 'From: info@exeleventos.com';
	
	$asunto='¡¡Último mes de preparativos!!';
	$mensaje='<table border="0" width="100%">
			<tr>
				<td>
					<img src="http://www.bilbodj.com/intranetv3/img/img_mail/cabecera.jpg" width="100%">
				</td>
			</tr>
			<tr>
				<td align="justify">
				
				<p>¡Hola pareja!</p>
								 
				<p>¡Entramos en el último mes de preparativos! :D</p>
					
				<p>No olvidéis incluir todas las canciones que no queréis que falten en vuestro día. Asignar cada canción a su momento e incluir observaciones en la parte inferior si tuviéramos que tener en cuenta algún detalle especial.</p>
					 
				<p>Recordad que el perfil se bloqueará dos días antes para que tengamos el tiempo suficiente de recopilar los temas indicados y hacer el reparto de los equipos asignados a vuestro evento.</p>
				
				<p>Si tenéis cualquier duda, podéis comunicaros con nosotros a través del Chat o contactando con nuestra oficina en el 946521839.</p>
					
				<p>¡Un saludo! </p>
					 
				</td>
				</tr>
				<tr>
					<td align="center"><img src="http://www.bilbodj.com/intranetv3/img/img_mail/pie.jpg" width="100%"></td>
				</tr>
			</table>';
	$asunto=html_entity_decode($asunto);
	$mensaje=html_entity_decode($mensaje);

	/* mail($email_novio, $asunto, $mensaje, $cabeceras);
      mail($email_novia, $asunto, $mensaje, $cabeceras); */
    sendEmail('info@exeleventos.com', [$email_novio, $email_novia], $asunto, $mensaje);
}

/*FIN EMAIL RECORDATORIO 75 Y 30 DIAS ANTES DE LA BODA*/
/*FIN EMAIL RECORDATORIO 75 Y 30 DIAS ANTES DE LA BODA*/


/*E-MAIL AUTOMÁTICO 5 DÍAS ANTES DE LA BODA*/
$hoy=date("Y-m-d");
$fecha_busqueda_5dias_antes=date("Y-m-d",strtotime ('+5 day',strtotime($hoy)));

/*Se realiza SÓLO si tiene momentos especiales vacíos que NO sean el momento "fiesta"*/
$result =mysql_query("SELECT id, email_novio, email_novia FROM clientes WHERE DATE_FORMAT(fecha_boda, '%Y-%m-%d')='".$fecha_busqueda_5dias_antes."' AND enviar_emails='S'", $link);
while ($fila = mysql_fetch_assoc($result)) {
	$email_novio=$fila['email_novio'];
	$email_novia=$fila['email_novia'];
	$existen_momentos_vacios=false;
	
	$result2 =mysql_query("SELECT DISTINCT(id) as id_momento, nombre FROM momentos_espec WHERE cliente_id='".$fila['id']."'", $link);
	while ($fila2 = mysql_fetch_assoc($result2)) {
		$result3 =mysql_query("SELECT COUNT(id) as num_canciones FROM canciones WHERE momento_id='".$fila2['id_momento']."'", $link);
		while ($fila3 = mysql_fetch_assoc($result3)) {
			//Sólo se enviará e-mail si tiene momentos vacíos que NO sea el momento Fiesta, si Fiesta está vacío no pasa nada
			if($fila3['num_canciones']==0 && $fila2['nombre']<>"Fiesta"){
				//echo $fila["id"]."---".$fila2["nombre"]."<br>";
				$existen_momentos_vacios=true;
			}
		}
	}
	if($existen_momentos_vacios==true){
		$cabeceras  = 'MIME-Version: 1.0' . "\r\n";
		$cabeceras .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
		$cabeceras .= 'From: info@exeleventos.com';
		
		$asunto='Momentos especiales sin canciones asignadas';
		$mensaje='<table border="0" width="100%">
				<tr>
					<td>
						<img src="http://www.bilbodj.com/intranetv3/img/img_mail/cabecera.jpg" width="100%">
					</td>
				</tr>
				<tr>
					<td align="justify">
					
					<p>¡Hola pareja!</p>
					
					<p>Tan sólo quedan 5 días para vuestra boda y vemos que aún hay algunos momentos especiales sin canción asignada. Acceded a vuestro perfil para incluir los temas de los momentos pendientes.</p>
						
					<p>¡Un saludo! </p>
					
					<p>Equipo Exel Eventos</p>
						 
					</td>
					</tr>
					<tr>
						<td align="center"><img src="http://www.bilbodj.com/intranetv3/img/img_mail/pie.jpg" width="100%"></td>
					</tr>
				</table>';
		$asunto=html_entity_decode($asunto);
		$mensaje=html_entity_decode($mensaje);
	
		/* mail($email_novio, $asunto, $mensaje, $cabeceras);
          mail($email_novia, $asunto, $mensaje, $cabeceras); */
        sendEmail('info@exeleventos.com', [$email_novio, $email_novia], $asunto, $mensaje);
    }
}
/*FIN E-MAIL AUTOMÁTICO 5 DÍAS ANTES DE LA BODA*/



/*Actualizamos a NO INTERESADO todas las solicitudes cuyo estado de solicitud NO SEA FIRMADO y la fecha de la boda ya haya pasado*/
mysql_query("UPDATE solicitudes SET estado_solicitud='5' WHERE fecha_boda<NOW() AND estado_solicitud<>'2'", $link);
/*FIN actualizamos a NO INTERESADO todas las solicitudes cuyo estado de solicitud NO SEA FIRMADO y la fecha de la boda ya haya pasado*/
function sendEmail($from, $to, $subject, $message) {
    try {
        $this->config->load('mailconfig');
        $this->load->library('PHPMailer_Lib');
        $mail = $this->phpmailer_lib->load();
        $mail->isSMTP();
        $mail->Host = $this->config->item('host');
        $mail->SMTPAuth = $this->config->item('smtpauth');
        $mail->Username = $this->config->item('username');
        $mail->Password = $this->config->item('password');
        $mail->SMTPSecure = $this->config->item('smtpsecure');
        $mail->Port = $this->config->item('port');
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';
        $mail->setFrom($from, 'Exel Eventos');
        $mail->addReplyTo($from, 'Exel Eventos');
        // Add a recipient
        if (filter_var($to[0], FILTER_VALIDATE_EMAIL)) {
            $mail->addAddress($to[0]);
        } else {
            error_log("Email invalido " . var_export($to, 1), 3, "./r");
        }
        // Add cc or bcc
        for ($i = 1; $i < count($to) - 1; $i++) {
            if (filter_var($to[$i], FILTER_VALIDATE_EMAIL)) {
                $mail->addCC($to[$i]);
            }
        }

        /* $mail->addBCC('bcc@example.com'); */

        // Email subject
        $mail->Subject = $subject;
        // Set email format to HTML
        $mail->isHTML(true);
        // Email body content

        $mail->Body = $message;
        // Send email
        if (!$mail->send()) {
            error_log("\r\n Message could not be sent.'Mailer Error: " . $mail->ErrorInfo . "\r\n", 3, "./r");
        }
    } catch (Exception $e) {
        error_log("Algún tipo de error al enviar el correo " . var_export($e, 1), 3, "./r");
    }
}

?>