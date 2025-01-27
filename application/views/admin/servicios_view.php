<!-- jQuery -->
<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<!-- jQuery UI -->
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">


<h2>Listar Servicios</h2>

<div class="main form">

    <form method="post">
        <fieldset class="datos">
            <legend>Nuevo Servicio</legend>
            <ul>
                <li><label>Nombre:</label><input type="text" name="nombre" style="width:300px" /> </li>
                <li><label>Precio:</label><input type="text" name="precio" /> </li>
                <li><label>Precio Oferta:</label><input type="text" name="precio_oferta" /> </li>
                <li><label>Servicio Adicional:</label><input type="checkbox" name="servicio_adicional" /> </li>
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
                    <th></th>
                </tr>
                <?php foreach ($servicios as $servicio) { ?>
                    <tr class="sortable-row" data-id="<?php echo $servicio['id']; ?>">
                        <td class="drag-handle">☰</td>
                        <td><?php echo $servicio['nombre'] ?></td>
                        <td><?php echo $servicio['precio'] ?></td>
                        <td><?php echo $servicio['precio_oferta'] ?></td>
                        <td><?php echo $servicio['servicio_adicional'] ?></td>
                        <td><a href="<?php echo base_url() ?>admin/servicios/edit/<?php echo $servicio['id'] ?>">Editar</a></td>
                    </tr>
                <?php } ?>
            </table>
        </fieldset>

    </form>
</div>
<div class="clear">
</div>

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
                    url: "http://localhost/intraboda/admin/actualizar_orden_servicios",
                    method: "POST",
                    data: {
                        order: order
                    }
                });

            }
        }).disableSelection(); // Desactivar la selección de texto mientras se arrastra
    });
</script>

<style>
    .drag-handle {
        cursor: move;
    }