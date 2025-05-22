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

				<?php
				// Agrupamos los eventos por fecha
				$eventos_por_fecha = [];
				foreach ($eventos_view as $evento) {
					$eventos_por_fecha[$evento['fecha_boda']][] = $evento;
				}
				?>

				<table class="tabledata">
					<tr>
						<th>Fecha</th>
						<th style="vertical-align: middle;">
							<span id="textoDJ" style="margin-right: 5px;">DJ</span>
							<span id="toggleDJ" class="columna-toggle" style="cursor:pointer; display:inline-block; vertical-align: middle;">
								<img src="<?php echo base_url() ?>/img/ojoc.png" style="width:20px;" />
							</span>
						</th>
						<th style="vertical-align: middle;">
							<span id="textoDJND" style="margin-right: 5px;">DJ-ND</span>
							<span id="toggleDJND" class="columna-toggle" style="cursor:pointer; display:inline-block; vertical-align: middle;">
								<img src="<?php echo base_url() ?>/img/ojoc.png" style="width:20px;" />
							</span>
						</th>
						<th style="vertical-align: middle;">
							<span id="textoNombre" style="margin-right: 5px;">Nombre</span>
							<span id="toggleNombre" class="columna-toggle" style="cursor:pointer; display:inline-block; vertical-align: middle;">
								<img src="<?php echo base_url() ?>/img/ojoc.png" style="width:20px; vertical-align: middle;" />
							</span>
						</th>
						<th style="vertical-align: middle;">
							<span id="textoLugar" style="margin-right: 5px;">Lugar</span>
							<span id="toggleLugar" class="columna-toggle" style="cursor:pointer; display:inline-block; vertical-align: middle;">
								<img src="<?php echo base_url() ?>/img/ojoc.png" style="width:20px;" />
							</span>
						</th>
						<th>Localidad</th>
						<th>Horario</th>
						<th>Servicios</th>
						<th>S. Adicionales</th>
						<th>Acceso</th>
					</tr>

					<?php
					// Recorremos cada grupo de eventos por fecha
					foreach ($eventos_por_fecha as $fecha => $eventos_del_dia) {
						$primero = true;
						$rowspan = count($eventos_del_dia); // El número de eventos en esta fecha

						// Recorremos los eventos de una misma fecha
						foreach ($eventos_del_dia as $ev) {
							// Solo en la primera fila de cada fecha mostramos la fecha con rowspan
							echo "<tr>";

							if ($primero) {
								echo '<td rowspan="' . $rowspan . '" style="background-color:' . $color . '">' . $fecha . '</td>';
								$primero = false;
							}

							// DJ completo
							$dj_nombre = '';
							$dj_bool = '';

							// Buscamos DJ asignado
							foreach ($djs as $dj) {
								if ($dj['id'] == $ev['dj']) {
									$dj_nombre = $dj['nombre'];
								}
							}

							// Si no hay DJ asignado, mostramos preasignados
							if (!$dj_nombre) {
								$contador_pre = 0;
								foreach ($djs_pre as $djp) {
									if ($djp['id_cliente'] == $ev['id']) {
										$dj_nombre .= $djp['nombre'] . "\n";
										$contador_pre++;
									}
								}
								$dj_bool = 'djs';

								if ($contador_pre == 0) {
									$dj_nombre = ''; // No hay DJs preasignados
								}
							}

							echo "<td class='col-dj oculto' style='background-color:" . $color . "'>" . $dj_nombre . "</td>";

							// DJ iniciales

							if ($dj_nombre != '' && $dj_bool == '') {
								echo "<td class='col-dj-iniciales' style='background-color:" . $color . "' title='" . $dj_nombre . "'>";
								$partes = explode(' ', trim($dj_nombre));
								echo strtoupper(mb_substr($partes[0], 0, 1)) . "." . (isset($partes[1]) ? strtoupper(mb_substr($partes[1], 0, 1)) : '');
							} else if ($dj_nombre != '' && $dj_bool == 'djs') {
								// Mostrar número de DJs preasignados
								echo "<td class='col-dj-iniciales' style='background-color:rgba(234, 255, 0, 0.33);' title='" . $dj_nombre . "'>";
								echo $contador_pre . " DJs preasignados";
							} else if ($dj_nombre == '') {
								echo "<td class='col-dj-iniciales' style='background-color:rgba(255, 0, 0, 0.28);' title='" . $dj_nombre . "'>";
								echo '-';
							}
							echo "</td>";

							//DJ-ND

							echo "<td class='col-djnd oculto' style='background-color:" . $color . "'>";
							if (!empty($ev['djs_disponibles_nombres'])) {
								$nombres = array();
								foreach ($ev['djs_disponibles_nombres'] as $dj) {
									$nombres[] = $dj['nombre'];
								}
								echo implode(', ', $nombres);
							} else {
								echo 'Sin DJs No Disponibles';
							}
							echo '</td>';

							echo "<td class='col-djnd-iniciales' style='background-color:#d7f7dc;' title='DJs disponibles'>";
							echo $ev['djs_disponibles'];
							echo "</td>";
							// DJ-ND FINAL 

							echo "<td class='col-nombre oculto' style='background-color:" . $color . "'>";
							echo $ev['nombre_novio'] . " y " . $ev['nombre_novia'];
							echo "</td>";

							echo "<td class='col-iniciales' style='background-color:" . $color . "' title='" . $ev['nombre_novio'] . ' y ' . $ev['nombre_novia'] . "'>";
							echo strtoupper(mb_substr($ev['nombre_novio'], 0, 1)) . "&" . strtoupper(mb_substr($ev['nombre_novia'], 0, 1));
							echo "</td>";

							echo "<td class='col-lugar oculto' style='background-color:" . $color . "'>" . $ev['restaurante'] . "</td>";

							echo "<td class='col-lugar-iniciales' style='background-color:" . $color . "' title='" . $ev['restaurante'] . "'>";
							$partes = explode(' ', $ev['restaurante']);
							echo strtoupper(mb_substr($partes[0], 0, 1)) . "." . (isset($partes[1]) ? strtoupper(mb_substr($partes[1], 0, 1)) : '');
							echo "</td>";

							echo "<td style='background-color:" . $color . "'>" . $ev['direccion_restaurante'] . "</td>";
							echo "<td style='background-color:" . $color . "'>" . $ev['hora_boda'] . "</td>";
							echo "<td style='background-color:" . $color . "' onMouseOver=\"Tip('" . htmlspecialchars($tooltip, ENT_QUOTES, 'UTF-8') . "')\" onMouseOut=\"UnTip()\">" . $serv . "</td>";
							echo "<td style='background-color:" . $color . "' onMouseOver=\"Tip('" . htmlspecialchars($tooltip_ad, ENT_QUOTES, 'UTF-8') . "')\" onMouseOut=\"UnTip()\">" . $serv_ad . "</td>";
							echo "<td style='background-color:" . $color . "'><a href='" . base_url() . "admin/clientes/view/" . $ev['id'] . "' target='_blank'>Ver ficha</a></td>";

							echo "</tr>";
						}
						echo "<tr>";
						echo "<td colspan='11' style='background-color: #93CE37;'></td>";
						echo "</tr>";
					}
					?>
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
		let oculto = true;
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

	$(document).ready(function() {
		let ocultoDJ = true;
		let ocultoLugar = true;
		let ocultoDJND = true;

		$('#toggleDJ').click(function() {
			$('.col-dj').toggleClass('oculto');
			$('.col-dj-iniciales').toggleClass('oculto');
			ocultoDJ = !ocultoDJ;
			$('#textoDJ').text(ocultoDJ ? 'DJ' : 'DJ');
			$(this).find('img').attr('src', ocultoDJ ? '<?php echo base_url() ?>/img/ojo.png' : '<?php echo base_url() ?>/img/ojoc.png');
		});

		$('#toggleDJND').click(function() {
			$('.col-djnd').toggleClass('oculto');
			$('.col-djnd-iniciales').toggleClass('oculto');
			ocultoDJND = !ocultoDJND;
			$('#textoDJND').text(ocultoDJND ? 'DJ-ND' : 'DJ-ND');
			$(this).find('img').attr('src', ocultoDJND ? '<?php echo base_url() ?>/img/ojo.png' : '<?php echo base_url() ?>/img/ojoc.png');
		});

		$('#toggleLugar').click(function() {
			$('.col-lugar').toggleClass('oculto');
			$('.col-lugar-iniciales').toggleClass('oculto');
			ocultoLugar = !ocultoLugar;
			$('#textoLugar').text(ocultoLugar ? 'Lug.' : 'Lugar');
			$(this).find('img').attr('src', ocultoLugar ? '<?php echo base_url() ?>/img/ojo.png' : '<?php echo base_url() ?>/img/ojoc.png');
		});

		$('#textoNombre').text('Nom.');
		$('#textoLugar').text('Lug.');
		$('#toggleNombre img').attr('src', '<?php echo base_url() ?>/img/ojo.png');
		$('#toggleDJ img').attr('src', '<?php echo base_url() ?>/img/ojo.png');
		$('#toggleDJND img').attr('src', '<?php echo base_url() ?>/img/ojo.png');
		$('#toggleLugar img').attr('src', '<?php echo base_url() ?>/img/ojo.png');
	});
</script>