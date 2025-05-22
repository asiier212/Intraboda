<?php
class Dj_functions extends CI_Model
{

	function DjLogin($mail, $clave)
	{
		//$clave = md5($clave);
		$data = false;
		$this->load->database();
		$this->load->library('encrypt');
		$clave_sin_cifrar = "";
		//Busco la clave cifrada del dj
		$query2 = $this->db->query("SELECT clave FROM djs WHERE email  = '{$mail}'");
		if ($query2->num_rows() > 0) {
			$fila2 = $query2->row();
			$clave_cifrada = $fila2->clave;

			//Desencripto la clave cifrada para compararla con la que introduce el dj
			$clave_sin_cifrar = $this->encrypt->decode($clave_cifrada);
		}
		//Comparo las clave descifrada con la que introduce el dj
		if ($clave_sin_cifrar <> $clave) {
			//Si no coinciden me invento una clave error
			$clave = "ERROR";
		}

		//Sólo busco en la BD si la clave que ha introducido el dj es igual a la que hay en descifrada en la BD	
		if ($clave <> "ERROR") {
			$query = $this->db->query("SELECT id, email, nombre, foto FROM djs WHERE email  = '" . $mail . "'");
			if ($query->num_rows() > 0) {
				$fila = $query->row();
				$data['id'] = $fila->id;
				$data['nombre'] = $fila->nombre;
				$data['foto'] = $fila->foto;
				$data['email'] = $mail;
			}
		}

		return $data;
	}
	function InsertCliente($data)
	{

		$this->load->database();
		$data['servicios'] = implode(",", $data['servicios']);
		$data['personas_contacto'] = implode(",", $data['personas_contacto']);
		$data['fecha_boda'] = $data['fecha_boda'] . " " . $data['hora_boda'];
		unset($data['hora_boda']);
		$this->db->insert('clientes', $data);

		return $this->db->insert_id();
	}
	function GetClientes($str_where, $ord, $limit)
	{
		$data = false;
		$this->load->database();
		$query = $this->db->query("SELECT clientes.id, clientes.foto, clientes.nombre_novio, clientes.nombre_novia, restaurantes.nombre AS restaurante, DATE_FORMAT(clientes.fecha_boda, '%d-%m-%Y %H:%i') as fecha_boda_formateado, DATE_FORMAT(clientes.fecha, '%d-%m-%Y') as fecha_alta FROM clientes INNER JOIN restaurantes ON clientes.id_restaurante=restaurantes.id_restaurante {$str_where} ORDER BY {$ord}   {$limit}");

		if ($query->num_rows() > 0) {
			$i = 0;
			foreach ($query->result() as $fila) {
				$data[$i]['id'] = $fila->id;
				$data[$i]['foto'] = $fila->foto;
				$data[$i]['nombre_novio'] = $fila->nombre_novio;
				$data[$i]['nombre_novia'] = $fila->nombre_novia;
				$data[$i]['restaurante'] = $fila->restaurante;
				$data[$i]['fecha_boda'] = $fila->fecha_boda_formateado;
				$data[$i]['fecha_alta'] = $fila->fecha_alta;
				//$data[$i]['consulta'] = "SELECT id, foto, nombre_novio, nombre_novia, restaurante, DATE_FORMAT(fecha_boda, '%d-%m-%Y %H:%i') as fecha_boda, DATE_FORMAT(fecha, '%d-%m-%Y') as fecha_alta FROM clientes {$str_where} ORDER BY {$ord}   {$limit}";
				$i++;
			}
		}
		return $data;
	}
	function GetCliente($id)
	{
		$data = false;
		$this->load->database();
		$query = $this->db->query("SELECT clientes.email_novio, clientes.email_novia, clientes.clave, clientes.nombre_novio, clientes.apellidos_novio, clientes.direccion_novio, clientes.cp_novio, clientes.poblacion_novio, clientes.telefono_novio, clientes.nombre_novia, clientes.apellidos_novia, clientes.direccion_novia, clientes.cp_novia, clientes.poblacion_novia, clientes.telefono_novia, clientes.foto, clientes.fecha_boda, restaurantes.id_restaurante, restaurantes.nombre AS restaurante, restaurantes.direccion AS direccion_restaurante, restaurantes.telefono AS telefono_restaurante, clientes.servicios, clientes.personas_contacto, DATE_FORMAT(clientes.fecha_boda, '%d-%m-%Y') as fecha_boda, DATE_FORMAT(clientes.fecha_boda, '%H:%i') as hora_boda, restaurantes.maitre, restaurantes.telefono_maitre, clientes.contrato_pdf, clientes.presupuesto_pdf, clientes.descuento, clientes.observaciones, clientes.dj FROM clientes INNER JOIN restaurantes ON clientes.id_Restaurante=restaurantes.id_restaurante WHERE id = {$id}");

		if ($query->num_rows() > 0) {
			$fila = $query->row();
			$data['id'] = $id;
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
			$data['observaciones'] = $fila->observaciones;
			$data['dj'] = $fila->dj;

			$query2 = $this->db->query("SELECT archivo, descripcion FROM restaurantes_archivos WHERE id_restaurante = {$fila->id_restaurante}");
			if ($query2->num_rows() > 0) {
				$i = 0;
				foreach ($query2->result() as $fila2) {
					$data['restaurante_archivos'][$i]['archivo'] = $fila2->archivo;
					$data['restaurante_archivos'][$i]['descripcion'] = $fila2->descripcion;
					$i++;
				}
			}
		}


		return $data;
	}

	function GetHorasCliente($id)
	{
		$data = false;
		$this->load->database();
		$query = $this->db->query("SELECT id_hora_dj, id_cliente, concepto, horas_dj FROM horas_djs WHERE id_cliente = {$id}");

		if ($query->num_rows() > 0) {
			$i = 0;
			foreach ($query->result() as $fila) {
				$data[$i]['id_hora_dj'] = $fila->id_hora_dj;
				$data[$i]['id_cliente'] = $fila->id_cliente;
				$data[$i]['concepto'] = $fila->concepto;
				$data[$i]['horas_dj'] = $fila->horas_dj;
				$i++;
			}
		}


		return $data;
	}

	function UpdatefotoCliente($id, $foto)
	{

		$this->load->database();
		$this->db->query("UPDATE clientes SET foto = '" . $foto . "' WHERE id = {$id}");
	}

	function InsertServicio($data)
	{

		$this->load->database();
		$this->db->insert('servicios', $data);
		//$query = $this->db->query("INSERT INTO servicios (nombre, descripcion, precio) VALUES ('".str_replace("'", "&#39;",$data['nombre'])."', '".stripslashes(str_replace("'", "&#39;",$data['descripcion']))."', '".$data['precio']."')");	

	}
	function InsertEvent($nombre)
	{

		$this->load->database();
		$query = $this->db->query("INSERT INTO momentos_espec (nombre) VALUES ('" . str_replace("'", "&#39;", $nombre) . "')");
	}
	function DeleteEvent($id)
	{

		$this->load->database();
		$query = $this->db->query("DELETE FROM momentos_espec WHERE id = {$id}");
	}

	function GetDJ($id)
	{
		$data = false;
		$this->load->database();
		$this->load->library('encrypt');
		$query = $this->db->query("SELECT id, nombre, telefono, email, clave, foto FROM djs WHERE id = {$id}");
		if ($query->num_rows() > 0) {
			$i = 0;
			foreach ($query->result() as $fila) {
				$data[$i]['id'] = $fila->id;
				$data[$i]['nombre'] = $fila->nombre;
				$data[$i]['telefono'] = $fila->telefono;
				$data[$i]['email'] = $fila->email;
				$data[$i]['clave'] = $this->encrypt->decode($fila->clave);
				//$data[$i]['clave'] = $fila->clave;
				$data[$i]['foto'] = $fila->foto;
				$i++;
			}
		}
		return $data;
	}

	function GetDJContratos($id, $ano_contrato)
	{
		$data = false;
		$this->load->database();

		$query = $this->db->query("SELECT id_contrato, nombre_contrato, fecha_contrato, contrato_pdf FROM contratos_djs WHERE id_dj = {$id} AND fecha_contrato>='" . $ano_contrato . "-01-01' AND fecha_contrato<='" . $ano_contrato . "-12-31'");

		if ($query->num_rows() > 0) {
			$i = 0;
			foreach ($query->result() as $fila) {
				$data[$i]['id_contrato'] = $fila->id_contrato;
				$data[$i]['nombre_contrato'] = $fila->nombre_contrato;
				$data[$i]['fecha_contrato'] = $fila->fecha_contrato;
				$data[$i]['contrato_pdf'] = $fila->contrato_pdf;
				$data[$i]['ano_contrato'] = $ano_contrato;
				$i++;
			}
		} else {
			$data[0]['ano_contrato'] = $ano_contrato;
		}
		return $data;
	}

	function GetDJNominas($id, $ano_nomina)
	{
		$data = false;
		$this->load->database();
		$query = $this->db->query("SELECT id_nomina, nombre_nomina, fecha_nomina, nomina_pdf FROM nominas_djs WHERE id_dj = {$id} AND fecha_nomina>='" . $ano_nomina . "-01-01' AND fecha_nomina<='" . $ano_nomina . "-12-31'");
		if ($query->num_rows() > 0) {
			$i = 0;
			foreach ($query->result() as $fila) {
				$data[$i]['id_nomina'] = $fila->id_nomina;
				$data[$i]['nombre_nomina'] = $fila->nombre_nomina;
				$data[$i]['fecha_nomina'] = $fila->fecha_nomina;
				$data[$i]['nomina_pdf'] = $fila->nomina_pdf;
				$data[$i]['ano_nomina'] = $ano_nomina;
				$i++;
			}
		} else {
			$data[0]['ano_nomina'] = $ano_nomina;
		}
		return $data;
	}

	function GuardarRevisionesEquipo($id_cliente, $tipo_equipo, $revision_salida, $revision_fin, $revision_pabellon)
	{
		$this->load->database();

		$revision_salida_json = json_encode(array_values($revision_salida));
		$revision_fin_json = json_encode(array_values($revision_fin));
		$revision_pabellon_json = json_encode(array_values($revision_pabellon));


		$this->db->where('id_cliente', $id_cliente);
		$this->db->where('tipo_equipo', $tipo_equipo);
		$this->db->update('clientes_equipos', array(
			'revision_salida' => $revision_salida_json,
			'revision_findevento' => $revision_fin_json,
			'revision_pabellon' => $revision_pabellon_json,
		));
	}

	function GetRevisionesGuardadas($id_cliente)
	{
		$this->load->database();
		$query = $this->db->query("
			SELECT tipo_equipo, revision_salida, revision_findevento, revision_pabellon
			FROM clientes_equipos
			WHERE id_cliente = ?
		", array($id_cliente));

		$revisiones = [];

		foreach ($query->result_array() as $row) {
			$tipo = $row['tipo_equipo'];
			$revisiones[$tipo] = [
				'revision_salida' => json_decode($row['revision_salida'], true) ?: [],
				'revision_fin' => json_decode($row['revision_findevento'], true) ?: [],
				'revision_pabellon' => json_decode($row['revision_pabellon'], true) ?: [],
			];
		}

		return $revisiones;
	}

	function GetDetallesEquipoAsignado($id_cliente, $tipo_equipo)
	{
		$this->load->database();

		// Obtener info del grupo asignado
		$query = $this->db->query("
			SELECT ce.id_grupo, g.nombre_grupo, ce.fecha_asignacion
			FROM clientes_equipos ce
			JOIN grupos_equipos g ON ce.id_grupo = g.id_grupo
			WHERE ce.id_cliente = ? AND ce.tipo_equipo = ?
			LIMIT 1
		", array($id_cliente, $tipo_equipo));

		if ($query->num_rows() == 0) {
			return null;
		}

		$grupo = $query->row_array();

		// Obtener componentes
		$componentes_query = $this->db->query("
			SELECT c.id_componente, c.nombre_componente, c.n_registro, c.descripcion_componente, c.urls,
			(SELECT COUNT(*) FROM reparaciones_componentes r WHERE r.id_componente = c.id_componente) AS num_reparaciones
			FROM componentes c
			WHERE c.id_grupo = ?
		", array($grupo['id_grupo']));

		$componentes = array();
		foreach ($componentes_query->result_array() as $comp) {

			// Obtener reparaciones para este componente
			$rep_query = $this->db->query("
				SELECT reparacion, fecha_reparacion
				FROM reparaciones_componentes
				WHERE id_componente = ?
				ORDER BY fecha_reparacion DESC
			", array($comp['id_componente']));

			$comp['reparaciones'] = $rep_query->result_array();
			$componentes[] = $comp;
		}

		$grupo['componentes'] = $componentes;

		return $grupo;
	}

	function GetEquiposAsignados($id_cliente)
	{
		$this->load->database();

		// Obtener los equipos asignados
		$query = $this->db->query("
		SELECT ce.tipo_equipo, ce.id_grupo, g.nombre_grupo, g.borrado
		FROM clientes_equipos ce
		JOIN grupos_equipos g ON ce.id_grupo = g.id_grupo
		WHERE ce.id_cliente = ?
	", array($id_cliente));

		$asignados_raw = array();
		$max_num_equipo = 0;

		foreach ($query->result_array() as $row) {
			$tipo = $row['tipo_equipo'];
			$asignados_raw[$tipo] = $row;

			// Detectar el número de equipo (Ej: Equipo 5)
			if (preg_match('/Equipo (\d+)/', $tipo, $m)) {
				$max_num_equipo = max($max_num_equipo, intval($m[1]));
			}
		}

		// Construimos array completo incluyendo los vacíos
		$completo = array();
		$max_num_equipo = max($max_num_equipo, 3); // al menos 3

		for ($i = 1; $i <= $max_num_equipo; $i++) {
			$key = 'Equipo ' . $i;

			if ($i <= 3) {
				// Mostrar siempre Equipo 1, 2, 3
				$completo[$key] = isset($asignados_raw[$key]) ? $asignados_raw[$key] : null;
			} elseif (isset($asignados_raw[$key])) {
				// Solo mostrar Equipo 4+ si están asignados
				$completo[$key] = $asignados_raw[$key];
			}
		}


		return $completo;
	}

	function GetEquiposDisponibles($id_cliente)
	{
		$data = [];
		$this->load->database();
		$query = $this->db->query("SELECT id_grupo, nombre_grupo FROM grupos_equipos WHERE borrado = 0 ORDER BY nombre_grupo ASC");
		if ($query->num_rows() > 0) {
			$i = 0;
			foreach ($query->result() as $fila) {
				$data[$i]['id_grupo'] = $fila->id_grupo;
				$data[$i]['nombre_grupo'] = $fila->nombre_grupo;
				$i++;
			}
		}
		return $data;
	}


	function GetComponentes()
	{
		$data = false;
		$this->load->database();
		$query = $this->db->query("SELECT * FROM componentes ORDER BY n_registro ASC");
		if ($query->num_rows() > 0) {
			$i = 0;
			foreach ($query->result() as $fila) {
				$data[$i]['id_componente'] = $fila->id_componente;
				$data[$i]['nombre_componente'] = $fila->nombre_componente;
				$data[$i]['n_registro'] = $fila->n_registro;
				$data[$i]['descripcion_componente'] = $fila->descripcion_componente;
				$data[$i]['id_grupo'] = $fila->id_grupo;
				$i++;
			}
		}
		return $data;
	}

	function GetReparacionesTotales()
	{
		$data = false;
		$this->load->database();

		$query = $this->db->query("SELECT reparaciones_componentes.id_reparacion, componentes.id_componente, componentes.n_registro, componentes.nombre_componente, reparaciones_componentes.fecha_reparacion, reparaciones_componentes.reparacion FROM componentes inner join reparaciones_componentes on componentes.id_componente=reparaciones_componentes.id_componente");
		if ($query->num_rows() > 0) {
			$i = 0;
			foreach ($query->result() as $fila) {
				$data[$i]['id_reparacion'] = $fila->id_reparacion;
				$data[$i]['id_componente'] = $fila->id_componente;
				$data[$i]['n_registro'] = $fila->n_registro;
				$data[$i]['nombre_componente'] = $fila->nombre_componente;
				$data[$i]['fecha_reparacion'] = $fila->fecha_reparacion;
				$data[$i]['reparacion'] = $fila->reparacion;
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

	public function GetMensajesContacto($id)
	{
		$this->load->database();
		$data = [];

		$cliente = $this->db->query("
        SELECT CONCAT(nombre_novio, ' ', apellidos_novio, ' y ', nombre_novia, ' ', apellidos_novia) AS nombre_completo, foto, dj 
        FROM clientes 
        WHERE id = $id
    ")->row();
		$dj = $cliente && $cliente->dj ? $this->db->query("SELECT nombre, foto FROM djs WHERE id = $cliente->dj")->row() : null;

		$query = $this->db->query("
        SELECT c.*, 
            CONCAT(nombre_novio, ' ', apellidos_novio, ' y ', nombre_novia, ' ', apellidos_novia) AS nombre_completo, cl.foto, cl.dj 
        FROM contacto c 
        JOIN clientes cl ON cl.id = c.id_cliente 
        WHERE c.id_cliente = $id 
        ORDER BY c.fecha ASC
    ");

		foreach ($query->result() as $m) {
			$item = [
				'id_mensaje' => $m->id_mensaje,
				'id_cliente' => $m->id,
				'fecha' => $m->fecha,
				'usuario' => $m->usuario,
				'id_usuario' => $m->id_usuario,
				'mensaje' => $m->mensaje,
				'foto' => $m->foto_cliente,
				'dj' => $m->dj,
				'nombre_completo' => $m->nombre_completo,
			];

			if ($m->usuario === 'cliente') {
				$item['nombre'] = $cliente->nombre;
				$item['foto'] = $cliente->foto;
			} elseif ($m->usuario === 'dj' && $dj) {
				$item['nombre_dj'] = $dj->nombre;
				$item['foto'] = $dj->foto;
			} elseif ($m->usuario === 'administrador') {
				$item['nombre'] = 'Coordinador';
				$item['foto'] = 'logo.jpg';
			}

			$data[] = $item;
		}

		return $data;
	}

	public function GetTituloChat($id)
	{
		$this->load->database();

		$cliente = $this->db->query("
        SELECT nombre_novio, apellidos_novio, nombre_novia, apellidos_novia, dj
        FROM clientes
        WHERE id = $id
    ")->row();

		$titulo = '';

		if ($cliente) {
			$titulo = $cliente->nombre_novio . ', ' . $cliente->nombre_novia;

			if ($cliente->dj) {
				$dj = $this->db->query("SELECT nombre FROM djs WHERE id = {$cliente->dj}")->row();
				if ($dj) {
					$titulo .= ' y Coordinador';
				}
			}
		}

		return $titulo;
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





	function GetEvents()
	{
		$data = false;
		$this->load->database();
		$query = $this->db->query("SELECT id, nombre FROM momentos_espec");
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
	function GetServicio($id)
	{
		$data = false;
		$this->load->database();
		$query = $this->db->query("SELECT id, nombre, descripcion, precio, precio_oferta FROM servicios WHERE id = {$id}");
		if ($query->num_rows() > 0) {
			$fila = $query->row();
			$data['id'] = $fila->id;
			$data['nombre'] = $fila->nombre;
			$data['descripcion'] = $fila->descripcion;
			$data['precio'] = $fila->precio;
			$data['precio_oferta'] = $fila->precio_oferta;
		}
		return $data;
	}
	function GetObservaciones($id)
	{
		$data = false;
		$this->load->database();
		$query = $this->db->query("SELECT id, comentario, link, DATE_FORMAT(fecha, '%d-%m-%Y %H:%i') as fecha FROM observaciones WHERE id_cliente = {$id} ORDER BY id DESC");
		if ($query->num_rows() > 0) {
			$i = 0;
			foreach ($query->result() as $fila) {
				$data[$i]['id'] = $fila->id;
				$data[$i]['comentario'] = $fila->comentario;
				$data[$i]['link'] = $fila->link;
				$data[$i]['fecha'] = $fila->fecha;
				$i++;
			}
		}
		return $data;
	}
	function DeleteServicio($id)
	{
		$this->load->database();
		$query = $this->db->query("DELETE FROM servicios WHERE id = {$id}");
	}
	function UpdateServicio($data, $id)
	{
		$this->load->database();
		$query = $this->db->query("UPDATE servicios SET nombre = '" . str_replace("'", "&#39;", $data['nombre']) . "', precio = '" . $data['precio'] . "', precio_oferta = '" . $data['precio_oferta'] . "' WHERE id = {$id}");
	}
	function InsertPerson($data)
	{

		$this->load->database();
		$query = $this->db->query("INSERT INTO personas_contacto (nombre, telefono, email, tipo) VALUES ('" . str_replace("'", "&#39;", $data['nombre']) . "', '" . stripslashes(str_replace("'", "&#39;", $data['telefono'])) . "', '" . $data['email'] . "', '" . str_replace("'", "&#39;", $data['tipo']) . "')");
		return $this->db->insert_id();
	}
	function UpdatePerson($data)
	{

		$this->load->database();
		$query = $this->db->query("UPDATE personas_contacto SET nombre = '" . str_replace("'", "&#39;", $data['nombre']) . "', telefono = '" . stripslashes(str_replace("'", "&#39;", $data['telefono'])) . "', email = '" . $data['email'] . "', tipo = '" . str_replace("'", "&#39;", $data['tipo']) . "' WHERE id = " . $data['id'] . "");
	}
	function UpdatefotoPerson($id, $foto)
	{

		$this->load->database();
		$this->db->query("UPDATE personas_contacto SET foto = '" . $foto . "' WHERE id = {$id}");
	}
	function DeletePerson($id)
	{

		$this->load->database();
		$query = $this->db->query("SELECT foto FROM personas_contacto WHERE id = {$id}");
		$fila = $query->row();
		if ($fila->foto != "") {
			$foto = './uploads/personas_contacto/' . $fila->foto;
			echo $foto;
			if (file_exists($foto)) {
				unlink($foto);
			}
		}

		$this->db->query("DELETE FROM personas_contacto WHERE id = {$id}");
	}
	function GetPersonasContacto()
	{
		$data = false;
		$this->load->database();
		$query = $this->db->query("SELECT id, nombre, telefono, email, tipo, foto FROM personas_contacto");
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

	function GetPagos($cliente_id)
	{
		$data = array();
		$this->load->database();
		$query = $this->db->query("SELECT valor, DATE_FORMAT(fecha, '%d-%m-%Y') as fecha FROM pagos WHERE cliente_id = {$cliente_id} ");
		if ($query->num_rows() > 0) {
			$i = 0;
			foreach ($query->result() as $fila) {
				$data[$i]['valor'] = $fila->valor;
				$data[$i]['fecha'] = $fila->fecha;
				$i++;
			}
		}
		return $data;
	}


	public function getNotificaciones($dj)
	{
		return $this->db->query("
        SELECT nd.id, nd.id_cliente, nd.mensaje, nd.fecha, nd.leido
        FROM notificaciones_dj nd
		INNER JOIN clientes c ON c.id = nd.id_cliente
		WHERE c.dj = ?
        ORDER BY fecha DESC
    ", [$dj])->result();
	}

	public function getNotificacionesPorEstado($leido = null, $dj)
	{
		$this->load->database();

		if ($leido === null) {
			// Todas las notificaciones
			return $this->db->query("SELECT nd.id, nd.id_cliente, nd.mensaje, nd.fecha, nd.leido FROM notificaciones_dj nd INNER JOIN clientes c ON c.id = nd.id_cliente WHERE c.dj = ? ORDER BY fecha DESC", [$dj])->result();
		} else {
			// Filtrar por leído o no leído
			return $this->db->query("SELECT nd.id, nd.id_cliente, nd.mensaje, nd.fecha, nd.leido FROM notificaciones_dj nd INNER JOIN clientes c ON c.id = nd.id_cliente WHERE c.dj = ? AND leido = ? ORDER BY fecha DESC", [$dj, $leido])->result();
		}
	}

	public function marcarNotificacionLeida($id)
	{
		$this->load->database();
		return $this->db->query("UPDATE notificaciones_dj SET leido = 1 WHERE id = ?", array($id));
	}

	public function contar_todas($dj)
	{
		$this->load->database();
		$this->db->from('notificaciones_dj nd');
		$this->db->join('clientes c', 'c.id = nd.id_cliente');
		$this->db->where('c.dj', $dj);
		return $this->db->count_all_results();
	}

	public function contar_leidas($dj)
	{
		$this->load->database();
		$this->db->from('notificaciones_dj nd');
		$this->db->join('clientes c', 'c.id = nd.id_cliente');
		$this->db->where('c.dj', $dj);
		$this->db->where('nd.leido', 1);
		return $this->db->count_all_results();
	}

	public function contar_no_leidas($dj)
	{
		$this->load->database();
		$this->db->from('notificaciones_dj nd');
		$this->db->join('clientes c', 'c.id = nd.id_cliente');
		$this->db->where('c.dj', $dj);
		$this->db->where('nd.leido', 0);
		return $this->db->count_all_results();
	}

	function get_disponibilidad($dj_id)
	{
		$this->db->select('disponibilidad_dj.id, disponibilidad_dj.fecha, disponibilidad_dj.hora_inicio, disponibilidad_dj.hora_fin, disponibilidad_dj.validacion, djs.nombre');
		$this->db->from('disponibilidad_dj');
		$this->db->join('djs', 'disponibilidad_dj.dj_id = djs.id');
		$this->db->where('disponibilidad_dj.dj_id', $dj_id);
		return $this->db->get()->result_array();
	}

	function guardar($dj_id, $fecha, $hora_inicio, $hora_fin, $id = null)
	{

		// Verifica si hay solapamiento con otra franja del mismo DJ (excluyendo el propio ID si está editando)
		$this->db->where('dj_id', $dj_id);
		$this->db->where('fecha', $fecha);
		$this->db->where('hora_inicio <', $hora_fin);
		$this->db->where('hora_fin >', $hora_inicio);
		if ($id) {
			$this->db->where('id !=', $id);
		}
		$existe = $this->db->get('disponibilidad_dj')->row_array();

		if ($existe) {
			return json_encode(['status' => 'error', 'msg' => 'Franja horaria solapada']);
		}

		$mesaje = '';

		$this->db->select('nombre');
		$this->db->from('djs');
		$this->db->where('id', $dj_id);
		$query = $this->db->get();
		$dj = $query->row_array(); // o ->row() si prefieres objeto

		$nombre_dj = isset($dj['nombre']) ? $dj['nombre'] : '';

		// Inserta o actualiza
		if ($id) {
			$this->db->where('id', $id);
			$this->db->update('disponibilidad_dj', array(
				'dj_id' => $dj_id,
				'fecha' => $fecha,
				'hora_inicio' => $hora_inicio,
				'hora_fin' => $hora_fin,
				'validacion' => 1
			));

			$mensaje = "<strong>Petición de Ausencia editada de DJ $nombre_dj en $fecha de $hora_inicio a $hora_fin</strong><br></br><button onclick=\"window.location.href='" . base_url() . "admin/calendarioDisp'\" style='padding: 8px 24px; background-color:rgb(63, 114, 255); color: white; border: none; border-radius: 6px; font-weight: bold; cursor: pointer;'>Ver Calendario</button><br></br>";
		} else {
			$this->db->insert('disponibilidad_dj', array(
				'dj_id' => $dj_id,
				'fecha' => $fecha,
				'hora_inicio' => $hora_inicio,
				'hora_fin' => $hora_fin,
				'validacion' => 1
			));

			$mensaje = "<strong>Nueva petición de Ausencia de DJ $nombre_dj en $fecha de $hora_inicio a $hora_fin </strong><br></br><button onclick=\"window.location.href='" . base_url() . "admin/calendarioDisp'\" style='padding: 8px 24px; background-color:rgb(63, 114, 255); color: white; border: none; border-radius: 6px; font-weight: bold; cursor: pointer;'>Ver Calendario</button><br></br>";
		}

		// NOTIFICACIONES PARA ADMIN

		if ($dj_id) {

			$data_notif = array(
				'id_cliente' => 1,
				'mensaje' => $mensaje,
				'fecha' => date('Y-m-d H:i:s'),
				'leido' => 0
			);

			$this->db->insert('notificaciones_admin', $data_notif);
		}
		//--------------

		return json_encode(['status' => 'ok']);
	}


	function eliminar($id)
	{
		$this->db->delete('disponibilidad_dj', array('id' => $id));
	}
}
