<?php
// Encabezados y scripts
mb_internal_encoding('UTF-8');
?>
<link rel="stylesheet" href="<?php echo base_url() ?>js/jquery1.10.4/themes/smoothness/jquery-ui.css">
<script src="<?php echo base_url() ?>js/jquery1.10.4/js/jquery-1.10.2.js"></script>
<script src="<?php echo base_url() ?>js/jquery1.10.4/js/jquery-ui-1.10.4.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery1.10.4/js/jquery.jeditable.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/tooltip.js"></script>

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
	});
</script>

<style>
	.editable img {
		float: right
	}

	.oculto {
		display: none;
	}

	.columna-toggle {
		cursor: pointer;
		color: #007bff;
		text-decoration: underline;
	}

	.iniciales {
		font-weight: bold;
	}
</style>

<h2>Eventos</h2>
<div class="main form">
	<form method="post">
		<fieldset class="datos">
			<legend>Eventos</legend>
			<ul>
				<li><label>Desde:</label><input type="text" name="fecha_desde" id="calendar_desde" value="<?php echo $fecha_desde ?>" /></li>
				<li><label>Hasta:</label><input type="text" name="fecha_hasta" id="calendar_hasta" value="<?php echo $fecha_hasta ?>" /></li>
				<li><label>Oficina:</label>
					<select name="oficina" id="oficina">
						<option value="todos">Todos</option>
						<?php foreach ($oficinas as $ofi) { ?>
							<option value="<?php echo $ofi['id_oficina'] ?>"><?php echo ($ofi['nombre']) ?></option>
						<?php } ?>
					</select>
				<li><input type="submit" value="Filtrar" /></li>
			</ul>

			<br><br>

			<p>

			<fieldset>
				<legend>Eventos Contratados entre <?php echo $fecha_desde ?> y <?php echo $fecha_hasta ?></legend>
				<table class="tabledata">
					<tr>
						<th colspan="2">TOTAL EVENTOS</th>
					</tr>
					<tr>
						<?php if ($oficina != 'todos' || $oficina = null) { ?>
							<?php foreach ($oficinas as $ofi) {
								if ($ofi['id_oficina'] == $oficina) { ?>
									<th><?php echo ($ofi['nombre']) ?></th>
							<?php }
							}
						} else { ?>
							<th>Todos</th>
						<?php } ?>
						<th>Exel Eventos</th>
					</tr>
					<tr>
						<?php if ($eventos_totales[0] != "") {
							foreach ($eventos_totales as $ev) { ?>
								<td align="center"><?php echo $ev['eventos'] ?></td>
								<td align="center"><?php echo $ev['eventos_totales'] ?></td>
						<?php }
						} ?>
					</tr>
				</table>

				<br><br>

				<table class="tabledata">
					<tr>
						<th>Fecha</th>
						<th>DJ</th>
						<th style="vertical-align: middle;">
							<span id="textoNombre" style="margin-right: 5px;">Nombre</span>
							<span id="toggleNombre" class="columna-toggle" style="cursor:pointer; display:inline-block; vertical-align: middle;">
								<img src="<?php echo base_url() ?>/img/ojoc.png" style="width:20px; vertical-align: middle;" />
							</span>
						</th>
						<th>Lugar</th>
						<th>Localidad</th>
						<th>Horario</th>
						<th>Servicios</th>
						<th>S. Adicionales</th>
						<th>Acceso</th>
					</tr>
					<?php
					if ($eventos_view[0] != "") {
						foreach ($eventos_view as $ev) {
							foreach ($tipos_clientes as $tipo) {
								if ($tipo['id_tipo_cliente'] == $ev['id_tipo_cliente']) {
									$color = $tipo['color'];
								}
							}
							$serv = "";
							$tooltip = "";
							$serv_ad = "";
							$tooltip_ad = "";
							$arr_servicios = unserialize($ev['servicios']);
							$arr_serv_keys = array_keys($arr_servicios);
							foreach ($servicios as $servicio) {
								if (in_array($servicio['id'], $arr_serv_keys)) {
									$nombre = $servicio['nombre'];
									$short = mb_substr($nombre, 0, 4, 'UTF-8');
									$tooltipText = "- " . str_replace("'", "", str_replace("&#39;", "", $nombre));
									if ($servicio['servicio_adicional'] == 'N') {
										$serv .= ($serv != "" ? "-" : "") . $short;
										$tooltip .= ($tooltip != "" ? "<br>" : "") . $tooltipText;
									} else {
										$serv_ad .= ($serv_ad != "" ? "-" : "") . $short;
										$tooltip_ad .= ($tooltip_ad != "" ? "<br>" : "") . $tooltipText;
									}
								}
							}
					?>
							<tr>
								<td style="background-color:<?php echo $color ?>"><?php echo $ev['fecha_boda'] ?></td>

								<td style="background-color:<?php echo $color ?>">
									<?php foreach ($djs as $dj) {
										if ($dj['id'] == $ev['dj']) {
											echo ($dj['nombre']);
										}
									} ?>
								</td>

								<td class="col-nombre" style="background-color:<?php echo $color ?>">
									<?php echo ($ev['nombre_novio']) ?> y <?php echo ($ev['nombre_novia']) ?>
								</td>
								<td class="col-iniciales oculto" style="background-color:<?php echo $color ?>" title="<?php echo ($ev['nombre_novio']) . ' y ' . $ev['nombre_novia'] ?>">
									<?php echo strtoupper(mb_substr($ev['nombre_novio'], 0, 1)) . "&" . strtoupper(mb_substr($ev['nombre_novia'], 0, 1)) ?>
								</td>

								<td style="background-color:<?php echo $color ?>"><?php echo ($ev['restaurante']) ?></td>
								<td style="background-color:<?php echo $color ?>"><?php echo ($ev['direccion_restaurante']) ?></td>
								<td style="background-color:<?php echo $color ?>"><?php echo $ev['hora_boda'] ?></td>
								<td style="background-color:<?php echo $color ?>" onMouseOver="Tip('<?php echo htmlspecialchars($tooltip, ENT_QUOTES, 'UTF-8') ?>')" onMouseOut="UnTip()"><?php echo $serv ?></td>
								<td style="background-color:<?php echo $color ?>" onMouseOver="Tip('<?php echo htmlspecialchars($tooltip_ad, ENT_QUOTES, 'UTF-8') ?>')" onMouseOut="UnTip()"><?php echo $serv_ad ?></td>
								<td style="background-color:<?php echo $color ?>">
									<a href="<?php echo base_url() ?>admin/clientes/view/<?php echo $ev['id'] ?>" target="_blank">Ver ficha</a>
								</td>
							</tr>
					<?php }
					} ?>
				</table>
			</fieldset>
			</p>

			<br class="clear" />
		</fieldset>
		<p style="text-align:center"></p>
	</form>
</div>
<div class="clear"></div>

<script>
	$(document).ready(function() {
		let oculto = false;
		$('#toggleNombre').click(function() {
			$('.col-nombre').toggleClass('oculto');
			$('.col-iniciales').toggleClass('oculto');
			oculto = !oculto;
			$('#textoNombre').text(oculto ? 'Nom.' : 'Nombre');

			// Cambia imagen según el estado
			const img = $(this).find('img');
			img.attr('src', oculto ? '<?php echo base_url() ?>/img/ojo.png' : '<?php echo base_url() ?>/img/ojoc.png');
		});
	});
</script>