<?php

Class Admin_functions extends CI_Model{
	
	function InsertCliente($data)
	{
		
		$this->load->database();
		$this->load->library('encrypt');
		//$data['servicios'] = implode(",", $data['servicios']);
		$servicios_momentos = array();
		$servicios_momentos = $data['servicios'];
		$servicios = array();
		$servicios = serialize($data['servicios']);
		$data['servicios'] = $servicios;
		$data['personas_contacto'] = implode(",", $data['personas_contacto']);
		$data['fecha_boda'] = $data['fecha_boda'] . " " .$data['hora_boda']; 
		unset($data['hora_boda']);
		
		$config['upload_path'] = './uploads/pdf/';
		$config['allowed_types'] = 'pdf';
		$this->load->library('upload', $config);
		
		if ( ! $this->upload->do_upload("presupuesto"))
		{
			$pdf['msg_pdf'] = $this->upload->display_errors();
		} else {
			$pdf['upload_data'] = $this->upload->data();
			$data['presupuesto_pdf']=$pdf['upload_data']['file_name'];
		}
			
		if ( ! $this->upload->do_upload("contrato"))
		{
			$pdf2['msg_pdf'] = $this->upload->display_errors();
		} else {
			$pdf2['upload_data'] = $this->upload->data();
			$data['contrato_pdf'] = $pdf2['upload_data']['file_name'];
		}
			
		$data['canal_captacion'] = $data['canal_captacion'];
		$data['id_oficina'] = $data['id_oficina'];		
		$clave = $data['clave'];
		$data['clave'] = $this->encrypt->encode($data['clave']);
		
			
		$this->db->insert('clientes', $data);
		
		$id_cliente = $this->db->insert_id();
		
		
		
		//PERSONALIZAMOS LOS MOMENTOS ESPECIALES QUE SE AÑADEN DEPENDIENDO LOS SERVICIOS CONTRATADOS
		$orden=1;
		$arr_serv_keys = array_keys($servicios_momentos);
		//Escogen Djs animadores 2 horas
		if(in_array(4, $arr_serv_keys)){
			$query= $this->db->query("INSERT INTO momentos_espec VALUES ('', 'Apertura del baile', '".$orden."', '".$id_cliente."')");
			$orden++;
			$query= $this->db->query("INSERT INTO momentos_espec VALUES ('', 'Fiesta', '".$orden."', '".$id_cliente."')");
			$orden++;
		}
		//Escogen Sonorización Cocktail
		if(in_array(9, $arr_serv_keys)){
			$query= $this->db->query("INSERT INTO momentos_espec VALUES ('', 'Música Cocktail', '".$orden."', '".$id_cliente."')");
			$orden++;
		}
		//Sonorización momentos del banquete
		if(in_array(10, $arr_serv_keys)){
			$query= $this->db->query("INSERT INTO momentos_espec VALUES ('', 'Entrada al banquete', '".$orden."', '".$id_cliente."')");
			$orden++;
			$query= $this->db->query("INSERT INTO momentos_espec VALUES ('', 'Corte de tarta', '".$orden."', '".$id_cliente."')");
			$orden++;
			$query= $this->db->query("INSERT INTO momentos_espec VALUES ('', 'Entrega de muñecos tarta', '".$orden."', '".$id_cliente."')");
			$orden++;
			$query= $this->db->query("INSERT INTO momentos_espec VALUES ('', 'Entrega del ramo', '".$orden."', '".$id_cliente."')");
			$orden++;
		}
		//Escogen Sonorización de ceremonia civil
		if(in_array(11, $arr_serv_keys)){
			$query= $this->db->query("INSERT INTO momentos_espec VALUES ('', 'Entrada del novio a la ceremonia', '".$orden."', '".$id_cliente."')");
			$orden++;
			$query= $this->db->query("INSERT INTO momentos_espec VALUES ('', 'Entrada de la novia a la ceremonia', '".$orden."', '".$id_cliente."')");
			$orden++;
			$query= $this->db->query("INSERT INTO momentos_espec VALUES ('', 'Lectura 1', '".$orden."', '".$id_cliente."')");
			$orden++;
			$query= $this->db->query("INSERT INTO momentos_espec VALUES ('', 'Lectura 2', '".$orden."', '".$id_cliente."')");
			$orden++;
			$query= $this->db->query("INSERT INTO momentos_espec VALUES ('', 'Firma de acta y salida', '".$orden."', '".$id_cliente."')");
			$orden++;
		}
		
		
		//SE AÑADEN AUTOMÁTICAMENTE LOS MOMENTOS ESPECIALES QUE ESTÁN EN BD MOMENTOS ESPECIALES
		/*$query= $this->db->query("SELECT momento FROM bd_momentos_espec");
		if($query->num_rows() > 0){
			$orden=1;
			foreach($query->result() as $fila){
				$query= $this->db->query("INSERT INTO momentos_espec VALUES ('', '".$fila->momento."', '".$orden."', '".$id_cliente."')");
				$orden++;
			}
		}*/
		
		
		if($data['enviar_emails']=='S'){
			$query = $this->db->query("select nombre, email from oficinas where id_oficina='".$data['id_oficina']."'");
			foreach($query->result() as $fila){
				$nombre_oficina=$fila->nombre;
				$email_oficina=$fila->email;
			}
			
			$cabeceras  = 'MIME-Version: 1.0' . "\r\n";
			$cabeceras .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
			$cabeceras .= 'From: '.$email_oficina;
			
			$asunto='Bienvenido/a a IntraBoda - '.$nombre_oficina;
			$mensaje='<font color="#C79ED6">
					  <table width="100%" border="0">
					  <tr>
						<td align="center">
							<img src="http://www.bilbodj.com/intranetv3/img/alta_perfil/cabecera.jpg" width="100%">
						</td>
					  </tr>
					  <tr>
						<td><table width="100%" border="0">
						  <tr>
							<td width="14%" align="center"><img src="http://www.bilbodj.com/intranetv3/img/alta_perfil/1.jpg" width="100%"></td>
							<td width="63%"><div align="justify">Accede a <a href="http://www.exeleventos.com" target="_blank">www.exeleventos.com</a> con tu navegador y haz click sobre “ZONA CLIENTE” en el margen superior derecho.<br>
							  Introduce tu email como usuario y en la clave introduce la siguiente contraseña:<br>
							  <br>
							  <font size="+4"><center>'.$clave.'</center></font></div></td>
							<td width="23%" align="center"><img src="http://www.bilbodj.com/intranetv3/img/alta_perfil/zona_cliente.jpg" width="100%"></td>
						  </tr>
						  <tr>
							<td align="center"><img src="http://www.bilbodj.com/intranetv3/img/alta_perfil/2.jpg" width="100%"></td>
							<td><div align="justify">Tras introducir la clave en vuestro primer acceso, el sistema os pedirá una foto. Seguidamente tendréis que contestar a unas preguntas en un breve formulario que nos servirán para crear un perfil de DJ Animador para vuestra boda. Como ya sabéis, el DJ será asignado un mes antes del evento. Una vez completado, podremos continuar para acceder al perfil.</div></td>
							<td align="center"><img src="http://www.bilbodj.com/intranetv3/img/alta_perfil/foto_instrucciones.jpg" width="100%"></td>
						  </tr>
						</table>
						  <table width="100%" border="0">
							<tr>
							  <td width="14%" align="center"><img src="http://www.bilbodj.com/intranetv3/img/alta_perfil/3.jpg" width="100%"></td>
							  <td width="86%"><div align="justify">En la parte superior de la pantalla encontraréis un menú de navegación para trabajar sobre las diferentes secciones de la herramienta.<br>
								- En <i>"Canciones más elegidas"</i> podréis ver un Top 10 de los temas más elegidos por todas las parejas BilboDJ y también para qué momento lo han señalado (Ceremonia, Cocktail, Entrada al Banquete, Corte de Tarta, Entrega del Ramo, Regalo a amig@s, Fiesta, …)<br>
								- En <i>"Mis datos"</i> podréis revisar toda la información (horarios, foto y datos del DJ Animador asignado, cambiar encuesta inicial, servicios contratados, actualidad de pagos y cambio de contraseña).<br>
								- <i>"Mi listado de canciones"</i> es la sección diseñada para que podáis definir todas las canciones que no queréis que falten y las observaciones a tener en cuenta el día de la boda.<br>
							  - <i>"Ofertas destacadas"</i> para valorar posibles nuevos servicios.</div></td>
							</tr>
							<tr>
							  <td align="center"><img src="http://www.bilbodj.com/intranetv3/img/alta_perfil/4.jpg" width="100%"></td>
							  <td><div align="justify">Para finalizar, podremos mantener un contacto directo en la pestaña de <i>"Chat"</i>.  Reflejad cualquier duda que os pueda surgir con los preparativos o cuestiones que nos queráis plantear y os contestaremos desde nuestras oficinas a la mayor brevedad posible. Así mismo, el DJ Animador pasará a formar parte de ese Chat una vez haya sido asignado.</div></td>
							</tr>
						</table></td>
					  </tr>
					  <tr>
						<td align="center">
							<img src="http://www.bilbodj.com/intranetv3/img/alta_perfil/pie.jpg" width="100%">
						</td>
					  </tr>
					</table>
					</font>';
			
			$asunto=html_entity_decode($asunto);
			$mensaje=html_entity_decode($mensaje);
	
			/* mail($data['email_novio'], $asunto, $mensaje, $cabeceras);
              mail($data['email_novia'], $asunto, $mensaje, $cabeceras); */
            $this->sendEmail('info@exeleventos.com', [$data['email_novio'], $data['email_novia']], $asunto, $mensaje);
        }
		
		return $this->db->insert_id();
	
	}
	
	function InsertRestaurante($data)
	{
		
		$this->load->database();
					
		$this->db->insert('restaurantes', $data);
		
		$id_cliente = $this->db->insert_id();
		
		return $this->db->insert_id();
	
	}
	
	function GetRestaurantes($str_where, $ord, $limit)
	{
		$data = false;
		$this->load->database();
		
		$query = $this->db->query("SELECT id_restaurante, nombre, direccion, telefono, maitre, telefono_maitre, hora_limite_fiesta FROM restaurantes {$str_where} ORDER BY {$ord}   {$limit}");
		if($query->num_rows() > 0){
			$i = 0;
			foreach($query->result() as $fila){				
				$data[$i]['id_restaurante'] = $fila->id_restaurante;
				$data[$i]['nombre'] = $fila->nombre;
				$data[$i]['direccion'] = $fila->direccion;
				$data[$i]['telefono'] = $fila->telefono;
				$data[$i]['maitre'] = $fila->maitre;
				$data[$i]['telefono_maitre'] = $fila->telefono_maitre;
				$data[$i]['hora_limite_fiesta'] = $fila->hora_limite_fiesta;
				$i++;
			}
		}
		return $data;
	}
	
	function GetRestaurantesTotales()
	{
		$data = false;
		$this->load->database();
		
		$query = $this->db->query("SELECT id_restaurante, nombre, direccion, telefono, maitre, telefono_maitre, hora_limite_fiesta FROM restaurantes ORDER BY nombre ASC");
		if($query->num_rows() > 0){
			$i = 0;
			foreach($query->result() as $fila){				
				$data[$i]['id_restaurante'] = $fila->id_restaurante;
				$data[$i]['nombre'] = $fila->nombre;
				$data[$i]['direccion'] = $fila->direccion;
				$data[$i]['telefono'] = $fila->telefono;
				$data[$i]['maitre'] = $fila->maitre;
				$data[$i]['telefono_maitre'] = $fila->telefono_maitre;
				$data[$i]['hora_limite_fiesta'] = $fila->hora_limite_fiesta;
				$i++;
			}
		}
		return $data;
	}
	
	function GetClientes($str_where, $ord, $limit)
	{
		$data = false;
		$this->load->database();
		
		$query = $this->db->query("SELECT clientes.id, clientes.foto, clientes.nombre_novio, clientes.nombre_novia, restaurantes.nombre AS restaurante, clientes.id_tipo_cliente, DATE_FORMAT(clientes.fecha_boda, '%d-%m-%Y %H:%i') as fecha_boda, DATE_FORMAT(clientes.fecha, '%d-%m-%Y') as fecha_alta FROM clientes INNER JOIN restaurantes ON clientes.id_restaurante=restaurantes.id_restaurante {$str_where} ORDER BY {$ord}   {$limit}");
		//$query = $this->db->query("SELECT id, clave, foto, nombre_novio, nombre_novia, restaurante, DATE_FORMAT(fecha_boda, '%d-%m-%Y %H:%i') as fecha_boda, DATE_FORMAT(fecha, '%d-%m-%Y') as fecha_alta FROM clientes");
		
		if($query->num_rows() > 0){
			$i = 0;
			foreach($query->result() as $fila){
				
				/*$this->load->library('encrypt');
				$query = $this->db->query("UPDATE clientes SET clave = '" . $this->encrypt->encode($fila->clave) . "' WHERE id = '" . $fila->id . "'");*/
				
				$data[$i]['id'] = $fila->id;
				$data[$i]['foto'] = $fila->foto;
				$data[$i]['nombre_novio'] = $fila->nombre_novio;
				$data[$i]['nombre_novia'] = $fila->nombre_novia;
				$data[$i]['restaurante'] = $fila->restaurante;
				$data[$i]['id_tipo_cliente'] = $fila->id_tipo_cliente;
				$data[$i]['fecha_boda'] = $fila->fecha_boda;
				$data[$i]['fecha_alta'] = $fila->fecha_alta;
				$i++;
			}
		}
		return $data;
	}
	function GetCliente($id)
	{
		$data = false;
		
		$this->load->library('encrypt');
		/*$msg = 'Mi mensaje secreto';
		$encrypted_string = $this->encrypt->encode($msg);
		$data['msg']= 'Mi mensaje secreto';
		$data['msg2']= $this->encrypt->encode($msg);
		$data['msg3'] = $this->encrypt->decode($data['msg2']);*/

		$this->load->database();
		$query = $this->db->query("SELECT clientes.email_novio, clientes.email_novia, clientes.clave, clientes.nombre_novio, clientes.apellidos_novio, clientes.direccion_novio, clientes.cp_novio, clientes.poblacion_novio, clientes.telefono_novio, clientes.nombre_novia, clientes.apellidos_novia, clientes.direccion_novia, clientes.cp_novia, clientes.poblacion_novia, clientes.telefono_novia, clientes.foto, clientes.canal_captacion, clientes.id_oficina, clientes.id_tipo_cliente, clientes.enviar_emails, clientes.fecha_boda, clientes.id_restaurante, restaurantes.nombre AS restaurante, restaurantes.direccion AS direccion_restaurante, restaurantes.telefono AS telefono_restaurante, clientes.servicios, clientes.personas_contacto, DATE_FORMAT(clientes.fecha_boda, '%d-%m-%Y') as fecha_boda, DATE_FORMAT(clientes.fecha_boda, '%H:%i') as hora_boda, restaurantes.maitre, restaurantes.telefono_maitre, clientes.contrato_pdf, clientes.presupuesto_pdf, clientes.descuento, clientes.observaciones FROM clientes INNER JOIN restaurantes ON clientes.id_restaurante=restaurantes.id_restaurante WHERE id = {$id}");	
		
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
			$data['canal_captacion'] = $fila->canal_captacion;
			$data['id_oficina'] = $fila->id_oficina;
			$data['id_tipo_cliente'] = $fila->id_tipo_cliente;
			$data['enviar_emails'] = $fila->enviar_emails;
			$data['id_restaurante'] = $fila->restaurante;
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
	
	function GetTiposClientes()
	{
		$data = false;
		$this->load->database();
		$query = $this->db->query("SELECT id_tipo_cliente, tipo_cliente, color FROM tipos_clientes");	
		if($query->num_rows() > 0){
			$i = 0;
			foreach($query->result() as $fila){
				$data[$i]['id_tipo_cliente'] = $fila->id_tipo_cliente;
				$data[$i]['tipo_cliente'] = $fila->tipo_cliente;
				$data[$i]['color'] = $fila->color;
				$i++;
			}
		}
		return $data;
	}
	
	function GetRestaurante($id)
	{
		$data = false;
		$this->load->database();
		
		$query = $this->db->query("SELECT id_restaurante, nombre, direccion, telefono, maitre, telefono_maitre, otro_personal, hora_limite_fiesta, empresa_habitual FROM restaurantes WHERE id_restaurante = {$id}");	
		
		if($query->num_rows() > 0){
			$fila = $query->row();
			$data['id_restaurante'] = $id;
			$data['nombre'] = $fila->nombre;
			$data['direccion'] = $fila->direccion;
			$data['telefono'] = $fila->telefono;
			$data['maitre'] = $fila->maitre;
			$data['telefono_maitre'] = $fila->telefono_maitre;
			$data['otro_personal'] = $fila->otro_personal;
			$data['hora_limite_fiesta'] = $fila->hora_limite_fiesta;
			$data['empresa_habitual'] = $fila->empresa_habitual;
		}
		
		return $data;
	}
	
	function GetArchivosRestaurante($id)
	{
		$data = false;
		$this->load->database();
		$query = $this->db->query("SELECT id_adjunto, id_restaurante, descripcion, archivo FROM restaurantes_archivos WHERE id_restaurante = {$id}");	
		if($query->num_rows() > 0){
			$i = 0;
			foreach($query->result() as $fila){
				$data[$i]['id_adjunto'] = $fila->id_adjunto;
				$data[$i]['id_restaurante'] = $fila->id_restaurante;
				$data[$i]['descripcion'] = $fila->descripcion;
				$data[$i]['archivo'] = $fila->archivo;
				$i++;
			}
		}
		return $data;
	}
	
	function UpdateArchivoRestaurante($id, $archivo)
	{
		
		$this->load->database();
		$this->db->query("UPDATE clientes SET foto = '".$foto."' WHERE id = {$id}");	
		
	}
	
	function GetHorasDJ($id)
	{
		$data = false;
		$this->load->database();
		$query = $this->db->query("SELECT id_hora_dj, concepto, horas_dj FROM horas_djs WHERE id_cliente = {$id}");	
		if($query->num_rows() > 0){
			$i = 0;
			foreach($query->result() as $fila){
				$data[$i]['id_hora_dj'] = $fila->id_hora_dj;
				$data[$i]['concepto'] = $fila->concepto;
				$data[$i]['horas_dj'] = $fila->horas_dj;
				$i++;
			}
		}
		return $data;
	}
	
	function GetHorasAnualesDJs($anio)
	{
		$data = false;
		$this->load->database();
		
		$i=0;
		$query = $this->db->query("SELECT id FROM djs");
		if($query->num_rows() > 0){
			foreach($query->result() as $fila){
				for($mes=1;$mes<=12;$mes++){
					$query2 = $this->db->query("SELECT SUM(horas_djs.horas_dj) as total_horas FROM horas_djs, clientes WHERE horas_djs.id_cliente = clientes.id and YEAR(clientes.fecha_boda)={$anio} and MONTH(clientes.fecha_boda)={$mes} and horas_djs.id_dj={$fila->id}");
					if($query2->num_rows() > 0){
						foreach($query2->result() as $fila2){
							if($fila2->total_horas<>""){
								$data[$i]['total_horas']=$fila2->total_horas;
								$data[$i]['id_dj']=$fila->id;
								$data[$i]['mes']=$mes;

								$i++;
							}
						}
					}
				}
			}
		}
		
		
		return $data;
	}
	
	function GetFactura($id)
	{
		$data = false;
		$this->load->database();
		$query = $this->db->query("SELECT n_factura, fecha_factura, factura_pdf FROM facturas WHERE id_cliente = {$id}");	
		
		if($query->num_rows() > 0){
			$fila = $query->row();
			$data['id_cliente'] = $id;
			$data['n_factura'] = $fila->n_factura;
			$data['fecha_factura'] = $fila->fecha_factura;
			$data['factura_pdf'] = $fila->factura_pdf;
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
	
	function GetCuentas_Bancarias()
	{
		$data = false;
		$this->load->database();
		$query = $this->db->query("SELECT id_cuenta, entidad, iban, codigo_entidad, codigo_oficina, codigo_control, numero_cuenta FROM cuentas_bancarias");	
		if($query->num_rows() > 0){
			$i = 0;
			foreach($query->result() as $fila){
				$data[$i]['id_cuenta'] = $fila->id_cuenta;
				$data[$i]['entidad'] = $fila->entidad;
				$data[$i]['iban'] = $fila->iban;
				$data[$i]['codigo_entidad'] = $fila->codigo_entidad;
				$data[$i]['codigo_oficina'] = $fila->codigo_oficina;
				$data[$i]['codigo_control'] = $fila->codigo_control;
				$data[$i]['numero_cuenta'] = $fila->numero_cuenta;
				$i++;
			}
		}
		return $data;
	}
	
	function GetCaptacion()
	{
		$data = false;
		$this->load->database();
		$query = $this->db->query("SELECT id, nombre FROM canales_captacion");	
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
	
	function GetMomentos_Especiales()
	{
		$data = false;
		$this->load->database();
		$query = $this->db->query("SELECT id_momento, momento FROM bd_momentos_espec");	
		if($query->num_rows() > 0){
			$i = 0;
			foreach($query->result() as $fila){
				$data[$i]['id'] = $fila->id_momento;
				$data[$i]['momento'] = $fila->momento;
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
		if($query->num_rows() > 0){
			$i = 0;
			foreach($query->result() as $fila){
				$data[$i]['id_estado'] = $fila->id_estado;
				$data[$i]['nombre_estado'] = $fila->nombre_estado;
				$i++;
			}
		}
		return $data;
	}
	
	function GetCancionesBD($fecha_desde, $fecha_hasta, $validada)
	{
		$data = false;
		$this->load->database();
		$query = $this->db->query("SELECT id, artista, cancion, DATE_FORMAT(fecha_alta,'%d/%m/%Y') AS fecha_alta, id_cliente, validada FROM bd_canciones where fecha_alta >= '".$fecha_desde."' AND fecha_alta <= '".$fecha_hasta."' AND validada = '".$validada."' ORDER BY artista ASC");	
		if($query->num_rows() > 0){
			$i = 0;
			foreach($query->result() as $fila){
				$query2 = $this->db->query("SELECT nombre_novio, apellidos_novio, nombre_novia, apellidos_novia FROM clientes where id= '".$fila->id_cliente."'");
				foreach($query2->result() as $fila2){
					$data[$i]['nombre_novio'] = $fila2->nombre_novio;
					$data[$i]['apellidos_novio'] = $fila2->apellidos_novio;
					$data[$i]['nombre_novia'] = $fila2->nombre_novia;
					$data[$i]['apellidos_novia'] = $fila2->apellidos_novia;
				}
				$data[$i]['id'] = $fila->id;
				$data[$i]['artista'] = $fila->artista;
				$data[$i]['cancion'] = $fila->cancion;
				$data[$i]['fecha_alta'] = $fila->fecha_alta;
				$data[$i]['validada'] = $fila->validada;
				$i++;
			}
		}
		return $data;
	}
	
	function GetServicios()
	{
		$data = false;
		$this->load->database();
		$query = $this->db->query("SELECT id, nombre, descripcion, precio, precio_oferta, servicio_adicional FROM servicios");	
		if($query->num_rows() > 0){
			$i = 0;
			foreach($query->result() as $fila){
				$data[$i]['id'] = $fila->id;
				$data[$i]['nombre'] = $fila->nombre;
				$data[$i]['descripcion'] = $fila->descripcion;
				$data[$i]['precio'] = $fila->precio;
				$data[$i]['precio_oferta'] = $fila->precio_oferta;
				$data[$i]['servicio_adicional'] = $fila->servicio_adicional;
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
	
	
	function GetEquipos()
	{
		$data = false;
		$this->load->database();
		$query = $this->db->query("SELECT * FROM grupos_equipos ORDER BY nombre_grupo ASC");
		if($query->num_rows() > 0){
			$i = 0;
			foreach($query->result() as $fila){
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
	
	function GetComponentesSinAsociar()
	{
		$data = false;
		$this->load->database();
		$query = $this->db->query("SELECT * FROM componentes WHERE id_grupo IS NULL ORDER BY n_registro ASC");
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
	
	function GetComponentesAsociados()
	{
		$data = false;
		$this->load->database();
		$query = $this->db->query("SELECT * FROM componentes WHERE id_grupo IS NOT NULL");
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
	
	
	
	function GetReparaciones($str_where, $ord, $limit)
	{
		$data = false;
		$this->load->database();
		
		$query = $this->db->query("SELECT reparaciones_componentes.id_reparacion, componentes.id_componente, componentes.n_registro, componentes.nombre_componente, reparaciones_componentes.fecha_reparacion, reparaciones_componentes.reparacion FROM componentes inner join reparaciones_componentes on componentes.id_componente=reparaciones_componentes.id_componente {$str_where} ORDER BY {$ord}   {$limit}");
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
		$query = $this->db->query("SELECT id, nombre, descripcion, precio, precio_oferta, servicio_adicional FROM servicios WHERE id = {$id}");	
		if($query->num_rows() > 0){
			$fila = $query->row();	
			$data['id'] = $fila->id;
			$data['nombre'] = $fila->nombre;
			$data['descripcion'] = $fila->descripcion;
			$data['precio'] = $fila->precio;
			$data['precio_oferta'] = $fila->precio_oferta;
			$data['servicio_adicional'] = $fila->servicio_adicional;
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
		if(isset($data['servicio_adicional'])){
			$data['servicio_adicional']='S';
		}else{
			$data['servicio_adicional']='N';
		}
		$this->load->database();
		$query = $this->db->query("UPDATE servicios SET nombre = '".str_replace("'", "&#39;",$data['nombre'])."', precio = '".$data['precio']."', precio_oferta = '".$data['precio_oferta']."', servicio_adicional = '".$data['servicio_adicional']."' WHERE id = {$id}");	
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
	
	
	
	
	function InsertDJ($data)
	{	
	
		$this->load->database();
		$this->load->library('encrypt');
		$data['clave'] = $this->encrypt->encode($data['clave']);
		$query = $this->db->query("INSERT INTO djs (nombre, telefono, email, clave) VALUES ('".str_replace("'", "&#39;",$data['nombre'])."', '".stripslashes(str_replace("'", "&#39;",$data['telefono']))."', '".$data['email']."', '".str_replace("'", "&#39;",$data['clave'])."')");	
		return $this->db->insert_id();
	}
	function UpdateDJ($data)
	{
		
		$this->load->database();
		$this->load->library('encrypt');
		$data['clave'] = $this->encrypt->encode($data['clave']);
		$query = $this->db->query("UPDATE djs SET nombre = '".str_replace("'", "&#39;",$data['nombre'])."', telefono = '".stripslashes(str_replace("'", "&#39;",$data['telefono']))."', email = '".$data['email']."', clave = '".str_replace("'", "&#39;",$data['clave'])."' WHERE id = ".$data['id']."");	
		
	}
	function UpdatefotoDJ($id, $foto)
	{
		
		$this->load->database();
		$this->db->query("UPDATE djs SET foto = '".$foto."' WHERE id = {$id}");	
		
	}
	function DeleteDJ($id)
	{
		
		$this->load->database();
		$query = $this->db->query("SELECT foto FROM djs WHERE id = {$id}");	
		$fila = $query->row();	
		if($fila->foto != ""){
			$foto = './uploads/djs/'.$fila->foto;
			//echo $foto ;
			if (file_exists($foto)) { unlink ($foto); }
		}
		
		$query = $this->db->query("SELECT contrato_pdf FROM contratos_djs WHERE id_dj = {$id}");
		if($query->num_rows() > 0){
			foreach($query->result() as $fila){	
				if($fila->contrato_pdf != ""){
					$contrato = './uploads/contratos_djs/'.$fila->contrato_pdf;
					//echo $foto ;
					if (file_exists($contrato)) { unlink ($contrato); }
				}
			}
		}
		
		$query = $this->db->query("SELECT nomina_pdf FROM nominas_djs WHERE id_dj = {$id}");	
		if($query->num_rows() > 0){
			foreach($query->result() as $fila){	
				if($fila->nomina_pdf != ""){
					$nomina = './uploads/nominas_djs/'.$fila->nomina_pdf;
					//echo $foto ;
					if (file_exists($nomina)) { unlink ($nomina); }
				}
			}
		}
		
		$this->db->query("DELETE FROM djs WHERE id = {$id}");
		$this->db->query("DELETE FROM contratos_djs WHERE id_dj = {$id}");
		$this->db->query("DELETE FROM nominas_djs WHERE id_dj = {$id}");	
	 }
	function GetDJs()
	{
		$data = false;
		$this->load->database();
		$this->load->library('encrypt');
		$query = $this->db->query("SELECT id, nombre, telefono, email, clave, foto FROM djs");	
		if($query->num_rows() > 0){
			$i = 0;
			foreach($query->result() as $fila){
				
				/*$this->load->library('encrypt');
				$query = $this->db->query("UPDATE djs SET clave = '" . $this->encrypt->encode($fila->clave) . "' WHERE id = '" . $fila->id . "'");*/
				
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
	
	
	function InsertContratoDJ($data)
	{	
		$this->load->database();			
		$this->db->insert('contratos_djs', $data);	
	}
	
	function InsertNominaDJ($data)
	{	
		$this->load->database();			
		$this->db->insert('nominas_djs', $data);	
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
	
	function InsertComercial($data)
	{	
	
		$this->load->database();
		$this->load->library('encrypt');
		$data['clave'] = $this->encrypt->encode($data['clave']);
		$query = $this->db->query("INSERT INTO comerciales (nombre, telefono, email, clave, solo_eventos, id_oficina) VALUES ('".str_replace("'", "&#39;",$data['nombre'])."', '".stripslashes(str_replace("'", "&#39;",$data['telefono']))."', '".$data['email']."', '".str_replace("'", "&#39;",$data['clave'])."', '".$data['solo_eventos']."', '".$data['oficina']."')");	
		return $this->db->insert_id();
	}
	
	function UpdatefotoComercial($id, $foto)
	{
		
		$this->load->database();
		$this->db->query("UPDATE comerciales SET foto = '".$foto."' WHERE id = {$id}");	
		
	}
	
	function UpdateComercial($data)
	{
		
		$this->load->database();
		$this->load->library('encrypt');
		$data['clave'] = $this->encrypt->encode($data['clave']);
		$query = $this->db->query("UPDATE comerciales SET nombre = '".str_replace("'", "&#39;",$data['nombre'])."', telefono = '".stripslashes(str_replace("'", "&#39;",$data['telefono']))."', email = '".$data['email']."', clave = '".str_replace("'", "&#39;",$data['clave'])."', solo_eventos = '".str_replace("'", "&#39;",$data['solo_eventos'])."' , id_oficina = '".$data['id_oficina']."' WHERE id = ".$data['id']."");	
		
	}

	function DeleteComercial($id)
	{
		
		$this->load->database();
		$query = $this->db->query("SELECT foto FROM comerciales WHERE id = {$id}");	
		$fila = $query->row();	
		if($fila->foto != ""){
			$foto = './uploads/comerciales/'.$fila->foto;
			//echo $foto ;
			if (file_exists($foto)) { unlink ($foto); }
		}
		
		$this->db->query("DELETE FROM comerciales WHERE id = {$id}");
	 }
	
	function GetComerciales()
	{
		$data = false;
		$this->load->database();
		$this->load->library('encrypt');
		$query = $this->db->query("SELECT id, nombre, telefono, email, clave, foto, solo_eventos, id_oficina FROM comerciales");	
		if($query->num_rows() > 0){
			$i = 0;
			foreach($query->result() as $fila){
				
				/*$this->load->library('encrypt');
				$query = $this->db->query("UPDATE djs SET clave = '" . $this->encrypt->encode($fila->clave) . "' WHERE id = '" . $fila->id . "'");*/
				
				$query2 = $this->db->query("SELECT nombre FROM oficinas WHERE id_oficina='".$fila->id_oficina."'");
				foreach($query2->result() as $fila2){
					$data[$i]['nombre_oficina']=$fila2->nombre;
				}
				
				$data[$i]['id'] = $fila->id;
				$data[$i]['nombre'] = $fila->nombre;
				$data[$i]['telefono'] = $fila->telefono;
				$data[$i]['email'] = $fila->email;
				$data[$i]['clave']=$this->encrypt->decode($fila->clave);
				//$data[$i]['clave'] = $fila->clave;
				$data[$i]['foto'] = $fila->foto;
				$data[$i]['solo_eventos'] = $fila->solo_eventos;
				$data[$i]['id_oficina'] = $fila->id_oficina;
				$i++;
			}
		}
		return $data;
	}
	
	function GetComercial($id)
	{
		$data = false;
		$this->load->database();
		$this->load->library('encrypt');
		$query = $this->db->query("SELECT id, nombre, telefono, email, clave, foto, solo_eventos FROM comerciales WHERE id = {$id}");	
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
				$data[$i]['solo_eventos'] = $fila->solo_eventos;
				$i++;
			}
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
	
	function GetEquiposDisponibles($id_cliente)
	{
		$data = false;
		$this->load->database();
		$query = $this->db->query("SELECT DATE_FORMAT(fecha_boda, '%Y-%m-%d') as fecha_boda FROM clientes WHERE id = ({$id_cliente})");	
		if($query->num_rows() > 0){
			$i = 0;
			foreach($query->result() as $fila){				
				$fecha_boda = $fila->fecha_boda;
				//$data[$i]['id_grupo'] = 1;
				//$data[$i]['nombre_grupo'] = $fila->fecha_boda;
				$i++;
			}
		}
		
		//////EL PROBLEMA ES LA COMPARACIÓN CON LA HORA EN EL CAMPO FECHA BODA//////////
		$query = $this->db->query("SELECT id_grupo, nombre_grupo FROM grupos_equipos WHERE id_grupo NOT IN (SELECT equipo_componentes FROM clientes WHERE DATE(fecha_boda)= '".$fecha_boda."' AND equipo_componentes IS NOT NULL) AND id_grupo NOT IN (SELECT equipo_luces FROM clientes WHERE DATE(fecha_boda)= '".$fecha_boda."' AND equipo_luces IS NOT NULL) AND id_grupo NOT IN (SELECT equipo_extra1 FROM clientes WHERE DATE(fecha_boda)= '".$fecha_boda."' AND equipo_extra1 IS NOT NULL) AND id_grupo NOT IN (SELECT equipo_extra2 FROM clientes WHERE DATE(fecha_boda)= '".$fecha_boda."' AND equipo_extra2 IS NOT NULL) ORDER BY nombre_grupo ASC");
		if($query->num_rows() > 0){
				$i = 0;
				foreach($query->result() as $fila){
					$data[$i]['id_grupo'] = $fila->id_grupo;
					$data[$i]['nombre_grupo'] = $fila->nombre_grupo;
					$i++;
				}
			}
		
		return $data;
	}
	
	function GetPagos($cliente_id)
	{
		$data = array();
		$this->load->database();
		$query = $this->db->query("SELECT valor, fecha FROM pagos WHERE cliente_id = {$cliente_id } ORDER BY fecha ASC");	
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
	
	function GetEventos()
	{
		$data = false;
		$this->load->database();
		$query = $this->db->query("SELECT id_evento, nombre_evento FROM eventos");	
		if($query->num_rows() > 0){
			$i = 0;
			foreach($query->result() as $fila){
				$data[$i]['id_evento'] = $fila->id_evento;
				$data[$i]['nombre_evento'] = $fila->nombre_evento;
				$i++;
			}
		}
		return $data;
	}
	
	function GetDescuentos()
	{
		$data = false;
		$this->load->database();
		$query = $this->db->query("SELECT id_descuento, nombre, servicios, fecha_desde, fecha_hasta, importe FROM descuento_presupuesto_eventos");	
		if($query->num_rows() > 0){
			$i = 0;
			foreach($query->result() as $fila){
				$data[$i]['id_descuento'] = $fila->id_descuento;
				$data[$i]['nombre'] = $fila->nombre;
				$data[$i]['servicios'] = $fila->servicios;
				$data[$i]['fecha_desde'] = $fila->fecha_desde;
				$data[$i]['fecha_hasta'] = $fila->fecha_hasta;
				$data[$i]['importe'] = $fila->importe;
				$i++;
			}
		}
		return $data;
	}
	
	function InsertOficina($data)
	{	
		$this->load->database();
		$query = $this->db->query("INSERT INTO oficinas (nombre, direccion, poblacion, cp, telefono, movil, fax, email, web) VALUES ('".str_replace("'", "&#39;",$data['nombre'])."', '".stripslashes(str_replace("'", "&#39;",$data['direccion']))."', '".stripslashes(str_replace("'", "&#39;",$data['poblacion']))."', '".stripslashes(str_replace("'", "&#39;",$data['cp']))."', '".stripslashes(str_replace("'", "&#39;",$data['telefono']))."', '".stripslashes(str_replace("'", "&#39;",$data['movil']))."', '".stripslashes(str_replace("'", "&#39;",$data['fax']))."', '".$data['email']."', '".stripslashes(str_replace("'", "&#39;",$data['web']))."')");	
		return $this->db->insert_id();
	}
	
	function UpdateOficina($data)
	{
		
		$this->load->database();
		$query = $this->db->query("UPDATE oficinas SET nombre = '".str_replace("'", "&#39;",$data['nombre'])."', direccion = '".str_replace("'", "&#39;",$data['direccion'])."', poblacion = '".str_replace("'", "&#39;",$data['poblacion'])."', cp = '".str_replace("'", "&#39;",$data['cp'])."', telefono = '".stripslashes(str_replace("'", "&#39;",$data['telefono']))."', movil = '".str_replace("'", "&#39;",$data['movil'])."', fax = '".str_replace("'", "&#39;",$data['fax'])."', email = '".$data['email']."', web = '".stripslashes(str_replace("'", "&#39;",$data['web']))."' WHERE id_oficina = ".$data['id_oficina']."");	
		
	}
	
	function UpdateLogoMailOficina($id, $foto)
	{
		
		$this->load->database();
		$query = $this->db->query("SELECT logo_mail FROM oficinas WHERE id_oficina = {$id}");	
		$fila = $query->row();	
		if($fila->logo_mail != ""){
			$logo_mail = './uploads/oficinas/'.$fila->logo_mail;
			//echo $foto ;
			if (file_exists($logo_mail)) { unlink ($logo_mail); }
		}
		$this->db->query("UPDATE oficinas SET logo_mail = '".$foto."' WHERE id_oficina = {$id}");	
		
	}
	
	function DeleteOficina($id)
	{
		
		$this->load->database();
		$query = $this->db->query("SELECT logo_mail FROM oficinas WHERE id_oficina = {$id}");	
		$fila = $query->row();	
		if($fila->logo_mail != ""){
			$logo_mail = './uploads/oficinas/'.$fila->logo_mail;
			//echo $foto ;
			if (file_exists($logo_mail)) { unlink ($logo_mail); }
		}
		
		$this->db->query("DELETE FROM oficinas WHERE id_oficina = {$id}");
	 }
	
	function GetOficinas()
	{
		$data = false;
		$this->load->database();
		$query = $this->db->query("SELECT id_oficina, nombre, direccion, poblacion, cp, telefono, movil, fax, email, web, logo_mail FROM oficinas");	
		if($query->num_rows() > 0){
			$i = 0;
			foreach($query->result() as $fila){
				$data[$i]['id_oficina'] = $fila->id_oficina;
				$data[$i]['nombre'] = $fila->nombre;
				$data[$i]['direccion'] = $fila->direccion;
				$data[$i]['poblacion'] = $fila->poblacion;
				$data[$i]['cp'] = $fila->cp;
				$data[$i]['telefono'] = $fila->telefono;
				$data[$i]['movil'] = $fila->movil;
				$data[$i]['fax'] = $fila->fax;
				$data[$i]['email'] = $fila->email;
				$data[$i]['web'] = $fila->web;
				$data[$i]['logo_mail'] = $fila->logo_mail;
				$i++;
			}
		}
		return $data;
	}
	
	function GetPreguntasEncuesta()
	{
		$data = false;
		$this->load->database();
		$query = $this->db->query("SELECT id_pregunta, pregunta, importe_descuento FROM preguntas_encuesta ORDER BY id_pregunta ASC");	
		if($query->num_rows() > 0){
			$i = 0;
			foreach($query->result() as $fila){
				$data[$i]['id_pregunta'] = $fila->id_pregunta;
				$data[$i]['pregunta'] = $fila->pregunta;
				$data[$i]['importe_descuento'] = $fila->importe_descuento;
				$i++;
			}
		}
		return $data;
	}
	
	function GetRespuestasPreguntas()
	{
		$data = false;
		$this->load->database();
		$query = $this->db->query("SELECT id_respuesta, id_pregunta, respuesta FROM respuestas_encuesta ORDER BY id_respuesta ASC");	
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
	
	
	function GetEstadisticaServicios($fecha_desde, $fecha_hasta)
	{
		$data = false;
		$this->load->database();
		
		$arr_serv_keys=array();
		
		$query=$this->db->query("SELECT servicios FROM clientes WHERE fecha_boda>='".$fecha_desde." 00:00:00' and fecha_boda<='".$fecha_hasta." 23:59:59'");
		foreach($query->result() as $fila){
			$arr_servicios = unserialize($fila->servicios );
			foreach(array_keys($arr_servicios) as $s)
			{
				array_push($arr_serv_keys,$s);
			}
		}
		
		$repeated = array();
 
		foreach( (array)$arr_serv_keys as $id )
		{
			$inArray = false;
			
			$result = mysql_query("select * from servicios where id='".$id."'");
			while ($fila = mysql_fetch_assoc($result)) {
				$value=$fila['nombre'];
			}
		
			foreach( $repeated as $i => $rItem )
			{
				if( $rItem['servicio'] === $value )
				{
					$inArray = true;
					++$repeated[$i]['veces'];
				}					
			}
		
			 if( false === $inArray )
			{
				$i = count($repeated);
				$repeated[$i] = array();
				$repeated[$i]['servicio'] = $value;
				$repeated[$i]['veces'] = 1;
			}
		}
		
		//Ordenamos de mayor a menor por el número de veces que se contrata un servicio
		foreach($repeated as $canales=>$campo){
			$numero[$canales]=$campo['veces'];
		}
		
		/*if(count($repeated)>0){
			array_multisort($numero, SORT_DESC, $repeated);
		}*/
		
		return $repeated;
	}
	
	function GetEstadisticaCanalesCaptacion($fecha_desde, $fecha_hasta)
	{
		$data = false;
		$this->load->database();
		
		$i = 0;
		$query=$this->db->query("SELECT id, nombre FROM canales_captacion");
		foreach($query->result() as $fila){
			$query2=$this->db->query("SELECT COUNT(canal_captacion) as numero FROM clientes WHERE fecha_boda>='".$fecha_desde." 00:00:00' and fecha_boda<='".$fecha_hasta." 23:59:59' AND canal_captacion='".$fila->id."'");
			foreach($query2->result() as $fila2){
				$data[$i]['canal'] = $fila->nombre;
				$data[$i]['numero'] = $fila2->numero;
				$i++;
			}
		}
		
		//Ordenamos de mayor a menor por el número de veces que se ha utilizado ese canal de captación
		foreach($data as $canales=>$campo){
			$numero[$canales]=$campo['numero'];
		}
		array_multisort($numero, SORT_DESC, $data);
		
		return $data;
	}
	
	function GetEstadisticaComerciales($fecha_desde, $fecha_hasta)
	{
		$data = false;
		$this->load->database();
		
		$i = 0;
		$query=$this->db->query("SELECT id, nombre FROM comerciales");
		foreach($query->result() as $fila){
			
			$query2 = $this->db->query("SELECT COUNT(id_solicitud) as num FROM solicitudes WHERE fecha>='".$fecha_desde." 00:00:00' AND fecha<='".$fecha_hasta." 23:59:59' AND id_comercial=".$fila->id."");
		if($query2->num_rows() > 0){
			foreach($query2->result() as $fila2)
			{
				$num_presupuestos_totales=$fila2->num;
			}
		}
			
			$j=0;
			$query2 = $this->db->query("SELECT id_estado, nombre_estado FROM estados_solicitudes");
			foreach($query2->result() as $fila2){
				$porcentaje[$j]=0;
				$num_presupuestos=0;
				
				$query3 = $this->db->query("SELECT COUNT(id_solicitud) as num FROM solicitudes WHERE fecha>='".$fecha_desde." 00:00:00' AND fecha<='".$fecha_hasta." 23:59:59' AND estado_solicitud=".$fila2->id_estado." AND id_comercial=".$fila->id."");
				if($query3->num_rows() > 0){
					foreach($query3->result() as $fila3)
					{
						$num_presupuestos=$fila3->num;
					}
					if($num_presupuestos<>0)
					{
						$porcentaje[$j]=number_format(($num_presupuestos*100)/$num_presupuestos_totales,2);
					}
					$nombre_e[$j]=$fila2->nombre_estado;
					
					$data[$i]['comercial']=$fila->nombre;
					$data[$i][$nombre_e[$j]]=$nombre_e[$j];
					$data[$i][$nombre_e[$j].'p']=$porcentaje[$j];
					$data[$i]['num_presupuestos']=$num_presupuestos_totales;
					
					
					$j++;
				}
			}
			
			$num = $this->db->query("SELECT COUNT(id_estado) as num_estados FROM estados_solicitudes");
			foreach($num->result() as $fila_num)
			{
				$data[$i]['num_estados']=$fila_num->num_estados;
			}
			
			$i++;
		}
		
		return $data;
	}
	
	function GetEstadisticaEncuestas($fecha_desde, $fecha_hasta)
	{
		$data = false;
		$this->load->database();
		
		$i = 0;
		$query=$this->db->query("SELECT DISTINCT(id_pregunta) as id_pregunta from encuestas_solicitudes WHERE fecha>='".$fecha_desde." 00:00:00' AND fecha<='".$fecha_hasta." 23:59:59' ORDER BY id_pregunta ASC");
		foreach($query->result() as $fila){
			$id_pregunta=$fila->id_pregunta;
			
			$j=0;
			$query2=$this->db->query("SELECT id_respuesta from respuestas_encuesta WHERE id_pregunta='".$id_pregunta."'");
			foreach($query2->result() as $fila2){
				$id_respuesta[$j]=$fila2->id_respuesta;
				$data[$i][$id_respuesta[$j]]=$id_respuesta[$j];
				
				
				$query3=$this->db->query("SELECT COUNT(id_respuesta) as num_respuestas from encuestas_solicitudes WHERE id_respuesta='".$id_respuesta[$j]."'");
				foreach($query3->result() as $fila3){
					//$num_respuestas[$j][$h]=$fila3->num_respuestas;
					$data[$i][$id_respuesta[$j].'n']=$fila3->num_respuestas;
					
					$query4=$this->db->query("SELECT COUNT(id_respuesta) as num_total_respuestas from encuestas_solicitudes WHERE id_pregunta='".$id_pregunta."'");
					foreach($query4->result() as $fila4){
						$data[$i][$id_respuesta[$j].'p']=number_format(($fila3->num_respuestas*100)/$fila4->num_total_respuestas,2);
					}
				}
				
				$j++;
			}
			
			$data[$i]['id_pregunta']=$id_pregunta;
			//$data[$i]['pregunta']=$pregunta;
			//$data[$i]['num_total_respuestas']=$num_total_respuestas;
			
			//$data[$i][$respuesta[$j]]=$respuesta[$j];
			//$data[$i][$respuesta[$j].'p']=$porcentaje[$j];
			//$data[$i]['num_presupuestos']=$num_presupuestos_totales;
			
			
			$i++;
		}
		
		
		return $data;
	}
	
	function GetEventosView($fecha_desde, $fecha_hasta, $oficina)
	{
		$data = false;
		$this->load->database();
		
		$query=$this->db->query("SELECT id, DATE_FORMAT(fecha_boda, '%d-%m-%Y') as fecha_bodaa, fecha_boda, nombre_novio, nombre_novia, id_tipo_cliente, restaurantes.nombre AS restaurante, restaurantes.direccion AS direccion_restaurante, DATE_FORMAT(fecha_boda, '%H:%i') as hora_boda, servicios, dj FROM clientes INNER JOIN restaurantes ON clientes.id_restaurante=restaurantes.id_restaurante WHERE fecha_boda>='".$fecha_desde." 00:00:00' and fecha_boda<='".$fecha_hasta." 23:59:59' and id_oficina='".$oficina."' order by fecha_boda ASC");
		if($query->num_rows() > 0){
			$i = 0;
			foreach($query->result() as $fila){
				$data[$i]['id'] = $fila->id;
				$data[$i]['fecha_boda'] = $fila->fecha_bodaa;
				$data[$i]['nombre_novio'] = $fila->nombre_novio;
				$data[$i]['nombre_novia'] = $fila->nombre_novia;
				$data[$i]['id_tipo_cliente'] = $fila->id_tipo_cliente;
				$data[$i]['restaurante'] = $fila->restaurante;
				$data[$i]['direccion_restaurante'] = $fila->direccion_restaurante;
				$data[$i]['hora_boda'] = $fila->hora_boda;
				$data[$i]['servicios'] = $fila->servicios;
				$data[$i]['dj'] = $fila->dj;
				
				$i++;
			}
		}
		
		return $data;
	}
	
	
	function GetEventosTotalesView($fecha_desde, $fecha_hasta, $oficina)
	{
		$data = false;
		$this->load->database();
		
		$query=$this->db->query("SELECT COUNT(id) as eventos_totales FROM clientes WHERE fecha_boda>='".$fecha_desde." 00:00:00' and fecha_boda<='".$fecha_hasta." 23:59:59'");
		foreach($query->result() as $fila){
				$data[0]['eventos_totales'] = $fila->eventos_totales;
		}
		
		$query=$this->db->query("SELECT COUNT(id) as eventos FROM clientes WHERE fecha_boda>='".$fecha_desde." 00:00:00' and fecha_boda<='".$fecha_hasta." 23:59:59' and id_oficina='".$oficina."'");
		foreach($query->result() as $fila){
				$data[0]['eventos'] = $fila->eventos;
				$data[0]['id_oficina'] = $oficina;
		}
		
		return $data;
	}
	
	function GetContabilidadClientes($fecha_desde, $fecha_hasta, $oficina)
	{
		$data = false;
		$this->load->database();
		
		$query=$this->db->query("SELECT id, DATE_FORMAT(fecha_boda, '%d-%m-%Y') as fecha_bodaa, fecha_boda, nombre_novio, nombre_novia, servicios, descuento FROM clientes WHERE fecha_boda>='".$fecha_desde." 00:00:00' and fecha_boda<='".$fecha_hasta." 23:59:59' and id_oficina='".$oficina."' order by fecha_boda ASC");
		if($query->num_rows() > 0){
			$i = 0;
			foreach($query->result() as $fila){
				$data[$i]['id'] = $fila->id;
				$data[$i]['fecha_boda'] = $fila->fecha_bodaa;
				$data[$i]['nombre_novio'] = $fila->nombre_novio;
				$data[$i]['nombre_novia'] = $fila->nombre_novia;
				$data[$i]['servicios'] = $fila->servicios;
				$data[$i]['descuento'] = $fila->descuento;
				
				$data[$i]['senal'] = 0;
				$data[$i]['50%'] = 0;
				$data[$i]['final'] = 0;
				
				$data[$i]['fecha_senal'] = "";
				$data[$i]['fecha_50%'] = "";
				$data[$i]['fecha_final'] = "";
				$data[$i]['tipo_senal'] = "";
				$data[$i]['tipo_50%'] = "";
				$data[$i]['tipo_final'] = "";
				
				$data[$i]['factura'] = "";
				
				$query2=$this->db->query("SELECT factura_pdf FROM facturas WHERE id_cliente='".$fila->id."'");
				if($query2->num_rows() > 0){
					foreach($query2->result() as $fila2){
						$data[$i]['factura'] = $fila2->factura_pdf;
					}
				}
				
				$query2=$this->db->query("SELECT valor, fecha as fecha_orden, DATE_FORMAT(fecha, '%d-%m-%Y') as fecha, tipo FROM pagos WHERE cliente_id='".$fila->id."' order by fecha_orden ASC");
				if($query2->num_rows() > 0){
					$j = 0;
					foreach($query2->result() as $fila2){
						if($data[$i]['senal'] == ""){
							$data[$i]['senal']=$fila2->valor;
							$data[$i]['fecha_senal']=$fila2->fecha;
							$data[$i]['tipo_senal']=$fila2->tipo;
						}
						else if($data[$i]['50%'] == ""){
							$data[$i]['50%']=$fila2->valor;
							$data[$i]['fecha_50%']=$fila2->fecha;
							$data[$i]['tipo_50%']=$fila2->tipo;
						}
						else{
							$data[$i]['final']=$fila2->valor;
							$data[$i]['fecha_final']=$fila2->fecha;
							$data[$i]['tipo_final']=$fila2->tipo;
						}
						
						$j++;
					}
				}
						
						$i++;
			}
		}
		
		return $data;
	}
	
	function GetContabilidadTotal($fecha_desde, $fecha_hasta)
	{
		$data = false;
		$this->load->database();
		
		$query=$this->db->query("SELECT id, servicios, descuento FROM clientes WHERE fecha_boda>='".$fecha_desde." 00:00:00' and fecha_boda<='".$fecha_hasta." 23:59:59'");
		if($query->num_rows() > 0){
			$i = 0;
			foreach($query->result() as $fila){
				$data[$i]['id']=$fila->id;
				$data[$i]['servicios']=$fila->servicios;
				$data[$i]['descuento']=$fila->descuento;
				
				$data[$i]['senal'] = 0;
				$data[$i]['50%'] = 0;
				$data[$i]['final'] = 0;
				
				$query2=$this->db->query("SELECT valor, fecha as fecha_orden, DATE_FORMAT(fecha, '%d-%m-%Y') as fecha FROM pagos WHERE cliente_id='".$fila->id."' order by fecha_orden ASC");
				if($query2->num_rows() > 0){
					$j = 0;
					foreach($query2->result() as $fila2){
						if($data[$i]['senal'] == 0){
							$data[$i]['senal']=$fila2->valor;
							$data[$i]['fecha_senal']=$fila2->fecha;
						}
						else if($data[$i]['50%'] == 0){
							$data[$i]['50%']=$fila2->valor;
							$data[$i]['fecha_50%']=$fila2->fecha;
						}
						else{
							$data[$i]['final']=$fila2->valor;
							$data[$i]['fecha_final']=$fila2->fecha;
						}
						
						$j++;
					}
				}
				
				$i++;
			}
		}
		
		return $data;
	}
	
	function GetCuentasBancarias()
	{
		$data = false;
		$this->load->database();
		$query = $this->db->query("SELECT id_cuenta, entidad, IBAN, codigo_entidad, codigo_oficina, codigo_control, numero_cuenta FROM cuentas_bancarias");	
		if($query->num_rows() > 0){
			$i = 0;
			foreach($query->result() as $fila){
				$data[$i]['id_cuenta'] = $fila->id_cuenta;
				$data[$i]['entidad'] = $fila->entidad;
				$data[$i]['IBAN'] = $fila->IBAN;
				$data[$i]['codigo_entidad'] = $fila->codigo_entidad;
				$data[$i]['codigo_oficina'] = $fila->codigo_oficina;
				$data[$i]['codigo_control'] = $fila->codigo_control;
				$data[$i]['numero_cuenta'] = $fila->numero_cuenta;
				$i++;
			}
		}
		return $data;
	}
	
	function InsertFacturaManual($data)
	{	
	
		$this->load->database();
		$query = $this->db->query("INSERT INTO facturas_manuales (n_factura, importe_bruto, IVA, importe_neto, fecha_factura, observaciones, tipo_factura) VALUES ('".$data['n_factura']."', '".$data['importe_bruto']."', '".$data['iva']."', '".$data['importe_neto']."', '".$data['fecha_factura']."', '".str_replace("'", "&#39;",$data['observaciones'])."', '".$data['tipo_factura']."')");	
		return $this->db->insert_id();
	}
	
	function GetFacturaManual($id_factura)
	{
		$data = false;
		$this->load->database();
		$query = $this->db->query("SELECT id_factura, n_factura, importe_bruto, IVA, importe_neto, fecha_factura, observaciones, tipo_factura FROM facturas_manuales WHERE id_factura = {$id_factura}");	
		if($query->num_rows() > 0){
			$fila = $query->row();
			$data['id_factura'] = $fila->id_factura;
			$data['n_factura'] = $fila->n_factura;
			$data['importe_bruto'] = $fila->importe_bruto;
			$data['iva'] = $fila->IVA;
			$data['importe_neto'] = $fila->importe_neto;
			$data['fecha_factura'] = $fila->fecha_factura;
			$data['observaciones'] = $fila->observaciones;
			$data['tipo_factura'] = $fila->tipo_factura;
		}
		return $data;
	}
	
	function GetFacturas($fecha_desde, $fecha_hasta)
	{
		$data = false;
		$this->load->database();
		
		$i = 0;
		$query=$this->db->query("SELECT id_factura, n_factura, importe_bruto, IVA, importe_neto, fecha_factura, tipo_factura FROM facturas_manuales WHERE fecha_factura>='".$fecha_desde." 00:00:00' and fecha_factura<='".$fecha_hasta." 23:59:59'");
		if($query->num_rows() > 0){
			foreach($query->result() as $fila){
				$data[$i]['id_factura']=$fila->id_factura;
				$data[$i]['n_factura']=$fila->n_factura;
				$data[$i]['importe_bruto']=number_format($fila->importe_bruto,2,",",".");
				$data[$i]['iva']=number_format($fila->IVA,2,",",".");
				$data[$i]['importe_neto']=number_format($fila->importe_neto,2,",",".");
				$data[$i]['fecha_factura']=$fila->fecha_factura;
				$data[$i]['tipo_factura']=$fila->tipo_factura;
				
				$i++;
			}
		}
		
		$query=$this->db->query("SELECT n_factura, DATE_FORMAT(fecha_factura, '%Y-%m-%d') as fecha_factura, id_cliente FROM facturas WHERE fecha_factura>='".$fecha_desde." 00:00:00' and fecha_factura<='".$fecha_hasta." 23:59:59'");
		if($query->num_rows() > 0){
			foreach($query->result() as $fila){
				$data[$i]['id_factura']=$fila->id_cliente;
				$data[$i]['n_factura']=$fila->n_factura;
				$data[$i]['fecha_factura']=$fila->fecha_factura;
				
				$query2=$this->db->query("SELECT servicios, descuento FROM clientes WHERE id='".$fila->id_cliente."'");
				if($query2->num_rows() > 0){
					foreach($query2->result() as $fila2){
						$arr_servicios = unserialize( $fila2->servicios );
						$total = array_sum($arr_servicios);
						$descuento=$fila2->descuento;
						$importe_neto=$total-$descuento;
						$iva=($importe_neto)-(($importe_neto)/1.21);
						$importe_bruto=($importe_neto-$iva);
						$importe_neto=number_format($importe_neto,2,",",".");
						$iva=number_format($iva,2,",",".");
						$importe_bruto=number_format($importe_bruto,2,",",".");
					}
				}
				
				$data[$i]['importe_bruto']=$importe_bruto;
				$data[$i]['iva']=$iva;
				$data[$i]['importe_neto']=$importe_neto;
				$data[$i]['tipo_factura']='Factura Cliente';
				
				$i++;
			}
		}
		
		return $data;
	}
	
	function InsertPartidaPresupuestaria($data)
	{	
	
		$this->load->database();
		$query = $this->db->query("INSERT INTO partidas_presupuestarias (concepto, importe, ano) VALUES ('".$data['concepto']."', '".$data['importe']."', '".$data['ano']."')");	
		return $this->db->insert_id();
	}
	
	function GetPartidaPresupuestaria($id_partida)
	{
		$data = false;
		$this->load->database();
		$query = $this->db->query("SELECT id_partida, concepto, importe, ano FROM partidas_presupuestarias WHERE id_partida = {$id_partida}");	
		if($query->num_rows() > 0){
			$fila = $query->row();
			$data['id_partida'] = $fila->id_partida;
			$data['concepto'] = $fila->concepto;
			$data['importe'] = $fila->importe;
			$data['año'] = $fila->ano;
		}
		return $data;
	}
	
	function GetPartidasPresupuestarias($fecha_desde, $fecha_hasta)
	{
		$data = false;
		$this->load->database();
		
		$query=$this->db->query("SELECT id_partida, concepto, importe, ano FROM partidas_presupuestarias WHERE ano>='".$fecha_desde."' AND ano<='".$fecha_hasta."'");
		if($query->num_rows() > 0){
			$i = 0;
			foreach($query->result() as $fila){
				$data[$i]['id_partida']=$fila->id_partida;
				$data[$i]['concepto']=$fila->concepto;
				$data[$i]['importe']=$fila->importe;
				$data[$i]['año']=$fila->ano;
				
				$i++;
			}
		}
		return $data;
	}
	
	function GetPartidasPresupuestariasAno($id_movimiento)
	{
		$data = false;
		$this->load->database();
		
		$query=$this->db->query("SELECT fecha FROM movimientos_cuentas WHERE id_movimiento='".$id_movimiento."'");
			foreach($query->result() as $fila){
				$fecha_movimiento=$fila->fecha;
			}
		
		
		$query=$this->db->query("SELECT id_partida, concepto, importe, ano FROM partidas_presupuestarias WHERE ano>='".substr($fecha_movimiento,0,4)."'");
		if($query->num_rows() > 0){
			$i = 0;
			foreach($query->result() as $fila){
				$data[$i]['id_partida']=$fila->id_partida;
				$data[$i]['concepto']=$fila->concepto;
				$data[$i]['importe']=$fila->importe;
				$data[$i]['año']=$fila->ano;
				
				$i++;
			}
		}
		return $data;
	}
	
	function BuscaPartidasPresupuestariasMovimientos($fecha_desde,$fecha_hasta)
	{
		$data = false;
		$this->load->database();
		
		$query=$this->db->query("SELECT partida_presupuestaria, importe, DATE_FORMAT(fecha,'%Y') as ano from movimientos_cuentas where fecha>='".$fecha_desde."-01-01' and fecha<='".$fecha_hasta."-31-12' AND partida_presupuestaria<>''");
		if($query->num_rows() > 0){
			$i = 0;
			foreach($query->result() as $fila){
				$data[$i]['partida_presupuestaria']=$fila->partida_presupuestaria;
				$data[$i]['importe']=$fila->importe;
				$data[$i]['año']=$fila->ano;
				$data[$i]['c']="SELECT partida_presupuestaria, importe, DATE_FORMAT(fecha,'%Y') as ano from movimientos_cuentas where fecha>='".$fecha_desde."-01-01' and fecha<='".$fecha_hasta."-31-12' AND partida_presupuestaria<>''";
				$i++;
			}
		}
		
		return $data;
	}
	
	function InsertMovimiento($data)
	{	
		if($data['tipo_movimiento']=="ingreso"){ //Nos da igual la partida presupuestaria
			$data['partida_presupuestaria']="";
		}
		if($data['lugar']=="cuenta"){ //Nos da igual la oficina
			$data['oficina']="";
		}
		$this->load->database();
		$query = $this->db->query("INSERT INTO movimientos_cuentas (tipo_movimiento, lugar, tipo_lugar, id_oficina, fecha, concepto, importe, partida_presupuestaria) VALUES ('".$data['tipo_movimiento']."', '".$data['lugar']."', '".$data['tipo_lugar']."', '".$data['oficina']."', '".$data['fecha']."', '".$data['concepto']."', '".$data['importe']."', '".$data['partida_presupuestaria']."')");	
		return $this->db->insert_id();
	}
	
	function GetMovimiento($id_movimiento)
	{
		$data = false;
		$this->load->database();
		$query = $this->db->query("SELECT id_movimiento, tipo_movimiento, lugar, tipo_lugar, id_oficina, fecha, concepto, importe, partida_presupuestaria FROM movimientos_cuentas WHERE id_movimiento = {$id_movimiento}");	
		if($query->num_rows() > 0){
			$fila = $query->row();
			$data['id_movimiento'] = $fila->id_movimiento;
			$data['tipo_movimiento'] = $fila->tipo_movimiento;
			$data['lugar'] = $fila->lugar;
			$data['tipo_lugar'] = $fila->tipo_lugar;
			$data['id_oficina'] = $fila->id_oficina;
			$data['fecha'] = $fila->fecha;
			$data['concepto'] = $fila->concepto;
			$data['importe'] = $fila->importe;
			$data['partida_presupuestaria'] = $fila->partida_presupuestaria;
		}
		return $data;
	}
	
	function UpdateMovimiento($data)
	{	
		if($data['lugar']=="cuenta"){ //Nos da igual la oficina
			$data['oficina']="";
		}
		$this->load->database();
		$query = $this->db->query("UPDATE movimientos_cuentas SET tipo_movimiento = '".$data['tipo_movimiento']."', lugar = '".$data['lugar']."', tipo_lugar = '".$data['tipo_lugar']."', id_oficina = '".$data['oficina']."', fecha = '".$data['fecha']."', concepto = '".$data['concepto']."', importe = '".$data['importe']."', partida_presupuestaria = '".$data['partida_presupuestaria']."' WHERE id_movimiento = '".$data['id_movimiento']."'");
		redirect('admin/movimientos/view/'.$data['id_movimiento']);
	}
	
	function GetMovimientos($fecha_desde, $fecha_hasta, $str_where)
	{
		$data = false;
		$this->load->database();
		
		$query=$this->db->query("SELECT id_movimiento, tipo_movimiento, lugar, tipo_lugar, id_oficina, fecha, concepto, importe, partida_presupuestaria FROM movimientos_cuentas WHERE fecha>='".$fecha_desde."' AND fecha<='".$fecha_hasta."'".$str_where);
		if($query->num_rows() > 0){
			$i = 0;
			foreach($query->result() as $fila){
				$data[$i]['id_movimiento']=$fila->id_movimiento;
				$data[$i]['tipo_movimiento']=$fila->tipo_movimiento;
				$data[$i]['lugar']=$fila->lugar;
				$data[$i]['tipo_lugar']=$fila->tipo_lugar;
				$data[$i]['id_oficina']=$fila->id_oficina;
				$data[$i]['fecha']=$fila->fecha;
				$data[$i]['concepto']=$fila->concepto;
				$data[$i]['importe']=$fila->importe;
				$data[$i]['partida_presupuestaria']=$fila->partida_presupuestaria;
				
				$i++;
			}
		}
		return $data;
	}
	
	function InsertRetencion($data)
	{	
		$this->load->database();
		$query = $this->db->query("INSERT INTO retenciones (tipo_retencion, id_oficina, concepto, importe, observaciones, fecha, fecha_vencimiento) VALUES ('".$data['tipo_retencion']."', '".$data['oficina']."', '".$data['concepto']."', '".$data['importe']."', '".$data['observaciones']."', '".$data['fecha']."', '".$data['fecha_vencimiento']."')");	
		return $this->db->insert_id();
	}
	
	function UpdateRetencion($data)
	{	
		$this->load->database();
		$query = $this->db->query("UPDATE retenciones SET tipo_retencion = '".$data['tipo_retencion']."', id_oficina = '".$data['oficina']."', concepto = '".$data['concepto']."', importe = '".$data['importe']."', observaciones = '".$data['observaciones']."', fecha = '".$data['fecha']."', fecha_vencimiento = '".$data['fecha_vencimiento']."' WHERE id_retencion = '".$data['id_retencion']."'");
		redirect('admin/retenciones/view/'.$data['id_retencion']);
	}
	
	function GetRetencion($id_retencion)
	{
		$data = false;
		$this->load->database();
		$query = $this->db->query("SELECT id_retencion, tipo_retencion, id_oficina, concepto, importe, observaciones, fecha, fecha_vencimiento FROM retenciones WHERE id_retencion = {$id_retencion}");	
		if($query->num_rows() > 0){
			$fila = $query->row();
			$data['id_retencion']=$fila->id_retencion;
			$data['tipo_retencion']=$fila->tipo_retencion;
			$data['id_oficina']=$fila->id_oficina;
			$data['concepto']=$fila->concepto;
			$data['importe']=$fila->importe;
			$data['observaciones']=$fila->observaciones;
			$data['fecha']=$fila->fecha;
			$data['fecha_vencimiento']=$fila->fecha_vencimiento;
		}
		return $data;
	}
	
	function GetRetenciones($fecha_desde, $fecha_hasta, $str_where)
	{
		$data = false;
		$this->load->database();
		
		$query=$this->db->query("SELECT id_retencion, tipo_retencion, id_oficina, concepto, importe, observaciones, fecha, fecha_vencimiento FROM retenciones WHERE id_retencion=id_retencion".$str_where);
		if($query->num_rows() > 0){
			$i = 0;
			foreach($query->result() as $fila){
				$data[$i]['id_retencion']=$fila->id_retencion;
				$data[$i]['tipo_retencion']=$fila->tipo_retencion;
				$data[$i]['id_oficina']=$fila->id_oficina;
				$data[$i]['concepto']=$fila->concepto;
				$data[$i]['importe']=$fila->importe;
				$data[$i]['observaciones']=$fila->observaciones;
				$data[$i]['fecha']=$fila->fecha;
				$data[$i]['fecha_vencimiento']=$fila->fecha_vencimiento;
				
				$i++;
			}
		}
		return $data;
	}
	
	function GetRetencionesAnuales($anio, $id_oficina)
	{
		$data = false;
		$this->load->database();
		
		$i=0;
		
		for($mes=1;$mes<=12;$mes++){
			$query = $this->db->query("SELECT SUM(importe) as total_importe FROM retenciones WHERE tipo_retencion = 'IRPF' and YEAR(fecha_vencimiento)={$anio} and MONTH(fecha_vencimiento)={$mes} and id_oficina={$id_oficina}");
			if($query->num_rows() > 0){
				foreach($query->result() as $fila){
					if($fila->total_importe<>""){
						$data[$i]['tipo_retencion']="IRPF";
						$data[$i]['total_importe']=$fila->total_importe;
						$data[$i]['mes']=$mes;

						$i++;
					}
				}
			}
		}
		
		for($mes=1;$mes<=12;$mes++){
			$query = $this->db->query("SELECT SUM(importe) as total_importe FROM retenciones WHERE tipo_retencion = 'SS' and YEAR(fecha_vencimiento)={$anio} and MONTH(fecha_vencimiento)={$mes} and id_oficina={$id_oficina}");
			if($query->num_rows() > 0){
				foreach($query->result() as $fila){
					if($fila->total_importe<>""){
						$data[$i]['tipo_retencion']="SS";
						$data[$i]['total_importe']=$fila->total_importe;
						$data[$i]['mes']=$mes;

						$i++;
					}
				}
			}
		}

		return $data;
	}

    private function sendEmail($from, $to, $subject, $message) {
        try {


            $this->load->library('PHPMailer_Lib');
            $mail = $this->phpmailer_lib->load();
            $mail->isSMTP();
            $mail->Host = 'smtp.ionos.es';
            $mail->SMTPAuth = true;
            $mail->Username = 'info@exeleventos.com';
            $mail->Password = '1492BDJ5319';
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 465;
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

            /* $mail->addCC('cc@example.com');
              $mail->addBCC('bcc@example.com'); */

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