
    <script type="text/javascript" src="<?php echo base_url() ?>js/jquery/development-bundle/ui/jquery.jeditable.js"></script>

<script type="text/javascript" src="<?php echo base_url() ?>js/alertify/lib/alertify.js"></script>
<link rel="stylesheet" href="<?php echo base_url() ?>js/alertify/themes/alertify.core.css" />
<link rel="stylesheet" href="<?php echo base_url() ?>js/alertify/themes/alertify.default.css" />



<script language="javascript">
function deletepregunta(id_pregunta){
	alertify.confirm("<p>\u00BFSeguro que desea borrar la pregunta?</p>", function (e) {
		if (e) {
			$.ajax({
				type: 'POST',   
				url: '<?php echo base_url() ?>index.php/ajax/deletepregunta_encuesta', 
				data: 'id_pregunta='+id_pregunta, 
				success: function(data) {
						location.href= '<?php echo base_url() ?>admin/encuesta';
				}
			});
		} else { alertify.error("Opción cancelada");
		}
	}); 
}



function deleterespuesta(id_respuesta){
	alertify.confirm("<p>\u00BFSeguro que desea borrar la posible respuesta?</p>", function (e) {
		if (e) {
			$.ajax({
				type: 'POST',   
				url: '<?php echo base_url() ?>index.php/ajax/deleterespuesta_encuesta', 
				data: 'id_respuesta='+id_respuesta, 
				success: function(data) {
						location.href= '<?php echo base_url() ?>admin/encuesta';
				}
			});
		} else { alertify.error("Opción cancelada");
		}
	}); 
}

function anade_pregunta(){
	
	alertify.prompt("Añade una pregunta para la encuesta:", function (e, preg) { 
	if (e){
		//alertify.success("Has pulsado '" + alertify.labels.ok + "'' e introducido: " + preg);
		$("#pregunta").val(preg);
		
		alertify.prompt("Añade una importe para la pregunta:", function (e2, importe) { 
			if (e2){
				//alertify.success("Has pulsado '" + alertify.labels.ok + "'' e introducido: " + importe);
				$("#importe_descuento").val(importe);
				
				if($("#pregunta").val()!="" && $("#importe_descuento").val()!=""){
					$("#preguntas").submit();
				}
			}else{
				//alertify.error("Has pulsado '" + alertify.labels.cancel + "'");
				}
		});	
	}else{
		//alertify.error("Has pulsado '" + alertify.labels.cancel + "'");
		return false;
		}
	});

}

function anade_respuesta(id_pregunta, pregunta){
	alertify.prompt("Añade una respuesta para la pregunta: <br><b>"+pregunta+"</b>:", function (e, respuesta) { 
	if (e){
		//alertify.success("Has pulsado '" + alertify.labels.ok + "'' e introducido: " + respuesta);
		$("#id_pregunta").val(id_pregunta);
		$("#respuesta").val(respuesta);
		
		if($("#respuesta").val()!="" && $("#id_pregunta").val()!=""){
			$("#preguntas").submit();
		}
	}else{
		//alertify.error("Has pulsado '" + alertify.labels.cancel + "'");
		}
	});	
}

function editar_pregunta(id_pregunta, pregunta){
	alertify.prompt("Modifica la pregunta: <br><b>"+pregunta+"</b>", function (e, pregunta) { 
		if (e) {
			$.ajax({
			type: 'POST',   
			url: '<?php echo base_url() ?>index.php/ajax/edita_pregunta_encuesta', 
			data: 'id_pregunta='+id_pregunta+'&pregunta='+pregunta, 
			success: function(data) {
					location.href= '<?php echo base_url() ?>admin/encuesta';
			}
			});
		} else { alertify.error("Opción cancelada");
		}
	});	
}

function editar_respuesta(id_respuesta, respuesta){
	alertify.prompt("Modifica la respuesta: <br><b>"+respuesta+"</b>", function (e, respuesta) { 
		if (e) {
			$.ajax({
			type: 'POST',   
			url: '<?php echo base_url() ?>index.php/ajax/edita_respuesta_encuesta', 
			data: 'id_respuesta='+id_respuesta+'&respuesta='+respuesta, 
			success: function(data) {
					location.href= '<?php echo base_url() ?>admin/encuesta';
			}
			});
		} else { alertify.error("Opción cancelada");
		}
	});	
}

function modifica_importe_pregunta(id_pregunta, pregunta, importe_descuento){
	alertify.prompt("Modifica el importe para la pregunta: <br><b>"+pregunta+"</b>: Valor actual: ("+importe_descuento+" &euro;)", function (e, importe) { 
		if (e) {
			$.ajax({
			type: 'POST',   
			url: '<?php echo base_url() ?>index.php/ajax/modifica_importe_descuento_pregunta_encuesta', 
			data: 'id_pregunta='+id_pregunta+'&importe_descuento='+importe, 
			success: function(data) {
					location.href= '<?php echo base_url() ?>admin/encuesta';
			}
			});
		} else { alertify.error("Opción cancelada");
		}
	});	
}

</script>

<h2>
        Encuesta
    </h2>
<div class="main form">
 

<form method="post" name="preguntas" id="preguntas">
    
    <div style="clear:both"></div>

	<fieldset class="datos">
    	<legend>Preguntas que forman parte de la encuesta</legend>
        	Añadir pregunta: <a href="#" onclick="return anade_pregunta()"><img src="<?php echo base_url() ?>img/anadir.png" width="18px" title="Añadir pregunta a la encuesta" /></a>
            <input type="hidden" id="pregunta" name="pregunta" value="" />
    		<input type="hidden" id="importe_descuento" name="importe_descuento" value="">
            
            <br><br>
       		
            <div>
            <?php
			if(isset($preguntas_encuesta) && $preguntas_encuesta[0]<>""){
				$cont_preguntas=1;
				foreach($preguntas_encuesta as $pregunta){
					?>
                    <fieldset style="clear:both; width:90%">
                    <legend>
					<?php echo $cont_preguntas.". ".$pregunta['pregunta']?>
						<a href="#" onclick="return anade_respuesta(<?php echo $pregunta['id_pregunta']?>,'<?php echo str_replace("'", "\'",$pregunta['pregunta'])?>')"><img src="<?php echo base_url() ?>img/anadir.png" width="18px" title="Añadir respuesta" /></a>&nbsp;
                        <a href="#" onclick="return editar_pregunta(<?php echo $pregunta['id_pregunta']?>,'<?php echo str_replace("'", "\'",$pregunta['pregunta'])?>')"><img src="<?php echo base_url() ?>img/editar.png" width="18px" title="Editar pregunta" /></a>&nbsp;
                        <a href="#" onclick="return deletepregunta(<?php echo $pregunta['id_pregunta']?>)"><img src="<?php echo base_url() ?>img/delete.gif" width="15" title="Eliminar pregunta" /></a>
					&nbsp;&nbsp;
                    Descuento: <a href="#" onclick="modifica_importe_pregunta(<?php echo $pregunta['id_pregunta']?>,'<?php echo str_replace("'", "\'",$pregunta['pregunta'])?>','<?php echo $pregunta['importe_descuento']?>')"><?php echo $pregunta['importe_descuento']?></a> &euro;</legend>
					<?php
					if(isset($respuestas_preguntas) && $respuestas_preguntas[0]<>""){
						?>
                        <ul>
						<?php
						foreach($respuestas_preguntas as $respuesta){
							//Comprobamos que la respuesta forme parte de esa pregunta
							if($pregunta['id_pregunta']==$respuesta['id_pregunta']){
								?>
								<li id="respuesta_<?php echo $respuesta['id_respuesta']?>" style="margin-left:40px;"><?php echo $respuesta['respuesta']?>&nbsp;
                                    <a href="#" onclick="return editar_respuesta(<?php echo $respuesta['id_respuesta']?>,'<?php echo $respuesta['respuesta']?>')"><img src="<?php echo base_url() ?>img/editar.png" width="15" title="Editar respuesta" /></a>&nbsp;
									<a href="#" onclick="return deleterespuesta(<?php echo $respuesta['id_respuesta']?>)"><img src="<?php echo base_url() ?>img/delete.gif" width="15" title="Eliminar respuesta" /></a>
								</li>
								<?php
							}
						}
						$cont_preguntas++;
					}
					?></fieldset><?php
				}
				?></ul><?php
			}
			?>
            </div>	 

        <br class="clear" />
    </fieldset>
    
    <input type="hidden" id="respuesta" name="respuesta" value="">
    <input type="hidden" id="id_pregunta" name="id_pregunta" value="" />
</form>

</div>
<div class="clear">
</div>