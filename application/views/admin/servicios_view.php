<!-- jQuery -->
<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<!-- jQuery UI -->
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

<h2>Listar Servicios</h2>

<div class="main form">
    <form method="post" enctype="multipart/form-data">
        <fieldset class="datos">
            <legend>Nuevo Servicio</legend>
            <ul>
                <li><label>Nombre:</label><input type="text" name="nombre" style="width:300px" /> </li>
                <li><label>Precio:</label><input type="text" name="precio" /> </li>
                <li><label>Precio Oferta:</label><input type="text" name="precio_oferta" /> </li>
                <li><label>Servicio Adicional:</label><input type="checkbox" name="servicio_adicional" /> </li>
                <li><label>Imagen:</label><input type="file" name="imagen" /> </li>
                <li><label>&nbsp;</label><input type="submit" style="width:120px" value="A&ntilde;adir" /> </li>
            </ul>
        </fieldset>
        <fieldset class="datos">
            <legend>Servicios</legend>
            <p style="font-style: italic; color: gray;">Puedes arrastrar las filas para reordenarlas.</p>
            <table class="tabledata">
                <tr>
                    <th></th>
                    <th style="width:400px">Nombre</th>
                    <th>Precio</th>
                    <th>Oferta</th>
                    <th>Servicio adicional</th>
                    <th>Mostrar</th>
                    <th>Imagen</th>
                    <th></th>
                </tr>
                <?php if (isset($servicios) && is_array($servicios)) { ?>
                    <?php foreach ($servicios as $servicio) { ?>
                        <tr class="sortable-row" data-id="<?php echo $servicio['id']; ?>">
                            <td class="drag-handle">☰</td>
                            <td><?php echo htmlspecialchars($servicio['nombre']); ?></td>
                            <td><?php echo htmlspecialchars($servicio['precio']); ?></td>
                            <td><?php echo htmlspecialchars($servicio['precio_oferta']); ?></td>
                            <td><?php echo htmlspecialchars($servicio['servicio_adicional']); ?></td>
                            <td style="padding: 0px; text-align: center;">
                                <input type="checkbox" style="width: 13px" class="check_mostrar" data-id="<?php echo $servicio['id']; ?>"
                                    <?php echo isset($servicio['mostrar']) && $servicio['mostrar'] == 1 ? 'checked' : ''; ?> />
                            </td>
                            <td style="padding: 0px; text-align: center;">
                                <?php
                                $ruta = base_url() . 'uploads/servicios/' . $servicio['imagen'];
                                $archivo_local = FCPATH . 'uploads/servicios/' . $servicio['imagen'];

                                if (!empty($servicio['imagen']) && file_exists($archivo_local)) { ?>
                                    <a href="<?php echo $ruta; ?>" style="font-weight:bold; font-size: 12px; padding: 10px" target="_blank">Ver imagen</a>

                                <?php } else { ?>
                                    <span style="color: #888; font-size: 12px; padding: 10px">Sin imagen</span>
                                <?php } ?>
                            </td>

                            <td><a href="<?php echo base_url() ?>admin/servicios/edit/<?php echo $servicio['id']; ?>">Editar</a></td>
                        </tr>
                    <?php } ?>
                <?php } ?>
            </table>
        </fieldset>
    </form>
</div>
<div class="clear"></div>

<script>
    $(function() {
        $(".tabledata").sortable({
            items: ".sortable-row",
            handle: ".drag-handle",
            update: function(event, ui) {
                var order = [];
                $(".sortable-row").each(function(index, element) {
                    order.push({
                        id: $(element).data("id"),
                        orden: index + 1
                    });
                });
                $.ajax({
                    url: "<?php echo site_url('admin/actualizar_orden_servicios'); ?>",
                    method: "POST",
                    data: {
                        order: order
                    }
                });
            }
        }).disableSelection();

        $(document).ready(function() {
            $(".check_mostrar").change(function() {
                var servicioId = $(this).data("id");
                var mostrar = $(this).is(":checked") ? 1 : 0;

                $.ajax({
                    url: "<?php echo site_url('admin/actualizar_mostrar_servicio'); ?>",
                    method: "POST",
                    data: {
                        id: servicioId,
                        mostrar: mostrar
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.status === "success") {
                            console.log("Estado actualizado correctamente.");
                        } else {
                            alert("Error: " + response.message);
                        }
                    },
                    error: function() {
                        alert("Error en la solicitud AJAX.");
                    }
                });
            });
        });

    });
</script>

<style>
    .drag-handle {
        cursor: move;
    }
</style>