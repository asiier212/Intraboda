<h2>Listar Restaurantes</h2>
<div class="main form">
    <script language="javascript" type="application/javascript">
        function confirmar() {
            return confirm("¿Seguro que desea borrar el restaurante?");
        }
    </script>

    <fieldset class="datos">
        <legend>Restaurantes</legend>
        <input type="button" value="Añadir un nuevo restaurante" onClick="location.href='<?php echo base_url(); ?>admin/restaurantes/add'">
        <br><br>
        <form method="get" style="margin:10px 0">
            Buscador por: &nbsp;
            <select name="f">
                <option value="nombre" <?php if(isset($_GET['f']) && $_GET['f'] == 'nombre') echo 'selected="selected"'; ?>>Nombre</option>
                <option value="direccion" <?php if(isset($_GET['f']) && $_GET['f'] == 'direccion') echo 'selected="selected"'; ?>>Dirección</option>
                <option value="telefono" <?php if(isset($_GET['f']) && $_GET['f'] == 'telefono') echo 'selected="selected"'; ?>>Teléfono</option>
                <option value="maitre" <?php if(isset($_GET['f']) && $_GET['f'] == 'maitre') echo 'selected="selected"'; ?>>Maitre</option>
            </select>
            <input type="text" name="q" value="<?php echo isset($_GET['q']) ? $_GET['q'] : ''; ?>">
            <input type="submit" value="Buscar" style="margin-right:30px" />
            <a href="<?php echo base_url(); ?>admin/restaurantes/view">Limpiar buscador</a>
        </form>
        
        <?php if (!empty($restaurantes)) { 
            $url_ord = base_url() . "admin/restaurantes/view";
            if (isset($_GET['q'])) {
                $url_ord .= "?f=" . $_GET['f'] . "&q=" . $_GET['q'];
                if (isset($_GET['p'])) {
                    $url_ord .= "&p=" . $_GET['p'];
                }
                $url_ord .= "&ord=";
            } else {
                $url_ord .= "?ord=";
            }
        ?>
        
        <table class="tabledata">
            <tr>
                <th><a style="color:#FFF; text-decoration:underline" href="<?php echo $url_ord; ?>nombre">Nombre</a></th>
                <th><a style="color:#FFF; text-decoration:underline" href="<?php echo $url_ord; ?>direccion">Dirección</a></th>
                <th><a style="color:#FFF; text-decoration:underline" href="<?php echo $url_ord; ?>maitre">Maitre</a></th>
                <th><a style="color:#FFF; text-decoration:underline" href="<?php echo $url_ord; ?>telefono_maitre">Teléfono Maitre</a></th>
                <th><a style="color:#FFF; text-decoration:underline" href="<?php echo $url_ord; ?>hora_limite_fiesta">Hora límite de fiesta</a></th>
                <th style="width:220px"></th>
            </tr>
            
            <?php foreach ($restaurantes as $r) { ?>
            <tr>
                <td><?php echo $r['nombre']; ?></td>
                <td><?php echo $r['direccion']; ?></td>
                <td><?php echo $r['maitre']; ?></td>
                <td><?php echo $r['telefono_maitre']; ?></td>
                <td><?php echo $r['hora_limite_fiesta']; ?></td>
                <td>
                    <form method="post" onsubmit="return confirmar();">
                        <input type="hidden" name="id" value="<?php echo $r['id_restaurante']; ?>">
                        <input type="submit" name="delete_restaurante" value="Borrar" style="width:80px">
                        <span style="padding:0 15px">|</span>
                        <a href="<?php echo base_url(); ?>admin/restaurantes/view/<?php echo $r['id_restaurante']; ?>">Ver ficha</a>
                    </form>
                </td>
            </tr>
            <?php } ?>
        </table>
        
        <div class="pag">
        <?php
            $url_pag = base_url() . "admin/restaurantes/view?p=";
            if (isset($_GET['q'])) {
                $url_pag = base_url() . "admin/restaurantes/view?f=" . $_GET['f'] . "&q=" . $_GET['q'] . "&p=";
                if (isset($_GET['ord'])) {
                    $url_pag .= "&ord=" . $_GET['ord'];
                }
            }
        ?>
        
        <?php if ($num_rows > $rows_page) {
            if ($page > 1) { ?>
                <a class="pP" href="<?php echo $url_pag . ($page - 1); ?>" title="Página <?php echo $page - 1; ?>">&laquo; Anterior</a>
            <?php }
            for ($i = 1; $i <= $last_page; $i++) {
                if ($i == $page) { ?>
                    <a href="#" class="sel"><?php echo $i; ?></a>
                <?php } else { ?>
                    <a href="<?php echo $url_pag . $i; ?>" title="Página <?php echo $i; ?>"><?php echo $i; ?></a>
                <?php }
            }
            if ($page < $last_page) { ?>
                <a class="nP" href="<?php echo $url_pag . ($page + 1); ?>" title="Página <?php echo $page + 1; ?>">Siguiente &raquo;</a>
            <?php }
        } ?>
        </div>
        
        <?php } else {
            echo "No hay datos";
        } ?>
    </fieldset>
</div>
<div class="clear"></div>
