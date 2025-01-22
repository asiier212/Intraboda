<link rel="stylesheet" href="<?php echo base_url() ?>js/jquery1.10.4/themes/smoothness/jquery-ui.css">
<script src="<?php echo base_url() ?>js/jquery1.10.4/js/jquery-1.10.2.js"></script>
<script src="<?php echo base_url() ?>js/jquery1.10.4/js/jquery-ui-1.10.4.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery1.10.4/js/jquery.jeditable.js"></script>

<style>
.editable img { float:right}
</style>
<h2>
        Horas de los DJs
    </h2>
<div class="main form">
 

<form method="post">
	<fieldset class="datos">
    	<legend>Horas de los DJs</legend>
        <ul>
                <li><label>Año:</label>
                <?php
				$anio_actual=date("Y");
				?>
                <select name="anio" id="anio">
                	<option value="<?php echo $anio_actual?>"><?php echo $anio_actual?></option>
                	<?php
					for($i=$anio_actual-5;$i<=$anio_actual+5;$i++){
						?>
                        <option value="<?php echo $i?>"><?php echo $i?></option>
                        <?php
					}?>
                </select>
                <li><input type="submit" value="Filtrar" /></li>
            </ul>
            
            <br><br>
            
            <p><fieldset>
            <legend>Horas de los DJs en el año <?php echo $anio?></legend>                  		
            <table class="tabledata">
            <th>DJ</th>
            <th>Enero</th>
            <th>Febrero</th>
            <th>Marzo</th>
            <th>Abril</th>
            <th>Mayo</th>
            <th>Junio</th>
            <th>Julio</th>
            <th>Agosto</th>
            <th>Sept.</th>
            <th>Octubre</th>
            <th>Noviem.</th>
            <th>Diciem.</th>
            <th>TOTAL</th>
            <?php			
            foreach($djs as $dj){
				?>
                <tr>
				<td><?php echo $dj['nombre']?></td>
                <?php
				$total=0;
				if($horas_anuales_djs[0]<>""){
					for($mes=1;$mes<=12;$mes++){
						$h="";
						foreach($horas_anuales_djs as $horas){
							if($dj['id']==$horas['id_dj'] && $mes==$horas['mes']){
								$h=$horas['total_horas'];
							}
						}
						if($h<>""){
							?><td><?php echo number_format($h,2,",",".")?></td><?php
							$total=$total+$h;
							$h="";
						}else{
							?><td>0,00</td><?php
						}
					}
					?><td><?php echo number_format($total,2,",",".")?></td><?php
						$total=0;
				}
				?>
                </tr>
                <?php
			}
			
			?>
            </table>

        <br class="clear" />
    </fieldset>
    <p style="text-align:center"></p>
</form> 

</div>
<div class="clear">
</div>