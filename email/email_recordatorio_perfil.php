<?php
include("../application/config/config2.php");

$link = mysql_connect($host, $usuario, $pass);
mysql_select_db($database, $link);

/*$link = mysql_connect("82.98.134.18", "bilbodj", "bilbodj");
mysql_select_db("bilbodj", $link);*/

$hoy=date("Y-m-d");
$fecha_busqueda_75dias_antes=date("Y-m-d",strtotime ('+75 day',strtotime($hoy)));
$fecha_busqueda_30dias_antes=date("Y-m-d",strtotime ('+30 day',strtotime($hoy)));


/*NO OLVIDAR QUITAR EL ID EN EL WHERE DE LAS CONSULTAS*/
/*NO OLVIDAR QUITAR EL ID EN EL WHERE DE LAS CONSULTAS*/
/*NO OLVIDAR QUITAR EL ID EN EL WHERE DE LAS CONSULTAS*/
/*NO OLVIDAR QUITAR EL ID EN EL WHERE DE LAS CONSULTAS*/
/*NO OLVIDAR QUITAR EL ID EN EL WHERE DE LAS CONSULTAS*/
/*NO OLVIDAR QUITAR EL ID EN EL WHERE DE LAS CONSULTAS*/


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

