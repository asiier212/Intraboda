<script type="text/javascript" src="<?php echo base_url() ?>js/tiny_mce.js"></script>
<script type="text/javascript">
tinyMCE.init({
		// General options
		mode : 'textareas',
		theme : 'advanced',
		plugins : 'autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave,visualblocks',

		// Theme options
		theme_advanced_buttons1 : 'save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect',
		theme_advanced_buttons2 : 'cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor',
		theme_advanced_toolbar_location : 'top',
		theme_advanced_toolbar_align : 'left',
		theme_advanced_statusbar_location : 'bottom',
		theme_advanced_resizing : true,


		// Drop lists for link/image/media/template dialogs
		template_external_list_url : 'lists/template_list.js',
		external_link_list_url : 'lists/link_list.js',
		external_image_list_url : 'lists/image_list.js',
		media_external_list_url : 'lists/media_list.js',

		// Style formats
		style_formats : [
			{title : 'Bold text', inline : 'b'},
			{title : 'Red text', inline : 'span', styles : {color : '#ff0000'}},
			{title : 'Red header', block : 'h1', styles : {color : '#ff0000'}},
			{title : 'Example 1', inline : 'span', classes : 'example1'},
			{title : 'Example 2', inline : 'span', classes : 'example2'},
			{title : 'Table styles'},
			{title : 'Table row 1', selector : 'tr', classes : 'tablerow1'}
		],

	});
</script>
<link rel="stylesheet" href="<?php echo base_url() ?>js/jquery1.10.4/themes/smoothness/jquery-ui.css">
<script src="<?php echo base_url() ?>js/jquery1.10.4/js/jquery-1.10.2.js"></script>
<script src="<?php echo base_url() ?>js/jquery1.10.4/js/jquery-ui-1.10.4.js"></script>
	
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery1.10.4/js/jquery.jeditable.js"></script>  
<script src="<?php echo base_url() ?>js/jquery/development-bundle/ui/jquery-ui-timepicker-addon.js"></script>

		<script type="text/javascript" src="<?php echo base_url()?>/js/jquery/development-bundle/ui/jquery-ui-sliderAccess.js"></script>

           
	
	<link rel="stylesheet" href="<?php echo base_url() ?>js/jquery/development-bundle/demos/demos.css">
	<script>
	$(function() {
		$( "#calendar" ).datepicker();
		$( "#calendar_hora" ).timepicker({});
	
	});
	
	</script>
    
    <script>
$(function() {
	$('#anadir').click(function(){
		if($('#nombre').val()=='')
		{
			alert("Debes añadir el nombre al presupuesto");
			$('#nombre').focus();
			return false;
		}
		if($('#apellidos').val()=='')
		{
			alert("Debes añadir los apellidos al presupuesto");
			$('#apellidos').focus();
			return false;
		}
		if($('#email').val()=='')
		{
			alert("Debes añadir el e-mail al presupuesto");
			$('#email').focus();
			return false;
		}		
		if($('#telefono').val()=='')
		{
			alert("Debes añadir el teléfono a la solicitud");
			$('#telefono').focus();
			return false;
		}
		if($('#restaurante').val()=='')
		{
			alert("Debes añadir el restaurante al presupuesto");
			$('#restaurante').focus();
			return false;
		}
		if($('#calendar').val()=='')
		{
			alert("Debes añadir la fecha de la boda al presupuesto");
			$('#calendar').focus();
			return false;
		}
		if($('#calendar_hora').val()=='')
		{
			alert("Debes añadir la hora de la boda al presupuesto");
			$('#calendar_hora').focus();
			return false;
		}
		var checkboxValues = false;
		$('input:checkbox:checked').each(function() {
			checkboxValues = true;
		});
		if(checkboxValues==false){
			alert('Debes seleccionar al menos un servicio');
			return false;
		}
     });
	 
	 $('#restaurante').keyup(function(e){
        if(e.which == 13)
        {
            e.preventDefault();
        }
        
		var nombre = $('#restaurante').val();
		//alert(nombre);
		//alert(searched);
        var fullurl = $('#hiddenurl').val() + 'index.php/ajax/buscarrestaurante/' + encodeURIComponent(nombre);
       
	    $.getJSON(fullurl,function(result){
        	var elements = [];
           	$.each(result,function(i,val){
               	elements.push(val.nombre);
        	});
            	
			$('#restaurante').autocomplete({
               	source : elements
            });
        });
     });
	 
	 $('#restaurante').focusout(function(e){
		 var nombre = $('#restaurante').val();
        var fullurl = $('#hiddenurl').val() + 'index.php/ajax/buscarrestaurantearchivos/' + encodeURIComponent(nombre);
       var elements = [];
	    $.getJSON(fullurl,function(result){
        	
			existe=false;
           	$.each(result,function(i,val){
               	elements.push(val.nombre);
				elements.push(val.direccion);
				elements.push(val.telefono);
				elements.push(val.maitre);
				elements.push(val.telefono_maitre);
				elements.push(val.otro_personal);
				elements.push(val.hora_limite_fiesta);
				elements.push(val.empresa_habitual);
				elements.push(val.descripcion);
				elements.push(val.archivo);
				existe=true;
        	});
		
		
			if(existe){
				
				var tabla="<p><table class=tabledata><th>Nombre</th><th>Dirección</th><th>Teléfono</th><th>Maitre</th><th>Teléfono Maitre</th><th>Otro Personal</th><th>Hora límite fiesta</th><th>Empresa habitual</th><th>Archivos</th><tr><td>"+elements[0]+"</td><td>"+elements[1]+"</td><td>"+elements[2]+"</td><td>"+elements[3]+"</td><td>"+elements[4]+"</td><td>"+elements[5]+"</td><td>"+elements[6]+"</td><td>"+elements[7]+"</td><td>";
				
				//Chamba para coger los archivos y añadirlos a la tabla//
				var c=-1;
				for(i=0;i<=elements.length;i++){
					c++;
					if(c==9){
						if(elements[i]!=null){
							tabla=tabla+"<a href=<?php echo base_url()?>/uploads/restaurantes/"+elements[i]+" target=_blank>"+elements[i-1]+"</a><br><br>";
						}
						c=-1;
					}
				}
				
				tabla=tabla+"</td></tr></table></p>";
				$('#datos_restaurante').html(tabla);
								
			}else{
				$('#datos_restaurante').html("<strong>No hay información</strong>");
			}
			
        });
		
		 $('#datos_restaurante').css('visibility', 'visible');
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
			
			fecha_boda = $("#calendar").val();
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
			calcula_descuento($("#calendar").val(),servicios);

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
	</script>
    
    
       <h2>
        A&ntilde;adir Presupuesto de Evento
    </h2>
<div class="main form">
 
<form method="post" id="formulario_cliente" name="formulario_cliente">
	<fieldset class="datos">
    	<legend>Datos de contacto</legend>
            <ul>
            	<li><label>(*)Nombre:</label><input type="text" id="nombre" name="nombre" /> </li>
                <li><label>(*)Apellidos:</label><input type="text" id="apellidos" name="apellidos" /> </li>
                <li><label>(*)Email:</label><input type="text" id="email" name="email" /> </li>
                <li><label>(*)Tel&eacute;fono:</label><input type="text" id="telefono" name="telefono" /> </li>
                <li><label>(*)Evento:</label><select name="evento">
       							<?php
								foreach($eventos as $ev) {?>
                                <option value="<?php echo $ev['id_evento']?>"><?php echo $ev['nombre_evento']?></option>
                                <?php
                                }?>
                                </select> </li>
                <li><label>(*)Estado:</label><select name="estado_solicitud">
       							<?php
								foreach($estados_solicitudes as $estado) {?>
                                <option value="<?php echo $estado['id_estado']?>"><?php echo $estado['nombre_estado']?></option>
                                <?php
                                }?>
                                </select> </li>
            </ul>
    </fieldset>
	<fieldset class="datos">
        	<legend>Datos de la boda</legend>
            <ul>
            <li><label>(*)Restaurante:</label><input type="text" id="restaurante" name="restaurante" /></li>
            	<input value="<?php echo base_url()?>" id="hiddenurl" type="hidden">
                <div id="datos_restaurante" style="visibility:hidden">
                <input type="hidden" id="id_restaurante">
                </div>
            	<li><label>(*)Fecha de la boda:</label><input type="text" name="fecha_boda" id="calendar"  onChange="recalcula();"/></li>
                <li><label>(*)Hora de la boda:</label><input type="text" name="hora_boda" id="calendar_hora" style="width:60px"  /></li>     
            </ul>
    </fieldset>
    
    <fieldset class="datos">
        	<legend>Presupuesto</legend>
            <ul>
            	<?php
				foreach($servicios as $servicio) {?>
            	<li><input type="checkbox" name="servicios[<?php echo $servicio['id']?>]" id="chserv_<?php echo $servicio['id']?>" value="<?php echo $servicio['precio']?>" style="width:30px; vertical-align:middle" class="servicio" onClick="calcular_total(<?php echo $servicio['id']?>)" /><?php echo $servicio['nombre'];?><input type="checkbox" name="serviciosid[<?php echo $servicio['id']?>]" id="chserv2_<?php echo $servicio['id']?>" value="<?php echo $servicio['id']?>" class="idservicio" style="display:none;" /></li>
                <?php }?>
             </ul>
             <li><label>(*)Importe:</label><input type="text" id="importe" name="importe" value="0" style="width:50px;" readonly /> &#8364; </li>
             <li><label>(*)Descuento:</label><input type="text" id="descuento" name="descuento" value="0" style="width:50px;" onkeyup="calcula()" /> &#8364;
             <span id="mensajedescuento" style="color: green;"></span> </li>
             <li><label>(*)Total:</label><input type="text" id="total" name="total" value="0" readonly style="width:50px;" /> &#8364; </li>
    </fieldset>
    
    <p style="text-align:center"><input type="submit" id="anadir" value="A&ntilde;adir" /></p>
</form>
        </div>
        <div class="clear">
        </div>