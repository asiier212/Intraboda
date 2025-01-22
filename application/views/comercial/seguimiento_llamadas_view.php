  <h2>
        Seguimiento de LLamadas
    </h2>
<div class="main form">
  
	<fieldset class="datos">
    	<legend>LLamadas pendientes</legend>

        <?php if($llamadas_solicitudes) {
		?>
		   <table class="tabledata">
           		<tr>
                	<th style="width:160px"><a style="color:#FFF; text-decoration:underline" href="#">Próxima LLamada</a></th>

                    <th style="width:200px"><a style="color:#FFF; text-decoration:underline" href="#">Solicitud</a></th>
                    <th style="width:160px"><a style="color:#FFF; text-decoration:underline" href="#">Comercial</a></th>
					<th style="width:180px"><a style="color:#FFF; text-decoration:underline" href="#">Fecha Última LLamada</a></th>
                    <th style="width:100px"></th>
                </tr>
                <?php foreach($llamadas_solicitudes as $c) { 
				?>
                <tr>
                	<?php
                    $proxima_llamada = date_create($c['proxima_llamada']);
					?>
                	<td><?php echo date_format($proxima_llamada,"d-m-Y") ?></td>
                    <td><?php echo $c['solicitud'] ?></td>
                    <td><?php echo $c['comercial'] ?></td>
                    <td><?php echo $c['fecha_llamada'] ?></td>
                    <td><a href="<?php echo base_url() ?>comercial/solicitudes/view/<?php echo $c['id_solicitud'] ?>" target="_blank">Ver ficha</a></td>
                </tr>
                <?php } ?>
           </table>

           <?php } else {
			echo "No hay datos";   
		   }?>
           
        </fieldset>
       

        </div>
        <div class="clear">
        </div>