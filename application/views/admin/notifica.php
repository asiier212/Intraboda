<h2>Notificaciones</h2>

<!-- Aquí mostramos las notificaciones -->
<div id="notificaciones-lista">
    <?php if (isset($notificaciones) && !empty($notificaciones)): ?>
        <ul>
            <?php foreach ($notificaciones as $notificacion): ?>
                <li class="notificacion">
                    <div class="notificacion-content">
                        <p class="mensaje"><strong><?= $notificacion->mensaje ?></strong></p>
                        <p class="fecha"><small><?= date('d-m-Y H:i', strtotime($notificacion->fecha)) ?></small></p>
                    </div>
                    <!-- Enlace para borrar la notificación -->
                    <a href="javascript:void(0);" class="borrar-notificacion" data-id="<?= $notificacion->id ?>">Borrar</a>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No tienes nuevas notificaciones.</p>
    <?php endif; ?>
</div>

<script>
    let ultimoId = 0;

    // Función para verificar las notificaciones nuevas
    function verificarNotificaciones() {
        fetch(`<?= base_url('admin/notificaciones_ajax') ?>`)
            .then(res => res.json())
            .then(data => {
                if (data.length > 0) {
                    data.reverse().forEach(notif => {
                        if (notif.id > ultimoId) ultimoId = notif.id;
                        const lista = document.getElementById("notificaciones-lista");
                        const nuevoElemento = document.createElement("li");
                        nuevoElemento.innerHTML = `
						<p><strong>${notif.mensaje}</strong></p>
						<p><small>${notif.fecha}</small></p>
					`;
                        lista.insertBefore(nuevoElemento, lista.firstChild);
                    });
                    alert("Tienes una nueva notificación.");
                }
            });
    }

    // Verificar nuevas notificaciones cada 30 segundos
    setInterval(verificarNotificaciones, 30000); // cada 30 segundos

    document.querySelectorAll('.borrar-notificacion').forEach((element) => {
        element.addEventListener('click', function() {
            const idNotificacion = this.getAttribute('data-id');

            // Hacer la solicitud AJAX para eliminar la notificación
            fetch(`<?= base_url() . 'admin/borrar_notificacion' ?>`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: new URLSearchParams({
                        'id_notificacion': idNotificacion, // Pasar el ID como parámetro
                    }),
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Eliminar el elemento de la lista en el frontend
                        this.closest('li').remove();
                    } else {
                        alert('Error al borrar la notificación.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Hubo un problema al borrar la notificación.');
                });
        })
    });
</script>

<style>
    /* Estilo para la lista de notificaciones */
    #notificaciones-lista {
        width: 100%;
        padding: 20px;
        box-sizing: border-box;
        background-color: #f0f0f0;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    #notificaciones-lista ul {
        list-style-type: none;
        padding: 0;
        margin: 0;
    }

    #notificaciones-lista li.notificacion {
        background-color: #fff;
        border: 1px solid #ddd;
        border-radius: 8px;
        margin-bottom: 10px;
        padding: 15px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        transition: all 0.3s ease-in-out;
    }

    #notificaciones-lista li.notificacion:hover {
        transform: translateX(5px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .notificacion-content {
        max-width: 80%;
    }

    .mensaje {
        font-size: 16px;
        font-weight: bold;
        color: #333;
        margin-bottom: 5px;
    }

    .fecha {
        font-size: 12px;
        color: #777;
    }

    .borrar-notificacion {
        font-size: 12px;
        color: #e74c3c;
        text-decoration: none;
        background-color: transparent;
        border: none;
        cursor: pointer;
        transition: color 0.2s ease-in-out;
    }

    .borrar-notificacion:hover {
        color: #c0392b;
    }

    /* Estilo para el mensaje vacío de no notificaciones */
    #notificaciones-lista p {
        font-size: 14px;
        color: #666;
        text-align: center;
    }
</style>