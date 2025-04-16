<link rel="stylesheet" href="<?php echo base_url() ?>js/jquery1.10.4/themes/smoothness/jquery-ui.css">
<script src="<?php echo base_url() ?>js/jquery1.10.4/js/jquery-1.10.2.js"></script>
<script src="<?php echo base_url() ?>js/jquery1.10.4/js/jquery-ui-1.10.4.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery1.10.4/js/jquery.jeditable.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/tooltip.js"></script>
<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>




<script language="javascript">
	$(document).ready(function() {
		$('.pestana').hide();

		// ✅ Recuperar pestaña desde localStorage o default a #tab-1
		var activeTab = localStorage.getItem('activeTab') || '#tab-1';
		$(activeTab).show();
		$('.tabs li').removeClass("selected");
		$('.tabs li a[href="' + activeTab + '"]').parent().addClass("selected");

		$('.tabs li').click(function(e) {
			e.preventDefault();

			var id = $(this).find("a").attr("href");

			// ✅ Guardar en localStorage la pestaña seleccionada
			localStorage.setItem('activeTab', id);

			$('.pestana').hide();
			$('.tabs li').removeClass("selected");
			$(id).fadeToggle();
			$(this).addClass("selected");
		});

		// ✅ Si se fuerza la variable PHP $tab2, sobrescribimos lo anterior
		<?php if ($tab2 == true) { ?>
			localStorage.setItem('activeTab', '#tab-2');
		<?php } ?>
		// Activar buscador en el select de componentes para editar
		$('#editar_grupo_componentes').select2({
			width: '100%', // Asegura que el select se adapte al contenedor
			placeholder: 'Selecciona Componente',
			allowClear: true
		});
		// Aplica Select2 también al select de editar equipo
		$('#editar_grupo_equipos').select2({
			width: '100%',
			placeholder: 'Selecciona Equipo',
			allowClear: true
		});
	});
	// Captura el envío del formulario y guarda la pestaña activa antes de enviar
	$('#form_reparacion').submit(function() {
		localStorage.setItem('activeTab', '#tab-2');
	});

	function deleteasociacioncomponenteequipo(id) {
		if (confirm("\u00BFSeguro que desea desvincular la asociaci\u00f3n\u003F")) {
			//$("#result").html("Actualizando...");
			$.ajax({
				type: 'POST',
				url: '<?php echo base_url() ?>index.php/ajax/deleteasociacioncomponenteequipo',
				data: 'id=' + id,
				success: function(data) {
					//$("#can_" + id).css("display", "none");
					//$("#result").html("");
					//location.reload();
					location.href = '<?php echo base_url() ?>admin/mantenimiento_equipos';
				}
			});
		}
		return false
	}

	function deleteequipo(id) {
		if (confirm("¿Seguro que desea borrar el equipo y todas las asociaciones?")) {
			console.log("Enviando petición para ocultar equipo ID:", id);

			$.ajax({
				type: 'POST',
				url: '<?php echo base_url() ?>index.php/ajax/deleteequipo',
				data: 'id=' + id,
				success: function(data) {
					console.log("Respuesta del servidor:", data);

					// Forzar recarga incluso si Ajax caching interfiere
					if (data.trim() === '' || data.trim().toLowerCase() === 'ok') {
						window.location = window.location.href;
					} else {
						alert("El servidor respondió pero no se pudo recargar automáticamente.");
						location.reload(); // backup recarga
					}
				},
				error: function(xhr, status, error) {
					console.error("Error en la petición AJAX:", error);
					alert("Error al intentar eliminar el equipo.");
				}
			});
		}
		return false;
	}



	function deletecomponente(id) {
		if (confirm("\u00BFSeguro que desea borrar el componente\u003F")) {
			//$("#result").html("Actualizando...");
			$.ajax({
				type: 'POST',
				url: '<?php echo base_url() ?>index.php/ajax/deletecomponente',
				data: 'id=' + id,
				success: function(data) {
					//$("#can_" + id).css("display", "none");
					//$("#result").html("");
					//location.reload();
					location.href = '<?php echo base_url() ?>admin/mantenimiento_equipos';
				}
			});
		}
		return false
	}

	function deletereparacioncomponente(id) {
		if (confirm("\u00BFSeguro que desea borrar la reparación\u003F")) {
			//$("#result").html("Actualizando...");
			$.ajax({
				type: 'POST',
				url: '<?php echo base_url() ?>index.php/ajax/deletereparacioncomponente',
				data: 'id=' + id,
				success: function(data) {
					//$("#can_" + id).css("display", "none");
					//$("#result").html("");
					//location.reload();
					location.href = '<?php echo base_url() ?>admin/mantenimiento_equipos';
				}
			});
		}
		return false
	}

	$(function() {
		$('#anadir_equipo').click(function() {
			if ($('#nombre_equipo').val() == '') {
				alert("Debes añadir un nombre para el equipo");
				$('#nombre_equipo').focus();
				return false;
			}
		});
		$('#anadir_componente').click(function() {
			if ($('#n_registro').val() == '') {
				alert("Debes añadir un número de registro para el componente");
				$('#n_registro').focus();
				return false;
			}

			if ($('#nombre_componente').val() == '') {
				alert("Debes añadir un nombre para el componente");
				$('#nombre_componente').focus();
				return false;
			}
			if ($('#descripcion_componente').val() == '') {
				alert("Debes añadir una descripción para el componente");
				$('#descripcion_componente').focus();
				return false;
			}
		});

		$('#n_registro').focusout(function(e) {
			//alert('Hola');
			var componentes = new Array();
			<?php foreach ($componentes as $c) { ?>
				componentes.push("<?php echo $c['n_registro'] ?>");
			<?php } ?>
			for (i = 0; i < componentes.length; i++) {
				if (componentes[i] == $('#n_registro').val()) {
					alert("Ya existe un componente con ese número de serie");
					$('#n_registro').val('');
					$('#n_registro').focus();
					break;
				}
			}
		});

		$('#editar_grupo_equipos').change(function(event) {
			var fullurl = $('#hiddenurl').val() + 'index.php/ajax/buscardatosequipo/' + encodeURIComponent($('#editar_grupo_equipos').val());

			$.getJSON(fullurl, function(result) {
				$.each(result, function(i, val) {
					$('#editar_nombre_equipo').val(val.nombre_grupo);
				});

			});
		});

		$('#editar_grupo_componentes').change(function(event) {
			var fullurl = $('#hiddenurl').val() + 'index.php/ajax/buscardatoscomponente/' + encodeURIComponent($('#editar_grupo_componentes').val());

			$.getJSON(fullurl, function(result) {
				$.each(result, function(i, val) {
					$('#editar_n_registro').val(val.n_registro);
					$('#editar_nombre_componente').val(val.nombre_componente);
					$('#editar_descripcion_componente').val(val.descripcion_componente);
				});

			});
		});
	});
</script>

<style>
	.editable img {
		float: right
	}
</style>

<link href="<?php echo base_url() ?>css/pestanas.css" rel="stylesheet" type="text/css" />


<h2>
	Base de Datos de Equipamiento
</h2>
<div class="main form">

	<input value="<?php echo base_url() ?>" id="hiddenurl" type="hidden">

	<ul class="tabs">
		<?php
		//Con esto logramos que se si realiza un búsqueda en el tab2 se mantenga seleccionada esa pestaña
		if ($tab1 == true) { //Esta variable viene de admin.php indicando que se va a usar de inicio el tab2
		?>
			<li class="selected"><a href="#tab-1">Equipos y componentes</a></li>
			<li><a href="#tab-2">Reparaciones</a></li>
		<?php
		} else {
		?>
			<li><a href="#tab-1">Equipos y componentes</a></li>
			<li class="selected"><a href="#tab-2">Reparaciones</a></li>
		<?php
		}
		?>
	</ul>

	<div class="pestana" id="tab-1">

		<div style="display: grid; grid-template-columns: auto auto;padding-bottom: 40px">

			<!-- Fila 1: Equipos -->
			<div style="display: flex; justify-content: space-around; gap: 30px; flex-direction: column; padding: 20px 40px; border-right: 1px solid grey; padding-bottom: 40px">

				<fieldset style="margin: 0; background:#f9f9f9; border:1px solid #ddd; border-radius:12px; padding:25px; box-shadow:0 2px 8px rgba(0,0,0,0.05);">
					<legend style="font-weight:bold; color:#333; font-size:16px;">➕ Añadir Equipo</legend>
					<form method="post" style="display: flex; flex-direction: column;">
						<label style="display:block; margin-bottom:6px;">Nombre:</label>
						<input type="text" name="nombre_equipo" id="nombre_equipo" required
							style="padding: 8px; border:1px solid #ccc; border-radius:6px; margin-bottom: 20px;" />
						<input type="submit" name="anadir_equipo" id="anadir_equipo" value="Añadir"
							style="padding: 10px 20px; background-color:#007BFF; color:white; border:none; border-radius:6px; font-weight:bold; cursor:pointer; width: 200px" />
					</form>
				</fieldset>

				<fieldset style="margin: 0; background:#f9f9f9; border:1px solid #ddd; border-radius:12px; padding:25px; box-shadow:0 2px 8px rgba(0,0,0,0.05);">
					<legend style="font-weight:bold; color:#333; font-size:16px;">➕ Añadir Componente</legend>
					<form method="post" style="display: flex; flex-direction: column;">
						<label style="display:block; margin-bottom:6px;">Nº de registro:</label>
						<input type="text" name="n_registro" id="n_registro" required
							style="padding:8px; border:1px solid #ccc; border-radius:6px; margin-bottom:12px;" />

						<label style="display:block; margin-bottom:6px;">Nombre:</label>
						<input type="text" name="nombre_componente" id="nombre_componente" required
							style="padding:8px; border:1px solid #ccc; border-radius:6px; margin-bottom:12px;" />

						<label style="display:block; margin-bottom:6px;">Descripción:</label>
						<textarea name="descripcion_componente" id="descripcion_componente" rows="4" required
							style="padding:8px; border:1px solid #ccc; border-radius:6px; margin-bottom:20px;"></textarea>

						<input type="submit" name="anadir_componente" id="anadir_componente" value="Añadir"
							style="padding: 10px 20px; background-color:#007BFF; color:white; border:none; border-radius:6px; font-weight:bold; cursor:pointer; width: 200px" />
					</form>
				</fieldset>
			</div>

			<!-- Fila 2: Componentes -->
			<div style="display: flex; gap: 30px; flex-direction: column; padding: 20px 40px; border-left: 1px solid grey; padding-bottom: 40px">

				<fieldset style="margin: 0; background:#f9f9f9; border:1px solid #ddd; border-radius:12px; padding:25px; box-shadow:0 2px 8px rgba(0,0,0,0.05);">
					<legend style="font-weight:bold; color:#333; font-size:16px;">✏️ Modificar Equipo</legend>
					<form method="post" style="display: flex; flex-direction: column;">
						<label style="display:block; margin-bottom:6px;">Equipos:</label>
						<select name="editar_grupo_equipos" id="editar_grupo_equipos" required>
							<option value="">Selecciona Equipo</option>
							<?php foreach ($equipos as $e) { ?>
								<option value="<?php echo $e['id_grupo'] ?>"><?php echo $e['nombre_grupo'] ?></option>
							<?php } ?>
						</select>


						<label style="display:block; margin-bottom:6px;">Nombre:</label>
						<input type="text" name="editar_nombre_equipo" id="editar_nombre_equipo" required
							style="padding:8px; border:1px solid #ccc; border-radius:6px; margin-bottom:20px;" />

						<input type="submit" name="modificar_equipo" id="modificar_equipo" value="Modificar"
							style="padding: 10px 20px; background-color:#28a745; color:white; border:none; border-radius:6px; font-weight:bold; cursor:pointer; width: 200px" />
					</form>
				</fieldset>

				<fieldset style="margin: 0; background:#f9f9f9; border:1px solid #ddd; border-radius:12px; padding:25px; box-shadow:0 2px 8px rgba(0,0,0,0.05)">
					<legend style="font-weight:bold; color:#333; font-size:16px;">✏️ Modificar Componente</legend>
					<form method="post" style="display: flex; flex-direction: column;">
						<label style="display:block; margin-bottom:6px;">Componentes:</label>
						<select name="editar_grupo_componentes" id="editar_grupo_componentes" required>
							<option value="">Selecciona Componente</option>
							<?php foreach ($componentes as $c) { ?>
								<option value="<?php echo $c['id_componente'] ?>"><?php echo $c['nombre_componente'] ?></option>
							<?php } ?>
						</select>

						<label style="display:block; margin-bottom:6px;">Nº de registro:</label>
						<input type="text" name="editar_n_registro" id="editar_n_registro" required
							style="padding:8px; border:1px solid #ccc; border-radius:6px; margin-bottom:12px;" />

						<label style="display:block; margin-bottom:6px;">Nombre:</label>
						<input type="text" name="editar_nombre_componente" id="editar_nombre_componente" required
							style="padding:8px; border:1px solid #ccc; border-radius:6px; margin-bottom:12px;" />

						<label style="display:block; margin-bottom:6px;">Descripción:</label>
						<textarea name="editar_descripcion_componente" id="editar_descripcion_componente" rows="4" required
							style="padding:8px; border:1px solid #ccc; border-radius:6px; margin-bottom:20px;"></textarea>

						<input type="submit" name="modificar_componente" id="modificar_componente" value="Modificar"
							style="padding: 10px 20px; background-color:#28a745; color:white; border:none; border-radius:6px; font-weight:bold; cursor:pointer; width: 200px" />
					</form>
				</fieldset>
			</div>
		</div>

		<div>
			<form method="post">
				<fieldset style="margin: 0; background:#f9f9f9; border:1px solid #ddd; border-radius:12px; padding:25px; margin: 30px; box-shadow:0 2px 8px rgba(0,0,0,0.05);">
					<legend style="font-weight:bold; color:#333; font-size:16px;">🔗 Asociar Equipos a Componentes</legend>
					<form method="post">
						<div style="display: flex; justify-content: center; gap: 30px; align-items: center;">

							<div style="display: flex; flex-direction: column;">
								<label style="margin-bottom:6px;">Equipo:</label>
								<select name="grupo_equipos" required
									style="width: 100%; padding: 8px; border:1px solid #ccc; border-radius:6px;">
									<?php foreach ($equipos as $e) { ?>
										<option value="<?php echo $e['id_grupo'] ?>"><?php echo $e['nombre_grupo'] ?></option>
									<?php } ?>
								</select>
							</div>

							<div style="display: flex; flex-direction: column;">
								<label style="margin-bottom:6px;">Componente:</label>
								<select name="grupo_componentes" required
									style="width: 100%; padding: 8px; border:1px solid #ccc; border-radius:6px;">
									<?php foreach ($componentes_no_asociados as $c) { ?>
										<option value="<?php echo $c['id_componente'] ?>"><?php echo $c['nombre_componente'] ?></option>
									<?php } ?>
								</select>
							</div>

							<input type="submit" name="asociar" value="Asociar"
								style="padding: 10px 20px; background-color:#007BFF; color:white; border:none; border-radius:6px; font-weight:bold; cursor:pointer;" />
						</div>
					</form>
				</fieldset>


				<fieldset style="margin: 0; background:#f9f9f9; border:1px solid #ddd; border-radius:12px; padding:25px;margin: 30px; box-shadow:0 2px 8px rgba(0,0,0,0.05);">
					<legend style="font-weight:bold; color:#333; font-size:16px;">🧰 Equipamiento</legend>

					<div style="display: flex; flex-wrap: wrap; gap: 24px;">
						<?php foreach ($equipos as $e) { ?>
							<div style="background:white; border:1px solid #ccc; border-radius:12px; padding:20px; min-width:200px; max-width:300px; box-shadow:0 2px 4px rgba(0,0,0,0.1); flex: 1;">
								<h4 style="margin-top:0; color:#007BFF; font-family: Arial, Helvetica, sans-serif; font-size: 18px"><?php echo $e['nombre_grupo'] ?></h4>

								<?php
								if ($componentes_asociados) {
									$has_componentes = false;
									foreach ($componentes_asociados as $ca) {
										if ($ca['id_grupo'] == $e['id_grupo']) {
											$has_componentes = true;
											$reparaciones_realizadas = "No hay reparaciones de este componente";
											if ($reparaciones_totales) {
												foreach ($reparaciones_totales as $r) {
													if ($r['id_componente'] == $ca['id_componente']) {
														$reparaciones_realizadas = "<b>Reparaciones:</b><br>" . $r['fecha_reparacion'] . " - " . $r['reparacion'];
													}
												}
											}
								?>

											<div style="display:flex; align-items:center; justify-content:space-between; border:1px solid #eee; border-radius:6px; padding:8px 12px; margin-bottom:8px; background:#fefefe;">
												<span
													onmouseover="Tip('Nº de Registro: <?php echo $ca['n_registro'] ?><br>Descripción: <?php echo $ca['descripcion_componente'] ?><br><?php echo $reparaciones_realizadas ?>')"
													onmouseout="UnTip()"
													style="cursor:help; color:#333;">
													<?php echo $ca['nombre_componente'] ?>
												</span>
												<a href="#" onclick="return deleteasociacioncomponenteequipo(<?php echo $ca['id_componente'] ?>)">
													<img src="<?php echo base_url() ?>img/delete.gif" width="15" alt="Eliminar" title="Eliminar componente" />
												</a>
											</div>

								<?php }
									}

									if (!$has_componentes) {
										echo "<p style='color: #999;'>Sin componentes asociados</p>";
									}
								} else {
									echo "<p style='color: #999;'>Sin componentes asociados</p>";
								}
								?>
							</div>
						<?php } ?>
					</div>
				</fieldset>
			</form>

			<fieldset style="margin: 0; background:#f9f9f9; border:1px solid #ddd; border-radius:12px; padding:25px; margin: 30px; box-shadow:0 2px 8px rgba(0,0,0,0.05);">
				<legend style="font-weight:bold; color:#333; font-size:16px;">📋 Listado Equipos y Componentes</legend>

				<div style="display: flex; gap: 24px; flex-wrap: wrap;">

					<!-- Listado Equipos -->
					<div style="flex: 1; min-width: 250px; background:#fff; border:1px solid #ccc; border-radius:12px; padding:20px; box-shadow:0 2px 4px rgba(0,0,0,0.1);">
						<h4 style="margin-top:0; color:#007BFF; font-family: Arial, Helvetica, sans-serif; font-size: 18px">🛠️ Equipos</h4>
						<?php if ($equipos): ?>
							<ul style="padding-left:0;">
								<?php foreach ($equipos as $e): ?>
									<?php
									// Buscar si este equipo tiene algún componente
									$tiene_componentes = false;
									if ($componentes_asociados) {
										foreach ($componentes_asociados as $ca) {
											if ($ca['id_grupo'] == $e['id_grupo']) {
												$tiene_componentes = true;
												break;
											}
										}
									}
									?>
									<li style="list-style:none; display:flex; justify-content:space-between; align-items:center; padding:6px 0; border-bottom:1px solid #eee;">
										<span>
											<?php echo $e['nombre_grupo']; ?>
											<?php if (!$tiene_componentes): ?>
												<span style="color: #dc3545; font-size: 12px; margin-left: 8px; background: #f8d7da; padding: 2px 6px; border-radius: 6px;">Sin componentes</span>
											<?php endif; ?>
										</span>
										<a href="#" onclick="return deleteequipo(<?php echo $e['id_grupo'] ?>)">
											<img src="<?php echo base_url() ?>img/delete.gif" width="15" alt="Eliminar" title="Eliminar equipo" />
										</a>
									</li>
								<?php endforeach; ?>

							</ul>
						<?php else: ?>
							<p style="color: #999;">No hay equipos registrados.</p>
						<?php endif; ?>
					</div>

					<!-- Listado Componentes -->
					<div style="flex: 2; min-width: 350px; background:#fff; border:1px solid #ccc; border-radius:12px; padding:20px; box-shadow:0 2px 4px rgba(0,0,0,0.1);">
						<h4 style="margin-top:0; color:#007BFF; font-family: Arial, Helvetica, sans-serif; font-size: 18px">🔩 Componentes</h4>
						<?php if ($componentes): ?>
							<ul style="padding-left:0;">
								<?php foreach ($componentes as $c): ?>
									<?php
									$asignado = false;
									if ($componentes_asociados) {
										foreach ($componentes_asociados as $ca) {
											if ($ca['id_componente'] == $c['id_componente']) {
												$asignado = true;
												break;
											}
										}
									}
									?>
									<li style="list-style:none; margin-bottom: 14px; cursor: pointer;"
										onclick="mostrarHistorial(<?php echo $c['id_componente'] ?>)">
										<div style="display: flex; align-items: center; justify-content: space-between; border:1px solid #eee; border-radius:8px; padding:12px 16px;
		background: <?php echo $asignado ? '#fff' : '#f8f9fa'; ?>; box-shadow: 0 1px 3px rgba(0,0,0,0.05); margin-bottom: 12px;">

											<!-- Parte izquierda -->
											<div style="display: flex; align-items: center; gap: 12px;">
												<?php if (!empty($c['qr_path']) && file_exists(FCPATH . $c['qr_path'])): ?>
													<img src="<?php echo base_url() . $c['qr_path'] ?>" alt="QR" width="60" style="border:1px solid #ccc; background:#fff; padding:3px; border-radius:6px;">
												<?php else: ?>
													<em style="color: gray;">Sin QR</em>
												<?php endif; ?>

												<a
													onmouseover="Tip('Nº de Registro: <?php echo $c['n_registro'] ?><br>Descripción: <?php echo $c['descripcion_componente'] ?>')"
													onmouseout="UnTip()"
													style="cursor:help; color:#333; font-weight: 500; font-size: 15px; text-decoration: none;">
													<?php echo $c['nombre_componente'] ?>
												</a>

												<?php if (!$asignado): ?>
													<span style="color: #dc3545; font-size: 12px; background: #f8d7da; padding: 2px 6px; border-radius: 6px;">No asignado</span>
												<?php endif; ?>
											</div>

											<!-- Parte derecha -->
											<div style="display: flex; align-items: center; gap: 14px;">
												<?php if (!empty($c['qr_path']) && file_exists(FCPATH . $c['qr_path'])): ?>
													<a href="<?php echo base_url() . $c['qr_path'] ?>" download title="Descargar QR"
														style="font-size: 20px; text-decoration: none;" onclick="event.stopPropagation();">📥</a>
												<?php endif; ?>

												<a href="#" onclick="event.stopPropagation(); return deletecomponente(<?php echo $c['id_componente'] ?>)" title="Eliminar componente">
													<img src="<?php echo base_url() ?>img/delete.gif" width="16" alt="Eliminar" />
												</a>

											</div>
										</div>
									</li>
								<?php endforeach; ?>

							</ul>
						<?php else: ?>
							<p style="color: #999;">No hay componentes registrados.</p>
						<?php endif; ?>
					</div>

				</div>
			</fieldset>


		</div>

		<!-- Fondo oscuro -->
		<div id="fondoHistorial" onclick="cerrarHistorial()" style="display:none; position:fixed; top:0; left:0; width:100vw; height:100vh; background:rgba(0,0,0,0.4); z-index:999;"></div>

		<!-- Contenedor del popup -->
		<div id="popupHistorial" style="display:none; position:fixed; top:50%; left:50%; transform:translate(-50%, -50%); background:#fefefe; padding:25px 30px; border-radius:14px; box-shadow:0 20px 40px rgba(0,0,0,0.25); max-width:550px; width:90%; z-index:1000; font-family:'Segoe UI', sans-serif; color:#333;">

			<!-- Título -->
			<h3 style="margin-top:0; font-size:20px; color:#2c3e50; padding-bottom:10px;">
				📜 Historial de asignaciones
			</h3>

			<!-- Contenido dinámico -->
			<div id="contenidoHistorial" style="max-height:500px; overflow-y:auto; padding-right:5px; font-size:14px; line-height:1.6;"></div>

			<!-- Botón cerrar -->
			<div style="text-align:right; margin-top:20px;">
				<button onclick="cerrarHistorial()" style="background:#3498db; color:white; border:none; padding:10px 18px; font-size:14px; border-radius:6px; cursor:pointer; transition:background 0.3s;" onmouseover="this.style.background='#2980b9'" onmouseout="this.style.background='#3498db'">
					Cerrar
				</button>
			</div>
		</div>



		<script>
			const historialDatos = <?php echo json_encode($historial_componentes); ?>;

			function mostrarHistorial(idComponente) {
				const contenedor = document.getElementById('contenidoHistorial');
				const historial = historialDatos[idComponente];

				if (!historial || historial.length === 0) {
					contenedor.innerHTML = '<p style="color:gray; height: 30px">No hay historial registrado.</p>';
				} else {
					let html = '<ul style="padding-left:20px;">';
					historial.forEach(function(item) {
						html += `<li style="background:#f8f9fa; border:1px solid #ddd; border-radius:8px; padding:10px 14px; margin-bottom:10px; box-shadow:0 1px 2px rgba(0,0,0,0.05);">
									<strong>Asignado a:</strong> ${item.nombre_grupo || '<em>Equipo eliminado</em>'}<br>
									<strong>Desde:</strong> ${item.fecha_asignacion}<br>
									<strong>Hasta:</strong> ${item.fecha_desasignacion || '<em>Actual</em>'}
								</li>`;

					});
					html += '</ul>';
					contenedor.innerHTML = html;
				}

				document.getElementById('popupHistorial').style.display = 'block';
				document.getElementById('fondoHistorial').style.display = 'block';
			}

			function cerrarHistorial() {
				document.getElementById('popupHistorial').style.display = 'none';
				document.getElementById('fondoHistorial').style.display = 'none';
			}
		</script>


	</div>

	<div class="pestana" id="tab-2">
		<fieldset class="datos">
			<legend>A&ntilde;adir reparación</legend>

			<div style="float:left">
				<form id="form_reparacion" method="post" action="<?php echo base_url() ?>admin/mantenimiento_equipos">
					<label style="width:100px">Componente:</label>
					<select style="display:block; float:left" name="reparacion_componente" id="reparacion_componente" required>
						<option value="">Selecciona Componente</option>
						<?php foreach ($componentes as $c) { ?>
							<option value="<?php echo $c['id_componente'] ?>"><?php echo $c['n_registro'] ?></option>
						<?php } ?>
					</select><br>

					<label style="width:100px">Reparación:</label>
					<textarea name="descripcion_reparacion" id="descripcion_reparacion" cols="30" rows="5" required></textarea><br><br>

					<input type="submit" style="width:100px; margin-left:150px;" name="anadir_reparacion" id="anadir_reparacion" value="Añadir" />
				</form>

			</div>
		</fieldset>

		<fieldset class="datos">
			<legend>Reparaciones realizadas</legend>
			<form method="get" style="margin:10px 0">
				Buscador por: &nbsp;
				<select name="f">
					<option value="n_registro" <?php if (isset($_GET['f']) && $_GET['f'] == 'componentes.n_registro') echo 'selected="selected"' ?>>Nº registro componente</option>
					<option value="nombre_componente" <?php if (isset($_GET['f']) && $_GET['f'] == 'componentes.nombre_componente') echo 'selected="selected"' ?>>Nombre componente</option>
					<option value="fecha_reparacion" <?php if (isset($_GET['f']) && $_GET['f'] == 'reparaciones.componentes.fecha_reparacion') echo 'selected="selected"' ?>>Fecha reparacion (dd-mm-aaaa)</option>
				</select>
				<input type="text" name="q" value="<?php if (isset($_GET['q'])) echo $_GET['q'] ?>">
				<input type="submit" value="Buscar" style="margin-right:30px" />
				<a href="<?php echo base_url() ?>admin/mantenimiento_equipos">Limpiar buscador</a>
			</form>
			<?php
			if ($reparaciones) {

				if (isset($_GET['q']) && !isset($_GET['p']))
					$url_ord = base_url() . "admin/mantenimiento_equipos?f=" . $_GET['f'] . "&q=" . $_GET['q'] . "&ord=";
				elseif (isset($_GET['q']) && isset($_GET['p']))
					$url_ord = base_url() . "admin/mantenimiento_equipos?f=" . $_GET['f'] . "&q=" . $_GET['q'] . "&p=" . $_GET['p'] . "&ord=";
				else
					$url_ord = base_url() . "admin/mantenimiento_equipos?ord=";

			?>
				<table class="tabledata" width="100%">
					<tr>
						<th width="10%">Nº registro</th>
						<th width="25%">Componente</th>
						<th width="25%">Fecha de reparación</a></th>
						<th width="40%">Reparación</th>
						<th></th>
					</tr>
					<?php
					foreach ($reparaciones as $r) { ?>
						<tr>
							<td><?php echo $r['n_registro'] ?></td>
							<td><?php echo $r['nombre_componente'] ?></td>
							<td><?php echo $r['fecha_reparacion'] ?></td>
							<td><?php echo $r['reparacion'] ?></td>
							<td><a href="#" onclick="return deletereparacioncomponente(<?php echo $r['id_reparacion'] ?>)"><img src="<?php echo base_url() ?>img/cancel.gif" width="15" /></a></td>
						</tr>
					<?php
					} ?>
				</table>

				<div class="pag">
					<?php
					if (isset($_GET['q']) && !isset($_GET['ord']))
						$url_pag = base_url() . "admin/mantenimiento_equipos?f=" . $_GET['f'] . "&q=" . $_GET['q'] . "&p=";
					elseif (isset($_GET['q']) && isset($_GET['ord']))
						$url_pag =  base_url() . "admin/mantenimiento_equipos?f=" . $_GET['f'] . "&q=" . $_GET['q'] . "&ord=" . $_GET['ord'] . "&p=";
					else
						$url_pag =  base_url() . "admin/mantenimiento_equipos?p=";


					?>
					<?php if ($num_rows > $rows_page) {
						if ($page > 2) { ?>
							<a class="pP" href="<?php echo $url_pag; ?><?php echo $page - 1; ?>" title="Pagina <?php echo $page - 1; ?>">&laquo; Anterior</a>
						<?php }
						if ($page == 2) { ?>
							<a href="<?php echo $url_pag; ?>1" title="Pagina <?php echo $page - 1; ?>">&laquo; Anterior</a>
						<?php }
						if ($page > 3) { ?>
							<a href="<?php echo $url_pag; ?>1">1</a> ...<?php
																	}
																	for ($i = $page - 2; $i <= $page + 2; $i++) {
																		if ($i == 1) { ?>
							<a href="<?php echo $url_pag; ?>1">1</a><?php
																		}
																		if ($i == $page && $i != 1) { ?>
							<a href="#" class="sel"><?php echo $i; ?></a> <?php
																		} elseif ($i > 1 && $i <= $last_page) { ?>
							<a href="<?php echo $url_pag; ?><?php echo $i; ?>" title="Pagina <?php echo $i; ?>"><?php echo $i; ?></a><?php
																																	}
																																}
																																if ($i - 1 < $last_page) { ?>
						... <a href="<?php echo $url_pag; ?><?php echo $last_page; ?>" title="Pagina <?php echo $last_page; ?>"><?php echo $last_page; ?></a><?php
																																							}
																																							if ($page < $last_page) { ?>
						<a class="nP" href="<?php echo $url_pag; ?><?php echo $page + 1; ?>" title="Pagina <?php echo $page + 1; ?>">Siguiente &raquo;</a><?php
																																							}
																																						} ?>
				</div>

			<?php } else {
				echo "No hay datos";
			} ?>

		</fieldset>
	</div>
	<p style="text-align:center"></p>

</div>
<div class="clear">
</div>

<style>
	/* Ancho completo del contenedor */
	.select2-container {
		width: 100% !important;
	}

	/* Input visual del select */
	.select2-selection {
		padding: 3px;
		border: 1px solid #ccc !important;
		border-radius: 6px !important;
		height: auto !important;
		min-height: 38px;
		margin-bottom: 12px;
	}

	/* Texto del placeholder o seleccionado */
	.select2-selection__rendered {
		color: black;
		font-size: 14px;
	}

	/* Flecha desplegable */
	.select2-selection__arrow {
		margin-top: 5px;
	}
</style>