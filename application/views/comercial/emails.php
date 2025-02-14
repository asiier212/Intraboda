<h2>Emails</h2>
<!-- Botón para mostrar el formulario -->
<button id="toggleFormButton" style="margin-bottom: 20px; width: 180px; cursor: pointer;">
    Añadir Email
</button>

<!-- Fieldset Oculto por defecto -->
<fieldset id="addEmailFieldset" style="display: none;">
    <legend>Añadir Email</legend>
    <form action="<?php echo site_url('comercial/emails/add'); ?>" method="post" enctype="multipart/form-data">
        <input type="hidden" name="add" value="1"> <!-- Indica que se está agregando un email -->

        <label for="asunto">Asunto:</label>
        <input type="text" name="asunto" id="asunto" required>
        <br><br>

        <label for="cuerpo">Cuerpo del Email:</label><br>
        <textarea style="width:1200px; height: 120px" name="cuerpo" id="cuerpo" required><?php echo htmlspecialchars($email->cuerpo); ?></textarea>
        <br><br>

        <label for="dias">Enviar después de (días):</label>
        <input type="number" name="dias" id="dias" min="1" required>
        <br><br>

        <label for="firma">Firma (JPG opcional):</label>
        <input type="file" name="firma" id="firma" accept=".jpg">
        <br><br>

        <button type="submit">Añadir</button>
    </form>
</fieldset>

<script>
    document.getElementById("toggleFormButton").addEventListener("click", function() {
        var fieldset = document.getElementById("addEmailFieldset");
        if (fieldset.style.display === "none") {
            fieldset.style.display = "block";
            this.textContent = "Cerrar Formulario"; // Cambiar el texto del botón
        } else {
            fieldset.style.display = "none";
            this.textContent = "Añadir Email"; // Restaurar el texto original
        }
    });
</script>


<fieldset>
    <legend>Lista de Emails</legend>

    <?php if (!empty($emails)): ?>
        <div style="display: flex; flex-wrap: wrap; gap: 30px; justify-content: center;">
            <?php foreach ($emails as $email): ?>
                <div style="border: 1px solid #ccc; padding: 15px; border-radius: 5px; width: 350px; display: flex; flex-direction: column; gap: 10px;">

                    <h3 style="margin: 0;"><?php echo htmlspecialchars($email->asunto); ?></h3>

                    <p style="font-size: 14px; color: #555;">
                        <span class="email-preview"><?php echo htmlspecialchars(substr($email->cuerpo, 0, 100)); ?>...</span>
                        <span class="email-full" style="display: none;"><?php echo htmlspecialchars($email->cuerpo); ?></span>
                        <a href="#" class="toggle-email" style="color:rgb(116, 87, 247); font-size: 13px;cursor: pointer;">Mostrar más</a>
                    </p>

                    <div><strong>Enviar en:</strong> <?php echo $email->dias; ?> días</div>

                    <div style="display: flex; align-items: center; gap: 7px">
                        <strong>Firma:</strong>
                        <?php if (!empty($email->firma)): ?>
                            <img src="<?php echo base_url() . "uploads/comerciales/firmas/" . $email->firma; ?>" alt="Firma" style="max-width: 80px; max-height:80px; border-radius: 5px;">
                        <?php else: ?>
                            <span>No tiene firma</span>
                        <?php endif; ?>
                    </div>

                    <div style="display: flex; align-items: center; gap: 7px">
                        <strong>Activar:</strong>
                        <input type="checkbox" class="toggle-status" data-id="<?php echo $email->id; ?>" <?php echo $email->estado ? 'checked' : ''; ?>>
                    </div>

                    <div style="display: flex; justify-content: space-between;">
                        <a href="<?php echo site_url('comercial/emails/edit/' . $email->id); ?>" style="color: blue;" onmouseover="this.style.fontWeight='bold';" onmouseout="this.style.fontWeight='normal';">Editar</a>
                        <a href="#" class="preview-email"
                            data-asunto="<?php echo htmlspecialchars($email->asunto); ?>"
                            data-cuerpo="<?php echo htmlspecialchars($email->cuerpo); ?>"
                            data-firma="<?php echo !empty($email->firma) ? base_url() . "uploads/comerciales/firmas/" . $email->firma : ''; ?>"
                            style="color: green;">
                            Vista Previa
                        </a>
                        <a href="<?php echo site_url('comercial/emails/delete/' . $email->id); ?>" onclick="return confirm('¿Seguro que quieres eliminar este email?');" style="color: red;" onmouseover="this.style.fontWeight='bold';" onmouseout="this.style.fontWeight='normal';">Eliminar</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p>No hay emails automáticos creados aún.</p>
    <?php endif; ?>
</fieldset>

<!-- Modal para la Vista Previa -->
<div id="previewModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); justify-content: center; align-items: center;">
    <div style="background: white; padding: 20px; border-radius: 5px; width: 60%; max-height: 80vh; overflow-y: auto; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2); position: relative;">

        <span onclick="document.getElementById('previewModal').style.display='none'"
            style="position: absolute; top: 12px; right: 15px; font-size: 22px; font-weight: bold; cursor: pointer; 
    background: #d9534f; color: white; padding: 6px 12px; border-radius: 50%; transition: 0.2s; display: flex; 
    align-items: center; justify-content: center;">
            ✖
        </span>

        <!-- Asunto del Email con Estilo Mejorado -->
        <div style="background: #f2f2f2; padding: 15px; font-family: Arial, sans-serif; font-size: 18px; font-weight: bold; border-radius: 5px; text-align: center; color: #333; margin-bottom: 15px;">
            <span id="previewAsunto"></span>
        </div>

        <!-- Contenido del Email -->
        <div id="previewCuerpo" style="border-top: 1px solid #ccc; margin-top: 10px; padding-top: 10px; font-family: Arial, sans-serif; font-size: 16px; color: #444; line-height: 1.6;"></div>
        <div id="previewFirma" style="margin-top: 20px; text-align: center;"></div>
    </div>
</div>



<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Mostrar más / menos contenido
        document.querySelectorAll(".toggle-email").forEach(function(btn) {
            btn.addEventListener("click", function(event) {
                event.preventDefault();
                var preview = this.previousElementSibling.previousElementSibling;
                var fullText = this.previousElementSibling;

                if (fullText.style.display === "none") {
                    fullText.style.display = "inline";
                    preview.style.display = "none";
                    this.textContent = "Mostrar menos";
                } else {
                    fullText.style.display = "none";
                    preview.style.display = "inline";
                    this.textContent = "Mostrar más";
                }
            });
        });

        // Activar / desactivar email
        document.querySelectorAll(".toggle-status").forEach(function(checkbox) {
            checkbox.addEventListener("change", function() {
                var emailId = this.getAttribute("data-id");
                var newStatus = this.checked ? 1 : 0;

                var formData = new FormData();
                formData.append("id", emailId);
                formData.append("estado", newStatus);

                fetch("<?php echo site_url('comercial/update_email_status'); ?>", {
                        method: "POST",
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (!data.success) {
                            alert("Error al actualizar el estado del email.");
                            this.checked = !this.checked;
                        }
                    })
                    .catch(error => {
                        console.error("Error:", error);
                        alert("Error de conexión.");
                        this.checked = !this.checked;
                    });
            });
        });

        // Vista Previa del Email en un Modal
        document.querySelectorAll(".preview-email").forEach(function(btn) {
            btn.addEventListener("click", function(event) {
                event.preventDefault();
                var asunto = this.getAttribute("data-asunto");
                var cuerpo = this.getAttribute("data-cuerpo");
                var firma = this.getAttribute("data-firma");

                document.getElementById("previewAsunto").innerText = asunto;
                document.getElementById("previewCuerpo").innerHTML = cuerpo;

                if (firma && firma !== "null" && firma.trim() !== "") {
                    document.getElementById("previewFirma").innerHTML =
                        '<img src="' + firma + '" alt="Firma" style="max-width: 150px; max-height:100px; border-radius: 5px;">';
                } else {
                    document.getElementById("previewFirma").innerHTML = "";
                }

                document.getElementById("previewModal").style.display = "flex";
            });
        });

    });
</script>