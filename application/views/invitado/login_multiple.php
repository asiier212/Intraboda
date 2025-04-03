<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link rel="icon" type="image/png" href="<?php echo base_url() ?>img/favicon.png">
  <title>Acceso Invitado</title>
  <link href="<?php echo base_url() ?>css/style.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="top"><div>&nbsp;</div></div>
<div class="page">
  <div class="header">
    <div class="title">
      <h1><img src="<?php echo base_url() ?>img/logo_intranet.png" /></h1>
    </div>
  </div>

  <h2 style="color:#93CE37!important;">Acceso Invitados</h2>

  <div class="main">
    <div style="margin:0 auto; text-align:center; width:500px; padding:20px">
      <fieldset style="width:100%">
        <legend>Selecciona una cuenta</legend>
        <p style="margin-bottom:15px;">
          Hemos detectado que este correo y contraseña están asociados a varios clientes.<br>
          Por favor, selecciona la cuenta a la que deseas acceder:
        </p>

        <ul style="list-style: none; padding: 0;">
          <?php foreach ($opciones as $op): ?>
            <?php
              $cliente = $this->invitado_functions->GetCliente($op->id_cliente);
              $nombre = $cliente['nombre_novio'] . " y " . $cliente['nombre_novia'];
              $fecha = $cliente['fecha_boda'];
            ?>
            <li style="margin-bottom: 12px;">
              <form method="post" action="<?php echo base_url() ?>invitado/login_seleccion">
                <input type="hidden" name="id_invitado" value="<?php echo $op->id; ?>" />
                <button type="submit" style="padding: 8px 20px; font-size: 14px;">
                  Acceder a la cuenta de <strong><?php echo $nombre ?></strong> (<?php echo $fecha ?>)
                </button>
              </form>
            </li>
          <?php endforeach; ?>
        </ul>
      </fieldset>
    </div>
  </div>
</div>
</body>
</html>
