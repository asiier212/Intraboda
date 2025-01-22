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

   <h2>
        Contactar
    </h2>
    <div class="main form">
 
<form method="post" enctype="multipart/form-data">    
 <fieldset class="datos"> 
        <legend>Mis personas de contacto</legend>
		   <ul>
            	<?php 
				if($personas_contacto){
		
				foreach($personas_contacto as $p) { ?>
                <li style="display: block; float:left; padding:0 20px; text-align:center">
               	<label for="p<?php echo $p['id']?>" style="float:none; margin:0 auto; width:auto">
				<?php if($p['foto'] != '') {?>
                	<img src="<?php echo base_url() ?>uploads/personas_contacto/<?php echo $p['foto']?>"/>
                <?php }?>
                <br />
                <?php echo $p['tipo']?>
                <?php echo $p['nombre']?>
               </label>
               <input type="radio" name="personas_contacto" class="personas" id="p<?php echo $p['id']?>" value="<?php echo $p['id']?>" style="width:30px" />
               
                </li>
              <?php }
				}?>
            </ul>
        	
        </fieldset>
        <fieldset class="datos">
        	<legend>Formulario de contacto</legend>
            <ul>
            	<li><label>Desde:</label><div><input style="width:30px; vertical-align:middle" checked="checked" name="mail_desde" type="radio" value="<?php echo $email_novio ?>" /> <?php echo $email_novio ?> <input name="mail_desde"  style="width:30px ;vertical-align:middle" type="radio" value="<?php echo $email_novia ?>" /> <?php echo $email_novia ?> </div></li>
            	<li><label>Asunto:</label><input type="text" name="asunto" style="width:300px" /> </li>
                <li><label>Mensaje:</label><textarea name="mensaje" style="height:300px"></textarea></li>
                <li style="text-align:center"><input type="submit" onclick="if(!$('.personas').is(':checked')) { alert('Selecione la persona de contacto'); return false; }" value="Enviar" /> </li>
            </ul>
             <?php if($_POST && isset($send)) 
 			echo "<p style=\"text-align:center;padding:20px\">Gracias. El mensaje ha sido enviado con &eacute;xito</p>";
 		elseif($_POST && !isset($send))
				echo "<p style=\"text-align:center;padding:20px\">Lo sentimos. Ha ocurrido un error durante el env&iacute;o. Int&eacute;ntelo  de nuevo dentro de un rato</p>";
				
 	
 ?>
        </fieldset>
 </form>       
 </div>

<div class="clear"></div>