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


	<form method="post" name="canal">
		<fieldset class="datos">
			<legend>Cuentas Bancarias</legend>
			Nueva Entidad: <input type="text" name="entidad" required /><br><br>
			Cuenta Bancaria:
			<input type="text" name="iban" style="width:50px;" maxlength="4" required />
			<input type="text" name="codigo_entidad" style="width:50px;" maxlength="4" required />
			<input type="text" name="codigo_oficina" style="width:50px;" maxlength="4" required />
			<input type="text" name="codigo_control" style="width:25px;" maxlength="2" required />
			<input type="text" name="numero_cuenta" style="width:150px;" maxlength="10" required />
			<input type="submit" value="Añadir" style="width:50px" />
			<br class="clear" /><br class="clear" />
			<ul id="total_cuentas_bancarias">
				<?php if (!empty($cuentas_bancarias)) : ?>
					<?php foreach ($cuentas_bancarias as $cuenta) : ?>
						<li id="cuenta_<?php echo $cuenta['id_cuenta'] ?>" class="sortable-item">
							<?php echo $cuenta['orden'] . ". " . $cuenta['entidad'] . " - " . $cuenta['iban'] . " " . $cuenta['codigo_entidad'] . " " . $cuenta['codigo_oficina'] . " " . $cuenta['codigo_control'] . " " . $cuenta['numero_cuenta']; ?>
							<a href="#" onclick="return deletecuenta_bancaria(<?php echo $cuenta['id_cuenta'] ?>)">
								<img src="<?php echo base_url() ?>img/delete.gif" width="15" />
							</a>
						</li>
					<?php endforeach; ?>
				<?php else : ?>
					<li>No hay cuentas bancarias registradas.</li>
				<?php endif; ?>
			</ul>
		</fieldset>
		<p style="text-align:center"></p>
	</form>



	<form method="post" name="canal">
		<fieldset class="datos">
			<legend>Canales de captaci&oacute;n</legend>
			Nuevo canal de captaci&oacute;n:
			<input type="text" name="canal_captacion" required />
			<input type="submit" value="A&ntilde;adir" style="width:50px" />
			<br class="clear" /><br class="clear" />
			<ul id="total_canales_captacion">
				<?php if (!empty($captacion)) : ?>
					<?php foreach ($captacion as $capta) : ?>
						<li id="capta_<?php echo $capta['id'] ?>" class="sortable-item">
							<?php echo $capta['nombre']; ?>
							<a href="#" onclick="return deletecanal_captacion(<?php echo $capta['id'] ?>)">
								<img src="<?php echo base_url() ?>img/delete.gif" width="15" />
							</a>
						</li>
					<?php endforeach; ?>
				<?php else : ?>
					<li>No hay canales de captación registrados.</li>
				<?php endif; ?>
			</ul>
			<div id="result"></div>
			<br class="clear" />
		</fieldset>
		<p style="text-align:center"></p>
	</form>

	<!-- Momentos Especiales -->
	<form method="post">
		<fieldset class="datos">
			<legend>Momentos Especiales</legend>
			Nuevo momento especial:<input type="text" name="momento_especial" required /><input type="submit" value="Añadir" style="width:50px;" />
			<br class="clear" /><br class="clear" />
			<ul id="total_momentos_especiales">
				<?php if (!empty($momentos_especiales)) : ?>
					<?php foreach ($momentos_especiales as $momento) : ?>
						<li id="momento_<?php echo $momento['id'] ?>" class="sortable-item">
							<?php echo $momento['momento']; ?>
							<a href="#" onclick="return deletemomento_especial(<?php echo $momento['id'] ?>)">
								<img src="<?php echo base_url() ?>img/delete.gif" width="15" />
							</a>
						</li>
					<?php endforeach; ?>
				<?php else : ?>
					<li>No hay momentos especiales registrados.</li>
				<?php endif; ?>
			</ul>
			<div id="result_bd_momento_espec"></div>
			<br class="clear" />
		</fieldset>
	</form>

	<!-- Estados de Solicitudes -->
	<form method="post">
		<fieldset class="datos">
			<legend>Estados de Solicitudes</legend>
			Nuevo estado:<input type="text" name="estado_solicitud" required /><input type="submit" value="Añadir" style="width:50px;" />
			<br class="clear" /><br class="clear" />
			<ul id="total_estados_solicitudes">
				<?php if (!empty($estados_solicitudes)) : ?>
					<?php foreach ($estados_solicitudes as $estado) : ?>
						<li id="estado_<?php echo $estado['id_estado'] ?>" class="sortable-item">
							<?php echo $estado['nombre_estado']; ?>
							<?php if ($estado['id_estado'] > 6) : // Impedir borrar los 6 primeros estados 
							?>
								<a href="#" onclick="return deleteestado_solicitud(<?php echo $estado['id_estado'] ?>)">
									<img src="<?php echo base_url() ?>img/delete.gif" width="15" />
								</a>
							<?php else : ?>
								<a href="#" onclick="alert('No puedes eliminar este estado')">
									<img src="<?php echo base_url() ?>img/delete.gif" width="15" />
								</a>
							<?php endif; ?>
						</li>
					<?php endforeach; ?>
				<?php else : ?>
					<li>No hay estados de solicitud registrados.</li>
				<?php endif; ?>
			</ul>
			<div id="result_estado_solicitud"></div>
			<br class="clear" />
		</fieldset>
	</form>


	<!-- Tipos de Cliente -->
	<form method="post">
		<fieldset class="datos">
			<legend>Tipos de Cliente</legend>
			Nuevo tipo de cliente: <input type="text" name="tipo_cliente" required /><br><br>
			Color: <input type="text" id="color" name="color" style="width:100px;" required /><br>
			<input type="submit" value="A&#241;adir" style="width:50px" />
			<br class="clear" /><br class="clear" />
			<ul id="total_tipos_clientes">
				<?php if (!empty($tipos_clientes)) : ?>
					<?php foreach ($tipos_clientes as $tipo) : ?>
						<li id="tipo_cliente_<?php echo $tipo['id_tipo_cliente'] ?>" class="sortable-item">
							<?php echo $tipo['tipo_cliente']; ?>
							<?php if ($tipo['id_tipo_cliente'] > 1) : // Impedir borrar el cliente estándar 
							?>
								<a href="#" onclick="return deletetipo_cliente(<?php echo $tipo['id_tipo_cliente'] ?>)">
									<img src="<?php echo base_url() ?>img/delete.gif" width="15" />
								</a>
							<?php else : ?>
								<a href="#" onclick="alert('No puedes eliminar este tipo de cliente')">
									<img src="<?php echo base_url() ?>img/delete.gif" width="15" />
								</a>
							<?php endif; ?>
						</li>
					<?php endforeach; ?>
				<?php else : ?>
					<li>No hay tipos de cliente registrados.</li>
				<?php endif; ?>
			</ul>
			<div id="result_tipo_cliente"></div>
			<br class="clear" />
		</fieldset>
	</form>


</div>
<div class="clear">
</div>


<script>
	$(function() {
		// Hacer que la lista sea arrastrable
		$("#total_cuentas_bancarias").sortable({
			cursor: "move", // Cambiar el cursor al estilo "mover"
			update: function(event, ui) {
				// Obtener el nuevo orden de los elementos
				var order = [];
				$("#total_cuentas_bancarias .sortable-item").each(function(index, element) {
					order.push({
						id: $(element).attr("id").replace("cuenta_", ""),
						orden: index + 1
					});
				});

				// Enviar el nuevo orden al servidor
				$.ajax({
					url: "http://localhost/intraboda/admin/actualizar_orden_cuentas",
					method: "POST",
					data: {
						order: order
					}
				});
			}
		}).disableSelection(); // Desactivar la selección de texto al arrastrar
	});

	$(function() {
		// Hacer que la lista sea arrastrable
		$("#total_canales_captacion").sortable({
			cursor: "move", // Cambiar el cursor al estilo "mover"
			update: function(event, ui) {
				// Obtener el nuevo orden de los elementos
				var order = [];
				$("#total_canales_captacion .sortable-item").each(function(index, element) {
					order.push({
						id: $(element).attr("id").replace("capta_", ""),
						orden: index + 1
					});
				});

				// Enviar el nuevo orden al servidor
				$.ajax({
					url: "http://localhost/intraboda/admin/actualizar_orden_canales",
					method: "POST",
					data: {
						order: order
					}
				});
			}
		}).disableSelection(); // Desactivar la selección de texto al arrastrar
	});

	$(function() {
		// Hacer que la lista sea arrastrable
		$("#total_momentos_especiales").sortable({
			cursor: "move", // Cambiar el cursor al estilo "mover"
			update: function(event, ui) {
				// Obtener el nuevo orden de los elementos
				var order = [];
				$("#total_momentos_especiales .sortable-item").each(function(index, element) {
					order.push({
						id: $(element).attr("id").replace("momento_", ""),
						orden: index + 1
					});
				});

				// Enviar el nuevo orden al servidor
				$.ajax({
					url: "http://localhost/intraboda/admin/actualizar_orden_momentos",
					method: "POST",
					data: {
						order: order
					}
				});
			}
		}).disableSelection(); // Desactivar la selección de texto al arrastrar
	});

	$(function() {
		// Hacer que la lista sea arrastrable
		$("#total_estados_solicitudes").sortable({
			cursor: "move", // Cambiar el cursor al estilo "mover"
			update: function(event, ui) {
				// Obtener el nuevo orden de los elementos
				var order = [];
				$("#total_estados_solicitudes .sortable-item").each(function(index, element) {
					order.push({
						id: $(element).attr("id").replace("estado_", ""),
						orden: index + 1
					});
				});

				// Enviar el nuevo orden al servidor
				$.ajax({
					url: "http://localhost/intraboda/admin/actualizar_orden_estados",
					method: "POST",
					data: {
						order: order
					}
				});
			}
		}).disableSelection(); // Desactivar la selección de texto al arrastrar
	});

	$(function () {
        // Hacer que la lista sea arrastrable
        $("#total_tipos_clientes").sortable({
            cursor: "move", // Cambiar el cursor al estilo "mover"
            update: function (event, ui) {
                // Obtener el nuevo orden de los elementos
                var order = [];
                $("#total_tipos_clientes .sortable-item").each(function (index, element) {
                    order.push({
                        id: $(element).attr("id").replace("tipo_cliente_", ""),
                        orden: index + 1
                    });
                });

                // Enviar el nuevo orden al servidor
				$.ajax({
					url: "http://localhost/intraboda/admin/actualizar_orden_tipos_clientes",
					method: "POST",
					data: {
						order: order
					}
				});
            }
        }).disableSelection(); // Desactivar la selección de texto al arrastrar
    });
</script>


<style>
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