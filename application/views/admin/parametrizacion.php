<script src="<?php echo base_url() ?>js/jquery1.10.4/js/jquery-1.10.2.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo base_url() ?>js/jquery1.10.4/js/jquery-ui-1.10.4.min.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo base_url() ?>js/colorpicker/js/evol.colorpicker.min.js" type="text/javascript" charset="utf-8"></script>

<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>js/jquery1.10.4/css/ui-lightness/jquery-ui-1.10.4.css">
<link href="<?php echo base_url() ?>js/colorpicker/css/evol.colorpicker.css" rel="stylesheet" type="text/css">

<script type="text/javascript">
	$(document).ready(function() {
		$("#color").colorpicker();
	});
</script>

<script language="javascript">
	function deletecuenta_bancaria(id) {
		if (confirm("\u00BFSeguro que desea borrar la cuenta bancaria?")) {
			$("#result").html("Actualizando...");
			$.ajax({
				type: 'POST',
				url: '<?php echo base_url() ?>index.php/ajax/deletecuentabancaria',
				data: 'id=' + id,
				success: function(data) {
					$("#cuenta_" + id).css("display", "none");
					$("#result").html("");
				}
			});
		}
		return false
	}

	function deletecanal_captacion(id) {
		if (confirm("\u00BFSeguro que desea borrar el canal de captaci\u00f3n?")) {
			$("#result").html("Actualizando...");
			$.ajax({
				type: 'POST',
				url: '<?php echo base_url() ?>index.php/ajax/deletecanalcaptacion',
				data: 'id=' + id,
				success: function(data) {
					$("#capta_" + id).css("display", "none");
					$("#result").html("");
				}
			});
		}
		return false
	}

	function deletemomento_especial(id) {
		if (confirm("\u00BFSeguro que desea borrar el momento especial?")) {
			$("#result_bd_momento_espec").html("Actualizando...");
			$.ajax({
				type: 'POST',
				url: '<?php echo base_url() ?>index.php/ajax/deletemomentoespecial',
				data: 'id=' + id,
				success: function(data) {
					$("#momento_" + id).css("display", "none");
					$("#result_bd_momento_espec").html("");
				}
			});
		}
		return false;
	}

	function deleteestado_solicitud(id) {
		if (confirm("\u00BFSeguro que desea borrar el estado de la solicitud?")) {
			$("#result_estado_solicitud").html("Actualizando...");
			$.ajax({
				type: 'POST',
				url: '<?php echo base_url() ?>index.php/ajax/deleteestadosolicitud',
				data: 'id=' + id,
				success: function(data) {
					$("#estado_" + id).css("display", "none");
					$("#result_estado_solicitud").html("");
				}
			});
		}
		return false
	}

	function deletetipo_cliente(id) {
		if (confirm("\u00BFSeguro que desea borrar el tipo de cliente? Si lo elimina los clientes que afectan a este tipo se convertirán en Cliente Estándar")) {
			$("#result_tipo_cliente").html("Actualizando...");
			$.ajax({
				type: 'POST',
				url: '<?php echo base_url() ?>index.php/ajax/deletetipocliente',
				data: 'id=' + id,
				success: function(data) {
					$("#tipo_cliente_" + id).css("display", "none");
					$("#result_tipo_cliente").html("");
				}
			});
		}
		return false
	}
</script>


<style>
	.editable img {
		float: right
	}


</style>
<h2>
	Parametrizaci&oacute;n
</h2>
<div class="main form">

	<!--Cuenta Bancaria -->
	<h2>Cuentas Bancarias</h2>
	<div class="main form">
		<form method="post" name="canal">
			<fieldset class="datos">
				<legend>Añadir Cuenta Bancaria</legend>
				<ul>
					<li>
						<label>Nueva Entidad:</label>
						<input type="text" name="entidad" required />
					</li>
					<li>
						<label>Cuenta Bancaria:</label>
						<input type="text" name="iban" style="width:50px;" maxlength="4" required />
						<input type="text" name="codigo_entidad" style="width:50px;" maxlength="4" required />
						<input type="text" name="codigo_oficina" style="width:50px;" maxlength="4" required />
						<input type="text" name="codigo_control" style="width:25px;" maxlength="2" required />
						<input type="text" name="numero_cuenta" style="width:150px;" maxlength="10" required />
						<input type="submit" value="Añadir" />
					</li>
				</ul>
				<br><br>

				<fieldset style="width:90%;">
					<legend>Listado de Cuentas</legend>

					<table class="tabledata" id="tabla-cuentas">
						<tr>
							<th></th>
							<th>Entidad</th>
							<th>IBAN</th>
							<th>Cod. Entidad</th>
							<th>Cod. Oficina</th>
							<th>Control</th>
							<th>Nº Cuenta</th>
							<th>Acción</th>
						</tr>
						<?php if (!empty($cuentas_bancarias)) : ?>
							<?php foreach ($cuentas_bancarias as $cuenta) : ?>
								<tr id="cuenta_<?= $cuenta['id_cuenta'] ?>" class="sortable-row" data-id="<?= $cuenta['id_cuenta'] ?>">
									<td class="drag-handle">☰</td>
									<td><?= $cuenta['entidad'] ?></td>
									<td><?= $cuenta['iban'] ?></td>
									<td><?= $cuenta['codigo_entidad'] ?></td>
									<td><?= $cuenta['codigo_oficina'] ?></td>
									<td><?= $cuenta['codigo_control'] ?></td>
									<td><?= $cuenta['numero_cuenta'] ?></td>
									<td>
									<a href="#" onclick="return deletecuenta_bancaria(<?= $cuenta['id_cuenta'] ?>)">
										<img src="<?= base_url() ?>img/delete.gif" width="15" />
									</a>
									</td>
								</tr>
							<?php endforeach; ?>
						<?php else : ?>
							<tr>
								<td colspan="8">No hay cuentas bancarias registradas.</td>
							</tr>
						<?php endif; ?>
					</table>
				</fieldset>
			</fieldset>
		</form>
	</div>


	<!--Canal de captacion -->
	<div class="main form">
		<h2>Canales de Captación</h2>
		<form method="post" name="canal">
			<fieldset class="datos">
				<legend>Añadir Canal de Captación</legend>
				<ul>
					<li>
						<label>Nuevo Canal:</label>
						<input type="text" name="canal_captacion" required />
						<input type="submit" value="Añadir" />
					</li>
				</ul>
				<br><br>

				<fieldset style="width:90%;">
					<legend>Listado de Canales</legend>
					<table class="tabledata" id="tabla-canales">
						<tr>
							<th></th>
							<th>Canal</th>
							<th>Acción</th>
						</tr>
						<?php if (!empty($captacion)) : ?>
							<?php foreach ($captacion as $capta) : ?>
								<tr id="capta_<?= $capta['id'] ?>" class="sortable-row" data-id="<?= $capta['id'] ?>">
									<td class="drag-handle">☰</td>
									<td><?= $capta['nombre'] ?></td>
									<td>
										<a href="#" onclick="return deletecanal_captacion(<?= $capta['id'] ?>)">
											<img src="<?= base_url() ?>img/delete.gif" width="15" />
										</a>
									</td>
								</tr>
							<?php endforeach; ?>
						<?php else : ?>
							<tr>
								<td colspan="3">No hay canales de captación registrados.</td>
							</tr>
						<?php endif; ?>
					</table>
				</fieldset>
			</fieldset>
		</form>
	</div>

	<!--Momentos Especiales -->
	<div class="main form">
		<h2>Momentos Especiales</h2>
		<form method="post" name="momentos_form">
			<fieldset class="datos">
				<legend>Añadir Momento Especial</legend>
				<ul>
					<li>
						<label>Nuevo Momento:</label>
						<input type="text" name="momento_especial" required />
						<input type="submit" value="Añadir" />
					</li>
				</ul>
				<br><br>

				<fieldset style="width:90%;">
					<legend>Listado de Momentos</legend>
					<table class="tabledata" id="tabla-momentos">
						<tr>
							<th></th>
							<th>Momento Especial</th>
							<th>Acción</th>
						</tr>
						<?php if (!empty($momentos_especiales)) : ?>
							<?php foreach ($momentos_especiales as $momento) : ?>
								<tr id="momento_<?= $momento['id'] ?>" class="sortable-row" data-id="<?= $momento['id'] ?>">
									<td class="drag-handle">☰</td>
									<td><?= $momento['momento'] ?></td>
									<td>
										<a href="#" onclick="return deletemomento_especial(<?= $momento['id'] ?>)">
											<img src="<?= base_url() ?>img/delete.gif" width="15" />
										</a>
									</td>
								</tr>
							<?php endforeach; ?>
						<?php else : ?>
							<tr>
								<td colspan="3">No hay momentos especiales registrados.</td>
							</tr>
						<?php endif; ?>
					</table>
					<div id="result_bd_momento_espec"></div>
				</fieldset>
			</fieldset>
		</form>
	</div>


	<!-- Estados de Solicitudes -->
	<div class="main form">
		<h2>Estados de Solicitudes</h2>
		<form method="post" name="estados_form">
			<fieldset class="datos">
				<legend>Añadir Estado</legend>
				<ul>
					<li>
						<label>Nuevo Estado:</label>
						<input type="text" name="estado_solicitud" required />
						<input type="submit" value="Añadir" />
					</li>
				</ul>
				<br><br>

				<fieldset style="width:90%;">
					<legend>Listado de Estados</legend>
					<table class="tabledata" id="tabla-estados">
						<tr>
							<th></th>
							<th>Estado</th>
							<th>Acción</th>
						</tr>
						<?php if (!empty($estados_solicitudes)) : ?>
							<?php foreach ($estados_solicitudes as $estado) : ?>
								<tr id="estado_<?= $estado['id_estado'] ?>" class="sortable-row" data-id="<?= $estado['id_estado'] ?>">
									<td class="drag-handle">☰</td>
									<td><?= $estado['nombre_estado'] ?></td>
									<td>
										<?php if ($estado['id_estado'] > 6) : ?>
											<a href="#" onclick="return deleteestado_solicitud(<?= $estado['id_estado'] ?>)">
												<img src="<?= base_url() ?>img/delete.gif" width="15" />
											</a>
										<?php else : ?>
											<a href="#" onclick="alert('No puedes eliminar este estado')">
												<img src="<?= base_url() ?>img/delete.gif" width="15" />
											</a>
										<?php endif; ?>
									</td>
								</tr>
							<?php endforeach; ?>
						<?php else : ?>
							<tr>
								<td colspan="3">No hay estados de solicitud registrados.</td>
							</tr>
						<?php endif; ?>
					</table>
					<div id="result_estado_solicitud"></div>
				</fieldset>
			</fieldset>
		</form>
	</div>



	<!-- Tipos de Cliente -->
	<div class="main form">
		<h2>Tipos de Cliente</h2>
		<form method="post" name="tipos_cliente_form">
			<fieldset class="datos">
				<legend>Añadir Tipo de Cliente</legend>
				<ul>
					<li>
						<label>Nuevo Tipo de Cliente:</label><input type="text" name="tipo_cliente" required />
					</li>
					<li>
						<label>Color:</label><input type="text" id="color" name="color" style="width:50px;" required />
					</li>
					<li>
						<input type="submit" value="Añadir" />
					</li>
				</ul>
				<br><br>

				<fieldset style="width:90%;">
					<legend>Listado de Tipos de Cliente</legend>
					<table class="tabledata" id="tabla-tipos-cliente">
						<tr>
							<th></th>
							<th>Tipo de Cliente</th>
							<th>Color</th>
							<th>Acción</th>
						</tr>
						<?php if (!empty($tipos_clientes)) : ?>
							<?php foreach ($tipos_clientes as $tipo) : ?>
								<tr id="tipo_cliente_<?= $tipo['id_tipo_cliente'] ?>" class="sortable-row" data-id="<?= $tipo['id_tipo_cliente'] ?>">
									<td class="drag-handle">☰</td>
									<td><?= $tipo['tipo_cliente'] ?></td>
									<td><?= $tipo['color'] ?></td>
									<td>
										<?php if ($tipo['id_tipo_cliente'] > 1) : ?>
											<a href="#" onclick="return deletetipo_cliente(<?= $tipo['id_tipo_cliente'] ?>)">
												<img src="<?= base_url() ?>img/delete.gif" width="15" />
											</a>
										<?php else : ?>
											<a href="#" onclick="alert('No puedes eliminar este tipo de cliente')">
												<img src="<?= base_url() ?>img/delete.gif" width="15" />
											</a>
										<?php endif; ?>
									</td>
								</tr>
							<?php endforeach; ?>
						<?php else : ?>
							<tr>
								<td colspan="4">No hay tipos de cliente registrados.</td>
							</tr>
						<?php endif; ?>
					</table>
					<div id="result_tipo_cliente"></div>
				</fieldset>
			</fieldset>
		</form>
	</div>


</div>
<div class="clear">
</div>


<script>
	$(function() {
		$("#tabla-cuentas").sortable({
			items: ".sortable-row",
			handle: ".drag-handle",
			update: function(event, ui) {
				var order = [];
				$(".sortable-row").each(function(index, element) {
					order.push({
						id: $(element).data("id"),
						orden: index + 1
					});
				});
				// Envía el orden al servidor (AJAX opcional)
				$.ajax({
					url: "<?php echo site_url('admin/actualizar_orden_cuentas_bancarias'); ?>",
					method: "POST",
					data: {
						order: order
					}
				});
			}
		}).disableSelection();
	});


	$(function() {
		$("#tabla-canales").sortable({
			items: ".sortable-row",
			handle: ".drag-handle",
			update: function(event, ui) {
				var order = [];
				$(".sortable-row").each(function(index, element) {
					order.push({
						id: $(element).data("id"),
						orden: index + 1
					});
				});
				// Envía el orden al servidor (AJAX opcional)
				$.ajax({
					url: "<?php echo site_url('admin/actualizar_orden_cuentas_bancarias'); ?>",
					method: "POST",
					data: {
						order: order
					}
				});
			}
		}).disableSelection();
	});

	$(function() {
		$("#tabla-momentos").sortable({
			items: ".sortable-row",
			handle: ".drag-handle",
			update: function(event, ui) {
				var order = [];
				$(".sortable-row").each(function(index, element) {
					order.push({
						id: $(element).data("id"),
						orden: index + 1
					});
				});
				// Envía el orden al servidor (AJAX opcional)
				$.ajax({
					url: "<?php echo site_url('admin/actualizar_orden_cuentas_bancarias'); ?>",
					method: "POST",
					data: {
						order: order
					}
				});
			}
		}).disableSelection();
	});

	$(function() {
		$("#tabla-estados").sortable({
			items: ".sortable-row",
			handle: ".drag-handle",
			update: function(event, ui) {
				var order = [];
				$(".sortable-row").each(function(index, element) {
					order.push({
						id: $(element).data("id"),
						orden: index + 1
					});
				});
				// Envía el orden al servidor (AJAX opcional)
				$.ajax({
					url: "<?php echo site_url('admin/actualizar_orden_cuentas_bancarias'); ?>",
					method: "POST",
					data: {
						order: order
					}
				});
			}
		}).disableSelection();
	});

	$(function() {
		$("#tabla-tipos-cliente").sortable({
			items: ".sortable-row",
			handle: ".drag-handle",
			update: function(event, ui) {
				var order = [];
				$(".sortable-row").each(function(index, element) {
					order.push({
						id: $(element).data("id"),
						orden: index + 1
					});
				});
				// Envía el orden al servidor (AJAX opcional)
				$.ajax({
					url: "<?php echo site_url('admin/actualizar_orden_cuentas_bancarias'); ?>",
					method: "POST",
					data: {
						order: order
					}
				});
			}
		}).disableSelection();
	});

</script>


<style>
	.drag-handle {
		cursor: move;
	}

	.tabledata {
		width: 100%;
		border-collapse: collapse;
	}

	.tabledata th,
	.tabledata td {
		border: 1px solid #ccc;
		padding: 5px;
		text-align: center;
	}

	#total_cuentas_bancarias .sortable-item {
		cursor: move;
	}

	#total_canales_captacion .sortable-item {
		cursor: move;
	}

	#total_momentos_especiales .sortable-item {
		cursor: move;
	}

	#total_estados_solicitudes .sortable-item {
		cursor: move;
	}

	#total_tipos_clientes .sortable-item {
		cursor: move;
	}
</style>