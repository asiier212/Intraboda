<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Invitado_functions extends CI_Model
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
    
        $this->db->where('email', $email);
        $query = $this->db->get('invitado');
    
        if ($query->num_rows() > 0) {
            $fila = $query->row();
    
            // ¿Está desactivado?
            if ($fila->valido != 1) {
                return 'desactivado';
            }

            if (!empty($fila->fecha_expiracion) && strtotime($fila->fecha_expiracion) < time()) {
                return 'expirado';
            }            
    
            // Comprobar clave
            $clave_sin_cifrar = $this->encrypt->decode($fila->clave);
    
            if ($clave_sin_cifrar === $clave && $clave_sin_cifrar != '') {
                return $fila; // Login correcto
            }
        }
    
        return false; // Usuario no existe o clave incorrecta
    }

    function GetIdClienteForIdInvitado($id_invitado)
    {
        $data = false;
        $this->load->database();
        $query = $this->db->query("SELECT id_cliente FROM invitado WHERE id = {$id_invitado}");
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $fila) {
                $data = $fila->id_cliente;
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
			$data['id_restaurante'] = $fila->id_restaurante;
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
		$query = $this->db->query("SELECT id, comentario, link, ocultar, DATE_FORMAT(fecha, '%d-%m-%Y %H:%i') as fecha FROM observaciones WHERE id_cliente = {$id} ORDER BY id DESC");
		if ($query->num_rows() > 0) {
			$i = 0;
			foreach ($query->result() as $fila) {
				$data[$i]['id'] = $fila->id;
				$data[$i]['comentario'] = $fila->comentario;
				$data[$i]['link'] = $fila->link;
				$data[$i]['ocultar'] = $fila->ocultar;
				$data[$i]['fecha'] = $fila->fecha;
				$i++;
			}
		}
		return $data;
	}

	function GetEvents($id)
	{
		$data = false;
		$this->load->database();
		$query = $this->db->query("SELECT id, nombre, orden, hora FROM momentos_espec WHERE cliente_id  = {$id} ORDER BY orden");
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
	function GetmomentosUser($id)
	{
		$data = false;
		$this->load->database();
		$query = $this->db->query("SELECT DISTINCT canciones.momento_id, momentos_espec.nombre, momentos_espec.orden, momentos_espec.hora FROM canciones INNER JOIN momentos_espec ON canciones.momento_id=momentos_espec.id WHERE canciones.client_id = {$id} ORDER BY momentos_espec.orden");
	

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

	function GetcancionesUser($id)
	{
		$data = false;
		$this->load->database();
		$query = $this->db->query("SELECT id, momento_id, id_bd_canciones, orden FROM canciones WHERE client_id = {$id} ORDER BY momento_id, orden");
	


		if ($query->num_rows() > 0) {
			$i = 0;
			foreach ($query->result() as $fila) {
				$data[$i]['id'] = $fila->id;
				$data[$i]['momento_id'] = $fila->momento_id;

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

	function GetObservaciones_momesp($id)
	{
		$data = false;
		$this->load->database();
		$query = $this->db->query("SELECT canciones_observaciones.id, momento_id, comentario, nombre, DATE_FORMAT(fecha, '%d/%m/%Y') as fecha FROM canciones_observaciones INNER JOIN momentos_espec ON canciones_observaciones.momento_id = momentos_espec.id WHERE momentos_espec.cliente_id = {$id} ORDER BY momento_id");
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
	function GetObservaciones_general($id)
	{
		$data = false;
		$this->load->database();
		$query = $this->db->query("SELECT id, comentario, DATE_FORMAT(fecha, '%d/%m/%Y') as fecha FROM canciones_observaciones WHERE id = {$id} AND momento_id = 0 ORDER BY id DESC");
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

}
