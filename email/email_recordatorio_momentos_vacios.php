<?php
include("../application/config/config2.php");

$link = mysql_connect($host, $usuario, $pass);
mysql_select_db($database, $link);

/*$link = mysql_connect("82.98.134.18", "bilbodj", "bilbodj");
mysql_select_db("bilbodj", $link);*/

$hoy=date("Y-m-d");
$fecha_busqueda_5dias_antes=date("Y-m-d",strtotime ('+5 day',strtotime($hoy)));

/*NO OLVIDAR QUITAR EL ID EN EL WHERE DE LAS CONSULTAS*/
/*NO OLVIDAR QUITAR EL ID EN EL WHERE DE LAS CONSULTAS*/
/*NO OLVIDAR QUITAR EL ID EN EL WHERE DE LAS CONSULTAS*/
/*NO OLVIDAR QUITAR EL ID EN EL WHERE DE LAS CONSULTAS*/
/*NO OLVIDAR QUITAR EL ID EN EL WHERE DE LAS CONSULTAS*/
/*NO OLVIDAR QUITAR EL ID EN EL WHERE DE LAS CONSULTAS*/



/*E-MAIL AUTOMÁTICO 5 DÍAS ANTES DE LA BODA*/
/*Se realiza SÓLO si tiene momentos especiales vacíos que NO sean el momento "fiesta"*/
$result =mysql_query("SELECT id, email_novio, email_novia FROM clientes WHERE DATE_FORMAT(fecha_boda, '%Y-%m-%d')='".$fecha_busqueda_5dias_antes."' AND enviar_emails='S' AND id='1'", $link);
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

