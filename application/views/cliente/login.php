<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link rel="icon" type="image/png" href="<?php echo base_url() ?>img/favicon.png">
  <title></title>

  <script src="<?php echo base_url() ?>js/jquery/js/jquery-1.7.2.min.js"></script>
</head>

<body style="
  background-image: url('<?php echo base_url() ?>img/loginFondo.png');
  background-repeat: no-repeat;
  background-position: center center;
  background-size: cover;
  background-attachment: fixed;
  font-family: Arial, sans-serif;
">


  <div id="top">
    <div>&nbsp;</div>
  </div>
  <div class="page">
    <div class="header">
      <div class="title">
        <h1> <img class="logo" src="<?php echo base_url() ?>img/exel-mini-logo-blanco.png" /></h1>
      </div>
      <div class="loginDisplay"> </div>

    </div>
    <h2 class="titleH2">Exel Eventos</h2>
    <div class="main">



      <div style="margin:0 auto; text-align:center; width:400px; padding:20px">
        <form method="post" style="width:300px">
          <fieldset class="login-box">

            <?php if (isset($msg)): ?>
              <div class="login-msg">
                <?php echo $msg; ?>
              </div>
            <?php endif; ?>

            <label class="usuario" for="admin_name">E-mail Novia/Novio:</label>
            <input type="text" name="email" placeholder="Tu usuario" />

            <label for="pass">Contraseña:</label>
            <input class="password" type="password" name="pass" placeholder="Tu contraseña" />

            <input type="submit" class="submit" value="Entrar »" />

            <br style="clear:both" />

            <div class="ppass">
              <font style="font-size:smaller;">
                <a href="<?php echo base_url() ?>cliente/recordar_pass">¿Perdiste tu contraseña?</a>
              </font>
            </div>

            <div class="login-version">
              Versión <?php echo version ?>
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

<style>
  .submit {
    width: 100%;
    margin-top: 25px;
    padding: 9px;
    background-color: #00cc00;
    color: #ffffff;
    border: 2px solid #00ff00;
    border-radius: 8px;
    font-family: 'WorkSans', sans-serif;
    font-weight: bold;
    font-size: 16px;
    cursor: pointer;
    transition: all 0.3s ease-in-out;
    margin-bottom: 8px;
  }

  .submit:hover {
    background-color: rgb(0, 175, 0);
    box-shadow: 0px 0px 5px 0px rgb(0, 175, 0);
  }


  .titleH2 {
    font-family: 'NeonTubes', sans-serif;
    font-size: 70px;
    color: #00ff00;
    text-shadow: rgb(40, 146, 30) 0px 0px 12.9763px, rgb(40, 146, 30) 0px 0px 38.9289px, rgb(40, 146, 30) 0px 0px 129.763px, rgb(40, 146, 30) 0px 0px 129.763px, rgb(43, 156, 33) 0px 0px 5.19052px, rgb(35, 89, 18) 9.6px 9.6px 1.92px;
    text-align: center;

  }

  .logo {
    width: 50px;
    height: auto;
    margin-left: 20px;
  }

  @font-face {
    font-family: 'NeonTubes';
    src: url('<?php echo base_url() ?>img/fonts/NeonTubes2.otf') format('truetype');
    font-weight: normal;
    font-style: normal;
  }

  @font-face {
    font-family: 'WorkSans';
    src: url('<?php echo base_url() ?>img/fonts/WorkSans.ttf') format('truetype');
    font-weight: normal;
    font-style: normal;
  }

  .login-box {
    width: 100%;
    padding: 40px;
    background: #fff;
    border-radius: 12px;
    border: 2px solid rgb(0, 189, 0);
    box-shadow:
      0 0 10px rgb(0, 189, 0),
      0 0 20px rgb(0, 189, 0),
      0 0 40px rgb(0, 189, 0);
    transition: all 0.3s ease-in-out;
    font-family: 'WorkSans', sans-serif;
  }

  .usuario {
    margin-top: 0 !important;
  }

  .password {
    margin-bottom: 5px !important;
  }

  .login-box label {
    display: block;
    margin: 20px 0px 12px 0px;
    color: #3c3c3c;
    font-weight: bold;
    text-align: left;
    font-family: 'WorkSans', sans-serif;
  }

  .login-box input[type="text"],
  .login-box input[type="password"] {
    width: 90%;
    padding: 10px;
    border: 2px solid rgb(0, 189, 0);
    border-radius: 4px;
    transition: border 0.3s, box-shadow 0.3s;
    font-family: 'WorkSans', sans-serif;
  }

  .login-box input[type="text"]:focus,
  .login-box input[type="password"]:focus {
    border-color: rgb(0, 189, 0);
    box-shadow: 0 0 10px #00ff00;
    outline: none;
  }

  .login-msg {
    text-align: center;
    padding: 9px;
    font-size: smaller;
    color: #F00;
    background-color: rgb(255, 139, 139);
    border: 1px solid red;
    border-radius: 2px;
    margin-bottom: 20px;
  }

  .login-version {
    text-align: right;
    font-size: smaller;
    padding-top: 10px;
  }

  .ppass {
    padding-top: 8px;
    padding-bottom: 2px;
  }

  .ppass a {
    text-decoration: none;
    transition: 300ms;
    color: black;
  }

  .ppass a:hover {
    color: #00cc00;
    transition: 300ms;
  }
</style>