<script type="text/javascript" src="<?php echo base_url() ?>js/jquery-ui-personalized-1.6rc4.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url() ?>js/jquery/development-bundle/ui/jquery.jeditable.js"></script>

 <script language="javascript">
$(document).ready(function() {
	 $('.edit_box').editable('<?php echo base_url() ?>index.php/ajax/updatedatocliente/<?php echo $cliente['id']?>', { 
         type      : 'text',
        submit    : '<img src="<?php echo base_url() ?>img/save.gif" />',
         tooltip   : 'Click para editar...',
     });
});
function deleteobservacion_admin(id){
	if (confirm("\u00BFSeguro que desea borrar la observaci\u00f3n?")) 
	{
		
		$.ajax({
			type: 'POST',   
			url: '<?php echo base_url() ?>index.php/ajax/deleteobservacion_admin', 
			data: 'id='+id, 
			success: function(data) {
					$("#o_" + id).css("display", "none");
					$("#result").html("");
				}
		});
	}
	return false
}

</script>
<style>
.editable img { float:right}
</style>
<h2>
        Datalles del cliente
    </h2>
<div class="main form">
    
<form method="post" enctype="multipart/form-data">
	<fieldset class="datos">
    	<legend>Datos de contacto</legend>
       
		<p style="float:left">Para editar los datos haz click sobre el texto</p>
         <p style="text-align:right"><a style="text-decoration:underline" target="_blank" href="<?php echo base_url() ?>/admin/clientes/initsession/<?php echo $cliente['id']?>">Iniciar Sesi&oacute;n en la cuenta del usuario</a></p>
        <br clear="left" />        
        <fieldset style="width:350px">
        	<legend>Datos del Novio</legend>
            <ul class="editable">
            	<li><label>Nombre:</label><span class="edit_box" id="nombre_novio"><?php echo $cliente['nombre_novio']?></span> </li>
                <li><label>Apellidos:</label><span class="edit_box" id="apellidos_novio"><?php echo $cliente['apellidos_novio']?></span></li>
                <li><label>Direcci&oacute;n:</label><span class="edit_box" id="direccion_novio"><?php echo $cliente['direccion_novio']?></span></li>
                <li><label>CP:</label><span class="edit_box" id="cp_novio"><?php echo $cliente['cp_novio']?></span></li>
                <li><label>Poblaci&oacute;n:</label><span class="edit_box" id="poblacion_novio"><?php echo $cliente['poblacion_novio']?></span></li>
                <li><label>Telefono:</label><span class="edit_box" id="telefono_novio"><?php echo $cliente['telefono_novio']?></span></li>
                <li><label>Email:</label><span class="edit_box" id="email_novio"><?php echo $cliente['email_novio']?></span></li>
            </ul>
        </fieldset>
         <fieldset style="width:350px">
        	<legend>Datos de la Novia</legend>
            <ul>
            	<li><label>Nombre:</label><span class="edit_box" id="nombre_novia"><?php echo $cliente['nombre_novia']?></span></li>
                <li><label>Apellidos:</label><span class="edit_box" id="apellidos_novia"><?php echo $cliente['apellidos_novia']?></span></li>
                <li><label>Direcci&oacute;n:</label><span class="edit_box" id="direccion_novia"><?php echo $cliente['direccion_novia']?></span></li>
                <li><label>CP:</label><span class="edit_box" id="cp_novia"><?php echo $cliente['cp_novia']?></span></li>
                <li><label>Poblaci&oacute;n:</label><span class="edit_box" id="poblacion_novia"><?php echo $cliente['poblacion_novia']?></span></li>
                <li><label>Telefono:</label><span class="edit_box" id="telefono_novia"><?php echo $cliente['telefono_novia']?></span></li>
                <li><label>Email:</label><span class="edit_box" id="email_novia"><?php echo $cliente['email_novia']?></span></li>
            </ul>
        </fieldset>
        <br class="clear" />
       

    </fieldset>
	<fieldset class="datos">
        	<legend>Datos de la boda</legend>
            <ul>
            	<li><label>Fecha de la boda:</label><span class="edit_box" id="fecha_boda"><?php echo $cliente['fecha_boda']?></span></li>
                <li><label>Hora de la boda:</label>
                <span class="edit_box" id="hora_boda"><?php echo $cliente['hora_boda']?></span></li>
                <li><label>Restaurante:</label><span class="edit_box" id="restaurante"><?php echo $cliente['restaurante']?></span></li>
                <li><label>Dirreci&oacute;n del Restaurante:</label><span class="edit_box" id="direccion_restaurante"><?php echo $cliente['direccion_restaurante']?></span></li>
                <li><label>Tel&eacute;fono del Restaurante:</label><span class="edit_box" id="telefono_restaurante"><?php echo $cliente['telefono_restaurante']?></span></li>
                <li><label>Maitre de la boda:</label><span class="edit_box" id="maitre"><?php echo $cliente['maitre']?></span></li>
                <li><label>Tel&eacute;fono Maitre:</label><span class="edit_box" id="telefono_maitre"><?php echo $cliente['telefono_maitre']?></span></li>
            </ul>
             
    </fieldset>
    <fieldset class="datos">
        	<legend>Servicios</legend>
            <ul>
            	<?php 
				$arr_serv_contr = explode(",", $cliente['servicios']);
				$total = 0;
				foreach($servicios as $servicio) {
					if(in_array($servicio['id'], $arr_serv_contr)) $total = $total + $servicio['precio'];
					?>
            	<li><input type="checkbox" name="servicios[]" <?php echo in_array($servicio['id'], $arr_serv_contr) ? 'checked="checked"' : ''?> value="<?php echo $servicio['id']?>" style="width:30px; vertical-align:middle" /><?php echo $servicio['nombre'] . " - ". $servicio['precio']?>&euro;</li>
                <?php }?>
                
             </ul>
             
             <input type="submit" name="update_servicios" value="Actualizar servicios" />
             <br /><br />
            Descuento: <input type="text" name="descuento" style="width:80px" value="<?php echo $cliente['descuento']?>" />&euro; &nbsp; <input type="submit" name="update_descuento" value="Actualizar descuento" />	
			 <br /><br />
              Total:
             <?php 
				if($cliente['descuento'] != '' && $cliente['descuento'] != '0' )
					echo $total . "&euro; - " . $cliente['descuento'] . "&euro; = " . ($total - $cliente['descuento']);
				else	
					echo $total;
				
				?>
               &euro;
    </fieldset>
    <fieldset>
    	<legend>Pagos, Presupuesto &amp; Contrato</legend>
        	
            <ul>
            	<li><strong>Presupuesto:</strong> <?php if($cliente['presupuesto_pdf'] != '') {?>
                <a href="<?php echo base_url() ?>uploads/pdf/<?php echo $cliente['presupuesto_pdf']?>">Descargar</a>
                <?php } else echo "No hay Presupuesto";?></li>
                <li style="padding:8px 0;"><label>Subir Presupuesto:</label> <input type="file" name="presupuesto" /> <input type="submit" name="add_presupuesto" value="Subir" /> </li>
                <li><strong>Contrato:</strong> <?php if($cliente['contrato_pdf'] != '') {?>
                <a href="<?php echo base_url() ?>uploads/pdf/<?php echo $cliente['contrato_pdf']?>">Descargar</a>
                <?php } else echo "No hay Contrato";?></li>
                <li style="padding:8px 0;"><label>Subir Contrato:</label> <input type="file" name="contrato" /> <input type="submit" name="add_contrato" value="Subir" /> </li>
                <li style="padding:8px 0;"><strong>Estado de Pagos</strong></li>
                
            <?php 
			$suma_pagos = 0;
			if(count($pagos) == 0)
				{ 
					echo "<li>A&uacute;n no se han hecho pagos</li>";
					echo '<li style="padding:8px 0;">Pago Inicial: <input type="text" name="valor"> <input type="submit" name="add_pago" value="Subir" /></li>';
				} else {
					foreach($pagos as $p) {
						$suma_pagos = $suma_pagos + $p['valor'];
						echo "<li style='padding:8px 0;'><strong>".$p['fecha']. " - " . number_format($p['valor'], 2)."</strong>&euro;</li>";
					}
					if(count($pagos) == 1)
					{
						echo '<li style="padding:8px 0;">Segundo pago: <input type="text" name="valor" value="'.number_format(($total / 2) - $suma_pagos,2).'"> <input type="submit" name="add_pago" value="Subir" /></li>';
					} else {
						echo '<li style="padding:8px 0;">Siguiente pago: <input type="text" name="valor" value="'.
						( $cliente['descuento'] != '' && $cliente['descuento'] != '0'  ?
							number_format($total-$suma_pagos-$cliente['descuento'], 2) : number_format($total-$suma_pagos, 2)).'"> <input type="submit" name="add_pago" value="Subir" /></li>';
					}
				}
				
				?>
                <li style="padding:8px 0;">Pendiente por pagar: <strong><?php 
				if($cliente['descuento'] != '' && $cliente['descuento'] != '0' )
					echo number_format(count($pagos) == 0 ? $total :  $total-$suma_pagos-$cliente['descuento'],2);
				else	
					echo number_format(count($pagos) == 0 ? $total :  $total-$suma_pagos,2);
				
				?></strong>&euro;</li>
            </ul>
           <?php if(isset($msg_pdf)) echo "<p>{$msg_pdf}</p>";?>
    </fieldset>
     <fieldset class="datos"> 
        <legend>Observaciones</legend>
        <?php 
        if(!$observaciones_cliente) 
	  echo '<p style="text-align:center;padding:20px">Todav&iacute;a no se ha a&ntilde;adido observaciones</p>';
	else {
	  echo "<ul class=\"observaciones obs_admin\">";
	
	  foreach($observaciones_cliente as $observacion) { ?>
	
	    <li id="o_<?php echo $observacion['id']?>"><?php echo $observacion['comentario']." (".$observacion['fecha'] ?>)
		<a href="#" onclick="return deleteobservacion_admin(<?php echo $observacion['id']?>)"><img src="<?php echo base_url() ?>img/delete.gif" width="15" /></a> 
		</li>
	 <?php }
	  
	  echo "</ul>";
	}
	
	  ?>
        <textarea name="observaciones" style="width:600px; height:100px; float:left"></textarea>
        
        <div style="padding:20px; text-align:center"><input type="submit" name="add_observ" value="Añadir"></div>
        <div style="text-align:center; clear: left; margin-top:20px"><?php if(isset($_POST['add_observ'])) echo "Se ha añdido con &eacute;xito";?></div>
     </fieldset>   
     <div class="clear"> </div>
     <fieldset class="datos"> 
        <legend>Listado personas de contacto</legend>
		   <ul>
            	<?php 
				if($personas){
				$arr_pers_contr = explode(",", $cliente['personas_contacto']);	
				foreach($personas as $p) { ?>
                <li style="display: block; float:left; padding:0 20px; text-align:center; height:360px">
               	<label for="p<?php echo $p['id']?>" style="float:none; text-align:center; width:auto">
				<?php if($p['foto'] != '') {?>
                	<img style="max-height:320px" src="<?php echo base_url() ?>uploads/personas_contacto/<?php echo $p['foto']?>"/>
                <?php }?>
                <br />
                <?php echo $p['tipo']?>
                <?php echo $p['nombre']?>
               </label>
               <input type="checkbox" name="personas_contacto[]" <?php echo in_array($p['id'], $arr_pers_contr) ? 'checked="checked"' : ''?> id="p<?php echo $p['id']?>" value="<?php echo $p['id']?>" style="width:30px" />
               
                </li>
              <?php }
				}?>
            </ul>
        	<p style="text-align:center; clear:left; padding-top:20px"><input type="submit" name="personas" value="Actualizar" /></p>
        </fieldset>
    <p style="text-align:center"></p>
</form>
        </div>
        <div class="clear">
        </div>