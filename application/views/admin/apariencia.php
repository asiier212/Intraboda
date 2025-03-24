<h2>Apariencia</h2>

<fieldset>
    <legend>Logo del Header</legend>
    <?php $logo = $this->config->item('logo_header'); ?>
    <div style="display: flex; align-items: center; gap: 10px;">
        <!-- Logo actual -->
        <img src="<?php echo base_url() . $logo ?>" style="max-width:80px" alt="Logo" />

        <!-- Botón para eliminar el logo actual solo si no es el por defecto -->
        <?php if ($logo !== 'img/logo_intranet.png'): ?>
            <form action="" method="post">
                <input type="submit" name="delete_logo" value="x">
            </form>
        <?php endif; ?>
    </div>
    <br>

    <!-- Formulario para subir un nuevo logo -->
    <form action="" method="post" enctype="multipart/form-data">
        <label for="logo">Subir nuevo logo:</label>
        <input type="file" name="logo" id="logo" accept="image/*"><br><br>
        <input type="submit" name="update_logo" value="Subir">
    </form>
</fieldset>

<fieldset>
    <legend>Favicon</legend>
    <?php $favicon = $this->config->item('favicon'); ?>
    <div style="display: flex; align-items: center; gap: 10px;">
        <!-- Favicon actual -->
        <img src="<?php echo base_url() . $favicon; ?>" style="max-width:80px" alt="Favicon" />

        <!-- Botón para eliminar el favicon solo si no es el por defecto -->
        <?php if ($favicon !== 'img/favicon.png'): ?>
            <form action="" method="post">
                <input type="submit" name="delete_favicon" value="x">
            </form>
        <?php endif; ?>
    </div>
    <br>

    <!-- Formulario para subir un nuevo favicon -->
    <form action="" method="post" enctype="multipart/form-data">
        <label for="favicon">Subir nuevo favicon:</label>
        <input type="file" name="favicon" id="favicon" accept="image/x-icon,image/png"><br><br>
        <input type="submit" name="update_favicon" value="Subir">
    </form>
</fieldset>

<fieldset>
    <legend>Cabecera Email</legend>
    <?php $cabecera = $this->config->item('email_header'); ?>
    <div style="display: flex; align-items: center; gap: 10px;">
        <img src="<?php echo base_url() . $cabecera ?>" style="max-width:400px" alt="Cabecera" />
        <?php if ($cabecera !== 'img/img_mail/cabecera.jpg'): ?>
            <form action="" method="post">
                <input type="submit" name="delete_email_header" value="x">
            </form>
        <?php endif; ?>
    </div>
    <br>
    <form action="" method="post" enctype="multipart/form-data">
        <label for="cabecera_mail">Subir nueva cabecera:</label>
        <input type="file" name="cabecera_mail" accept="image/*"><br><br>
        <input type="submit" name="update_email_header" value="Subir">
    </form>
</fieldset>

<fieldset>
    <legend>Pie Email</legend>
    <?php $pie = $this->config->item('email_footer'); ?>
    <div style="display: flex; align-items: center; gap: 10px;">
        <img src="<?php echo base_url() . $pie ?>" style="max-width:400px" alt="Pie Email" />
        <?php if ($pie !== 'img/img_mail/pie.jpg'): ?>
            <form action="" method="post">
                <input type="submit" name="delete_email_footer" value="x">
            </form>
        <?php endif; ?>
    </div>
    <br>
    <form action="" method="post" enctype="multipart/form-data">
        <label for="pie_mail">Subir nuevo pie:</label>
        <input type="file" name="pie_mail" accept="image/*"><br><br>
        <input type="submit" name="update_email_footer" value="Subir">
    </form>
</fieldset>