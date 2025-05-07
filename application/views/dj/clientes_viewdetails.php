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
<span class="spantitulo" style="display: flex; justify-content: space-between; align-items: center">
	<h2>
		Detalles del cliente
	</h2>
	<button onclick="window.open('<?php echo base_url() ?>dj/dj_chat/<?php echo $cliente['id'] ?>', '_blank')">Chatear con <?php echo $cliente['nombre_novio'] . " y " . $cliente['nombre_novia'] ?></button>
</span>

<style>
	.spantitulo button {
		margin-bottom: 20px;
		padding: 8px 20px;
		background-color: #93CE37;
		border: 2px solid rgb(90, 119, 43);
		border-radius: 5px;
		font-size: 14px;
		font-weight: bold;
		color: rgb(38, 46, 25);
		cursor: pointer;
	}

	.spantitulo button:hover {
		transform: scale(1.02);
		transition: transform 0.3s ease;
	}
</style>
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

			<?php
			function renderBloqueEquipo($tipo_equipo, $equipo_asignado, $equipos_disponibles, $detalles_equipo)
			{
				$asignado = isset($equipo_asignado) && $equipo_asignado != null;
				$nombre_grupo = $asignado ? $equipo_asignado['nombre_grupo'] : '';

				// Si hay detalles, preparar string JSON manual (solo lo que necesitamos)
				$componentes_string = '';
				if (!empty($detalles_equipo['componentes']) && is_array($detalles_equipo['componentes'])) {
					foreach ($detalles_equipo['componentes'] as $c) {
						$reps = '';
						if (!empty($c['reparaciones'])) {
							foreach ($c['reparaciones'] as $r) {
								$reps .= $r['reparacion'] . '%%' . $r['fecha_reparacion'] . '||'; // Reparacion%%Fecha||...
							}
						}
						$componentes_string .= htmlspecialchars(
							$c['nombre_componente'] . '||' .
								$c['n_registro'] . '||' .
								$c['descripcion_componente'] . '||' .
								$c['num_reparaciones'] . '||' .
								$reps
						) . '##';
					}
				}
			?>
				<?php if ($asignado): ?>
					<div style="display: flex; align-items: center; gap: 5px; margin-bottom: 10px;">
						<span>
							<?php echo $tipo_equipo; ?> Asignado:
							<?php
							$style_borrado = (isset($equipo_asignado['borrado']) && $equipo_asignado['borrado'] == 1)
								? 'color:red; font-weight:bold;'
								: '';
							?>
							<b>
								<a href="#"
									class="mostrar-popup"
									style="<?php echo $style_borrado; ?>"
									data-nombre="<?php echo htmlspecialchars($detalles_equipo['nombre_grupo']); ?>"
									data-fecha="<?php echo isset($detalles_equipo['fecha_asignacion']) ? date('d/m/Y', strtotime($detalles_equipo['fecha_asignacion'])) : ''; ?>"
									data-componentes-html="<?php echo htmlspecialchars($html_componentes); ?>"
									data-borrado="<?php echo isset($equipo_asignado['borrado']) ? $equipo_asignado['borrado'] : 0; ?>"
									data-tipo="<?php echo $tipo_equipo; ?>">
									<?php echo $nombre_grupo; ?>
								</a>
							</b>
						</span>
						<form method="POST" style="margin: 0;">
							<input type="hidden" name="tipo_equipo" value="<?php echo $tipo_equipo; ?>">
							<button type="submit" name="eliminar_equipo" style="background: none; border: none; padding: 0; cursor: pointer;">
								<img src="<?php echo base_url() ?>img/delete.gif" alt="Eliminar" style="width:15px; vertical-align: middle;" />
							</button>
						</form>
					</div>
				<?php else: ?>
					<div style="margin-bottom: 10px;">
						<form method="POST" style="display:inline;">
							<?php echo $tipo_equipo; ?>:
							<select style="width:200px" name="id_grupo">
								<option value="">Sin Asignar</option>
								<?php foreach ($equipos_disponibles as $equipo): ?>
									<option value="<?php echo $equipo['id_grupo']; ?>"><?php echo $equipo['nombre_grupo']; ?></option>
								<?php endforeach; ?>
							</select>
							<input type="hidden" name="tipo_equipo" value="<?php echo $tipo_equipo; ?>">
							<input type="submit" name="asignar" value="Asignar" style="width: 70px;" />
						</form>
					</div>
				<?php endif;
			}
			foreach ($equipos_asignados as $tipo_equipo => $equipo_asignado): ?>
				<?php renderBloqueEquipo(
					$tipo_equipo,
					$equipo_asignado,
					$equipos_disponibles,
					isset($equipos_detalles[$tipo_equipo]) ? $equipos_detalles[$tipo_equipo] : []
				); ?>
			<?php endforeach; ?>


			<div id="popup_equipo" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.4); z-index:9999;">
				<div id="popup_content" style="background:#fff; margin:80px auto; padding:30px; max-width:700px; border-radius:10px; position:relative; box-shadow:0 0 20px rgba(0,0,0,0.3); font-family:'Segoe UI', Tahoma, sans-serif;">

					<!-- Header -->
					<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; border-bottom: 1px solid #eee; padding-bottom: 15px;">
						<div>
							<div style="font-size: 20px; font-weight: bold; color: #222; margin-bottom: 5px;" id="popup_nombre">Nombre del equipo</div>
							<div style="font-size: 13px; color: #666;">
								📅 Fecha de asignación: <span id="popup_fecha" style="color: #000;"></span>
							</div>
						</div>
						<span onclick="document.getElementById('popup_equipo').style.display='none'" style="cursor:pointer; font-size:22px; padding: 5px;">❌</span>
					</div>

					<!-- Aviso de borrado -->
					<div id="popup_aviso_borrado" style="display:none; margin-bottom:15px; padding:10px; background-color:#ffe5e5; color:#b30000; border:1px solid #e63737; border-radius:5px; font-size:13px;">
						⚠️ Este equipo ha sido borrado.
					</div>

					<!-- Tabs -->
					<div id="popup_tabs" style="display: flex; border-bottom: 1px solid #ddd; margin-bottom: 20px;">
						<button type="button" onclick="mostrarTabEquipo('componentes')" id="tab_componentes"
							style="flex: 1; padding: 12px 0; border: none; cursor: pointer; font-size: 15px; font-weight: bold; border-top-left-radius: 10px; border-top-right-radius: 10px; background: #f2f2f2; border-bottom: 2px solid #93CE37;">
							Componentes
						</button>
						<button type="button" onclick="mostrarTabEquipo('revision')" id="tab_revision"
							style="flex: 1; padding: 12px 0; border: none; cursor: pointer; font-size: 15px; font-weight: bold; border-top-left-radius: 10px; border-top-right-radius: 10px; background: #ffffff; border-bottom: 2px solid transparent;">
							Revisión
						</button>

					</div>

					<!-- CONTENIDO: Componentes -->
					<div id="tab_content_componentes">
						<?php foreach ($equipos_detalles as $tipo_equipo_loop => $detalle): ?>
							<div class="bloque_componentes" data-tipo-equipo="<?php echo $tipo_equipo_loop; ?>" style="display: none;">
								<h3 style="margin: 0 0 20px 0; color: #333; font-size: 22px; font-weight: 600; font-family: Arial, Helvetica, sans-serif;">
									Componentes:
								</h3>

								<ul style="list-style:none; padding:0; margin:0; max-height:60vh; overflow-y:auto;">
									<?php if (!empty($detalle['componentes'])): ?>
										<?php foreach ($detalle['componentes'] as $c): ?>
											<?php
											$tieneReparaciones = intval($c['num_reparaciones']) > 0;
											$colorBorde = $tieneReparaciones ? '#e63737' : '#4a90e2';
											?>
											<li style="margin-bottom:20px; padding:10px; padding-left:18px; border-radius:6px; background:#fff; border:1px solid #ddd; border-left:8px solid <?php echo $colorBorde; ?>; box-shadow:0 1px 3px rgba(0,0,0,0.08); box-sizing:border-box;">
												<div style="display:flex; gap: 10px; align-items:center;">
													<span style="font-weight:bold; font-size:16px; margin-bottom:6px;"><?php echo $c['nombre_componente']; ?></span>
													<span style="color:#444; margin-bottom:6px; font-size: 12px">(Nº Registro: <b><?php echo $c['n_registro'] . ")"; ?></b></span>
												</div>
												<div style="margin-bottom:6px; line-height:1.4; color:#333;">Descripción: <?php echo $c['descripcion_componente']; ?></div>
												<div style="margin-bottom:6px; line-height:1.4; color:#333;">URLs:
													<?php
													$urls = array();
													if (isset($c['urls']) && !empty($c['urls'])) {
														$urls_decoded = json_decode($c['urls'], true);
														if (is_array($urls_decoded)) {
															$urls = $urls_decoded;
														}
													}
													?>
													<?php if (!empty($urls)): ?>
														<ul>
															<?php foreach ($urls as $url): ?>
																<li style="padding:0">
																	<a href="<?php echo htmlspecialchars($url); ?>" target="_blank" style="color:#007bff;">
																		<?php echo htmlspecialchars($url); ?>
																	</a>
																</li>
															<?php endforeach; ?>
														</ul>
													<?php else: ?>
														<span style="color:#999;"><em>Sin enlaces.</em></span>
													<?php endif; ?>

												</div>

												<?php if (!empty($c['reparaciones'])): ?>
													<?php foreach ($c['reparaciones'] as $r): ?>
														<div style="margin-top:10px; font-size:13px; color:#b30000;">
															✖ <?php echo $r['reparacion']; ?>
															<?php if (!empty($r['fecha_reparacion'])): ?>
																<span style="color:#888;">(<?php echo $r['fecha_reparacion']; ?>)</span>
															<?php endif; ?>
														</div>
													<?php endforeach; ?>
												<?php endif; ?>
											</li>
										<?php endforeach; ?>
									<?php else: ?>
										<li style="color:#666;">No hay componentes asignados.</li>
									<?php endif; ?>
								</ul>
							</div>
						<?php endforeach; ?>
					</div>



					<!-- CONTENIDO: Revisión -->
					<div id="tab_content_revision" style="display:none;">
						<?php foreach ($equipos_detalles as $tipo_equipo_loop => $detalle): ?>
							<?php
							$rev_salida = isset($revisiones_guardadas[$tipo_equipo_loop]['revision_salida'])
								? $revisiones_guardadas[$tipo_equipo_loop]['revision_salida']
								: [];

							$rev_fin = isset($revisiones_guardadas[$tipo_equipo_loop]['revision_fin'])
								? $revisiones_guardadas[$tipo_equipo_loop]['revision_fin']
								: [];

							$rev_pabellon = isset($revisiones_guardadas[$tipo_equipo_loop]['revision_pabellon'])
								? $revisiones_guardadas[$tipo_equipo_loop]['revision_pabellon']
								: [];
							?>


							<form method="POST" class="formulario_revision" data-tipo-equipo="<?php echo $tipo_equipo_loop; ?>" style="display:none; margin:0;">
								<input type="hidden" name="guardar_revisiones" value="1">
								<input type="hidden" name="tipo_equipo_revision" value="<?php echo $tipo_equipo_loop; ?>">

								<table style="width:100%; border-collapse: collapse; font-size:14px;">
									<thead>
										<tr style="background:#f2f2f2;">
											<th style="text-align:left; padding:10px; border-bottom:1px solid #ddd; font-size: 16px">Componente</th>
											<th style="text-align:center; padding:10px; border-bottom:1px solid #ddd; font-size: 16px; width: 120px">Salida</th>
											<th style="text-align:center; padding:10px; border-bottom:1px solid #ddd; font-size: 16px; width: 120px">Fin Evento</th>
											<th style="text-align:center; padding:10px; border-bottom:1px solid #ddd; font-size: 16px; width: 120px">Pabellón</th>
										</tr>
									</thead>
									<tbody>
										<?php if (!empty($detalle['componentes'])): ?>
											<?php foreach ($detalle['componentes'] as $c): ?>
												<tr>
													<td style="padding:10px; border-bottom:1px solid #eee; font-size: 17px">
														<?php echo $c['nombre_componente']; ?>
													</td>
													<td style="text-align:center; border-bottom:1px solid #eee; font-size: 17px">
														<input type="checkbox" style="transform: scale(1.5)" name="revision_salida[<?php echo $c['id_componente']; ?>]"
															<?php echo in_array($c['id_componente'], $rev_salida) ? 'checked' : ''; ?>>
													</td>
													<td style="text-align:center; border-bottom:1px solid #eee; font-size: 17px">
														<input type="checkbox" style="transform: scale(1.5)" name="revision_fin[<?php echo $c['id_componente']; ?>]"
															<?php echo in_array($c['id_componente'], $rev_fin) ? 'checked' : ''; ?>>
													</td>
													<td style="text-align:center; border-bottom:1px solid #eee; font-size: 17px">
														<input type="checkbox" style="transform: scale(1.5)" name="revision_pabellon[<?php echo $c['id_componente']; ?>]"
															<?php echo in_array($c['id_componente'], $rev_pabellon) ? 'checked' : ''; ?>>
													</td>
												</tr>
											<?php endforeach; ?>
										<?php endif; ?>
									</tbody>
								</table>

								<div style="text-align:center; margin-top:20px;">
									<button type="submit" style="padding:10px 20px; background:#93CE37; color:#fff; border:none; border-radius:4px; font-weight:bold; cursor:pointer; font-size:16px;">
										GUARDAR
									</button>
								</div>
							</form>
						<?php endforeach; ?>
					</div>


				</div>
			</div>


			<script>
				function mostrarTabEquipo(tab) {
					var tabComp = document.getElementById('tab_componentes');
					var tabRev = document.getElementById('tab_revision');

					if (tab === 'componentes') {
						tabComp.style.background = '#f2f2f2';
						tabComp.style.borderBottom = '2px solid #93CE37';

						tabRev.style.background = '#ffffff';
						tabRev.style.borderBottom = '2px solid transparent';
					} else {
						tabRev.style.background = '#f2f2f2';
						tabRev.style.borderBottom = '2px solid #93CE37';

						tabComp.style.background = '#ffffff';
						tabComp.style.borderBottom = '2px solid transparent';
					}

					document.getElementById('tab_content_componentes').style.display = tab === 'componentes' ? 'block' : 'none';
					document.getElementById('tab_content_revision').style.display = tab === 'revision' ? 'block' : 'none';
				}
			</script>


			<script>
				window.onload = function() {
					var enlaces = document.getElementsByClassName('mostrar-popup');
					for (var i = 0; i < enlaces.length; i++) {
						enlaces[i].onclick = function(e) {
							e.preventDefault();

							var nombre = this.getAttribute('data-nombre');
							var fecha = this.getAttribute('data-fecha');
							var borrado = this.getAttribute('data-borrado');
							var tipo_equipo = this.getAttribute('data-tipo');

							document.getElementById('popup_nombre').innerHTML = nombre;
							document.getElementById('popup_fecha').innerHTML = fecha;

							var avisoBorrado = document.getElementById('popup_aviso_borrado');
							var tabs = document.getElementById('popup_tabs');

							if (borrado == '1') {
								avisoBorrado.style.display = 'block';
								tabs.style.display = 'none';
								document.getElementById('tab_content_componentes').style.display = 'none';
								document.getElementById('tab_content_revision').style.display = 'none';
							} else {
								avisoBorrado.style.display = 'none';
								tabs.style.display = 'flex';

								// Mostrar la pestaña por defecto
								mostrarTabEquipo('componentes');

								// Ocultar todos los formularios de revisión
								const formularios = document.querySelectorAll('.formulario_revision');
								formularios.forEach(f => f.style.display = 'none');

								// Mostrar el formulario correspondiente
								const formVisible = document.querySelector(`.formulario_revision[data-tipo-equipo="${tipo_equipo}"]`);
								if (formVisible) formVisible.style.display = 'block';

								// Ocultar todos los bloques de componentes
								const bloques = document.querySelectorAll('.bloque_componentes');
								bloques.forEach(b => b.style.display = 'none');

								// Mostrar el bloque correspondiente de componentes
								const bloqueVisible = document.querySelector(`.bloque_componentes[data-tipo-equipo="${tipo_equipo}"]`);
								if (bloqueVisible) bloqueVisible.style.display = 'block';
							}

							document.getElementById('popup_equipo').style.display = 'block';
						};
					}
				};
			</script>



			<div id="equipos_dinamicos_container"></div>

			<button type="button" onclick="agregarEquipoDinamico()">
				Añadir Otro Equipo
			</button>
			<div id="bloque_equipo_template" style="display:none;">
				<div class="bloque_equipo_dinamico" data-equipo-num="X" style="margin-bottom: 10px;">
					<form method="POST" style="display:inline;">
						<span class="etiqueta_tipo_equipo">Equipo X:</span>
						<select style="width:200px" name="id_grupo">
							<option value="">Sin Asignar</option>
							<?php foreach ($equipos_disponibles as $equipo): ?>
								<option value="<?php echo $equipo['id_grupo']; ?>"><?php echo $equipo['nombre_grupo']; ?></option>
							<?php endforeach; ?>
						</select>
						<input type="hidden" name="tipo_equipo" value="Equipo X">
						<input type="submit" name="asignar" value="Asignar" style="width: 70px;" />
					</form>
				</div>
			</div>


			<script>
				let equipoCounter = <?php echo isset($proximo_equipo_num) ? $proximo_equipo_num : 4; ?>;


				function agregarEquipoDinamico() {
					const container = document.getElementById('equipos_dinamicos_container');
					const template = document.getElementById('bloque_equipo_template');

					// Clonar
					const nuevoBloque = template.firstElementChild.cloneNode(true);

					// Reemplazar “X” por el número real del equipo
					nuevoBloque.setAttribute('data-equipo-num', equipoCounter);
					const html = nuevoBloque.innerHTML.replace(/Equipo X/g, 'Equipo ' + equipoCounter);
					nuevoBloque.innerHTML = html;

					// Añadir al contenedor
					container.appendChild(nuevoBloque);

					// Aumentar contador
					equipoCounter++;
				}
			</script>
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

			.toggle-label input:checked+.toggle-slider {
				background: #4CAF50;
			}

			.toggle-label input:checked+.toggle-slider::before {
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