
<h2>
        Partidas Presupuestarias
    </h2>
<div class="main form">
 

<form method="post">
	<fieldset class="datos">
    	<legend>Partidas</legend>
        	<ul>
            	<li><label>Desde:</label><input type="number" name="fecha_desde" id="fecha_desde" value="<?php echo $fecha_desde?>" /></li>
                <li><label>Hasta:</label><input type="number" name="fecha_hasta" id="fecha_hasta"  value="<?php echo $fecha_hasta?>"/></li>
                <li><input type="submit" value="Filtrar" /></li>
            </ul>
            
            <br><br>
       		
            <p><fieldset style="width:90%;">
            <legend>Partidas entre <?php echo $fecha_desde?> y <?php echo $fecha_hasta?></legend>
            
            <?php
			if($partidas[0]<>""){?>
				<table class="tabledata">
				<th>TOTAL</th>
				<tr>
					<?php
					$total=0;
					foreach($partidas as $p)
					{
							$total=$total+$p['importe'];
					}?>
					<td align="center"><?php echo number_format($total,2,",",".")?> &#8364;</td>
				</tr>
				</table>
				<br>
                <?php
			}?>
            
            <table class="tabledata">
            <th>Concepto</th>
            <th>Importe</th>
            <th>Año</th>
            <th>I. Restante</th>
            <th>I. Consumido</th>
            <th>Consumo</th>
            <th>Acción</th>
			<?php
			if($partidas[0]<>""){
				foreach($partidas as $p)
				{
					?>
					<tr>
					<td><?php echo $p['concepto']?></td>
                    <td><?php echo number_format($p['importe'],2,",",".")?> &#8364;</td>
                    <td><?php echo $p['año']?></td>
                    
					<?php
					$importe_consumido=0;
					if($partidas_ano[0]<>""){
						foreach($partidas_ano as $pa)
						{
							if(($pa['partida_presupuestaria']==$p['id_partida'])&&($pa['año']==$p['año'])){
								$importe_consumido=$importe_consumido+$pa['importe'];
							}
						}
					}
					$importe_restante=$p['importe']-$importe_consumido;
					$porcentaje_consumo=($importe_consumido*100)/$p['importe'];
					if($porcentaje_consumo>=0 && $porcentaje_consumo<=40){
						$color="#00b050";
						$color_letra="#000000";
					}elseif($porcentaje_consumo>=41 && $porcentaje_consumo<=70){
						$color="#ffff00";
						$color_letra="#000000";
					}else{
						$color="#ff0000";
						$color_letra="#ffffff";
					}
					?>
                    <td><?php echo number_format($importe_restante,2,",",".")?> &#8364;</td>
                    <td><?php echo number_format($importe_consumido,2,",",".")?> &#8364;</td>
    				<td style="background-color:<?php echo $color?>; color:<?php echo $color_letra?>;"><?php echo number_format($porcentaje_consumo,2,",",".")?>%</td>
                    <td><a href="<?php echo base_url() ?>admin/partidas_presupuestarias/view/<?php echo $p['id_partida'] ?>" target="_blank">Ver partida</a></td>
					</tr>
					<?php
				}
			}
            ?>
            </table>
            </fieldset></p>

        <br class="clear" />
    </fieldset>
    <p style="text-align:center"></p>
</form> 

</div>
<div class="clear">
</div>