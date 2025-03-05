<script type="text/javascript" src="<?php echo base_url() ?>js/jquery/development-bundle/ui/jquery.jeditable.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/alertify/lib/alertify.js"></script>
<link rel="stylesheet" href="<?php echo base_url() ?>js/alertify/themes/alertify.core.css" />
<link rel="stylesheet" href="<?php echo base_url() ?>js/alertify/themes/alertify.default.css" />

<!-- Place the first <script> tag in your HTML's <head> -->
<script src="https://cdn.tiny.cloud/1/o6bdbfrosyztaa19zntejfp6e2chzykthzzh728vtdjokot2/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>

<script>
	function initTinyMCE(selector) {
		tinymce.init({
			selector: selector,
			height: 200,
			menubar: false,
			toolbar: 'bold italic fontsizeselect',
			font_size_formats: '8pt 10pt 12pt 14pt 18pt 24pt 36pt',
			content_style: 'body { font-size: 14px; }',
			branding: false
		});
	}
</script>

<script>
	function anadirPreguntaPopup() {
		let activeTab = document.querySelector('.tab.active').getAttribute('data-tab');
		let popupContent = '';

		if (activeTab === 'encuesta1') {
			popupContent = `
        <label>Pregunta:</label>
        <input type='text' id='nueva_pregunta' class='popup-input'><br><br>
        <label>Importe Descuento (€):</label>
        <input type='number' id='importe_descuento' class='popup-input'><br><br>
    `;
		} else if (activeTab === 'encuesta2') {
			popupContent = `
                <label>Pregunta:</label>
                <input type='text' id='nueva_pregunta' class='popup-input-preguta'><br><br>
                <label>Descripción:</label>
                <textarea id='descripcion' class='popup-input-descripcion'></textarea><br><br>
                <label>Tipo de Pregunta:</label>
                <select id='tipo_pregunta' class='popup-input'>
                    <option value='texto'>Texto</option>
                    <option value='rango'>Rango</option>
                    <option value='opciones'>Opción Única</option>
                    <option value='multiple'>Múltiples Opciones</option>
                </select><br><br>
            `;
		}

		let popup = `
            <div class='popup-overlay' id='popup'>
                <div class='popup-content'>
                    <h3>Añadir Nueva Pregunta</h3><br>
                    ${popupContent}
                    <div class='popup-buttons'>
                        <button onclick='guardarPregunta("${activeTab}")'>Guardar</button>
                        <button onclick='cerrarPopup()'>Cancelar</button>
                    </div>
                </div>
            </div>
        `;

		document.body.insertAdjacentHTML('beforeend', popup);
		initTinyMCE('#descripcion');
	}

	function cerrarPopup() {
		document.getElementById('popup').remove();
	}

	function guardarPregunta(tab) {
		let pregunta = document.getElementById('nueva_pregunta').value.trim();
		let data = {
			pregunta: pregunta
		};

		if (tab === 'encuesta1') {
			let importeElement = document.querySelector('.popup-content #importe_descuento');
			let importe = importeElement ? importeElement.value.trim() : "";
			console.log("Valor correcto del input importe_descuento:", importe);

			data.importe_descuento = importe !== "" ? parseFloat(importe) : null;
		} else if (tab === 'encuesta2') {
			data.descripcion = tinymce.get('descripcion').getContent().trim();
			data.tipo_pregunta = document.getElementById('tipo_pregunta').value;
		}

		if (pregunta === '') {
			alert('La pregunta no puede estar vacía');
			return;
		}

		fetch('<?php echo base_url() ?>index.php/ajax/anadir_pregunta', {
				method: 'POST',
				headers: {
					'Content-Type': 'application/json'
				},
				body: JSON.stringify(data)
			})
			.then(response => response.json())
			.then(result => {
				if (result.success) {
					location.reload();
				} else {
					alert(result.message);
				}
			});
	}


	function editar_pregunta(id_pregunta, pregunta, descripcion = '', tipo_pregunta = '', respuestas = []) {
		let activeTab = document.querySelector('.tab.active').getAttribute('data-tab');
		let popupContent = `<label>Pregunta:</label>
            <input type='text' id='edit_pregunta' class='popup-input-preguta' value='${pregunta}'><br><br>`;

		if (activeTab === 'encuesta1') {
			popupContent += `<label>Importe Descuento (€):</label>
                <input type='number' id='edit_importe_descuento' class='popup-input' value='${descripcion}'><br><br>`;
		} else if (activeTab === 'encuesta2') {
			popupContent += `<label>Descripción:</label><br>
                <textarea id='edit_descripcion' class='popup-input-descripcion'>${descripcion}</textarea><br><br>
                <label>Tipo de Pregunta:</label>
                <select id='edit_tipo_pregunta' class='popup-input'>
                    <option value='texto' ${tipo_pregunta === 'texto' ? 'selected' : ''}>Texto</option>
                    <option value='rango' ${tipo_pregunta === 'rango' ? 'selected' : ''}>Rango</option>
                    <option value='opciones' ${tipo_pregunta === 'opciones' ? 'selected' : ''}>Opción Única</option>
                    <option value='multiple' ${tipo_pregunta === 'multiple' ? 'selected' : ''}>Múltiples Opciones</option>
                </select><br><br>`;
		}

		popupContent += `<h4>Respuestas:</h4><div id='respuestas_container'>`;
		respuestas.forEach(resp => {
			popupContent += `
                <div class='respuesta-item' id='respuesta_${resp.id_respuesta}'>
                    <input type='text' class='respuesta-input' data-id='${resp.id_respuesta}' value='${resp.respuesta}'>
                    <button style="border:none; background-color:white" onclick='eliminar_respuesta(${resp.id_respuesta})'>
                        <img class="icon" src="<?php echo base_url(); ?>img/delete.gif"/>
                    </button>
                </div>`;
		});
		popupContent += `</div>`;

		let popup = `<div class='popup-overlay' id='popup'>
            <div class='popup-content'>
                <h3>Editar Pregunta</h3><br>
                ${popupContent}
                <div class='popup-buttons'>
                    <br>
                    <button onclick='guardarEdicionPregunta(${id_pregunta}, "${activeTab}")'>Guardar</button>
                    <button onclick='cerrarPopup()'>Cancelar</button>
                </div>
            </div>
        </div>`;

		document.body.insertAdjacentHTML('beforeend', popup);
		initTinyMCE('#edit_descripcion');
	}

	function guardarEdicionPregunta(id_pregunta, tab) {
		let nuevaPregunta = document.getElementById('edit_pregunta').value.trim();
		let data = {
			id_pregunta: id_pregunta,
			pregunta: nuevaPregunta
		};

		if (tab === 'encuesta1') {
			data.importe_descuento = document.getElementById('edit_importe_descuento').value.trim();
		} else if (tab === 'encuesta2') {
			data.descripcion = tinymce.get('edit_descripcion').getContent().trim();
			data.tipo_pregunta = document.getElementById('edit_tipo_pregunta').value;
		}

		let respuestasEditadas = [];
		document.querySelectorAll('.respuesta-input').forEach(input => {
			respuestasEditadas.push({
				id_respuesta: input.getAttribute('data-id'),
				respuesta: input.value
			});
		});

		data.respuestas = respuestasEditadas;

		fetch('<?php echo base_url() ?>index.php/ajax/editar_pregunta', {
				method: 'POST',
				headers: {
					'Content-Type': 'application/json'
				},
				body: JSON.stringify(data)
			})
			.then(response => response.json())
			.then(result => {
				if (result.success) {
					location.reload();
				} else {
					alert("Error al actualizar la pregunta");
				}
			});
	}

	function eliminar_respuesta(id_respuesta) {
		fetch('<?php echo base_url() ?>index.php/ajax/eliminar_respuesta', {
				method: 'POST',
				headers: {
					'Content-Type': 'application/json'
				},
				body: JSON.stringify({
					id_respuesta: id_respuesta
				})
			})
			.then(response => response.json())
			.then(result => {
				if (result.success) {
					document.getElementById(`respuesta_${id_respuesta}`).remove();
				} else {
					alert("Error al eliminar la respuesta");
				}
			});
	}

	function deletepregunta(id_pregunta) {
    let activeTab = document.querySelector('.tab.active').getAttribute('data-tab');
    console.log("🔵 Eliminando pregunta en", activeTab, "ID:", id_pregunta);

    if (confirm("¿Seguro que deseas eliminar esta pregunta?")) {
        fetch('<?php echo base_url() ?>index.php/ajax/deletepregunta_encuesta', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ 
                id_pregunta: id_pregunta, 
                tipo_encuesta: activeTab  // Se envía la encuesta activa 
            })
        })
        .then(response => response.json())
        .then(result => {
            console.log("🟢 Respuesta del servidor:", result);
            if (result.success) {
                location.reload();
            } else {
                alert("❌ Error al eliminar la pregunta: " + result.message);
            }
        })
        .catch(error => console.error("🔴 Error en fetch:", error));
    }
}



	function anadir_respuesta(id_pregunta) {
		let activeTab = document.querySelector('.tab.active').getAttribute('data-tab'); // Identificar la encuesta activa
		let preguntaFieldset = document.getElementById(`pregunta_${id_pregunta}`);

		if (!preguntaFieldset) {
			console.error(`❌ No se encontró el fieldset para la pregunta con ID: ${id_pregunta}`);
			return;
		}

		// Verificar si el contenedor de respuestas existe, si no, crearlo
		let respuestasContainer = preguntaFieldset.querySelector(".respuestas");
		if (!respuestasContainer) {
			respuestasContainer = document.createElement("ul");
			respuestasContainer.className = "respuestas";
			preguntaFieldset.appendChild(respuestasContainer);
		}

		// Verificar si ya existe un input para evitar duplicados
		if (document.getElementById(`nueva_respuesta_${id_pregunta}`)) {
			return;
		}

		// Crear el input para la nueva respuesta
		let inputRespuesta = document.createElement("input");
		inputRespuesta.type = "text";
		inputRespuesta.id = `nueva_respuesta_${id_pregunta}`;
		inputRespuesta.className = "respuesta-input";
		inputRespuesta.placeholder = "Escribe la respuesta";

		// Crear botón de confirmar ✔
		let btnConfirmar = document.createElement("button");
		btnConfirmar.innerText = "✔";
		btnConfirmar.onclick = function() {
			guardar_respuesta(id_pregunta, activeTab);
		};

		// Crear botón de cancelar ✖
		let btnCancelar = document.createElement("button");
		btnCancelar.innerText = "✖";
		btnCancelar.onclick = function() {
			inputRespuesta.remove();
			btnConfirmar.remove();
			btnCancelar.remove();
		};

		// Agregar input y botones al contenedor de respuestas
		respuestasContainer.appendChild(inputRespuesta);
		respuestasContainer.appendChild(btnConfirmar);
		respuestasContainer.appendChild(btnCancelar);

		// 🔹 AUTOFOCUS para escribir de inmediato
		inputRespuesta.focus();
	}


	function guardar_respuesta(id_pregunta) {
		let respuestaInput = document.querySelector(`#pregunta_${id_pregunta} .respuesta-input`);
		console.log("Input encontrado:", respuestaInput); // Verifica si se encuentra el input
		if (!respuestaInput) {
			console.error("No se encontró el input para la respuesta.");
			return;
		}

		let respuesta = respuestaInput.value.trim();
		console.log("Respuesta:", respuesta); // Verifica el valor de la respuesta
		if (respuesta === "") {
			alert("La respuesta no puede estar vacía.");
			return;
		}

		console.log("🔵 Enviando respuesta:", respuesta, "para la pregunta con ID:", id_pregunta);

		fetch('<?php echo base_url() ?>index.php/ajax/anadir_respuesta', {
				method: 'POST',
				headers: {
					'Content-Type': 'application/json'
				},
				body: JSON.stringify({
					id_pregunta: id_pregunta,
					respuesta: respuesta
				})
			})
			.then(response => response.json())
			.then(result => {
				console.log("🟢 Respuesta del servidor:", result);
				if (result.success) {
					location.reload();
				} else {
					alert(result.message);
				}
			})
			.catch(error => console.error("🔴 Error en la petición fetch:", error));
	}
</script>


<h2>
	Encuesta
</h2>
<div class="main form">

	<div class="tabs">
		<div class="tab active" data-tab="encuesta1" onclick="openTab('encuesta1')">Comercial</div>
		<div class="tab" data-tab="encuesta2" onclick="openTab('encuesta2')">Inicial Cliente</div>
	</div>

	<div id="encuesta1" class="tab-content active">

		<form method="post" name="preguntas" id="preguntas" style="display: flex; flex-direction: column; justify-content: center; align-items: center;">
			<div style="clear:both"></div>

			<button type="button" onclick="anadirPreguntaPopup()" style="width: 10%; margin: 10px">Añadir pregunta</button>

			<input type="hidden" id="pregunta" name="pregunta" value="" />
			<input type="hidden" id="importe_descuento" name="importe_descuento" value="">

			<br><br>

			<?php if (!empty($preguntas_encuesta)) {
				$cont_preguntas = 1;
				foreach ($preguntas_encuesta as $pregunta) { ?>
					<fieldset id="pregunta_<?php echo $pregunta['id_pregunta']; ?>">
						<legend>
							<?php echo $cont_preguntas . ". " . $pregunta['pregunta']; ?>
						</legend>

						<div class="contenido_PyR">
							<p><strong>Importe Descuento:</strong> <?php echo $pregunta['importe_descuento']; ?> &euro;</p>

							<?php if (!empty($respuestas_preguntas)) { ?>
								<ul class="respuestas">
									<?php foreach ($respuestas_preguntas as $respuesta) {
										if ($pregunta['id_pregunta'] == $respuesta['id_pregunta']) { ?>
											<?php echo $respuesta['respuesta']  . "<br>"; ?>
									<?php }
									} ?>
								</ul>
							<?php } else {
								echo "<p class='no-respuestas'>No hay respuestas aún.</p>";
							} ?>
						</div>
						<div class="botones_Aña_Edi_Eli">
							<a href="#" onclick="anadir_respuesta(<?php echo $pregunta['id_pregunta']; ?>)">
								<img class="icon" src="<?php echo base_url(); ?>img/anadir.png" title="Añadir respuesta" />
							</a>
							<a href="#" onclick='return editar_pregunta(
								<?php echo json_encode($pregunta['id_pregunta'], JSON_HEX_APOS | JSON_HEX_QUOT); ?>, 
								<?php echo json_encode($pregunta['pregunta'], JSON_HEX_APOS | JSON_HEX_QUOT); ?>, 
								<?php echo json_encode($pregunta['importe_descuento'], JSON_HEX_APOS | JSON_HEX_QUOT); ?>, 
								null, 
								<?php echo json_encode(array_values(array_filter($respuestas_preguntas, function ($r) use ($pregunta) {
									return $r['id_pregunta'] == $pregunta['id_pregunta'];
								})), JSON_HEX_APOS | JSON_HEX_QUOT); ?>
								)'>
								<img class="icon" src="<?php echo base_url(); ?>img/editar.png" title="Editar pregunta" />
							</a>
							<a href="#" onclick="return deletepregunta(<?php echo $pregunta['id_pregunta']; ?>)">
								<img class="icon" src="<?php echo base_url(); ?>img/delete.gif" title="Eliminar pregunta" />
							</a>
						</div>
					</fieldset>
				<?php $cont_preguntas++;
				}
			} else { ?>
				<p class="no-preguntas">❌ No hay preguntas en la base de datos.</p>
			<?php } ?>

			<br class="clear" />

			<input type="hidden" id="respuesta" name="respuesta" value="">
			<input type="hidden" id="id_pregunta" name="id_pregunta" value="" />
		</form>

	</div>
	<div class="clear">
	</div>



	<div id="encuesta2" class="tab-content">

		<form method="post" name="preguntas" id="preguntas" style="display: flex; flex-direction: column; justify-content: center; align-items: center;">
			<div style="clear:both"></div>

			<button type="button" onclick="anadirPreguntaPopup()" style="width: 10%; margin: 10px">Añadir pregunta</button>

			<input type="hidden" id="pregunta" name="pregunta" value="" />
			<input type="hidden" id="importe_descuento" name="importe_descuento" value="">

			<br><br>

			<?php if (!empty($preguntas_encuesta_cliente)) {
				$cont_preguntas = 1;
				foreach ($preguntas_encuesta_cliente as $preguntaCliente) { ?>
					<fieldset id="pregunta_<?php echo $preguntaCliente['id_pregunta']; ?>">
						<legend>
							<?php echo $cont_preguntas . ". " . $preguntaCliente['pregunta']; ?>
						</legend>

						<div class="contenido_PyR">
							<p class="pregunta-descripcion"><?php echo nl2br($preguntaCliente['descripcion']); ?></p>
							<p><strong>Tipo de Pregunta:</strong> <span class="tipo-pregunta"><?php echo ucfirst($preguntaCliente['tipo_pregunta']); ?></span></p>

							<?php if (!empty($respuestas_preguntasClientes)) { ?>
								<ul class="respuestas">
									<?php foreach ($respuestas_preguntasClientes as $respuestaCliente) {
										if ($preguntaCliente['id_pregunta'] == $respuestaCliente['id_pregunta']) { ?>
											<?php echo $respuestaCliente['respuesta'] . "<br>"; ?>
									<?php }
									} ?>
								</ul>
							<?php } else {
								echo "<p class='no-respuestas'>No hay respuestas aún.</p>";
							} ?>
						</div>
						<div class="botones_Aña_Edi_Eli">
							<a href="#" onclick="return anadir_respuesta(<?php echo $preguntaCliente['id_pregunta']; ?>)">
								<img class="icon" src="<?php echo base_url(); ?>img/anadir.png" title="Añadir respuesta" />
							</a>

							<a href="#" onclick='return editar_pregunta(
								<?php echo json_encode($preguntaCliente['id_pregunta'], JSON_HEX_APOS | JSON_HEX_QUOT); ?>, 
								<?php echo json_encode($preguntaCliente['pregunta'], JSON_HEX_APOS | JSON_HEX_QUOT); ?>, 
								<?php echo json_encode($preguntaCliente['descripcion'], JSON_HEX_APOS | JSON_HEX_QUOT); ?>, 
								<?php echo json_encode($preguntaCliente['tipo_pregunta'], JSON_HEX_APOS | JSON_HEX_QUOT); ?>, 
        						<?php echo json_encode(array_values(array_filter($respuestas_preguntasClientes, function ($r) use ($preguntaCliente) {
									return $r['id_pregunta'] == $preguntaCliente['id_pregunta'];
								})), JSON_HEX_APOS | JSON_HEX_QUOT); ?>
    							)'>
								<img class="icon" src="<?php echo base_url(); ?>img/editar.png" title="Editar pregunta" />
							</a>
							<a href="#" onclick="return deletepregunta(<?php echo $preguntaCliente['id_pregunta']; ?>)">
								<img class="icon" src="<?php echo base_url(); ?>img/delete.gif" title="Eliminar pregunta" />
							</a>
						</div>

					</fieldset>
				<?php $cont_preguntas++;
				}
			} else { ?>
				<p class="no-preguntas">❌ No hay preguntas en la base de datos.</p>
			<?php } ?>

			<br class="clear" />

			<input type="hidden" id="respuesta" name="respuesta" value="">
			<input type="hidden" id="id_pregunta" name="id_pregunta" value="" />
		</form>

	</div>
</div>



<script>

	function openTab(tabId) {
		// Oculta todos los contenidos y quita la clase activa de las pestañas
		document.querySelectorAll('.tab-content').forEach(content => content.classList.remove('active'));
		document.querySelectorAll('.tab').forEach(tab => tab.classList.remove('active'));

		// Activa la pestaña y su contenido correspondiente
		document.querySelector(`[data-tab="${tabId}"]`).classList.add('active');
		document.getElementById(tabId).classList.add('active');

		// Guarda la pestaña activa en localStorage
		localStorage.setItem('activeTab', tabId);
	}

	document.addEventListener("DOMContentLoaded", function() {
		// Recupera la pestaña activa de localStorage o usa 'encuesta1' por defecto
		const activeTab = localStorage.getItem('activeTab') || 'encuesta1';
		openTab(activeTab);
	});
</script>

<style>
	.popup-overlay {
		position: fixed;
		top: 0;
		left: 0;
		width: 100%;
		height: 100%;
		background: rgba(0, 0, 0, 0.5);
		display: flex;
		/* Asegurar que se muestra */
		justify-content: center;
		align-items: center;
		z-index: 1000;
	}

	.popup-content {
		background: white;
		padding: 20px;
		border-radius: 10px;
		box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.3);
		width: 20%;
		text-align: center;
	}

	/* Contenedor de cada pregunta */
	fieldset {
		width: 90%;
		margin-bottom: 15px;
		padding: 15px;
		border: 2px solid #ccc;
		border-radius: 8px;
		background-color: #f9f9f9;

		display: flex;
		justify-content: space-between;
	}

	legend {
		font-size: 1.2em;
		font-weight: bold;
		padding: 5px 10px;
		border-radius: 5px;
	}

	/* Descripción de la pregunta */
	.pregunta-descripcion {
		font-style: italic;
		color: #555;
		margin-bottom: 10px;
	}

	.popup-input-preguta {
		width: 80%;
	}

	.popup-input-descripcion {
		width: 80%;
	}

	/* Tipo de pregunta */
	.tipo-pregunta {
		background: #f1f1f1;
		padding: 5px;
		border-radius: 5px;
		font-weight: bold;
		display: inline-block;
		margin-bottom: 10px;
	}

	/* Lista de respuestas */
	ul.respuestas {
		margin-left: 20px;
		padding-left: 0;
	}

	ul.respuestas li {
		margin-bottom: 5px;
		list-style-type: none;
	}

	/* Iconos de edición y eliminación */
	.icon {
		width: 15px;
		cursor: pointer;
		transition: 0.2s;
	}

	.icon:hover {
		transform: scale(1.2);
	}

	/* Mensaje cuando no hay preguntas */
	.no-preguntas {
		color: red;
		font-weight: bold;
	}

	/* Mensaje cuando no hay respuestas */
	.no-respuestas {
		color: #888;
		font-style: italic;
	}

	.botones_Aña_Edi_Eli {
		display: flex;
		flex-direction: column;
		align-items: center;
		justify-content: center;
		gap: 10px
	}

	.tabs {
		display: flex;
		cursor: pointer;
	}

	.tab {
		padding: 10px 20px;
		border: 1px solid #ccc;
		border-bottom: none;
		background: #f4f4f4;
	}

	.tab.active {
		background: #fff;
		font-weight: bold;
	}

	.tab-content {
		display: none;
		padding: 20px;
		border: 2px solid #ccc;
	}

	.tab-content.active {
		display: block;
	}
</style>