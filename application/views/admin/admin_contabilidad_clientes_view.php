<link rel="stylesheet" href="<?php echo base_url() ?>js/jquery1.10.4/themes/smoothness/jquery-ui.css">
<script src="<?php echo base_url() ?>js/jquery1.10.4/js/jquery-1.10.2.js"></script>
<script src="<?php echo base_url() ?>js/jquery1.10.4/js/jquery-ui-1.10.4.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery1.10.4/js/jquery.jeditable.js"></script>

<script>
    $.datepicker.regional['es'] = {
        closeText: 'Cerrar',
        prevText: '<Ant',
        nextText: 'Sig>',
        currentText: 'Hoy',
        monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
        dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
        dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mié', 'Juv', 'Vie', 'Sáb'],
        dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sá'],
        weekHeader: 'Sm',
        //dateFormat: 'dd/mm/yy',
        dateFormat: 'yy-mm-dd',
        firstDay: 1,
        isRTL: false,
        showMonthAfterYear: false,
        yearSuffix: ''
    };
    $.datepicker.setDefaults($.datepicker.regional['es']);


    $(function() {
        $("#calendar_desde").datepicker();
        $("#calendar_hasta").datepicker();

    });
</script>



<style>
    .editable img {
        float: right
    }
</style>
<h2>
    Contabilidad Clientes
</h2>
<div class="main form">


    <form method="post">
        <fieldset class="datos">
            <legend>Contabilidad Clientes</legend>
            <ul>
                <li><label>Desde:</label><input type="text" name="fecha_desde" id="calendar_desde" value="<?php echo $fecha_desde ?>" /></li>
                <li><label>Hasta:</label><input type="text" name="fecha_hasta" id="calendar_hasta" value="<?php echo $fecha_hasta ?>" /></li>
                <li><label>Oficina:</label>
                    <select name="oficina" id="oficina">
                        <?php
                        foreach ($oficinas as $ofi) {
                        ?>
                            <option value="<?php echo $ofi['id_oficina'] ?>"><?php echo $ofi['nombre'] ?></option>
                        <?php
                        } ?>
                    </select>
                <li><input type="submit" value="Filtrar" /></li>
            </ul>

            <br><br>

            <p>
            <fieldset>
                <legend>Eventos Contratados entre <?php echo $fecha_desde ?> y <?php echo $fecha_hasta ?></legend>
                <table class="tabledata">
                    <tr>
                        <th colspan="3">TOTAL CONTABILIDAD</th>
                    </tr>
                    <tr>
                        <th></th>
                        <?php
                        foreach ($oficinas as $ofi) {
                            if ($ofi['id_oficina'] == $oficina) {
                        ?>
                                <th><?php echo $ofi['nombre'] ?></th>
                        <?php
                            }
                        } ?>
                        <th>Exel Eventos</th>
                    </tr>
                    <tr>
                        <?php
                        $total_oficina = 0;
                        $n_eventos_oficina = 0;
                        if ($contabilidad_clientes[0] <> "") {
                            foreach ($contabilidad_clientes as $conta) {
                                $total_cliente = 0;
                                $arr_servicios = unserialize($conta['servicios']);
                                $total_cliente = array_sum($arr_servicios);
                                $total_cliente = $total_cliente - $conta['descuento'];

                                $total_oficina = $total_oficina + $total_cliente;
                                $n_eventos_oficina++;
                            }
                        }
                        ?>
                        <th>Total</th>
                        <td align="center"><?php echo number_format($total_oficina, 2, ",", ".") ?></td>
                        <?php
                        $total_exel_eventos = 0;
                        $n_eventos_totales = 0;
                        if ($contabilidad_total[0] <> "") {
                            foreach ($contabilidad_total as $conta_total) {
                                $total_cliente = 0;
                                $arr_servicios = unserialize($conta_total['servicios']);
                                $total_cliente = array_sum($arr_servicios);
                                $total_cliente = $total_cliente - $conta_total['descuento'];

                                $total_exel_eventos = $total_exel_eventos + $total_cliente;
                                $n_eventos_totales++;
                            }
                        }
                        ?>
                        <td align="center"><?php echo number_format($total_exel_eventos, 2, ",", ".") ?></td>
                    </tr>

                    <?php
                    $total_ingreso_oficina = 0;
                    $total_pendiente_oficina = 0;
                    if ($contabilidad_clientes[0] <> "") {
                        foreach ($contabilidad_clientes as $conta) {
                            $total_ingreso_oficina = $total_ingreso_oficina + $conta['senal'] + $conta['50%'] + $conta['final'];
                        }
                    }
                    $total_pendiente_oficina = $total_oficina - $total_ingreso_oficina;

                    $total_ingreso = 0;
                    $total_pendiente = 0;
                    if ($contabilidad_total[0] <> "") {
                        foreach ($contabilidad_total as $conta_total) {
                            $total_ingreso = $total_ingreso + $conta_total['senal'] + $conta_total['50%'] + $conta_total['final'];
                        }
                    }
                    $total_pendiente = $total_exel_eventos - $total_ingreso;
                    ?>





                    <tr>
                        <th>Ingreso</th>
                        <td align="center"><?php echo number_format($total_ingreso_oficina, 2, ",", ".") ?></td>
                        <td align="center"><?php echo number_format($total_ingreso, 2, ",", ".") ?></td>
                    </tr>
                    <tr>
                        <th>Pendiente</th>
                        <td align="center"><?php echo number_format($total_pendiente_oficina, 2, ",", ".") ?></td>
                        <td align="center"><?php echo number_format($total_pendiente, 2, ",", ".") ?></td>
                    </tr>
                    <th>Nº Eventos</th>
                    <td align="center"><?php echo $n_eventos_oficina ?></td>
                    <td align="center"><?php echo $n_eventos_totales ?></td>
                    </tr>
                </table>
                </p>

                <table class="tabledata">
                    <th>Fecha</th>
                    <th>Nombre</th>
                    <th>Señal</th>
                    <th>Fecha Señal</th>
                    <th>50%</th>
                    <th>Fecha 50%</th>
                    <th>Final</th>
                    <th>Fecha Final</th>
                    <th>Total</th>
                    <th>Pendiente</th>
                    <th>Factura</th> <!-- ✅ Se mantiene la columna de Factura -->
                    <th>Acceso</th>

                    <?php
                    if ($contabilidad_clientes[0] <> "") {
                        foreach ($contabilidad_clientes as $conta) {
                    ?>
                            <tr>
                                <td><?php echo $conta['fecha_boda'] ?></td>
                                <td><?php echo $conta['nombre_novio'] ?> y <?php echo $conta['nombre_novia'] ?></td>

                                <td style="color:#00F; <?php echo ($conta['tipo_senal'] == "B") ? 'background-color:#C6F' : ''; ?>">
                                    <?php echo number_format($conta['senal'], 2, ",", ".") ?>
                                </td>
                                <td><?php echo $conta['fecha_senal'] ?></td>

                                <td style="color:#F90; <?php echo ($conta['tipo_50%'] == "B") ? 'background-color:#C6F' : ''; ?>">
                                    <?php echo number_format($conta['50%'], 2, ",", ".") ?>
                                </td>
                                <td><?php echo $conta['fecha_50%'] ?></td>

                                <td style="color:#F00; <?php echo ($conta['tipo_final'] == "B") ? 'background-color:#C6F' : ''; ?>">
                                    <?php echo number_format($conta['final'], 2, ",", ".") ?>
                                </td>
                                <td><?php echo $conta['fecha_final'] ?></td>

                                <?php
                                // Deserializar servicios
                                $arr_servicios = @unserialize($conta['servicios']);
                                $total_servicios = 0;
                                $descuento2 = 0;

                                if (is_array($arr_servicios)) {
                                    foreach ($arr_servicios as $servicio) {
                                        // Si es array con clave 'precio', lo sumamos
                                        if (is_array($servicio)) {
                                            $total_servicios += isset($servicio['precio']) ? floatval($servicio['precio']) : 0;
                                        }
                                        // Soporte para versiones antiguas (array plano de precios)
                                        else {
                                            $total_servicios += floatval($servicio);
                                        }
                                    }
                                }                  

                                // Descuento1 directo (puede no existir)
                                $descuento1 = isset($conta['descuento']) ? floatval($conta['descuento']) : 0;
                                $descuento2 = isset($conta['descuento2']) ? floatval($conta['descuento2']) : 0;


                                // Total después de aplicar ambos descuentos
                                $total_cliente = $total_servicios - $descuento1 - $descuento2;

                                // Pagos (defensivo)
                                $senal = isset($conta['senal']) ? floatval($conta['senal']) : 0;
                                $p50 = isset($conta['50%']) ? floatval($conta['50%']) : 0;
                                $final = isset($conta['final']) ? floatval($conta['final']) : 0;

                                // Calcular pendiente
                                $pendiente = $total_cliente - $senal - $p50 - $final;
                                ?>

                                <td><?php echo number_format($total_cliente, 2, ",", ".") ?></td>
                                <td><?php echo number_format($pendiente, 2, ",", ".") ?></td>


                                <!-- ✅ Mostrar enlace de la factura solo si existe -->
                                <td>
                                    <?php if (!empty($conta['factura'])) { ?>
                                        <a href="<?php echo base_url() . "uploads/facturas/" . urlencode(utf8_decode($conta['factura'])); ?>" target="_blank">Ver Factura</a>
                                    <?php } else { ?>
                                        Factura no disponible
                                    <?php } ?>
                                </td>

                                <td><a href="<?php echo base_url() ?>admin/clientes/view/<?php echo $conta['id'] ?>" target="_blank">Ver ficha</a></td>
                            </tr>
                    <?php
                        }
                    }
                    ?>
                </table>

            </fieldset>
            </p>

            <br class="clear" />
        </fieldset>
        <p style="text-align:center"></p>
    </form>

</div>
<div class="clear">
</div>