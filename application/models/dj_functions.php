<?
Class Dj_functions extends CI_Model{
	
	function DjLogin($mail, $clave)
	{
		//$clave = md5($clave);
		$data = false;
		$this->load->database();
		$this->load->library('encrypt');
		$clave_sin_cifrar="";
		//Busco la clave cifrada del dj
		$query2 = $this->db->query("SELECT clave FROM djs WHERE email  = '{$mail}'");
		if($query2->num_rows() > 0){
			$fila2 = $query2->row();
			$clave_cifrada = $fila2->clave;
			
			//Desencripto la clave cifrada para compararla con la que introduce el dj
			$clave_sin_cifrar=$this->encrypt->decode($clave_cifrada);
		}
		//Comparo las clave descifrada con la que introduce el dj
		if($clave_sin_cifrar<>$clave)
		{
			//Si no coinciden me invento una clave error
			$clave="ERROR";
		}
		
		//Sólo busco en la BD si la clave que ha introducido el dj es igual a la que hay en descifrada en la BD	
		if($clave<>"ERROR")
		{	
			$query = $this->db->query("SELECT id, email, nombre, foto FROM djs WHERE email  = '".$mail."'");	
			if($query->num_rows() > 0){
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
		$data['fecha_boda'] = $data['fecha_boda'] . " " .$data['hora_boda']; 
		unset($data['hora_boda']);
		$this->db->insert('clientes', $data); 
		
		return $this->db->insert_id();
	
		
	}
	function GetClientes($str_where, $ord, $limit)
	{
		$data = false;
		$this->load->database();
		$query = $this->db->query("SELECT clientes.id, clientes.foto, clientes.nombre_novio, clientes.nombre_novia, restaurantes.nombre AS restaurante, DATE_FORMAT(clientes.fecha_boda, '%d-%m-%Y %H:%i') as fecha_boda_formateado, DATE_FORMAT(clientes.fecha, '%d-%m-%Y') as fecha_alta FROM clientes INNER JOIN restaurantes ON clientes.id_restaurante=restaurantes.id_restaurante {$str_where} ORDER BY {$ord}   {$limit}");	
		
		if($query->num_rows() > 0){
			$i = 0;
			foreach($query->result() as $fila){
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
		
		if($query->num_rows() > 0){
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
			if($query2->num_rows() > 0){
				$i = 0;
				foreach($query2->result() as $fila2){
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
		
		if($query->num_rows() > 0){
			$i = 0;
			foreach($query->result() as $fila){
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
		$this->db->query("UPDATE clientes SET foto = '".$foto."' WHERE id = {$id}");	
		
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
		$query = $this->db->query("INSERT INTO momentos_espec (nombre) VALUES ('".str_replace("'", "&#39;",$nombre)."')");	
		
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
		if($query->num_rows() > 0){
			$i = 0;
			foreach($query->result() as $fila){
				$data[$i]['id'] = $fila->id;
				$data[$i]['nombre'] = $fila->nombre;
				$data[$i]['telefono'] = $fila->telefono;
				$data[$i]['email'] = $fila->email;
				$data[$i]['clave']=$this->encrypt->decode($fila->clave);
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

		$query = $this->db->query("SELECT id_contrato, nombre_contrato, fecha_contrato, contrato_pdf FROM contratos_djs WHERE id_dj = {$id} AND fecha_contrato>='".$ano_contrato."-01-01' AND fecha_contrato<='".$ano_contrato."-12-31'");
			
		if($query->num_rows() > 0){
			$i = 0;
			foreach($query->result() as $fila){
				$data[$i]['id_contrato'] = $fila->id_contrato;
				$data[$i]['nombre_contrato'] = $fila->nombre_contrato;
				$data[$i]['fecha_contrato'] = $fila->fecha_contrato;
				$data[$i]['contrato_pdf'] = $fila->contrato_pdf;
				$data[$i]['ano_contrato'] = $ano_contrato;
				$i++;
			}
		}
		else
		{
			$data[0]['ano_contrato'] = $ano_contrato;
		}
		return $data;
	}
	
	function GetDJNominas($id, $ano_nomina)
	{
		$data = false;
		$this->load->database();
		$query = $this->db->query("SELECT id_nomina, nombre_nomina, fecha_nomina, nomina_pdf FROM nominas_djs WHERE id_dj = {$id} AND fecha_nomina>='".$ano_nomina."-01-01' AND fecha_nomina<='".$ano_nomina."-12-31'");	
		if($query->num_rows() > 0){
			$i = 0;
			foreach($query->result() as $fila){
				$data[$i]['id_nomina'] = $fila->id_nomina;
				$data[$i]['nombre_nomina'] = $fila->nombre_nomina;
				$data[$i]['fecha_nomina'] = $fila->fecha_nomina;
				$data[$i]['nomina_pdf'] = $fila->nomina_pdf;
				$data[$i]['ano_nomina'] = $ano_nomina;
				$i++;
			}
		}
		else
		{
			$data[0]['ano_nomina'] = $ano_nomina;
		}
		return $data;
	}
	
	
	function GetEquiposComponentesAsignado($id_cliente)
	{
		$data = false;
		$this->load->database();
		$query = $this->db->query("SELECT equipo_componentes FROM clientes WHERE id = {$id_cliente}");	
		$fila = $query->row();
		$equipo_componentes = $fila->equipo_componentes;

		if($equipo_componentes <> "" )
		{
			$query = $this->db->query("SELECT id_grupo, nombre_grupo FROM grupos_equipos WHERE id_grupo = ({$equipo_componentes})");	
			if($query->num_rows() > 0){
				$i = 0;
				foreach($query->result() as $fila){
					$data[$i]['id_grupo'] = $fila->id_grupo;
					$data[$i]['nombre_grupo'] = $fila->nombre_grupo;
					$i++;
				}
			}
		}
		return $data;
	}
	
	function GetEquiposLucesAsignado($id_cliente)
	{
		$data = false;
		$this->load->database();
		$query = $this->db->query("SELECT equipo_luces FROM clientes WHERE id = {$id_cliente}");	
		$fila = $query->row();
		$equipo_luces = $fila->equipo_luces;

		if($equipo_luces <> "" )
		{
			$query = $this->db->query("SELECT id_grupo, nombre_grupo FROM grupos_equipos WHERE id_grupo = ({$equipo_luces})");	
			if($query->num_rows() > 0){
				$i = 0;
				foreach($query->result() as $fila){
					$data[$i]['id_grupo'] = $fila->id_grupo;
					$data[$i]['nombre_grupo'] = $fila->nombre_grupo;
					$i++;
				}
			}
		}
		return $data;
	}
	
	function GetEquiposExtra1Asignado($id_cliente)
	{
		$data = false;
		$this->load->database();
		$query = $this->db->query("SELECT equipo_extra1 FROM clientes WHERE id = {$id_cliente}");	
		$fila = $query->row();
		$equipo_extra1 = $fila->equipo_extra1;

		if($equipo_extra1 <> "" )
		{
			$query = $this->db->query("SELECT id_grupo, nombre_grupo FROM grupos_equipos WHERE id_grupo = ({$equipo_extra1})");	
			if($query->num_rows() > 0){
				$i = 0;
				foreach($query->result() as $fila){
					$data[$i]['id_grupo'] = $fila->id_grupo;
					$data[$i]['nombre_grupo'] = $fila->nombre_grupo;
					$i++;
				}
			}
		}
		return $data;
	}
	
	function GetEquiposExtra2Asignado($id_cliente)
	{
		$data = false;
		$this->load->database();
		$query = $this->db->query("SELECT equipo_extra2 FROM clientes WHERE id = {$id_cliente}");	
		$fila = $query->row();
		$equipo_extra2 = $fila->equipo_extra2;

		if($equipo_extra2 <> "" )
		{
			$query = $this->db->query("SELECT id_grupo, nombre_grupo FROM grupos_equipos WHERE id_grupo = ({$equipo_extra2})");	
			if($query->num_rows() > 0){
				$i = 0;
				foreach($query->result() as $fila){
					$data[$i]['id_grupo'] = $fila->id_grupo;
					$data[$i]['nombre_grupo'] = $fila->nombre_grupo;
					$i++;
				}
			}
		}
		return $data;
	}
	
	function GetComponentes()
	{
		$data = false;
		$this->load->database();
		$query = $this->db->query("SELECT * FROM componentes ORDER BY n_registro ASC");
		if($query->num_rows() > 0){
			$i = 0;
			foreach($query->result() as $fila){
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
		if($query->num_rows() > 0){
			$i = 0;
			foreach($query->result() as $fila){
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
		$query = $this->db->query("SELECT id_pregunta, pregunta FROM preguntas_encuesta_datos_boda");	
		if($query->num_rows() > 0){
			$i = 0;
			foreach($query->result() as $fila){
				$data[$i]['id_pregunta'] = $fila->id_pregunta;
				$data[$i]['pregunta'] = $fila->pregunta;
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
		if($query->num_rows() > 0){
			$i = 0;
			foreach($query->result() as $fila){
				$data[$i]['id_respuesta'] = $fila->id_respuesta;
				$data[$i]['id_pregunta'] = $fila->id_pregunta;
				$data[$i]['respuesta'] = $fila->respuesta;
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
		if($query->num_rows() > 0){
			$i = 0;
			foreach($query->result() as $fila){
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
		if($query->num_rows() > 0){
			$i = 0;
			foreach($query->result() as $fila){
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
		if($query->num_rows() > 0){
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
		$query = $this->db->query("SELECT id, comentario, DATE_FORMAT(fecha, '%d-%m-%Y %H:%i') as fecha FROM observaciones WHERE id_cliente = {$id} ORDER BY id DESC");		
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
	function DeleteServicio($id)
	{
		$this->load->database();
		$query = $this->db->query("DELETE FROM servicios WHERE id = {$id}");	
	 }
	function UpdateServicio($data, $id)
	{
		$this->load->database();
		$query = $this->db->query("UPDATE servicios SET nombre = '".str_replace("'", "&#39;",$data['nombre'])."', precio = '".$data['precio']."', precio_oferta = '".$data['precio_oferta']."' WHERE id = {$id}");	
	 }
	 function InsertPerson($data)
	{
		
		$this->load->database();
		$query = $this->db->query("INSERT INTO personas_contacto (nombre, telefono, email, tipo) VALUES ('".str_replace("'", "&#39;",$data['nombre'])."', '".stripslashes(str_replace("'", "&#39;",$data['telefono']))."', '".$data['email']."', '".str_replace("'", "&#39;",$data['tipo'])."')");	
		return $this->db->insert_id();
	}
	function UpdatePerson($data)
	{
		
		$this->load->database();
		$query = $this->db->query("UPDATE personas_contacto SET nombre = '".str_replace("'", "&#39;",$data['nombre'])."', telefono = '".stripslashes(str_replace("'", "&#39;",$data['telefono']))."', email = '".$data['email']."', tipo = '".str_replace("'", "&#39;",$data['tipo'])."' WHERE id = ".$data['id']."");	
		
	}
	function UpdatefotoPerson($id, $foto)
	{
		
		$this->load->database();
		$this->db->query("UPDATE personas_contacto SET foto = '".$foto."' WHERE id = {$id}");	
		
	}
	function DeletePerson($id)
	{
		
		$this->load->database();
		$query = $this->db->query("SELECT foto FROM personas_contacto WHERE id = {$id}");	
		$fila = $query->row();	
		if($fila->foto != ""){
			$foto = './uploads/personas_contacto/'.$fila->foto;
			echo $foto ;
			if (file_exists($foto)) { unlink ($foto); }
		}
		
		$this->db->query("DELETE FROM personas_contacto WHERE id = {$id}");	
	 }
	function GetPersonasContacto()
	{
		$data = false;
		$this->load->database();
		$query = $this->db->query("SELECT id, nombre, telefono, email, tipo, foto FROM personas_contacto");	
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
	
}
?>