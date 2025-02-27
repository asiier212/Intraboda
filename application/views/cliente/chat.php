<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/style.css'); ?>">
<script language="javascript">
	function deletemensajechat(id) {
		if (confirm("\u00BFSeguro que desea borrar el mensaje del chat?\n")) {
			$.ajax({
				type: 'POST',
				url: '<?php echo base_url() ?>index.php/ajax/deletemensajechat',
				data: 'id=' + id,
				success: function(data) {
					location.href = '<?php echo base_url() ?>cliente/chat/';
				}
			});
		}
		return false
	}
</script>
<div class="page-content">
	<h2>
		Contactar
	</h2>

	<div class="contenedor_chat">
		<?php if ($mensajes_contacto) { ?>
			<?php foreach ($mensajes_contacto as $m) {
				$clase_bocadillo = '';
				$nombre_usuario = '';

				if ($m['usuario'] == 'administrador') {
					$clase_bocadillo = 'bocadillo_administrador';
					$nombre_usuario = "Coordinador";
				} elseif ($m['usuario'] == 'cliente') {
					$clase_bocadillo = 'bocadillo_usuario';
					$nombre_usuario = $this->session->userdata('nombre_novio') . ' y ' . $this->session->userdata('nombre_novia');
				} elseif ($m['usuario'] == 'dj') {
					$clase_bocadillo = 'bocadillo_dj';
					$nombre_usuario = $m['nombre_dj'];
				}
			?>

				<div class="bocadillo <?php echo $clase_bocadillo; ?>">
					<!-- Encabezado con usuario y botón eliminar -->
					<div class="bocadillo-header">
						<strong><?php echo $nombre_usuario; ?>:</strong>
						<?php if ($this->session->userdata('admin')) { ?>
							<span class="delete-btn" onclick="return deletemensajechat(<?php echo $m['id_mensaje'] ?>)">
								❌
							</span>
						<?php } ?>
					</div>

					<!-- Contenido del mensaje -->
					<p class="bocadillo-mensaje"><?php echo $m['mensaje']; ?></p>

					<!-- Pie con fecha y hora -->
					<div class="bocadillo-footer">
						<span class="bocadillo-fecha"><?php echo date("Y-m-d", strtotime($m['fecha'])); ?></span>
						<span class="bocadillo-hora"><?php echo date("H:i:s", strtotime($m['fecha'])); ?></span>
					</div>
				</div>

			<?php } ?>
		<?php } ?>


		<form method="post" enctype="multipart/form-data" class="text-content">
			<textarea name="mensaje" class="whatsapp-textarea" placeholder="Escribe un mensaje..."></textarea>
			<button type="submit" class="whatsapp-submit">➤</button>
		</form>
	</div>
	<br>
	<br>

	<div class="chat" style="display: flex; flex-direction: column; align-items: center; width: 100%;">
		<div id="infoTop">
			<h3>💬 ¿Cómo funciona el chat? 💬</h3>
			<a id="toggleInfo" class="btn-info">Más Info</a>
		</div>

		<div id="extraInfo" class="hidden">
			<p>Fácil, rápido y sin rodeos. Escribid cualquier duda que tengáis y vuestro coordinador o DJ (si ya está asignado) os responderá lo antes posible.</p>

			<h3>📩 ¿Y cómo sabéis que os hemos contestado?</h3>
			<p>Sencillo: en cuanto le echemos un ojo a vuestro mensaje y os respondamos, recibiréis una notificación en vuestro email.</p>

			<h3>📜 ¿Y qué pasa con la conversación?</h3>
			<p>Tranquilos, queda todo registrado para que nada se pierda y forme parte de la coordinación de vuestro gran día. <br><br>Así que escribid sin miedo. Que aquí estamos para hacer que la música y la fiesta sean perfectas. 🎶✨</p>
		</div>
	</div>
	<script>
		document.getElementById("toggleInfo").addEventListener("click", function() {
			var infoTop = document.getElementById("infoTop");
			infoTop.style.borderBottomLeftRadius = "0";
			infoTop.style.borderBottomRightRadius = "0";

			var info = document.getElementById("extraInfo");
			if (info.style.display === "none" || info.style.display === "") {
				info.style.display = "block";
				this.textContent = "Menos Info";
			} else {
				info.style.display = "none";
				this.textContent = "Más Info";
			}
		});
		document.addEventListener("DOMContentLoaded", function() {
    window.scrollTo({
        top: document.body.scrollHeight,
        behavior: "smooth" // Hace que el desplazamiento sea animado
    });
});

	</script>

</div>
<br>
<br>

<!-- TinyMCE -->
<script src="https://cdn.tiny.cloud/1/o6bdbfrosyztaa19zntejfp6e2chzykthzzh728vtdjokot2/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>

<script>
tinymce.init({
    selector: 'textarea.whatsapp-textarea',
    menubar: false,
    toolbar: 'bold italic',
    content_style: 'body { font-size: 16px; font-family: Arial, sans-serif; background: #ffffff;}',
    branding: false,
    width: '100%',
    height: 105, // Altura inicial
    min_height: 105, // Altura mínima
    max_height: 250, // Altura máxima antes de que aparezca el scrollbar
    autoresize_bottom_margin: 10, // Espacio extra antes de activar el scroll
    autoresize_on_init: true, // Se ajusta automáticamente al iniciar
    statusbar: false,
    plugins: 'autoresize', // Habilita el crecimiento automático
    autoresize_max_height: 250, // Altura máxima antes del scroll
    autoresize_min_height: 105, // Altura mínima inicial
});

</script>