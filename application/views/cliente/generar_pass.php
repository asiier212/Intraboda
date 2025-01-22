<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Contraseña generada</title>
<link href="<?php echo base_url() ?>css/style.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url() ?>js/jquery/js/jquery-1.7.2.min.js"></script>
</head>
<body>
<div id="top"><div>&nbsp;</div></div>
<div class="page">
<div class="header">
  <div class="title">
    <h1> <img src="<?php echo base_url() ?>img/logo_intranet.png" /></h1>
  </div>
  <div class="loginDisplay"> </div>
  
</div>
 <h2>Recordar Contraseña</h2>
<div class="main">
 
  <div style="margin:0 auto; text-align:center; width:400px; padding:20px">
    <form method="post" style="width:300px">
      <fieldset style="width:300px">
        <legend>Recordar la contraseña</legend>
        <label for="admin_name" style="margin:0 5px 0 0; width:120px; font-size:15px; font-weight:bold;">Tu nueva contraseña de acceso a Intraboda es:</label>
        <br /><br />
        <div style="text-align:center; padding-top:5px"> <font style="font-size:25px; color:#F00; font-weight:bold;">
          <?php if(isset($msg)) echo $msg?>
          &nbsp;</font></div>
         
        <br /><br />
        <div style="padding-top:5px"> <font style="font-size:15px; font-weight:bold;">
          <a href="<?php echo base_url() ?>cliente/login">Accede con tu nueva contraseña aquí</a>
          </font></div>
        <br />
          <div style="text-align:right; padding-top:5px"> <font style="font-size:smaller;">
          Versión <?php echo version?>
          &nbsp;</font></div>
      </fieldset>
    </form>
  </div>
  <div class="clear"></div>
</div>
<div class="footer"> </div>
</div>
</body>
</html>