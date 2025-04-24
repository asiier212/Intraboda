<?php
if (! defined('BASEPATH')) exit('No direct script access allowed');
class Ajax extends CI_Controller
{

	public function ordenarEquipos()
	{
		$this->load->database();
		$this->load->model('admin_functions');
	
		$orden = $this->input->post('orden');
	
		if (is_array($orden)) {
			foreach ($orden as $pos => $id_grupo) {
				$this->admin_functions->ActualizarOrdenEquipo($id_grupo, $pos + 1);
			}
			echo "ok";
		} else {
			http_response_code(400);
			echo "Parámetro 'orden' inválido";
		}
	}
	
	
	

	function updateordencanciones()
	{
		if ($_POST) {
			$order = str_replace('c_', '', $_POST['order']);
			$arr = explode(',', $order);
			$this->load->database();

			$query = $this->db->query("SELECT id FROM canciones WHERE id IN ({$order}) ORDER BY FIELD( id, {$order} )");

			if ($query->num_rows() > 0) {
				$i = 1;
				foreach ($query->result() as $fila) {
					$q[] = "UPDATE canciones SET orden = {$i} WHERE id = " . $fila->id . "";
					$i++;
				}
			}
			foreach ($q as $r) {
				$this->db->query($r);
			}
		}
	}

	function updateordenmomentos()
	{
		if ($_POST) {
			log_message('debug', 'Horas recibidas: ' . print_r($_POST['horas'], true));
			$order = str_replace('mom_', '', $_POST['order']);
			$arr = explode(',', $order);
			$horas = isset($_POST['horas']) ? $_POST['horas'] : [];

			$this->load->database();

			$query = $this->db->query("SELECT id FROM momentos_espec WHERE id IN ({$order}) ORDER BY FIELD(id, {$order})");

			if ($query->num_rows() > 0) {
				$i = 1;
				foreach ($query->result() as $fila) {
					$id_momento = $fila->id;

					// Si existe hora para este momento, escapamos el valor, si no, lo dejamos como NULL
					$hora = isset($horas[$id_momento]) ? $this->db->escape($horas[$id_momento]) : 'NULL';

					// Actualizar orden + hora
					$q[] = "UPDATE momentos_espec SET orden = {$i}, hora = {$hora} WHERE id = {$id_momento}";
					$i++;
				}
			}

			if (!empty($q)) {
				foreach ($q as $r) {
					$this->db->query($r);
					if ($this->db->affected_rows() === 0) {
						log_message('error', "No se actualizó nada con: $r");
					}
				}
			}
		}
	}


	function actualizarestaurantecliente()
	{
		$data = array();

		if ($_POST) {
			$this->load->database();
			$this->db->query("UPDATE clientes SET id_restaurante = '" . $_POST['id_restaurante'] . "' WHERE id = '" . $_POST['id_cliente'] . "'");

			$query = $this->db->query("SELECT * FROM restaurantes WHERE id_restaurante='" . $_POST['id_restaurante'] . "'");
			foreach ($query->result() as $fila) {
				$data['nombre'] = $fila->nombre;
				$data['direccion'] = $fila->direccion;
				$data['telefono'] = $fila->telefono;
				$data['maitre'] = $fila->maitre;
				$data['telefono_maitre'] = $fila->telefono_maitre;
				$i = 0;
				$query2 = $this->db->query("SELECT * FROM restaurantes_archivos WHERE id_restaurante='" . $_POST['id_restaurante'] . "'");
				foreach ($query2->result() as $fila2) {
					$data['archivos'][$i]['descripcion'] = $fila2->descripcion;
					$data['archivos'][$i]['archivo'] = $fila2->archivo;
					$i++;
				}
			}

			echo json_encode($data);
		}
	}

	public function update_observacion_ocultar()
	{
		$this->load->database();

		$id = intval($this->input->post('id'));
		$ocultar = $this->input->post('ocultar') == '1' ? 1 : 0;

		$this->db->where('id', $id);
		$this->db->update('observaciones', array('ocultar' => $ocultar));

		echo 'ok';
	}


	public function updateinvitado()
	{
		$this->load->library('encrypt');
		$this->load->database();

		if (!isset($_POST['id']) || !isset($_POST['value'])) {
			http_response_code(400);
			echo "Datos incompletos.";
			return;
		}

		$element_id = $_POST['id']; // Ej: email_5
		$nuevo_valor = trim($_POST['value']);

		if (strpos($element_id, "_") === false) {
			http_response_code(400);
			echo "Formato incorrecto de ID.";
			return;
		}

		list($campo, $id) = explode("_", $element_id);
		if (!is_numeric($id)) {
			http_response_code(400);
			echo "ID inválido.";
			return;
		}

		// Obtener id_cliente del invitado actual
		$consulta = $this->db->get_where('invitado', array('id' => $id));
		if ($consulta->num_rows() == 0) {
			http_response_code(404);
			echo "Invitado no encontrado.";
			return;
		}
		$invitado = $consulta->row();
		$id_cliente = $invitado->id_cliente;

		// Validación de email duplicado para el mismo cliente
		if ($campo == 'email') {
			$this->db->where('email', $nuevo_valor);
			$this->db->where('id_cliente', $id_cliente);
			$this->db->where('id !=', $id); // excluir el actual
			$existe = $this->db->get('invitado')->num_rows();
			if ($existe > 0) {
				http_response_code(409);
				echo "Este email ya está en uso por otro invitado de este cliente.";
				return;
			}
		}

		if ($campo == 'clave') {
			if ($nuevo_valor === '') {
				http_response_code(400);
				echo "La clave no puede estar vacía.";
				return;
			}
			$nuevo_valor = $this->encrypt->encode($nuevo_valor);
		}

		if ($campo == 'expira') {
			$fecha = DateTime::createFromFormat('d/m/Y', $nuevo_valor);
			if (!$fecha || $fecha->format('d/m/Y') !== $nuevo_valor) {
				http_response_code(400);
				echo "Formato de fecha inválido. Usa dd/mm/yyyy.";
				return;
			}
			$nuevo_valor = $fecha->format('Y-m-d');
			$campo = 'fecha_expiracion'; // Mapear a nombre real
		}

		$this->db->where('id', $id);
		$exito = $this->db->update('invitado', array($campo => $nuevo_valor));

		if (!$exito) {
			http_response_code(500);
			echo "Error al actualizar la base de datos.";
			return;
		}

		if ($campo == 'clave') {
			echo $this->encrypt->decode($nuevo_valor);
		} elseif ($campo == 'fecha_expiracion') {
			echo $fecha->format('d/m/Y');
		} else {
			echo $nuevo_valor;
		}
	}




	function buscarartista($nombre)
	{
		$this->load->database();
		$nombre = urldecode($nombre);
		echo json_encode($this->db->query("SELECT DISTINCT(artista) FROM bd_canciones WHERE artista LIKE '%" . $nombre . "%' AND validada='S'")->result());
	}

	function buscarcanciones($titulo, $artista)
	{
		$this->load->database();
		//$this->db->like('cancion',$titulo);
		//$this->db->like('artista',$artista);
		//echo json_encode( $this->db->get('bd_canciones')->result() );
		$titulo = urldecode($titulo);
		$artista = urldecode($artista);
		echo json_encode($this->db->query("SELECT * FROM bd_canciones WHERE artista = '" . $artista . "' AND cancion LIKE '%" . $titulo . "%' AND validada='S'")->result());
	}

	function buscarcuentasbancarias()
	{
		$this->load->database();
		echo json_encode($this->db->query("SELECT * FROM cuentas_bancarias")->result());
	}

	function buscarpartidaspresupuestarias($ano)
	{
		$this->load->database();
		$ano = urldecode($ano);
		echo json_encode($this->db->query("SELECT * FROM partidas_presupuestarias WHERE ano = '" . $ano . "'")->result());
	}

	function buscardatosequipo($id_grupo)
	{
		$this->load->database();
		echo json_encode($this->db->query("SELECT * FROM grupos_equipos WHERE id_grupo = '" . $id_grupo . "'")->result());
	}
	function buscardatoscomponente($id_componente)
	{
		$this->load->database();
		echo json_encode($this->db->query("SELECT * FROM componentes WHERE id_componente = '" . $id_componente . "'")->result());
	}


	function updatebdartista()
	{
		if ($_POST) {
			$this->load->database();

			// Obtener el valor original antes de actualizar
			$queryOriginal = $this->db->query("SELECT artista, cancion FROM bd_canciones WHERE id = ?", array($_POST['id']));
			$fila = $queryOriginal->row();
			$artista_original = $fila->artista;
			$cancion_original = $fila->cancion;

			// Verificar si ya existe un cambio registrado para esta canción
			$queryCheck = $this->db->query("SELECT id, artista_original, cancion_original, cancion_nueva FROM bd_cambios_canciones WHERE id_cancion = ?", array($_POST['id']));

			if ($queryCheck->num_rows() > 0) {
				$cambio = $queryCheck->row();
				$artista_original = is_null($cambio->artista_original) ? $artista_original : $cambio->artista_original;
				$cancion_original = $cambio->cancion_original ?: $cancion_original; // Mantener la canción original si existe
				$cancion_nueva = $cambio->cancion_nueva ?: $cancion_original;

				// Actualizamos solo el artista nuevo, manteniendo los valores de la canción
				$this->db->query(
					"UPDATE bd_cambios_canciones SET artista_original = ?, artista_nuevo = ?, cancion_original = ?, cancion_nueva = ? WHERE id_cancion = ?",
					array($artista_original, $_POST['value'], $cancion_original, $cancion_nueva, $_POST['id'])
				);
			} else {
				// Si no existe, insertamos un nuevo registro con los valores originales
				$this->db->query(
					"INSERT INTO bd_cambios_canciones (id_cancion, artista_original, artista_nuevo, cancion_original, cancion_nueva) VALUES (?, ?, ?, ?, ?)",
					array($_POST['id'], $artista_original, $_POST['value'], $cancion_original, $cancion_original)
				);
			}

			// Actualizar la BD con el nuevo artista
			$this->db->query("UPDATE bd_canciones SET artista = ? WHERE id = ?", array($_POST['value'], $_POST['id']));
			echo $_POST['value'];
		}
	}

	function updatebdcancion()
	{
		if ($_POST) {
			$this->load->database();

			// Obtener el valor original antes de actualizar
			$queryOriginal = $this->db->query("SELECT cancion, artista FROM bd_canciones WHERE id = ?", array($_POST['id']));
			$fila = $queryOriginal->row();
			$cancion_original = $fila->cancion;
			$artista_original = $fila->artista;

			// Verificar si ya existe un cambio registrado para esta canción
			$queryCheck = $this->db->query("SELECT id, cancion_original, artista_original, artista_nuevo FROM bd_cambios_canciones WHERE id_cancion = ?", array($_POST['id']));

			if ($queryCheck->num_rows() > 0) {
				$cambio = $queryCheck->row();
				$cancion_original = is_null($cambio->cancion_original) ? $cancion_original : $cambio->cancion_original;
				$artista_original = $cambio->artista_original ?: $artista_original; // Mantener el artista original si existe
				$artista_nuevo = $cambio->artista_nuevo ?: $artista_original;

				// Actualizamos solo la canción nueva, manteniendo los valores del artista
				$this->db->query(
					"UPDATE bd_cambios_canciones SET cancion_original = ?, cancion_nueva = ?, artista_original = ?, artista_nuevo = ? WHERE id_cancion = ?",
					array($cancion_original, $_POST['value'], $artista_original, $artista_nuevo, $_POST['id'])
				);
			} else {
				// Si no existe, insertamos un nuevo registro con los valores originales
				$this->db->query(
					"INSERT INTO bd_cambios_canciones (id_cancion, cancion_original, cancion_nueva, artista_original, artista_nuevo) VALUES (?, ?, ?, ?, ?)",
					array($_POST['id'], $cancion_original, $_POST['value'], $artista_original, $artista_original)
				);
			}

			// Actualizar la BD con la nueva canción
			$this->db->query("UPDATE bd_canciones SET cancion = ? WHERE id = ?", array($_POST['value'], $_POST['id']));
			echo $_POST['value'];
		}
	}




	function validarbdcancion()
	{
		if ($_POST) {
			$this->load->database();

			$id_cancion = intval($_POST['id']);

			// Obtener los datos de la canción antes de validar
			$query = $this->db->query("SELECT id_cliente, artista, cancion FROM bd_canciones WHERE id = ?", array($id_cancion));
			$fila = $query->row();

			if (!$fila) {
				log_message('error', "No se encontró la canción con ID: $id_cancion");
				echo json_encode(['status' => 'error', 'message' => 'Canción no encontrada']);
				exit();
			}

			$id_cliente = $fila->id_cliente;

			// Buscar si ya existe una canción exactamente igual (artista y canción)
			$query2 = $this->db->query("SELECT id FROM bd_canciones WHERE artista = ? AND cancion = ? AND id <> ?", array($fila->artista, $fila->cancion, $id_cancion));

			if ($query2->num_rows() > 0) {
				$fila2 = $query2->row();
				$id_bd_canciones = $fila2->id;

				// Borrar la canción duplicada
				$this->db->query("DELETE FROM bd_canciones WHERE id = ?", array($id_cancion));

				// Actualizar referencias de clientes a la canción validada
				$this->db->query("UPDATE canciones SET id_bd_canciones = ? WHERE id_bd_canciones = ?", array($id_bd_canciones, $id_cancion));

				// Obtener cambios de la tabla temporal
				$query = $this->db->query("SELECT artista_original, cancion_original, artista_nuevo, cancion_nueva FROM bd_cambios_canciones WHERE id_cancion = ?", array($id_cancion));
				$fila = $query->row();

				if ($fila) {
					// Enviar el aviso de modificación
					$this->enviarAvisoModificacion(
						$id_cliente,
						$fila->cancion_original ?: '',
						$fila->artista_original ?: '',
						$fila->cancion_nueva ?: '',
						$fila->artista_nuevo ?: ''
					);

					// Borrar el registro de cambios después de enviar el email
					$this->db->query("DELETE FROM bd_cambios_canciones WHERE id_cancion = ?", array($id_cancion));
				}
			} else {
				// Si no hay duplicados, simplemente validamos la canción
				$this->db->query("UPDATE bd_canciones SET validada = 'S' WHERE id = ?", array($id_cancion));
			}

			echo json_encode(['status' => 'success']);
			exit();
		}
	}



	function enviarAvisoModificacion($id_cliente, $cancion_original, $artista_original, $cancion_nueva, $artista_nuevo)
	{
		$this->load->database();

		$query_email = $this->db->query("SELECT email_novio, email_novia FROM clientes WHERE id = ?", array($id_cliente));
		$email_cliente = $query_email->row();

		if (!$email_cliente) {
			return;
		}

		$emails = array_filter([$email_cliente->email_novio, $email_cliente->email_novia]);
		if (empty($emails)) {
			return;
		}

		$subject = "Corrección en tu registro de música";
		$message = "<div style='font-family: Arial, sans-serif; color: #333; max-width: 600px; margin: auto; padding: 20px; border: 1px solid #ddd; border-radius: 5px;'>
		<h2 style='color: #568F23;'>Corrección en tu canción</h2>
		<p style='font-size: 16px;'>Buenas,</p>
		<p style='font-size: 16px;'>Una de tus canciones ha sido corregida.</p>
		<p style='font-size: 16px; background-color: #f8f8f8; padding: 10px; border-left: 4px solid #568F23;'>
			La canción <strong>\"{$cancion_original}\"</strong> de <strong>\"{$artista_original}\"</strong> ha sido modificada por
			<strong>\"{$cancion_nueva}\"</strong> de <strong>\"{$artista_nuevo}\"</strong>.
		</p>
		<p style='font-size: 16px;'>Si tienes alguna duda, por favor, ponte en contacto con nosotros.</p>
		<p style='font-size: 16px;'>Un saludo,</p>
		<p style='font-size: 18px; font-weight: bold; color: #568F23;'>Exel Eventos</p>
	</div>";

		$this->sendEmail('info@exeleventos.com', $emails, $subject, $message);
	}


	function deletebdcancion()
	{
		if ($_POST) {
			$this->load->database();
			$this->db->query("DELETE FROM bd_canciones WHERE id = " . $_POST['id'] . "");
			//Borramos también las canciones de los clientes que la hayan escogido
			$this->db->query("DELETE FROM canciones WHERE id_bd_canciones = " . $_POST['id'] . "");
			//borramos tambien si existe las modificaciones de la tabla bd_cambios_canciones
			$this->db->query("DELETE FROM bd_cambios_canciones WHERE id_cancion = " . $_POST['id'] . "");
		}
	}


	function buscarrestaurante()
	{
		$data = array();

		if ($_POST && isset($_POST['id_restaurante']) && !empty($_POST['id_restaurante'])) {
			$this->load->database();

			// Evitar SQL Injection manualmente
			$id_restaurante = (int) $_POST['id_restaurante']; // Convertir a entero si aplica
			$query = $this->db->query("SELECT * FROM restaurantes WHERE id_restaurante = '$id_restaurante'");
			$restaurante = $query->row(); // Tomar solo una fila

			if ($restaurante) {
				// Asignamos los datos del restaurante
				$data['nombre'] = $restaurante->nombre;
				$data['direccion'] = $restaurante->direccion;
				$data['telefono'] = $restaurante->telefono;
				$data['maitre'] = $restaurante->maitre;
				$data['telefono_maitre'] = $restaurante->telefono_maitre;

				// Obtener archivos del restaurante
				$query2 = $this->db->query("SELECT * FROM restaurantes_archivos WHERE id_restaurante = '$id_restaurante'");
				$data['archivos'] = array();

				foreach ($query2->result() as $fila2) {
					$data['archivos'][] = array(
						'descripcion' => $fila2->descripcion,
						'archivo' => $fila2->archivo
					);
				}
			} else {
				// En caso de no encontrar restaurante
				$data['error'] = "No se encontró el restaurante.";
			}
		} else {
			$data['error'] = "ID de restaurante no proporcionado.";
		}

		// Enviar respuesta JSON
		header('Content-Type: application/json');
		echo json_encode($data);
	}

	/*function buscarrestaurante($nombre)
{
	$this->load->database();
	//$this->db->like('cancion',$titulo);
	//$this->db->like('artista',$artista);
	//echo json_encode( $this->db->get('bd_canciones')->result() );
	$nombre=urldecode($nombre);
	echo json_encode ( $this->db->query("SELECT * FROM restaurantes WHERE nombre LIKE '%".$nombre."%'")->result() );
	
}

function buscarrestaurantearchivos($nombre)
{
	$this->load->database();
	//$this->db->like('cancion',$titulo);
	//$this->db->like('artista',$artista);
	//echo json_encode( $this->db->get('bd_canciones')->result() );
	$nombre=urldecode($nombre);
	echo json_encode ( $this->db->query("SELECT restaurantes.id_restaurante, restaurantes.nombre, restaurantes.direccion, restaurantes.telefono, restaurantes.maitre, restaurantes.telefono_maitre, restaurantes.otro_personal, restaurantes.hora_limite_fiesta, restaurantes.empresa_habitual, restaurantes_archivos.archivo, restaurantes_archivos.descripcion FROM restaurantes left join restaurantes_archivos on restaurantes.id_restaurante=restaurantes_archivos.id_restaurante WHERE restaurantes.nombre LIKE '%".$nombre."%'")->result() );
	
}*/

	function updateobservaciones()
	{
		if ($_POST) {
			$this->load->database();
			$_POST['value'] = str_replace("'", "&#39;", $_POST['value']);
			$this->db->query("UPDATE canciones_observaciones SET comentario = '" . $_POST['value'] . "' WHERE id = " . $_POST['id'] . "");
			echo $_POST['value'];
		}
	}
	function deletemomento()
	{
		if ($_POST) {
			$this->load->database();
			$this->db->query("DELETE FROM canciones WHERE momento_id = " . $_POST['id'] . "");
			$this->db->query("DELETE FROM momentos_espec WHERE id = " . $_POST['id'] . "");
		}
	}
	function deletecancion()
	{
		if ($_POST) {
			$this->load->database();
			$this->db->query("DELETE FROM canciones WHERE id = " . $_POST['id'] . "");
		}
	}
	function deletemensajechat()
	{
		if ($_POST) {
			$this->load->database();
			$this->db->query("DELETE FROM contacto WHERE id_mensaje = " . $_POST['id'] . "");
		}
	}
	function deletecuentabancaria()
	{
		if ($_POST) {
			$this->load->database();
			$this->db->query("DELETE FROM cuentas_bancarias WHERE id_cuenta = " . $_POST['id'] . "");
		}
	}

	function deletecanalcaptacion()
	{
		if ($_POST) {
			$this->load->database();
			$this->db->query("DELETE FROM canales_captacion WHERE id = " . $_POST['id'] . "");
		}
	}
	function deletemomentoespecial()
	{
		if ($_POST) {
			$this->load->database();
			$query = $this->db->query("SELECT momento FROM bd_momentos_espec WHERE id_momento = " . $_POST['id'] . "");
			$fila = $query->row();
			$nombre_momento = $fila->momento;

			//Borramos todos la tabla momentos_espec todos los momentos de los clientes que contienen ese momento especial, así como sus canciones
			$query = $this->db->query("SELECT id FROM momentos_espec WHERE nombre = '" . $nombre_momento . "'");
			foreach ($query->result() as $fila) {
				$this->db->query("DELETE FROM canciones WHERE momento_id = '" . $fila->id . "'");
				$this->db->query("DELETE FROM canciones_observaciones WHERE momento_id = '" . $fila->id . "'");
			}
			$this->db->query("DELETE FROM momentos_espec WHERE nombre = '" . $nombre_momento . "'");

			//Borramos de la bd_momentos_espec
			$this->db->query("DELETE FROM bd_momentos_espec WHERE id_momento = '" . $_POST['id'] . "'");
		}
	}

	function deleteevento()
	{
		if ($_POST) {
			$this->load->database();
			$this->db->query("DELETE FROM eventos WHERE id_evento = " . $_POST['id'] . "");
		}
	}

	function deletedescuento()
	{
		if ($_POST) {
			$this->load->database();
			$this->db->query("DELETE FROM descuento_presupuesto_eventos WHERE id_descuento = " . $_POST['id'] . "");
		}
	}

	function deleteestadosolicitud()
	{
		if ($_POST) {
			$this->load->database();
			$this->db->query("DELETE FROM estados_solicitudes WHERE id_estado = " . $_POST['id'] . "");
		}
	}

	function deletetipocliente()
	{
		if ($_POST) {
			$this->load->database();
			$this->db->query("DELETE FROM tipos_clientes WHERE id_tipo_cliente = " . $_POST['id'] . "");
			//Actualizamos a tipo cliente estándar los clientes del tipo borrado
			$this->db->query("UPDATE clientes SET id_tipo_cliente='1' WHERE id_tipo_cliente = " . $_POST['id'] . "");
		}
	}

	function deleteobservacion()
	{
		if ($_POST) {
			$this->load->database();
			$this->db->query("DELETE FROM canciones_observaciones WHERE id = " . $_POST['id'] . "");
		}
	}


	function deleteasociacioncomponenteequipo()
	{
		if ($_POST) {
			$this->load->database();
			$id_componente = intval($_POST['id']);
	
			// Eliminar asociación actual
			$this->db->query("UPDATE componentes SET id_grupo = NULL WHERE id_componente = " . $id_componente);
	
			// Cerrar historial activo
			$this->db->query("UPDATE historial_componentes_grupos SET fecha_desasignacion = NOW() WHERE id_componente = $id_componente AND fecha_desasignacion IS NULL");
		}
	}
	
	function deleteequipo()
	{
		if ($_POST) {
			$this->load->database();

			$id_grupo = intval($_POST['id']);

			// Desasociar componentes
			$this->db->query("UPDATE componentes SET id_grupo = NULL WHERE id_grupo = " . $id_grupo);

			// Marcar el equipo como borrado
			$this->db->query("UPDATE grupos_equipos SET borrado = 1 WHERE id_grupo = " . $id_grupo);

			// Cerrar historial activo
			$this->db->query("UPDATE historial_componentes_grupos SET fecha_desasignacion = NOW() WHERE id_grupo = $id_grupo AND fecha_desasignacion IS NULL");

			echo 'ok';
			exit;
		}
	}

	function deletecomponente()
	{
		if ($_POST) {
			$this->load->database();
	
			$id_componente = intval($_POST['id']); // Sanitiza por seguridad
	
			// 1. Borrar historial primero
			$this->db->where('id_componente', $id_componente);
			$this->db->delete('historial_componentes_grupos');
	
			// 2. Borrar componente
			$this->db->where('id_componente', $id_componente);
			$this->db->delete('componentes');
		}
	}
	
	function deletereparacioncomponente()
	{
		if ($_POST) {
			$this->load->database();
			$this->db->query("DELETE FROM reparaciones_componentes WHERE id_reparacion = " . $_POST['id'] . "");
		}
	}

	function deletecontratodj()
	{
		if ($_POST) {
			$this->load->database();
			$query = $this->db->query("SELECT contrato_pdf FROM contratos_djs WHERE id_contrato = " . $_POST['id'] . "");
			foreach ($query->result() as $fila) {
				$contrato = './uploads/contratos_djs/' . $fila->contrato_pdf;
				//echo $contrato ;
				if (file_exists($contrato)) {
					unlink($contrato);
				}
			}

			$this->db->query("DELETE FROM contratos_djs WHERE id_contrato = " . $_POST['id'] . "");
		}
	}

	function deletenominadj()
	{
		if ($_POST) {
			$this->load->database();
			$query = $this->db->query("SELECT nomina_pdf FROM nominas_djs WHERE id_nomina = " . $_POST['id'] . "");
			foreach ($query->result() as $fila) {
				$nomina = './uploads/nominas_djs/' . $fila->nomina_pdf;
				//echo $contrato ;
				if (file_exists($nomina)) {
					unlink($nomina);
				}
			}

			$this->db->query("DELETE FROM nominas_djs WHERE id_nomina = " . $_POST['id'] . "");
		}
	}

	function deletepago()
	{
		if ($_POST) {
			$this->load->database();
			$this->db->query("DELETE FROM pagos WHERE cliente_id = " . $_POST['id'] . " AND valor = '" . $_POST['valor'] . "' AND fecha =' " . $_POST['fecha'] . "'");
		}
	}

	function elimina_horas_dj()
	{
		if ($_POST) {
			$this->load->database();
			$this->db->query("DELETE FROM horas_djs WHERE id_hora_dj = " . $_POST['id'] . "");
		}
	}

	function deleteobservacion_admin()
	{
		if ($_POST) {
			$this->load->database();
			$this->db->query("DELETE FROM observaciones WHERE id = " . $_POST['id'] . "");
		}
	}

	function updatedatorestaurante($id = false)
	{
		if ($_POST) {
			$this->load->database();
			$this->load->library('encrypt');

			if ($_POST['id'] == 'nombre') {
				// Consultamos el nombre viejo
				$query = $this->db->query("SELECT nombre FROM restaurantes WHERE id_restaurante = {$id}");
				foreach ($query->result() as $fila) {
					$nombre_viejo = $fila->nombre;
				}

				// Actualizamos tablas relacionadas
				$this->db->query("UPDATE presupuesto_eventos SET restaurante = '" . str_replace("'", "&#39;", $_POST['value']) . "' WHERE restaurante = '" . $nombre_viejo . "'");
				$this->db->query("UPDATE solicitudes SET restaurante = '" . str_replace("'", "&#39;", $_POST['value']) . "' WHERE restaurante = '" . $nombre_viejo . "'");
			}

			$campo = $_POST['id'];
			$valor = str_replace("'", "&#39;", $_POST['value']);

			// Encriptar si el campo es clave
			if ($campo === 'clave') {
				$valor = $this->encrypt->encode($valor);
			}

			$this->db->query("UPDATE restaurantes SET {$campo} = '{$valor}' WHERE id_restaurante = {$id}");
			echo $_POST['value']; // devuelve la versión "plana", no encriptada
		}
	}


	function elimina_archivo_restaurante()
	{
		if ($_POST) {
			$this->load->database();
			$query = $this->db->query("SELECT archivo FROM restaurantes_archivos WHERE id_adjunto = " . $_POST['id_adjunto'] . "");
			foreach ($query->result() as $fila) {
				$archivo = './uploads/restaurantes/' . $fila->archivo;
				if (file_exists($archivo)) {
					unlink($archivo);
				}
			}

			$this->db->query("DELETE FROM restaurantes_archivos WHERE id_adjunto = " . $_POST['id_adjunto'] . "");
		}
	}

	function updatedatocliente($id = false)
	{

		if ($_POST) {

			$this->load->database();
			$id_cliente = "";
			$result = $_POST['value'];

			if ($id) {
				//admin       CAGADAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA

				$id_cliente = $id;
			} else {
				//cliente
				$this->load->library('session');
				$id_cliente = $this->session->userdata('user_id');
			}
			if ($_POST['id'] == 'fecha_boda' || $_POST['id'] == 'hora_boda') {
				$query = $this->db->query("SELECT fecha_boda FROM clientes WHERE id = {$id_cliente}");
				$fila = $query->row();
				$str_fechaDB = explode(" ", $fila->fecha_boda);

				if ($_POST['id'] == 'fecha_boda') {
					$str_fecha = explode("-", $_POST['value']);
					$_POST['value'] = $str_fecha[2] . "-" . $str_fecha[1] . "-" . $str_fecha[0] . " " . $str_fechaDB[1];
				} elseif ($_POST['id'] == 'hora_boda') {
					$_POST['id'] = 'fecha_boda';
					$_POST['value'] = $str_fechaDB[0] . " " . $_POST['value'] . ":00";
				}
			}

			if ($_POST['id'] == 'horas_dj') {
				$_POST['value'] = str_replace(',', '.', $_POST['value']);
			}
			if ($_POST['id'] == 'telefono_novio') {
				$_POST['value'] = str_replace(' ', '', $_POST['value']);
			}
			if ($_POST['id'] == 'telefono_novia') {
				$_POST['value'] = str_replace(' ', '', $_POST['value']);
			}

			$this->db->query("UPDATE clientes SET " . $_POST['id'] . " = '" . str_replace("'", "&#39;", $_POST['value']) . "' WHERE id = {$id_cliente}");

			echo $result;


			//SÓLO SE MANDA UN E-MAIL SI LA MODIFICACIÓN DE LOS DATOS DEL CLIENTE
			//VIENEN POR PARTE DEL PANEL DEL CLIENTE NO POR EL PANEL DE ADMINISTRADOR
			if (!$id) {
				$this->send_mail(str_replace("_", " ", $_POST['id']) . "->" . $_POST['value']);
			}
		}
	}

	function updatedatosolicitud($id = false)
	{
		if ($_POST) {

			$this->load->database();
			$id_solicitud = "";
			$result = $_POST['value'];

			if ($id) {
				//admin       CAGADAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA

				$id_solicitud = $id;
			} else {
				//solicitud
				//$this->load->library('session');
				//$id_solicitud = $this->session->userdata('user_id');

			}
			if ($_POST['id'] == 'fecha_boda' || $_POST['id'] == 'hora_boda') {
				$query = $this->db->query("SELECT fecha_boda FROM solicitudes WHERE id_solicitud = {$id_solicitud}");
				$fila = $query->row();
				$str_fechaDB = explode(" ", $fila->fecha_boda);

				if ($_POST['id'] == 'fecha_boda') {
					$str_fecha = explode("-", $_POST['value']);
					$_POST['value'] = $str_fecha[2] . "-" . $str_fecha[1] . "-" . $str_fecha[0] . " " . $str_fechaDB[1];
				} elseif ($_POST['id'] == 'hora_boda') {
					$_POST['id'] = 'fecha_boda';
					$_POST['value'] = $str_fechaDB[0] . " " . $_POST['value'] . ":00";
				}
			}

			if ($_POST['id'] == 'importe') {
				$_POST['value'] = str_replace(',', '.', $_POST['value']);
			}
			if ($_POST['id'] == 'descuento') {
				$_POST['value'] = str_replace(',', '.', $_POST['value']);
			}

			$this->db->query("UPDATE solicitudes SET " . $_POST['id'] . " = '" . str_replace("'", "&#39;", $_POST['value']) . "' WHERE id_solicitud = {$id_solicitud}");

			echo $result;
		}
	}



	function updatedatopresup($id = false)
	{


		if ($_POST) {

			$this->load->database();
			$id_presupuesto = "";
			$result = $_POST['value'];

			if ($id) {
				//admin       CAGADAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA

				$id_presupuesto = $id;
			} else {
				//solicitud
				//$this->load->library('session');
				//$id_solicitud = $this->session->userdata('user_id');

			}
			if ($_POST['id'] == 'fecha_boda' || $_POST['id'] == 'hora_boda') {
				$query = $this->db->query("SELECT fecha_boda FROM presupuesto_eventos WHERE id_presupuesto = {$id_presupuesto}");
				$fila = $query->row();
				$str_fechaDB = explode(" ", $fila->fecha_boda);

				if ($_POST['id'] == 'fecha_boda') {
					$str_fecha = explode("-", $_POST['value']);
					$_POST['value'] = $str_fecha[2] . "-" . $str_fecha[1] . "-" . $str_fecha[0] . " " . $str_fechaDB[1];
				} elseif ($_POST['id'] == 'hora_boda') {
					$_POST['id'] = 'fecha_boda';
					$_POST['value'] = $str_fechaDB[0] . " " . $_POST['value'] . ":00";
				}
			}

			$this->db->query("UPDATE presupuesto_eventos SET " . $_POST['id'] . " = '" . str_replace("'", "&#39;", $_POST['value']) . "' WHERE id_presupuesto = {$id_presupuesto}");

			echo $result;
		}
	}

	function deleteobservacion_presupuesto_eventos()
	{
		if ($_POST) {
			$this->load->database();
			$this->db->query("DELETE FROM observaciones_presupuesto_eventos WHERE id = " . $_POST['id'] . "");
		}
	}

	function calculardescuento($fecha_boda, $servicios)
	{
		$this->load->database();
		//$this->db->like('cancion',$titulo);
		//$this->db->like('artista',$artista);
		//echo json_encode( $this->db->get('bd_canciones')->result() );
		$fecha_boda = urldecode($fecha_boda);
		$servicios = urldecode($servicios);
		echo json_encode($this->db->query("SELECT * FROM descuento_presupuesto_eventos WHERE fecha_desde <= '" . $fecha_boda . "'  AND fecha_hasta >= '" . $fecha_boda . "' AND servicios = '" . $servicios . "'")->result());
		//echo json_encode ("SELECT * FROM descuento_presupuesto_eventos WHERE fecha_desde >= '".$fecha_boda."'  AND fecha_hasta <= '".$fecha_boda."' AND servicios = '".$servicios."'");
	}

	function deletepresupuesto_solicitud()
	{
		if ($_POST) {
			$this->load->database();
			$query = $this->db->query("SELECT presupuesto_pdf FROM solicitudes WHERE id_solicitud = " . $_POST['id'] . "");
			foreach ($query->result() as $fila) {
				$presupuesto = './uploads/presupuestos_solicitudes/' . $fila->presupuesto_pdf;
				//echo $contrato ;
				if (file_exists($presupuesto)) {
					unlink($presupuesto);
				}
			}

			$this->db->query("UPDATE solicitudes SET presupuesto_pdf = NULL WHERE id_solicitud = " . $_POST['id'] . "");
		}
	}

	function deleteobservacion_solicitud()
	{
		if ($_POST) {
			$this->load->database();
			$this->db->query("DELETE FROM observaciones_solicitudes WHERE id = " . $_POST['id'] . "");
		}
	}

	function deletellamada_solicitud()
	{
		if ($_POST) {
			$this->load->database();
			$this->db->query("DELETE FROM llamadas_solicitudes WHERE id_llamada = " . $_POST['id_llamada'] . "");
		}
	}

	public function anadir_pregunta()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$this->load->database();
			$data = json_decode(file_get_contents("php://input"), true);

			if (empty($data['pregunta'])) {
				echo json_encode(["success" => false, "message" => "La pregunta no puede estar vacía."]);
				return;
			}

			log_message('error', "Datos recibidos en anadir_pregunta: " . print_r($data, true));

			$insertData = ["pregunta" => $data['pregunta']];

			if (isset($data['importe_descuento']) && $data['importe_descuento'] !== null) {
				// Encuesta Comercial
				$insertData['importe_descuento'] = floatval($data['importe_descuento']);
				$this->db->insert('preguntas_encuesta', $insertData);
			} elseif (isset($data['descripcion']) && isset($data['tipo_pregunta'])) {
				// Encuesta Inicial Cliente
				$insertData['descripcion'] = $data['descripcion'];
				$insertData['tipo_pregunta'] = $data['tipo_pregunta'];
				$this->db->insert('preguntas_encuesta_datos_boda', $insertData);
			}

			if ($this->db->affected_rows() > 0) {
				echo json_encode(["success" => true, "message" => "Pregunta añadida con éxito"]);
			} else {
				log_message('error', "Error en la inserción SQL: " . $this->db->last_query()); // Log de la última consulta ejecutada
				echo json_encode(["success" => false, "message" => "Error al añadir la pregunta"]);
			}
		}
	}
	public function anadir_respuesta()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$this->load->database();
			$data = json_decode(file_get_contents("php://input"), true);

			log_message('error', "📥 Datos recibidos para nueva respuesta: " . print_r($data, true));

			if (empty($data['id_pregunta']) || empty($data['respuesta'])) {
				echo json_encode(["success" => false, "message" => "Faltan datos."]);
				return;
			}

			// Verificar si la pregunta existe
			$existeEncuesta1 = $this->db->get_where('preguntas_encuesta', ['id_pregunta' => $data['id_pregunta']])->num_rows() > 0;
			$existeEncuesta2 = $this->db->get_where('preguntas_encuesta_datos_boda', ['id_pregunta' => $data['id_pregunta']])->num_rows() > 0;

			if (!$existeEncuesta1 && !$existeEncuesta2) {
				log_message('error', "❌ ERROR: No se encontró la pregunta con ID: " . $data['id_pregunta']);
				echo json_encode(["success" => false, "message" => "La pregunta no existe."]);
				return;
			}

			// Determinar la tabla según la pregunta
			$tabla = $existeEncuesta1 ? "respuestas_encuesta" : "opciones_respuesta_encuesta_datos_boda";

			log_message('error', "✅ Insertando en la tabla: $tabla");

			$insertData = [
				"id_pregunta" => $data['id_pregunta'],
				"respuesta" => $data['respuesta']
			];
			$this->db->insert($tabla, $insertData);

			if ($this->db->affected_rows() > 0) {
				echo json_encode(["success" => true, "message" => "Respuesta añadida correctamente"]);
			} else {
				echo json_encode(["success" => false, "message" => "Error al añadir respuesta"]);
			}
		}
	}


	public function deletepregunta_encuesta()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$this->load->database();
			$data = json_decode(file_get_contents("php://input"), true);

			error_log("Recibido para eliminar: " . print_r($data, true)); // Depuración

			if (empty($data['id_pregunta']) || empty($data['tipo_encuesta'])) {
				echo json_encode(["success" => false, "message" => "Faltan datos en la solicitud."]);
				return;
			}

			// Determinar de qué tabla eliminar
			$tabla = ($data['tipo_encuesta'] === 'encuesta1') ? 'preguntas_encuesta' : 'preguntas_encuesta_datos_boda';

			// Intentar eliminar la pregunta de la tabla correspondiente
			$this->db->where('id_pregunta', intval($data['id_pregunta']));
			$this->db->delete($tabla);

			if ($this->db->affected_rows() > 0) {
				echo json_encode(["success" => true, "message" => "Pregunta eliminada correctamente"]);
			} else {
				echo json_encode(["success" => false, "message" => "No se pudo eliminar la pregunta"]);
			}
		}
	}


	public function editar_pregunta()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$this->load->database();
			$data = json_decode(file_get_contents("php://input"), true);

			if (empty($data['id_pregunta']) || empty($data['pregunta'])) {
				echo json_encode(["success" => false, "message" => "Datos insuficientes."]);
				return;
			}

			// Determinar la tabla según los datos recibidos
			if (isset($data['descripcion']) && isset($data['tipo_pregunta'])) {
				// Encuesta Inicial Cliente -> Actualiza preguntas_encuesta_datos_boda
				$updateData = [
					"pregunta" => $data['pregunta'],
					"descripcion" => $data['descripcion'],
					"tipo_pregunta" => $data['tipo_pregunta']
				];
				$this->db->where('id_pregunta', $data['id_pregunta']);
				$success = $this->db->update('preguntas_encuesta_datos_boda', $updateData);

				// Actualizar respuestas en la tabla opciones_respuesta_encuesta_datos_boda
				if (!empty($data['respuestas'])) {
					foreach ($data['respuestas'] as $resp) {
						$this->db->where('id_respuesta', $resp['id_respuesta']);
						$this->db->update('opciones_respuesta_encuesta_datos_boda', ['respuesta' => $resp['respuesta']]);
					}
				}
			} else {
				// Encuesta Comercial -> Actualiza preguntas_encuesta
				$updateData = ["pregunta" => $data['pregunta']];
				if (isset($data['importe_descuento'])) {
					$updateData['importe_descuento'] = floatval($data['importe_descuento']);
				}
				$this->db->where('id_pregunta', $data['id_pregunta']);
				$success = $this->db->update('preguntas_encuesta', $updateData);

				// Actualizar respuestas en la tabla respuestas_encuesta
				if (!empty($data['respuestas'])) {
					foreach ($data['respuestas'] as $resp) {
						$this->db->where('id_respuesta', $resp['id_respuesta']);
						$this->db->update('respuestas_encuesta', ['respuesta' => $resp['respuesta']]);
					}
				}
			}

			if ($success) {
				echo json_encode(["success" => true, "message" => "Pregunta y respuestas actualizadas correctamente"]);
			} else {
				echo json_encode(["success" => false, "message" => "No se pudo actualizar la pregunta"]);
			}
		}
	}


	public function eliminar_respuesta()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$this->load->database();
			$data = json_decode(file_get_contents("php://input"), true);

			if (empty($data['id_respuesta'])) {
				echo json_encode(["success" => false, "message" => "ID de respuesta no recibido."]);
				return;
			}

			// Verificar si la respuesta existe en respuestas_encuesta
			$this->db->where('id_respuesta', $data['id_respuesta']);
			$existsInRespuestasEncuesta = $this->db->get('respuestas_encuesta')->num_rows() > 0;

			if ($existsInRespuestasEncuesta) {
				$this->db->where('id_respuesta', $data['id_respuesta']);
				$this->db->delete('respuestas_encuesta');
			} else {
				// Verificar si la respuesta existe en opciones_respuesta_encuesta_datos_boda
				$this->db->where('id_respuesta', $data['id_respuesta']);
				$existsInOpcionesRespuesta = $this->db->get('opciones_respuesta_encuesta_datos_boda')->num_rows() > 0;

				if ($existsInOpcionesRespuesta) {
					$this->db->where('id_respuesta', $data['id_respuesta']);
					$this->db->delete('opciones_respuesta_encuesta_datos_boda');
				} else {
					echo json_encode(["success" => false, "message" => "La respuesta no existe."]);
					return;
				}
			}

			echo json_encode(["success" => true, "message" => "Respuesta eliminada correctamente"]);
		}
	}


	function updatefacturamanual($id = false)
	{

		if ($_POST) {

			$this->load->database();
			$id_factura = "";
			$result = $_POST['value'];

			if ($id) {
				$id_factura = $id;
			}

			$this->db->query("UPDATE facturas_manuales SET " . $_POST['id'] . " = '" . str_replace("'", "&#39;", $_POST['value']) . "' WHERE id_factura = {$id_factura}");

			echo $result;
		}
	}

	function updatepartidapresupuestaria($id = false)
	{

		if ($_POST) {

			$this->load->database();
			$id_partida = "";
			$result = $_POST['value'];

			if ($id) {
				$id_partida = $id;
			}

			$this->db->query("UPDATE partidas_presupuestarias SET " . $_POST['id'] . " = '" . str_replace("'", "&#39;", $_POST['value']) . "' WHERE id_partida = {$id_partida}");

			echo $result;
		}
	}

	function deletefacturamanual()
	{
		$this->load->database();
		$this->db->query("DELETE FROM facturas_manuales WHERE id_factura = " . $_POST['id'] . "");
	}

	function deleteretencion()
	{
		$this->load->database();
		$this->db->query("DELETE FROM retenciones WHERE id_retencion = " . $_POST['id'] . "");
	}

	function deletemovimiento()
	{
		$this->load->database();
		$this->db->query("DELETE FROM movimientos_cuentas WHERE id_movimiento = " . $_POST['id'] . "");
	}


	public function send_mail($mensaje)
	{

		$mensaje = "Usuario " . $this->session->userdata('nombre_novia') . "(" . $this->session->userdata('email_novia') . ") & " . $this->session->userdata('nombre_novio') . "(" . $this->session->userdata('email_novio') . " ha cambiado siguente dato: " . $mensaje;

		/* $cabeceras  = 'MIME-Version: 1.0' . "\r\n";
          $cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
          $cabeceras .= 'From: info@exeleventos.com'; */

		//$send = mail("info@exeleventos.com", "Intraboda - Cambio de datos del usuario", $mensaje, $cabeceras);
		$asunto = "Intraboda - Cambio de datos del usuario";
		$this->sendEmail('info@exeleventos.com', [$email_novio, $email_novia], $asunto, $mensaje);
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
}
