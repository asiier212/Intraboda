<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Ajax extends CI_Controller {

function updateordencanciones()
{
  	if($_POST) 
	{
   		$order = str_replace('c_','',$_POST['order']);
		$arr = explode(',',$order);
   		$this->load->database();
  
  		$query = $this->db->query("SELECT id FROM canciones WHERE id IN ({$order}) ORDER BY FIELD( id, {$order} )");	
		
		if($query->num_rows() > 0)
		{
			$i = 1;
			foreach($query->result() as $fila)
			{
				$q[] = "UPDATE canciones SET orden = {$i} WHERE id = ".$fila->id."";
				$i++;
			}
		}
		foreach($q as $r)
		{
			$this->db->query($r);
		}
	}
}

function updateobservaciones()
{
  	if($_POST) 
	{
		$this->load->database();
		$this->db->query("UPDATE canciones_observaciones SET comentario = '".$_POST['value']."' WHERE id = ".$_POST['id']."");
		echo $_POST['value'];
	}
}
function deletecancion()
{
  	if($_POST) 
	{
		$this->load->database();
		$this->db->query("DELETE FROM canciones WHERE id = ".$_POST['id']."");
		
	}
}
function deleteobservacion(){
	if($_POST) 
	{
		$this->load->database();
		$this->db->query("DELETE FROM canciones_observaciones WHERE id = ".$_POST['id']."");
		
	}
}
function deleteobservacion_admin(){
	if($_POST) 
	{
		$this->load->database();
		$this->db->query("DELETE FROM observaciones WHERE id = ".$_POST['id']."");
		
	}
}
function updatedatocliente($id = false)
{
echo "1";
  	if($_POST) 
	{
		
		$this->load->database();
		$id_cliente = "";
		$result = $_POST['value'];
		
		if($id) {
			//admin
			
			$id_cliente = $id;
			
		} else {	
			//cliente
			$this->load->library('session');
			$id_cliente = $this->session->userdata('user_id');
			
		}
		if($_POST['id'] == 'fecha_boda' || $_POST['id'] == 'hora_boda') {
			$query = $this->db->query("SELECT fecha_boda FROM clientes WHERE id = {$id_cliente}");	
			$fila = $query->row();	
			$str_fechaDB = explode(" ",$fila->fecha_boda);
		
			if($_POST['id'] == 'fecha_boda') {
				$str_fecha = explode("-",$_POST['value']);
				$_POST['value'] = $str_fecha[2]."-".$str_fecha[1]."-".$str_fecha[0]." ".$str_fechaDB[1];
				
			} elseif($_POST['id'] == 'hora_boda') {
				
				$_POST['value'] = $str_fechaDB[0]." ".$_POST['value']. ":00";
				
			}
		
		}
		
		$this->db->query("UPDATE clientes SET ".$_POST['id']." = '".str_replace("'", "&#39;",$_POST['value'])."' WHERE id = {$id_cliente}");
		if($id_cliente == 1)
			//echo "UPDATE clientes SET ".$_POST['id']." = '".str_replace("'", "&#39;",$_POST['value'])."' WHERE id = {$id_cliente}";
 			echo $_POST['id'];
			//echo $result;
		else
		echo $result;
		
		//$this->send_mail( str_replace("_", " ", $_POST['id']) . "->" . $_POST['value'] );
	
	}
	
}
public function send_mail($mensaje){

	$mensaje = "Usuario ". $this->session->userdata('nombre_novia') . "(".$this->session->userdata('email_novia').") & ". $this->session->userdata('nombre_novio') . "(".$this->session->userdata('email_novio')." ha cambiado siguente dato: " . $mensaje;
	
	$cabeceras  = 'MIME-Version: 1.0' . "\r\n";
	$cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$cabeceras .= 'From: info@exeleventos.com';

        //$send = mail("info@exeleventos.com", "Intraboda - Cambio de datos del usuario", $mensaje, $cabeceras);
        $this->sendEmail('info@exeleventos.com', ["info@exeleventos.com"], "Intraboda - Cambio de datos del usuario", $mensaje);
    }

    private function sendEmail($from, $to, $subject, $message) {
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
}
?>