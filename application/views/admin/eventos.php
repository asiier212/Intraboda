<script type="text/javascript" src="<?php echo base_url() ?>js/jquery/development-bundle/ui/jquery.jeditable.js"></script>
<script src="<?php echo base_url() ?>js/jquery/development-bundle/ui/jquery-ui-1.8.16.custom.min.js"></script>
<script src="<?php echo base_url() ?>js/jquery/development-bundle/ui/jquery-ui-timepicker-addon.js"></script>

<link rel="stylesheet" href="<?php echo base_url() ?>js/jquery/development-bundle/themes/base/jquery.ui.all.css">

<script>
	$(function() {
		$("#fecha_desde_descuento").datepicker();
		$("#fecha_hasta_descuento").datepicker();


		$('#anadir_evento').click(function() {
			if ($('#evento').val() == '') {
				alert("Debes añadir el nombre al evento");
				$('#evento').focus();
				return false;
			}
		});

		$('#anadir_descuento').click(function() {
			if ($('#nombre_descuento').val() == '') {
				alert("Debes añadir el nombre al descuento");
				$('#nombre_descuento').focus();
				return false;
			}
			if ($('#fecha_desde_descuento').val() == '') {
				alert("Debes indicar la fecha inicial del descuento");
				$('#fecha_desde_descuento').focus();
				return false;
			}
			if ($('#fecha_hasta_descuento').val() == '') {
				alert("Debes indicar la fecha final del descuento");
				$('#fecha_hasta_descuento').focus();
				return false;
			}
			if ($('#importe_descuento').val() == '') {
				alert("Debes indicar el importe del descuento");
				$('#importe_descuento').focus();
				return false;
			}

			var checkboxValues = false;
			$('input:checkbox:checked').each(function() {
				checkboxValues = true;
			});
			if (checkboxValues == false) {
				alert('Debes seleccionar al menos un servicio');
				return false;
			}
		});
	});
</script>


<script language="javascript">
	function deleteevento(id) {
		if (confirm("\u00BFSeguro que desea borrar el evento?")) {
			$("#result").html("Actualizando...");
			$.ajax({
				type: 'POST',
				url: '<?php echo base_url() ?>index.php/ajax/deleteevento',
				data: 'id=' + id,
				success: function(data) {
					$("#ev_" + id).css("display", "none");
					$("#result").html("");
				}
			});
		}
		return false
	}

	function deletedescuento(id) {
		if (confirm("\u00BFSeguro que desea borrar el descuento?")) {
			$("#result_bd_momento_espec").html("Actualizando...");
			$.ajax({
				type: 'POST',
				url: '<?php echo base_url() ?>index.php/ajax/deletedescuento',
				data: 'id=' + id,
				success: function(data) {
					location.href = '<?php echo base_url() ?>admin/eventos';
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
	Eventos
</h2>

<div class="main form">


	<form method="post" name="eventos">
		<fieldset class="datos">
			<legend>Eventos</legend>
			(*)Nuevo evento: <input type="text" name="evento" id="evento" /><input type="submit" id="anadir_evento" value="A&#241;adir" style="width:50px" />
			<br class="clear" /><br class="clear" />
			<ul>
				<div id="total_eventos">
					<?php
					if ($eventos[0] <> "") {
						foreach ($eventos as $ev) {
					?>
							<li id="ev_<?php echo $ev['id_evento'] ?>"><?php echo $ev['nombre_evento'] ?>
								<a href="#" onclick="return deleteevento(<?php echo $ev['id_evento'] ?>)"><img src="<?php echo base_url() ?>img/delete.gif" width="15" /></a>
							</li>
					<?php
						}
					}
					?>
				</div>
			</ul>
			<div id="result"></div>

			<br class="clear" />
		</fieldset>
		<p style="text-align:center"></p>
	</form>

	<form method="post" name="descuento">
		<fieldset class="datos">
			<legend>A&ntilde;adir Descuento</legend>

			<div style="float:left">
				<fieldset>
					<legend>Descuento</legend>
					<ul>
						<li><label style="width:100px">(*)Nombre:</label>
							<input type="text" name="nombre_descuento" id="nombre_descuento" />
						</li>
						<li><label style="width:100px">(*)Desde:</label>
							<input type="text" name="fecha_desde_descuento" id="fecha_desde_descuento" />
						</li>
						<li><label style="width:100px">(*)Hasta:</label>
							<input type="text" name="fecha_hasta_descuento" id="fecha_hasta_descuento" />
						</li>
						<li><label style="width:100px">(*)Descuento:</label>
							<input type="text" name="importe_descuento" id="importe_descuento" style="width:50px;" /> &#8364;
						</li>
					</ul>
					<br><br>
					<input type="submit" style="width:100px; margin-left:10px; margin-left:150px;" name="anadir_descuento" id="anadir_descuento" value="A&ntilde;adir" />
				</fieldset>
			</div>

			<div style="float:left">
				<fieldset>
					<legend>Servicios</legend>
					<ul>
						<?php
						foreach ($servicios as $servicio) { ?>
							<li><input type="checkbox" name="servicios[<?php echo $servicio['id'] ?>]" id="chserv_<?php echo $servicio['id'] ?>" value="<?php echo $servicio['id'] ?>" style="width:30px; vertical-align:middle" /><?php echo $servicio['nombre']; ?></li>
						<?php } ?>
					</ul>
				</fieldset>
		</fieldset>

		<fieldset class="datos">
			<legend>Listado Descuentos</legend>

			<?php
			if ($descuentos[0] <> "") {
				foreach ($descuentos as $d) { ?>
					<fieldset>
						<legend><?php echo $d['nombre'] ?> <a href="#" onclick="return deletedescuento(<?php echo $d['id_descuento'] ?>)"><img src="<?php echo base_url() ?>img/cancel.gif" width="15" /></a> </legend>
						<?php
						if ($servicios != false) {
						?>
							<ul>

								<li><strong>Desde: <?php echo $d['fecha_desde'] ?></strong></li>
								<li><strong>Hasta: <?php echo $d['fecha_hasta'] ?></strong></li>
							</ul>

							<br>

							<ul>
								<?php
								$arr_servicios = explode(",", $d['servicios']);

								foreach ($servicios as $serv) {
									if (in_array($serv['id'], $arr_servicios)) {
								?>
										<li>- <?php echo $serv['nombre'] ?></li><?php
																			} ?>

							</ul><?php
								}
							} ?>
					<br>
					<ul>
						<li>Importe: <strong><?php echo $d['importe'] ?> &#8364;</strong></li>
					</ul>
					</fieldset>
			<?php
				}
			} ?>
		</fieldset>
		<p style="text-align:center"></p>
	</form>


</div>
<div class="clear">
</div>