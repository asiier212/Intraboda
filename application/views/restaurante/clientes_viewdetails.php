<script type="text/javascript" src="<?php echo base_url() ?>js/jquery/development-bundle/ui/jquery.jeditable.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/alertify/lib/alertify.js"></script>
<link rel="stylesheet" href="<?php echo base_url() ?>js/alertify/themes/alertify.core.css" />
<link rel="stylesheet" href="<?php echo base_url() ?>js/alertify/themes/alertify.default.css" />

<script language="javascript">
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
            <legend>Encuesta</legend>
            <?php if (!empty($preguntas_encuesta_datos_boda)) { ?>
                <form>
                    <?php foreach ($preguntas_encuesta_datos_boda as $pregunta) { ?>
                        <span>
                            <strong><?php echo htmlspecialchars($pregunta['pregunta']); ?></strong>
                            <?php if (!empty($pregunta['descripcion'])) { ?>
                                <span><?php echo $pregunta['descripcion']; ?></span>
                            <?php } else { ?>
                                <br><br>
                            <?php } ?>

                            <?php
                            $respuestas = array();
                            foreach ($opciones_respuestas_encuesta_datos_boda as $resp) {
                                if (intval($resp['id_pregunta']) === intval($pregunta['id_pregunta'])) {
                                    $respuestas[] = $resp;
                                }
                            }

                            if (!is_array($respuesta_cliente)) {
                                $respuesta_cliente = array();
                            }

                            $respuesta_cliente_actual = null;
                            $respuestas_seleccionadas = array();

                            foreach ($respuesta_cliente as $resp) {
                                if ($resp['id_pregunta'] == $pregunta['id_pregunta']) {
                                    if ($pregunta['tipo_pregunta'] == 'multiple') {
                                        $respuestas_seleccionadas = array_merge($respuestas_seleccionadas, array_map('trim', explode(',', $resp['respuesta'])));
                                    } else {
                                        $respuesta_cliente_actual = $resp['respuesta'];
                                    }
                                }
                            }

                            $tipo = isset($pregunta['tipo_pregunta']) ? strtolower($pregunta['tipo_pregunta']) : '';
                            ?>

                            <?php if ($tipo == 'rango') { ?>
                                <input type="range" min="0" max="10" value="<?php echo htmlspecialchars(!empty($respuesta_cliente_actual) ? $respuesta_cliente_actual : 5); ?>" disabled>
                                <span><?php echo htmlspecialchars(!empty($respuesta_cliente_actual) ? $respuesta_cliente_actual : 'No respondido'); ?></span>

                            <?php } elseif ($tipo == 'opciones' && !empty($respuestas)) { ?>
                                <?php
                                $respuesta_encontrada = false;
                                foreach ($respuestas as $respuesta) {
                                    if (!empty($respuesta_cliente_actual) && $respuesta_cliente_actual == $respuesta['respuesta']) {
                                        $respuesta_encontrada = true;
                                    }
                                }
                                ?>

                                <?php foreach ($respuestas as $respuesta) { ?>
                                    <label>
                                        <input type="radio" disabled
                                            <?php echo (!empty($respuesta_cliente_actual) && $respuesta_cliente_actual == $respuesta['respuesta']) ? 'checked' : ''; ?>>
                                        <?php echo htmlspecialchars($respuesta['respuesta']); ?>
                                    </label><br>
                                <?php } ?>

                                <?php if (!$respuesta_encontrada && !empty($respuesta_cliente_actual)) { ?>
                                    <!-- Mostrar input de número si la respuesta no coincide con ninguna opción -->
                                    <label>
                                        <input type="radio" disabled checked>
                                        Número exacto:
                                        <input type="number" value="<?php echo htmlspecialchars($respuesta_cliente_actual); ?>" disabled>
                                    </label><br>
                                <?php } ?>

                            <?php } elseif ($tipo == 'multiple' && !empty($respuestas)) { ?>
                                <?php
                                $respuestas_disponibles = array_map(function ($r) {
                                    return trim($r['respuesta']);
                                }, $respuestas);

                                $respuestas_extra = array_filter($respuestas_seleccionadas, function ($r) use ($respuestas_disponibles) {
                                    return !in_array($r, $respuestas_disponibles);
                                });
                                ?>

                                <?php foreach ($respuestas as $respuesta) { ?>
                                    <label>
                                        <input type="checkbox" disabled
                                            <?php echo (!empty($respuestas_seleccionadas) && in_array(trim($respuesta['respuesta']), $respuestas_seleccionadas)) ? 'checked' : ''; ?>>
                                        <?php echo htmlspecialchars($respuesta['respuesta']); ?>
                                    </label><br>
                                <?php } ?>

                                <?php foreach ($respuestas_extra as $respuesta_extra) { ?>
                                    <label>
                                        <input type="checkbox" disabled checked>
                                        <?php echo htmlspecialchars($respuesta_extra); ?>
                                    </label><br>
                                <?php } ?>

                            <?php } elseif ($tipo == 'texto') { ?>
                                <input type="text" value="<?php echo htmlspecialchars(!empty($respuesta_cliente_actual) ? $respuesta_cliente_actual : 'No respondido'); ?>" disabled>

                            <?php } else { ?>
                                <p>El tipo de pregunta <strong><?php echo htmlspecialchars($tipo); ?></strong> no está soportado.</p>
                            <?php } ?>
                        </span>
                        <br><br>
                    <?php } ?>
                </form>
            <?php } else { ?>
                <li>No se ha realizado la encuesta</li>
            <?php } ?>
        </fieldset>



        <fieldset class="datos">
            <legend>Observaciones</legend>

            <?php
            // Filtramos solo las observaciones que no están ocultas
            $observaciones_visibles = array_filter($observaciones_cliente, function ($o) {
                return $o['ocultar'] == 0;
            });
            ?>

            <?php if (empty($observaciones_visibles)): ?>
                <p style="text-align:center;padding:20px">Todavía no se han añadido observaciones</p>
            <?php else: ?>
                <ul class="observaciones obs_admin" id="lista_observaciones">
                    <?php foreach ($observaciones_visibles as $observacion): ?>
                        <li id="o_<?php echo $observacion['id']; ?>"
                            style="margin-bottom: 10px; padding: 10px; border: 1px solid #ccc; border-radius: 5px; background-color: #f9f9f9; display: flex; justify-content: space-between; align-items: center;">
                            <div>
                                <strong>Observación:</strong> <?php echo $observacion['comentario']; ?><br>
                                <span>Link:</span>
                                <?php
                                $url = trim($observacion['link']);
                                if (!empty($url)) {
                                    if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
                                        $url = "http://" . $url;
                                    }
                                    echo '<a href="' . htmlspecialchars($url, ENT_QUOTES, 'UTF-8') . '" target="_blank" style="color: #007bff; text-decoration: none;">' . htmlspecialchars($observacion['link'], ENT_QUOTES, 'UTF-8') . '</a><br>';
                                }
                                ?>
                                <small style="color: #666;">Fecha: <?php echo date('d/m/Y', strtotime($observacion['fecha'])); ?></small>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>

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