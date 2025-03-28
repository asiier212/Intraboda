<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="icon" type="image/png" href="<?php echo base_url() ?>img/favicon.png">
<title>Acceso Restaurante</title>
<link href="<?php echo base_url() ?>css/style.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url() ?>js/jquery/js/jquery-1.7.2.min.js"></script>
</head>
<body>
<div id="top"><div>&nbsp;</div></div>
<div class="page">
<div class="header">
  <div class="title">
    <h1><img src="<?php echo base_url() ?>img/logo_intranet.png" /></h1>
  </div>
  <div class="loginDisplay"> </div>
</div>

<h2 style="color:#93CE37!important;">Acceso Restaurantes</h2>

<div class="main">
  <div style="margin:0 auto; text-align:center; width:400px; padding:20px">
    <form method="post" style="width:300px">
      <fieldset style="width:300px">
        <legend>Log in</legend>

        <label for="email" style="float:left; margin:0 5px 0 0; width:120px">Email Maitre:</label>
        <input style="float: left; margin:0 0 2px 0" type="text" name="email" value="" />
        <br style="clear:both; height:10px;" />

        <label for="pass" style="float:left; margin:0 5px 0 0; width:120px">Contraseña:</label>
        <input style="float: left; margin:0 0 2px 0" type="password" name="clave" value="" />
        <br style="clear:both" />

        <input type="submit" value="Entrar &raquo;" style="margin:5px 0 0 140px; width:100px" />
        <br style="clear:both" />

        <div style="text-align:center; padding-top:5px">
          <font style="font-size:smaller; color:#F00">
            <?php if(isset($msg)) echo $msg ?>
          </font>
        </div>

        <br />

        <div style="text-align:right; padding-top:5px">
          <font style="font-size:smaller;">Versión <?php echo version ?>&nbsp;</font>
        </div>
      </fieldset>
    </form>
  </div>
  <div class="clear"></div>
</div>

<div class="footer"> </div>
</div>
</body>
</html>
