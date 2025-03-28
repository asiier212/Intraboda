<h2>Listado de Clientes</h2>
<div class="main form">

    <script language="javascript" type="application/javascript">
        function confirmar() {
            return confirm("¿Seguro que desea borrar el cliente?");
        }
    </script>

    <fieldset class="datos">
        <legend>Clientes</legend>

        <?php echo "ID de inicio de sesión: " . $this->session->userdata('restaurante_id');

        ?>

        <form method="get" style="margin:10px 0">
            Buscar por: &nbsp;
            <select name="f">
                <option value="nombre_novia" <?php if (isset($_GET['f']) && $_GET['f'] == 'nombre_novia') echo 'selected="selected"' ?>>Nombre novia</option>
                <option value="nombre_novio" <?php if (isset($_GET['f']) && $_GET['f'] == 'nombre_novio') echo 'selected="selected"' ?>>Nombre novio</option>
                <option value="apellidos_novia" <?php if (isset($_GET['f']) && $_GET['f'] == 'apellidos_novia') echo 'selected="selected"' ?>>Apellidos novia</option>
                <option value="apellidos_novio" <?php if (isset($_GET['f']) && $_GET['f'] == 'apellidos_novio') echo 'selected="selected"' ?>>Apellidos novio</option>
                <option value="poblacion_novia" <?php if (isset($_GET['f']) && $_GET['f'] == 'poblacion_novia') echo 'selected="selected"' ?>>Población novia</option>
                <option value="poblacion_novio" <?php if (isset($_GET['f']) && $_GET['f'] == 'poblacion_novio') echo 'selected="selected"' ?>>Población novio</option>
                <option value="fecha_boda" <?php if (isset($_GET['f']) && $_GET['f'] == 'fecha_boda') echo 'selected="selected"' ?>>Fecha boda (dd-mm-aaaa)</option>
            </select>
            <input type="text" name="q" value="<?php if (isset($_GET['q'])) echo $_GET['q'] ?>">
            <input type="submit" value="Buscar" style="margin-right:30px" />
            <a href="<?php echo base_url() ?>restaurante/clientes/view">Limpiar buscador</a>
        </form>

        <?php if ($clientes) {
            if (isset($_GET['q']) && !isset($_GET['p']))
                $url_ord = base_url() . "restaurante/clientes/view?f=" . $_GET['f'] . "&q=" . $_GET['q'] . "&ord=";
            elseif (isset($_GET['q']) && isset($_GET['p']))
                $url_ord = base_url() . "restaurante/clientes/view?f=" . $_GET['f'] . "&q=" . $_GET['q'] . "&p=" . $_GET['p'] . "&ord=";
            else
                $url_ord = base_url() . "restaurante/clientes/view?ord=";

        ?>

            <table class="tabledata">
                <tr>
                    <th>Foto perfil</th>
                    <th style="width:160px">
                        <a style="color:#FFF; text-decoration:underline" href="<?php echo $url_ord ?>nombre_novia">Novia</a> |
                        <a style="color:#FFF; text-decoration:underline" href="<?php echo $url_ord ?>nombre_novio">Novio</a>
                    </th>
                    <th><a style="color:#FFF; text-decoration:underline" href="<?php echo $url_ord ?>fecha_boda">Fecha boda</a></th>
                    <th><a style="color:#FFF; text-decoration:underline" href="<?php echo $url_ord ?>fecha">Fecha alta</a></th>
                    <th style="width:220px"></th>
                </tr>

                <?php foreach ($clientes as $c) {
                    if ($c['foto'] == '') $c['foto'] = "desconocido.jpg";
                ?>
                    <tr>
                        <td><img src="<?php echo base_url() ?>uploads/foto_perfil/<?php echo $c['foto'] ?>" width="100px" /></td>
                        <td><?php echo $c['nombre_novia'] . " & " . $c['nombre_novio'] ?></td>
                        <td><?php echo $c['fecha_boda'] ?></td>
                        <td><?php echo $c['fecha_alta'] ?></td>
                        <td>
                            <a href="<?php echo base_url() ?>restaurante/clientes/view/<?php echo $c['id'] ?>">Ver ficha</a>
                        </td>
                    </tr>
                <?php } ?>
            </table>

            <div class="pag">
                <?php
                if (isset($_GET['q']) && !isset($_GET['ord']))
                    $url_pag = base_url() . "restaurante/clientes/view?f=" . $_GET['f'] . "&q=" . $_GET['q'] . "&p=";
                elseif (isset($_GET['q']) && isset($_GET['ord']))
                    $url_pag = base_url() . "restaurante/clientes/view?f=" . $_GET['f'] . "&q=" . $_GET['q'] . "&ord=" . $_GET['ord'] . "&p=";
                else
                    $url_pag = base_url() . "restaurante/clientes/view?p=";

                if ($num_rows > $rows_page) {
                    if ($page > 2) {
                        echo '<a class="pP" href="' . $url_pag . ($page - 1) . '">&laquo; Anterior</a>';
                    }
                    if ($page == 2) {
                        echo '<a href="' . $url_pag . '1">&laquo; Anterior</a>';
                    }
                    if ($page > 3) {
                        echo '<a href="' . $url_pag . '1">1</a> ... ';
                    }
                    for ($i = $page - 2; $i <= $page + 2; $i++) {
                        if ($i == $page) {
                            echo '<a href="#" class="sel">' . $i . '</a> ';
                        } elseif ($i > 0 && $i <= $last_page) {
                            echo '<a href="' . $url_pag . $i . '">' . $i . '</a> ';
                        }
                    }
                    if ($i - 1 < $last_page) {
                        echo '... <a href="' . $url_pag . $last_page . '">' . $last_page . '</a>';
                    }
                    if ($page < $last_page) {
                        echo '<a class="nP" href="' . $url_pag . ($page + 1) . '">Siguiente &raquo;</a>';
                    }
                }
                ?>
            </div>

        <?php } else {
            echo "No hay datos.";
        } ?>
    </fieldset>

</div>
<div class="clear"></div>