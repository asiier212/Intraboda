<script type="text/javascript" src="<?php echo base_url() ?>js/jquery/development-bundle/ui/jquery.jeditable.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/alertify/lib/alertify.js"></script>
<link rel="stylesheet" href="<?php echo base_url() ?>js/alertify/themes/alertify.core.css" />
<link rel="stylesheet" href="<?php echo base_url() ?>js/alertify/themes/alertify.default.css" />

<script language="javascript">
    $(document).ready(function() {
        $('.edit_box').editable('<?php echo base_url() ?>index.php/ajax/updatedatocliente/<?php echo $cliente['id'] ?>', {
            type: 'text',
            submit: '<img src="<?php echo base_url() ?>img/save.gif" />',
            tooltip: 'Click para editar...',
        });
    });

    function deleteobservacion_admin(id) {
        if (confirm("\u00BFSeguro que desea borrar la observaci\u00f3n?")) {

            $.ajax({
                type: 'POST',
                url: '<?php echo base_url() ?>index.php/ajax/deleteobservacion_admin',
                data: 'id=' + id,
                success: function(data) {
                    $("#o_" + id).css("display", "none");
                    $("#result").html("");
                }
            });
        }
        return false
    }

    function muestra_componentes_equipo(componentes) {
        alertify.alert(componentes);
    }
</script>
<style>
    .editable img {
        float: right
    }
</style>
<h2>
    Detalles del cliente
</h2>
<div class="main form">
    <?php
    session_start(); //Sesión para controlar que no puedan acceder DJ a fichas de clientes que NO son suyos
    $_SESSION['id_restaurante'] =  $this->session->userdata('restaurante_id');
    ?>

    <form method="post" enctype="multipart/form-data">
        <fieldset class="datos">
            <legend>Datos de contacto</legend>

            <br clear="left" />
            <fieldset style="width:350px">
                <legend>Datos del Novio</legend>
                <ul class="editable">
                    <li><label>Nombre:</label><span id="nombre_novio"><?php echo $cliente['nombre_novio'] ?></span> </li>
                    <li><label>Apellidos:</label><span id="apellidos_novio"><?php echo $cliente['apellidos_novio'] ?></span></li>
                    <li><label>Direcci&oacute;n:</label><span id="direccion_novio"><?php echo $cliente['direccion_novio'] ?></span></li>
                    <li><label>CP:</label><span id="cp_novio"><?php echo $cliente['cp_novio'] ?></span></li>
                    <li><label>Poblaci&oacute;n:</label><span id="poblacion_novio"><?php echo $cliente['poblacion_novio'] ?></span></li>
                    <li><label>Telefono:</label><span id="telefono_novio"><?php echo $cliente['telefono_novio'] ?></span></li>
                    <li><label>Email:</label><span id="email_novio"><?php echo $cliente['email_novio'] ?></span></li>
                </ul>
            </fieldset>
            <fieldset style="width:350px">
                <legend>Datos de la Novia</legend>
                <ul>
                    <li><label>Nombre:</label><span id="nombre_novia"><?php echo $cliente['nombre_novia'] ?></span></li>
                    <li><label>Apellidos:</label><span id="apellidos_novia"><?php echo $cliente['apellidos_novia'] ?></span></li>
                    <li><label>Direcci&oacute;n:</label><span id="direccion_novia"><?php echo $cliente['direccion_novia'] ?></span></li>
                    <li><label>CP:</label><span id="cp_novia"><?php echo $cliente['cp_novia'] ?></span></li>
                    <li><label>Poblaci&oacute;n:</label><span id="poblacion_novia"><?php echo $cliente['poblacion_novia'] ?></span></li>
                    <li><label>Telefono:</label><span id="telefono_novia"><?php echo $cliente['telefono_novia'] ?></span></li>
                    <li><label>Email:</label><span id="email_novia"><?php echo $cliente['email_novia'] ?></span></li>
                </ul>
            </fieldset>
            <br class="clear" />


        </fieldset>
        <fieldset class="datos">
            <legend>Datos de la boda</legend>
            <ul>
                <li><label>Fecha de la boda:</label><span id="fecha_boda"><?php echo $cliente['fecha_boda'] ?></span></li>
                <li><label>Hora de la boda:</label>
                    <span id="hora_boda"><?php echo $cliente['hora_boda'] ?></span>
                </li>
                <li><label>Restaurante:</label><span id="restaurante"><?php echo $cliente['restaurante'] ?></span></li>
                <li><label>Dirreci&oacute;n del Restaurante:</label><span id="direccion_restaurante"><?php echo $cliente['direccion_restaurante'] ?></span></li>
                <li><label>Tel&eacute;fono del Restaurante:</label><span id="telefono_restaurante"><?php echo $cliente['telefono_restaurante'] ?></span></li>
                <li><label>Maitre de la boda:</label><span id="maitre"><?php echo $cliente['maitre'] ?></span></li>
                <li><label>Tel&eacute;fono Maitre:</label><span id="telefono_maitre"><?php echo $cliente['telefono_maitre'] ?></span></li>
            </ul>
            <?php
            if (isset($cliente['restaurante_archivos'])) {
            ?><ul><?php
                    foreach ($cliente['restaurante_archivos'] as $ra) {
                    ?>
                        <li><label><?php echo $ra['descripcion'] ?>:</label><span><a href="<?php echo base_url() ?>uploads/restaurantes/<?php echo $ra['archivo'] ?>" target="_blank"><?php echo $ra['archivo'] ?></a></span></li>
                    <?php
                    }
                    ?>
                </ul><?php
                    }
                        ?>

        </fieldset>


        <fieldset class="datos">
            <legend>Servicios</legend>
            <ul>
                <?php
                $arr_servicios = unserialize($cliente['servicios']);
                $total = array_sum($arr_servicios);
                $arr_serv_keys = array_keys($arr_servicios);
                foreach ($servicios as $servicio) {
                    if (!in_array($servicio['id'], $arr_serv_keys)) continue; // ← esto filtra los no marcados
                ?>
                    <li>
                        <input type="checkbox"
                            name="servicios[<?php echo $servicio['id'] ?>]"
                            checked="checked"
                            id="chserv_<?php echo $servicio['id'] ?>"
                            value="<?php echo $arr_servicios[$servicio['id']] ?>"
                            style="width:30px; vertical-align:middle"
                            disabled />
                        <?php echo $servicio['nombre']; ?>
                    </li>
                <?php } ?>
            </ul>
        </fieldset>

        <fieldset class="datos">
            <legend>Observaciones</legend>

            <?php if (!$observaciones_cliente): ?>
                <p style="text-align:center;padding:20px">Todavía no se han añadido observaciones</p>
            <?php else: ?>
                <ul class="observaciones obs_admin" id="lista_observaciones">
                    <?php foreach ($observaciones_cliente as $observacion): ?>
                        <li id="o_<?php echo $observacion['id']; ?>"
                            style="margin-bottom: 10px; padding: 10px; border: 1px solid #ccc; 
                    border-radius: 5px; background-color: #f9f9f9; 
                    display: flex; justify-content: space-between; align-items: center;">

                            <div>
                                <strong>Observación:</strong> <?php echo $observacion['comentario']; ?><br>
                                <span>Link:</span>
                                <?php
                                $url = trim($observacion['link']);
                                if (!empty($url)) {
                                    if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
                                        $url = "http://" . $url;
                                    }
                                    echo '<a href="' . htmlspecialchars($url, ENT_QUOTES, 'UTF-8') . '" target="_blank" 
                            style="color: #007bff; text-decoration: none;">' . htmlspecialchars($observacion['link'], ENT_QUOTES, 'UTF-8') . '</a><br>';
                                }
                                ?>
                                <small style="color: #666;">Fecha: <?php echo date('d/m/Y', strtotime($observacion['fecha'])); ?></small>
                            </div>

                            <a href="#" onclick="return deleteobservacion_admin(<?php echo $observacion['id']; ?>)">
                                <img src="<?php echo base_url(); ?>img/delete.gif" width="15" alt="Eliminar" style="margin-right: 10px" />
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>

            <li style="padding:8px 0;"><strong>Añadir Observación:</strong></li>

            <form method="post" action="" id="form_observacion" style="display: flex; flex-direction: column; align-items: left;">
                <textarea name="observaciones" id="observaciones" style="width:100%; height:50px; float:left;"
                    placeholder="Observación"></textarea>
                <br>

                <li style="padding:8px 0;"><strong>Link:</strong></li>
                <input style="text-align: left" type="text" name="link" id="link"
                    placeholder="Ej.: https://www.youtube.com/watch?v=a1Femq4NPxs" style="width:300px; float:left" />
                <br>
                <input type="submit" name="add_observ" value="Añadir">
            </form>

            <!-- Cargar TinyMCE -->
            <script src="<?php echo base_url() . "js/tinymce/tinymce.min.js" ?>"></script>

            <script>
                // Inicialización de TinyMCE
                document.addEventListener("DOMContentLoaded", function() {
                    tinymce.init({
                        selector: 'textarea',
                        toolbar: 'bold italic fontsizeselect',
                        font_size_formats: '8pt 10pt 12pt 14pt 18pt 24pt 36pt',
                        content_style: 'body { font-size: 14px; }',
                        branding: false,
                        menubar: false,
                        height: 200,
                    });
                });

                document.addEventListener("DOMContentLoaded", function() {
                    var form = document.getElementById("form_observacion");
                    var textarea = document.getElementById("observaciones");

                    // Eliminar required porque el campo está oculto
                    textarea.removeAttribute("required");

                    // Agregar validación en el submit
                    form.addEventListener("submit", function(event) {
                        var editor = tinymce.get("observaciones"); // Obtener instancia de TinyMCE
                        var content = editor ? editor.getContent().trim() : textarea.value.trim(); // Obtener contenido

                        if (!content) {
                            alert("El campo de observación no puede estar vacío.");
                            event.preventDefault(); // Evita el envío del formulario
                        }
                    });
                });
            </script>

            <div style="text-align:center; clear: left; margin-top:20px">
                <?php if ($this->session->flashdata('msg')): ?>
                    <p><?php echo $this->session->flashdata('msg'); ?></p>
                <?php endif; ?>
            </div>
        </fieldset>
        <div class="clear"> </div>
        <p style="text-align:center"></p>
    </form>
</div>
<div class="clear">
</div>