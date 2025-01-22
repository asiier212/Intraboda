<script type="text/javascript" src="<?php echo base_url() ?>js/tiny_mce.js"></script>
<script type="text/javascript">
tinyMCE.init({
		// General options
		mode : 'textareas',
		theme : 'advanced',
		plugins : 'autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave,visualblocks',

		// Theme options
		theme_advanced_buttons1 : 'newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,formatselect,fontselect,fontsizeselect',
		theme_advanced_buttons2 : 'cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|',
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

<br>

<div class="chat">
<span>¿Cómo funciona el chat?</span>
<p>Escribid lo que queráis consultar, el coordinador o vuestro Dj (siempre que ya haya sido asignado) atenderá vuestros mensajes a la mayor brevedad posible. En el momento que atendamos vuestro mensaje, recibiréis una notificación en el email. Todas las conversaciones quedarán registradas para formar parte de la coordinación de vuestra boda.</p>
</div>

<?php
if($mensajes_contacto){
	foreach($mensajes_contacto as $m) {
		if($m['usuario']=='administrador'){
			?>
            <div class="bocadillo_administrador">
            	<strong><?php echo $m['fecha']?><br>
            	Coordinador dice:</strong><br>
            	<?php echo $m['mensaje'];?>
            </div>
            <div class="clear"></div><br>
			<?php
		}elseif($m['usuario']=='cliente'){
			?>
            <div class="bocadillo_usuario">
            	<strong><?php echo $m['fecha']?><br>
				<?php echo $this->session->userdata('nombre_novio').' y '.$this->session->userdata('nombre_novia').' dicen:'?></strong><br>
            <?php echo $m['mensaje'];?>
			</div>
            <div class="clear"></div><br>
			<?php
		}
		elseif($m['usuario']=='dj'){
			?>
            <div class="bocadillo_dj">
            <strong><?php echo $m['fecha']?><br>
			<?php echo $m['nombre_dj'].' dice:'?></strong><br>
            <?php echo $m['mensaje'];?>
			</div>
            <div class="clear"></div><br>
			<?php
		}
	}
}?>

<form method="post" enctype="multipart/form-data">
        <fieldset class="datos">
        	<legend>Formulario de envio</legend>
            <ul>
                <li><label>Mensaje:</label><textarea name="mensaje" style="height:300px"></textarea></li>
                <li style="text-align:center"><input type="submit" value="Enviar" /> </li>
            </ul>
        </fieldset>
 </form>       
 </div>

<div class="clear"></div>