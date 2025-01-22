<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Tarifas extends CI_Controller {
    const WPDBNAME = 'dbs538934';
    const WPDBHOST = 'db5000561367.hosting-data.io';
    const WPDBUSER = 'dbu521641';
    const WPDBPWD = '#20ExelEventos20Nueva#';

    private $wpconn = false;
    private $posts;

    function __construct() {
        parent::__construct();
        //$this->load->helper('url');
        //$this->load->helper(array('form', 'url'));
        $this->load->library('session');
       // $this->load->model('admin_functions');
        if (!$this->session->userdata('admin') && $this->router->method != 'login') {
            redirect('admin/login');
        }
        if (isset($_POST['action'])) {
            $action = $_POST['action'];
            $this->execAction($action);
}

//$this->load->View();
    }

    public function index($a = false) {

        $view = "admin/tarifas";
        $data = false;
        $data_header = false;
        
        $data_footer = false;
        $data['posts'] = $this->getWPPost();
        $this->load->helper('url');
        if (count($_POST) == 0) {
            $this->load->view('admin/header', $data_header);
            $this->load->view($view, $data);
        }
    }
    protected function execAction($action){
       
        switch ($action) {
            
            case 'change-service':
                $result = $this->getServiceTariffs();
                
                return $this->output
                        ->set_content_type('application/json')
                                ->set_status_header(200)
                                ->set_output(json_encode($result, 1));

            case 'create-tariff':
                $result = $this->createTariff();
                return $this->output
                                ->set_content_type('application/json')
                                ->set_status_header(200)
                                ->set_output(json_encode($result, 1));
            case 'get-detalle-tarifa':
                $html = $this->htmlTarifDetail();
                return $this->output
                                ->set_content_type('text/plain')
                                ->set_status_header(200)
                                ->set_output($html, 1);
            case 'save-detail-tariff':
                $result = $this->saveSelectTariff();
                return $this->output
                                ->set_content_type('text/plain')
                                ->set_status_header(200)
                                ->set_output(json_encode($result, 1), 1);
            case 'save-switch-tariff':
                $result = $this->saveSwitchTariff();
                return $this->output
                                ->set_content_type('text/plain')
                                ->set_status_header(200)
                                ->set_output(json_encode($result, 1), 1);
            case 'save-slider-tariff':
                $result = $this->saveSliderTariff();
                return $this->output
                                ->set_content_type('text/plain')
                                ->set_status_header(200)
                                ->set_output(json_encode($result, 1), 1);
            case 'delete-tarifa':
                $result = $this->delete();
                return $this->output
                                ->set_content_type('text/plain')
                                ->set_status_header(200)
                                ->set_output(json_encode($result, 1), 1);
            case 'guardar-tarifa':
                $result = $this->guardarTarifa();
                return $this->output
                                ->set_content_type('text/plain')
                                ->set_status_header(200)
                                ->set_output(json_encode($result, 1), 1);
        }
    }

    protected function getWPPost($postid = null) {
        $data = [];
        try {
            $sql = "Select * from wpzjwr_posts where post_type='bt-cost-calculator' and post_status='publish'";
            if ($postid) {
                $sql .= " and ID=" . $postid;
            }
            
            if (!$this->wpconn) {
                $this->wpConnect();
            }
            $data = mysqli_query($this->wpconn, $sql);
            $this->posts = [];
            while ($row = mysqli_fetch_assoc($data)) {
               
                $this->post[] = $row;
            }
            //error_log("Los post son " . var_export($this->post, 1), 3, "./r");
            return $this->post;
        } catch (Exception $e) {
            error_log("El error es " . var_export($e, 1), 3, "./r");
        } finally {
            
            return $this->post;
        }
    }

    private function wpConnect() {
        if (!$this->wpconn) {
            $this->wpconn = new mysqli(self::WPDBHOST, self::WPDBUSER, self::WPDBPWD,self::WPDBNAME);
            
        }
        return $this->wpconn;
    }
    private function getServiceTariffs() {
        $this->load->database();
        $data = [];
        if (!isset($_POST['idservice'])) {
            return [];
        }
        $serviceid = $_POST['idservice'];
        $sql = "select * from tarifas_servicio where idservicio='" . $serviceid . " order by desde DESC';";
        $query = $this->db->query($sql);
        foreach ($query->result() as $row) {
            $data[] = [
                'id' => $row->id
                , 'idservicio' => $row->idservicio
                , 'desde' => $row->desde
                , 'hasta' => $row->hasta
                , 'nombre' => $row->nombre
                , 'desde_numeventos' => $row->desde_numeventos
                , 'hasta_numeventos' => $row->hasta_numeventos
            ];
        }
        return $data;
    }

    public function createTariff() {
        $this->load->database();
        $idservicio = $_POST['idservicio'];
        $nombre = $_POST['nombre'];
        $desfec = $_POST['desfec'];
        $hasfec = $_POST['hasfec'];
        $mineventos = $_POST['mineventos'];
        $maxeventos = $_POST['maxeventos'];

        $sql = " INSERT INTO tarifas_servicio (idservicio,nombre,desde,hasta,desde_numeventos,hasta_numeventos) values ("
                . $idservicio . ",'" . $nombre . "','" . $desfec . "','" . $hasfec . "'," . $mineventos . "," . $maxeventos . ");";
       
        $result = $this->db->query($sql);
        $id = $this->db->insert_id();
        
        $post = $this->getWPPost($idservicio);
       
        $controles = $this->procesarTexto($post[0]['post_content']);
       
        $valores = $this->procesarControles($controles);
        

        foreach ($valores as $valor) {
            $values = mysql_real_escape_string(json_encode($valor['valores'], 1));
            $sql = 'insert into tarifas_detalle (idtarifa,tipo, name,item_el_id,valores)'
                    . 'values(' . $id
                    . ',"' . $valor['control'] . '"'
                    . ',"' . $valor['valores']['name'] . '"'
                    . ',"' . $valor['valores']['item_el_id'] . '"'
                    . ',"' . $values . '")';

            
            $result = $this->db->query($sql);
        }
        return ['resultado' => $result];
    }

    private function procesarTexto($texto) {
        $datos = [];
        $posspc = strpos($texto, ' ');
        $poscierre = strpos($texto, ']');
        $texto = substr($texto, ($poscierre + 1));
       
        while ($posspc > 0) {
            $poscierre = strpos($texto, ']');
            $posspc = strpos($texto, ' ');
            $clave = trim(substr($texto, 1, $posspc));
            switch ($clave) {
                case 'bt_cc_group':
                    $poscierre = strpos($texto, ']');
                    $texto = substr($texto, ($poscierre + 1));
                    $texto = str_replace('[/bt_cc_group]', '', $texto);
                    continue 2;
                    break;
            }
            $textoprocesar = substr($texto, $posspc, $poscierre - $posspc - 1);
            $datos[] = ['clave' => $clave, 'valor' => $textoprocesar];
            $cortar = strpos($texto, '[/' . $clave . ']') + strlen($clave) + 3;
            $texto = substr($texto, $cortar);
            $posspc = strpos($texto, ' ');
        }
        return $datos;
    }
    private function procesarControles($controles) {
        $resultado = [];
        foreach ($controles as $control) {
           
            
            switch ($control['clave']) {
                case 'bt_cc_select':
                    $elselect = $this->extractSelectData($control);
                    $resultado[] = [
                        'control' => $control['clave']
                        , 'valores' => $elselect
                    ];
                    
                    break;
                case 'bt_cc_switch':
                    $elswitch = $this->extractSwitchData($control);
                    $resultado[] = [
                        'control' => $control['clave']
                        , 'valores' => $elswitch
                    ];
                    
                    break;
                case 'bt_cc_slider':
                    $elslider = $this->extractSliderData($control);
                    $resultado[] = [
                        'control' => $control['clave']
                        , 'valores' => $elslider
                    ];
                    break;
            }
        }
        
        return $resultado;
    }
    private function extractSliderData($textcontrol) {
        $pattern = '/(\w+)\s*=\s*"([^"]*)"/';
        preg_match_all($pattern, $textcontrol['valor'], $matches);
        $attributes = array_combine($matches[1], $matches[2]);
        
        $resultado = [
            'tipo' => 'bt_cc_slider'
            , 'name' => $attributes['name']
            , 'item_el_id' => $attributes['item_el_id']
            , 'description' => $attributes['description']
            , 'values' => [
                'value_min' => $attributes['value_min']
                , 'value_max' => $attributes['value_max']
                , 'value_unit' => $attributes['value_unit']
            ]
        ];
        return $resultado;
    }

    private function extractSwitchData($textcontrol) {
        $pattern = '/(\w+)\s*=\s*"([^"]*)"/';
        preg_match_all($pattern, $textcontrol['valor'], $matches);
        $attributes = array_combine($matches[1], $matches[2]);
        
        $resultado = [
            'tipo' => 'bt_cc_switch'
            , 'name' => $attributes['name']
            , 'item_el_id' => $attributes['item_el_id']
            , 'values' => [
                'value_off' => $attributes['value_off']
                , 'value_on' => $attributes['value_on']
                , 'initial_value' => $attributes['initial_value']
            ]
        ];
        return $resultado;
    }

    private function extractSelectData($textcontrol) {
        
        $pattern = '/(\w+)\s*=\s*"([^"]*)"/';
        preg_match_all($pattern, $textcontrol['valor'], $matches);
        $attributes = array_combine($matches[1], $matches[2]);
        //var_export($attributes);
        //var_export($attributes['value']); 
        $text = $attributes['value'];
        $data = preg_split('/$\R?^/m', $text);
        //echo '<br/><br/>';
        //print_r($data);

        $valores = [];
        foreach ($data as $dato) {
            //print_r($dato);
            $separado = explode(';', $dato);
            $valores[] = ['nombre' => $separado[0], 'precio' => $separado[1], 'descripcion' => $separado[2]];
        }
        $resultado = [
            'tipo' => 'bt_cc_select'
            , 'name' => $attributes['name']
            , 'item_el_id' => $attributes['item_el_id']
            , 'values' => $valores
        ];
        
        return $resultado;
    }

    private function htmlTarifDetail() {
        $idTarifa = $_POST['idtarifa'];
        $this->load->database();
        $sql = "select * from tarifas_detalle where idtarifa=" . $idTarifa . ";";
        $query = $this->db->query($sql);
        $html = '<div class="accordion" id="detalleTarifa_' . $idTarifa . '">';
        foreach ($query->result() as $row) {
            
            switch ($row->tipo) {
                case 'bt_cc_select':
                    $html.=$this->generateHtmlSelect($row);
                    break;
                case 'bt_cc_switch':
                    $html .= $this->generateHtmlSwitch($row);
                    break;
                case 'bt_cc_slider':
                    $html .= $this->generateHtmlSlider($row);
                    break;
            }
        }
        $html .= '</div>';
        
        return $html;
    }

    private function generateHtmlSlider($row) {
        $values = json_decode($row->valores);
        $valor = $values->values;
        
        $body = '<div class="row"><form method="POST" id="' . $row->id . '">';
        $body .= '<input type="hidden" value="' . $row->id . '" name="idregistro"/>';
        $body .= '<input type="hidden" value="' . $row->name . '" name="nombreprincipal"/>';
        $body .= '<table><tbody>';
        $body .= '<tr><td>'
                . '<input name="titulo_' . $row->name . '" readonly="readonly" class="" style="font-weight:bold;width:100%;border: 0;" value="' . $row->name . '"/><br/>'
                . '</td>';
        $body .= '<td><label>Off</label>'
                . '<input type="number" class="form-control" name="value_' . $row->name . '" id="value_' . $row->id . '" value="' . $valor->value_unit . '"></td></tr>';
        $body .= '<tr><td colspan="3" style="text-align:right;">'
                . '<button type="button" id="btn_' . $row->name . '" name="btn_' . $row->name . '" class="btn btn-primary" style="margin-top:5%;" onclick="saveDetailSliderTarifa(' . $row->id . ');">Guardar</button></td></tr>';
        $body .= '</tr></tbody></table>';

        $html = '<div class="accordion-item">'
                . '<h2 class="accordion-header" style="background-color:#BEFBD0;">'
                . '<button class="accordion-button" style="background-color:#BEFBD0;" type="button" data-bs-toggle="collapse" data-bs-target="#detalleTarifa_' . $row->id . '" aria-expanded="true" aria-controls="collapseOne">'
                . $row->name . '</button></h2>'
                . '<div id="detalleTarifa_' . $row->id . '" class="accordion-collapse collapse show" data-bs-parent="#detalleTarifa_' . $row->id . '">'
                . '<div class="accordion-body">';
        $html .= $body;

        $html .= '</div></div></form></div>';

        return $html;
    }

    private function generateHtmlSwitch($row) {
            $values = json_decode($row->valores);
        $valor = $values->values;
       
        $body = '<div class="row"><form method="POST" id="' . $row->id . '">';
        $body .= '<input type="hidden" value="' . $row->id . '" name="idregistro"/>';
        $body .= '<input type="hidden" value="' . $row->name . '" name="nombreprincipal"/>';
        $body .= '<table><tbody>';
        $body .= '<tr><td>'
                . '<input name="titulo_' . $row->name . '" readonly="readonly" class="" style="font-weight:bold;width:100%;border: 0;" value="' . $row->name . '"/><br/>'
                . '</td>';
        $body .= '<td><label>Off</label>'
                . '<input type="number" class="form-control" name="valueoff_' . $row->name . '" id="valueoff_' . $row->id . '" value="' . $valor->value_off . '"></td>';

        $body .= '<td><label>On</label>'
                . '<input type="number" class="form-control" name="valueon_' . $row->name . '" id="valueon_' . $row->id . '" value="' . $valor->value_on . '">'
                . '</tr></td>';
        $body .= '<tr><td colspan="3" style="text-align:right;">'
                . '<button type="button" id="btn_' . $row->name . '" name="btn_' . $row->name . '" class="btn btn-primary" style="margin-top:5%;" onclick="saveDetailSwitchTarifa(' . $row->id . ');">Guardar</button></td></tr>';
        $body .= '</tbody></table>';

        $html = '<div class="accordion-item">'
                . '<h2 class="accordion-header" style="background-color:#BEFBD0;">'
                . '<button class="accordion-button" style="background-color:#BEFBD0;" type="button" data-bs-toggle="collapse" data-bs-target="#detalleTarifa_' . $row->id . '" aria-expanded="true" aria-controls="collapseOne">'
                . $row->name . '</button></h2>'
                . '<div id="detalleTarifa_' . $row->id . '" class="accordion-collapse collapse show" data-bs-parent="#detalleTarifa_' . $row->id . '">'
                . '<div class="accordion-body">';
        $html .= $body;

        $html .= '</div></div></form></div>';

        return $html;
    }

    private function generateHtmlSelect($row) {
        $values = json_decode($row->valores);
        $body = '<div class="row"><form method="POST" id="' . $row->id . '">';
        $body .= '<input type="hidden" value="' . $row->id . '" name="idregistro"/>';
        $body .= '<input type="hidden" value="' . $row->name . '" name="nombreprincipal"/>';

        $body .= '<table><tbody>';
        
        foreach ($values->values as $valor) {
            $body .= '<tr style="border-bottom:1px solid gray;">';
            $body .= '<td style="width:60%;">'
                    . '<input name="titulo" readonly="readonly" class="" style="font-weight:bold;width:100%;border: 0;" value="' . $valor->nombre . '"/><br/>'
                    . '<input name="desc" readonly="readonly" style="font-size:0.8em;width:100%;border: 0;" value="' . $valor->descripcion . '"/>'
                    . '</td>'
                    . '<td style="width:30%;">'
                    . '<input type="number" class="form-control" name="value" id="value_' . $valor->nombre . '" value="' . $valor->precio . '">'
                    . '</td></tr>';
        }
        $body .= '<tr><td>&nbsp;</td style="text-align:right;"><td>'
                . '<button type="button" id="btn_' . $valor->nombre . '" name="btn_' . $valor->nombre . '" class="btn btn-primary" style="margin-left: 50%;margin-top:5%;" onclick="saveDetailSelectTarifa(' . $row->id . ');">Guardar</button></td>';
        $body .= '</tbody></table>';
        $html = '<div class="accordion-item">'
                . '<h2 class="accordion-header" style="background-color:#BEFBD0;">'
                . '<button class="accordion-button" style="background-color:#BEFBD0;" type="button" data-bs-toggle="collapse" data-bs-target="#detalleTarifa_' . $row->id . '" aria-expanded="true" aria-controls="collapseOne">'
                . $row->name . '</button></h2>'
                . '<div id="detalleTarifa_' . $row->id . '" class="accordion-collapse collapse show" data-bs-parent="#detalleTarifa_' . $row->id . '">'
                . '<div class="accordion-body">';
        $html .= $body;

        $html .= '</div></div></form></div>';

        return $html;
    }
    private function saveSliderTariff() {
        $idregistro = $_POST['id'];
        $valorRecibido = $_POST['valor'];
        $sql = "*";
        $this->load->database();
        $this->db->select($sql);
        $this->db->where('id', $idregistro);
        $this->db->limit(1);
        $query = $this->db->get('tarifas_detalle');
        $row = $query->row();
        $guardado = json_decode($row->valores, 1);
        $guardado['values']['value_unit'] = $valorRecibido;
        if (isset($row)) {

            $actualizar = ['valores' => json_encode($guardado, 1)];

             $this->db->where('id', $idregistro);
            $this->db->update('tarifas_detalle', $actualizar);
        }
        return ['resultado' => 'OK'];
    }

    private function saveSwitchTariff() {
        $idregistro = $_POST['id'];
        $data = $_POST['values'];
        $sql = "*";
        $this->load->database();
        $this->db->select($sql);
        $this->db->where('id', $idregistro);
        $this->db->limit(1);
        $query = $this->db->get('tarifas_detalle');
        $row = $query->row();
        if (isset($row)) {
            $grabar = [
                'tipo' => $row->tipo
                , 'name' => $row->name
                , 'values' => $data
            ];
           

             $actualizar = ['valores' => json_encode($grabar, 1)];

            $this->db->where('id', $idregistro);
              $this->db->update('tarifas_detalle', $actualizar);
              }
              return ['resultado' => 'OK'];
    }
    

    private function saveSelectTariff() {
        $idregistro = $_POST['id'];
        $data = $_POST['values'];
        
        // Recuperarmos el registro.
        $this->load->database();
        

        $sql = "*";
        $this->db->select($sql);
        $this->db->where('id', $idregistro);
        $this->db->limit(1);
            $query = $this->db->get('tarifas_detalle');
        $row = $query->row();
        if (isset($row)) {
            $grabar = [
                'tipo' => $row->tipo
                , 'name' => $row->name
                , 'values' => $data
        ];
        

            $actualizar = ['valores' => json_encode($grabar, 1)];

            $this->db->where('id', $idregistro);
            $this->db->update('tarifas_detalle', $actualizar);
        }
        return ['resultado' => 'OK'];
    }

    private function delete() {
        $idTarifa = $_POST['id'];
        
        $this->load->database();
        $this->db->where('idtarifa', $idTarifa);
        $this->db->delete('tarifas_detalle');

        $this->db->where('id', $idTarifa);
        $this->db->delete('tarifas_servicio');

        return ['resultado' => 'OK'];
    }

    private function guardarTarifa() {
        $idTarifa = $_POST['id'];
        $idServicio = $_POST['idServicio'];
        $nombre = $_POST['nombre'];
        $desde = $_POST['desde'];
        $hasta = $_POST['hasta'];
        $desdeNumEventos = $_POST['desdeNumEventos'];
        $hastaNumEventos = $_POST['hastaNumEventos'];

        $this->load->database();
        $this->db->where('id', $idTarifa);
        $guardar = ['nombre' => $nombre, 'desde' => $desde, 'hasta' => $hasta
            , 'desde_numeventos' => $desdeNumEventos, 'hasta_numeventos' => $hastaNumEventos];
        $this->db->update('tarifas_servicio', $guardar);
        $conflicto = $this->hayConflicto($idServicio, $idTarifa, $desde, $hasta, $desdeNumEventos, $hastaNumEventos);
        if ($conflicto) {
            return['resultado' => 'CONFLICTO', 'DATOS' => $conflicto];
        }
        return ['resultado' => 'OK'];
    }
    private function hayConflicto($idServicio, $idTarifa, $desde, $hasta, $desdeNumEventos, $hastaNumEventos) {
        $desFec=\DateTime::createFromFormat('Y-m-d',$desde);
        $hasFec = \DateTime::createFromFormat('Y-m-d', $hasta);
        $this->load->database();
        $data = false;
        for($conta=$desdeNumEventos;$conta<=$hastaNumEventos;$conta++){
            $contaFec = $desFec;
            
            while($contaFec<=$hasFec){
                
                $sql = "SELECT * FROM tarifas_servicio ts "
                        . " where '" . $contaFec->format('Y-m-d') . "' BETWEEN ts.desde and ts.hasta"
                        . " and '" . $conta . "' BETWEEN ts.desde_numeventos and ts.hasta_numeventos"
                        . " and idservicio=" . $idServicio . " and id<>" . $idTarifa
                        . " limit 1;";
                
                $query = $this->db->query($sql);
                foreach ($query->result() as $row) {
                    $data[] = [
                        'id' => $row->id
                        , 'idservicio' => $row->idservicio
                        , 'desde' => $row->desde
                        , 'hasta' => $row->hasta
                        , 'nombre' => $row->nombre
                        , 'desde_numeventos' => $row->desde_numeventos
                        , 'hasta_numeventos' => $row->hasta_numeventos
                    ];
                    return $data;
                }
                
                $contaFec->modify('+1 day');
            }
            
        }
        return false;
    }

}
