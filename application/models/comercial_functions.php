<?php

class Comercial_functions extends CI_Model
{

	function ComercialLogin($mail, $clave)
	{
		$data = false;
		$this->load->database();
		$this->load->library('encrypt');
		$clave_sin_cifrar = "";

		// Busco la clave cifrada del comercial
		$query2 = $this->db->query("SELECT clave FROM comerciales WHERE email = '{$mail}'");
		if ($query2->num_rows() > 0) {
			$fila2 = $query2->row();
			$clave_cifrada = $fila2->clave;

			// Desencripto la clave cifrada para compararla
			$clave_sin_cifrar = $this->encrypt->decode($clave_cifrada);
		}

		// Comparo la clave descifrada con la introducida
		if ($clave_sin_cifrar !== $clave) {
			$clave = "ERROR";
		}

		// Si la clave es correcta, obtengo los datos del comercial
		if ($clave !== "ERROR") {
			$query = $this->db->query("SELECT id, email, nombre, foto, solo_eventos FROM comerciales WHERE email = '{$mail}'");
			if ($query->num_rows() > 0) {
				$fila = $query->row();
				$data = [
					'id' => $fila->id,
					'nombre' => $fila->nombre,
					'foto' => $fila->foto,
					'email' => $fila->email, // Aquí asigno el email real
					'solo_eventos' => $fila->solo_eventos
				];

				// Guardar en sesión el email del comercial para evitar consultas posteriores
				$this->session->set_userdata('email_comercial', $fila->email);
			}
		}

		return $data;
	}


	function GetCaptacion()
	{
		$data = false;
		$this->load->database();
		$query = $this->db->query("SELECT id, nombre FROM canales_captacion");
		if ($query->num_rows() > 0) {
			$i = 0;
			foreach ($query->result() as $fila) {
				$data[$i]['id'] = $fila->id;
				$data[$i]['nombre'] = $fila->nombre;
				$i++;
			}
		}
		return $data;
	}

	function GetEstados_Solicitudes()
	{
		$data = false;
		$this->load->database();
		$query = $this->db->query("SELECT id_estado, nombre_estado FROM estados_solicitudes");
		if ($query->num_rows() > 0) {
			$i = 0;
			foreach ($query->result() as $fila) {
				$data[$i]['id_estado'] = $fila->id_estado;
				$data[$i]['nombre_estado'] = $fila->nombre_estado;
				$i++;
			}
		}
		return $data;
	}


	function InsertSolicitud($data)
	{

		$this->load->database();
		$this->db->insert('solicitudes', $data);
		$id_solicitud = $this->db->insert_id();

		//Damos de alta el seguimiento de llamadas
		$hoy = date('Y-m-d');
		$nueva_llamada = strtotime('+7 day', strtotime($hoy));
		$nueva_llamada = date('Y-m-d', $nueva_llamada);

		$this->db->query("INSERT INTO llamadas_solicitudes (id_solicitud, id_comercial, observaciones, proxima_llamada) VALUES (" . $this->db->insert_id() . ", " . $this->session->userdata('id') . ", 'Cliente dado de alta', '" . $nueva_llamada . "')");

		return $id_solicitud;
	}

	function GetSolicitudes($str_where, $ord, $limit)
	{
		$data = false;
		$this->load->database();

		$query = $this->db->query("SELECT id_solicitud, n_presupuesto, nombre, apellidos, restaurante, DATE_FORMAT(fecha_boda, '%d-%m-%Y %H:%i') as fecha_boda, DATE_FORMAT(fecha, '%d-%m-%Y') as fecha_alta, id_comercial, estado_solicitud FROM solicitudes {$str_where} ORDER BY {$ord}   {$limit}");
		//$query = $this->db->query("SELECT id, clave, foto, nombre_novio, nombre_novia, restaurante, DATE_FORMAT(fecha_boda, '%d-%m-%Y %H:%i') as fecha_boda, DATE_FORMAT(fecha, '%d-%m-%Y') as fecha_alta FROM clientes");
		if ($query->num_rows() > 0) {
			$i = 0;
			foreach ($query->result() as $fila) {

				/*$this->load->library('encrypt');
				$query = $this->db->query("UPDATE clientes SET clave = '" . $this->encrypt->encode($fila->clave) . "' WHERE id = '" . $fila->id . "'");*/

				$data[$i]['id_solicitud'] = $fila->id_solicitud;
				$data[$i]['n_presupuesto'] = $fila->n_presupuesto;
				$data[$i]['nombre'] = $fila->nombre;
				$data[$i]['apellidos'] = $fila->apellidos;
				$data[$i]['restaurante'] = $fila->restaurante;
				$data[$i]['fecha_boda'] = $fila->fecha_boda;
				$data[$i]['fecha'] = $fila->fecha_alta;
				$data[$i]['id_comercial'] = $fila->id_comercial;
				$data[$i]['estado_solicitud'] = $fila->estado_solicitud;

				$i++;
			}
		}
		return $data;
	}

	function GetSolicitud($id)
	{
		$data = false;
		$this->load->database();
		$query = $this->db->query("SELECT n_presupuesto, email, nombre, apellidos, direccion, cp, poblacion, telefono, canal_captacion, restaurante, DATE_FORMAT(fecha_boda, '%d-%m-%Y') as fecha_boda, DATE_FORMAT(fecha_boda, '%H:%i') as hora_boda, estado_solicitud, id_comercial, importe, descuento FROM solicitudes WHERE id_solicitud = {$id}");

		if ($query->num_rows() > 0) {
			$fila = $query->row();
			$data['id_solicitud'] = $id;
			$data['n_presupuesto'] = $fila->n_presupuesto;
			$data['email'] = $fila->email;
			$data['nombre'] = $fila->nombre;
			$data['apellidos'] = $fila->apellidos;
			$data['direccion'] = $fila->direccion;
			$data['cp'] = $fila->cp;
			$data['poblacion'] = $fila->poblacion;
			$data['telefono'] = $fila->telefono;
			$data['canal_captacion'] = $fila->canal_captacion;
			$data['restaurante'] = $fila->restaurante;
			$data['fecha_boda'] = $fila->fecha_boda;
			$data['hora_boda'] = $fila->hora_boda;
			$data['estado_solicitud'] = $fila->estado_solicitud;
			$data['id_comercial'] = $fila->id_comercial;
			$data['presupuesto_pdf'] = $fila->presupuesto_pdf;
			$data['importe'] = $fila->importe;
			$data['descuento'] = $fila->descuento;
		}

		return $data;
	}

	function GetObservaciones_Solicitud($id)
	{
		$data = false;
		$this->load->database();
		$query = $this->db->query("SELECT id, id_comercial, comentario, DATE_FORMAT(fecha, '%d-%m-%Y %H:%i') as fecha FROM observaciones_solicitudes WHERE id_solicitud = {$id} ORDER BY id DESC");
		if ($query->num_rows() > 0) {
			$i = 0;
			foreach ($query->result() as $fila) {
				$query2 = $this->db->query("SELECT nombre FROM comerciales WHERE id = {$fila->id_comercial}");
				foreach ($query2->result() as $fila2) {
					$nombre_comercial = $fila2->nombre;
				}
				$data[$i]['id'] = $fila->id;
				$data[$i]['comercial'] = $nombre_comercial;
				$data[$i]['comentario'] = $fila->comentario;
				$data[$i]['fecha'] = $fila->fecha;
				$i++;
			}
		}
		return $data;
	}

	function GetEncuesta_Solicitud($id)
	{
		$data = false;
		$this->load->database();
		$total_importe_descuento = 0;
		$query = $this->db->query("SELECT id_pregunta, id_respuesta, DATE_FORMAT(fecha, '%d-%m-%Y %H:%i') as fecha FROM encuestas_solicitudes WHERE id_solicitud = {$id} ORDER BY id_pregunta ASC");
		if ($query->num_rows() > 0) {
			$i = 0;
			foreach ($query->result() as $fila) {
				$query2 = $this->db->query("SELECT pregunta, importe_descuento FROM preguntas_encuesta WHERE id_pregunta = {$fila->id_pregunta}");
				foreach ($query2->result() as $fila2) {
					$pregunta = $fila2->pregunta;
				}

				$query2 = $this->db->query("SELECT respuesta FROM respuestas_encuesta WHERE id_respuesta = {$fila->id_respuesta}");
				foreach ($query2->result() as $fila2) {
					$respuesta = $fila2->respuesta;
				}

				$data[$i]['pregunta'] = $pregunta;
				$data[$i]['respuesta'] = $respuesta;
				//$data[$i]['total_importe_descuento'] = $total_importe_descuento;
				$data[$i]['fecha'] = $fila->fecha;
				$i++;
			}

			$query2 = $this->db->query("SELECT SUM(importe_descuento) as total_importe_descuento FROM preguntas_encuesta");
			foreach ($query2->result() as $fila2) {
				$data[0]['total_importe_descuento'] = $fila2->total_importe_descuento;
			}
		}
		return $data;
	}

	function GetLLamadas_Solicitudes()
	{
		$data = false;
		$this->load->database();


		$query = $this->db->query("SELECT solicitudes.id_solicitud, llamadas_solicitudes.id_llamada, DATE_FORMAT(llamadas_solicitudes.fecha_llamada, '%d-%m-%Y %H:%i') as fecha_llamada, llamadas_solicitudes.id_comercial,  llamadas_solicitudes.proxima_llamada FROM solicitudes INNER JOIN llamadas_solicitudes ON solicitudes.id_solicitud=llamadas_solicitudes.id_solicitud WHERE solicitudes.estado_solicitud<>2 AND solicitudes.estado_solicitud<>5 AND solicitudes.estado_solicitud<>8 ORDER BY llamadas_solicitudes.proxima_llamada ASC");
		if ($query->num_rows() > 0) {
			$i = 0;
			foreach ($query->result() as $fila) {
				//Tengo que hacer el MAX(id_llamada) para saber cúal ha sido la última de cada resultado de solicitudes NO HAY OTRA
				$query_max_id_llamada = $this->db->query("SELECT MAX(id_llamada) as id_llamada FROM llamadas_solicitudes WHERE id_solicitud='" . $fila->id_solicitud . "'");
				if ($query_max_id_llamada->num_rows() > 0) {
					foreach ($query_max_id_llamada->result() as $fila_max_id_llamada) {
						$max_id_llamada = $fila_max_id_llamada->id_llamada;
					}
				}

				if ($fila->id_llamada == $max_id_llamada) {
					$data[$i]['id_solicitud'] = $fila->id_solicitud;
					$query2 = $this->db->query("SELECT nombre, apellidos FROM solicitudes WHERE id_solicitud = {$fila->id_solicitud}");
					foreach ($query2->result() as $fila2) {
						$nombre_solicitud = $fila2->nombre . " " . $fila2->apellidos;
					}
					$data[$i]['solicitud'] = $nombre_solicitud;
					$data[$i]['fecha_llamada'] = $fila->fecha_llamada;
					$query2 = $this->db->query("SELECT nombre FROM comerciales WHERE id = {$fila->id_comercial}");
					foreach ($query2->result() as $fila2) {
						$nombre_comercial = $fila2->nombre;
					}
					$data[$i]['comercial'] = $nombre_comercial;
					$data[$i]['proxima_llamada'] = $fila->proxima_llamada;
					$i++;
				}
			}
		}

		return $data;
	}

	function GetLLamadas_Solicitud($id)
	{
		$data = false;
		$this->load->database();
		$query = $this->db->query("SELECT id_llamada, DATE_FORMAT(fecha_llamada, '%d-%m-%Y %H:%i') as fecha_llamada, id_comercial, observaciones, DATE_FORMAT(proxima_llamada, '%d-%m-%Y %H:%i') as proxima_llamada FROM llamadas_solicitudes WHERE id_solicitud = {$id} ORDER BY id_llamada DESC");
		if ($query->num_rows() > 0) {
			$i = 0;
			foreach ($query->result() as $fila) {
				$data[$i]['id_llamada'] = $fila->id_llamada;
				$data[$i]['fecha_llamada'] = $fila->fecha_llamada;
				$query2 = $this->db->query("SELECT nombre FROM comerciales WHERE id = {$fila->id_comercial}");
				foreach ($query2->result() as $fila2) {
					$nombre_comercial = $fila2->nombre;
				}
				$data[$i]['comercial'] = $nombre_comercial;
				$data[$i]['observaciones'] = $fila->observaciones;
				$data[$i]['proxima_llamada'] = $fila->proxima_llamada;
				$i++;
			}
		}
		return $data;
	}

	function GetPorcentajeContratacion($fecha_desde, $fecha_hasta, $id_comercial)
	{
		$data = false;
		$this->load->database();

		$num_presupuestos_firmados = 0;
		$num_presupuestos_enviados = 0;
		$num_presupuestos_totales = 0;

		$query = $this->db->query("SELECT id_estado FROM estados_solicitudes WHERE nombre_estado='Firmado'");
		$fila = $query->row();
		$estado_firmado = $fila->id_estado;

		$query = $this->db->query("SELECT COUNT(id_solicitud) as num FROM solicitudes WHERE fecha>='" . $fecha_desde . " 00:00:00' AND fecha<='" . $fecha_hasta . " 23:59:59' AND estado_solicitud=" . $estado_firmado . " AND id_comercial=" . $id_comercial . "");
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $fila) {
				$num_presupuestos_firmados = $fila->num;
			}
		}

		$query = $this->db->query("SELECT COUNT(id_solicitud) as num FROM solicitudes WHERE fecha>='" . $fecha_desde . " 00:00:00' AND fecha<='" . $fecha_hasta . " 23:59:59' AND id_comercial=" . $id_comercial . "");
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $fila) {
				$num_presupuestos_enviados = $fila->num;
			}
		}


		$query = $this->db->query("SELECT COUNT(id_solicitud) as num FROM solicitudes WHERE fecha>='" . $fecha_desde . " 00:00:00' AND fecha<='" . $fecha_hasta . " 23:59:59'");
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $fila) {
				$num_presupuestos_totales = $fila->num;
			}
		}

		if ($num_presupuestos_firmados <> 0) {
			$data[0]['porcentaje_contratacion'] = number_format(($num_presupuestos_firmados * 100) / $num_presupuestos_totales, 2);
		} else {
			$data[0]['porcentaje_contratacion'] = 0;
		}

		$data[0]['fecha_desde'] = $fecha_desde;
		$data[0]['fecha_hasta'] = $fecha_hasta;
		$data[0]['presupuestos_totales'] = $num_presupuestos_totales;
		$data[0]['presupuestos_firmados'] = $num_presupuestos_firmados;
		$data[0]['presupuestos_enviados'] = $num_presupuestos_enviados;

		return $data;
	}

	function GraficoPorcentajeContratacion($fecha_desde, $fecha_hasta, $id_comercial)
	{
		$data = false;
		$this->load->database();

		$this->load->library('highcharts');
		$data['home'] = strtolower(__CLASS__) . '/';
		$this->load->vars($data);

		$num_presupuestos_firmados = 0;
		$num_presupuestos_enviados = 0;
		$num_presupuestos_totales = 0;

		$query = $this->db->query("SELECT COUNT(id_solicitud) as num FROM solicitudes WHERE fecha>='" . $fecha_desde . " 00:00:00' AND fecha<='" . $fecha_hasta . " 23:59:59' AND id_comercial=" . $id_comercial . "");
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $fila) {
				$num_presupuestos_totales = $fila->num;
			}
		}


		/*$query = $this->db->query("SELECT id_estado FROM estados_solicitudes WHERE nombre_estado='Firmado'");
		$fila = $query->row();
		$estado_firmado=$fila->id_estado;
		
		
		$query = $this->db->query("SELECT COUNT(id_solicitud) as num FROM solicitudes WHERE fecha>='".$fecha_desde."' AND fecha<='".$fecha_hasta."' AND estado_solicitud=".$estado_firmado." AND id_comercial=".$id_comercial."");
		if($query->num_rows() > 0){
			foreach($query->result() as $fila)
			{
				$num_presupuestos_firmados=$fila->num;
			}
		}
		
		if($num_presupuestos_firmados<>0)
		{
			$porcentaje_firmados=number_format(($num_presupuestos_firmados*100)/$num_presupuestos_totales,2);
		}
		*/


		$query = $this->db->query("SELECT id_estado, nombre_estado FROM estados_solicitudes");
		if ($query->num_rows() > 0) {
			$i = 0;
			foreach ($query->result() as $fila) {
				$porcentaje[$i] = 0;
				$num_presupuestos = 0;

				$query2 = $this->db->query("SELECT COUNT(id_solicitud) as num FROM solicitudes WHERE fecha>='" . $fecha_desde . " 00:00:00' AND fecha<='" . $fecha_hasta . " 23:59:59' AND estado_solicitud=" . $fila->id_estado . " AND id_comercial=" . $id_comercial . "");
				if ($query2->num_rows() > 0) {
					foreach ($query2->result() as $fila2) {
						$num_presupuestos = $fila2->num;
					}
					if ($num_presupuestos <> 0) {
						$porcentaje[$i] = number_format(($num_presupuestos * 100) / $num_presupuestos_totales, 2);
					}
					$nombre_e[$i] = $fila->nombre_estado;
					$i++;
				}
			}
		}



		$serie['data'] = array();

		for ($i = 0; $i < count($porcentaje); $i++) {
			array_push($serie['data'], array($nombre_e[$i], (int) $porcentaje[$i]));
		}


		//POR SI LO QUIERO METER A MANO UNO A UNO
		/*$serie['data']	= array(
			array($nombre_e[0], (int) $porcentaje[0]), 
			array($nombre_e[1], (int) $porcentaje[1]),
			array($nombre_e[2], (int) $porcentaje[2]),
			array($nombre_e[3], (int) $porcentaje[3]),
			array($nombre_e[4], (int) $porcentaje[4]),
		);*/


		$callback = "function() { return '<b>'+ this.point.name +'</b>: '+ this.y +' %'}";

		@$tool->formatter = $callback;
		@$plot->pie->dataLabels->formatter = $callback;

		$this->highcharts
			->set_type('pie')
			->set_serie($serie)
			->set_tooltip($tool)
			->set_title('ESTADISTICA', 'Porcentaje de presupuestos')
			->set_plotOptions($plot);

		return $data;
	}

	function GetEventos()
	{
		$data = false;
		$this->load->database();
		$query = $this->db->query("SELECT id_evento, nombre_evento FROM eventos ORDER BY id_evento DESC");
		if ($query->num_rows() > 0) {
			$i = 0;
			foreach ($query->result() as $fila) {
				$data[$i]['id_evento'] = $fila->id_evento;
				$data[$i]['nombre_evento'] = $fila->nombre_evento;
				$i++;
			}
		}
		return $data;
	}

	function GetServicios()
	{
		$data = false;
		$this->load->database();
		$query = $this->db->query("SELECT id, nombre, descripcion, precio, precio_oferta FROM servicios");
		if ($query->num_rows() > 0) {
			$i = 0;
			foreach ($query->result() as $fila) {
				$data[$i]['id'] = $fila->id;
				$data[$i]['nombre'] = $fila->nombre;
				$data[$i]['descripcion'] = $fila->descripcion;
				$data[$i]['precio'] = $fila->precio;
				$data[$i]['precio_oferta'] = $fila->precio_oferta;
				$i++;
			}
		}
		return $data;
	}

	function InsertPresupuestoEvento($data)
	{

		$this->load->database();
		$this->db->insert('presupuesto_eventos', $data);
		$id_presupuesto = $this->db->insert_id();

		$query = $this->db->query("SELECT nombre FROM restaurantes WHERE nombre='" . $data['restaurante'] . "'");
		if ($query->num_rows() == 0) {
			//Mandamos un email si no existe el restaurante en la base de datos de restaurantes y lo añadimos//

			$this->db->query("INSERT INTO restaurantes VALUES('','" . $data['restaurante'] . "', '', '', '', '', '', '', '')");


			$html = 'Nuevo restaurante <b>' . $data['restaurante'] . '</b>.<br>Revise la base de datos de restaurantes.';
			$asunto = 'Nuevo restaurante en la base de datos';

			$cabeceras  = 'MIME-Version: 1.0' . "\r\n";
			$cabeceras .= 'Content-type: text/html; charset=utf-8' . "\r\n";
			$cabeceras .= 'From: info@exeleventos.com';
			//mail("info@exeleventos.com", $asunto, $html, $cabeceras);
			$this->sendEmail('info@exeleventos.com', ["info@exeleventos.com"], $asunto, $mensaje);
		}

		return $id_presupuesto;
	}

	function GetPresupuestosEventos($str_where, $ord, $limit)
	{
		$data = false;
		$this->load->database();

		$query = $this->db->query("SELECT id_presupuesto, nombre, apellidos, restaurante, DATE_FORMAT(fecha_boda, '%d-%m-%Y %H:%i') as fecha_boda, id_comercial, evento, fecha_alta FROM presupuesto_eventos {$str_where} ORDER BY {$ord}   {$limit}");
		//$query = $this->db->query("SELECT id, clave, foto, nombre_novio, nombre_novia, restaurante, DATE_FORMAT(fecha_boda, '%d-%m-%Y %H:%i') as fecha_boda, DATE_FORMAT(fecha, '%d-%m-%Y') as fecha_alta FROM clientes");

		if ($query->num_rows() > 0) {
			$i = 0;
			foreach ($query->result() as $fila) {

				$data[$i]['id_presupuesto'] = $fila->id_presupuesto;
				$data[$i]['nombre'] = $fila->nombre;
				$data[$i]['apellidos'] = $fila->apellidos;
				$data[$i]['restaurante'] = $fila->restaurante;
				$data[$i]['fecha_boda'] = $fila->fecha_boda;
				$data[$i]['id_comercial'] = $fila->id_comercial;
				$data[$i]['evento'] = $fila->evento;
				$data[$i]['fecha_alta'] = $fila->fecha_alta;

				$i++;
			}

			$query2 = $this->db->query("SELECT COUNT(id_presupuesto) as total FROM presupuesto_eventos {$str_where}");
			foreach ($query2->result() as $fila2) {
				$data[0]['total'] = $fila2->total;
			}
		}
		return $data;
	}

	function GetPresupuestoEvento($id)
	{
		$data = false;
		$this->load->database();
		$query = $this->db->query("SELECT id_presupuesto, nombre, apellidos, email, telefono, restaurante, DATE_FORMAT(fecha_boda, '%d-%m-%Y') as fecha_boda, DATE_FORMAT(fecha_boda, '%H:%i') as hora_boda, evento, id_comercial, servicios, importe, descuento, total, estado_solicitud FROM presupuesto_eventos WHERE id_presupuesto = {$id}");

		if ($query->num_rows() > 0) {
			$fila = $query->row();
			$data['id_presupuesto'] = $id;
			$data['email'] = $fila->email;
			$data['nombre'] = $fila->nombre;
			$data['apellidos'] = $fila->apellidos;
			$data['telefono'] = $fila->telefono;
			$data['restaurante'] = $fila->restaurante;
			$data['fecha_boda'] = $fila->fecha_boda;
			$data['hora_boda'] = $fila->hora_boda;
			$data['evento'] = $fila->evento;
			$data['id_comercial'] = $fila->id_comercial;
			$data['servicios'] = $fila->servicios;
			$data['importe'] = $fila->importe;
			$data['descuento'] = $fila->descuento;
			$data['total'] = $fila->total;
			$data['estado_solicitud'] = $fila->estado_solicitud;
		}

		return $data;
	}

	function GetObservaciones_Presupuesto_Eventos($id)
	{
		$data = false;
		$this->load->database();
		$query = $this->db->query("SELECT id, id_comercial, comentario, DATE_FORMAT(fecha, '%d-%m-%Y %H:%i') as fecha FROM observaciones_presupuesto_eventos WHERE id_presupuesto = {$id} ORDER BY id DESC");
		if ($query->num_rows() > 0) {
			$i = 0;
			foreach ($query->result() as $fila) {
				$query2 = $this->db->query("SELECT nombre FROM comerciales WHERE id = {$fila->id_comercial}");
				foreach ($query2->result() as $fila2) {
					$nombre_comercial = $fila2->nombre;
				}
				$data[$i]['id'] = $fila->id;
				$data[$i]['comercial'] = $nombre_comercial;
				$data[$i]['comentario'] = $fila->comentario;
				$data[$i]['fecha'] = $fila->fecha;
				$i++;
			}
		}
		return $data;
	}

	public function getEmailsParaEnviar()
	{
		$fechaHoy = date('Y-m-d');
		$id_comercial = $this->session->userdata('id');
		log_message("INFO", "id comercial: " . $id_comercial);
		

		$this->db->select('*');
		$this->db->from('emails_automaticos');
		$this->db->where('estado', 1);
		$this->db->where('fecha_envio', $fechaHoy);
		$this->db->where('id_comercial', $id_comercial);
		return $this->db->get()->result();
	}


	public function getClientesPendientes($fecha_envio)
	{
		$this->db->select('solicitudes.id_solicitud, solicitudes.email, solicitudes.id_comercial');
		$this->db->from('solicitudes');
		$this->db->join('estados_solicitudes', 'solicitudes.estado_solicitud = estados_solicitudes.id_estado');
		$this->db->join('emails_automaticos', 'solicitudes.fecha >= emails_automaticos.creado_en AND solicitudes.fecha <= emails_automaticos.fecha_envio', 'inner');
		$this->db->where('estados_solicitudes.nombre_estado', 'Pendiente de Respuesta');
		$this->db->where('emails_automaticos.fecha_envio', $fecha_envio);

		return $this->db->get()->result();
	}



	public function getEmailComercial($id_comercial)
	{
		$this->db->select('email');
		$this->db->from('comerciales');
		$this->db->where('id', $id_comercial);
		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			return $query->row()->email;
		}
		return null; // Retorna null si no encuentra el email
	}


	public function registrarEmailEnviado($id_email, $id_solicitud, $id_comercial)
	{
		$data = [
			'id_email' => $id_email,
			'id_solicitud' => $id_solicitud,
			'id_comercial' => $id_comercial
		];
		$this->db->insert('emails_enviados', $data);
	}

	public function vaciarFirma()
	{
		$this->db->query("UPDATE emails_automaticos SET firma = ''");
	}
}
