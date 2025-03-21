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
	$_SESSION['id_dj'] =  $this->session->userdata('id');
	?>

	<form method="post" enctype="multipart/form-data">
		<fieldset class="datos">
			<legend>Datos de contacto</legend>

			<p style="text-align:right"><a style="text-decoration:underline" target="_blank" href="<?php echo base_url() ?>dj/clientes/initsession/<?php echo $cliente['id'] ?>">Iniciar Sesi&oacute;n en la cuenta del usuario</a></p>
			<p style="text-align:right"><a style="text-decoration:underline" target="_blank" href="<?php echo base_url() ?>informes/ficha.php?id_cliente=<?php echo $cliente['id'] ?>">Descargar ficha del usuario</a></p>
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

			<br>
			<?php
			if ($horas_dj) {
			?>
				<fieldset>
					<legend>Horas</legend>
					<table class="tabledata">
						<th>CONCEPTO</th>
						<th>HORAS</th>
						<?php
						foreach ($horas_dj as $h) {
						?>
							<tr>
								<?php
								if ($h['horas_dj'] <> 0) {
								?>
									<td><?php echo $h['concepto'] ?></td>
									<td><?php echo $h['horas_dj'] ?></td>
								<?php
								} else {
								?>
									<td colspan="2"><?php echo $h['concepto'] ?></td>
								<?php
								}
								?>
							</tr>
					<?php
						}
					}
					?>
					</table>
				</fieldset>
		</fieldset>

		<fieldset class="datos">
			<legend>Equipamiento destinado a la boda</legend>

			Equipo componentes:
			<?php
			if ($equipo_componentes_asignado) {
				$se_compone_de = "";
				foreach ($equipo_componentes_asignado as $equipo) {
					$se_compone_de = "<font size=\"+1\"><b>ESTE EQUIPO SE COMPONE DE: </b></font><br>(Haz click para ver las reparaciones de cada componente)<br>";
					foreach ($componentes as $c) {
						if ($equipo['id_grupo'] == $c['id_grupo']) {
							$reparado = "";
							$esta_reparado = "NO";
							if ($reparaciones_totales) {
								foreach ($reparaciones_totales as $r) {
									if ($c['id_componente'] == $r['id_componente']) {
										$reparado = $reparado . "\\n" . $r['fecha_reparacion'] . "\\n" . $r['reparacion'];
										$esta_reparado = "SI";
									}
								}
							}
							if ($reparado == "") {
								$reparado = "Este componente no tiene reparaciones";
							}
							if ($esta_reparado == "NO") {
								$se_compone_de = $se_compone_de . '<br><b><a onclick="alert(\'' . $reparado . '\');">' . $c['n_registro'] . '///' . $c['nombre_componente'] . '</a></b>';
							} else {
								$se_compone_de = $se_compone_de . '<br><font color="red"><b><a onclick="alert(\'' . $reparado . '\');">' . $c['n_registro'] . '///' . $c['nombre_componente'] . '</a></b></font>';
							}
						}
					}
			?>
					<a href="#" onclick="muestra_componentes_equipo('<?php echo addslashes(htmlentities($se_compone_de)) ?>')"><b><?php echo $equipo['nombre_grupo'] ?></b></a><br><?php
																																												}
																																											} else {
																																													?><b>No asignado</b><br><?php
																																											}
										?>
			<br>
			Equipo Luces:
			<?php
			if ($equipo_luces_asignado) {
				$se_compone_de = "";
				foreach ($equipo_luces_asignado as $equipol) {
					$se_compone_de = "<font size=\"+1\"><b>ESTE EQUIPO SE COMPONE DE: </b></font><br>(Haz click para ver las reparaciones de cada componente)<br>";
					foreach ($componentes as $c) {
						if ($equipol['id_grupo'] == $c['id_grupo']) {
							$reparado = "";
							$esta_reparado = "NO";
							if ($reparaciones_totales) {
								foreach ($reparaciones_totales as $r) {
									if ($c['id_componente'] == $r['id_componente']) {
										$reparado = $reparado . "\\n" . $r['fecha_reparacion'] . "\\n" . $r['reparacion'];
										$esta_reparado = "SI";
									}
								}
							}
							if ($reparado == "") {
								$reparado = "Este componente no tiene reparaciones";
							}
							if ($esta_reparado == "NO") {
								$se_compone_de = $se_compone_de . '<br><b><a onclick="alert(\'' . $reparado . '\');">' . $c['n_registro'] . '///' . $c['nombre_componente'] . '</a></b>';
							} else {
								$se_compone_de = $se_compone_de . '<br><font color="red"><b><a onclick="alert(\'' . $reparado . '\');">' . $c['n_registro'] . '///' . $c['nombre_componente'] . '</a></b></font>';
							}
						}
					}
			?>
					<a href="#" onclick="muestra_componentes_equipo('<?php echo addslashes(htmlentities($se_compone_de)) ?>')"><b><?php echo $equipol['nombre_grupo'] ?></b></a><br><?php
																																												}
																																											} else {
																																													?><b>No asignado</b><br><?php
																																											}
										?>
			<br>
			Equipo Extra1:
			<?php
			if ($equipo_extra1_asignado) {
				$se_compone_de = "";
				foreach ($equipo_extra1_asignado as $equipoe1) {
					$se_compone_de = "<font size=\"+1\"><b>ESTE EQUIPO SE COMPONE DE: </b></font><br>(Haz click para ver las reparaciones de cada componente)<br>";
					foreach ($componentes as $c) {
						if ($equipoe1['id_grupo'] == $c['id_grupo']) {
							$reparado = "";
							$esta_reparado = "NO";
							if ($reparaciones_totales) {
								foreach ($reparaciones_totales as $r) {
									if ($c['id_componente'] == $r['id_componente']) {
										$reparado = $reparado . "\\n" . $r['fecha_reparacion'] . "\\n" . $r['reparacion'];
										$esta_reparado = "SI";
									}
								}
							}
							if ($reparado == "") {
								$reparado = "Este componente no tiene reparaciones";
							}
							if ($esta_reparado == "NO") {
								$se_compone_de = $se_compone_de . '<br><b><a onclick="alert(\'' . $reparado . '\');">' . $c['n_registro'] . '///' . $c['nombre_componente'] . '</a></b>';
							} else {
								$se_compone_de = $se_compone_de . '<br><font color="red"><b><a onclick="alert(\'' . $reparado . '\');">' . $c['n_registro'] . '///' . $c['nombre_componente'] . '</a></b></font>';
							}
						}
					}
			?>
					<a href="#" onclick="muestra_componentes_equipo('<?php echo addslashes(htmlentities($se_compone_de)) ?>')"><b><?php echo $equipoe1['nombre_grupo'] ?></b></a><br><?php
																																												}
																																											} else {
																																													?><b>No asignado</b><br><?php
																																											}
										?>
			<br>
			Equipo Extra2:
			<?php
			if ($equipo_extra2_asignado) {
				$se_compone_de = "";
				foreach ($equipo_extra2_asignado as $equipoe2) {
					$se_compone_de = "<font size=\"+1\"><b>ESTE EQUIPO SE COMPONE DE: </b></font><br>(Haz click para ver las reparaciones de cada componente)<br>";
					foreach ($componentes as $c) {
						if ($equipoe2['id_grupo'] == $c['id_grupo']) {
							$reparado = "";
							$esta_reparado = "NO";
							if ($reparaciones_totales) {
								foreach ($reparaciones_totales as $r) {
									if ($c['id_componente'] == $r['id_componente']) {
										$reparado = $reparado . "\\n" . $r['fecha_reparacion'] . "\\n" . $r['reparacion'];
										$esta_reparado = "SI";
									}
								}
							}
							if ($reparado == "") {
								$reparado = "Este componente no tiene reparaciones";
							}
							if ($esta_reparado == "NO") {
								$se_compone_de = $se_compone_de . '<br><b><a onclick="alert(\'' . $reparado . '\');">' . $c['n_registro'] . '///' . $c['nombre_componente'] . '</a></b>';
							} else {
								$se_compone_de = $se_compone_de . '<br><font color="red"><b><a onclick="alert(\'' . $reparado . '\');">' . $c['n_registro'] . '///' . $c['nombre_componente'] . '</a></b></font>';
							}
						}
					}
			?>
					<a href="#" onclick="muestra_componentes_equipo('<?php echo addslashes(htmlentities($se_compone_de)) ?>')"><b><?php echo $equipoe2['nombre_grupo'] ?></b></a><br><?php
																																												}
																																											} else {
																																													?><b>No asignado</b><br><?php
																																											}
										?>







		</fieldset>

		<fieldset class="fieldsetencuesta">
    <legend>Encuesta del cliente respecto a la boda:</legend>

    <!-- Toggle para cambiar entre modo normal y modo simplificado -->
    <label class="toggle-label">
        <span>Mostrar solo respuestas</span>
        <input type="checkbox" id="toggleRespuestas" onclick="toggleModoSimplificado()" checked>
        <span class="toggle-slider"></span>
    </label>

    <?php if (!empty($preguntas_encuesta_datos_boda)) { ?>
        <form id="encuestaForm">
            <?php foreach ($preguntas_encuesta_datos_boda as $pregunta) { ?>
                <div class="pregunta-container">
                    <span class="pregunta-texto">
                        <strong><?php echo htmlspecialchars($pregunta['pregunta']); ?></strong>
                    </span>

                    <!-- Descripción (solo visible en modo completo) -->
                    <?php if (!empty($pregunta['descripcion'])) { ?>
                        <span class="descripcion-texto" style="display: none;">
                            <?php echo $pregunta['descripcion']; ?>
                        </span>
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

                    <!-- Respuesta en modo simplificado (visible por defecto) -->
                    <span class="respuesta-simplificada">
                        <?php 
                        if ($tipo == 'multiple') {
                            echo !empty($respuestas_seleccionadas) ? implode(', ', array_map('htmlspecialchars', $respuestas_seleccionadas)) : 'No respondido';
                        } else {
                            echo !empty($respuesta_cliente_actual) ? htmlspecialchars($respuesta_cliente_actual) : 'No respondido';
                        }
                        ?>
                    </span>

                    <!-- Respuesta en modo completo (oculto por defecto) -->
                    <div class="modo-normal" style="display: none;">
                        <?php if ($tipo == 'rango') { ?>
                            <input type="range" min="0" max="10" value="<?php echo htmlspecialchars(!empty($respuesta_cliente_actual) ? $respuesta_cliente_actual : 5); ?>" disabled>
                            <span><?php echo htmlspecialchars(!empty($respuesta_cliente_actual) ? $respuesta_cliente_actual : 'No respondido'); ?></span>

                        <?php } elseif ($tipo == 'opciones' && !empty($respuestas)) { ?>
                            <?php foreach ($respuestas as $respuesta) { ?>
                                <label>
                                    <input type="radio" disabled
                                        <?php echo (!empty($respuesta_cliente_actual) && $respuesta_cliente_actual == $respuesta['respuesta']) ? 'checked' : ''; ?>>
                                    <?php echo htmlspecialchars($respuesta['respuesta']); ?>
                                </label><br>
                            <?php } ?>

                        <?php } elseif ($tipo == 'multiple' && !empty($respuestas)) { ?>
                            <?php foreach ($respuestas as $respuesta) { ?>
                                <label>
                                    <input type="checkbox" disabled
                                        <?php echo (!empty($respuestas_seleccionadas) && in_array(trim($respuesta['respuesta']), $respuestas_seleccionadas)) ? 'checked' : ''; ?>>
                                    <?php echo htmlspecialchars($respuesta['respuesta']); ?>
                                </label><br>
                            <?php } ?>

                        <?php } elseif ($tipo == 'texto') { ?>
                            <input type="text" value="<?php echo htmlspecialchars(!empty($respuesta_cliente_actual) ? $respuesta_cliente_actual : 'No respondido'); ?>" disabled>

                        <?php } else { ?>
                            <p>El tipo de pregunta <strong><?php echo htmlspecialchars($tipo); ?></strong> no está soportado.</p>
                        <?php } ?>
                    </div>
                </div>
                <br>
            <?php } ?>
        </form>
    <?php } else { ?>
        <li>No se ha realizado la encuesta</li>
    <?php } ?>
</fieldset>

<!-- Script para alternar entre los modos -->
<script>
    function toggleModoSimplificado() {
        var isChecked = document.getElementById("toggleRespuestas").checked;
        var modoNormal = document.querySelectorAll(".modo-normal");
        var respuestasSimplificadas = document.querySelectorAll(".respuesta-simplificada");
        var descripciones = document.querySelectorAll(".descripcion-texto");

        modoNormal.forEach(el => el.style.display = isChecked ? "none" : "block");
        respuestasSimplificadas.forEach(el => el.style.display = isChecked ? "inline" : "none");
        descripciones.forEach(el => el.style.display = isChecked ? "none" : "inline");
    }

    // Ejecutar al cargar la página para que empiece en modo simplificado
    document.addEventListener("DOMContentLoaded", function() {
        toggleModoSimplificado();
    });
</script>

<!-- Estilos para el toggle y la presentación -->
<style>
    /* Toggle estilo switch */
    .toggle-label {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 16px;
        font-weight: bold;
        cursor: pointer;
        margin-bottom: 15px;
    }

    .toggle-label input {
        display: none;
    }

    .toggle-slider {
        width: 40px;
        height: 20px;
        background: grey;
        border-radius: 20px;
        position: relative;
        transition: background 0.3s;
    }

    .toggle-slider::before {
        content: "";
        position: absolute;
        width: 18px;
        height: 18px;
        background: white;
        border-radius: 50%;
        top: 1px;
        left: 2px;
        transition: transform 0.3s;
    }

    .toggle-label input:checked + .toggle-slider {
        background: #4CAF50;
    }

    .toggle-label input:checked + .toggle-slider::before {
        transform: translateX(20px);
    }

    /* Ajuste para preguntas y respuestas */
    .pregunta-container {
        margin-bottom: 10px;
    }

    .pregunta-texto {
        font-weight: bold;
        display: block;
        margin-bottom: 5px;
    }

    .descripcion-texto {
        font-size: 14px;
        color: #666;
        display: none;
    }

</style>



		<fieldset class="datos">
			<legend>Equipamiento</legend>
			<ul>
				<li>Equipo componentes:
					<?php
					if ($equipo_componentes_asignado) {
						foreach ($equipo_componentes_asignado as $equipo) {
					?><b><?php echo $equipo['nombre_grupo'] ?></b><br><?php
																		}
																	} else {
																			?><b>No asignado</b><br><?php
																	}
											?></li>
				<li>Equipo luces:
					<?php
					if ($equipo_luces_asignado) {
						foreach ($equipo_luces_asignado as $equipol) {
					?><b><?php echo $equipol['nombre_grupo'] ?></b><br><?php
																		}
																	} else {
																			?><b>No asignado</b><br><?php
																	}
											?></li>
			</ul>
		</fieldset>

		<fieldset class="datos">
			<legend>Servicios</legend>
			<ul>
				<?php
				$arr_servicios = unserialize($cliente['servicios']);
				$total = array_sum($arr_servicios);
				$arr_serv_keys = array_keys($arr_servicios);
				foreach ($servicios as $servicio) {
				?>
					<li><input type="checkbox" name="servicios[<?php echo $servicio['id'] ?>]" <?php echo in_array($servicio['id'], $arr_serv_keys) ? 'checked="checked"' : '' ?> id="chserv_<?php echo $servicio['id'] ?>" value="<?php echo in_array($servicio['id'], $arr_serv_keys) ? $arr_servicios[$servicio['id']] : $servicio['precio'] ?>" style="width:30px; vertical-align:middle" disabled /><?php echo $servicio['nombre']; ?></li>
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