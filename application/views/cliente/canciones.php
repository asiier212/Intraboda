<link rel="stylesheet" href="<?php echo base_url() ?>js/jquery1.10.4/themes/smoothness/jquery-ui.css">
<script src="<?php echo base_url() ?>js/jquery1.10.4/js/jquery-1.10.2.js"></script>
<script src="<?php echo base_url() ?>js/jquery1.10.4/js/jquery-ui-1.10.4.js"></script>
<script src="<?php echo base_url() ?>js/jquery1.10.4/js/jquery.ui.touch-punch.min.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/tooltip.js"></script>

<script type="text/javascript" src="<?php echo base_url() ?>js/jquery1.10.4/js/jquery.jeditable.js"></script>
<style>
	.canciones li {
		padding-left: 10px !important;
		background: #FFF url(<?php echo base_url() ?>img/arrows.gif) no-repeat center left;
		cursor: n-resize;
		border: #CCC 1px solid;
		margin: 2px;
		position: relative
	}

	.momentos li {
		padding-left: 10px !important;
		background: #FFF url(<?php echo base_url() ?>img/arrows.gif) no-repeat center left;
		cursor: n-resize;
		border: #CCC 1px solid;
		margin: 2px;
		position: relative
	}
</style>

<script language="javascript">
	$(function() {
		$('#artista').keyup(function(e) {
			if (e.which == 13) {
				e.preventDefault();
			}

			var searched = $('#artista').val();
			var fullurl = $('#hiddenurl').val() + 'index.php/ajax/buscarartista/' + encodeURIComponent(searched);

			$.getJSON(fullurl, function(result) {
				var elements = [];
				$.each(result, function(i, val) {
					elements.push($('<div/>').html(val.artista).text()); // Decodifica entidades HTML
				});

				$('#artista').autocomplete({
					source: elements
				});
			});
		});


		$('#nombre').keyup(function(e) {
			if ($('#artista').val() == '') {
				alert("Debes escoger primero al artista");
				$('#artista').focus();
				return false;
			}

			if (e.which == 13) {
				e.preventDefault();
			}

			var searched = $('#nombre').val();
			var artist = $('#artista').val();
			var fullurl = $('#hiddenurl').val() + 'index.php/ajax/buscarcanciones/' + encodeURIComponent(searched) + '/' + encodeURIComponent(artist);

			$.getJSON(fullurl, function(result) {
				var elements = [];
				$.each(result, function(i, val) {
					elements.push($('<div/>').html(val.cancion).text()); // Decodifica entidades HTML
				});

				$('#nombre').autocomplete({
					source: elements
				});
			});
		});

		//$(".canciones").sortable({
		// handle : '.handle',
		//  update : function () {

		//var order = $('#noticias').sortable('serialize');
		//$("#noticias").load("functions_ajax.php?acc=order_news&"+order); 

		//$.ajax({
		//	url: "functions_ajax.php?acc=order_news&id=1&"+order,
		//	success: function(data) {
		//		$('#form').submit();
		//	}
		//});

		//  }
		// });	
		$('.edit_box').editable('<?php echo base_url() ?>index.php/ajax/updateobservaciones', {
			type: 'textarea',
			width: '400px',
			height: '60px',
			submit: '<img src="<?php echo base_url() ?>img/save.gif" />',
			tooltip: 'Click para editar...'
		});
		$(".canciones").sortable({
			update: function() {
				$("#result").html("Actualizando...");
				var order = $(this).sortable('toArray');
				var m_id = $(this).attr('id').substring(2);

				$.ajax({
					type: 'POST',
					url: '<?php echo base_url() ?>index.php/ajax/updateordencanciones',
					data: 'm_id=' + m_id + "&order=" + order,
					success: function(data) {
						$("#result").html("")
					}
				});

			}
		});
		// Actualiza orden y horas al mover momentos
		$(".momentos").sortable({
			update: function() {
				$("#result").html("Actualizando...");
				var order = $(this).sortable('toArray');
				var id_cliente = $(this).attr('id').substring(2);

				var horas = {};
				order.forEach(function(itemId) {
					var id_real = itemId.replace("mom_", "");
					var hora = $("input[name='hora_" + id_real + "']").val();
					if (hora) {
						horas[id_real] = hora;
					}
				});

				$.ajax({
					type: 'POST',
					url: '<?php echo base_url() ?>index.php/ajax/updateordenmomentos',
					data: {
						id_cliente: id_cliente,
						order: order.map(id => id.replace("mom_", "")).join(','),
						horas: horas
					},
					success: function() {
						$("#result").html("");
					}
				});
			}
		});

		// Al cambiar una hora, forzar el mismo comportamiento
		$(document).on('change', 'input[type="time"]', function() {
			var $momentos = $(".momentos");
			if ($momentos.length > 0) {
				$momentos.sortable("option", "update").call($momentos[0], null, $momentos.data("ui-sortable"));
			}
		});


		$(".canciones").disableSelection();
		$(".momentos").disableSelection();

	});

	function deletemomento(id) {
		if (confirm("\u00BFSeguro que desea borrar el momento especial?\nRecordamos que se borra el momento especial, borrará todas las canciones asignadas a ese momento.")) {
			$("#result").html("Actualizando...");
			$.ajax({
				type: 'POST',
				url: '<?php echo base_url() ?>index.php/ajax/deletemomento',
				data: 'id=' + id,
				success: function(data) {
					$("#mom_" + id).css("display", "none");
					$("#result").html("");
				}
			});
		}
		return false
	}

	function deletecancion(id) {
		if (confirm("\u00BFSeguro que desea borrar la canci\u00f3n?")) {
			$("#result").html("Actualizando...");
			$.ajax({
				type: 'POST',
				url: '<?php echo base_url() ?>index.php/ajax/deletecancion',
				data: 'id=' + id,
				success: function(data) {
					$("#c_" + id).css("display", "none");
					$("#result").html("");
				}
			});
		}
		return false
	}

	function deleteobservacion(id) {
		if (confirm("\u00BFSeguro que desea borrar el comentario?")) {
			$("#result").html("Actualizando...");
			$.ajax({
				type: 'POST',
				url: '<?php echo base_url() ?>index.php/ajax/deleteobservacion',
				data: 'id=' + id,
				success: function(data) {
					$("#obs_" + id).css("display", "none");
					$("#result").html("");
				}
			});
		}
		return false
	}
</script>


<script type="text/javascript">
	function display_c(start) {
		window.start = parseFloat(start);
		var end = 0 // change this to stop the counter at a higher value
		var refresh = 1000; // Refresh rate in milli seconds
		if (window.start >= end) {
			mytime = setTimeout('display_ct()', refresh)
		}
	}

	function display_ct() {
		// Calculate the number of days left
		var days = Math.floor(window.start / 86400);
		// After deducting the days calculate the number of hours left
		var hours = Math.floor((window.start - (days * 86400)) / 3600)
		// After days and hours , how many minutes are left
		var minutes = Math.floor((window.start - (days * 86400) - (hours * 3600)) / 60)
		// Finally how many seconds left after removing days, hours and minutes.
		var secs = Math.floor((window.start - (days * 86400) - (hours * 3600) - (minutes * 60)))

		var x = "( " + days + " Días " + hours + " Horas " + minutes + " Minutos y " + secs + " Segundos " + ")";

		document.getElementById('contador').innerHTML = x;
		window.start = window.start - 1;

		tt = display_c(window.start);
	}
</script>

<h2>
	Mi listado de canciones
</h2>
<div class="main">

	<?php
	$ahora = date("Y-m-d H:i:s");
	$fecha_limite = ('2031-09-30 23:59:59');
	// $fecha_limite = date("Y-m-d", strtotime('-2 day', strtotime($cliente['fecha_boda'])));

	$tiempo_que_queda = strtotime($fecha_limite) - strtotime($ahora);
	?>
	<script>
		display_c(<?php echo $tiempo_que_queda ?>);
	</script>


	<form method="post">
		<?php
		if ($ahora < $fecha_limite) { ?>
			<br>
			<center>
				<font color="red"><strong>Tiempo disponible para añadir canciones y momentos: <span id='contador' style="width:100%; text-align:right"></span></strong></font>
			</center><br>
			<fieldset class="datos">
				<legend>A&ntilde;adir Momento Especial <img src="<?php echo base_url() ?>/img/interrogacion.png" width="16" height="16" onMouseOver="Tip('<p>Si tu momento especial no aparece en el desplegable, escríbelo en la celda <b>Nombre del momento</b> y haz click en <b>Añadir</b>.</p>')" onMouseOut="UnTip()"></legend>
				<ul>
					<li><label>Nombre del momento:</label>
						<input type="text" style="display:block; float:left" name="nombre_moment" />
						<input type="submit" style="width:100px; margin-left:10px" name="add_moment" value="A&ntilde;adir" />
					</li>

				</ul>
			</fieldset>
			<fieldset class="datos">
				<legend>A&ntilde;adir Canci&oacute;n <img src="<?php echo base_url() ?>/img/interrogacion.png" width="16" height="16" onMouseOver="Tip('<p>Para asignar una canción a su momento especial, rellena la celda de <b>Artista + Canción</b> y después selecciona el momento en el desplegable de la barra inferior.</p>')" onMouseOut="UnTip()"></legend>
				<div>
					<font color="red" size="-2px"><b>* Comienza a rellenar y el auto-completado indicará resultados a los pocos segundos</b></font>
				</div><br>
				<?php if ($events) { ?>
					<ul>
						<li><label style="width:150px">Artista:</label>
							<input type="text" name="artista" id="artista" autocomplete="off" />

						<li><label style="width:150px">Canci&oacute;n:</label>
							<input type="text" style="display:block; float:left" name="nombre" id="nombre" autocomplete="off" />
							<input value="<?php echo base_url() ?>" id="hiddenurl" type="hidden">
							<br><br>

							<label style="width:150px">Momento especial:</label>
							<select style="display:block; float:left" name="momento_id">
								<?php foreach ($events as $e) { ?>
									<option value="<?php echo $e['id'] ?>"><?php echo $e['nombre'] ?></option>
								<?php } ?>
							</select>
							<br><br>
							<input type="submit" style="width:100px; margin-left:10px; margin-left:150px;" name="add_song" value="A&ntilde;adir" />
						</li>

					</ul>
				<?php } else {
					echo "<p>Para poder a&ntilde;adir una canci&oacute;n  antes tienes que a&ntilde;adir un momento especial</p>";
				} ?>
			</fieldset>
		<?php
		} else {
		?><br>
			<center>
				<font color="red"><strong>**El periodo para incluir canciones en tu perfil ha finalizado**</strong></font>
			</center><?php
					}
						?>
	</form>

	<fieldset class="datos">
		<legend>Ordena los momentos especiales
			<img src="<?php echo base_url() ?>/img/interrogacion.png" width="16" height="16"
				onMouseOver="Tip('<p>Ordena los momentos arrastrándolos y haz click en <b>Actualizar el orden</b>.</p>')"
				onMouseOut="UnTip()">
		</legend>
		<h4>* cambia el orden de los momentos especiales arrastrándolos</h4>
		<h4>* elimina los momentos especiales que no vayas a utilizar</h4>
		<br>

		<ul class="momentos" id="l_<?php echo $this->session->userdata('user_id') ?>">
			<?php foreach ($events as $eu): ?>
				<?php if ($eu['nombre'] !== 'Fiesta'): ?>
					<li id="mom_<?php echo $eu['id'] ?>" style="display: flex; justify-content: space-between; align-items: center;">
						<span>
							<img src="<?php echo base_url() ?>img/<?php echo ($eu['num_canciones'] == 0) ? 'admiracion' : 'check' ?>.png" width="15"
								onMouseOver="Tip('<?php echo ($eu['num_canciones'] == 0) ? 'No hay ninguna canción asignada para este momento especial' : 'Existen canciones asignadas para este momento especial' ?>')"
								onMouseOut="UnTip()" />

							<?php echo $eu['orden'] . '.- ' . $eu['nombre'] ?>
						</span>

						<span style="display: flex; align-items: center; gap: 8px;">
							<input type="time" name="hora_<?php echo $eu['id'] ?>"
								value="<?php echo substr($eu['hora'], 0, 5) ?>"
								style="width:70px; margin-right:20px" />

							<a href="#" onclick="return deletemomento(<?php echo $eu['id'] ?>)">
								<img src="<?php echo base_url() ?>img/delete.gif" width="15" />
							</a>
						</span>
					</li>

				<?php endif; ?>
			<?php endforeach; ?>
		</ul>
	</fieldset>


	<fieldset class="datos">
		<legend>Mis Listas de canciones</legend>

		<?php if ($events_user != false): ?>
			<h4>* Cambia el orden de canciones arrastrándolas</h4>

			<?php foreach ($events_user as $eu): ?>
				<div class="momentos" style="margin-bottom: 30px; border: 1px solid #ccc; padding: 10px; ">
					<h3 style="margin-bottom: 10px;">
						<?php echo $eu['orden'] . '.- ' . $eu['nombre']; ?>
						<?php if (!empty($eu['hora'])): ?>
							<small style="color: #777; font-size: 13px;">(<?php echo substr($eu['hora'], 0, 5); ?>)</small>
						<?php endif; ?>
					</h3>

					<ul class="canciones" id="m_<?php echo $eu['momento_id'] ?>">
						<?php foreach ($canciones_user as $c): ?>
							<?php if ($eu['momento_id'] == $c['momento_id']): ?>
								<li id="c_<?php echo $c['id'] ?>" style="margin-bottom: 8px;">
									<?php echo $c['artista'] ?> - <?php echo $c['cancion'] ?>
									<a href="#" onclick="return deletecancion(<?php echo $c['id'] ?>)">
										<img src="<?php echo base_url() ?>img/delete.gif" width="15" style="margin-left: 10px;" />
									</a>
								</li>
							<?php endif; ?>
						<?php endforeach; ?>
					</ul>
				</div>
			<?php endforeach; ?>

		<?php else: ?>
			<p>No hay canciones</p>
		<?php endif; ?>
	</fieldset>

	<fieldset>
		<legend>Observaciones</legend>
		<form method="post">

			Observaciones:<br />
			<textarea name="comentario" style="width:400px; height:60px"></textarea>
			<br /><br />
			Crea una observaci&oacute;n eligiendo un momento de la siguiente lista desplegable:<br />
			<select style="" name="momento_id">
				<option value="0">General</option>
				<?php foreach ($events as $e) { ?>
					<option value="<?php echo $e['id'] ?>"><?php echo $e['nombre'] ?></option>
				<?php } ?>
			</select>
			<br /><br />
			<input type="submit" name="add_comentario" value="Añadir" />
			<br /><br /><br />

			<fieldset>

				<legend>Mis Observaciones</legend>
				<span style="font-size:11px">Para editar los datos haz clic sobre el texto</span>
				<br /><br />
				<ul style="list-style:none">
					<?php
					if (!$canciones_observaciones_general && !$canciones_observaciones_momesp)
						echo "No hay Observaciones";

					if ($canciones_observaciones_general) {
						foreach ($canciones_observaciones_general as $c) {
					?>
							<li style="border-bottom:#CCC 1px solid" id="obs_<?php echo $c['id'] ?>"><span style="font-size:16px" class="edit_box" id="<?php echo $c['id'] ?>"><?php echo $c['comentario'] ?></span> <span style="font-size:11px"><br>(escrito el <?php echo $c['fecha'] ?>)</span>
								<a href="#" onclick="return deleteobservacion(<?php echo $c['id'] ?>)"><img src="<?php echo base_url() ?>img/delete.gif" width="15" /></a>
							</li>
					<?php
						}
					}
					?>
				</ul>


				<?php

				if ($canciones_observaciones_momesp) {

					$momentos_ids = array();
					foreach ($canciones_observaciones_momesp as $c) {
						$momentos_ids[] = $c['momento_id'];
					}

					foreach ($events as $e) {

						if (in_array($e['id'], $momentos_ids, true)) {
				?>
							<div class="observaciones">
								<h3><?php echo $e['nombre']; ?></h3>
								<ul id="m_<?php echo $e['id'] ?>">
									<?php
								}
								foreach ($canciones_observaciones_momesp as $c) {
									if ($e['id'] == $c['momento_id']) {
									?>
										<li style="border-bottom:#CCC 1px solid" id="obs_<?php echo $c['id'] ?>"><span style="font-size:16px" class="edit_box" id="<?php echo $c['id'] ?>"><?php echo $c['comentario'] ?></span> <span style="font-size:11px"><br>(escrito el <?php echo $c['fecha'] ?>)</span>
											<a href="#" onclick="return deleteobservacion(<?php echo $c['id'] ?>)"><img src="<?php echo base_url() ?>img/delete.gif" width="15" /></a>
										</li>

								<?php
									}
								}

								?>

						<?php
						if (in_array($e['id'], $momentos_ids, true)) echo "</ul></div>";
					}
				} ?>
			</fieldset>

		</form>
	</fieldset>

</div>
<div class="clear"></div>