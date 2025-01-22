
    <script type="text/javascript" src="<?php echo base_url() ?>js/jquery/development-bundle/ui/jquery.jeditable.js"></script>



 <script language="javascript">
$(document).ready(function() {
	 $('.edit_box').editable('<?php echo base_url() ?>index.php/ajax/updatedatopresup/<?php echo $presupuesto_evento['id_presupuesto']?>', { 
         type      : 'text',
        submit    : '<img src="<?php echo base_url() ?>img/save.gif" />',
         tooltip   : 'Click para editar...',
		 callback : function() {
         	recalcula();
			alert('Si has modificado la fecha de la boda, acuérdate de guardar de nuevo los servicios pinchando en el botón <<Guardar servicios>>');
		 },
     });
	 
	 $('#update_evento').click(function(){
		if($('#evento').val()=='')
		{
			alert("Debes seleccionar un evento");
			$('#evento').focus();
			return false;
		}
     });
	 $('#enviar_email').click(function(){
		if(!confirm('Se le enviará un e-mail al cliente con el presupuesto')){	
			return false;
		}
     });
	 
	 
});
</script>

<script type="text/javascript">

		function recalcula() {
			importe = 0
			total = 0
			servicios = "";
			$(".servicio").each(
				function(index, value) {
					if($(this).is(':checked')){
						importe = importe + eval($(this).val());
					}
				}
			);
			
			$(".idservicio").each(
				function(index, value) {
					if($(this).is(':checked')){
						servicios = servicios + eval($(this).val()) + ",";
					}
				}
			);
			$("#importe").val(importe);
			
			
			
			servicios=servicios.substring(0,servicios.length-1);
			
			var fecha_boda = ""
			fecha_boda += $("#fecha_boda").html().substring(6) + "-"
			fecha_boda += $("#fecha_boda").html().substring(3,5) + "-"
			fecha_boda += $("#fecha_boda").html().substring(0,2)
			calcula_descuento(fecha_boda,servicios);

			calcula();
		}



		function calcular_total(id) {
			if($('#calendar').val()==''){
				alert("Debes añadir una fecha de boda primero");
				document.getElementById("chserv_"+id).checked = false;
				return false;
			}
			comprueba(id);
			importe = 0
			total = 0
			servicios = "";
			$(".servicio").each(
				function(index, value) {
					if($(this).is(':checked')){
						importe = importe + eval($(this).val());
					}
				}
			);
			
			$(".idservicio").each(
				function(index, value) {
					if($(this).is(':checked')){
						servicios = servicios + eval($(this).val()) + ",";
					}
				}
			);
			$("#importe").val(importe);
			
			
			
			servicios=servicios.substring(0,servicios.length-1);
			
			var fecha_boda = ""
			fecha_boda += $("#fecha_boda").html().substring(6) + "-"
			fecha_boda += $("#fecha_boda").html().substring(3,5) + "-"
			fecha_boda += $("#fecha_boda").html().substring(0,2)
			calcula_descuento(fecha_boda,servicios);

			calcula();
		}
		
		function comprueba(id){
			if($("#chserv_"+id).is(":checked")){
				$("#chserv2_"+id).prop('checked',true);
			}
			else{
				$("#chserv2_"+id).prop('checked',false);
			}
		}
		
		function calcula_descuento(fecha_boda,servicios){
			//Inicializamos descuento y el mensaje del descuento
			$("#descuento").val(0);
			$("#mensajedescuento").html('');
			
			var fullurl = <?php echo base_url() ?> + 'index.php/ajax/calculardescuento/' + encodeURIComponent(fecha_boda) + '/' + encodeURIComponent(servicios);
			
			$.getJSON(fullurl,function(result){
				/*var elements = [];*/
				$.each(result,function(i,val){
					$("#descuento").val(val.importe);
					$("#total").val();
					$("#total").val(($("#importe").val() - $("#descuento").val()));
					$("#mensajedescuento").html('Se ha aplicado un descuento');
				});
			});
		}
		
		function calcula(){
			total = $("#importe").val() - $("#descuento").val();
			$("#total").val(($("#importe").val() - $("#descuento").val()));
		}
		
		function deleteobservacion_presupuesto_eventos(id){
		if (confirm("\u00BFSeguro que desea borrar la observaci\u00f3n?")) 
		{
			
			$.ajax({
				type: 'POST',   
				url: '<?php echo base_url() ?>index.php/ajax/deleteobservacion_presupuesto_eventos', 
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
    
<h2>
        Detalles del presupuesto
    </h2>
<div class="main form">
   
<form method="post" enctype="multipart/form-data">
<input type="hidden" id="id_presupuesto" name="id_presupuesto" value="<?php echo $presupuesto_evento['id_presupuesto']?>">
	<fieldset class="datos">
    	<legend>Datos del contacto</legend>
            <ul class="editable">
            	<li><label>Nombre:</label><span class="edit_box" id="nombre"><?php echo $presupuesto_evento['nombre']?></span> </li>
                <li><label>Apellidos:</label><span class="edit_box" id="apellidos"><?php echo $presupuesto_evento['apellidos']?></span></li>
                <li><label>Email:</label><span class="edit_box" id="email"><?php echo $presupuesto_evento['email']?></span></li>
                <li><label>Teléfono:</label><span class="edit_box" id="telefono"><?php echo $presupuesto_evento['telefono']?></span></li>
            </ul>
        
    
        <br class="clear" />
       (*)Evento: <select name="evento" id="evento">
       							<?php
								foreach($eventos as $ev) {
									if($ev['id_evento']==$presupuesto_evento['evento'])
									{?>
                                		<option value="<?php echo $ev['id_evento']?>"><?php echo $ev['nombre_evento']?></option>
                                        <?php
									}
                                }?>
                                <option value=""></option>
                                <?php
                                foreach($eventos as $ev) {
									?>
                                		<option value="<?php echo $ev['id_evento']?>"><?php echo $ev['nombre_evento']?></option>
                                        <?php
									}
								?>
                                </select>
                                <input type="submit" name="update_evento" id="update_evento" value="Cambiar evento" />
        <br class="clear" /> <br class="clear" />
       (*)Estado: <select name="estado_solicitud">
       							<?php
								foreach($estados_solicitudes as $estado) {
									if($estado['id_estado']==$presupuesto_evento['estado_solicitud'])
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
         
    </fieldset>
	<fieldset class="datos">
        	<legend>Datos de la boda</legend>
            <ul>
            	<li><label>Fecha de la boda:</label><span class="edit_box" id="fecha_boda"><?php echo $presupuesto_evento['fecha_boda']?></span></li>
                <li><label>Hora de la boda:</label>
                <span class="edit_box" id="hora_boda"><?php echo $presupuesto_evento['hora_boda']?></span></li>
                <li><label>Restaurante:</label><span id="restaurante"><?php echo $presupuesto_evento['restaurante']?></span></li>
            </ul>                
     </fieldset>
     
     <fieldset class="datos">
        	<legend>Presupuesto</legend>
            <ul>
            	<?php
				$arr_servicios = explode(",", $presupuesto_evento['servicios'] );
				
				foreach($servicios as $servicio) {?>
            	<li><input type="checkbox" name="servicios[<?php echo $servicio['id']?>]" id="chserv_<?php echo $servicio['id']?>" <?php echo in_array($servicio['id'], $arr_servicios) ? 'checked="checked"' : '' ?> value="<?php echo $servicio['precio']?>" style="width:30px; vertical-align:middle" class="servicio" onClick="calcular_total(<?php echo $servicio['id']?>)" onchange="comprueba(<?php echo $servicio['id']?>)" /><?php echo $servicio['nombre'];?><input type="checkbox" name="serviciosid[<?php echo $servicio['id']?>]" id="chserv2_<?php echo $servicio['id']?>" <?php echo in_array($servicio['id'], $arr_servicios) ? 'checked="checked"' : '' ?> value="<?php echo $servicio['id']?>" class="idservicio" style="display:none;"  /></li>
                <?php }?>
             </ul>
             <li style="visibility:hidden"><label>(*)Importe:</label><input type="text" id="importe" name="importe" value="<?php echo $presupuesto_evento['importe']?>" style="width:50px;" readonly /> &#8364; </li>
             <li style="visibility:hidden"><label>(*)Descuento:</label><input type="text" id="descuento" name="descuento" value="<?php echo $presupuesto_evento['descuento']?>" onkeyup="calcula()" style="width:50px;" /> &#8364;
 			
            <?php
				if($presupuesto_evento['descuento']>0){
					?><span id="mensajedescuento" style="color: green;">Se ha aplicado un descuento</span><?php
				}
				else{
					?><span id="mensajedescuento" style="color: green;"></span><?php
				}
			?>
            </li>
             
             <li><label>(*)Total:</label><input type="text" id="total" name="total" value="<?php echo $presupuesto_evento['total']?>" readonly style="width:50px;" /> &#8364; </li>
             
             <br />
             <input type="submit" name="update_servicios" value="Guardar servicios" />
             <input type="submit" name="enviar_email" id="enviar_email" value="Enviar Presupuesto" />
    </fieldset>
    
    <fieldset class="datos"> 
        <legend>Observaciones</legend>
        <?php 
        if(!$observaciones_presupuesto_eventos) 
	  echo '<p style="text-align:center;padding:20px">Todav&iacute;a no se ha a&ntilde;adido observaciones</p>';
	else {
	  echo "<ul class=\"observaciones obs_admin\">";
	
	  foreach($observaciones_presupuesto_eventos as $observacion) { ?>
	
	    <li id="o_<?php echo $observacion['id']?>"><?php echo $observacion['comentario']." (".$observacion['fecha'] ?>) - <?php echo $observacion['comercial']?>
		<a href="#" onclick="return deleteobservacion_presupuesto_eventos(<?php echo $observacion['id']?>)"><img src="<?php echo base_url() ?>img/delete.gif" width="15" /></a> 
		</li>
	 <?php }
	  
	  echo "</ul>";
	}
	
	  ?>
        <textarea name="observaciones" style="width:600px; height:100px; float:left"></textarea>
        
        <div style="padding:20px; text-align:center"><input type="submit" name="add_observ" value="Añadir"></div>
        <div style="text-align:center; clear: left; margin-top:20px"><?php if(isset($_POST['add_observ'])) echo "Se ha añadido con &eacute;xito";?></div>
     </fieldset>   

    <p style="text-align:center"></p>
</form> 

</div>
<div class="clear">
</div>