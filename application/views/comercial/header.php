<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="icon" type="image/png" href="<?php echo base_url() ?>img/favicon.png">
    <title>Intranet BilboDj</title>
    <link href="<?php echo base_url() ?>css/style.css" rel="stylesheet" type="text/css" />
    <script src="<?php echo base_url() ?>js/jquery/development-bundle/jquery-1.7.2.js"></script>
    <?php if (isset($scripts_src)) echo $scripts_src; ?>
    <script language="javascript" type="text/javascript">
        $(function() {
            $('ul.menu li ul').each(function(index) {
                $(this).width($(this).parent('ul.menu li').width());
            });
        });
        <?php if (isset($scripts)) echo $scripts; ?>
    </script>
    <script language="javascript">
        posicionarMenu();

        $(window).scroll(function() {
            posicionarMenu();
        });

        function posicionarMenu() {
            var altura_del_header = $('.header').outerHeight(true);
            var altura_del_menu = $('.nav').outerHeight(true);

            if ($(window).scrollTop() >= altura_del_header) {
                $('.nav').addClass('fixed');
                $('.wrapper').css('margin-top', (altura_del_menu) + 10 + 'px');
            } else {
                $('.nav').removeClass('fixed');
                $('.wrapper').css('margin-top', '0');
            }
        }
    </script>

</head>

<body>

    <div id="header">
        <ul class="nav">
            <li class="logo">
                <img src="<?php echo base_url() . $this->config->item('logo_header') ?>" width="25" height="25" />
            </li> <?php
                    if ($this->session->userdata('solo_eventos') <> "S") {
                    ?>
                <li><a href="<?php echo base_url() ?>comercial/solicitudes/add">Añadir Solicitud</a></li>
                <li><a href="<?php echo base_url() ?>comercial/solicitudes/view">Listar Solicitudes</a></li>
                <li><a href="<?php echo base_url() ?>comercial/estadisticas">Estadísticas</a></li>
            <?php
                    }
            ?>
            <li><a href="<?php echo base_url() ?>comercial/presupuestos_eventos/add">Añadir Presupuesto Eventos</a></li>
            <li><a href="<?php echo base_url() ?>comercial/presupuestos_eventos/view">Listar Presupuestos Eventos</a></li>
            <li><a href="">Emails</a>
                <ul>
                    <li><a href="<?php echo base_url() ?>comercial/emails">Emails Automáticos</a></li>
                    <li><a href="<?php echo base_url() ?>comercial/emails_enviados">Emails Enviados</a></li>
                </ul>
            </li>
            <li><a href="<?php echo base_url() ?>comercial/seguimiento_llamadas/view">LLamadas</a></li>
            <div class="loginDisplay">
                Panel del Comercial <?php echo $this->session->userdata('nombre') ?> | <a id="" href="<?php echo base_url() ?>comercial/logout">Cerrar sesión</a>
            </div>
        </ul>

    </div>

    <div>&nbsp;</div>
    <div class="page">