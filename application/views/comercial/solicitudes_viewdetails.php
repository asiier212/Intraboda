
    <script type="text/javascript" src="<?php echo base_url() ?>js/jquery/development-bundle/ui/jquery.jeditable.js"></script>
<script src="<?php echo base_url() ?>js/jquery1.10.4/js/jquery-ui-1.10.4.js"></script>
<link rel="stylesheet" href="<?php echo base_url() ?>js/jquery1.10.4/themes/smoothness/jquery-ui.css">
<script src="<?php echo base_url() ?>js/jquery/development-bundle/ui/jquery-ui-timepicker-addon.js"></script>
<script>
	$(function() {
		$( "#fecha_prox_llamada" ).datepicker();	
	});
	
	</script>

 <script language="javascript">
$(document).ready(function() {
	 $('.edit_box').editable('<?php echo base_url() ?>index.php/ajax/updatedatosolicitud/<?php echo $solicitud['id_solicitud']?>', { 
         type      : 'text',
        submit    : '<img src="<?php echo base_url() ?>img/save.gif" />',
         tooltip   : 'Click para editar...',
     });
});
$(document).ready(function() 
	{
		$('.pestana').hide().eq(0).show();
		$('.tabs li').click(function(e)
		{
			e.preventDefault();
			$('.pestana').hide();
			$('.tabs li').removeClass("selected");
			var id = $(this).find("a").attr("href");
			$(id).fadeToggle();
			$(this).addClass("selected");
		});
	});
function deleteobservacion_solicitud(id){
	if (confirm("\u00BFSeguro que desea borrar la observaci\u00f3n?")) 
	{
		
		$.ajax({
			type: 'POST',   
			url: '<?php echo base_url() ?>index.php/ajax/deleteobservacion_solicitud', 
			data: 'id='+id, 
			success: function(data) {
					$("#o_" + id).css("display", "none");
					$("#result").html("");
				}
		});
	}
	return false
}

function deletepresupuesto_solicitud(id){
	if (confirm("\u00BFSeguro que desea borrar el presupuesto?")) 
	{
		
		$.ajax({
			type: 'POST',   
			url: '<?php echo base_url() ?>index.php/ajax/deletepresupuesto_solicitud', 
			data: 'id='+id, 
			success: function(data) {
					//$("#o_" + id).css("display", "none");
					//$("#result").html("");
					location.href= '<?php echo base_url() ?>comercial/solicitudes/view/'+id;
				}
		});
	}
	return false
}

function deletellamada(id, id_llamada){
	if (confirm("\u00BFSeguro que desea borrar este seguimiento de llamada?")) 
	{
		
		$.ajax({
			type: 'POST',   
			url: '<?php echo base_url() ?>index.php/ajax/deletellamada_solicitud', 
			data: 'id_llamada='+id_llamada, 
			success: function(data) {
					//$("#o_" + id).css("display", "none");
					//$("#result").html("");
					location.href= '<?php echo base_url() ?>comercial/solicitudes/view/'+id;
				}
		});
	}
	return false
}

function enviar_encuesta(){
	if (confirm("\u00BFSeguro que desea mandar el e-mail para realizar la encuesta?")) 
	{
		document.getElementById('mandar_encuesta').value='S';
		document.getElementById('formulario').submit();
		return false;
	}
}

</script>

<link href="<?php echo base_url() ?>css/pestanas.css" rel="stylesheet" type="text/css" />
    
<h2>
        Detalles de la solicitud
    </h2>
<div class="main form">
<br><br>

<form method="post" enctype="multipart/form-data" id="formulario">
   
<ul class="tabs">
		<li class="selected"><a href="#tab-1">Datos de la solicitud</a></li>
		<li><a href="#tab-2">Seguimiento de llamadas</a></li>
	</ul>
	<div class="pestana" id="tab-1">
	<fieldset class="datos">
    	<legend>Datos del contacto</legend>
            <ul class="editable">
            	<li><label>Número de presupuesto:</label><span class="edit_box" id="n_presupuesto"><?php echo $solicitud['n_presupuesto']?></span> </li>
            	<li><label>Nombre:</label><span class="edit_box" id="nombre"><?php echo $solicitud['nombre']?></span> </li>
                <li><label>Apellidos:</label><span class="edit_box" id="apellidos"><?php echo $solicitud['apellidos']?></span></li>
                <li><label>Direcci&oacute;n:</label><span class="edit_box" id="direccion"><?php echo $solicitud['direccion']?></span></li>
                <li><label>CP:</label><span class="edit_box" id="cp"><?php echo $solicitud['cp']?></span></li>
                <li><label>Poblaci&oacute;n:</label><span class="edit_box" id="poblacion"><?php echo $solicitud['poblacion']?></span></li>
                <li><label>Telefono:</label><span class="edit_box" id="telefono"><?php echo $solicitud['telefono']?></span></li>
                <li><label>Email:</label><span class="edit_box" id="email"><?php echo $solicitud['email']?></span></li>
                <?php
				if($solicitud['presupuesto_pdf'])
				{
					?>
                	<li><label>Presupuesto:</label><a href="<?php echo base_url() ?>uploads/presupuestos_solicitudes/<?php echo $solicitud['presupuesto_pdf']?>" target="_blank"><?php echo $solicitud['presupuesto_pdf']?></a> <a href="#" onclick="return deletepresupuesto_solicitud(<?php echo $solicitud['id_solicitud']?>)"><img src="<?php echo base_url() ?>img/cancel.gif" width="15" /></a></li>
                    <?php
				}
				else
				{
					?>
                	<li><label>Presupuesto:</label><input type="file" name="presupuesto_pdf" id="presupuesto_pdf"><input type="submit" id="anadir_presupuesto" name="anadir_presupuesto" value="A&ntilde;adir" style="width:65px;"></li>
                    <?php
				}
				?>
                
                <li><label>Importe:</label><span class="edit_box" id="importe"><?php echo $solicitud['importe']?></span></li>
                <li><label>Descuento:</label><span class="edit_box" id="descuento"><?php echo $solicitud['descuento']?></span></li>
            </ul>
        
    
        <br class="clear" />
       (*)Canal de captaci&oacute;n: <select name="canal_captacion">
       							<?php
								foreach($captacion as $capta) {
									if($capta['id']==$solicitud['canal_captacion'])
									{?>
                                		<option value="<?php echo $capta['id']?>"><?php echo $capta['nombre']?></option>
                                        <?php
									}
                                }?>
                                <option value=""></option>
                                <?php
                                foreach($captacion as $capta) {
									?>
                                		<option value="<?php echo $capta['id']?>"><?php echo $capta['nombre']?></option>
                                        <?php
									}
								?>
                                </select>
                                <input type="submit" name="update_canal_captacion" value="Cambiar canal de captación" />
                                
        <br class="clear" /> <br class="clear" />
       (*)Estado Solicitud: <select name="estado_solicitud">
       							<?php
								foreach($estados_solicitudes as $estado) {
									if($estado['id_estado']==$solicitud['estado_solicitud'])
									{?>
                                		<option value="<?php echo $estado['id_estado']?>"><?php echo $estado['nombre_estado']?></option>
                                        <?php
									}
                                }?>
                                <option value=""></option>
                                <?php
                                foreach($estados_solicitudes as $estado) {
									?>
                                		<option value="<?php echo $estado['id_estado']?>"><?php echo $estado['nombre_estado']?></option>
                                        <?php
									}
								?>
                                </select>
                                <input type="submit" name="update_estado_solicitud" value="Cambiar estado solicitud" />
        </fieldset>




	<fieldset class="datos">
        	<legend>Datos de la boda</legend>
            <ul>
            	<li><label>Fecha de la boda:</label><span class="edit_box" id="fecha_boda"><?php echo $solicitud['fecha_boda']?></span></li>
                <li><label>Hora de la boda:</label>
                <span class="edit_box" id="hora_boda"><?php echo $solicitud['hora_boda']?></span></li>
                <li><label>Restaurante:</label><span class="edit_box" id="restaurante"><?php echo $solicitud['restaurante']?></span></li>
            </ul>                
     </fieldset>
     <fieldset class="datos"> 
        <legend>Observaciones</legend>
        <?php 
        if(!$observaciones_solicitud) 
	  echo '<p style="text-align:center;padding:20px">Todav&iacute;a no se ha a&ntilde;adido observaciones</p>';
	else {
	  echo "<ul class=\"observaciones obs_admin\">";
	
	  foreach($observaciones_solicitud as $observacion) { ?>
	
	    <li id="o_<?php echo $observacion['id']?>"><?php echo $observacion['comentario']." (".$observacion['fecha'] ?>) - <?php echo $observacion['comercial']?>
		<a href="#" onclick="return deleteobservacion_solicitud(<?php echo $observacion['id']?>)"><img src="<?php echo base_url() ?>img/delete.gif" width="15" /></a> 
		</li>
	 <?php }
	  
	  echo "</ul>";
	}
	
	  ?>
        <textarea name="observaciones" style="width:600px; height:100px; float:left"></textarea>
        
        <div style="padding:20px; text-align:center"><input type="submit" name="add_observ" value="Añadir"></div>
        <div style="text-align:center; clear: left; margin-top:20px"><?php if(isset($_POST['add_observ'])) echo "Se ha añadido con &eacute;xito";?></div>
     </fieldset>
     

     <fieldset class="datos">
     <legend>Encuesta</legend>
     <?php
		if($encuesta_solicitud){
		?>
			<h3 style="color:red">IMPORTE DE DESCUENTO: <?php echo $encuesta_solicitud[0]['total_importe_descuento']?> &euro;</h3>
			<br>
			<?php
			foreach($encuesta_solicitud as $encuesta) { ?>
				<table class="tabledata" width="100%">
				<tr align="left">
					<th><?php echo $encuesta['pregunta']?></th>
				</tr>
				<tr>
					<td><?php echo $encuesta['respuesta']?></td>
				</tr>
				</table>
			 <?php }
		}
		else{
			?><center>
            <h3>Encuesta no realizada</h3>
            <br><br>
            <input type="hidden" id="email" name="email" value="<?php echo $solicitud['email']?>">
            <input type="hidden" id="mandar_encuesta" name="mandar_encuesta" value="N">
            <input type="button" onclick="enviar_encuesta()" value="Mandar encuesta por e-mail">
            </center>
		<?php
		}
	?> 
    </fieldset>
</form>
	</div>
	<div class="pestana" id="tab-2">
		<form method="post" enctype="multipart/form-data">   
    <fieldset class="datos"> 
        <legend>Seguimiento de llamadas</legend>
        <?php 
        if(!$llamadas_solicitud) 
	  		echo '<p style="text-align:center;padding:20px">Todav&iacute;a no se ha a&ntilde;adido nada en el seguimiento de llamadas</p>';
		else{
	  		
			echo "<ul class=\"observaciones obs_admin\">";
	
		  	foreach($llamadas_solicitud as $llamada) { ?>
		
			<li id="llamada_<?php echo $llamada['id_llamada']?>"><strong>(<?php echo $llamada['fecha_llamada'] ?>) - <?php echo $llamada['comercial']?></strong> <a href="#" onclick="return deletellamada(<?php echo $solicitud['id_solicitud']?>,<?php echo $llamada['id_llamada']?>)"><img src="<?php echo base_url() ?>img/cancel.gif" width="15" /></a><br>
            <?php echo $llamada['observaciones']?>
			</li>
		 <?php }
		  
		  echo "</ul>";
	}
	
	   //Mostramos el formulario sólo si sige siendo un posible cliente
	   if($solicitud['estado_solicitud']<>2 && $solicitud['estado_solicitud']<>5 && $solicitud['estado_solicitud']<>8)
	   {
		  ?>
		  <ul>
					<li><label>(*)Nueva llamada:</label>
					<textarea name="observaciones_llamada" style="width:600px; height:100px;" required></textarea></li>
					<?php
					$hoy = date('Y-m-d');
					$nueva_llamada = strtotime ( '+7 day' , strtotime ( $hoy ) ) ;
					$nueva_llamada = date ( 'Y-m-d' , $nueva_llamada );
					?>
					<li><label>(*)Próxima llamada:</label>
					<input type="text" id="fecha_prox_llamada" name="fecha_prox_llamada" required value="<?php echo $nueva_llamada?>"></li>
					<li><input type="submit" name="add_llamada" value="Añadir a seguimiento de llamadas" style="width:300px;"></li>
			</ul> 
            <?php
	   }?>
     </fieldset>
     </form>   
	</div>     
    
    <p style="text-align:center"></p> 

</div>
<div class="clear">
</div>