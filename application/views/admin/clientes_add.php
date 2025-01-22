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
<link rel="stylesheet" href="<?php echo base_url() ?>js/jquery/development-bundle/themes/base/jquery.ui.all.css">

<link rel="stylesheet" href="<?php echo base_url() ?>js/jquery1.10.4/themes/smoothness/jquery-ui.css">
<script src="<?php echo base_url() ?>js/jquery1.10.4/js/jquery-1.10.2.js"></script>
<script src="<?php echo base_url() ?>js/jquery1.10.4/js/jquery-ui-1.10.4.js"></script>
   
<script src="<?php echo base_url() ?>js/jquery/development-bundle/ui/jquery-ui-timepicker-addon.js"></script>

<script type="text/javascript" src="<?php echo base_url() ?>js/jquery/development-bundle/ui/jquery-ui-sliderAccess.js"></script>
        
    
	
	<link rel="stylesheet" href="<?php echo base_url() ?>js/jquery/development-bundle/demos/demos.css">
	<script>
	$(function() {
		$( "#calendar" ).datepicker();
		$( "#calendar_hora" ).timepicker({});
		
		/*$('#restaurante').keyup(function(e){
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
				$.each(result,function(i,val){
					$('#direccion_restaurante').val(val.direccion);
				});
			});
		});*/
		$('#restaurante').change(function(){
 		
		var id_restaurante = $("#restaurante").val();
			
		$.ajax({
			type: 'POST', 
			dataType: 'json',  
			url: '<?php echo base_url() ?>index.php/ajax/buscarrestaurante', 
			data: 'id_restaurante='+id_restaurante, 
			success: function(data) {
					$("#direccion_restaurante").text(data.direccion);
					$("#telefono_restaurante").text(data.telefono_restaurante);
					$("#maitre").text(data.maitre);
					$("#telefono_maitre").text(data.telefono_maitre);
					$("#datos_restaurante ul ul li").remove();
					$.each(data.archivos,function(i,archivos){
						//alert(archivos.descripcion);
						$("#datos_restaurante ul ul").append('<li><label>'+archivos.descripcion+':</label><span><a href="<?php echo base_url()?>uploads/restaurantes/'+archivos.archivo+'" target="_blank">'+archivos.archivo+'</a></span></li>');
					});
				}
			});
		
     	});
	
	});
	
	</script>
    
    <script>
	function comprueba_datos_obligatorios(){
		if(
		document.formulario_cliente.nombre_novio.value=='' || 
		document.formulario_cliente.apellidos_novio.value=='' || 
		document.formulario_cliente.direccion_novio.value=='' || 
		document.formulario_cliente.cp_novio.value=='' || 
		document.formulario_cliente.poblacion_novio.value=='' || 
		document.formulario_cliente.telefono_novio.value=='' || 
		document.formulario_cliente.email_novio.value=='' || 
		
		document.formulario_cliente.nombre_novia.value=='' || 
		document.formulario_cliente.apellidos_novia.value=='' || 
		document.formulario_cliente.direccion_novia.value=='' || 
		document.formulario_cliente.cp_novia.value=='' || 
		document.formulario_cliente.poblacion_novia.value=='' || 
		document.formulario_cliente.telefono_novia.value=='' || 
		document.formulario_cliente.email_novia.value=='' || 
		
		document.formulario_cliente.fecha_boda.value=='' || 
		document.formulario_cliente.hora_boda.value=='' ||
		document.formulario_cliente.restaurante.value=='' ||  
		document.formulario_cliente.direccion_restaurante.value=='' || 
		
		document.formulario_cliente.clave.value=='' ||
		
		document.formulario_cliente.presupuesto.value=='' ||
		document.formulario_cliente.contrato.value=='')
		{
			alert("Rellene los campos de datos obligatorios");
			return false;
		}
		
		
		//SERVICIOS
		checkeados = false;
		for(i=0;i<document.formulario_cliente['servicios[]'].length;i++){
			if(document.formulario_cliente['servicios[]'][i].checked){
				checkeados=true;
			}
		}
		if (checkeados==false){
			alert('Seleccione por lo menos 1 casilla de servicios');
			return false;
		}
		
		//PERSONAS DE CONTACTO
		checkeados = false;
		for(i=0;i<document.formulario_cliente['personas_contacto[]'].length;i++){
			if(document.formulario_cliente['personas_contacto[]'][i].checked){
				checkeados=true;
			}
		}
		if (checkeados==false){
			alert('Seleccione por lo menos 1 persona de contacto');
			return false;
		}

		return true;
	}
	</script>
       <h2>
        A&ntilde;adir cliente
    </h2>
<div class="main form">
 
<form method="post" enctype="multipart/form-data" id="formulario_cliente" name="formulario_cliente" onsubmit="return comprueba_datos_obligatorios();">
	<fieldset class="datos">
    	<legend>Datos de contacto</legend>
        
        <fieldset>
        	<legend>Datos del Novio</legend>
            <ul>
            	<li><label>(*)Nombre:</label><input type="text" name="nombre_novio" /> </li>
                <li><label>(*)Apellidos:</label><input type="text" name="apellidos_novio" /> </li>
                <li><label>(*)Direcci&oacute;n:</label><input type="text" name="direccion_novio" /> </li>
                <li><label>(*)CP:</label><input type="text" name="cp_novio" /> </li>
                <li><label>(*)Poblaci&oacute;n:</label><input type="text" name="poblacion_novio" /> </li>
                <li><label>(*)Tel&eacute;fono:</label><input type="text" name="telefono_novio" /> </li>
                <li><label>(*)Email:</label><input type="text" name="email_novio" /> </li>
            </ul>
        </fieldset>
         <fieldset>
        	<legend>Datos de la Novia</legend>
            <ul>
            	<li><label>(*)Nombre:</label><input type="text" name="nombre_novia" /> </li>
                <li><label>(*)Apellidos:</label><input type="text" name="apellidos_novia" /> </li>
                <li><label>(*)Direcci&oacute;n:</label><input type="text" name="direccion_novia" /> </li>
                <li><label>(*)CP:</label><input type="text" name="cp_novia" /> </li>
                <li><label>(*)Poblaci&oacute;n:</label><input type="text" name="poblacion_novia" /> </li>
                <li><label>(*)Tel&eacute;fono:</label><input type="text" name="telefono_novia" /> </li>
                <li><label>(*)Email:</label><input type="text" name="email_novia" /> </li>
            </ul>
        </fieldset>
        <br class="clear" />
       Foto de perfil (max 600px de ancho): <input type="file" name="foto" /> <br />
       <br class="clear" />
       (*)Presupuesto: <input type="file" name="presupuesto" /> <br />
       <br class="clear" />
       (*)Contrato: <input type="file" name="contrato" /> <br />
       
       <br class="clear" />
       (*)Canal de captaci&oacute;n: <select name="canal_captacion">
       							<?php
								foreach($captacion as $capta) {?>
                                <option value="<?php echo $capta['id']?>"><?php echo $capta['nombre']?></option>
                                <?php
                                }?>
                                </select> <br />
       <br class="clear" />
       (*)Oficina: <select name="id_oficina">
       							<?php
								foreach($oficinas as $ofi) {?>
                                <option value="<?php echo $ofi['id_oficina']?>"><?php echo $ofi['nombre']?></option>
                                <?php
                                }?>
                                </select> <br />
       <br class="clear" />
       (*)Tipo de Cliente: <select name="id_tipo_cliente">
       							<?php
								foreach($tipos_clientes as $tipo) {?>
                                <option value="<?php echo $tipo['id_tipo_cliente']?>"><?php echo $tipo['tipo_cliente']?></option>
                                <?php
                                }?>
                                </select> <br />
	<br class="clear" />
       (*)Enviar e-mails al cliente: <select name="enviar_emails">
       								<option value="S">SÍ</option>
                                    <option value="N">NO</option>
                                </select> <br />
    </fieldset>
	<fieldset class="datos" id="datos_restaurante">
        	<legend>Datos de la boda</legend>
            <ul>
            	<li><label>(*)Fecha de la boda:</label><input type="text" name="fecha_boda" id="calendar"  /></li>
                <li><label>(*)Hora de la boda:</label><input type="text" name="hora_boda" id="calendar_hora" style="width:60px"  /></li>
                <li><label>Restaurante:</label><select id="restaurante" name="id_restaurante" style="width:200px" required>
                <option value=""></option>
                <?php
				foreach($restaurantes as $r) {
					?>
                    <option value="<?php echo $r['id_restaurante']?>"><?php echo $r['nombre']?></option>
                    <?php
				}
				?>
                </select></li> 
                <li><label>Direcci&oacute;n del Restaurante:</label><span id="direccion_restaurante"></span></li>
                <li><label>Tel&eacute;fono del Restaurante:</label><span id="telefono_restaurante"></span></li>
                <li><label>Maitre de la boda:</label><span id="maitre"></span></li>
                <li><label>Tel&eacute;fono Maitre:</label><span id="telefono_maitre"></span></li>
                <ul></ul>
            </ul>
             
    </fieldset>
    <fieldset class="datos">
        	<legend>Clave de acceso al sitio de usuario</legend>
            <label>(*)Clave:</label><input type="text" name="clave" /> 
    </fieldset>
    <fieldset class="datos">
        	<legend>Servicios</legend>
            <ul>
            	<?php
				foreach($servicios as $servicio) {?>
            	<li><input type="checkbox" name="servicios[<?php echo $servicio['id']?>]" id="chserv_<?php echo $servicio['id']?>" value="<?php echo $servicio['precio']?>" style="width:30px; vertical-align:middle" /><?php echo $servicio['nombre'];?><input type="text" onchange="$('#chserv_<?php echo $servicio['id']?>').val(this.value)" value="<?php echo $servicio['precio']?>" style="width:50px; text-align:center" /> &euro;</li>
                <?php }?>
                <li>Descuento: <input type="text" name="descuento" style="width:60px" /></li>
             </ul>
    </fieldset>
    <!--<fieldset class="datos"> 
        <legend>Observaciones</legend>
        <textarea name="observaciones" style="width:100%; height:200px"></textarea>
     </fieldset>-->   
     <div class="clear"> </div>
     <fieldset class="datos"> 
        <legend>Listado personas de contacto</legend>
		   <ul>
            	<?php 
				if($personas){
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
               <input type="checkbox" name="personas_contacto[]" value="<?php echo $p['id']?>" id="p<?php echo $p['id']?>" style="width:30px" />
               
                </li>
              <?php }
				}?>
            </ul>
        	
        </fieldset>
    <p style="text-align:center"><input type="submit" value="A&ntilde;adir" /></p>
</form>
        </div>
        <div class="clear">
        </div>