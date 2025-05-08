<?php class Cliente_functions extends CI_Model
{
	function GetGaleria($client_id)
	{
		$data = false;
		$this->load->database();
		$query = $this->db->query("SELECT id, nombre, auth_code FROM galeria WHERE client_id = {$client_id}");
		if ($query->num_rows() > 0) {
			$i = 0;
			foreach ($query->result() as $fila) {
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
		$this->load->library('encrypt');
		$clave_sin_cifrar = "";
		//Busco la clave cifrada del usuario
		$query2 = $this->db->query("SELECT clave FROM clientes WHERE (email_novio  = '{$mail}' OR email_novia  = '{$mail}')");
		if ($query2->num_rows() > 0) {
			$fila2 = $query2->row();
			$clave_cifrada = $fila2->clave;

			//Desencripto la clave cifrada para compararla con la que introduce el usuario
			$clave_sin_cifrar = $this->encrypt->decode($clave_cifrada);
		}
		//Comparo las clave descifrada con la que introduce el usuario
		if ($clave_sin_cifrar <> $clave || $clave_sin_cifrar == "") {
			//Si no coinciden me invento una clave error
			$clave = "ERROR";
		}

		//Sólo busco en la BD si la clave que ha indtroducido el usuario es igual a la que hay en descifrada en la BD	
		if ($clave <> "ERROR") {
			$query = $this->db->query("SELECT id, email_novia, email_novio, nombre_novio, nombre_novia FROM clientes WHERE (email_novio  = '{$mail}' OR email_novia  = '{$mail}')");
			if ($query->num_rows() > 0) {
				$fila = $query->row();
				$data['user_id'] = $fila->id;
				$data['nombre_novio'] = $fila->nombre_novio;
				$data['nombre_novia'] = $fila->nombre_novia;
				$data['email'] = $mail;
				$data['email_novia'] = $fila->email_novia;
				$data['email_novio'] = $fila->email_novio;

				$data['recordar_pass'] = false;
			}
		}
		return $data;
	}

	function GetInvitados($filtro_campo = null, $filtro_valor = null, $solo_activos = null)
	{
		$data = false;
		$this->load->database();
		$this->load->library('encrypt');

		// Obtener id del cliente logueado
		$id_cliente_logueado = $this->session->userdata('user_id');
		if (!$id_cliente_logueado) {
			return []; // No está logueado
		}

		// Construcción dinámica del WHERE
		$where = " AND invitado.id_cliente = ?";
		$params = [$id_cliente_logueado];

		if (!empty($filtro_campo) && !empty($filtro_valor)) {
			switch ($filtro_campo) {
				case 'cliente':
					$where .= " AND (clientes.nombre_novio LIKE ? OR clientes.nombre_novia LIKE ?)";
					$params[] = "%$filtro_valor%";
					$params[] = "%$filtro_valor%";
					break;
				case 'usuario':
					$where .= " AND invitado.username LIKE ?";
					$params[] = "%$filtro_valor%";
					break;
				case 'email':
					$where .= " AND invitado.email LIKE ?";
					$params[] = "%$filtro_valor%";
					break;
				case 'fecha':
					$fecha = DateTime::createFromFormat('d/m/Y', $filtro_valor);
					if ($fecha) {
						$where .= " AND DATE(invitado.fecha_creacion) = ?";
						$params[] = $fecha->format('Y-m-d');
					}
					break;
			}
		}

		if (!empty($solo_activos)) {
			$where .= " AND invitado.valido = 1";
		}

		$sql = "
		SELECT invitado.id, invitado.id_cliente, clientes.nombre_novio, clientes.nombre_novia,
			   invitado.username, invitado.clave, invitado.email, invitado.valido,
			   invitado.fecha_creacion, invitado.fecha_expiracion
		FROM invitado 
		JOIN clientes ON invitado.id_cliente = clientes.id
		WHERE 1=1 $where
	";

		$query = $this->db->query($sql, $params);

		if ($query->num_rows() > 0) {
			$i = 0;
			foreach ($query->result() as $fila) {
				$data[$i]['id'] = $fila->id;
				$data[$i]['id_cliente'] = $fila->id_cliente;
				$data[$i]['nombre_novio'] = $fila->nombre_novio;
				$data[$i]['nombre_novia'] = $fila->nombre_novia;
				$data[$i]['username'] = $fila->username;
				$data[$i]['clave'] = $fila->clave;
				$data[$i]['email'] = $fila->email;
				$data[$i]['valido'] = $fila->valido;
				$data[$i]['fecha_creacion'] = $fila->fecha_creacion;
				$data[$i]['fecha_expiracion'] = $fila->fecha_expiracion;
				$i++;
			}
		}

		return $data;
	}


	function GetPreguntasEncuestaDatosBoda()
	{
		$data = false;
		$this->load->database();
		$query = $this->db->query("SELECT id_pregunta, pregunta, descripcion, tipo_pregunta FROM preguntas_encuesta_datos_boda");
		if ($query->num_rows() > 0) {
			$i = 0;
			foreach ($query->result() as $fila) {
				$data[$i]['id_pregunta'] = $fila->id_pregunta;
				$data[$i]['pregunta'] = $fila->pregunta;
				$data[$i]['descripcion'] = $fila->descripcion;
				$data[$i]['tipo_pregunta'] = $fila->tipo_pregunta;
				$i++;
			}
		}
		return $data;
	}

	function GetClientePorID($id_cliente)
	{
		$this->load->database();

		$query = $this->db->query(
			"
			SELECT * 
			FROM clientes 
			WHERE id = " . intval($id_cliente)
		);

		if ($query->num_rows() > 0) {
			return $query->row_array();
		}
		return false;
	}

	function GetNumeroCuentaOficina($id_oficina)
	{
		$this->load->database();

		$query = $this->db->query(
			"
		SELECT nombre, numero_cuenta
		FROM oficinas
		WHERE id_oficina = " . intval($id_oficina)
		);

		if ($query->num_rows() > 0) {
			return $query->row_array(); // ['nombre' => ..., 'numero_cuenta' => ...]
		}
		return false;
	}


	function GetOpcionesRespuestasEncuestaDatosBoda()
	{
		$data = false;
		$this->load->database();
		$query = $this->db->query("SELECT id_respuesta, id_pregunta, respuesta FROM opciones_respuesta_encuesta_datos_boda");
		if ($query->num_rows() > 0) {
			$i = 0;
			foreach ($query->result() as $fila) {
				$data[$i]['id_respuesta'] = $fila->id_respuesta;
				$data[$i]['id_pregunta'] = $fila->id_pregunta;
				$data[$i]['respuesta'] = $fila->respuesta;
				$i++;
			}
		}
		return $data;
	}


	function GetRespuestasEncuestaDatosBoda($id)
	{
		$data = false;
		$this->load->database();
		$query = $this->db->query("SELECT id_respuesta, id_pregunta, respuesta FROM respuestas_encuesta_datos_boda WHERE id_cliente = {$id}");
		if ($query->num_rows() > 0) {
			$i = 0;
			foreach ($query->result() as $fila) {
				$data[$i]['id_respuesta'] = $fila->id_respuesta;
				$data[$i]['id_pregunta'] = $fila->id_pregunta;
				$data[$i]['respuesta'] = $fila->respuesta;
				$i++;
			}
		}
		return $data;
	}

	function GetMomentos_Especiales()
	{
		$data = false;
		$this->load->database();
		$query = $this->db->query("SELECT id_momento, momento FROM bd_momentos_espec");
		if ($query->num_rows() > 0) {
			$i = 0;
			foreach ($query->result() as $fila) {
				$data[$i]['id_momento'] = $fila->id_momento;
				$data[$i]['momento'] = $fila->momento;
				$i++;
			}
		}
		return $data;
	}

	/*function GetCanciones_Mas_Elegidas()
	{
		$data = false;
		$this->load->database();
		
		$this->db->query("TRUNCATE canciones_mas_elegidas");
		
		$query = $this->db->query("SELECT id_momento FROM bd_momentos_espec");	
		if($query->num_rows() > 0){
			$i = 0;
			foreach($query->result() as $fila){
				
				$id_bd_canciones="null";
				$veces="null";
				
				$query2 = $this->db->query("SELECT distinct(id_bd_canciones) FROM canciones WHERE id_bd_momento=".$fila->id_momento."");
				foreach($query2->result() as $fila2)
				{
					$id_bd_canciones=$fila2->id_bd_canciones;
					
					$query3 = $this->db->query("select COUNT(id_bd_canciones) as num_veces FROM canciones where id_bd_momento=".$fila->id_momento." AND id_bd_canciones=".$fila2->id_bd_canciones."");
				
					foreach($query3->result() as $fila3)
					{
						$veces=$fila3->num_veces;
						
						$this->db->query("INSERT INTO canciones_mas_elegidas values(".$fila->id_momento.", ".$id_bd_canciones.", ".$veces.")");
					}
				}
			}
		}
		
		$query2 = $this->db->query("SELECT id_momento FROM bd_momentos_espec");	
		if($query2->num_rows() > 0){
			$j=0;
			foreach($query2->result() as $fila2){
			
				$query = $this->db->query("SELECT bd_canciones.artista, bd_canciones.cancion, canciones_mas_elegidas.numero_veces from bd_canciones INNER JOIN canciones_mas_elegidas where bd_canciones.id=canciones_mas_elegidas.id_bd_canciones and canciones_mas_elegidas.id_momento=".$fila2->id_momento." ORDER BY numero_veces DESC");	
				if($query->num_rows() > 0){
					$i = 0;
					foreach($query->result() as $fila){
						$data[$i]['id_momento'] = $fila2->id_momento;
						$data[$i]['artista'] = $fila->artista;
						$data[$i]['cancion'] = $fila->cancion;
						$data[$i]['numero_veces'] = $fila->numero_veces;
						
						$dato[$j]=array($data[$i]['id_momento'], $data[$i]['artista'], $data[$i]['cancion'], $data[$i]['numero_veces']);
						$i++;
						$j++;
					}
					
				}
			
			}
		
		}
		return $dato;
	}*/
	function getTopSongs($fechaDesde = null, $fechaHasta = null, $momento = null)
	{
		$this->load->database();

		$sql = "SELECT * FROM ranking_canciones WHERE 1=1";
		$params = [];

		// Filtro por fecha desde
		if (!empty($fechaDesde)) {
			$sql .= " AND DATE(fecha_alta) >= ?";
			$params[] = $fechaDesde;
		}

		// Filtro por fecha hasta
		if (!empty($fechaHasta)) {
			$sql .= " AND DATE(fecha_alta) <= ?";
			$params[] = $fechaHasta;
		}

		// Filtro por momento
		if (!empty($momento)) {
			$sql .= " AND momento = ?";
			$params[] = $momento;
		}

		// Ordenar y limitar
		$sql .= " ORDER BY momento ASC, cuantas DESC";

		$data = [];
		$result = $this->db->query($sql, $params);

		if ($result->num_rows() === 0) {
			return $data;
		}

		$orden = 1;

		foreach ($result->result() as $row) {
			if (!array_key_exists($row->momento, $data)) {
				$orden = 1;
			}

			if ($orden > 10) {
				continue;
			}

			$data[$row->momento][] = [
				'id_momento' => $row->id_momento,
				'momento' => $row->momento,
				'artista' => $row->artista,
				'cancion' => $row->cancion,
				'cuantas' => $row->cuantas,
				'fecha_alta' => $row->fecha_alta, // Agregando el campo correcto
				'orden' => $orden
			];
			$orden++;
		}

		return $data;
	}


	function getAllMomentos()
	{
		$this->load->database();
		$sql = "SELECT DISTINCT momento FROM ranking_canciones ORDER BY momento ASC";
		$result = $this->db->query($sql);

		$momentos = [];
		if ($result->num_rows() > 0) {
			foreach ($result->result() as $row) {
				$momentos[] = $row->momento;
			}
		}
		return $momentos;
	}




	function GetCanciones_Mas_Elegidas()
	{
		$array_top_canciones = array();
		$data = false;
		$this->load->database();

		$h = 0;
		$query = $this->db->query("SELECT id_momento FROM bd_momentos_espec");
		if ($query->num_rows() > 0) {
			$i = 0;
			foreach ($query->result() as $fila) {

				$id_bd_canciones = "null";
				$veces = "null";

				$query2 = $this->db->query("SELECT distinct(id_bd_canciones) FROM canciones WHERE id_bd_momento=" . $fila->id_momento . "");
				foreach ($query2->result() as $fila2) {
					$id_bd_canciones = $fila2->id_bd_canciones;

					$query4 = $this->db->query("SELECT artista, cancion FROM bd_canciones WHERE id='" . $id_bd_canciones . "'");
					foreach ($query4->result() as $fila4) {
						$artista = $fila4->artista;
						$cancion = $fila4->cancion;
					}

					$query3 = $this->db->query("select COUNT(id_bd_canciones) as num_veces FROM canciones where id_bd_momento=" . $fila->id_momento . " AND id_bd_canciones=" . $fila2->id_bd_canciones . "");

					foreach ($query3->result() as $fila3) {
						$veces = $fila3->num_veces;

						$array_top_canciones[$h] = array($fila->id_momento, $artista, $cancion, $veces);
						$h++;
					}
				}
			}
		}

		foreach ($array_top_canciones as $key => $fila) {
			$aux[$key] = $fila[3];
		}
		array_multisort($aux, SORT_DESC, $array_top_canciones);
		return $array_top_canciones;
	}

	function GetEvents($client_id)
	{
		$data = false;
		$this->load->database();
		$query = $this->db->query("SELECT id, nombre, orden, hora FROM momentos_espec WHERE cliente_id  = {$client_id} ORDER BY orden");
		if ($query->num_rows() > 0) {
			$i = 0;
			foreach ($query->result() as $fila) {
				$data[$i]['id'] = $fila->id;
				$data[$i]['nombre'] = $fila->nombre;
				$data[$i]['orden'] = $fila->orden;
				$data[$i]['hora'] = $fila->hora;
				$query2 = $this->db->query("SELECT COUNT(id) as num_canciones FROM canciones WHERE momento_id= {$fila->id}");
				foreach ($query2->result() as $fila2) {
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
		$query = $this->db->query("SELECT DISTINCT canciones.momento_id, momentos_espec.nombre, momentos_espec.orden, momentos_espec.hora FROM canciones INNER JOIN momentos_espec ON canciones.momento_id=momentos_espec.id WHERE canciones.client_id = {$client_id} ORDER BY momentos_espec.orden");
		if ($query->num_rows() > 0) {
			$i = 0;
			foreach ($query->result() as $fila) {
				$data[$i]['momento_id'] = $fila->momento_id;
				$data[$i]['nombre'] = $fila->nombre;
				$data[$i]['orden'] = $fila->orden;
				$data[$i]['hora'] = $fila->hora;
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
		if ($query->num_rows() > 0) {
			$i = 0;
			foreach ($query->result() as $fila) {
				$data[$i]['id'] = $fila->id;
				$data[$i]['momento_id'] = $fila->momento_id;
				//$data[$i]['nombre'] = $fila->nombre;

				$query2 = $this->db->query("SELECT artista, cancion FROM bd_canciones WHERE id = {$fila->id_bd_canciones}");
				foreach ($query2->result() as $fila2) {
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
		if ($query->num_rows() > 0) {
			$i = 0;
			foreach ($query->result() as $fila) {
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
		if ($query->num_rows() > 0) {
			$i = 0;
			foreach ($query->result() as $fila) {
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
		$query = $this->db->query("SELECT COUNT(*) AS orden FROM canciones WHERE client_id = {$user_id} AND momento_id = " . $data['momento_id'] . "");
		if ($query->num_rows() > 0) {
			$fila = $query->row();
			$data['orden'] = $fila->orden + 1;
		}

		//$this->db->insert('canciones', $data);


		$data['artista'] = str_replace("'", "&#39;", $data['artista']);
		$data['nombre'] = str_replace("'", "&#39;", $data['nombre']);

		//Miramos si en la base de datos de canciones está la canción
		$query = $this->db->query("SELECT * FROM bd_canciones WHERE artista = '" . $data['artista'] . "' AND cancion = '" . $data['nombre'] . "'");
		if ($query->num_rows() < 1) {
			//NO ESTÁ EN LA BASE DE DATOS DE CANCIONES POR LO QUE LA AÑADIMOS PERO SIN VALIDAR
			$this->db->query("INSERT INTO bd_canciones VALUES ('','" . $data['artista'] . "', '" . $data['nombre'] . "', '" . $data['client_id'] . "', '" . date("Y-m-d") . "', 'N')");
			$query = $this->db->query("SELECT * FROM bd_canciones WHERE artista = '" . $data['artista'] . "' AND cancion = '" . $data['nombre'] . "'");
		}

		$fila = $query->row();
		$data['id_bd_canciones'] = $fila->id;


		$query = $this->db->query("SELECT * FROM momentos_espec WHERE id = " . $data['momento_id'] . "");
		$fila = $query->row();
		$data['nombre_momento'] = $fila->nombre;

		$query = $this->db->query("SELECT * FROM bd_momentos_espec WHERE momento = '" . $data['nombre_momento'] . "'");
		if ($query->num_rows() > 0) {
			$fila = $query->row();
			$data['id_bd_momento'] = $fila->id_momento;
		} else {
			$data['id_bd_momento'] = 'null';
		}


		$this->db->query("INSERT INTO canciones VALUES ('','" . $data['client_id'] . "', '" . $data['momento_id'] . "', " . $data['id_bd_momento'] . ", '" . $data['id_bd_canciones'] . "', '" . $data['orden'] . "')");
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
		if ($query->num_rows() > 0) {
			$i = 0;
			foreach ($query->result() as $fila) {
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
	
		// 1. Obtener ID del DJ asignado al cliente
		$nombre_dj = '';
		$foto_dj = '';
		$query_dj = $this->db->query("
			SELECT djs.nombre, djs.foto 
			FROM clientes 
			JOIN djs ON djs.id = clientes.dj 
			WHERE clientes.id = {$user_id}
		");
	
		if ($query_dj->num_rows() > 0) {
			$row_dj = $query_dj->row();
			$nombre_dj = $row_dj->nombre;
			$foto_dj = $row_dj->foto;
		}
	
		// 2. Obtener los mensajes del cliente
		$query = $this->db->query("
			SELECT id_mensaje, id_cliente, fecha, usuario, id_usuario, mensaje 
			FROM contacto 
			WHERE id_cliente = {$user_id}
			ORDER BY fecha ASC
		");
	
		if ($query->num_rows() > 0) {
			$data = [];
			foreach ($query->result() as $fila) {
				$item = [
					'id_mensaje' => $fila->id_mensaje,
					'id_cliente' => $fila->id_cliente,
					'fecha' => $fila->fecha,
					'usuario' => $fila->usuario,
					'id_usuario' => $fila->id_usuario,
					'mensaje' => $fila->mensaje
				];
	
				// 3. Asignar nombre del DJ si aplica
				if ($fila->usuario === 'dj') {
					$item['nombre_dj'] = $nombre_dj;
					$item['foto'] = $foto_dj;
				}
				// 4. Añadir foto según tipo de usuario
				elseif ($fila->usuario === 'cliente') {
					$q_foto = $this->db->query("SELECT foto FROM clientes WHERE id = {$fila->id_usuario}");
					$item['foto'] = $q_foto->num_rows() > 0 ? $q_foto->row()->foto : 'default_cliente.jpg';
				}
				elseif ($fila->usuario === 'administrador') {
					$item['foto'] = 'logo.jpg';
				}
	
				$data[] = $item;
			}
		}
	
		return $data;
	}

	public function GetTituloChat($id_cliente)
	{
		$this->load->database();
	
		$cliente = $this->db->query("
			SELECT dj
			FROM clientes
			WHERE id = $id_cliente
		")->row();
	
		$titulo = 'el Coordinador';
	
		if ($cliente) {	
			if ($cliente->dj) {
				$dj = $this->db->query("SELECT nombre FROM djs WHERE id = {$cliente->dj}")->row();
				if ($dj) {
					$titulo .= ' y DJ ' . $dj->nombre;
				}
			}
		}
	
		return $titulo;
	}
	

	function GetDjAsignado($user_id)
	{
		$data = false;
		$this->load->database();
		$query = $this->db->query("SELECT dj FROM clientes WHERE id = {$user_id}");
		$fila = $query->row();
		$dj = $fila->dj;
		//$query = $this->db->query("ALTER TABLE `clientes` ADD `descuento` DECIMAL NULL AFTER `servicios`;");
		if ($dj <> "") {
			$query = $this->db->query("SELECT id, nombre, email, telefono, foto FROM djs WHERE id = ({$dj})");
			if ($query->num_rows() > 0) {
				$i = 0;
				foreach ($query->result() as $fila) {
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
		$query = $this->db->query("SELECT clientes.email_novio, clientes.email_novia, clientes.clave, clientes.nombre_novio, clientes.apellidos_novio, clientes.direccion_novio, clientes.cp_novio, clientes.poblacion_novio, clientes.telefono_novio, clientes.nombre_novia, clientes.apellidos_novia, clientes.direccion_novia, clientes.cp_novia, clientes.poblacion_novia, clientes.telefono_novia, clientes.foto, clientes.fecha_boda, restaurantes.nombre AS restaurante, restaurantes.direccion, restaurantes.telefono, clientes.servicios, clientes.personas_contacto, DATE_FORMAT(clientes.fecha_boda, '%d-%m-%Y') as fecha_boda, DATE_FORMAT(clientes.fecha_boda, '%H:%i') as hora_boda, restaurantes.maitre, restaurantes.telefono_maitre, clientes.contrato_pdf, clientes.presupuesto_pdf, clientes.descuento FROM clientes INNER JOIN restaurantes ON clientes.id_restaurante=restaurantes.id_restaurante WHERE clientes.id = {$id}");

		if ($query->num_rows() > 0) {
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
			$data['direccion_restaurante'] = $fila->direccion;
			$data['telefono_restaurante'] = $fila->telefono;
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

		$query = $this->db->query("SELECT factura_pdf FROM facturas WHERE id_cliente = {$id}");
		if ($query->num_rows() > 0) {
			$fila = $query->row();
			$data['factura_pdf'] = $fila->factura_pdf;
		} else {
			$data['factura_pdf'] = "";
		}


		return $data;
	}
	public function GetServicios($ids)
	{
		if (empty($ids)) {
			log_message('error', '⚠️ ERROR en GetServicios(): No se recibieron IDs.');
			return [];
		}

		log_message('debug', 'Ejecutando consulta: SELECT id, nombre FROM servicios WHERE id IN (' . $ids . ')');

		$query = $this->db->query("SELECT id, nombre FROM servicios WHERE id IN ($ids) Order by orden ASC");

		if ($query->num_rows() == 0) {
			log_message('error', '⚠️ ERROR: La consulta a servicios no devolvió resultados.');
			return [];
		}

		return $query->result_array();
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
		$cabeceras .= 'From: ' . $mail_desde;
		//$send = mail("w-marek@hotmail", $asunto, $mensaje, $cabeceras);
		$this->sendEmail('info@exeleventos.com', ["w-marek@hotmail"], $asunto, $mensaje);
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
		$this->db->query("UPDATE clientes SET foto = '" . $foto . "' WHERE id = {$id}");
	}
	function GetAvailableServicios($user_id)
	{
		$data = [];
		$this->load->database();

		// Evitar inyección SQL asegurando que user_id es un número
		$query = $this->db->query("SELECT servicios FROM clientes WHERE id = ?", [$user_id]);

		if ($query->num_rows() > 0) {
			$fila = $query->row();

			// Verificar si el campo 'servicios' está serializado antes de unserialize()
			$arr_servicios = @unserialize($fila->servicios);
			if ($arr_servicios === false && $fila->servicios !== 'b:0;') {
				$arr_servicios = json_decode($fila->servicios, true);
			}

			// Verificar que sea un array válido antes de usar array_keys()
			$arr_serv_keys = is_array($arr_servicios) ? array_keys($arr_servicios) : [];

			// Construir la consulta evitando errores de SQL
			if (!empty($arr_serv_keys)) {
				$placeholders = implode(',', array_map('intval', $arr_serv_keys));
				$query = $this->db->query("SELECT id, nombre, precio, precio_oferta, mostrar, imagen FROM servicios 
					WHERE id NOT IN ($placeholders) ORDER BY orden ASC");
			} else {
				$query = $this->db->query("SELECT id, nombre, precio, precio_oferta, mostrar, imagen FROM servicios ORDER BY orden ASC");
			}
		} else {
			$query = $this->db->query("SELECT id, nombre, precio, precio_oferta, mostrar, imagen FROM servicios ORDER BY orden ASC");
		}

		// Procesar resultados
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $fila) {
				$data[] = [
					'id' => $fila->id,
					'nombre' => $fila->nombre,
					'precio' => $fila->precio,
					'precio_oferta' => $fila->precio_oferta,
					'mostrar' => $fila->mostrar,
					'imagen' => $fila->imagen
				];
			}
		}

		return $data;
	}

	function GetPagos($cliente_id)
	{
		$data = array();
		$this->load->database();
		$query = $this->db->query("SELECT valor, DATE_FORMAT(fecha, '%d-%m-%Y') as fechaa, fecha FROM pagos WHERE cliente_id = {$cliente_id} ORDER BY fecha ASC");
		if ($query->num_rows() > 0) {
			$i = 0;
			foreach ($query->result() as $fila) {
				$data[$i]['valor'] = $fila->valor;
				$data[$i]['fecha'] = $fila->fechaa;
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
		if ($query->num_rows() > 0) {
			$fila = $query->row();
			$orden = $fila->orden + 1;
		}

		$query = $this->db->query("INSERT INTO momentos_espec (nombre, cliente_id, orden) VALUES ('" . str_replace("'", "&#39;", $nombre) . "', {$cliente_id}, " . $orden . ")");
	}

	private function sendEmail($from, $to, $subject, $message)
	{
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
	private $client_id = '302d6d43dfb94ee6b305be0049e8e33a';
    private $client_secret = '18c0a19582dd40e08491e0a37f502c13';

    function __construct() {
        parent::__construct();
    }
	function get_token() {
		$auth = base64_encode($this->client_id . ':' . $this->client_secret);
	
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "https://accounts.spotify.com/api/token");
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials");
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			"Authorization: Basic $auth",
			"Content-Type: application/x-www-form-urlencoded"
		));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$res = curl_exec($ch);
	
		// Log de errores cURL
		if(curl_errno($ch)) {
			log_message('error', 'Error cURL al obtener el token: ' . curl_error($ch));
		}
	
		curl_close($ch);
	
		// Verificamos la respuesta
		if (!$res) {
			log_message('error', 'No se recibió respuesta al obtener el token.');
			return null;
		}
	
		// Decodificamos la respuesta
		$data = json_decode($res, true);
	
		// Log de la respuesta completa para ver qué se recibe
		log_message('debug', 'Respuesta al obtener el token: ' . print_r($data, true));
	
		if (isset($data['access_token'])) {
			return $data['access_token']; // Token obtenido correctamente
		} else {
			log_message('error', 'No se pudo obtener el access_token de Spotify.');
			return null;
		}
	}
	public function obtener_canciones()
{
    $data_header = false;
    $data_footer = false;

    // Verifica si el formulario fue enviado
    if ($this->input->post()) {
        $playlist_id = $this->input->post('playlist_id');
        
        if (!empty($playlist_id)) {
            // Llamamos a la función del modelo para obtener las canciones
            $this->load->model('Cliente_functions');
            $canciones = $this->Cliente_functions->obtener_canciones_playlist($playlist_id);

            // Verificamos si obtuvimos canciones
            if (!empty($canciones)) {
                // Si hay canciones, las pasamos a la vista
                $data['canciones'] = $canciones;
            } else {
                // Si no hay canciones, mostramos un mensaje
                $data['msg'] = "No se encontraron canciones para esta playlist.";
            }
        } else {
            $data['msg'] = "Por favor ingresa un ID de playlist válido.";
        }
    }

    // Cargamos la vista con los datos
    $this->load->view('cliente/header_en_blanco', $data_header);
    $this->load->view('cliente/playlist', $data);
    $this->load->view('cliente/footer', $data_footer);
}
	

}
