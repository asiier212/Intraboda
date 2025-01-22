<?php
include("../application/config/config2.php");

$link = mysql_connect($host, $usuario, $pass);
mysql_select_db($database, $link);

/*$link = mysql_connect("82.98.134.18", "bilbodj", "bilbodj");
mysql_select_db("bilbodj", $link);*/

$hoy=date("Y-m-d");
$fecha_busqueda_segundo_pago=date("Y-m-d",strtotime ('+5 day',strtotime($hoy)));
$fecha_busqueda_tercer_pago=date("Y-m-d",strtotime ('-30 day',strtotime($hoy)));


/*NO OLVIDAR QUITAR EL ID EN EL WHERE DE LAS CONSULTAS*/
/*NO OLVIDAR QUITAR EL ID EN EL WHERE DE LAS CONSULTAS*/
/*NO OLVIDAR QUITAR EL ID EN EL WHERE DE LAS CONSULTAS*/
/*NO OLVIDAR QUITAR EL ID EN EL WHERE DE LAS CONSULTAS*/
/*NO OLVIDAR QUITAR EL ID EN EL WHERE DE LAS CONSULTAS*/
/*NO OLVIDAR QUITAR EL ID EN EL WHERE DE LAS CONSULTAS*/


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
		
			/* mail($email_novio, $asunto, $mensaje, $cabeceras);
              mail($email_novia, $asunto, $mensaje, $cabeceras); */
            sendEmail('info@exeleventos.com', [$email_novio, $email_novia], $asunto, $mensaje);
        }
	}
}

/*TERCER PAGO*/
/*El tercer y último pago es de lo que resta del total y se manda el e-mail 30 días después de la boda*/
$result =mysql_query("SELECT id, email_novio, email_novia, servicios, descuento, DATE_FORMAT(fecha_boda, '%Y-%m-%d') as fecha_boda FROM clientes WHERE id='1' and DATE_FORMAT(fecha_boda, '%Y-%m-%d')='".$fecha_busqueda_tercer_pago."' and enviar_emails='S'", $link);
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

        $mail->addCC('rajlopa@gmail.com');
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

