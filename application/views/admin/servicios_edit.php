<h2>
    Editar Servicio
</h2>
<div class="main form">

    <form method="post" enctype="multipart/form-data">
        <fieldset class="datos">
            <legend>Editar servicio</legend>
            <ul>
                <li>
                    <label>Nombre:</label>
                    <input type="text" name="nombre" style="width:300px" value="<?php echo $servicio['nombre'] ?>" />
                </li>
                <li>
                    <label>Precio:</label>
                    <input type="text" name="precio" value="<?php echo $servicio['precio'] ?>" />
                </li>
                <li>
                    <label>Precio oferta:</label>
                    <input type="text" name="precio_oferta" value="<?php echo $servicio['precio_oferta'] ?>" />
                </li>
                <li>
                    <label>Servicio adicional:</label>
                    <input type="checkbox" name="servicio_adicional" <?php if ($servicio['servicio_adicional'] == "S") echo 'checked'; ?> />
                </li>

                <li>
                    <label>Imagen:</label>

                    <?php if (!empty($servicio['imagen'])): ?>
                        <span style="margin-left: 10px;">
                            <img src="<?php echo base_url() . 'uploads/servicios/' . $servicio['imagen']; ?>" style="width: 40px; vertical-align: middle;" />
                            <button type="submit" name="delete_imagen" style="font-size: 1.5em; padding: 2px 6px; background: none; border: none; cursor: pointer;" title="Eliminar imagen">
                                ❌
                            </button>
                        </span>
                        <input type="hidden" name="imagen_actual" value="<?php echo htmlspecialchars($servicio['imagen']); ?>" />
                    <?php else: ?>
                        <input type="file" name="imagen" />
                    <?php endif; ?>
                </li>


                <li style="margin-top: 10px;">
                    <button type="submit" name="back" style="font-size: 2em; padding: 5px 10px; background: none; border: none; cursor: pointer; margin-left: 50px;" title="Volver">
                        ◀️
                    </button>

                    <button type="submit" name="delete" style="font-size: 2em; padding: 5px 10px; background: none; border: none; cursor: pointer;" title="Eliminar" onclick="return confirm('¿Estás seguro de que deseas eliminar este servicio?');">
                        ❌
                    </button>

                    <button type="submit" name="update" style="font-size: 2em; padding: 5px 10px; background: none; border: none; cursor: pointer;" title="Actualizar">
                        ✅
                    </button>
                </li>
            </ul>

        </fieldset>

    </form>
</div>
<div class="clear">
</div>