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
	$('#anadir').click(function(){
		if($('#nombre').val()=='')
		{
			alert("Debes añadir el nombre al restaurante");
			$('#nombre').focus();
			return false;
		}
     });
});
	</script>
       <h2>
        A&ntilde;adir restaurante
    </h2>
<div class="main form">
 
<form method="post" id="formulario_restaurante" name="formulario_restaurante" enctype="multipart/form-data">
	<fieldset class="datos">
    	<legend>Datos del restaurante</legend>
            <ul>
            	<li><label>(*)Nombre:</label><input type="text" id="nombre" name="nombre" /> </li>
                <li><label>Direcci&oacute;n:</label><input type="text" id="direccion" name="direccion" /> </li>
                <li><label>Tel&eacute;fono:</label><input type="text" id="telefono" name="telefono" /> </li>
                <li><label>Maitre:</label><input type="text" id="maitre" name="maitre" /> </li>
                <li><label>Tel&eacute;fono Maitre:</label><input type="text" id="telefono_maitre" name="telefono_maitre" /> </li>
                <li><label>Otro personal:</label><input type="text" id="otro_personal" name="otro_personal" /> </li>
                <li><label>Hora límite de fiesta:</label><input type="text" id="hora_limite_fiesta" name="hora_limite_fiesta" /> </li>
                <li><label>Empresa habitual:</label><input type="text" id="empresa_habitual" name="empresa_habitual" /> </li>
            </ul>
  
  		<br />
    </fieldset>
    
    <p style="text-align:center"><input type="submit" id="anadir" value="A&ntilde;adir" /></p>
</form>
        </div>
        <div class="clear">
        </div>