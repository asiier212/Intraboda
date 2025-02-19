<h2>Editar emails</h2>

<fieldset>
    <legend>Editar Email</legend>
    <form action="<?php echo site_url('comercial/emails/edit/' . $email->id); ?>" method="post" enctype="multipart/form-data">

        <label for="asunto">Asunto:</label>
        <input type="text" name="asunto" id="asunto" value="<?php echo htmlspecialchars($email->asunto); ?>" required>
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
            <input type="date" name="fecha_envio" id="fecha_envio" value="<?php echo htmlspecialchars($email->fecha_envio); ?>">
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

        <?php if (!empty($email->firma)): ?>
            <p>Firma actual:</p>
            <img src="<?php echo base_url() . 'uploads/comerciales/firmas/' . $email->firma; ?>" width="100" alt="Firma">
            <button class="btn-borrar-firma" data-id="<?= $email->id ?>">x</button>
            <br><br>
        <?php endif; ?>

        <button type="submit">Guardar Cambios</button>
    </form>
</fieldset>

<!-- Editor TinyMCE -->
<script src="https://cdn.tiny.cloud/1/o6bdbfrosyztaa19zntejfp6e2chzykthzzh728vtdjokot2/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    tinymce.init({
        selector: 'textarea',
        plugins: ['autolink', 'emoticons', 'link', 'lists', 'searchreplace', 'table', 'wordcount'],
        toolbar: 'undo redo | bold italic underline | link image media table | checklist numlist bullist | emoticons charmap | removeformat',
    });
</script>

<!-- Control de visibilidad de los campos -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        const fechaEnvio = $("#fecha_envio");
        const diasEnvio = $("#dias_envio");
        const fechaContainer = $("#fecha_container");
        const diasContainer = $("#dias_container");
        const radios = $("input[name='programar_opcion']");

        radios.change(function() {
            if ($(this).val() === "fecha") {
                fechaContainer.show();
                diasContainer.hide();
                diasEnvio.val("");
            } else {
                fechaContainer.hide();
                diasContainer.show();
                fechaEnvio.val("");
            }
        });

        diasEnvio.on("input", function() {
            if ($(this).val()) {
                let hoy = new Date();
                hoy.setDate(hoy.getDate() + parseInt($(this).val(), 10));
                let fechaFormateada = hoy.toISOString().split('T')[0];
                fechaEnvio.val(fechaFormateada);
            }
        });

        $(".btn-borrar-firma").click(function(event) {
            event.preventDefault();
            let id = $(this).data("id");

            $.ajax({
                url: "<?php echo site_url('comercial/borrarFirma'); ?>",
                type: "POST",
                data: {
                    id: id
                },
                dataType: "json",
                success: function(response) {
                    if (response.status === "success") {
                        location.reload();
                    } else {
                        alert("Error al eliminar la firma");
                    }
                }
            });
        });
    });
</script>