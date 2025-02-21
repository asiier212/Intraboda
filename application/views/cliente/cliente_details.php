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
				if ($respuestas_encuesta_datos_boda[0] <> "") {
					foreach ($preguntas_encuesta_datos_boda as $preguntas) {
				?><li>- <strong><?php echo $preguntas['pregunta'] ?></strong></li><br><?php
																						foreach ($respuestas_encuesta_datos_boda as $respuestas) {
																							if ($respuestas['id_pregunta'] == $preguntas['id_pregunta']) {
																								if ($preguntas['id_pregunta'] == '1') {
																						?>
    								<p><select name="participativo_dj" id="participacion1">
    										<option value="<?php echo $respuestas['respuesta'] ?>"><?php echo $respuestas['respuesta'] ?></option>
    										<?php
																									for ($i = 1; $i <= 10; $i++) {
											?><option value="<?php echo $i ?>"><?php echo $i ?></option><?php
																									}
																										?>
    									</select></p>
    							<?php
																								}
																								if ($preguntas['id_pregunta'] == '2') {
								?>
    								<p><select name="participativos_invitados" id="participacion2">
    										<option value="<?php echo $respuestas['respuesta'] ?>"><?php echo $respuestas['respuesta'] ?></option>
    										<?php
																									for ($i = 1; $i <= 10; $i++) {
											?><option value="<?php echo $i ?>"><?php echo $i ?></option><?php
																									}
																										?>
    									</select></p>
    							<?php
																								}
																								if ($preguntas['id_pregunta'] == '3') {
								?>
    								<li>Invitados: <input type="text" id="num_invitados" name="num_invitados" value="<?php echo $respuestas['respuesta'] ?>"></li><br>
    								<?php
																								}
																								if ($preguntas['id_pregunta'] == '4') {
																									if ($respuestas['respuesta'] == 'Si') {
									?>
    									<li><input type="radio" name="ampliar_fiesta" value="Si" checked> Sí</li>
    									<li><input type="radio" id="ampliar_fiesta" name="ampliar_fiesta" value="No"> No</li><br>
    								<?php
																									} else {
									?>
    									<li><input type="radio" name="ampliar_fiesta" value="Si"> Sí</li>
    									<li><input type="radio" id="ampliar_fiesta" name="ampliar_fiesta" value="No" checked> No</li><br>
    								<?php
																									}
																								}
																								if ($preguntas['id_pregunta'] == '5') {
																									if ($respuestas['respuesta'] == 'Si') {
									?>
    									<li><input type="radio" name="flexibilidad_restaurante" value="Si" checked> Sí</li>
    									<li><input type="radio" id="flexibilidad_restaurante" name="flexibilidad_restaurante" value="No"> No</li><br>
    								<?php
																									} else {
									?>
    									<li><input type="radio" name="flexibilidad_restaurante" value="Si"> Sí</li>
    									<li><input type="radio" id="flexibilidad_restaurante" name="flexibilidad_restaurante" value="No" checked> No</li><br>
    								<?php
																									}
																								}
																								if ($preguntas['id_pregunta'] == '6') {
									?>
    								<li>Hora: <input type="text" id="hora_ultimo_autobus" name="hora_ultimo_autobus" value="<?php echo $respuestas['respuesta'] ?>"></li><br>
    							<?php
																								}
																								if ($preguntas['id_pregunta'] == 7) {
																									$mas = explode(",", $respuestas['respuesta']);
								?>
    								<li><input type="checkbox" name="mas_importancia[]" value="Rock" <?php echo in_array('Rock', $mas) ? 'checked="checked"' : '' ?>> Rock</li>
    								<li><input type="checkbox" name="mas_importancia[]" value="Años70" <?php echo in_array('Años70', $mas) ? 'checked="checked"' : '' ?>> Años70</li>
    								<li><input type="checkbox" name="mas_importancia[]" value="Años 80 movida madrileña" <?php echo in_array('Años 80 movida madrileña', $mas) ? 'checked="checked"' : '' ?>> Años 80, movida madrileña</li>
    								<li><input type="checkbox" name="mas_importancia[]" value="Comercial (40 Principales)" <?php echo in_array('Comercial (40 Principales)', $mas) ? 'checked="checked"' : '' ?>> Comercial (40 Principales)</li>
    								<li><input type="checkbox" name="mas_importancia[]" value="Musica Latina" <?php echo in_array('Musica Latina', $mas) ? 'checked="checked"' : '' ?>> Musica Latina</li>
    								<li><input type="checkbox" name="mas_importancia[]" value="Bachata" <?php echo in_array('Bachata', $mas) ? 'checked="checked"' : '' ?>> Bachata</li>
    								<li><input type="checkbox" name="mas_importancia[]" value="Salsa" <?php echo in_array('Salsa', $mas) ? 'checked="checked"' : '' ?>> Salsa</li>
    								<li><input type="checkbox" name="mas_importancia[]" value="Merengue" <?php echo in_array('Merengue', $mas) ? 'checked="checked"' : '' ?>> Merengue</li>
    								<li><input type="checkbox" name="mas_importancia[]" value="Reggaeton" <?php echo in_array('Reggaeton', $mas) ? 'checked="checked"' : '' ?>> Reggaeton</li>
    								<li><input type="checkbox" name="mas_importancia[]" value="Revival (flying free ecuador...)" <?php echo in_array('Revival (flying free ecuador...)', $mas) ? 'checked="checked"' : '' ?>> Revival (flying free, ecuador...)</li>
    								<li><input type="checkbox" name="mas_importancia[]" value="Pachangueras" <?php echo in_array('Pachangueras', $mas) ? 'checked="checked"' : '' ?>> Pachangueras</li>
    								<li><input type="checkbox" name="mas_importancia[]" value="Nos es indiferente" <?php echo in_array('Nos es indiferente', $mas) ? 'checked="checked"' : '' ?>> Nos es indiferente</li>
    								<br>
    							<?php
																								}
																								if ($preguntas['id_pregunta'] == 8) {
																									$menos = explode(",", $respuestas['respuesta']);
								?>
    								<li><input type="checkbox" name="menos_importancia[]" value="Rock" <?php echo in_array('Rock', $menos) ? 'checked="checked"' : '' ?>> Rock</li>
    								<li><input type="checkbox" name="menos_importancia[]" value="Años70" <?php echo in_array('Años70', $menos) ? 'checked="checked"' : '' ?>> Años70</li>
    								<li><input type="checkbox" name="menos_importancia[]" value="Años 80 movida madrileña" <?php echo in_array('Años 80 movida madrileña', $menos) ? 'checked="checked"' : '' ?>> Años 80, movida madrileña</li>
    								<li><input type="checkbox" name="menos_importancia[]" value="Comercial (40 Principales)" <?php echo in_array('Comercial (40 Principales)', $menos) ? 'checked="checked"' : '' ?>> Comercial (40 Principales)</li>
    								<li><input type="checkbox" name="menos_importancia[]" value="Musica Latina" <?php echo in_array('Musica Latina', $menos) ? 'checked="checked"' : '' ?>> Musica Latina</li>
    								<li><input type="checkbox" name="menos_importancia[]" value="Bachata" <?php echo in_array('Bachata', $menos) ? 'checked="checked"' : '' ?>> Bachata</li>
    								<li><input type="checkbox" name="menos_importancia[]" value="Salsa" <?php echo in_array('Salsa', $menos) ? 'checked="checked"' : '' ?>> Salsa</li>
    								<li><input type="checkbox" name="menos_importancia[]" value="Merengue" <?php echo in_array('Merengue', $menos) ? 'checked="checked"' : '' ?>> Merengue</li>
    								<li><input type="checkbox" name="menos_importancia[]" value="Reggaeton" <?php echo in_array('Reggaeton', $menos) ? 'checked="checked"' : '' ?>> Reggaeton</li>
    								<li><input type="checkbox" name="menos_importancia[]" value="Revival (flying free ecuador...)" <?php echo in_array('Revival (flying free ecuador...)', $menos) ? 'checked="checked"' : '' ?>> Revival (flying free, ecuador...)</li>
    								<li><input type="checkbox" name="menos_importancia[]" value="Pachangueras" <?php echo in_array('Pachangueras', $menos) ? 'checked="checked"' : '' ?>> Pachangueras</li>
    								<li><input type="checkbox" name="menos_importancia[]" value="Nos es indiferente" <?php echo in_array('Nos es indiferente', $menos) ? 'checked="checked"' : '' ?>> Nos es indiferente</li>
    								<br>
    				<?php
																								}
																							}
																						}
																					}
					?>
    				<center><input type="submit" id="actualizar_encuesta" name="actualizar_encuesta" value="Actualizar Encuesta"></center>
    			<?php
				} else {
				?><li>No se ha realizado la encuesta</li><br><?php
															} ?>
    		</fieldset>

    		<fieldset class="datos">
    			<legend>Mis servicios contratados</legend>

    			<table class="tabledata">
    				<tr>
    					<th style="width:400px">Servicio</th>
    					<th style="width:200px">Importe</th>
    				</tr>
    				<?php
					$total = 0;
					$arr_servicios = unserialize($cliente['servicios']);
					$total = array_sum($arr_servicios);
					foreach ($servicios as $servicio) {
					?>
    					<tr>
    						<td><?php echo $servicio['nombre'] ?></td>
    						<td style="text-align:right;"><?php echo number_format($arr_servicios[$servicio['id']], 2, ',', '.') . " &euro;" ?></td>
    					</tr>
    				<?php

					}
					if ($cliente['descuento'] <> 0) {
					?>
    					<tr>
    						<td><b>Subtotal</b></td>
    						<td style="text-align:right;"><b><?php echo number_format($total, 2, ',', '.') ?> &euro;</b></td>
    					</tr>
    				<?php
					}
					if ($cliente['descuento'] <> 0) {
					?>
    					<tr>
    						<td>Descuento adicional aplicado</td>
    						<td style="text-align:right;"><?php echo number_format($cliente['descuento'], 2, ',', '.') ?> &euro;</td>
    					</tr>
    				<?php
					}
					?>
    				<tr>
    					<td><b>Total del contrato</b></td>
    					<td style="text-align:right;"><b><?php echo number_format(($total -  $cliente['descuento']), 2, ',', '.') ?> &euro;</b></td>
    				</tr>
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