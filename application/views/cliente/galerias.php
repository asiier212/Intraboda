<h2>Galerías de fotos</h2>

<div class="main">
    <fieldset class="datos">
        <legend>Mis Galerías</legend>
        <ul>
            <?php if ($galerias): ?>
                <?php foreach ($galerias as $g): ?>
                    <li>
                        <label><strong><?php echo $g['nombre']; ?></strong></label>
                        <a href="<?php echo base_url(); ?>galeria/show/<?php echo $g['id']; ?>/<?php echo $g['auth_code']; ?>">Ver & Compartir</a> |
                        <a href="<?php echo base_url(); ?>cliente/galeria/<?php echo $g['id']; ?>">Gestionar fotos</a>
                    </li>
                <?php endforeach; ?>
            <?php else: ?>
                <li>Todavía no tienes ninguna galería</li>
            <?php endif; ?>
        </ul>
    </fieldset>

    <form method="post">
        <fieldset class="datos">
            <legend>Nueva Galería</legend>
            <ul>
                <li>
                    <label>Nombre:</label>
                    <input type="text" name="nombre" />
                    <input type="submit" style="width:100px; margin-left:10px" value="Añadir" />
                </li>
            </ul>
        </fieldset>
    </form>

    <!-- Desplegable con información -->
    <fieldset class="datos">
        <legend>Información</legend>

        <!-- Botón para desplegar información -->
        <div style="display: flex;">
            <a id="toggleLabel" style="cursor: pointer;">
                <span id="toggleArrow">▸</span> 📸 <strong>¿Cómo funciona la galería de fotos?</strong> 📸
            </a>


        </div>
        <!-- Contenido oculto por defecto -->
        <div id="infoText" style="display: none; padding-top: 10px;">
            <p>Súper fácil. Sirve para mostrar detalles clave del lugar de la boda y que nada nos pille por sorpresa.</p>

            <p>🔎 <strong>¿Qué tipo de fotos subir?</strong></p>
            <ul>
                <li>📍 <strong>Cambios recientes:</strong> (si han hecho obras que hayan modificado espacios).</li>
                <li>🔌 <strong>Tomas eléctricas:</strong> (para que el DJ no tenga que ir de explorador buscando enchufes).</li>
                <li>🌳 <strong>Ubicación en el jardín:</strong> (si la fiesta es al aire libre, mejor saber dónde nos colocamos).</li>
            </ul>

            <p>📌 <strong>Regla de oro de <span style="padding-left:3px; padding-right:3px; background-color: #93CE37;">IntraBoda</span>:</strong> ¡Aquí no dejamos nada al azar! Subid lo que creáis útil y nos aseguramos de que todo esté listo para que la música y la fiesta fluyan sin problemas. 🎶🎉</p>
        </div>
    </fieldset>
</div>

<div class="clear"></div>

<!-- Script para mostrar/ocultar información con cambio de icono y texto -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const toggleLabel = document.getElementById("toggleLabel");
        const toggleArrow = document.getElementById("toggleArrow");
        const infoText = document.getElementById("infoText");

        toggleLabel.addEventListener("click", function() {
            const isHidden = infoText.style.display === "none";
            infoText.style.display = isHidden ? "block" : "none";
            toggleArrow.innerHTML = isHidden ? "▾" : "▸";
        });
    });
</script>

<style>
    #toggleLabel {
    display: flex;
    align-items: center;
    gap: 8px; /* Espaciado entre la flecha y el texto */
}

#toggleArrow {
    font-size: 2.5em; /* Ajusta el tamaño si es necesario */
    line-height: 1; /* Asegura que no tenga espacio extra */
}

</style>