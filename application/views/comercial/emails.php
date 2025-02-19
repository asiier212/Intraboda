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
        <textarea name="cuerpo" id="cuerpo"><?php echo htmlspecialchars_decode($email->cuerpo); ?></textarea>
        <br><br>

        <!-- Selección de método -->
        <label>
            <input type="radio" name="programar_opcion" value="fecha" checked> Programar con fecha
        </label>
        <br>
        <label>
            <input type="radio" name="programar_opcion" value="dias"> Programar en días
        </label>

        <br><br>

        <!-- Campo para ingresar la fecha -->
        <div id="fecha_container">
            <label for="fecha_envio">Selecciona una fecha:</label>
            <input type="date" name="fecha_envio" id="fecha_envio">
            <br><br>
        </div>

        <!-- Campo para ingresar la cantidad de días -->
        <div id="dias_container" style="display: none;">
            <label for="dias_envio">Enviar en (días):</label>
            <input type="number" name="dias_envio" id="dias_envio" min="1" placeholder="Ej: 3">
            <br><br>
        </div>


        <label for="email_prueba">Email de prueba:</label>
        <input type="text" name="email_prueba" id="email_prueba" value="<?php echo htmlspecialchars($email->email_prueba); ?>">
        <br><br>

        <label for="firma">Firma (JPG opcional):</label>
        <input type="file" name="firma" id="firma" accept=".jpg">
        <br><br>

        <button type="submit">Añadir</button>
    </form>
</fieldset>

<!-- Place the first <script> tag in your HTML's <head> -->
<script src="https://cdn.tiny.cloud/1/o6bdbfrosyztaa19zntejfp6e2chzykthzzh728vtdjokot2/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>

<!-- Place the following <script> and <textarea> tags your HTML's <body> -->
<script>
    tinymce.init({
        selector: 'textarea',
        plugins: [
            // Core editing features
            'anchor', 'autolink', 'charmap', 'codesample', 'emoticons', 'image', 'link', 'lists', 'media', 'searchreplace', 'table', 'visualblocks', 'wordcount',
            // Your account includes a free trial of TinyMCE premium features
            // Try the most popular premium features until Feb 28, 2025:
            'checklist', 'mediaembed', 'casechange', 'export', 'formatpainter', 'pageembed', 'a11ychecker', 'tinymcespellchecker', 'permanentpen', 'powerpaste', 'advtable', 'advcode', 'editimage', 'advtemplate', 'ai', 'mentions', 'tinycomments', 'tableofcontents', 'footnotes', 'mergetags', 'autocorrect', 'typography', 'inlinecss', 'markdown', 'importword', 'exportword', 'exportpdf'
        ],
        toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
        tinycomments_mode: 'embedded',
        tinycomments_author: 'Author name',
        mergetags_list: [{
                value: 'First.Name',
                title: 'First Name'
            },
            {
                value: 'Email',
                title: 'Email'
            },
        ],
        ai_request: (request, respondWith) => respondWith.string(() => Promise.reject('See docs to implement AI Assistant')),
    });

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

    document.addEventListener("DOMContentLoaded", function() {
        const fechaEnvio = document.getElementById("fecha_envio");
        const diasEnvio = document.getElementById("dias_envio");
        const fechaContainer = document.getElementById("fecha_container");
        const diasContainer = document.getElementById("dias_container");
        const radios = document.querySelectorAll('input[name="programar_opcion"]');

        radios.forEach(radio => {
            radio.addEventListener("change", function() {
                if (this.value === "fecha") {
                    fechaContainer.style.display = "block";
                    diasContainer.style.display = "none";
                    diasEnvio.value = "";
                } else {
                    fechaContainer.style.display = "none";
                    diasContainer.style.display = "block";
                    fechaEnvio.value = "";
                }
            });
        });

        diasEnvio.addEventListener("input", function() {
            if (this.value) {
                let hoy = new Date();
                hoy.setDate(hoy.getDate() + parseInt(this.value, 10));
                let fechaFormateada = hoy.toISOString().split('T')[0];
                fechaEnvio.value = fechaFormateada;
            }
        });
    });
</script>


<fieldset>
    <legend>Lista de Emails</legend>

    <?php if (!empty($emails)): ?>
        <div style="display: flex; flex-wrap: wrap; gap: 30px; justify-content: center;">
            <?php foreach ($emails as $email): ?>
                <div style="border: 1px solid #ccc; padding: 15px; border-radius: 5px; width: 350px; display: flex; flex-direction: column; gap: 10px;">

                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <h3 style="margin: 0; font-weight: bold; font-size: 18px"><?php echo htmlspecialchars($email->asunto); ?></h3>
                        <input type="checkbox" class="toggle-status" data-id="<?php echo $email->id; ?>" <?php echo $email->estado ? 'checked' : ''; ?>>
                    </div>

                    <p style="font-size: 14px; color: #555;">
                        <span class="email-preview"><?php echo htmlspecialchars(substr($email->cuerpo, 0, 100)); ?>...</span>
                        <span class="email-full" style="display: none;"><?php echo htmlspecialchars($email->cuerpo); ?></span>
                        <a href="#" class="toggle-email" style="color:rgb(116, 87, 247); font-size: 13px;cursor: pointer;">Mostrar más</a>
                    </p>

                    <div><strong>Programado para:</strong>
                        <?php if ($email->fecha_envio !== "0000-00-00" && !empty($email->fecha_envio)): ?>
                            <?php echo $email->fecha_envio; ?>
                        <?php else: ?>
                            <span>Sin fecha programada</span>
                        <?php endif; ?>
                    </div>


                    <div style="display: flex; align-items: center; gap: 7px">
                        <strong>Firma:</strong>
                        <?php if (!empty($email->firma)): ?>
                            <img src="<?php echo base_url() . "uploads/comerciales/firmas/" . $email->firma; ?>" alt="Firma" style="max-width: 80px; max-height:80px; border-radius: 5px;">
                        <?php else: ?>
                            <span>No tiene firma</span>
                        <?php endif; ?>
                    </div>

                    <div style="display: flex; align-items: center; gap: 7px">
                        <strong>Email de Prueba:</strong>
                        <?php if (!empty($email->email_prueba)): ?>
                            <span><?php echo htmlspecialchars($email->email_prueba); ?></span>
                        <?php else: ?>
                            <span>Sin email de prueba</span>
                        <?php endif; ?>
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
    function updateCardStyle(checkbox) {
        var card = checkbox.closest("div[style*='border: 1px solid']"); // Encuentra la tarjeta que lo contiene
        if (checkbox.checked) {
            card.style.backgroundColor = "#e6f7ff"; // Azul claro cuando está activo
            card.style.borderColor = "#007bff"; // Borde azul resaltado
            card.style.boxShadow = "0px 4px 8px rgba(0, 123, 255, 0.4)"; // Sombra azul
        } else {
            card.style.backgroundColor = "#fff"; // Fondo blanco cuando está desactivado
            card.style.borderColor = "#ccc"; // Borde gris
            card.style.boxShadow = "none"; // Sin sombra
        }
    }

    // Aplicar estilos al cargar la página según el estado inicial de los checkboxes
    document.querySelectorAll(".toggle-status").forEach(function(checkbox) {
        updateCardStyle(checkbox);
        checkbox.addEventListener("change", function() {
            updateCardStyle(this);
        });
    });

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