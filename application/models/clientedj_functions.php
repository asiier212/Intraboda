<?php Class Clientedj_functions extends CI_Model{
	function GetGaleria($client_id)
	{
		$data = false;
		$this->load->database();
		$query = $this->db->query("SELECT id, nombre, auth_code FROM galeria WHERE client_id = {$client_id}");	
		if($query->num_rows() > 0){
			$i = 0;
			foreach($query->result() as $fila){
				$data[$i]['id'] = $fila->id;
				$data[$i]['nombre'] = $fila->nombre;
				$data[$i]['auth_code'] = $fila->auth_code;
				$i++;
			}
		}
		return $data;
	}
	function ClientLogin($mail, $clave)
	{
		$data = false;
		$this->load->database();
		$query = $this->db->query("SELECT id, email_novia, email_novio, nombre_novio, nombre_novia FROM clientes WHERE (email_novio  = '{$mail}' OR email_novia  = '{$mail}') AND clave = '{$clave}'");	
		if($query->num_rows() > 0){
			$fila = $query->row();
			$data['user_id'] = $fila->id;
			$data['nombre_novio'] = $fila->nombre_novio;
			$data['nombre_novia'] = $fila->nombre_novia;
			$data['email'] = $mail;
			$data['email_novia'] = $fila->email_novia;
			$data['email_novio'] = $fila->email_novio;
		}
		return $data;
	}
	function GetEvents($client_id)
	{
		$data = false;
		$this->load->database();
		$query = $this->db->query("SELECT id, nombre, orden FROM momentos_espec WHERE cliente_id  = {$client_id} ORDER BY orden");	
		if($query->num_rows() > 0){
			$i = 0;
			foreach($query->result() as $fila){
				$data[$i]['id'] = $fila->id;
				$data[$i]['nombre'] = $fila->nombre;
				$data[$i]['orden'] = $fila->orden;
				$query2 = $this->db->query("SELECT COUNT(id) as num_canciones FROM canciones WHERE momento_id= {$fila->id}");
				foreach($query2->result() as $fila2){
					$data[$i]['num_canciones'] = $fila2->num_canciones;
				}
				$i++;
			}
		}
		return $data;
	}
	function GetmomentosUser($client_id)
	{
		$data = false;
		$this->load->database();
		$query = $this->db->query("SELECT DISTINCT canciones.momento_id, momentos_espec.nombre, momentos_espec.orden FROM canciones INNER JOIN momentos_espec ON canciones.momento_id=momentos_espec.id WHERE canciones.client_id = {$client_id} ORDER BY momentos_espec.orden");	
		if($query->num_rows() > 0){
			$i = 0;
			foreach($query->result() as $fila){
				$data[$i]['momento_id'] = $fila->momento_id;
				$data[$i]['nombre'] = $fila->nombre;
				$data[$i]['orden'] = $fila->orden;
				$i++;
			}
		}
		return $data;
	}
	function GetcancionesUser($client_id)
	{
		$data = false;
		$this->load->database();
		$query = $this->db->query("SELECT id, momento_id, id_bd_canciones, orden FROM canciones WHERE client_id = {$client_id} ORDER BY momento_id, orden");	
		if($query->num_rows() > 0){
			$i = 0;
			foreach($query->result() as $fila){
				$data[$i]['id'] = $fila->id;
				$data[$i]['momento_id'] = $fila->momento_id;
				//$data[$i]['nombre'] = $fila->nombre;
				
				$query2 = $this->db->query("SELECT artista, cancion FROM bd_canciones WHERE id = {$fila->id_bd_canciones}");
				foreach($query2->result() as $fila2){
					$data[$i]['artista'] = $fila2->artista;
					$data[$i]['cancion'] = $fila2->cancion;
				}
				
				$data[$i]['orden'] = $fila->orden;
				$i++;
			}
		}
		return $data;
	}
	function GetObservaciones_momesp($client_id)
	{
		$data = false;
		$this->load->database();
		$query = $this->db->query("SELECT canciones_observaciones.id, momento_id, comentario, nombre, DATE_FORMAT(fecha, '%d/%m/%Y') as fecha FROM canciones_observaciones INNER JOIN momentos_espec ON canciones_observaciones.momento_id = momentos_espec.id WHERE momentos_espec.cliente_id = {$client_id} ORDER BY momento_id");	
		if($query->num_rows() > 0){
			$i = 0;
			foreach($query->result() as $fila){
				$data[$i]['id'] = $fila->id;
				$data[$i]['momento_id'] = $fila->momento_id;
				$data[$i]['nombre'] = $fila->nombre;
				$data[$i]['comentario'] = $fila->comentario;
				$data[$i]['fecha'] = $fila->fecha;
				$i++;
			}
		}
		return $data;
	}
	function GetObservaciones_general($client_id)
	{
		$data = false;
		$this->load->database();
		$query = $this->db->query("SELECT id, comentario, DATE_FORMAT(fecha, '%d/%m/%Y') as fecha FROM canciones_observaciones WHERE client_id = {$client_id} AND momento_id = 0 ORDER BY id DESC");	
		if($query->num_rows() > 0){
			$i = 0;
			foreach($query->result() as $fila){
				$data[$i]['id'] = $fila->id;
				$data[$i]['comentario'] = $fila->comentario;
				$data[$i]['fecha'] = $fila->fecha;
				$i++;
			}
		}
		return $data;
	}
	function InsertCancion($data, $user_id)
	{
		$this->load->database();
		unset($data['add_song']);
		unset($data['nombre_moment']);
		$data['client_id'] = $user_id;
		$data['orden'] = 1;
		$query = $this->db->query("SELECT COUNT(*) AS orden FROM canciones WHERE client_id = {$user_id} AND momento_id = ".$data['momento_id']."");	
		if($query->num_rows() > 0){
			$fila = $query->row();
			$data['orden'] = $fila->orden + 1;
		}
	
		//$this->db->insert('canciones', $data);
		
		
		//Miramos si en la base de datos de canciones está la canción
		$query = $this->db->query("SELECT * FROM bd_canciones WHERE artista = '".$data['artista']."' AND cancion = '".$data['nombre']."'");
		if($query->num_rows() < 1){
			//NO ESTÁ EN LA BASE DE DATOS DE CANCIONES POR LO QUE LA AÑADIMOS PERO SIN VALIDAR
			$this->db->query("INSERT INTO bd_canciones VALUES ('','".$data['artista']."', '".$data['nombre']."', '".$data['client_id']."', '".date("Y-m-d")."', 'N')");
			$query = $this->db->query("SELECT * FROM bd_canciones WHERE artista = '".$data['artista']."' AND cancion = '".$data['nombre']."'");
		}

		$fila = $query->row();
		$data['id_bd_canciones']=$fila->id;
		
		$query = $this->db->query("SELECT * FROM momentos_espec WHERE id = ".$data['momento_id']."");
		$fila = $query->row();
		$data['nombre_momento']=$fila->nombre;
		
		$query = $this->db->query("SELECT * FROM bd_momentos_espec WHERE momento = '".$data['nombre_momento']."'");
		if($query->num_rows() > 0){
			$fila = $query->row();
			$data['id_bd_momento']=$fila->id_momento;
		}
		else
		{
			$data['id_bd_momento']='null';
		}
		
		$this->db->query("INSERT INTO canciones VALUES ('','".$data['client_id']."', '".$data['momento_id']."', ".$data['id_bd_momento'].", '".$data['id_bd_canciones']."', '".$data['orden']."')");
		
	}
	function InsertCancionComentario($momento_id, $comentario, $client_id)
	{
		$this->load->database();
	
		$data['momento_id'] = $momento_id;
		$data['comentario'] = $comentario;
		$data['client_id'] = $client_id;
		$this->db->insert('canciones_observaciones', $data); 
		
	}
	function GetPersonasContacto($user_id)
	{
		$data = false;
		$this->load->database();
		$query = $this->db->query("SELECT personas_contacto FROM clientes WHERE id = {$user_id}");	
		$fila = $query->row();
		$personas_contacto = $fila->personas_contacto;
		//$query = $this->db->query("ALTER TABLE `clientes` ADD `descuento` DECIMAL NULL AFTER `servicios`;");
		$query = $this->db->query("SELECT id, nombre, telefono, email, tipo, foto FROM personas_contacto WHERE id IN ({$personas_contacto})");	
		if($query->num_rows() > 0){
			$i = 0;
			foreach($query->result() as $fila){
				$data[$i]['id'] = $fila->id;
				$data[$i]['nombre'] = $fila->nombre;
				$data[$i]['telefono'] = $fila->telefono;
				$data[$i]['email'] = $fila->email;
				$data[$i]['tipo'] = $fila->tipo;
				$data[$i]['foto'] = $fila->foto;
				$i++;
			}
		}
		return $data;
	}
	
	function GetMensajesContacto($user_id)
	{
		$data = false;
		$this->load->database();
		$query = $this->db->query("SELECT id_mensaje, id_cliente, fecha, usuario, id_usuario, mensaje FROM contacto WHERE id_cliente={$user_id}");	
		if($query->num_rows() > 0){
			$i = 0;
			foreach($query->result() as $fila){
				$data[$i]['id_mensaje'] = $fila->id_mensaje;
				$data[$i]['id_cliente'] = $fila->id_cliente;
				$data[$i]['fecha'] = $fila->fecha;
				$data[$i]['usuario'] = $fila->usuario;
				$data[$i]['id_usuario'] = $fila->id_usuario;
				$data[$i]['mensaje'] = $fila->mensaje;
				if($fila->usuario=='dj'){
					$query2 = $this->db->query("SELECT nombre FROM djs WHERE id={$fila->id_usuario}");
					foreach($query2->result() as $fila2){
						$data[$i]['nombre_dj'] = $fila2->nombre;
					}
				}
				$i++;
			}
		}
		return $data;
	}
	
	function GetDjAsignado($user_id)
	{
		$data = false;
		$this->load->database();
		$query = $this->db->query("SELECT dj FROM clientes WHERE id = {$user_id}");	
		$fila = $query->row();
		$dj = $fila->dj;
		//$query = $this->db->query("ALTER TABLE `clientes` ADD `descuento` DECIMAL NULL AFTER `servicios`;");
		if($dj <> "")
		{
			$query = $this->db->query("SELECT id, nombre, email, telefono, foto FROM djs WHERE id = ({$dj})");	
			if($query->num_rows() > 0){
				$i = 0;
				foreach($query->result() as $fila){
					$data[$i]['id'] = $fila->id;
					$data[$i]['nombre'] = $fila->nombre;
					$data[$i]['email'] = $fila->email;
					$data[$i]['telefono'] = $fila->telefono;
					$data[$i]['foto'] = $fila->foto;
					$i++;
				}
			}
		}
		return $data;
	}
	
	function GetCliente($id)
	{
		$data = false;
		$this->load->database();
		$query = $this->db->query("SELECT clientes.email_novio, clientes.email_novia, clientes.clave, clientes.nombre_novio, clientes.apellidos_novio, clientes.direccion_novio, clientes.cp_novio, clientes.poblacion_novio, clientes.telefono_novio, clientes.nombre_novia, clientes.apellidos_novia, clientes.direccion_novia, clientes.cp_novia, clientes.poblacion_novia, clientes.telefono_novia, clientes.foto, clientes.fecha_boda, restaurantes.nombre AS restaurante, restaurantes.direccion AS direccion_restaurante, restaurantes.telefono AS telefono_restaurante, clientes.servicios, clientes.personas_contacto, DATE_FORMAT(clientes.fecha_boda, '%d-%m-%Y') as fecha_boda, DATE_FORMAT(clientes.fecha_boda, '%H:%i') as hora_boda, restaurantes.maitre, restaurantes.telefono_maitre, clientes.contrato_pdf, clientes.presupuesto_pdf, clientes.descuento FROM clientes INNER JOIN restaurantes ON clientes.id_restaurante=restaurantes.id_restaurante WHERE clientes.id = {$id}");	
		
		if($query->num_rows() > 0){
			$fila = $query->row();	
			$data['email_novio'] = $fila->email_novio;
			$data['email_novia'] = $fila->email_novia;
			$data['clave'] = $fila->clave;
			$data['nombre_novio'] = $fila->nombre_novio;
			$data['nombre_novia'] = $fila->nombre_novia;
			$data['apellidos_novio'] = $fila->apellidos_novio;
			$data['direccion_novio'] = $fila->direccion_novio;
			$data['cp_novio'] = $fila->cp_novio;
			$data['poblacion_novio'] = $fila->poblacion_novio;
			$data['telefono_novio'] = $fila->telefono_novio;
			$data['telefono_novia'] = $fila->telefono_novia;
			$data['foto'] = $fila->foto;
			$data['restaurante'] = $fila->restaurante;
			$data['telefono_novia'] = $fila->telefono_novia;
			$data['direccion_restaurante'] = $fila->direccion_restaurante;
			$data['telefono_restaurante'] = $fila->telefono_restaurante;
			$data['servicios'] = $fila->servicios;
			$data['personas_contacto'] = $fila->personas_contacto;
			$data['apellidos_novia'] = $fila->apellidos_novia;
			$data['direccion_novia'] = $fila->direccion_novia;
			$data['cp_novia'] = $fila->cp_novia;
			$data['poblacion_novia'] = $fila->poblacion_novia;
			$data['fecha_boda'] = $fila->fecha_boda;
			$data['hora_boda'] = $fila->hora_boda;
			$data['maitre'] = $fila->maitre;
			$data['telefono_maitre'] = $fila->telefono_maitre;
			$data['contrato_pdf'] = $fila->contrato_pdf;
			$data['presupuesto_pdf'] = $fila->presupuesto_pdf;
			$data['descuento'] = $fila->descuento;

		}
		
	
		return $data;
	}
	function GetServicios($servicios)
	{
		$data = false;
		$this->load->database();
		$query = $this->db->query("SELECT id, nombre, precio FROM servicios WHERE id IN ({$servicios})");	
		if($query->num_rows() > 0){
			$i = 0;
			foreach($query->result() as $fila){
				$data[$i]['id'] = $fila->id;
				$data[$i]['nombre'] = $fila->nombre;
				$data[$i]['precio'] = $fila->precio;
				$i++;
			}
		}
		
		return $data;
	}
	
	
	function GetValoraciones($id)
	{
		$data = false;
		$this->load->database();
		$query = $this->db->query("SELECT * FROM preguntas_valoracion");	
		if($query->num_rows() > 0){
			$i = 0;
			foreach($query->result() as $fila){
				$data[$i]['id_pregunta'] = $fila->id;
				$data[$i]['pregunta'] = $fila->pregunta;
				$query2 = $this->db->query("SELECT * FROM respuestas_valoracion WHERE id_pregunta='".$fila->id."'  AND id_cliente='".$id."'");
				if($query2->num_rows() > 0){
					foreach($query2->result() as $fila2){
						$data[$i]['respuesta'] = $fila2->respuesta;
					}
				}
				else
				{
					$data[$i]['respuesta'] = "";
				}
				$i++;
			}
		}
		return $data;
	}
	
	function GetIncidencias($id)
	{
		$data = false;
		$this->load->database();
		$query = $this->db->query("SELECT * FROM incidencias WHERE id_cliente='".$id."'");
		$i=0;
		if($query->num_rows() > 0){
			foreach($query->result() as $fila){
				$data[$i]['incidencia'] = $fila->incidencia;
			}
		}
		else
		{
			$data[$i]['incidencia'] = "";
		}
		//$i++;
		return $data;
	}
	
	function GetCancionesPendientes($id)
	{
		$data = false;
		$this->load->database();
		$query = $this->db->query("SELECT * FROM canciones_pendientes WHERE id_cliente='".$id."'");
		$i=0;
		if($query->num_rows() > 0){
			foreach($query->result() as $fila){
				$data[$i]['canciones'] = $fila->canciones;
			}
		}
		else
		{
			$data[$i]['canciones'] = "";
		}
		//$i++;
		return $data;
	}
	
	function GetJuegos()
	{
		$data = false;
		$this->load->database();
		$query = $this->db->query("SELECT * FROM juegos");
		if($query->num_rows() > 0){
			$i = 0;
			foreach($query->result() as $fila){
				$data[$i]['id_juego'] = $fila->id;
				$data[$i]['juego'] = $fila->juego;
				$i++;
			}
		}
		return $data;
	}

	function InsertValoraciones($data, $id)
	{
		$this->load->database();
		$data['juegos'] = implode(",", $data['juegos']);
		$query = $this->db->query("SELECT * FROM preguntas_valoracion");
		if($query->num_rows() > 0){
			$i = 0;
			foreach($query->result() as $fila){
				$query2 = $this->db->query("SELECT * FROM respuestas_valoracion WHERE id_pregunta='".$fila->id."'  AND id_cliente='".$id."'");
				if($query2->num_rows() > 0){
					//ES UNA UPDATE
					if($fila->id=='5') //pregunta de checkbox
					{
						$query = $this->db->query("UPDATE respuestas_valoracion SET respuesta='".$data['juegos']."' WHERE id_pregunta='".$fila->id."' AND id_cliente='".$id."'");
					}
					elseif($fila->id=='6'){ //pregunta de hora de inicio
						$query = $this->db->query("UPDATE respuestas_valoracion SET respuesta='".$data['hora_inicio']."' WHERE id_pregunta='".$fila->id."' AND id_cliente='".$id."'");
					}
					else
					{
						$query = $this->db->query("UPDATE respuestas_valoracion SET respuesta='".$data['res'.$fila->id]."' WHERE id_pregunta='".$fila->id."' AND id_cliente='".$id."'");
					}
				}
				else
				{
					if($fila->id=='5') //pregunta de checkbox
					{
						$query = $this->db->query("INSERT INTO respuestas_valoracion (id_pregunta,id_cliente,respuesta) VALUES ('".$fila->id."',".$id.",'".$data['juegos']."')");
					}
					elseif($fila->id=='6') //pregunta de hora de inicio
					{
						$query = $this->db->query("INSERT INTO respuestas_valoracion (id_pregunta,id_cliente,respuesta) VALUES ('".$fila->id."',".$id.",'".$data['hora_inicio']."')");
					}
					else
					{
						$query = $this->db->query("INSERT INTO respuestas_valoracion (id_pregunta,id_cliente,respuesta) VALUES ('".$fila->id."',".$id.",'".$data['res'.$fila->id]."')");
					}
				}
			}
		}
	}
	
	
	function InsertIncidencias($data, $id)
	{
		$this->load->database();
		$query = $this->db->query("SELECT * FROM incidencias WHERE id_cliente='".$id."'");
		if($query->num_rows() > 0){
			//Es una update
			$query = $this->db->query("UPDATE incidencias SET incidencia='".str_replace("'", "''",$data['incidencia'])."' WHERE id_cliente='".$id."'");
		}
		else
		{
			$query = $this->db->query("INSERT INTO incidencias (id_cliente,incidencia) VALUES (".$id.",'".str_replace("'", "''",$data['incidencia'])."')");
		}
	}
	
	
	function InsertCancionesPendientes($data, $id)
	{
		$this->load->database();
		$query = $this->db->query("SELECT * FROM canciones_pendientes WHERE id_cliente='".$id."'");
		if($query->num_rows() > 0){
			//Es una update
			$query = $this->db->query("UPDATE canciones_pendientes SET canciones='".$data['texto_canciones_pendientes']."' WHERE id_cliente='".$id."'");
		}
		else
		{
			$query = $this->db->query("INSERT INTO canciones_pendientes (id_cliente,canciones) VALUES (".$id.",'".$data['texto_canciones_pendientes']."')");
		}
	}
	
	
	
	
	
	
	function SendMailPersona($persona_id, $mail_desde, $asunto, $mensaje)
	{
		$data = false;
		$this->load->database();
		$query = $this->db->query("SELECT email FROM personas_contacto WHERE id = {$persona_id}");	
		$fila = $query->row();
		$email_to = $fila->email;
		
		$cabeceras  = 'MIME-Version: 1.0' . "\r\n";
		$cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$cabeceras .= 'From: '.$mail_desde;
		//$send = mail("w-marek@hotmail", $asunto, $mensaje, $cabeceras);
        //$send = mail($email_to, $asunto, $mensaje, $cabeceras);
		/*
		$this->load->library('email');

		$this->email->from($mail_desde);
		$this->email->to($email_to);
		//$this->email->to("w-marek@hotmail.com");
		$this->email->subject("Mensaje de Intraboda: " .$asunto);
		$this->email->message($mensaje);
		
		$this->email->send();
		
		$data = $this->email->print_debugger();
*/
		/*$cabeceras  = 'MIME-Version: 1.0' . "\r\n";
		$cabeceras .= 'Content-type: text/html; charset=utf-8' . "\r\n";
		$cabeceras .= 'From: '.$mail_desde;

		$send = mail("w-marek@hotmail.com", "Mensaje de Intraboda: " . $asunto, $mensaje, $cabeceras);*/
		return $send;
	}
	function UpdatefotoCliente($id, $foto)
	{
		
		$this->load->database();
		$this->db->query("UPDATE clientes SET foto = '".$foto."' WHERE id = {$id}");	
		
	}
	function GetAvailableServicios($user_id){
		$data = false;
		$this->load->database();
		$query = $this->db->query("SELECT servicios FROM clientes WHERE id = {$user_id}");
		if($query->num_rows() > 0)
		{
			$fila = $query->row();	
			
			$query = $this->db->query("SELECT id, nombre, precio, precio_oferta FROM servicios WHERE id NOT IN (".$fila->servicios.")");
		} else {
			$query = $this->db->query("SELECT id, nombre, precio, precio_oferta FROM servicios");
		}
		
		if($query->num_rows() > 0){
			$i = 0;
			foreach($query->result() as $fila){
				$data[$i]['id'] = $fila->id;
				$data[$i]['nombre'] = $fila->nombre;
				$data[$i]['precio'] = $fila->precio;
				$data[$i]['precio_oferta'] = $fila->precio_oferta;
				$i++;
			}
		}
		return $data;
	}
		function GetPagos($cliente_id)
	{
		$data = array();
		$this->load->database();
		$query = $this->db->query("SELECT valor, DATE_FORMAT(fecha, '%d-%m-%Y') as fecha FROM pagos WHERE cliente_id = {$cliente_id } ");	
		if($query->num_rows() > 0){
			$i = 0;
			foreach($query->result() as $fila){
				$data[$i]['valor'] = $fila->valor;
				$data[$i]['fecha'] = $fila->fecha;
				$i++;
			}
		}
		return $data;
	}
	function InsertEvent($nombre, $cliente_id)
	{
		
		$this->load->database();
		$orden = 1;
		$query = $this->db->query("SELECT COUNT(*) AS orden FROM momentos_espec WHERE cliente_id = {$cliente_id}");	
		if($query->num_rows() > 0){
			$fila = $query->row();
			$orden = $fila->orden + 1;
		}
		$query = $this->db->query("INSERT INTO momentos_espec (nombre, cliente_id, orden) VALUES ('".str_replace("'", "&#39;",$nombre)."', {$cliente_id}, ".$orden.")");	
		
		
	}
	
	
}
?>