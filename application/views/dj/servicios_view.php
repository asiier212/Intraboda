   <h2>
        Listar Servicios
    </h2>
    
<div class="main form">
 
	<fieldset class="datos">
    	<legend>Servicios</legend>
		   <table class="tabledata">
           		<tr>
                	<th style="width:400px">Nombre</th>
                </tr>
                <?php foreach($servicios as $servicio) { ?>
                <tr>
                	<td><?php echo $servicio['nombre'] ?></td>
                </tr>
                <?php } ?>
           </table>
        </fieldset>
       
</div>
<div class="clear">
</div>