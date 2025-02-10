<?php
if (! defined('BASEPATH')) exit('No direct script access allowed');
class Ajax extends CI_Controller
{

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
			$order = str_replace('mom_', '', $_POST['order']);
			$arr = explode(',', $order);
			$this->load->database();

			$query = $this->db->query("SELECT id FROM momentos_espec WHERE id IN ({$order}) ORDER BY FIELD( id, {$order} )");

			if ($query->num_rows() > 0) {
				$i = 1;
				foreach ($query->result() as $fila) {
					$q[] = "UPDATE momentos_espec SET orden = {$i} WHERE id = " . $fila->id . "";
					$i++;
				}
			}
			foreach ($q as $r) {
				$this->db->query($r);
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

		if ($_POST) {
			$this->load->database();

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
			$this->db->query("UPDATE componentes SET id_grupo = NULL WHERE id_componente = " . $_POST['id'] . "");
		}
	}
	function deleteequipo()
	{
		if ($_POST) {
			$this->load->database();
			$this->db->query("UPDATE componentes SET id_grupo = NULL WHERE id_grupo = " . $_POST['id'] . "");
			$this->db->query("DELETE FROM grupos_equipos WHERE id_grupo = " . $_POST['id'] . "");
			//Actualizamos las asignaciones
			$this->db->query("UPDATE clientes SET equipo_componentes = NULL WHERE equipo_componentes = " . $_POST['id'] . "");
			$this->db->query("UPDATE clientes SET equipo_luces = NULL WHERE equipo_luces = " . $_POST['id'] . "");
		}
	}
	function deletecomponente()
	{
		if ($_POST) {
			$this->load->database();
			$this->db->query("DELETE FROM componentes WHERE id_componente = " . $_POST['id'] . "");
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

			if ($_POST['id'] == 'nombre') {
				//Consultamos el nombre viejo
				$query = $this->db->query("SELECT nombre FROM restaurantes WHERE id_restaurante = {$id}");
				foreach ($query->result() as $fila) {
					$nombre_viejo = $fila->nombre;
				}

				//Actualizamos la tabla presupuestos_eventos
				$this->db->query("UPDATE presupuesto_eventos SET restaurante = '" . str_replace("'", "&#39;", $_POST['value']) . "' WHERE restaurante = '" . $nombre_viejo . "'");
				//Actualizamos la tabla solicitudes
				$this->db->query("UPDATE solicitudes SET restaurante = '" . str_replace("'", "&#39;", $_POST['value']) . "' WHERE restaurante = '" . $nombre_viejo . "'");
			}

			$this->db->query("UPDATE restaurantes SET " . $_POST['id'] . " = '" . str_replace("'", "&#39;", $_POST['value']) . "' WHERE id_restaurante = {$id}");
			$result = $_POST['value'];

			echo $result;
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

	function deletepregunta_encuesta()
	{
		if ($_POST) {
			$this->load->database();
			$this->db->query("DELETE FROM preguntas_encuesta WHERE id_pregunta = " . $_POST['id_pregunta'] . "");
			$this->db->query("DELETE FROM respuestas_encuesta WHERE id_pregunta = " . $_POST['id_pregunta'] . "");
			//Cabría la posibilidad de borrar las respuestas de la tabla encuestas_solicitudes cuya id_pregunta coinicida
			//con la que se borra (Lo realizamos)
			$this->db->query("DELETE FROM encuestas_solicitudes WHERE id_pregunta = " . $_POST['id_pregunta'] . "");
		}
	}

	function edita_pregunta_encuesta()
	{
		if ($_POST) {
			$this->load->database();
			$this->db->query("UPDATE preguntas_encuesta SET pregunta='" . $_POST['pregunta'] . "' WHERE id_pregunta = " . $_POST['id_pregunta'] . "");
		}
	}

	function edita_respuesta_encuesta()
	{
		if ($_POST) {
			$this->load->database();
			$this->db->query("UPDATE respuestas_encuesta SET respuesta='" . $_POST['respuesta'] . "' WHERE id_respuesta = " . $_POST['id_respuesta'] . "");
		}
	}

	function modifica_importe_descuento_pregunta_encuesta()
	{
		if ($_POST) {
			$this->load->database();
			$this->db->query("UPDATE preguntas_encuesta SET importe_descuento='" . $_POST['importe_descuento'] . "' WHERE id_pregunta = " . $_POST['id_pregunta'] . "");
		}
	}

	function deleterespuesta_encuesta()
	{
		if ($_POST) {
			$this->load->database();
			$this->db->query("DELETE FROM respuestas_encuesta WHERE id_respuesta = " . $_POST['id_respuesta'] . "");
			//Cabría la posibilidad de borrar las respuestas de la tabla encuestas_solicitudes cuya id_respuesta coinicida
			//con la que se borra (Lo realizamos)
			$this->db->query("DELETE FROM encuestas_solicitudes WHERE id_respuesta = " . $_POST['id_pregunta'] . "");
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

			//$mail->addCC('rajlopa@gmail.com');
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
