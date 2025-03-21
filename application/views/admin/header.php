<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="icon" type="image/png" href="<?php echo base_url() ?>img/favicon.png">
    <title>
        Página principal
    </title>
    <link href="<?php echo base_url() ?>css/style.css" rel="stylesheet" type="text/css" />
    <script src="<?php echo base_url() ?>js/jquery/development-bundle/jquery-1.7.2.js"></script>
    <?php if (isset($scripts_src)) echo $scripts_src; ?>
    <?php if (isset($scripts)) echo $scripts; ?>

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
            <li class="logo"><img src="<?php echo base_url() ?>img/logo_intranet.png" width="25" height="25" /></li>
            <li><a href="">Clientes</a>
                <ul>
                    <li><a href="<?php echo base_url() ?>admin/clientes/add">Añadir Cliente</a></li>
                    <li><a href="<?php echo base_url() ?>admin/clientes/view">Listar Clientes</a></li>
                </ul>
            </li>
            <li><a href="">Gestión</a>
                <ul>
                    <li><a href="<?php echo base_url() ?>admin/oficinas">Oficinas</a></li>
                    <li><a href="<?php echo base_url() ?>admin/apariencia">Apariencia</a></li>
                    <li><a href="<?php echo base_url() ?>admin/mantenimiento_equipos">Equipamiento</a></li>
                    <li><a href="<?php echo base_url() ?>admin/servicios/view">Servicios</a></li>
                    <li><a href="<?php echo base_url() ?>admin/persons/view">Personas de contacto</a></li>
                    <li><a href="<?php echo base_url() ?>admin/djs/view">DJs</a></li>
                    <li><a href="<?php echo base_url() ?>admin/comerciales/view">Comerciales</a></li>
                    <li><a href="<?php echo base_url() ?>admin/emails_enviados">Emails Automáticos</a></li>
                    <li><a href="<?php echo base_url() ?>admin/restaurantes/view">Restaurantes</a></li>
                </ul>
            </li>
            <li><a href="">Administración</a>
                <ul>
                    <li><a href="<?php echo base_url() ?>admin/parametrizacion">Parametrización</a></li>
                    <li><a href="<?php echo base_url() ?>admin/mantenimiento_bd_canciones">BD Canciones</a></li>
                    <li><a href="<?php echo base_url() ?>admin/estadisticas">Estadísticas</a></li>
                    <li><a href="<?php echo base_url() ?>admin/eventos">Ferias</a></li>
                    <li><a href="<?php echo base_url() ?>admin/encuesta">Encuesta</a></li>
                    <li><a href="<?php echo base_url() ?>tarifas">Tarifas</a></li>
                </ul>
            </li>
            <li><a href="">Eventos</a>
                <ul>
                    <li><a href="<?php echo base_url() ?>admin/admin_eventos_view">Eventos</a></li>
                    <li><a href="<?php echo base_url() ?>admin/admin_horas_djs_view">Horas DJs</a></li>
                </ul>
            </li>
            <li><a href="">Contabilidad Clientes</a>
                <ul>
                    <li><a href="<?php echo base_url() ?>admin/admin_contabilidad_clientes_view">Contabilidad</a></li>
                </ul>
            </li>
            <li><a href="">Contabilidad Empresa</a>
                <ul>
                    <li class="ocultar">
                        <ahref="<?php echo base_url() ?>admin /facturas/add">Añadir Factura</a>
                    </li>
                    <li><a href="<?php echo base_url() ?>admin/facturas/view">Listar Facturas e IVAs</a></li>
                    <li><a href="<?php echo base_url() ?>admin/partidas_presupuestarias/add">Añadir Partida Presupuestaria</a></li>
                    <li><a href="<?php echo base_url() ?>admin/partidas_presupuestarias/view">Listar Partidas Presupuestarias</a></li>
                    <li><a href="<?php echo base_url() ?>admin/movimientos/add">Añadir Movimiento</a></li>
                    <li><a href="<?php echo base_url() ?>admin/movimientos/view">Listar Movimientos</a></li>
                    <li class="ocultar"><a href="<?php echo base_url() ?>admin/retenciones/add">Añadir Retención</a></li>
                    <li class="ocultar"><a href="<?php echo base_url() ?>admin/retenciones/view">Listar Retenciones</a></li>
                </ul>
            </li>
            <div class="loginDisplay">
                Panel de gesti&oacute;n del Administrador | <a href="<?php echo base_url() ?>admin/logout">Cerrar sesión</a>
            </div>
        </ul>

    </div>

    <div>&nbsp;</div>
    <div class="page">

        <style>
            .ocultar {
                display: none;
            }
        </style>