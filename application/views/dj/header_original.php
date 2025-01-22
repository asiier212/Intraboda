<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Intranet BilboDj</title>
<link href="<?php echo base_url() ?>css/style.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url() ?>js/jquery/development-bundle/jquery-1.7.2.js"></script>  
<?php if (isset($scripts_src)) echo $scripts_src;?>
<script language="javascript" type="text/javascript">
$(function() {
  $('ul.menu li ul').each(function(index) {
    $(this).width($(this).parent('ul.menu li').width());
	});
});	
<?php if (isset($scripts)) echo $scripts;?>
</script>   
</head>
<body>
	<div id="top"><div>&nbsp;</div></div>
    <div class="page">
        <div class="header">
            <div class="title">
                <h1>
                 <img src="<?php echo base_url() ?>img/logo-bilbodj.png" />
                </h1>
            </div>
            <div class="loginDisplay">
                Panel de gesti&oacute;n del DJ <?php echo $this->session->userdata('nombre_dj') ?> | <a id="" href="<?php echo base_url() ?>dj/logout">Cerrar sesión</a>
            </div>
            <div class="hideSkiplink">
                <ul class="menu">
                    <li><a href="<?php echo base_url() ?>dj/clientes/add">Añadir Cliente</a></li>
                    <li><a href="<?php echo base_url() ?>dj/clientes/view">Listar Clientes</a></li>
                 	<li><a href="<?php echo base_url() ?>dj/servicios/view">Servicios</a></li>
                    
                    <li><a href="<?php echo base_url() ?>dj/persons/view">Personas de contacto</a></li>
                </ul>
            </div>
        </div>