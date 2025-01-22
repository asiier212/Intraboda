<script type="text/javascript" src="<?php echo base_url() ?>js/jrating/jquery/jRating.jquery.js"></script>
<link rel="stylesheet" href="<?php echo base_url() ?>js/jrating/jquery/jRating.jquery.css" type="text/css" />

<link rel="stylesheet" href="<?php echo base_url() ?>js/jquery/development-bundle/themes/base/jquery.ui.all.css">
	
<script src="<?php echo base_url() ?>js/jquery/development-bundle/ui/jquery-ui-1.8.16.custom.min.js"></script>   
<script src="<?php echo base_url() ?>js/jquery/development-bundle/ui/jquery-ui-timepicker-addon.js"></script>
<script src="<?php echo base_url() ?>js/jquery/development-bundle/ui/jquery-ui-sliderAccess.js"></script>
        
<link rel="stylesheet" href="<?php echo base_url() ?>js/jquery/development-bundle/demos/demos.css">



        
<script type="text/javascript">
  $(document).ready(function(){
	$(".valoracion").jRating({
	  step: true,
	  type :'big', // type of the rate.. can be set to 'small' or 'big'
	  length : 10, // nb of stars
	  rateMax : 10, // número máximo de valoración
	  bigStarsPath : "<?php echo base_url() ?>js/jrating/jquery/icons/stars.png", //Path de las estrellas
	  canRateAgain : true,
	  nbRates : 1000,
	  sendRequest : true,
	  onClick : function(element,rate) {
         //alert(element.id);
		 document.getElementById("res"+element.id).value=rate;
	  }
	});
	$( "#calendar_inicio" ).timepicker({});
  });
</script>

   <h2>
        Informes
    </h2>
    
<div class="main form">
 
<form method="post">
	<fieldset class="datos">
    	<legend>Valoración satisfacción del DJ</legend>
		   <table class="tabledata">
           <tr>
           		<th>Pregunta</th>
            	<th>Respuesta</th>
           </tr>
                <?php
				$i=1;
				foreach($valoraciones as $valoracion) { ?>
                <tr>
                	<td><?php echo $valoracion['pregunta'] ?></td>                    
                    
                    
                    <?php
					if($valoracion['id_pregunta']=='5') //pregunta de checkbox
					{
						?>
                        <td align="left" style="margin:0">          
						<?php
						if($valoracion['respuesta']<>"")
						{
							//echo $valoracion['respuesta'];
							$arr_juegos_realizados = explode(",", $valoracion['respuesta']);
							foreach($juegos as $juego) { ?>
                                <input type="checkbox" name="juegos[]" <?php echo in_array($juego['id_juego'], $arr_juegos_realizados) ? 'checked="checked"' : ''?> value="<?php echo $juego['id_juego']?>" style="width:30px; vertical-align:middle" />
                                <?php echo $juego['juego']?><br />
                                <?php
							}
						}
						else
						{
							foreach($juegos as $juego) { ?>
								<input type="checkbox" name="juegos[]" id="j<?php echo $juego['id_juego']?>" value="<?php echo $juego['id_juego']?>"  style="width:30px" /><?php echo $juego['juego']?><br />
								<?php
							}
						}
						?>
                        </td>
                        <?php
                    } elseif($valoracion['id_pregunta']=='6'){
						?>
						<td><input type="text" name="hora_inicio" id="calendar_inicio" value="<?php echo $valoracion['respuesta']?>" style="width:60px"  /></td>
                        <?php
					}
					else
					{
						?>
                        <td>
                        <?php
						if($valoracion['respuesta']<>"")
						{
							?>                    
							<div class="valoracion" data-average="<?php echo $valoracion['respuesta']?>" id="<?php echo $i?>" data-id="<?php echo $i?>"></div>
							<input type="hidden" name="res<?php echo $i?>" id="res<?php echo $i?>" size="2" maxlength="2"  value="<?php echo $valoracion['respuesta']?>" />
							<?php
						}
						else
						{
							?>
							<div class="valoracion" data-average="0" id="<?php echo $i?>" data-id="<?php echo $i?>"></div>
							<input type="hidden" name="res<?php echo $i?>" id="res<?php echo $i?>" size="2" maxlength="2"  value="" />
							<?php
						}
						?>
                        </td>
						<?php
					}
					?>  
                	
                </tr>
                <?php
				$i++;
				} ?>
                <tr>
                	<td colspan="2" align="center"><input type="submit" name="valoraciones" value="Enviar valoraciones" /></td>
                </tr>
           </table>
        </fieldset>
        
        <fieldset class="datos">
    		<legend>Incidencias</legend>
            <table class="tabledata">
            <tr><?php
				foreach($incidencias as $incidencia) { ?>
                	
            		<td><textarea name="incidencia" rows="10" cols="100"><?php echo $incidencia['incidencia']?></textarea></td>
                <?php
				}
				?>
            </tr>
            <tr>
            	<td align="center"><input type="submit" name="incidencias" value="Enviar incidencias" /></td>
            </tr>
            </table>
        </fieldset>
        
        <fieldset class="datos">
    		<legend>Canciones</legend>
            <table class="tabledata">
            <tr><?php
				foreach($canciones_pendientes as $canciones_p) { ?>
                	
            		<td><textarea name="texto_canciones_pendientes" rows="10" cols="100"><?php echo $canciones_p['canciones']?></textarea></td>
                <?php
				}
				?>
            </tr>
            <tr>
            	<td align="center"><input type="submit" name="canciones" value="Enviar canciones" /></td>
            </tr>
            </table>
        </fieldset>
       
</form>
        </div>
        <div class="clear">
        </div>