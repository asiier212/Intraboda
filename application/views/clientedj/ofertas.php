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
	if (confirm("\u00BFSeguro que desea a\u00faadir el servicio a los servicios ya contratados? \n\t\t\tEl servicio se a\u00faadir\u00e1 a los pagos pendientes")) return true
	return false
}
</script>
 <h2>
        Ofertas Destacadas
    </h2>
    
<div class="main">
   
    <fieldset>
    	<legend>Servicios disponibles</legend>
        <form method="post" onsubmit="return confirmar()">
        	<ul class="ofertas">
            	<? if($servicios) {
					
					foreach($servicios as $s) {
						$is_oferta = 0;
						if($s['precio_oferta'] != '' && $s['precio_oferta'] != 0){
							$is_oferta = 1;
						}
						
				?>
            	<li><input class="servicio" type="checkbox" value="<?php echo $s['id']?>" alt="<?php echo $is_oferta == 1 ? $s['precio_oferta'] : $s['precio']?>" id="s_<?php echo $s['id']?>" name="servicios[]" />  <label for="s_<?php echo $s['id']?>">
				
				<div><?php echo $s['nombre']?> </div>
               	<div class="precio"><span style="color:#645D62">Precio:</span> <span <?php echo $is_oferta == 1 ? 'style="text-decoration:line-through"' : ''?> ><?php echo $s['precio']?> &euro;</span></div>
				
				<?php if($is_oferta == 1){ ?>
                	
                    <div class="oferta">
                    	<?php echo $s['precio_oferta'] ?>&euro;
                    </div>
				<?php

					}
					?>
                
				  </label></li>
                
				<?php }
				}?>
            </ul>
    <div class="carrito"> 
    	<span id="tota_titulo">Total Servicios A&ntilde;adidos</span>
    	<span id="total">0</span>  
        <input type="submit" name="submit" value="A&ntilde;adir" />
    </div>
    <div style="clear:both; text-align:center">
    <?php if(isset($msg)) echo '<p style="padding:5px">'.$msg.'</p>';?>
    	
    </div>
    </form>
    </fieldset>
    
 </div>
<div class="clear"></div>