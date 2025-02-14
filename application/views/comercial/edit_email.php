<h2>Editar emails</h2>

<fieldset>
    <legend>Editar Email</legend>
    <form action="<?php echo site_url('comercial/emails/edit/' . $email->id); ?>" method="post" enctype="multipart/form-data">

        <label for="asunto">Asunto:</label>
        <input type="text" name="asunto" id="asunto" value="<?php echo htmlspecialchars($email->asunto); ?>" required>
        <br><br>

        <label for="cuerpo">Cuerpo del Email:</label><br>
        <textarea style="width:1200px; height: 120px" name="cuerpo" id="cuerpo" required><?php echo htmlspecialchars($email->cuerpo); ?></textarea>
        <br><br>

        <label for="dias">Enviar después de (días):</label>
        <input type="number" name="dias" id="dias" min="1" value="<?php echo $email->dias; ?>" required>
        <br><br>

        <label for="firma">Firma (JPG opcional):</label>
        <input type="file" name="firma" id="firma" accept=".jpg">
        <br><br>

        <?php if (!empty($email->firma)): ?>
            <p>Firma actual:</p>
            <img src="<?php echo base_url().'uploads/comerciales/firmas/' . $email->firma; ?>" width="100" alt="Firma">
            <button onclick="borrarfirma()">Eliminar Firma</button>
        <?php endif; ?>
        <br><br>

        <button type="submit">Guardar Cambios</button>
    </form>
</fieldset>

<!--<script>
    function borrarfirma() {
        $email->firma = null;
    }
</script>-->