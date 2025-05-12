<link rel="stylesheet" href="<?php echo base_url() ?>js/jquery1.10.4/themes/smoothness/jquery-ui.css">
<script src="<?php echo base_url() ?>js/jquery1.10.4/js/jquery-1.10.2.js"></script>
<script src="<?php echo base_url() ?>js/jquery1.10.4/js/jquery-ui-1.10.4.js"></script>
<script src="<?php echo base_url() ?>js/jquery1.10.4/js/jquery.ui.touch-punch.min.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/tooltip.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<?php print_r($data['canciones_spotify']); ?>

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
	}

	.momentos li a {
		position: static;
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
	$fecha_limite = date("Y-m-d", strtotime('-2 day', strtotime($cliente['fecha_boda'])));

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
			<!-- Añadir Momento Especial -->
			<fieldset class="datos" style="margin: 0 auto 30px auto; border: 2px solid #93ce37; padding: 20px; border-radius: 10px; background-color: #f9fff4;">
				<legend style="font-weight: bold; font-size: 18px; color: #4a7c12;">
					➕ Añadir Momento Especial
					<img src="<?php echo base_url() ?>/img/interrogacion.png" width="16" height="16"
						onMouseOver="Tip('<p>Si tu momento especial no aparece en el desplegable, escríbelo en la celda <b>Nombre del momento</b> y haz click en <b>Añadir</b>.</p>')"
						onMouseOut="UnTip()" style="vertical-align: middle; margin-left: 5px;" />
				</legend>

				<form method="post">
					<div style="display: flex; gap: 10px; align-items: center; margin-top: 10px; width: 30%">
						<label for="nombre_moment" style="width: 180px; color: #4a7c12; font-weight: bold;">Nombre del momento:</label>
						<input type="text" name="nombre_moment" id="nombre_moment" style="flex: 1; padding: 6px; border-radius: 4px; border: 1px solid #ccc;" />
						<input type="submit" name="add_moment" value="Añadir" style="padding: 6px 20px; background-color: #93ce37; color: white; border: none; border-radius: 4px; cursor: pointer;" />
					</div>
				</form>
			</fieldset>

			<!-- Añadir Canción -->
			<fieldset class="datos" style="margin: 0 auto 30px auto; border: 2px solid #93ce37; padding: 20px; border-radius: 10px; background-color: #f9fff4;">
				<legend style="font-weight: bold; font-size: 18px; color: #4a7c12;">
					🎵 Añadir Canción
					<img src="<?php echo base_url() ?>/img/interrogacion.png" width="16" height="16"
						onMouseOver="Tip('<p>Para asignar una canción a su momento especial, rellena la celda de <b>Artista + Canción</b> y después selecciona el momento en el desplegable de la barra inferior.</p>')"
						onMouseOut="UnTip()" style="vertical-align: middle; margin-left: 5px;" />
				</legend>

				<?php if ($events): ?>
					<p style="color: red; font-size: 12px; margin-bottom: 15px;"><strong>* Comienza a escribir y se activará el autocompletado automáticamente</strong></p>

					<form method="post">
						<div style="margin-bottom: 15px; display: flex; gap: 10px; align-items: center; width: 30%">
							<label for="artista" style="width: 150px; font-weight: bold; color: #4a7c12;">Artista:</label>
							<input type="text" name="artista" id="artista" autocomplete="off" style="flex: 1; padding: 6px; border-radius: 4px; border: 1px solid #ccc;" />
						</div>

						<div style="margin-bottom: 15px; display: flex; gap: 10px; align-items: center; width: 30%">
							<label for="nombre" style="width: 150px; font-weight: bold; color: #4a7c12;">Canción:</label>
							<input type="text" name="nombre" id="nombre" autocomplete="off" style="flex: 1; padding: 6px; border-radius: 4px; border: 1px solid #ccc;" />
							<input type="hidden" id="hiddenurl" value="<?php echo base_url() ?>">
						</div>

						<div style="margin-bottom: 15px; display: flex; gap: 10px; align-items: center; width: 30%">
							<label for="momento_id" style="width: 150px; font-weight: bold; color: #4a7c12;">Momento especial:</label>
							<select name="momento_id" id="momento_id" style="flex: 1; padding: 6px; border-radius: 4px; border: 1px solid #ccc;">
								<?php foreach ($events as $e): ?>
									<option value="<?php echo $e['id'] ?>"><?php echo $e['nombre'] ?></option>
								<?php endforeach; ?>
							</select>
						</div>

						<div style="text-align: left;">
							<input type="submit" name="add_song" value="Añadir" style="padding: 8px 24px; background-color: #93ce37; color: white; border: none; border-radius: 4px; font-weight: bold; cursor: pointer;" />
						</div>
					</form>
				<?php else: ?>
					<p style="color: #999;">Para poder añadir una canción, antes tienes que añadir un momento especial.</p>
				<?php endif; ?>
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

	<fieldset class="datos" style="border: 2px solid #93ce37; padding: 20px; border-radius: 10px; background-color: #f9fff4;">
		<legend style="font-weight: bold; font-size: 18px; color: #4a7c12;">
			🎯 Ordena los momentos especiales
			<img src="<?php echo base_url() ?>/img/interrogacion.png" width="16" height="16"
				onMouseOver="Tip('<p>Ordena los momentos arrastrándolos y haz click en <b>Actualizar el orden</b>.</p>')"
				onMouseOut="UnTip()" style="vertical-align: middle; margin-left: 5px;" />
		</legend>

		<p style="font-size: 13px; color: #666; margin-bottom: 15px;">
			* Cambia el orden de los momentos especiales arrastrándolos<br>
			* Elimina los momentos especiales que no vayas a utilizar
		</p>

		<ul class="momentos" id="l_<?php echo $this->session->userdata('user_id') ?>" style="list-style: none; padding-left: 0; margin: 0;">
			<?php foreach ($events as $eu): ?>
				<?php if ($eu['nombre'] !== 'Fiesta'): ?>
					<li id="mom_<?php echo $eu['id'] ?>"
						style="background: #fff; border: 1px solid #c9e7a3; border-left: 5px solid #93ce37; border-radius: 6px;
					box-shadow: 0 2px 4px rgba(0,0,0,0.04); padding: 10px 8px; margin-bottom: 10px;
					display: flex; justify-content: space-between; align-items: center;">

						<div style="display: flex; align-items: center; gap: 10px;">
							<img src="<?php echo base_url() ?>img/<?php echo ($eu['num_canciones'] == 0) ? 'admiracion' : 'check' ?>.png" width="16"
								onMouseOver="Tip('<?php echo ($eu['num_canciones'] == 0) ? 'No hay ninguna canción asignada para este momento especial' : 'Existen canciones asignadas para este momento especial' ?>')"
								onMouseOut="UnTip()" />
							<span style="font-size: 14px; font-weight: bold; color: #333;">
								<?php echo $eu['orden'] . '.- ' . $eu['nombre'] ?>
							</span>
						</div>

						<div style="display: flex; align-items: center; gap: 10px; justify-content: space-between;">
							<input type="time" name="hora_<?php echo $eu['id'] ?>" value="<?php echo substr($eu['hora'], 0, 5) ?>"
								style="font-family:Arial, Helvetica, sans-serif; width: 75px; padding: 4px; border: 1px solid #ccc; border-radius: 4px;" />
							<a href="#" onclick="return deletemomento(<?php echo $eu['id'] ?>)" title="Eliminar">
								<img src="<?php echo base_url() ?>img/delete.gif" width="15" alt="Eliminar">
							</a>
						</div>
					</li>
				<?php endif; ?>
			<?php endforeach; ?>
		</ul>
	</fieldset>



	<fieldset style="border: 2px solid #93ce37; padding: 20px; border-radius: 10px; background-color: #f9fff4;">
		<legend style="font-weight: bold; font-size: 18px; color: #4a7c12;">🎶 Mis Listas de Canciones</legend>

		<?php if ($events_user != false): ?>
			<p style="font-size: 13px; color: #666; margin-bottom: 25px;">* Puedes cambiar el orden de las canciones arrastrándolas</p>
			<?php foreach ($events_user as $eu): ?>
				<div class="momentos" style="margin-bottom: 30px; margin-right: 40px; border: 1px solid #c9e7a3; border-left: 5px solid #93ce37; border-radius: 6px; background-color: #fff; padding: 15px 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.03);">

					<h3 style="margin-bottom: 10px; font-size: 16px; font-weight: bold; color: #4a7c12; text-transform: uppercase;">
						<?php echo $eu['orden'] . '.- ' . $eu['nombre']; ?>
						<?php if (!empty($eu['hora'])): ?>
							<small style="color: #888; font-size: 13px;">(<?php echo substr($eu['hora'], 0, 5); ?>)</small>
						<?php endif; ?>
					</h3>

					<ul class="canciones" id="m_<?php echo $eu['momento_id'] ?>" style="list-style: none; padding-left: 0; margin: 0;">
						<?php foreach ($canciones_user as $c): ?>
							<?php if ($eu['momento_id'] == $c['momento_id']): ?>
								<li id="c_<?php echo $c['id'] ?>" style="margin-bottom: 10px; display: flex; justify-content: space-between; align-items: center; background: #f9fff4; padding: 8px 12px; border-radius: 5px; border: 1px solid #e3f1cd;">
									<span style="font-size: 14px; color: #333;">
										<?php echo $c['artista'] ?> - <?php echo $c['cancion'] ?>
									</span>
									<a href="#" onclick="return deletecancion(<?php echo $c['id'] ?>)" title="Eliminar">
										<img src="<?php echo base_url() ?>img/delete.gif" width="15" alt="Eliminar" />
									</a>
								</li>
							<?php endif; ?>
						<?php endforeach; ?>
					</ul>

				</div>
			<?php endforeach; ?>

		<?php else: ?>
			<p style="color: #888;">No hay canciones registradas.</p>
		<?php endif; ?>
	</fieldset>

	<!-- API SPOTIFY -->
	<?php
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		if (empty($canciones_spotify)) {
			$playlist = true;
		} else {
			$playlist = false;
		}
	}
	?>

	<fieldset style="border: 2px solid #93ce37; padding: 20px; border-radius: 10px; background-color: #f9fff4;">

		<legend style="font-weight: bold; font-size: 18px; color: #4a7c12;"><img src="<?php echo base_url() ?>/img/Spotify_Logo.png" width="23" height="23"></img> Añade tu PlayList de Spotify</legend>

		<?php if (isset($error_playlist) && $error_playlist): ?>
			<p style="color: red; margin: 10px 10px;">El enlace no es correcto</p>
		<?php endif; ?>

		<?php if (isset($mensaje) && $mensaje === 'guardada'): ?>
			<p style="color: green; margin: 10px 10px;">PlayList Guardada ✔</p>
		<?php elseif (isset($mensaje) && $mensaje === 'borrada'): ?>
			<p style="color: red; margin: 10px 10px;">PlayList No Guardada ✖</p>
		<?php endif; ?>




		<div style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
			<form method="post" style="display: flex; align-items: center; gap: 10px;">
				<!-- Imagen con margen a la derecha para separar del input -->
				<img src="<?php echo base_url() ?>/img/interrogacion.png" width="20" height="20"
					onMouseOver="Tip('<p>La playlist que compartas debe estar <b>Pública</b>. Para conseguir el enlace de la PlayList: <br> <b>Entra en la playlist, Pulsa en los tres puntos, Compartir y Copiar enlace en la lista</b>.</p>')"
					onMouseOut="UnTip()" style="vertical-align: middle; margin-right: 1px;" />

				<!-- Campo de texto con margen a la derecha para separar del botón -->
				<input type="text" name="playlist_id" placeholder="Link de una playlist de Spotify" value="<?= isset($playlist_id) ? $playlist_id : '' ?>"
					style="padding: 6px 10px; width: 100%; max-width: 300px; border: 1px solid #ccc; border-radius: 4px;">

				<!-- Botón con un tamaño adecuado para evitar que se divida el texto en varias líneas -->
				<button type="submit" style="padding: 8px 24px; background-color: #93ce37; color: white; border: none; border-radius: 6px; font-weight: bold; cursor: pointer; white-space: nowrap;">
					Cargar canciones
				</button>
			</form>

			<!-- Botón para ver playlists, fuera del formulario pero en el mismo contenedor -->
			<button id="togglePlaylists" type="button" onclick="verPlaylists()" style="padding: 8px 24px; background-color: rgb(116, 165, 38); color: white; border: none; border-radius: 6px; font-weight: bold; cursor: pointer; white-space: nowrap;">
				<span id="flecha">⭡ </span> Mis PlayList
			</button>
		</div>


		<div id="resultado-playlists" style="display: none;"></div>

		<?php if (isset($canciones_spotify) && count($canciones_spotify) > 0): ?>

			<form method="post" class="formElegir">
				<label style="font-size: 15px;">Quieres añadir esta PlayList?</label>
				<br></br>
				<button value="sumar" name="accion" type="submit" style="padding: 8px 24px; background-color:rgb(51, 255, 0); color: white; border: none; border-radius: 6px; font-weight: bold; cursor: pointer;">✔</button>
				<button value="restar" name="accion" type="submit" style="padding: 8px 24px; background-color:rgb(255, 0, 0); color: white; border: none; border-radius: 6px; font-weight: bold; cursor: pointer;">✖</button>
				<input type="hidden" name="enlace_playlist" value="<?= htmlspecialchars($enlacePlaylist) ?>" />
			</form>

			<table class="tabledata">
				<thead>
					<tr>
						<th>Portada</th>
						<th>Nombre</th>
						<th>Artista</th>
						<th>Álbum</th>
						<th>Duración</th>
						<th>Escuchar en Spotify</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($canciones_spotify as $c): ?>
						<tr>
							<td><img src="<?= $c['portada'] ?>" width="50" /></td>
							<td><?= $c['nombre'] ?></td>
							<td><?= $c['artista'] ?></td>
							<td><?= $c['album'] ?></td>
							<td><?= $c['duracion'] ?></td>
							<td><a href="<?= $c['enlace_spotify'] ?>" target="_blank"><img src="<?php echo base_url() ?>/img/Spotify_Logo.png" width="23" height="23"></img> </a></td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>

		<?php endif; ?>

	</fieldset>
	<!-- -->



	<fieldset style="border: 2px solid #93ce37; padding: 20px; border-radius: 10px; background-color: #f9fff4;">
		<legend style="font-weight: bold; font-size: 18px; color: #4a7c12;">📝Observaciones</legend>

		<form method="post">
			<div style="margin-bottom: 15px;">
				<label for="comentario" style="font-weight: bold; color: #4a7c12;">Escribe tu observación:</label><br>
				<textarea name="comentario" id="comentario"></textarea>
			</div>

			<label for="momento_id" style="font-weight: bold; color: #4a7c12;">Selecciona el momento:</label><br>
			<select name="momento_id" id="momento_id" style="padding: 6px 10px; width: 100%; max-width: 300px; border: 1px solid #ccc; border-radius: 4px;">
				<option value="0">General</option>
				<?php foreach ($events as $e) { ?>
					<option value="<?php echo $e['id'] ?>"><?php echo $e['nombre'] ?></option>
				<?php } ?>
			</select>


			<input type="submit" name="add_comentario" value="Añadir" style="padding: 8px 24px; background-color: #93ce37; color: white; border: none; border-radius: 6px; font-weight: bold; cursor: pointer;" />
		</form>
		<br><br><br>

		<!-- TinyMCE Editor -->
		<script src="<?php echo base_url() . "js/tinymce/tinymce.min.js" ?>"></script>
		<script>
			document.addEventListener("DOMContentLoaded", function() {
				tinymce.init({
					selector: 'textarea#comentario',
					menubar: false,
					toolbar: 'bold italic underline | bullist numlist',
					statusbar: false,
					branding: false,
					width: '100%',
					height: 140,
					content_style: "body { font-family:Helvetica,Arial,sans-serif; font-size:14px; }"
				});
			});
		</script>


		<script src="<?php echo base_url() . "js/tinymce/tinymce.min.js" ?>"></script>

		<script>
			document.addEventListener("DOMContentLoaded", function() {
				tinymce.init({
					selector: 'textarea',
					menubar: false,
					toolbar: 'bold italic',
					statusbar: false,
					branding: false,
					width: '100%',
					height: 140
				});
			});
		</script>


		<fieldset style="border: 2px solid #93ce37; padding: 20px; border-radius: 10px; background-color: #f9fff4;">
			<legend style="font-weight: bold; font-size: 18px; color: #4a7c12;">📝 Mis Observaciones</legend>
			<p style="font-size: 12px; color: #555;">Haz clic sobre el texto para editarlo</p>

			<?php if (!$canciones_observaciones_general && !$canciones_observaciones_momesp): ?>
				<div style="margin-top: 10px; color: #777;">No hay observaciones registradas.</div>
			<?php endif; ?>

			<!-- Observaciones Generales -->
			<?php if ($canciones_observaciones_general): ?>
				<div style="margin-top: 20px;">
					<?php foreach ($canciones_observaciones_general as $c): ?>
						<div style="background: #fff; border: 1px solid #c9e7a3; border-left: 5px solid #93ce37; border-radius: 6px; box-shadow: 0 2px 4px rgba(0,0,0,0.04); padding: 12px 16px; margin-bottom: 12px;" id="obs_<?php echo $c['id'] ?>">
							<span style="font-size: 15px;" class="edit_box" id="<?php echo $c['id'] ?>">
								<?php echo nl2br($c['comentario']); ?>
							</span>
							<div style="margin-top: 5px; color: #888; font-size: 12px;">📅 Escrito el <?php echo $c['fecha'] ?></div>
							<a href="#" onclick="return deleteobservacion(<?php echo $c['id'] ?>)" style="float: right; margin-top: -20px;" title="Eliminar">
								<img src="<?php echo base_url() ?>img/delete.gif" width="15" alt="Eliminar" />
							</a>
						</div>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>

			<!-- Observaciones por momento -->
			<?php if ($canciones_observaciones_momesp): ?>
				<?php
				$momentos_ids = array_column($canciones_observaciones_momesp, 'momento_id');
				foreach ($events as $e):
					if (in_array($e['id'], $momentos_ids)):
				?>
						<div style="margin-top: 30px;">
							<h3 style="font-size: 16px; font-weight: bold; color: #4a7c12; padding-bottom: 5px;"><?php echo strtoupper($e['nombre']); ?></h3>
							<?php foreach ($canciones_observaciones_momesp as $c): ?>
								<?php if ($e['id'] == $c['momento_id']): ?>
									<div style="background: #fff; border: 1px solid #c9e7a3; border-left: 5px solid #93ce37; border-radius: 6px; box-shadow: 0 2px 4px rgba(0,0,0,0.04); padding: 12px 16px; margin-bottom: 12px; display: flex; gap: 20px; justify-content: space-between; align-items: center;" id="obs_<?php echo $c['id'] ?>">
										<div>
											<span style="font-size: 15px;" class="edit_box" id="<?php echo $c['id'] ?>">
												<?php echo nl2br($c['comentario']); ?>
											</span>
											<div style="margin-top: 5px; color: #888; font-size: 12px;">📅 Escrito el <?php echo $c['fecha'] ?></div>
										</div>
										<a href="#" onclick="return deleteobservacion(<?php echo $c['id'] ?>)" title="Eliminar">
											<img src="<?php echo base_url() ?>img/delete.gif" width="15" alt="Eliminar" />
										</a>
									</div>
								<?php endif; ?>
							<?php endforeach; ?>
						</div>
				<?php endif;
				endforeach; ?>
			<?php endif; ?>
		</fieldset>


		</form>
	</fieldset>

</div>
<div class="clear"></div>

<style>
	.formElegir {
		margin-top: 20px;
	}

	.drag-handle {
		cursor: move;
	}

	.tabledata {
		width: 100%;
		border-collapse: collapse;
		margin-top: 40px;
	}

	.tabledata th,
	.tabledata td {
		border: 1px solid #ccc;
		padding: 5px;
		text-align: center;
	}

	#total_cuentas_bancarias .sortable-item,
	#total_canales_captacion .sortable-item,
	#total_momentos_especiales .sortable-item,
	#total_estados_solicitudes .sortable-item,
	#total_tipos_clientes .sortable-item {
		cursor: move;
	}
</style>

<script>
	function verPlaylists() {
		// Obtén el div que contiene las playlists
		var playlistsDiv = document.getElementById('resultado-playlists');

		// Solo alternar la visibilidad cuando se haga clic en el botón de mostrar/ocultar
		if (playlistsDiv.style.display === "none" || playlistsDiv.style.display === "") {
			playlistsDiv.style.display = "block"; // Mostrar el div
			document.getElementById('flecha').textContent = "⭣"; // Cambiar la flecha hacia abajo
		} else {
			playlistsDiv.style.display = "none"; // Ocultar el div
			document.getElementById('flecha').textContent = "⭡"; // Cambiar la flecha hacia arriba
		}

		// Hacer la llamada solo si el div está visible (esto es lo que garantiza que la tabla se recargue solo si está abierta)
		if (playlistsDiv.style.display === "block") {
			fetch('<?= base_url() . "cliente/canciones" ?>', {
					method: 'POST',
					headers: {
						'Content-Type': 'application/x-www-form-urlencoded'
					},
					body: 'accion=ver_playlists' // Acción para obtener las playlists
				})
				.then(response => response.text()) // Esperar una respuesta en formato HTML
				.then(html => {
					document.getElementById('resultado-playlists').innerHTML = html; // Actualizar el contenido
				});
		}
	}

	function delete_playlist(el) {
		var id = el.dataset.id; // Obtener el ID de la playlist
		if (confirm("¿Seguro que desea borrar la playlist?")) {
			$.ajax({
				type: 'POST',
				url: '<?= base_url() . 'index.php/ajax/deletePlayList' ?>',
				data: {
					id: id
				},
				success: function(data) {
					if (data.trim() === 'ok') {
						// Después de eliminar la playlist, recargamos las playlists
						verPlaylists(); // Recargar las playlists y mantener el div visible
						verPlaylists();
					}
				}
			});
		}
		return false;
	}
</script>