<script type="text/javascript" src="<?php echo base_url() ?>js/tiny_mce.js"></script>
<script type="text/javascript">
	tinyMCE.init({
		// General options
		mode: 'textareas',
		theme: 'advanced',
		plugins: 'autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave,visualblocks',

		// Theme options
		theme_advanced_buttons1: 'save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect',
		theme_advanced_buttons2: 'cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor',
		theme_advanced_toolbar_location: 'top',
		theme_advanced_toolbar_align: 'left',
		theme_advanced_statusbar_location: 'bottom',
		theme_advanced_resizing: true,


		// Drop lists for link/image/media/template dialogs
		template_external_list_url: 'lists/template_list.js',
		external_link_list_url: 'lists/link_list.js',
		external_image_list_url: 'lists/image_list.js',
		media_external_list_url: 'lists/media_list.js',

		// Style formats
		style_formats: [{
				title: 'Bold text',
				inline: 'b'
			},
			{
				title: 'Red text',
				inline: 'span',
				styles: {
					color: '#ff0000'
				}
			},
			{
				title: 'Red header',
				block: 'h1',
				styles: {
					color: '#ff0000'
				}
			},
			{
				title: 'Example 1',
				inline: 'span',
				classes: 'example1'
			},
			{
				title: 'Example 2',
				inline: 'span',
				classes: 'example2'
			},
			{
				title: 'Table styles'
			},
			{
				title: 'Table row 1',
				selector: 'tr',
				classes: 'tablerow1'
			}
		],

	});
</script>
<link rel="stylesheet" href="<?php echo base_url() ?>js/jquery/development-bundle/themes/base/jquery.ui.all.css">


<link rel="stylesheet" href="<?php echo base_url() ?>js/jquery1.10.4/themes/smoothness/jquery-ui.css">
<script src="<?php echo base_url() ?>js/jquery1.10.4/js/jquery-1.10.2.js"></script>
<script src="<?php echo base_url() ?>js/jquery1.10.4/js/jquery-ui-1.10.4.js"></script>

<script src="<?php echo base_url() ?>js/jquery/development-bundle/ui/jquery-ui-timepicker-addon.js"></script>

<script type="text/javascript" src="<?php echo base_url() ?>js/jquery/development-bundle/ui/jquery-ui-sliderAccess.js"></script>



<link rel="stylesheet" href="<?php echo base_url() ?>js/jquery/development-bundle/demos/demos.css">
<script>
	$(function() {
		$("#calendar").datepicker();
		$("#calendar_hora").timepicker({});

	});
</script>

<script>
	$(function() {
		$('#anadir').click(function() {
			if ($('#n_presupuesto').val() == '') {
				alert("Debes añadir el número de presupuesto a la solicitud");
				$('#n_presupuesto').focus();
				return false;
			}
			if ($('#nombre').val() == '') {
				alert("Debes añadir el nombre a la solicitud");
				$('#nombre').focus();
				return false;
			}
			if ($('#apellidos').val() == '') {
				alert("Debes añadir los apellidos a la solicitud");
				$('#apellidos').focus();
				return false;
			}
			if ($('#direccion').val() == '') {
				alert("Debes añadir la dirección a la solicitud");
				$('#direccion').focus();
				return false;
			}
			if ($('#cp').val() == '') {
				alert("Debes añadir el código postal a la solicitud");
				$('#cp').focus();
				return false;
			}
			if ($('#poblacion').val() == '') {
				alert("Debes añadir la población a la solicitud");
				$('#poblacion').focus();
				return false;
			}
			if ($('#telefono').val() == '') {
				alert("Debes añadir el teléfono a la solicitud");
				$('#telefono').focus();
				return false;
			}
			if ($('#email').val() == '') {
				alert("Debes añadir el e-mail a la solicitud");
				$('#email').focus();
				return false;
			}
			if ($('#presupuesto_pdf').val() == '') {
				alert("Debes añadir el presupuesto a la solicitud");
				$('#presupuesto_pdf').focus();
				return false;
			}
			if ($('#calendar').val() == '') {
				alert("Debes añadir la fecha de la boda a la solicitud");
				$('#calendar').focus();
				return false;
			}
			if ($('#calendar_hora').val() == '') {
				alert("Debes añadir la hora de la boda a la solicitud");
				$('#calendar_hora').focus();
				return false;
			}
			if ($('#restaurante').val() == '') {
				alert("Debes añadir el restaurante a la solicitud");
				$('#restaurante').focus();
				return false;
			}
			if ($('#presupuesto_pdf').val() == '') {
				alert("Debes añadir el presupuesto a la solicitud");
				$('#presupuesto_pdf').focus();
				return false;
			}
			if ($('#importe').val() == '') {
				alert("Debes añadir el importe a la solicitud");
				$('#importe').focus();
				return false;
			}
			if ($('#descuento').val() == '') {
				alert("Debes añadir el descuento a la solicitud");
				$('#descuento').focus();
				return false;
			}
			if (confirm("¿Deseas enviar un e-mail para que el cliente realice una encuesta para descuento sobre el presupuesto?")) {
				$('#enviar_encuesta').val("S");
			}
		});

		$('#restaurante').keyup(function(e) {
			if (e.which == 13) {
				e.preventDefault();
			}

			var nombre = $('#restaurante').val();
			//alert(nombre);
			//alert(searched);
			var fullurl = $('#hiddenurl').val() + 'index.php/ajax/buscarrestaurante/' + encodeURIComponent(nombre);

			$.getJSON(fullurl, function(result) {
				var elements = [];
				$.each(result, function(i, val) {
					elements.push(val.nombre);
				});

				$('#restaurante').autocomplete({
					source: elements
				});
			});
		});
	});
</script>
<h2>
	A&ntilde;adir solicitud
</h2>
<div class="main form">

	<form method="post" id="formulario_cliente" name="formulario_cliente" enctype="multipart/form-data">
		<fieldset class="datos">
			<legend>Datos de contacto</legend>
			<ul>
				<li><label>(*)Número de presupuesto:</label>
					<input type="text" id="n_presupuesto" name="n_presupuesto" value="<?php echo isset($n_presupuesto) ? $n_presupuesto : ''; ?>" />
				</li>

				<li><label>(*)Nombre:</label><input type="text" id="nombre" name="nombre" /> </li>
				<li><label>(*)Apellidos:</label><input type="text" id="apellidos" name="apellidos" /> </li>
				<li><label>(*)Direcci&oacute;n:</label><input type="text" id="direccion" name="direccion" /> </li>
				<li><label>(*)CP:</label><input type="text" id="cp" name="cp" /> </li>
				<li><label>(*)Poblaci&oacute;n:</label><input type="text" id="poblacion" name="poblacion" /> </li>
				<li><label>(*)Tel&eacute;fono:</label><input type="text" id="telefono" name="telefono" /> </li>
				<li><label>(*)Email:</label><input type="text" id="email" name="email" /> </li>
				<li><label>(*)Presupuesto:</label><input type="file" id="presupuesto_pdf" name="presupuesto_pdf" /> </li>
				<li><label>(*)Importe:</label><input type="text" id="importe" name="importe" /> </li>
				<li><label>(*)Descuento:</label><input type="text" id="descuento" name="descuento" /> </li>
			</ul>

			<br />

			<br class="clear" />
			(*)Canal de captaci&oacute;n: <select name="canal_captacion">
				<?php
				foreach ($captacion as $capta) { ?>
					<option value="<?php echo $capta['id'] ?>"><?php echo $capta['nombre'] ?></option>
				<?php
				} ?>
			</select> <br />

			<br class="clear" />
			(*)Estado de la solicitud: <select name="estado_solicitud">
				<?php
				foreach ($estados_solicitudes as $estado) { ?>
					<option value="<?php echo $estado['id_estado'] ?>"><?php echo $estado['nombre_estado'] ?></option>
				<?php
				} ?>
			</select> <br />

		</fieldset>
		<fieldset class="datos">
			<legend>Datos de la boda</legend>
			<ul>
				<li><label>(*)Fecha de la boda:</label><input type="text" name="fecha_boda" id="calendar" /></li>
				<li><label>(*)Hora de la boda:</label><input type="text" name="hora_boda" id="calendar_hora" style="width:60px" /></li>
				<li><label>(*)Restaurante:</label><input type="text" id="restaurante" name="restaurante" /></li>
				<input value="<?php echo base_url() ?>" id="hiddenurl" type="hidden">
			</ul>

		</fieldset>

		<input type="hidden" name="enviar_encuesta" id="enviar_encuesta" value="">

		<p style="text-align:center"><input type="submit" id="anadir" value="A&ntilde;adir" /></p>
	</form>
</div>
<div class="clear">
</div>