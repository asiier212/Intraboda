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

	});
</script>

<style>
	.editable img {
		float: right
	}
</style>
<h2>
	Estadísticas
</h2>
<div class="main form">


	<form method="post">
		<fieldset class="datos">
			<legend>Estadísticas</legend>
			<ul>
				<li><label>Desde:</label><input type="text" name="fecha_desde" id="calendar_desde" value="<?php echo $fecha_desde ?>" /></li>
				<li><label>Hasta:</label><input type="text" name="fecha_hasta" id="calendar_hasta" value="<?php echo $fecha_hasta ?>" /></li>
				<li><input type="submit" value="Filtrar" /></li>
			</ul>

			<br><br>

			<p>
			<fieldset>
				<legend>Servicios contratados</legend>
				<table class="tabledata">
					<tr>
						<th colspan="2">Servicios contratados entre <?php echo $fecha_desde ?> y <?php echo $fecha_hasta ?></th>
					</tr>
					<th>Servicio</th>
					<th>Veces</th>
					<?php
					foreach ($servicios_contratados as $servicios) {
					?>
						<tr>
							<td><?php echo $servicios['servicio'] ?></td>
							<td><?php echo $servicios['veces'] ?></td>
						</tr>
					<?php
					}
					?>
				</table>
			</fieldset>
			</p>

			<p>
			<fieldset>
				<legend>Canales de captación</legend>
				<table class="tabledata">
					<tr>
						<th colspan="2">Canales de captación entre <?php echo $fecha_desde ?> y <?php echo $fecha_hasta ?></th>
					</tr>
					<th>Canal</th>
					<th>Veces</th>
					<?php
					foreach ($canales_captacion as $canales) {
					?>

						<?php if($canales['numero'] > 0){ ?>
						<tr>
							<td><?php echo $canales['canal'] ?></td>
							<td><?php echo $canales['numero'];  ?></td>
						</tr>
					<?php
						}
					}
					?>
				</table>
			</fieldset>
			</p>

			<p>
			<fieldset>
				<legend>Comerciales</legend>
				<table class="tabledata">
					<!--Le añadimos 2 th que el nombre del comercial y número de presupuestos-->
					<tr>
						<th colspan="<?php echo $comerciales[0]['num_estados'] + 2 ?>">
							Comerciales entre <?php echo $fecha_desde ?> y <?php echo $fecha_hasta ?>
						</th>
					</tr>
					<th>Comercial</th>
					<th>Nº Presup.</th>
					<?php foreach ($estados_solicitudes as $estado) { ?>
						<th><?php echo $estado['nombre_estado'] ?></th>
					<?php } ?>

					<?php
					foreach ($comerciales as $com) {
						// Filtrar comerciales que tengan presupuestos
						if ($com['num_presupuestos'] > 0) {
					?>
							<tr>
								<td><?php echo $com['comercial'] ?></td>
								<td><?php echo $com['num_presupuestos'] ?></td>
								<?php
								foreach ($estados_solicitudes as $estado) {
									if ($estado['id_estado'] == '2') {
										if ($com[$estado['nombre_estado'] . 'p'] < 25) {
								?>
											<td class="rojo">
											<?php }
										if ($com[$estado['nombre_estado'] . 'p'] >= 25 && $com[$estado['nombre_estado'] . 'p'] < 33) { ?>
											<td class="amarillo">
											<?php }
										if ($com[$estado['nombre_estado'] . 'p'] >= 33) { ?>
											<td class="verde">
											<?php }
									} else { ?>
											<td>
												<?php }
											echo $com[$estado['nombre_estado'] . 'p'] ?>%</td>
										<?php } ?>
							</tr>
					<?php } // Fin del if para filtrar comerciales con presupuestos
					} ?>
				</table>

			</fieldset>
			</p>

			<p>
			<fieldset class="ancho">
				<legend>Respuestas entre <?php echo $fecha_desde ?> y <?php echo $fecha_hasta ?></legend>
				<?php
				if ($estadistica_encuestas[0] <> "") {
					foreach ($estadistica_encuestas as $pregunta) {
						$i = 0;
						foreach ($preguntas_encuesta as $preg_enc) {
							if ($pregunta['id_pregunta'] == $preg_enc['id_pregunta']) {
				?>
								<table class="tablaencuestas">
									<tr>
										<th><?php echo $preg_enc['pregunta'] ?></th>
									</tr>
									<tr>
										<td>
											<?php
											$j = 0;
											foreach ($respuestas_preguntas as $resp) {
												if (isset($pregunta[$resp['id_respuesta']]) && $pregunta[$resp['id_respuesta']] == $resp['id_respuesta']) {
											?><li>
														<table>
															<tr>
																<th>Respuesta</th>
																<th>Veces</th>
																<th>Porcentaje</th>
															</tr>
															<tr>
																<td><?php echo $resp['respuesta'] ?></td>
																<td align="center"><?php echo $pregunta[$resp['id_respuesta'] . 'n'] ?></td>
																<td align="center"><?php echo $pregunta[$resp['id_respuesta'] . 'p'] ?> %</td>
															</tr>
														</table>
													</li><?php
														}
														$j++;
													}
															?>
										</td>
									</tr>
								</table>
				<?php
							}
						}
					}
				}
				?>
			</fieldset>
			</p>

			<br class="clear" />
		</fieldset>
		<p style="text-align:center"></p>
	</form>

</div>
<div class="clear">
</div>