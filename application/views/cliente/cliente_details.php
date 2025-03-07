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

    	<form method="post" enctype="multipart/form-data">

    		<fieldset class="datos">
    			<legend>Datos de contacto</legend>
    			<span style="font-size:11px">Para editar los datos haz click sobre el texto</span>
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
									<?php foreach ($respuestas as $respuesta) { ?>
										<label>
											<input type="radio" name="respuesta[<?php echo $pregunta['id_pregunta']; ?>]" 
												   value="<?php echo htmlspecialchars($respuesta['respuesta']); ?>"
												   <?php echo (!empty($respuesta_cliente_actual) && $respuesta_cliente_actual == $respuesta['respuesta']) ? 'checked' : ''; ?>>
											<?php echo htmlspecialchars($respuesta['respuesta']); ?>
										</label><br>
									<?php } ?>
			
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
			
									<!-- Checkbox y campo de texto para "Otro..." -->
									<div id="otros_inputs_<?php echo $pregunta['id_pregunta']; ?>">
										<label>
											<input type="checkbox" id="check_otro_<?php echo $pregunta['id_pregunta']; ?>"
												   onclick="toggleOtroInput(this, '<?php echo $pregunta['id_pregunta']; ?>')">
											<input type="text" name="respuesta[<?php echo $pregunta['id_pregunta']; ?>][]" placeholder="Otro..." disabled
												   id="otro_input_<?php echo $pregunta['id_pregunta']; ?>" onkeyup="checkOtroInput('<?php echo $pregunta['id_pregunta']; ?>')">
										</label>
									</div>
			
									<!-- Mostrar respuestas "extra" ya guardadas -->
									<?php foreach ($respuestas_extra as $extra) { ?>
										<label>
											<input type="checkbox" name="respuesta[<?php echo $pregunta['id_pregunta']; ?>][]" value="<?php echo htmlspecialchars($extra); ?>" checked>
											<?php echo htmlspecialchars($extra); ?> (Otro)
										</label><br>
									<?php } ?>
			
								<?php } elseif ($tipo == 'texto') { ?>
									<input type="text" name="respuesta[<?php echo $pregunta['id_pregunta']; ?>]" 
										   value="<?php echo htmlspecialchars(!empty($respuesta_cliente_actual) ? $respuesta_cliente_actual : ''); ?>">
			
								<?php } else { ?>
									<p>El tipo de pregunta <strong><?php echo htmlspecialchars($tipo); ?></strong> no está soportado.</p>
								<?php } ?>
							</div>
							<br>
						<?php } ?>
			
						<center><input type="submit" name="actualizar_encuesta" value="Actualizar Encuesta"></center>
					</form>
				<?php } else { ?>
					<li>No se ha realizado la encuesta</li>
				<?php } ?>
			</fieldset>



    		<script type="text/javascript">
    			function toggleOtroInput(checkbox, idPregunta) {
    				var inputOtro = checkbox.nextElementSibling;

    				if (checkbox.checked) {
    					inputOtro.disabled = false;
    					inputOtro.focus();
    				} else {
    					removeOtroInput(checkbox.parentNode);
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
    						toggleOtroInput(this, idPregunta);
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

    			function removeOtroInput(label) {
    				var divOtros = label.parentNode;
    				if (label.previousSibling && label.previousSibling.nodeName === "BR") {
    					divOtros.removeChild(label.previousSibling);
    				}
    				divOtros.removeChild(label);
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

					if (!empty($cliente['servicios'])) {
						foreach ($cliente['servicios'] as $id => $datos) {
							// Buscar el nombre del servicio
							$nombreServicio = "Servicio no encontrado"; // Por defecto, si no lo encuentra
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
    									<span style="text-decoration: line-through; color: red; font-weight: bold"><?php echo number_format($precio, 2, ',', '.') . "€"; ?></span>
    								<?php } ?>
    								<b><?php echo number_format($precioFinal, 2, ',', '.') . "€"; ?></b>
    							</td>
    						</tr>
    					<?php } ?>
    					<tr>
    						<td><b>Total del contrato</b></td>
    						<td style="text-align:right;">
    							<?php if ($totalDescuento > 0) { ?>
    								<span style="text-decoration: line-through; color: red; font-weight: bold"><?php echo number_format($total, 2, ',', '.') . "€"; ?></span>
    							<?php } ?>
    							<b><?php echo number_format(($total - $totalDescuento), 2, ',', '.') . "€"; ?></b>
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
						echo "<li>A&uacute;n no se han hecho pagos</li>";
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
								$suma_pagos = $suma_pagos + $p['valor'];
							?>
    							<tr>
    								<td>
    									<?php echo ($i == 1 ? "Pago Se&ntilde;al " : "") . ($i == 2 ? "Pago de 50% " : "") . ($i == 3 ? "Pago final " : "")						?></td>
    								<td align="center"><?php echo $p['fecha'] ?></td>
    								<td align="right"><b><?php echo number_format($p['valor'], 2, ',', '.') . " &euro;"; ?></b></td>
    							</tr>
    						<?php
								$i++;
							}
							?>
    						<tr>
    							<td colspan="2">Pendiente por pagar: </td>
    							<td align="right"><b><?php echo number_format(count($pagos) == 0 ? $total - $cliente['descuento'] :  $total - $suma_pagos - $cliente['descuento'], 2, ',', '.') . " &euro;"; ?></b></td>
    						</tr>
    					</table>

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
    			<ul>
    				<li><label>Nueva contrase&ntilde;a:</label><input type="password" name="clave" /> <input type="submit" style="width:80px" value="Cambiar" /></li>
    			</ul>
    			<p style="text-align:center"><?php if (isset($msg_clave)) echo $msg_clave; ?></p>
    		</fieldset>

    		<p style="text-align:center"></p>
    	</form>
    </div>
    <div class="clear">
    </div>