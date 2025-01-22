<?php

//Parece ser un controlador que envía correos electrónicos a través de PHPMailer y SMTP.
//Para ello, primero se carga la biblioteca PHPMailer y se configura el servidor SMTP.
//A continuación, se establece el remitente, el destinatario, el asunto y el contenido del correo electrónico.
//Pero SIEMPRE envia el correo al mismo destinatario, en este caso a '10patrick.deba@gmail.com'.
//Deduzco que es un controlador de PRUEBA para enviar correos electrónicos.
//Pero esto no responde a la duda de porque solo le llega el email a un solo destinatario.

//Deberiamos poner $mail->addAddress($email_novio); para que el email se envie al novio.
//Y poner $mail->addAddress($email_novia); para que el email se envie a la novia.




if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Email extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

    function send() {
        // Load PHPMailer library
        $this->load->library('phpmailer_lib');

        // PHPMailer object
        $mail = $this->phpmailer_lib->load();

        // SMTP configuration
        $mail->isSMTP();
        $mail->Host = 'smtp.ionos.es';
        $mail->SMTPAuth = true;
        $mail->Username = 'info@exeleventos.com';
        $mail->Password = '1492BDJ5319';
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;

        $mail->setFrom('info@exeleventos.com', 'Prueba de envío de correo');
        $mail->addReplyTo('info@exeleventos.com', 'A quien contextar');

        // Add a recipient
        $mail->addAddress('10patrick.deba@gmail.com');

        // Add cc or bcc
       /* $mail->addCC('cc@example.com');
          $mail->addBCC('bcc@example.com'); */

        // Email subject
        $mail->Subject = 'Prueba de envío de email desde Intraboda';

        // Set email format to HTML
        $mail->isHTML(true);

        // Email body content
        $mailContent = "<h1>Envío de correo desde Intranet Exel eventos</h1>
                <p>Si esto llega, es que estamos avanzando un poco.</p>";
        $mail->Body = $mailContent;

        // Send email
        if (!$mail->send()) {
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        } else {
            echo 'Message has been sent';
        }
    }
}
