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
	
		<script src="<?php echo base_url() ?>js/jquery/development-bundle/ui/jquery-ui-1.8.16.custom.min.js"></script>   
		<script src="<?php echo base_url() ?>js/jquery/development-bundle/ui/jquery-ui-timepicker-addon.js"></script>

		<script type="text/javascript" src="<?php echo base_url() ?>js/jquery/development-bundle/ui/jquery-ui-sliderAccess.js"></script>
        
    
	
	<link rel="stylesheet" href="<?php echo base_url() ?>js/jquery/development-bundle/demos/demos.css">
	<script>
	$(function() {
		$( "#calendar" ).datepicker();
		$( "#calendar_hora" ).timepicker({});
	
	});
	
	</script>
       <h2>
        A&ntilde;adir cliente
    </h2>
<div class="main form">
 
<form method="post" enctype="multipart/form-data">
	<fieldset class="datos">
    	<legend>Datos de contacto</legend>
        
        <fieldset>
        	<legend>Datos del Novio</legend>
            <ul>
            	<li><label>Nombre:</label><input type="text" name="nombre_novio" /> </li>
                <li><label>Apellidos:</label><input type="text" name="apellidos_novio" /> </li>
                <li><label>Direcci&oacute;n:</label><input type="text" name="direccion_novio" /> </li>
                <li><label>CP:</label><input type="text" name="cp_novio" /> </li>
                <li><label>Poblaci&oacute;n:</label><input type="text" name="poblacion_novio" /> </li>
                <li><label>Tel&eacute;fono:</label><input type="text" name="telefono_novio" /> </li>
                <li><label>Email:</label><input type="text" name="email_novio" /> </li>
            </ul>
        </fieldset>
         <fieldset>
        	<legend>Datos de la Novia</legend>
            <ul>
            	<li><label>Nombre:</label><input type="text" name="nombre_novia" /> </li>
                <li><label>Apellidos:</label><input type="text" name="apellidos_novia" /> </li>
                <li><label>Direcci&oacute;n:</label><input type="text" name="direccion_novia" /> </li>
                <li><label>CP:</label><input type="text" name="cp_novia" /> </li>
                <li><label>Poblaci&oacute;n:</label><input type="text" name="poblacion_novia" /> </li>
                <li><label>Tel&eacute;fono:</label><input type="text" name="telefono_novia" /> </li>
                <li><label>Email:</label><input type="text" name="email_novia" /> </li>
            </ul>
        </fieldset>
        <br class="clear" />
       Foto de perfil (max 600px de ancho): <input type="file" name="foto" /> <br />

    </fieldset>
	<fieldset class="datos">
        	<legend>Datos de la boda</legend>
            <ul>
            	<li><label>Fecha de la boda:</label><input type="text" name="fecha_boda" id="calendar"  /></li>
                <li><label>Hora de la boda:</label><input type="text" name="hora_boda" id="calendar_hora" style="width:60px"  /></li>
                <li><label>Restaurante:</label><input type="text" name="restaurante" /></li>
                <li><label>Direcci&oacute;n del Restaurante:</label><input type="text" name="direccion_restaurante" /></li>
                <li><label>Tel&eacute;fono del Restaurante:</label><input type="text" name="telefono_restaurante" /></li>
                <li><label>Maitre de la boda:</label><input type="text" name="maitre" /></li>
                <li><label>Tel&eacute;fono de Maitre:</label><input type="text" name="telefono_maitre" /></li>
            </ul>
             
    </fieldset>
    <fieldset class="datos">
        	<legend>Clave de acceso al sitio de usuario</legend>
            <label>Clave:</label><input type="text" name="clave" /> 
    </fieldset>
    <fieldset class="datos">
        	<legend>Servicios</legend>
            <ul>
            	<?php foreach($servicios as $servicio) {?>
            	<li><input type="checkbox" name="servicios[]" value="<?php echo $servicio['id']?>" style="width:30px; vertical-align:middle" /><?php echo $servicio['nombre']?></li>
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