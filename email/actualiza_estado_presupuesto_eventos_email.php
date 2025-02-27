<?php
include("../application/config/config2.php");

$link = mysql_connect($host, $usuario, $pass);
mysql_select_db($database, $link);

/*$link = mysql_connect("82.98.134.18", "bilbodj", "bilbodj");
mysql_select_db("bilbodj", $link);*/

$result =mysql_query("SELECT nombre_estado FROM estados_solicitudes WHERE id_estado='".$_GET['estado_actualizado']."'", $link);

while ($fila = mysql_fetch_assoc($result)) {
	$nombre_estado_actualizado=$fila['nombre_estado'];
}

$result =mysql_query("SELECT * FROM presupuesto_eventos WHERE id_presupuesto='".$_GET['id_presupuesto']."' AND email='".html_entity_decode($_GET['email'])."' AND (estado_solicitud='1' OR estado_solicitud='6')", $link);

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
	
	if(mysql_query("UPDATE presupuesto_eventos SET estado_solicitud='".$_GET['estado_actualizado']."' WHERE id_presupuesto='".$fila['id_presupuesto']."'",$link)){
		?>
        <html xmlns="http://www.w3.org/1999/xhtml">
        <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>ESTADO ACTUALIZADO - <?php echo strtoupper($nombre_oficina)?></title>
        <link href="../css/style.css" rel="stylesheet" type="text/css" />
        </head>
        <body>
        <div id="top"><div>&nbsp;</div></div>
        <div class="page">
        <div class="header">
          <div class="title">
            <h1> <img src="<?php echo $url.'uploads/oficinas/'.$logo_mail_oficina?>" width="200" /></h1>
          </div>
          <div class="loginDisplay"> </div>
          
        </div>
        <h2>ACTUALIZACIÓN</h2>
        <div class="mensaje_confirmacion">
          <p>Sus datos han sido enviados a los técnicos de <?php echo strtoupper($nombre_oficina)?></p>
          <p>¡¡MUCHAS GRACIAS!!</p>
        </div>
        <div class="footer"> </div>
        </div>
        </body>
        </html>
        <?php
		
		//Mandamos email al comercial de este cliente
		$result2 = mysql_query("SELECT comerciales.email FROM comerciales,presupuesto_eventos WHERE comerciales.id=presupuesto_eventos.id_comercial and presupuesto_eventos.id_presupuesto='".$fila['id_presupuesto']."'", $link);
		while ($fila2 = mysql_fetch_assoc($result2)) {
			$cabeceras  = 'MIME-Version: 1.0' . "\r\n";
			$cabeceras .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
			$cabeceras .= 'From: '.$email_oficina;
			
			$asunto='Actualizacion de solicitud de presupuesto de eventos';
			$mensaje='<table border="0" width="100%">
			<tr>
				<td>
					<img src="http://www.bilbodj.com/intranetv3/img/img_mail/cabecera.jpg" width="100%">
				</td>
			</tr>
			<tr>
				<td align="justify"><p>La solicitud de presupuesto de eventos de <b>'.utf8_encode($fila['nombre']).' '.utf8_encode($fila['apellidos']).'</b> con fecha de alta <b>'.$fila['fecha_alta'].'</b> ha sido actualizada al estado <font color="red"><b>'.$nombre_estado_actualizado.'</b></font>.</p>
					
					<p>¡Revisa el perfil del cliente!</p> 
					<p>¡Recibe un cordial saludo!<br>
					El Equipo '.$nombre_oficina.'</p>
				</td>
				</tr>
				<tr>
					<td align="center"><img src="http://www.bilbodj.com/intranetv3/img/img_mail/pie.jpg" width="100%"></td>
				</tr>
			</table>';
			
			$asunto=html_entity_decode($asunto);
			$mensaje=html_entity_decode($mensaje);
	
			//mail($fila2['email'], $asunto, $mensaje, $cabeceras);
            sendEmail('info@exeleventos.com', [$fila2['email']], $asunto, $mensaje);
        }
		
	}	 
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

