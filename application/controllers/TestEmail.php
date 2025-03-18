<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class TestEmail extends CI_Controller {

    public function __construct() {
        parent::__construct();
        echo "<br>Constructor ejecutado";
    }

    public function index() {
        echo "Hola mundo";
        echo "<br>Inicio de la función index() en TestEmail";

        // Cargar el modelo
        $this->load->model('admin_functions');
        echo "<br>Modelo admin_functions cargado correctamente";

        // Parámetros de prueba para el envío de correo
        $from = 'info@exeleventos.com';
        $to = ['10patrick.deba@gmail.com'];
        $subject = 'Prueba de Envío de Correo';
        $message = '<p>Este es un correo de prueba desde IONOS.</p>';

        echo "<br>Intentando enviar correo...";

        // Llamar a la función sendEmail del modelo
        if ($this->admin_functions->sendEmail($from, $to, $subject, $message)) {
            echo "<br>Correo enviado correctamente.";
        } else {
            echo "<br>Error al enviar el correo.";
        }
    }
}