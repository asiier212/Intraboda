<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="icon" type="image/png" href="<?php echo base_url() . $this->config->item('favicon') ?>" />
    <title>
        Página principal
    </title>
    <link href="<?php echo base_url() ?>css/style.css" rel="stylesheet" type="text/css" />
    <script src="<?php echo base_url() ?>js/jquery/development-bundle/jquery-1.7.2.js"></script>
    <?php if (isset($scripts_src)) echo $scripts_src; ?>
    <?php if (isset($scripts)) echo $scripts; ?>

    <script language="javascript">
        function actualizarContadorNotificaciones() {
            fetch("<?= base_url() . 'admin/notificaciones_ajax' ?>")
                .then(res => res.json())
                .then(data => {
                    console.log("Notificaciones:", data); // debug
                    const total = data.length;
                    const contador = document.getElementById('contador-notif');

                    if (total > 0) {
                        contador.style.display = 'inline-block';
                        contador.innerText = total > 9 ? '9+' : total;
                    } else {
                        contador.style.display = 'inline-block';
                        contador.innerText = total > 9 ? '9+' : total;
                    }
                })
                .catch(err => console.error("Error al cargar notificaciones:", err));
        }

        actualizarContadorNotificaciones();
        setInterval(actualizarContadorNotificaciones, 5000); // Actualiza cada 30s
    </script>
</head>

<body>

    <div id="header">
        <ul class="nav">
            <li class="logo">
                <img src="<?php echo base_url() . $this->config->item('logo_header') ?>" width="25" height="25" />
            </li>
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
                    <li><a href="<?php echo base_url() ?>admin/invitados">Usuarios Invitado</a></li>
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
                        <a href="<?php echo base_url() ?>admin/facturas/add">Añadir Factura</a>
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
            <div class="loginDisplay" style="display: flex; align-items: center; gap: 10px; padding: 8px 12px; border-radius: 6px; font-family: Arial, sans-serif; font-size: 14px; margin-left: auto; width: fit-content;">
                <a href="<?= base_url() ?>admin/notificaciones/view" class="notif-wrapper" style="display: flex; align-items: center; position: relative;">
                    <img src="<?= base_url() ?>img/notificacion.png" class="notif" alt="Notificación" />
                    <span id="contador-notif"></span>
                </a>

                <span style="color: #93CE37">|</span>
                <span style="color: #93CE37">Panel de gestión del Administrador</span>
                <span style="color: #93CE37">|</span>
                <a href="<?= base_url() ?>admin/logout" class="cerrar_sesion">Cerrar sesión</a>
            </div>


        </ul>

    </div>

    <div>&nbsp;</div>
    <div id="header-placeholder"></div>
    <div class="page">

        <style>
            .page {
                margin-top: 50px;
                /* o lo que necesites */
            }

            #header-placeholder {
                display: none;
                height: 50px;
                /* igual altura que tu header */
            }

            .ocultar {
                display: none;
            }

            .cerrar_sesion {
                color: white !important;
                text-decoration: none;
                background-color: rgb(255, 39, 39);
                border: 1px solid red;
                border-radius: 2px;
                padding: 8px;
                transition: 300ms;
            }

            .cerrar_sesion:hover {
                background-color: rgb(255, 108, 108);
                transition: 300ms;
            }

            .notif {
                width: 25px;
                height: 25px;
                transition: 300ms;
                padding: 10px;
            }

            .notif {
                width: 25px;
                height: 25px;
                transition: 300ms;
                padding: 10px;
            }

            #contador-notif {
                position: absolute;
                top: 5px;
                right: 5px;
                background-color: red;
                color: white;
                font-size: 12px;
                font-weight: bold;
                padding: 2px 6px;
                border-radius: 12px;
                display: none;
                pointer-events: none;
                /* <- Esto hace que no bloquee el hover */
            }

            .notif-wrapper:hover .notif {
                border-radius: 100px;
                background-color: #93CE37;
                content: url('<?= base_url() ?>img/notificacion2.png');
            }

            .notif:hover {
                border-radius: 100px;
                background-color: #93CE37;
                transition: 300ms;
                content: url('<?= base_url() ?>img/notificacion2.png');
            }

            #contador-notif {
                position: absolute;
                top: 5px;
                right: 5px;
                background-color: red;
                color: white;
                font-size: 12px;
                font-weight: bold;
                padding: 2px 6px;
                border-radius: 12px;
                display: none;
            }

            /* Por defecto ocultamos menú para móvil */
            .nav>li:not(.menu-toggle) {
                display: inline-block;
                /* menú normal */
            }

            .menu-toggle {
                display: none;
                cursor: pointer;
                font-size: 28px;
                padding: 0 10px;
                user-select: none;
            }

            /* Para móviles */
            @media screen and (max-width: 768px) {

                .page {
                    margin-top: 100px;
                    /* o lo que necesites */
                }

                #header-placeholder {
                    display: none;
                    height: 100px;
                    /* igual altura que tu header */
                }
            }
        </style>

        <script>
            window.addEventListener('scroll', function() {
                var header = document.querySelector('.header');
                var placeholder = document.getElementById('header-placeholder');
                if (window.scrollY > 0) {
                    header.classList.add('fixed');
                    placeholder.style.display = 'block';
                } else {
                    header.classList.remove('fixed');
                    placeholder.style.display = 'none';
                }
            });

            $(document).ready(function() {
                posicionarMenu(); // Esto asegura que al cargar la página con scroll abajo se ajuste bien
                $(window).scroll(posicionarMenu);
            });

            $(window).on('load', function() {
                posicionarMenu();
            });

            $(document).ready(function() {
                $('.menu-toggle a').click(function() {
                    $('.nav').toggleClass('open');
                });
            });
        </script>