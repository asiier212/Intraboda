    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">

    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="icon" type="image/png" href="<?php echo base_url() . $this->config->item('favicon') ?>" />
        <title>
            Intranet BilboDj
        </title>
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

        <script language="javascript">
            function actualizarContadorNotificaciones() {
                fetch("<?= base_url() . 'cliente/notificaciones_ajax' ?>")
                    .then(res => res.json())
                    .then(data => {
                        const total = data.length;
                        const contadores = document.querySelectorAll('.contador-notif');
                        contadores.forEach(contador => {
                            if (total >= 0) {
                                contador.style.display = 'inline-block';
                                contador.innerText = total > 9 ? '9+' : total;
                            } else {
                                contador.style.display = 'none';
                            }
                        });
                    })
                    .catch(err => console.error("Error al cargar notificaciones:", err));
            }

            actualizarContadorNotificaciones();
            setInterval(actualizarContadorNotificaciones, 5000); // Actualiza cada 30s
        </script>


        <!-- Navbar móvil -->
        <nav class="mobile-navbar">
            <span class="navbar-brand"><img src="<?php echo base_url() . $this->config->item('logo_header') ?>" width="50" height="50" /></span>
            <button class="navbar-toggler" id="toggleMenu">&#9776;</button>
        </nav>

        <!-- Menú offcanvas móvil -->
        <div class="offcanvas" id="offcanvasMenu">
            <div class="offcanvas-header">
                <a href="<?= base_url() ?>cliente/notificaciones/view" class="notif-wrapper" style="display: flex; align-items: center; position: relative;">
                    <img src="<?= base_url() ?>img/notificacion.png" class="notif" alt="Notificación" />
                    <span class="contador-notif"></span>
                </a>

                <span style="color: #93CE37; margin-left: 10px; margin-right: 10px;">|</span>
                <span style="color: #93CE37"> Intranet de <?php echo $this->session->userdata('nombre_novia') . ' & ' . $this->session->userdata('nombre_novio') ?></span>
                <button class="btn-close" id="closeMenu">×</button>
            </div>
            <div class="offcanvas-body">
                <ul>
                    <li><a href="<?php echo base_url() ?>cliente/topSongs">Canciones más elegidas</a></li>
                    <li><a href="<?php echo base_url() ?>cliente/datos/view">Mis datos</a></li>
                    <li><a href="<?php echo base_url() ?>cliente/canciones">Mi listado de canciones</a></li>
                    <li><a href="<?php echo base_url() ?>cliente/chat">Chat</a></li>
                    <li><a href="<?php echo base_url() ?>cliente/ofertas">Ofertas destacadas</a></li>
                    <li><a href="<?php echo base_url() ?>cliente/galerias">Galeria de foto</a></li>
                    <li><a href="<?php echo base_url() ?>cliente/invitados">Usuarios Invitado</a></li>
                </ul>
                <ul>
                    <a href="<?= base_url() ?>cliente/logout" class="cerrar_sesion">Cerrar sesión</a>
                </ul>
            </div>
        </div>

        <div id="offcanvasOverlay"></div>

        <!-- Navbar desktop -->
        <nav class="desktop-navbar"> <span class="navbar-brand"><img src="<?php echo base_url() . $this->config->item('logo_header') ?>" width="50" height="50" /></span>
            <ul>
                <li><a href="<?php echo base_url() ?>cliente/topSongs">Canciones más elegidas</a></li>
                <li><a href="<?php echo base_url() ?>cliente/datos/view">Mis datos</a></li>
                <li><a href="<?php echo base_url() ?>cliente/canciones">Mi listado de canciones</a></li>
                <li><a href="<?php echo base_url() ?>cliente/chat">Chat</a></li>
                <li><a href="<?php echo base_url() ?>cliente/ofertas">Ofertas destacadas</a></li>
                <li><a href="<?php echo base_url() ?>cliente/galerias">Galeria de foto</a></li>
                <li><a href="<?php echo base_url() ?>cliente/invitados">Usuarios Invitado</a></li>
            </ul>
            <ul class="loginDisplay">
                <a href="<?= base_url() ?>cliente/notificaciones/view" class="notif-wrapper" style="display: flex; align-items: center; position: relative;">
                    <img src="<?= base_url() ?>img/notificacion.png" class="notif" alt="Notificación" />
                    <span class="contador-notif"></span>
                </a>

                <span style="color: #93CE37; margin-left: 10px; margin-right: 10px;">|</span>
                <span style="color: #93CE37"> Intranet de <?php echo $this->session->userdata('nombre_novia') . ' & ' . $this->session->userdata('nombre_novio') ?></span>
                <span style="color: #93CE37; margin-left: 10px; margin-right: 10px;">|</span>
                <a href="<?= base_url() ?>cliente/logout" class="cerrar_sesion">Cerrar sesión</a>
            </ul>
        </nav>

        <div>&nbsp;</div>
        <div id="header-placeholder"></div>
        <div class="page">

            <style>
                /* Reset básico */
                body {
                    margin: 0;
                    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                }

                /* Navbar móvil */
                .mobile-navbar {
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    background-color: rgb(245, 255, 211);
                    padding: 12px 20px;
                    position: fixed;
                    top: 0;
                    left: 0;
                    width: 100%;
                    z-index: 9999;
                    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
                    color: #f0f0f0;
                    box-sizing: border-box;
                }

                .navbar-brand {
                    font-size: 20px;
                    font-weight: 700;
                    color: #f0f0f0;
                    user-select: none;
                }

                .navbar-toggler {
                    background: none;
                    border: none;
                    font-size: 28px;
                    cursor: pointer;
                    color: #93CE37;
                    transition: color 0.3s ease;
                    position: relative;
                    z-index: 10001;
                }

                /* Offcanvas menú */
                .offcanvas {
                    position: fixed;
                    top: 0;
                    right: 0;
                    width: 280px;
                    height: 100%;
                    background-color: rgb(245, 255, 211);
                    box-shadow: -3px 0 12px rgba(0, 0, 0, 0.25);
                    transition: transform 0.35s cubic-bezier(0.4, 0, 0.2, 1);
                    z-index: 10000;
                    overflow-y: auto;
                    padding: 20px 25px;
                    border-left: 1px solid #e0e0e0;
                    border-radius: 0 0 0 8px;
                    transform: translateX(100%);
                    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                }

                .offcanvas.open {
                    transform: translateX(0);
                }

                .offcanvas-header {
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    margin-bottom: 25px;
                    border-bottom: 1px solid #ddd;
                    padding-bottom: 10px;
                }

                .offcanvas-header h5 {
                    font-size: 22px;
                    font-weight: 700;
                    color: #1e2a38;
                    margin: 0;
                    user-select: none;
                }

                .btn-close {
                    background: none;
                    border: none;
                    font-size: 28px;
                    cursor: pointer;
                    color: #999;
                    transition: color 0.3s ease;
                }

                .btn-close:hover {
                    color: #ff5252;
                }

                /* Lista menú */
                .offcanvas-body ul {
                    list-style: none;
                    padding: 0;
                    margin: 0;
                }

                .offcanvas-body li {
                    margin-bottom: 15px;
                }

                .offcanvas-body a {
                    text-decoration: none;
                    color: #93CE37;
                    font-weight: 600;
                    font-size: 16px;
                    transition: color 0.3s ease;
                    display: block;
                    padding: 6px 10px;
                    border-radius: 4px;
                    margin-bottom: 15px;
                }

                /* Dropdown toggle */
                .dropdown-toggle {
                    cursor: pointer;
                    position: relative;
                    user-select: none;
                }

                .dropdown-toggle::after {
                    content: "▼";
                    font-size: 12px;
                    margin-left: 8px;
                    color: #93CE37;
                    transition: transform 0.3s ease;
                    display: inline-block;
                    vertical-align: middle;
                }

                .dropdown.open>.dropdown-toggle::after {
                    transform: rotate(-180deg);
                    color: rgb(26, 153, 1);
                }

                /* Dropdown menu */
                .dropdown-menu {
                    display: none;
                    padding-left: 15px;
                    margin-top: 6px;
                    border-left: 2px solid rgb(23, 212, 6);
                    margin-left: 10px !important;
                }

                .dropdown.open .dropdown-menu {
                    display: block;
                }

                .dropdown-menu li {
                    margin-bottom: 10px;
                }

                .dropdown-menu a {
                    font-weight: 500;
                    font-size: 14px;
                    color: #93CE37;
                    padding-left: 10px;
                    transition: color 0.25s ease;
                }

                /* Overlay */
                #offcanvasOverlay {
                    position: fixed;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    background: rgba(0, 0, 0, 0.4);
                    opacity: 0;
                    visibility: hidden;
                    transition: opacity 0.3s ease;
                    z-index: 9998;
                }

                #offcanvasOverlay.active {
                    opacity: 1;
                    visibility: visible;
                }

                .ocultar {
                    display: none;
                }

                .cerrar_sesion {
                    margin-top: 50px;
                    color: white !important;
                    text-decoration: none;
                    background-color: rgb(255, 39, 39);
                    border: 1px solid red;
                    border-radius: 4px;
                    padding: 8px;
                    transition: 300ms;
                    text-align: center;
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

                .contador-notif {
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

                .page {
                    margin-top: 100px;
                    /* o lo que necesites */
                }

                #header-placeholder {
                    display: none;
                    height: 100px;
                    /* igual altura que tu header */
                }

                .desktop-navbar {
                    display: none;
                }


                /* ---- ESTILOS PARA PANTALLAS GRANDES ---- */
                @media (min-width: 768px) {

                    .dropdown-menu {
                        margin-left: 0px !important;
                    }

                    .cerrar_sesion {
                        margin-top: 0px;
                    }

                    /* Ocultar navbar móvil y menú offcanvas */
                    .mobile-navbar,
                    .offcanvas,
                    #offcanvasOverlay {
                        display: none !important;
                    }

                    .page {
                        margin-top: 100px;
                        /* o lo que necesites */
                    }

                    #header-placeholder {
                        display: none;
                        height: 50px;
                        /* igual altura que tu header */
                    }

                    nav.desktop-navbar {
                        position: fixed;
                        top: 0;
                        left: 0;
                        right: 0;
                        display: flex;
                        background-color: rgb(245, 255, 211);
                        padding: 12px 40px;
                        justify-content: flex-start;
                        align-items: center;
                        width: 100%;
                        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
                        box-sizing: border-box;
                        margin: 0;
                        z-index: 10000;
                    }

                    body,
                    html {
                        margin: 0;
                        padding: 0;
                    }

                    nav.desktop-navbar .navbar-brand {
                        color: #f0f0f0;
                        font-weight: 700;
                        font-size: 22px;
                        margin-right: 30px;
                        user-select: none;
                    }

                    .desktop-navbar ul {
                        display: flex;
                        list-style: none;
                        padding: 0;
                        margin: 0;
                    }

                    body,
                    html {
                        margin: 0;
                        padding: 0;
                    }

                    nav.desktop-navbar ul li {
                        position: relative;
                        margin-right: 25px;
                    }

                    nav.desktop-navbar ul li a {
                        color: #93CE37;
                        text-decoration: none;
                        font-weight: 600;
                        font-size: 16px;
                        padding: 8px 12px;
                        border-radius: 4px;
                        transition: background-color 0.3s ease, color 0.3s ease;
                        user-select: none;
                    }

                    nav.desktop-navbar ul li a:hover,
                    nav.desktop-navbar ul li a.active {
                        background-color: #93CE37;
                        color: white;
                    }

                    /* Dropdown menu desktop */
                    nav.desktop-navbar ul li.dropdown:hover>ul.dropdown-menu,
                    nav.desktop-navbar ul li.dropdown:focus-within>ul.dropdown-menu {
                        display: block;
                    }

                    /* Asegurar que el contenedor tenga posición relativa */
                    nav.desktop-navbar ul li.dropdown {
                        position: relative;
                    }

                    nav.desktop-navbar ul ul.dropdown-menu {
                        display: none;
                        position: absolute;
                        top: calc(100% + 8px);
                        left: 0;
                        background: rgb(245, 255, 211);
                        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
                        padding: 10px 0;
                        border-radius: 6px;
                        min-width: 180px;
                        z-index: 100000;
                    }

                    nav.desktop-navbar ul ul.dropdown-menu li {
                        margin: 0;
                    }

                    nav.desktop-navbar ul ul.dropdown-menu li a {
                        color: #93CE37;
                        padding: 8px 18px;
                        font-weight: 500;
                        font-size: 14px;
                        display: block;
                        white-space: nowrap;
                        user-select: none;
                    }

                    nav.desktop-navbar ul ul.dropdown-menu li a:hover {
                        background-color: rgb(171, 230, 76);
                        color: #fff;
                    }

                    /* Ocultar icono ▼ en desktop */
                    nav.desktop-navbar ul li>a.dropdown-toggle::after {
                        content: "";
                        margin-left: 0;
                    }

                    nav.desktop-navbar .loginDisplay {
                        margin-left: auto;
                        display: flex;
                        align-items: center;
                    }
                }
            </style>

            <script>
                // Toggle offcanvas menu en móvil
                const toggleBtn = document.getElementById('toggleMenu');
                const closeBtn = document.getElementById('closeMenu');
                const offcanvasMenu = document.getElementById('offcanvasMenu');
                const overlay = document.getElementById('offcanvasOverlay');

                toggleBtn.addEventListener('click', () => {
                    offcanvasMenu.classList.add('open');
                    overlay.classList.add('active');
                });
                closeBtn.addEventListener('click', () => {
                    offcanvasMenu.classList.remove('open');
                    overlay.classList.remove('active');
                });
                overlay.addEventListener('click', () => {
                    offcanvasMenu.classList.remove('open');
                    overlay.classList.remove('active');
                });

                // Dropdown toggle en móvil
                document.querySelectorAll('.offcanvas .dropdown-toggle').forEach(item => {
                    item.addEventListener('click', e => {
                        e.preventDefault();
                        const parent = e.target.closest('.dropdown');
                        parent.classList.toggle('open');
                    });
                });
            </script>

            <!-- SCRIPTS HEADER -->
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

            <script>
                // Dropdowns
                document.addEventListener('DOMContentLoaded', function() {
                    document.querySelectorAll('.dropdown-toggle').forEach(function(toggle) {
                        toggle.addEventListener('click', function(e) {
                            e.preventDefault();
                            const dropdownMenu = this.nextElementSibling;
                            document.querySelectorAll('.dropdown-menu').forEach(menu => {
                                if (menu !== dropdownMenu) menu.style.display = 'none';
                            });
                            dropdownMenu.style.display = dropdownMenu.style.display === 'block' ? 'none' : 'block';
                        });
                    });

                    // Menú móvil
                    const toggleMenu = document.getElementById('toggleMenu');
                    const closeMenu = document.getElementById('closeMenu');
                    const offcanvas = document.getElementById('offcanvasMenu');
                    const overlay = document.getElementById('offcanvasOverlay');

                    toggleMenu.onclick = () => {
                        offcanvas.classList.add('open');
                        overlay.style.display = 'block';
                    };
                    closeMenu.onclick = () => {
                        offcanvas.classList.remove('open');
                        overlay.style.display = 'none';
                    };
                    overlay.onclick = () => {
                        offcanvas.classList.remove('open');
                        overlay.style.display = 'none';
                    };
                });
            </script>