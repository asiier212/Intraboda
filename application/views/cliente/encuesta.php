
<script type="text/javascript" src="<?php echo base_url() ?>js/tooltip.js"></script>

<script language="javascript">
$(function() {
	$('#enviar_datos').click(function(){
		//Comprobamos que exista el campo foto en el formulario
		if($("#foto").length ) {
			if($('#foto').val()=='')
			{
				alert("Debes añadir tu foto");
				return false;
			}
			var ext = $('#foto').val().split('.').pop().toLowerCase();
			if($.inArray(ext, ['gif','png','jpg']) == -1) {
				alert('La foto no es un arcnivo válido');
				return false;
			}
		}

		if($('#participacion1').val()=='')
		{
			alert("Debes elegir cómo de participativo te gustaría que estuviera el DJ Animador en tu boda");
			return false;
		}
		if($('#participacion2').val()=='')
		{
			alert("Debes elegir cómo de animados y participativos crees que van a estar los invitados a tu boda");
			return false;
		}
		
		if($('#num_invitados').val()=='')
		{
			alert("Debes añadir cuántos invitados esperáis en la boda");
			$('#num_invitados').focus();
			return false;
		}
		//AMPLIAR FIESTA
		checkeados_ampliar_fiesta = false;
		for(i=0;i<document.formulario['ampliar_fiesta'].length;i++){
			if(document.formulario['ampliar_fiesta'][i].checked){
				checkeados_ampliar_fiesta=true;
			}
		}
		if (checkeados_ampliar_fiesta==false){
			alert('Debes elegir si tenéis previsto ampliar la fiesta el mismo día de la boda');
			return false;
		}
		//FLEXIBILIDAD HORARIO RESTURANTE
		checkeados_flexibilidad_restaurante = false;
		for(i=0;i<document.formulario['flexibilidad_restaurante'].length;i++){
			if(document.formulario['flexibilidad_restaurante'][i].checked){
				checkeados_flexibilidad_restaurante=true;
			}
		}
		if (checkeados_flexibilidad_restaurante==false){
			alert('Debes elegir si el restaurante os da flexibilidad para ampliar la fiesta');
			return false;
		}
		
		if($('#hora_ultimo_autobus').val()=='')
		{
			alert("Debes añadir a qué hora es el último autobús de salida");
			$('#hora_ultimo_autobus').focus();
			return false;
		}
		
		//MAS IMPORTANCIA
		checkeados_mas_importancia = false;
		for(i=0;i<document.formulario['mas_importancia[]'].length;i++){
			if(document.formulario['mas_importancia[]'][i].checked){
				checkeados_mas_importancia=true;
			}
		}
		if (checkeados_mas_importancia==false){
			alert('Debes elegir qué estilos musicales quieres que no falten en tu boda');
			return false;
		}
		
		//MENOS IMPORTANCIA
		checkeados_menos_importancia = false;
		for(i=0;i<document.formulario['menos_importancia[]'].length;i++){
			if(document.formulario['menos_importancia[]'][i].checked){
				checkeados_menos_importancia=true;
			}
		}
		if (checkeados_menos_importancia==false){
			alert('Debes elegir a qué estilos musicales te gustaría que les diéramos menos importancia');
			return false;
		}
     });
	 
});
</script>


  <h2>
        Bienvenid@!
    </h2>
<div class="main">

<form name="formulario" method="post" enctype="multipart/form-data">
<p>&nbsp;</p>
<p><font color="red"><strong>Antes de empezar, tómate 2 minutos para darnos unos datos que nos servirán para organizar tu boda:</strong></font></p>

<?php
//Miramos si ya ha subido una foto para no poner el campo foto si ya ha subido una
if($cliente['foto']==""){
?>
    <fieldset style="width:87%">
        <legend>Envíanos tu fotografía</legend>
            <img src="<?php echo base_url()?>/img/interrogacion.png" width="16" height="16" onMouseOver="Tip('<p>Para saber qué tamaño tiene la imagen, hacemos <b>click con el botón derecho</b> encima de la imagen y seleccionamos <b>propiedades</b>.</p><p>Una vez hecho esto seleccionamos la <b>pestaña detalles</b> y en las propiedades de la imagen nos fijamos en los píxeles de ancho y alto que <b>no deben exceder de 600px en anchura</b>.</p>')" onMouseOut="UnTip()"> Subir foto (max 600px de ancho)(gif|jpg|png): <input type="file" id="foto" name="foto" />
    </fieldset>
    <?php
}?>


<fieldset style="width:87%">
	<legend>Encuesta respecto a la boda</legend>
    <?php	
		foreach($preguntas_encuesta_datos_boda as $preguntas) {
			?><li>- <strong><?php echo $preguntas['pregunta']?></strong></li><br><?php
			if($preguntas['id_pregunta']==10){
				?><p><select name="participativo_dj" id="participacion1">
                  <?php
						for($i=1;$i<=10;$i++){
							?><option value="<?php echo $i?>"><?php echo $i?></option><?php
						}
						?>
                     </select></p>
			<?php
			}
			if($preguntas['id_pregunta']==12){
				?><p><select name="participativos_invitados" id="participacion2">
                  <?php
						for($i=1;$i<=10;$i++){
							?><option value="<?php echo $i?>"><?php echo $i?></option><?php
						}
						?>
                  </select></p>
			<?php
			}
			if($preguntas['id_pregunta']==13){
				?><li>Invitados: <input type="text" id="num_invitados" name="num_invitados"></li><br><?php
			}
			if($preguntas['id_pregunta']==14){
				?><li><input type="radio" name="ampliar_fiesta" value="Si"> Sí</li>
                <li><input type="radio" id="ampliar_fiesta" name="ampliar_fiesta" value="No"> No</li><br><?php
			}
			if($preguntas['id_pregunta']==41){
				?><li><input type="radio" id="flexibilidad_restaurante" name="flexibilidad_restaurante" value="Si"> Sí</li>
                <li><input type="radio" id="flexibilidad_restaurante" name="flexibilidad_restaurante" value="No"> No</li><br><?php
			}
			if($preguntas['id_pregunta']==42){
				?><li>Hora: <input type="text" id="hora_ultimo_autobus" name="hora_ultimo_autobus"></li><br><?php
			}	
			if($preguntas['id_pregunta']==43){
				?>
                    <li><input type="checkbox" name="mas_importancia[]" value="Rock"> Rock</li>
                    <li><input type="checkbox" name="mas_importancia[]" value="Años70"> Años70</li>
                    <li><input type="checkbox" name="mas_importancia[]" value="Años 80 movida madrileña"> Años 80, movida madrileña</li>
                    <li><input type="checkbox" name="mas_importancia[]" value="Comercial (40 Principales)"> Comercial (40 Principales)</li>
                    <li><input type="checkbox" name="mas_importancia[]" value="Musica Latina"> Musica Latina</li>
                    <li><input type="checkbox" name="mas_importancia[]" value="Bachata"> Bachata</li>
                    <li><input type="checkbox" name="mas_importancia[]" value="Salsa"> Salsa</li>
                    <li><input type="checkbox" name="mas_importancia[]" value="Merengue"> Merengue</li>
                    <li><input type="checkbox" name="mas_importancia[]" value="Reggaeton"> Reggaeton</li>
                    <li><input type="checkbox" name="mas_importancia[]" value="Revival (flying free ecuador...)"> Revival (flying free, ecuador...)</li>
                    <li><input type="checkbox" name="mas_importancia[]" value="Pachangueras"> Pachangueras</li>
                    <li><input type="checkbox" name="mas_importancia[]" value="Nos es indiferente"> Nos es indiferente</li>
                    <br>
                <?php
			}
			if($preguntas['id_pregunta']==8){
				?>
                    <li><input type="checkbox" name="menos_importancia[]" value="Rock"> Rock</li>
                    <li><input type="checkbox" name="menos_importancia[]" value="Años70"> Años70</li>
                    <li><input type="checkbox" name="menos_importancia[]" value="Años 80 movida madrileña"> Años 80, movida madrileña</li>
                    <li><input type="checkbox" name="menos_importancia[]" value="Comercial (40 Principales)"> Comercial (40 Principales)</li>
                    <li><input type="checkbox" name="menos_importancia[]" value="Musica Latina"> Musica Latina</li>
                    <li><input type="checkbox" name="menos_importancia[]" value="Bachata"> Bachata</li>
                    <li><input type="checkbox" name="menos_importancia[]" value="Salsa"> Salsa</li>
                    <li><input type="checkbox" name="menos_importancia[]" value="Merengue"> Merengue</li>
                    <li><input type="checkbox" name="menos_importancia[]" value="Reggaeton"> Reggaeton</li>
                    <li><input type="checkbox" name="menos_importancia[]" value="Revival (flying free ecuador...)"> Revival (flying free, ecuador...)</li>
                    <li><input type="checkbox" name="menos_importancia[]" value="Pachangueras"> Pachangueras</li>
                    <li><input type="checkbox" name="menos_importancia[]" value="Nos es indiferente"> Nos es indiferente</li>
                    <br>
                <?php
			}
		}?>
</fieldset>
<center><input type="submit" id="enviar_datos" value="Enviar datos"></center>
</form>
 </div>
<div class="clear"></div>