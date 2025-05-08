<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="icon" type="image/png" href="<?php echo base_url() ?>img/favicon.png">
    <title>Exel Eventos-Intranet Clientes</title>
    <link href="<?php echo base_url() ?>css/style.css" rel="stylesheet" type="text/css" />
    <script src="<?php echo base_url() ?>js/jquery/js/jquery-1.7.2.min.js"></script>
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
                <img src="<?php echo base_url() . $this->config->item('logo_header') ?>" width="60" />
            </li>
            <li><a href="<?php echo base_url() ?>cliente/topSongs">Canciones más elegidas</a></li>
            <li><a href="<?php echo base_url() ?>cliente/datos/view">Mis datos</a></li>
            <li><a href="<?php echo base_url() ?>cliente/canciones">Mi listado de canciones</a></li>
            <li><a href="<?php echo base_url() ?>cliente/chat">Chat</a></li>
            <li><a href="<?php echo base_url() ?>cliente/ofertas">Ofertas destacadas</a></li>
            <li><a href="<?php echo base_url() ?>cliente/galerias">Galeria de foto</a></li>
            <li><a href="<?php echo base_url() ?>cliente/invitados">Usuarios Invitado</a></li>
            <li><a href="<?php echo base_url() ?>Spotify/obtener_playlist">Spotify</a></li>
            <div class="loginDisplay">
                Intranet de <?php echo $this->session->userdata('nombre_novia') . ' & ' . $this->session->userdata('nombre_novio') ?> | <a id="" href="<?php echo base_url() ?>cliente/logout">Cerrar sesión</a>
            </div>
        </ul>

    </div>

    <div>&nbsp;</div>
    <div class="page">