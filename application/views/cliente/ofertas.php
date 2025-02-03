<script type="text/javascript">
$(function() {
    $('.servicio').change(function() {
        var total = 0;						   
        $('.servicio:checked').each(function(index) {
            total = total + parseInt($(this).attr('alt'));
        });
        $('#total').html(total + "&euro;");  
    });	   
});	

function confirmar() {
    if (confirm("\u00BFSeguro que desea a\u00f1adir el servicio a los servicios ya contratados? \n\t\t\tEl servicio se a\u00f1adir\u00e1 a los pagos pendientes")){
        return true;
    }
    else{
        return false;
    }
}
</script>

<h2>Ofertas Destacadas</h2>

<div class="main">
    <fieldset>
        <legend>Servicios disponibles</legend>
        <form method="post" onsubmit="return confirmar()">
            <ul class="ofertas">
                <?php 
                
                if (!empty($servicios)) {
                    $hay_ofertas = false; // Variable para verificar si hay ofertas visibles
                    foreach ($servicios as $s) {
                        if (!isset($s['mostrar']) || $s['mostrar'] != 1) {
                            continue; // Omitir si mostrar no es 1
                        }
                        $hay_ofertas = true;
                        $is_oferta = (!empty($s['precio_oferta']) && $s['precio_oferta'] != 0) ? 1 : 0;
                ?>
                <li>
                    <input class="servicio" type="checkbox" value="<?php echo htmlspecialchars($s['id']); ?>" 
                        alt="<?php echo htmlspecialchars($is_oferta == 1 ? $s['precio_oferta'] : $s['precio']); ?>" 
                        id="s_<?php echo htmlspecialchars($s['id']); ?>" name="servicios[]" />
                    <label for="s_<?php echo htmlspecialchars($s['id']); ?>">
                        <div><?php echo htmlspecialchars($s['nombre']); ?> </div>
                        <div class="precio">
                            <span style="color:#645D62">Precio:</span>
                            <span <?php echo $is_oferta == 1 ? 'style="text-decoration:line-through"' : ''; ?>>
                                <?php echo htmlspecialchars($s['precio']); ?> &euro;
                            </span>
                        </div>
                        <?php if ($is_oferta == 1) { ?>
                        <div class="oferta">
                            <?php echo htmlspecialchars($s['precio_oferta']); ?>&euro;
                        </div>
                        <?php } ?>
                    </label>
                </li>
                <?php 
                    }
                    if (!$hay_ofertas) {
                        echo "<p>No hay ofertas disponibles en este momento.</p>";
                    }
                } else {
                    echo "<p>No hay ofertas disponibles en este momento.</p>";
                }
                ?>
            </ul>
            <div class="carrito"> 
                <span id="tota_titulo">Total Servicios A&ntilde;adidos</span>
                <span id="total">0</span>  
                <input type="submit" name="submit" value="A&ntilde;adir" />
            </div>
            <div style="clear:both; text-align:center">
                <?php if(isset($msg)) echo '<p style="padding:5px">'.htmlspecialchars($msg).'</p>';?>
            </div>
        </form>
    </fieldset>
</div>
<div class="clear"></div>
