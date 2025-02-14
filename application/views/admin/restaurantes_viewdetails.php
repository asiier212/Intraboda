<script type="text/javascript" src="<?php echo base_url() ?>js/jquery/development-bundle/ui/jquery.jeditable.js"></script>



<script language="javascript">
	$(document).ready(function() {
		$('.edit_box').editable('<?php echo base_url() ?>index.php/ajax/updatedatorestaurante/<?php echo $restaurante['id_restaurante'] ?>', {
			type: 'text',
			submit: '<img src="<?php echo base_url() ?>img/save.gif" />',
			tooltip: 'Click para editar...',
		});

		$('#enviar_archivo').click(function() {
			if ($('#descripcion_archivo').val() == '') {
				alert("Debes añadir la descripción del archivo");
				$('#descripcion_archivo').focus();
				return false;
			}
		});
	});


	function elimina_archivo_restaurante(id_adjunto, id_restaurante) {
		if (confirm("\u00BFSeguro que desea borrar el archivo?")) {
			$.ajax({
				type: 'POST',
				url: '<?php echo base_url() ?>index.php/ajax/elimina_archivo_restaurante',
				data: 'id_adjunto=' + id_adjunto,
				success: function(data) {
					location.href = '<?php echo base_url() ?>admin/restaurantes/view/' + id_restaurante;
				}
			});
		}
		return false
	}
</script>


<link rel="stylesheet" href="<?php echo base_url() ?>js/jquery/development-bundle/themes/base/jquery.ui.all.css">
<script src="<?php echo base_url() ?>js/jquery/development-bundle/ui/jquery-ui-1.8.16.custom.min.js"></script>




<style>
	.editable img {
		float: right
	}
</style>
<h2>
	Detalles del restaurante
</h2>
<div class="main form">

	<form method="post" enctype="multipart/form-data">
		<input type="hidden" name="id" id="id" value="<?php $restaurante['id_restaurante'] ?>">
		<fieldset class="datos">
			<legend>Datos del restaurante</legend>
			<ul>
				<li><label>Nombre:</label><span class="edit_box" id="nombre"><?php echo $restaurante['nombre'] ?></span> </li>
				<li><label>Direcci&oacute;n:</label><span class="edit_box" id="direccion"><?php echo $restaurante['direccion'] ?></span></li>
				<li><label>Telefono:</label><span class="edit_box" id="telefono"><?php echo $restaurante['telefono'] ?></span></li>
				<li><label>Maitre:</label><span class="edit_box" id="maitre"><?php echo $restaurante['maitre'] ?></span></li>
				<li><label>Telefono Maitre:</label><span class="edit_box" id="telefono_maitre"><?php echo $restaurante['telefono_maitre'] ?></span></li>
				<li><label>Otro Personal:</label><span class="edit_box" id="otro_personal"><?php echo $restaurante['otro_personal'] ?></span></li>
				<li><label>Hora limite de fiesta:</label><span class="edit_box" id="hora_limite_fiesta"><?php echo $restaurante['hora_limite_fiesta'] ?></span></li>
				<li><label>Empresa Habitual:</label><span class="edit_box" id="empresa_habitual"><?php echo $restaurante['empresa_habitual'] ?></span></li>
			</ul>
		</fieldset>

		<fieldset class="datos">
			<legend>Archivos adjuntos del restaurante</legend>
			<?php
			if ($archivos_restaurante[0] <> "") {
			?>
				<table class="tabledata">
					<th>DESCRIPCION</th>
					<?php
					foreach ($archivos_restaurante as $archivo) { ?>
						<tr>
							<td><a href="<?php echo base_url() ?>/uploads/restaurantes/<?php echo $archivo['archivo'] ?>" target="_blank"><?php echo $archivo['descripcion'] ?></a></td>
							<td><a href="#" onclick="return elimina_archivo_restaurante(<?php echo $archivo['id_adjunto'] ?>, <?php echo $archivo['id_restaurante'] ?>)"><img src="<?php echo base_url() ?>img/cancel.gif" width="18px" title="Eliminar archivo" /></a></td>
						</tr>
					<?php
					}
					?>
				</table>
				<?php
			} else {
				?>No hay archivos<?php
							}
								?>
				<br><br>
				(*) Descripción: <input type="text" id="descripcion_archivo" name="descripcion_archivo"><br>
				<input type="file" name="archivo"><br>
				<input type="submit" id="enviar_archivo" name="enviar_archivo" value="Subir Archivo">
		</fieldset>

		<p style="text-align:center"></p>
	</form>

</div>
<div class="clear">
</div>