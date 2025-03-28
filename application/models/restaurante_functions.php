<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Restaurante_functions extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->library('encrypt');
	}

	public function login($email, $clave)
	{
		$this->load->database();
		$this->load->library('encrypt');

		$clave_sin_cifrar = "";

		// Buscar la clave cifrada del restaurante
		$query = $this->db->query("SELECT id_restaurante, nombre, clave FROM restaurantes WHERE email_maitre = '{$email}'");

		if ($query->num_rows() > 0) {
			$fila = $query->row();
			$clave_cifrada = $fila->clave;

			// Desencriptar
			$clave_sin_cifrar = $this->encrypt->decode($clave_cifrada);

			// Comparar claves
			if ($clave_sin_cifrar === $clave && $clave_sin_cifrar != '') {
				return $fila;
			}
		}

		return false;
	}

	function GetClientes($str_where, $ord, $limit)
	{
		$data = false;
		$this->load->database();

		// Obtener el restaurante_id desde la sesión
		$restaurante_id = $this->session->userdata('restaurante_id');
		
		

		// Agregar filtro obligatorio por restaurante
		if (trim($str_where) === "") {
			$str_where = "WHERE clientes.id_restaurante = {$restaurante_id}";
		} else {
			$str_where .= " AND clientes.id_restaurante = {$restaurante_id}";
		}

		$query = $this->db->query("
        SELECT 
            clientes.id, 
            clientes.foto, 
            clientes.nombre_novio, 
            clientes.nombre_novia, 
            restaurantes.nombre AS restaurante, 
            DATE_FORMAT(clientes.fecha_boda, '%d-%m-%Y %H:%i') AS fecha_boda_formateado, 
            DATE_FORMAT(clientes.fecha, '%d-%m-%Y') AS fecha_alta 
        FROM clientes 
        INNER JOIN restaurantes ON clientes.id_restaurante = restaurantes.id_restaurante 
        {$str_where} 
        ORDER BY {$ord} 
        {$limit}
    ");

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
}
