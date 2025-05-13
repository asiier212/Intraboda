    <script type="text/javascript" src="<?php echo base_url() ?>js/jquery/development-bundle/ui/jquery.jeditable.js"></script>
    <script language="javascript">
    	$(document).ready(function() {
    		$('.edit_box').editable('<?php echo base_url() ?>index.php/ajax/updatedatocliente', {
    			type: 'text',
    			submit: '<img src="<?php echo base_url() ?>img/save.gif" />',
    			tooltip: 'Click para editar...'
    		});

    	});
    </script>

    <style>
    	.editable img {
    		float: right
    	}
    </style>
    <h2>
    	Nuestros datos
    </h2>
    <div class="main form">

    	<div id="popupInvitado" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background-color:rgba(0,0,0,0.5); z-index:1000;">

    		<div style="box-sizing:border-box; background:white; width:400px; padding:25px 30px; border-radius:12px; position:absolute; top:50%; left:50%; transform:translate(-50%, -50%); box-shadow: 0 10px 25px rgba(0,0,0,0.1); font-family:'Segoe UI', sans-serif;">
    			<a onclick="cerrarPopupInvitado()" style="position:absolute; top:17px; right:20px; cursor:pointer; font-size:22px; color:red; font-weight:bold;">✖</a>

    			<h2 style="margin-top:0; font-size:20px; color:#333;">Crear Cuenta de Invitado</h2>

    			<form method="post" action="">
    				<label style="font-weight:bold; font-size:14px;">Usuario:</label><br>
    				<input type="text" name="nuevo_username" required style="width:100%; padding:10px; margin:8px 0 15px 0; border:1px solid #ccc; border-radius:6px; box-sizing:border-box;" />

    				<label style="font-weight:bold; font-size:14px;">Contraseña:</label><br>
    				<input type="text" name="nuevo_clave" required style="width:100%; padding:10px; margin:8px 0 15px 0; border:1px solid #ccc; border-radius:6px; box-sizing:border-box;" />

    				<label style="font-weight:bold; font-size:14px;">Email:</label><br>
    				<input type="email" name="nuevo_email" required style="width:100%; padding:10px; margin:8px 0 15px 0; border:1px solid #ccc; border-radius:6px; box-sizing:border-box;" />

    				<label style="font-weight:bold; font-size:14px;">Fecha de expiración:</label><br>
    				<input type="date" name="nuevo_expiracion" style="width:100%; padding:10px; margin:8px 0 20px 0; border:1px solid #ccc; border-radius:6px; box-sizing:border-box;" />

    				<!-- Checkbox: Enviar email -->
    				<div style="margin-bottom: 20px;">
    					<label for="enviar_email" style="font-weight:bold; font-size:14px;">¿Enviar un email de acceso al invitado?</label><br>
    					<label class="toggle-label" style="display: inline-flex; align-items: center; gap: 12px; margin-top: 10px;">
    						<input type="checkbox" id="enviar_email" name="enviar_email" checked style="display:none;">
    						<span class="toggle-slider"></span>
    						<span style="font-size:13px; color:#333;"></span>
    					</label>
    				</div>


    				<!-- Mensaje de error -->
    				<?php
					$msg_invitado = $this->session->flashdata('msg_invitado');
					if (!empty($msg_invitado)) {
						echo '<div style="color:#b30000; background:#ffe5e5; padding:10px; border:1px solid #e63737; border-radius:5px; font-weight:bold; text-align:center; margin-bottom:15px;">' . $msg_invitado . '</div>';
					}
					?>

    				<div style="text-align:center;">
    					<input type="submit" name="crear_invitado" value="CREAR INVITADO" style="padding:10px 20px; background:#93CE37; color:#fff; border:none; border-radius:6px; font-weight:bold; cursor:pointer; font-size:14px;" />
    				</div>
    			</form>
    		</div>

    		<style>
    			.toggle-slider {
    				width: 40px;
    				height: 20px;
    				background: grey;
    				border-radius: 20px;
    				position: relative;
    				transition: background 0.3s;
    				cursor: pointer;
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

    			.toggle-label input:checked+.toggle-slider {
    				background: #4CAF50;
    			}

    			.toggle-label input:checked+.toggle-slider::before {
    				transform: translateX(20px);
    			}
    		</style>

    	</div>
    	<?php if (!empty($msg_invitado)): ?>
    		<script type="text/javascript">
    			window.onload = function() {
    				document.getElementById('popupInvitado').style.display = 'block';
    			};
    		</script>
    	<?php endif; ?>


    	<script type="text/javascript">
    		function abrirPopupInvitado() {
    			document.getElementById('popupInvitado').style.display = 'block';
    		}

    		function cerrarPopupInvitado() {
    			document.getElementById('popupInvitado').style.display = 'none';
    		}
    	</script>


    	<form method="post" enctype="multipart/form-data">

    		<fieldset class="datos">
    			<legend>Datos de contacto</legend>
    			<span style="font-size:11px">Para editar los datos haz click sobre el texto</span>
    			<p style="text-align:right"><a style="text-decoration:underline; cursor:pointer;" onclick="abrirPopupInvitado()">Crear Cuenta Invitado</a></p>


    			<br clear="left" />
    			<fieldset style="width:350px">
    				<legend>Datos del Novio/a</legend>
    				<ul class="editable">
    					<li><label>Nombre:</label><span class="edit_box" id="nombre_novio"><?php echo $cliente['nombre_novio'] ?></span> </li>
    					<li><label>Apellidos:</label><span class="edit_box" id="apellidos_novio"><?php echo $cliente['apellidos_novio'] ?></span></li>
    					<li><label>Direcci&oacute;n:</label><span class="edit_box" id="direccion_novio"><?php echo $cliente['direccion_novio'] ?></span></li>
    					<li><label>CP:</label><span class="edit_box" id="cp_novio"><?php echo $cliente['cp_novio'] ?></span></li>
    					<li><label>Poblaci&oacute;n:</label><span class="edit_box" id="poblacion_novio"><?php echo $cliente['poblacion_novio'] ?></span></li>
    					<li><label>Tel&eacute;fono:</label><span class="edit_box" id="telefono_novio"><?php echo $cliente['telefono_novio'] ?></span></li>
    					<li><label>Email:</label><span class="edit_box" id="email_novio"><?php echo $cliente['email_novio'] ?></span></li>
    				</ul>
    			</fieldset>
    			<fieldset style="width:350px">
    				<legend>Datos del Novio/a</legend>
    				<ul>
    					<li><label>Nombre:</label><span class="edit_box" id="nombre_novia"><?php echo $cliente['nombre_novia'] ?></span></li>
    					<li><label>Apellidos:</label><span class="edit_box" id="apellidos_novia"><?php echo $cliente['apellidos_novia'] ?></span></li>
    					<li><label>Direcci&oacute;n:</label><span class="edit_box" id="direccion_novia"><?php echo $cliente['direccion_novia'] ?></span></li>
    					<li><label>CP:</label><span class="edit_box" id="cp_novia"><?php echo $cliente['cp_novia'] ?></span></li>
    					<li><label>Poblaci&oacute;n:</label><span class="edit_box" id="poblacion_novia"><?php echo $cliente['poblacion_novia'] ?></span></li>
    					<li><label>Tel&eacute;fono:</label><span class="edit_box" id="telefono_novia"><?php echo $cliente['telefono_novia'] ?></span></li>
    					<li><label>Email:</label><span class="edit_box" id="email_novia"><?php echo $cliente['email_novia'] ?></span></li>
    				</ul>
    			</fieldset>
    		</fieldset>
    		<br class="clear" />
    		<div style="clear:left; text-align:center; margin-top:20px">

    			<?php if ($cliente['foto'] != '') {
					echo '<img width="400" src="' . base_url() . 'uploads/foto_perfil/' . $cliente['foto'] . '"/>';
				} ?>

    			<br />

    			Subir foto (max 600px de ancho): <input type="file" name="foto" /> <input type="submit" style="width:90px; margin-left:50px" name="subir_foto" value="Subir" />

    			<?php if (isset($msg_foto)) echo "<br>" . $msg_foto; ?>

    		</div>

    		</fieldset>
    		<fieldset class="datos">
    			<legend>Datos de la boda</legend>
    			<fieldset style="width:350px">
    				<legend>Lugar, fecha y hora</legend>
    				<ul>
    					<li><label>Hora de la boda:</label><span class="edit_box" id="hora_boda"><?php echo $cliente['hora_boda'] ?></span></li>
    					<li><label>Fecha de la boda:</label><span class="edit_box" id="fecha_boda"><?php echo $cliente['fecha_boda'] ?></span></li>


    					<li><label>Restaurante:</label><span id="restaurante"><?php echo $cliente['restaurante'] ?></span></li>
    					<li><label>Direcci&oacute;n del Restaurante:</label><span id="direccion_restaurante"><?php echo $cliente['direccion_restaurante'] ?></span></li>
    					<li><label>Tel&eacute;fono del Restaurante:</label><span id="telefono_restaurante"><?php echo $cliente['telefono_restaurante'] ?></span></li>
    					<li><label>Maitre de la boda:</label><span id="maitre"><?php echo $cliente['maitre'] ?></span></li>
    					<li><label>Tel&eacute;fono Maitre:</label><span id="telefono_maitre"><?php echo $cliente['telefono_maitre'] ?></span></li>
    				</ul>
    			</fieldset>
    			<fieldset style="width:350px">
    				<legend>DJ asignado</legend>
    				<ul>
    					<?php
						if ($dj) {
							foreach ($dj as $p) { ?>
    							<li style="display: block; float:left; padding:0 60px; text-align:center">
    								<label for="dj<?php echo $p['id'] ?>" style="float:none; margin:0 auto; width:auto">
    									<table>
    										<tr>
    											<td align="center">
    												<?php if ($p['foto'] != '') { ?>
    													<img src="<?php echo base_url() ?>uploads/djs/<?php echo $p['foto'] ?>" />
    												<?php } else {
													?><img src="<?php echo base_url() ?>uploads/djs/desconocido.jpg" /><?php
																													} ?>
    											</td>
    										</tr>
    										<tr>
    											<td align="center">
    												<?php echo $p['nombre'] ?> <br />
    												Tel: <a href="https://wa.me/<?php echo preg_replace('/[^0-9]/', '', $p['telefono']); ?>" target="_blank">
    													<?php echo $p['telefono']; ?>
    												</a>

    												<br />
    												E-mail: <?php echo $p['email'] ?>
    											</td>
    										</tr>
    									</table>
    								</label>
    							</li>
    					<?php }
						} else {
							echo "No hay DJ asignado";
						} ?>
    				</ul>
    			</fieldset>
    		</fieldset>

    		<fieldset>
    			<legend>Encuesta del cliente respecto a la boda:</legend>
    			<?php
				$preguntas_encuesta_datos_boda = $this->cliente_functions->GetPreguntasEncuestaDatosBoda();
				$opciones_respuestas_encuesta_datos_boda = $this->cliente_functions->GetOpcionesRespuestasEncuestaDatosBoda();
				$respuestas_cliente = $this->cliente_functions->GetRespuestasEncuestaDatosBoda($this->session->userdata('user_id'));

				if (!empty($preguntas_encuesta_datos_boda)) { ?>
    				<form method="post" action="procesar_encuesta.php">
    					<?php foreach ($preguntas_encuesta_datos_boda as $pregunta) { ?>
    						<div>
    							<strong><?php echo htmlspecialchars($pregunta['pregunta']); ?></strong>
    							<?php if (!empty($pregunta['descripcion'])) { ?>
    								<div><?php echo $pregunta['descripcion']; ?></div>
    							<?php } else echo "<br><br>"; ?>

    							<?php
								// Obtener opciones de respuesta
								$respuestas = [];
								foreach ($opciones_respuestas_encuesta_datos_boda as $resp) {
									if (intval($resp['id_pregunta']) === intval($pregunta['id_pregunta'])) {
										$respuestas[] = $resp;
									}
								}

								// Obtener la respuesta guardada del cliente
								$respuesta_cliente_actual = null;
								$respuestas_seleccionadas = [];

								foreach ($respuestas_cliente as $resp) {
									if ($resp['id_pregunta'] == $pregunta['id_pregunta']) {
										if ($pregunta['tipo_pregunta'] == 'multiple') {
											$respuestas_seleccionadas = array_merge($respuestas_seleccionadas, array_map('trim', explode(',', $resp['respuesta'])));
										} else {
											$respuesta_cliente_actual = $resp['respuesta'];
										}
									}
								}

								// Determinar el tipo de pregunta
								$tipo = isset($pregunta['tipo_pregunta']) ? strtolower($pregunta['tipo_pregunta']) : '';
								?>

    							<?php if ($tipo == 'rango') { ?>
    								<input type="range" name="respuesta[<?php echo $pregunta['id_pregunta']; ?>]" min="0" max="10"
    									value="<?php echo htmlspecialchars(!empty($respuesta_cliente_actual) ? $respuesta_cliente_actual : 5); ?>"
    									oninput="document.getElementById('valor_<?php echo $pregunta['id_pregunta']; ?>').innerText = this.value;">
    								<span id="valor_<?php echo $pregunta['id_pregunta']; ?>"><?php echo htmlspecialchars(!empty($respuesta_cliente_actual) ? $respuesta_cliente_actual : '5'); ?></span>

    							<?php } elseif ($tipo == 'opciones' && !empty($respuestas)) { ?>
    								<?php
									$respuesta_encontrada = false; // Para saber si la respuesta es de las opciones predefinidas
									$id_pregunta = $pregunta['id_pregunta']; // ID de la pregunta
									?>

    								<?php foreach ($respuestas as $respuesta) {
										$checked = (!empty($respuesta_cliente_actual) && $respuesta_cliente_actual == $respuesta['respuesta']) ? 'checked' : '';
										if ($checked) {
											$respuesta_encontrada = true; // Si se encuentra la respuesta en el rango, la marcamos
										}
									?>
    									<label>
    										<input type="radio" name="respuesta[<?php echo $id_pregunta; ?>]"
    											value="<?php echo htmlspecialchars($respuesta['respuesta'], ENT_QUOTES, 'UTF-8'); ?>"
    											class="opcion_radio_<?php echo $id_pregunta; ?>"
    											<?php echo $checked; ?>>
    										<?php echo htmlspecialchars($respuesta['respuesta'], ENT_QUOTES, 'UTF-8'); ?>
    									</label><br>
    								<?php } ?>

    								<!-- Opción de Número Exacto -->
    								<label>
    									<input type="radio" name="respuesta[<?php echo $id_pregunta; ?>]"
    										value="numero_exacto" id="numero_exacto_radio_<?php echo $id_pregunta; ?>"
    										<?php echo (!$respuesta_encontrada && !empty($respuesta_cliente_actual)) ? 'checked' : ''; ?>>
    									Introducir número exacto:
    									<input type="number" style="width:40px" name="numero_exacto[<?php echo $id_pregunta; ?>]"
    										id="numero_exacto_input_<?php echo $id_pregunta; ?>"
    										value="<?php echo (!$respuesta_encontrada && !empty($respuesta_cliente_actual)) ? htmlspecialchars($respuesta_cliente_actual, ENT_QUOTES, 'UTF-8') : ''; ?>">
    								</label><br>

    							<?php } elseif ($tipo == 'multiple' && !empty($respuestas)) { ?>
    								<?php
									// Obtener todas las opciones de respuesta de la BD
									$respuestas_disponibles = array_map(function ($resp) {
										return trim($resp['respuesta']);
									}, $respuestas);

									// Buscar respuestas "extra" (no presentes en la lista de opciones)
									$respuestas_extra = array_diff($respuestas_seleccionadas, $respuestas_disponibles);
									?>

    								<!-- Mostrar opciones de la BD -->
    								<?php foreach ($respuestas as $respuesta) { ?>
    									<label>
    										<input type="checkbox" name="respuesta[<?php echo $pregunta['id_pregunta']; ?>][]"
    											value="<?php echo htmlspecialchars($respuesta['respuesta']); ?>"
    											<?php echo (!empty($respuestas_seleccionadas) && in_array(trim($respuesta['respuesta']), $respuestas_seleccionadas)) ? 'checked' : ''; ?>>
    										<?php echo htmlspecialchars($respuesta['respuesta']); ?>
    									</label><br>
    								<?php } ?>

    								<!-- Mostrar respuestas "extra" ya guardadas -->
    								<?php foreach ($respuestas_extra as $extra) { ?>
    									<label>
    										<input type="checkbox" name="respuesta[<?php echo $pregunta['id_pregunta']; ?>][]" value="<?php echo htmlspecialchars($extra); ?>" checked>
    										<?php echo htmlspecialchars($extra); ?>
    									</label><br>
    								<?php } ?>

    								<!-- Checkbox y campo de texto para "Otro..." -->
    								<div id="otros_inputs_<?php echo $pregunta['id_pregunta']; ?>">
    									<label>
    										<input type="checkbox" id="check_otro_<?php echo $pregunta['id_pregunta']; ?>"
    											onclick="toggleOtroInput(this, '<?php echo $pregunta['id_pregunta']; ?>')">
    										<input type="text" name="respuesta[<?php echo $pregunta['id_pregunta']; ?>][]" placeholder="Otro..." disabled
    											id="otro_input_<?php echo $pregunta['id_pregunta']; ?>" onkeyup="checkOtroInput('<?php echo $pregunta['id_pregunta']; ?>')">
    									</label>
    								</div>


    							<?php } elseif ($tipo == 'texto') { ?>
    								<input type="text" name="respuesta[<?php echo $pregunta['id_pregunta']; ?>]"
    									value="<?php echo htmlspecialchars(!empty($respuesta_cliente_actual) ? $respuesta_cliente_actual : ''); ?>">
    							<?php } elseif ($tipo == 'textol') { ?>
    								<textarea id="observaciones"><?php echo htmlspecialchars(!empty($respuesta_cliente_actual) ? $respuesta_cliente_actual : 'No respondido'); ?></textarea>
    							<?php } else { ?>
    								<p>El tipo de pregunta <strong><?php echo htmlspecialchars($tipo); ?></strong> no está soportado.</p>
    							<?php } ?>
    						</div>
    						<br>
    					<?php } ?>

    					<style>
    						#observaciones {
    							resize: none;
    							width: 100%;
    							height: 150px;
    							padding: 10px;
    							border: 1px solid #ccc;
    							border-radius: 5px;
    							box-sizing: border-box;
    							font-size: 14px;
    							font-family: Arial, sans-serif;
    						}
    					</style>

    					<center><input type="submit" name="actualizar_encuesta" value="Actualizar Encuesta"></center>
    				</form>
    			<?php } else { ?>
    				<li>No se ha realizado la encuesta</li>
    			<?php } ?>
    		</fieldset>



    		<script type="text/javascript">
    			// Función para manejar el comportamiento dinámico de las opciones
    			(function() {
    				let radioButtons = document.querySelectorAll('.opcion_radio_<?php echo $id_pregunta; ?>');
    				let numeroExactoRadio = document.getElementById("numero_exacto_radio_<?php echo $id_pregunta; ?>");
    				let numeroExactoInput = document.getElementById("numero_exacto_input_<?php echo $id_pregunta; ?>");

    				radioButtons.forEach(radio => {
    					radio.addEventListener("change", function() {
    						if (this !== numeroExactoRadio) {
    							numeroExactoRadio.checked = false;
    							numeroExactoInput.value = ""; // Vaciar input al seleccionar otra opción
    						}
    					});
    				});

    				numeroExactoInput.addEventListener("click", function() {
    					numeroExactoRadio.checked = true;
    					radioButtons.forEach(radio => {
    						radio.checked = false;
    					});
    				});
    			})();

    			function toggleOtroInput(checkbox) {
    				var inputOtro = checkbox.nextElementSibling;

    				if (checkbox.checked) {
    					inputOtro.disabled = false;
    					inputOtro.focus();
    				} else {
    					inputOtro.disabled = true; // Solo desactiva el input, no lo borra
    					inputOtro.value = ""; // Limpia el contenido cuando se desactiva
    				}
    			}

    			function checkOtroInput(idPregunta) {
    				var divOtros = document.getElementById("otros_inputs_" + idPregunta);
    				var inputs = divOtros.getElementsByTagName("input");
    				var ultimoInput = inputs[inputs.length - 1];

    				if (ultimoInput.type === "text" && ultimoInput.value.trim() !== "") {
    					var nuevoLabel = document.createElement("label");

    					var nuevoCheckbox = document.createElement("input");
    					nuevoCheckbox.type = "checkbox";
    					nuevoCheckbox.onclick = function() {
    						toggleOtroInput(this);
    					};

    					var nuevoInput = document.createElement("input");
    					nuevoInput.type = "text";
    					nuevoInput.name = "respuesta[" + idPregunta + "][]";
    					nuevoInput.placeholder = "Otro...";
    					nuevoInput.disabled = true;
    					nuevoInput.onkeyup = function() {
    						checkOtroInput(idPregunta);
    					};

    					nuevoLabel.appendChild(nuevoCheckbox);
    					nuevoLabel.appendChild(nuevoInput);
    					divOtros.appendChild(document.createElement("br"));
    					divOtros.appendChild(nuevoLabel);
    				}
    			}
    		</script>

    		<fieldset class="datos">
    			<legend>Mis servicios contratados</legend>

    			<table class="tabledata">
    				<tr>
    					<th style="width:400px">Servicio</th>
    					<th style="width:200px; text-align:right;">Importe</th>
    				</tr>
    				<?php
					$total = 0;
					$totalDescuento = 0;

					$cliente['servicios'] = unserialize($cliente['servicios']); // ← importante

					if (!empty($cliente['servicios'])) {
						foreach ($cliente['servicios'] as $id => $datos) {
							// Buscar el nombre del servicio
							$nombreServicio = "Servicio no encontrado";
							foreach ($servicios as $servicio) {
								if ($servicio['id'] == $id) {
									$nombreServicio = $servicio['nombre'];
									break;
								}
							}

							$precio = $datos['precio'];
							$descuento = $datos['descuento'];
							$precioFinal = $precio - $descuento;

							$total += $precio;
							$totalDescuento += $descuento;
					?>
    						<tr>
    							<td><?php echo $nombreServicio; ?></td>
    							<td style="text-align:right;">
    								<?php if ($descuento > 0) { ?>
    									<span style="text-decoration: line-through; color: red; font-weight: bold">
    										<?php echo number_format($precio, 2, ',', '.') . "€"; ?>
    									</span>
    								<?php } ?>
    								<b><?php echo number_format($precioFinal, 2, ',', '.') . "€"; ?></b>
    							</td>
    						</tr>
    					<?php } ?>
    					<tr>
    						<td><b>Total del contrato</b></td>
    						<td style="text-align:right;">
    							<?php
								$descuento1 = $cliente['descuento'];
								$descuento2 = $cliente['descuento2'];
								$descuento_total = $descuento1 + $descuento2;
								?>
    							<?php if ($cliente['descuento'] > 0) { ?>
    								<span style="text-decoration: line-through; color: red; font-weight: bold">
    									<?php echo number_format($total, 2, ',', '.') . "€"; ?>
    								</span>
    							<?php } ?>
    							<b><?php echo number_format(($total - $descuento_total), 2, ',', '.') . "€"; ?></b>
    						</td>
    					</tr>
    				<?php } else { ?>
    					<tr>
    						<td colspan="2" style="text-align:center; color: red;">No hay servicios contratados</td>
    					</tr>
    				<?php } ?>
    			</table>

    			<br /><br />

    			<ul>
    				<li style="padding:8px 0;"><strong>Mi Estado de Pagos</strong></li>

    				<?php
					$suma_pagos = 0;
					if (count($pagos) == 0) {
						echo "<li>Aún no se han hecho pagos</li>";
					} else {
					?>
    					<table class="tabledata">
    						<tr>
    							<th style="width:200px">Concepto</th>
    							<th style="width:200px">Fecha</th>
    							<th style="width:180px">Importe</th>
    						</tr>
    						<?php
							$i = 1;
							foreach ($pagos as $p) {
								$suma_pagos += $p['valor'];
							?>
    							<tr>
    								<td>
    									<?php echo ($i == 1 ? "Pago Se&ntilde;al " : "") . ($i == 2 ? "Pago de 50% " : "") . ($i == 3 ? "Pago final " : ""); ?>
    								</td>
    								<td align="center"><?php echo $p['fecha']; ?></td>
    								<td align="right"><b><?php echo number_format($p['valor'], 2, ',', '.') . " &euro;"; ?></b></td>
    							</tr>
    						<?php
								$i++;
							}
							?>
    						<tr>
    							<td colspan="2">Pendiente por pagar: </td>
    							<td align="right">
    								<b><?php echo number_format(count($pagos) == 0 ? $total - $totalDescuento - $cliente['descuento'] : $total - $suma_pagos - $totalDescuento - $cliente['descuento'], 2, ',', '.') . " &euro;"; ?></b>
    							</td>
    						</tr>
    					</table>

    					<br /><br />

    					<div style="padding:10px; border:1px solid #ccc; background-color:#f9f9f9; border-radius:5px; width: 400px;">
    						<li style="padding: 0"><strong>Hacer Un Pago</strong></li>
    						<?php $fecha_boda_array = explode(' ', $cliente['fecha_boda']); ?>

    						Numero de cuenta: <b><?php echo $numero_cuenta ?></b><br />
    						Concepto: <b><?php echo $cliente['nombre_novio'] . " " . $cliente['apellidos_novio'] . " - " . $cliente['nombre_novia'] . " " . $cliente['apellidos_novia'] . " - " . $fecha_boda_array[0];  ?></b><br />
    					</div>
    				<?php
					}
					?>
    			</ul>

    			<br /><br />
    			<?php if ($cliente['contrato_pdf'] != '') { ?>
    				<a href="<?php echo base_url() ?>uploads/pdf/<?php echo $cliente['contrato_pdf'] ?>" style="color:#333; font-weight:bold" target="_blank">Descargar Contrato en PDF</a>
    			<?php } ?>
    			<span style="padding:0 40px">&nbsp;</span>
    			<?php if ($cliente['presupuesto_pdf'] != '') { ?>
    				<a href="<?php echo base_url() ?>uploads/pdf/<?php echo $cliente['presupuesto_pdf'] ?>" style="color:#333; font-weight:bold" target="_blank">Descargar Presupuesto en PDF</a>
    			<?php } ?>
    			<span style="padding:0 40px">&nbsp;</span>
    			<?php if ($cliente['factura_pdf'] != '') { ?>
    				<a href="<?php echo base_url() ?>uploads/facturas/<?php echo urlencode(utf8_decode($cliente['factura_pdf'])) ?>" style="color:#333; font-weight:bold" target="_blank">Descargar Factura en PDF</a>
    			<?php } ?>
    		</fieldset>

    		<fieldset class="datos">
    			<legend>Cambio de la contrase&ntilde;a</legend>
    			<form method="post" action="">
    				<ul>
    					<li>
    						<label>Nueva contrase&ntilde;a:</label>
    						<input type="password" name="clave" required />
    						<input type="submit" style="width:80px" value="Cambiar" />
    					</li>
    				</ul>
    			</form>
    			<p style="text-align:center">
    				<?php if (isset($msg_clave)) echo $msg_clave; ?>
    			</p>
    		</fieldset>


    		<p style="text-align:center"></p>
    	</form>
    </div>
    <div class="clear">
    </div>



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

	