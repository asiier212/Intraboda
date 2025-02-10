<link rel="stylesheet" href="<?php echo base_url() ?>js/jquery1.10.4/themes/smoothness/jquery-ui.css">
<script src="<?php echo base_url() ?>js/jquery1.10.4/js/jquery-1.10.2.js"></script>
<script src="<?php echo base_url() ?>js/jquery1.10.4/js/jquery-ui-1.10.4.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery1.10.4/js/jquery.jeditable.js"></script>

<script>
	$.datepicker.regional['es'] = {
		closeText: 'Cerrar',
		prevText: '<Ant',
		nextText: 'Sig>',
		currentText: 'Hoy',
		monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
		monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
		dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
		dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mié', 'Juv', 'Vie', 'Sáb'],
		dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sá'],
		weekHeader: 'Sm',
		//dateFormat: 'dd/mm/yy',
		dateFormat: 'yy-mm-dd',
		firstDay: 1,
		isRTL: false,
		showMonthAfterYear: false,
		yearSuffix: ''
	};
	$.datepicker.setDefaults($.datepicker.regional['es']);


	$(function() {
		$("#calendar_desde").datepicker();
		$("#calendar_hasta").datepicker();

		$('.edit_box_artista').editable('<?php echo base_url() ?>index.php/ajax/updatebdartista', {
			type: 'textarea',
			width: '100%',
			height: '60px',
			submit: '<img src="<?php echo base_url() ?>img/save.gif" />',
			tooltip: 'Click para editar...'
		});
		$('.edit_box_cancion').editable('<?php echo base_url() ?>index.php/ajax/updatebdcancion', {
			type: 'textarea',
			width: '100%',
			height: '60px',
			submit: '<img src="<?php echo base_url() ?>img/save.gif" />',
			tooltip: 'Click para editar...'
		});
	});
</script>

<script language="javascript">
	$(function() {
		$("#cvalidada").click(function() {
			if ($("#cvalidada").is(':checked')) {
				$("#validada").val("S");
			} else {
				$("#validada").val("N");
			}
		});
	});

	function validarcancion(id) {
		if (confirm("\u00BFSeguro que desea validar la canci\u00f3n?")) {
			//$("#result").html("Actualizando...");
			$.ajax({
				type: 'POST',
				url: '<?php echo base_url() ?>index.php/ajax/validarbdcancion',
				data: 'id=' + id,
				dataType: 'json',
				success: function(data) {
					//$("#can_" + id).css("display", "none");
					//$("#result").html("");
					//location.reload();
					location.href = '<?php echo base_url() ?>admin/mantenimiento_bd_canciones';
				}
			});
		}
		return false
	}

	function deletebdcancion(id) {
		if (confirm("\u00BFSeguro que desea borrar la canci\u00f3n?")) {
			//$("#result").html("Actualizando...");
			$.ajax({
				type: 'POST',
				url: '<?php echo base_url() ?>index.php/ajax/deletebdcancion',
				data: 'id=' + id,
				success: function(data) {
					//$("#can_" + id).css("display", "none");
					//$("#result").html("");
					location.reload();
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
	Base de Datos de Canciones
</h2>
<div class="main form">


	<form method="post">
		<fieldset class="datos">
			<legend>Canciones</legend>
			<ul>
				<li><label>Desde:</label><input type="text" name="fecha_desde" id="calendar_desde" value="<?php echo $fecha_desde ?>" /></li>
				<li><label>Hasta:</label><input type="text" name="fecha_hasta" id="calendar_hasta" value="<?php echo $fecha_hasta ?>" /></li>
				<li><label>Validada:</label>
					<?php
					if ($validada == "N") {
					?><input type="checkbox" name="cvalidada" id="cvalidada" /><?php
																			} else {
																				?><input type="checkbox" name="cvalidada" id="cvalidada" checked /><?php
																					}
																						?>
					<input type="hidden" name="validada" id="validada" value="<?php echo $validada ?>" />
				</li>
				<li><input type="submit" value="Filtrar" /></li>
			</ul>

			<br><br>

			<div id="canciones" style="display:flex; justify-content:center">
				<table style="width:75%; text-align:center" border="1">
					<tr>
						<td style="width:20%"><b>ARTISTA</b></td>
						<td style="width:29%"><b>CANCION</b></td>
						<td style="width:10%"><b>FECHA ALTA</b></td>
						<td style="width:25%"><b>ALTA POR</b></td>
						<td style="width:8%"><b>VALIDADA</b></td>
						<td style="width:8%"><b>BORRAR</b></td>
					</tr>
					<?php
					if ($bd_canciones[0]['id'] <> "") //COMPRUEBO QUE EL RESULTADO NO SEA VACIO PARA QUE NO ME DE ERROR FOREACH
					{

						foreach ($bd_canciones as $cancion) {
					?>
							<tr>
								<td>
									<li style="list-style: none;" id="can_<?php echo $cancion['id'] ?>"><span style="font-size:16px" class="edit_box_artista" id="<?php echo $cancion['id'] ?>"><?php echo $cancion['artista'] ?></span></li>
								</td>

								<td>
									<li style="list-style: none;" id="can_<?php echo $cancion['id'] ?>"><span style="font-size:16px" class="edit_box_cancion" id="<?php echo $cancion['id'] ?>"><?php echo $cancion['cancion'] ?></span></li>
								</td>
								<td><?php echo $cancion['fecha_alta'] ?></td>
								<td><?php echo $cancion['nombre_novio'] ?> <?php echo $cancion['apellidos_novio'] ?> y <?php echo $cancion['nombre_novia'] ?> <?php echo $cancion['apellidos_novia'] ?></td>
								<td>
									<?php
									if ($cancion['validada'] == 'N') {
									?><a href="#" onclick="return validarcancion(<?php echo $cancion['id'] ?>)"><img src="<?php echo base_url() ?>img/interrogacion.gif" width="15" /></a><?php
																																												} else {
																																													?><img src="<?php echo base_url() ?>img/ok.gif" width="15" /><?php
																																												}
																							?></td>
								<td><a href="#" onclick="return deletebdcancion(<?php echo $cancion['id'] ?>)"><img src="<?php echo base_url() ?>img/cancel.gif" width="15" /></a></td>
							</tr>
					<?php
						}
					}
					?>
				</table>
			</div>

			<div id="result"></div>

			<br class="clear" />
		</fieldset>
		<p style="text-align:center"></p>
	</form>

</div>
<div class="clear">
</div>