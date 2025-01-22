  <h2>
        Bienvenid@!
    </h2>
<div class="main">

<fieldset class="datos">
	<legend>Canciones más elegidas</legend>
    <?php
	$numero_canciones=10;
	
	if($momentos_especiales){
		foreach($momentos_especiales as $m){
			?>
            <fieldset class="datos">
            	<legend><?php echo $m['momento']?></legend>
                <?php
				if($canciones_mas_elegidas){
					$posicion=1;
					$contador=1;
					?>
                    <table border="0" width="600px" class="tabledata">
                    <th align="center">&nbsp;</th>
                    <th align="center">Canción</th>
                    <th align="center">Veces</th>
                    <?php
					/*foreach($canciones_mas_elegidas as $c){
						if($m['id_momento']==$c[0]){
							?>
                            <tr>
                            <td align="center"><?php echo $posicion?></td>
                            <td align="center"><?php echo $c[1]." - ".$c[2]?></td>
                            <td align="center"><?php echo $c[3]?></td>
                            </tr>
							<?php
							$contador++;
							$posicion++;
							if($contador>$numero_canciones)
							{
								$posicion=1;
								$contador=1;
								break 1;
							}
						}
					}*/
					
                    foreach($canciones_mas_elegidas as $c){
						if($m['id_momento']==$c[0]){
							?>
                        	<tr>
                            <td align="center"><?php echo $posicion?></td>
                            <td align="center"><?php echo $c[1]." - ".$c[2]?></td>
                            <td align="center"><?php echo $c[3]?></td>
                            </tr>
                            <?php
							$contador++;
							$posicion++;
							if($contador>$numero_canciones)
							{
								$posicion=1;
								$contador=1;
								break 1;
							}
                         }
                    }
					?>
                    </table>
                    <?php
				}
				?>
            </fieldset><div style="clear:both">
            <?php
		}
	}
	
    
    ?>
</fieldset>
  
 </div>
<div class="clear"></div>