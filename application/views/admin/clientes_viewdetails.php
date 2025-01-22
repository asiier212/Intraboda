
    <script type="text/javascript" src="<?php echo base_url() ?>js/jquery/development-bundle/ui/jquery.jeditable.js"></script>

<script type="text/javascript" src="<?php echo base_url() ?>js/tooltip.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/alertify/lib/alertify.js"></script>
<link rel="stylesheet" href="<?php echo base_url() ?>js/alertify/themes/alertify.core.css" />
<link rel="stylesheet" href="<?php echo base_url() ?>js/alertify/themes/alertify.default.css" />


 <script language="javascript">
$(document).ready(function() {
	 $('.edit_box').editable('<?php echo base_url() ?>index.php/ajax/updatedatocliente/<?php echo $cliente['id']?>', { 
         type      : 'text',
        submit    : '<img src="<?php echo base_url() ?>img/save.gif" />',
         tooltip   : 'Click para editar...',
     });
});
function deleteobservacion_admin(id){
	if (confirm("\u00BFSeguro que desea borrar la observaci\u00f3n?")) 
	{
		
		$.ajax({
			type: 'POST',   
			url: '<?php echo base_url() ?>index.php/ajax/deleteobservacion_admin', 
			data: 'id='+id, 
			success: function(data) {
					$("#o_" + id).css("display", "none");
					$("#result").html("");
				}
		});
	}
	return false
}

function deletepago(id,valor,fecha){
	if (confirm("\u00BFSeguro que desea borrar el pago?")) 
	{
		$.ajax({
			type: 'POST',   
			url: '<?php echo base_url() ?>index.php/ajax/deletepago', 
			data: 'id='+id+'&valor='+valor+'&fecha='+fecha, 
			success: function(data) {
					location.href= '<?php echo base_url() ?>admin/clientes/view/'+id;
				}
		});
	}
	return false
}

function anade_horas_dj(){
	
	alertify.prompt("Añade el concepto:", function (e, con) { 
	if (e){
		$("#horas_concepto").val(con);
		
		alertify.prompt("Añade el número de horas:", function (e2, ho) { 
			if (e2){
				$("#horas_dj").val(ho);
				
				if($("#horas_concepto").val()!="" && $("#horas_dj").val()!=""){
					$("#form_cliente").submit();
				}
			}
		});	
	}else{
		return false;
		}
	});

}

function elimina_horas_dj(id,id_cliente){
	if (confirm("\u00BFSeguro que desea borrar el trabajo?")) 
	{
		$.ajax({
			type: 'POST',   
			url: '<?php echo base_url() ?>index.php/ajax/elimina_horas_dj', 
			data: 'id='+id, 
			success: function(data) {
					location.href= '<?php echo base_url() ?>admin/clientes/view/'+id_cliente;
				}
		});
	}
	return false
}

function muestra_componentes_equipo(componentes){
	alertify.alert(componentes);
}
</script>

<script type="text/javascript" src="<?php echo base_url() ?>js/jrating/jquery/jRating.jquery.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$(".valoracion").jRating({
	  step: true,
	  type :'big', // type of the rate.. can be set to 'small' or 'big'
	  length : 10, // nb of stars
	  rateMax : 10, // número máximo de valoración
	  bigStarsPath : "<?php echo base_url() ?>js/jrating/jquery/icons/stars.png", //Path de las estrellas
	  isDisabled : true
	});
	
	$('#generar_factura').click(function(e){
		if($("#cif").val()=="")
		{
			alert("Debes rellenar el campo CIF, antes de generar la factura");
			return false;
		}
		if($("#fecha_factura").val()=="")
		{
			alert("Debes rellenar el campo fecha de la factura, antes de generar la factura");
			return false;
		}
		if($("#facturar_a").val()=="")
		{
			alert("Debes rellenar el campo Facturar a, antes de generar la factura");
			return false;
		}
		if($("#direccion").val()=="")
		{
			alert("Debes rellenar el campo Dirección, antes de generar la factura");
			return false;
		}
		if($("#poblacion").val()=="")
		{
			alert("Debes rellenar el campo Población, antes de generar la factura");
			return false;
		}
		if($("#cp").val()=="")
		{
			alert("Debes rellenar el campo CP, antes de generar la factura");
			return false;
		}
		if($("#telefono").val()=="")
		{
			alert("Debes rellenar el campo Teléfono, antes de generar la factura");
			return false;
		}
		if($("#email").val()=="")
		{
			alert("Debes rellenar el campo E-mail, antes de generar la factura");
			return false;
		}
		if($("#n_factura").val()=="")
		{
			alert("Debes rellenar el campo Nº de Factura, antes de generar la factura");
			return false;
		}
		if($("#concepto").val()=="")
		{
			alert("Debes rellenar el campo Concepto, antes de generar la factura");
			return false;
		}
	});
	
	
	$('#restaurante').change(function(){
 		
		var id_cliente = <?php echo $cliente['id']?>;
		var id_restaurante = $("#restaurante").val();
			
		$.ajax({
			type: 'POST', 
			dataType: 'json',  
			url: '<?php echo base_url() ?>index.php/ajax/actualizarestaurantecliente', 
			data: 'id_cliente='+id_cliente+"&id_restaurante="+id_restaurante, 
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
</script><link rel="stylesheet" href="<?php echo base_url() ?>js/jrating/jquery/jRating.jquery.css" type="text/css" />


<link rel="stylesheet" href="<?php echo base_url() ?>js/jquery/development-bundle/themes/base/jquery.ui.all.css">
	
		<script src="<?php echo base_url() ?>js/jquery/development-bundle/ui/jquery-ui-1.8.16.custom.min.js"></script>   
		<script src="<?php echo base_url() ?>js/jquery/development-bundle/ui/jquery-ui-timepicker-addon.js"></script>

		<script type="text/javascript" src="<?php echo base_url() ?>js/jquery/development-bundle/ui/jquery-ui-sliderAccess.js"></script>
<script>
	$(function() {
		$("#fecha_factura" ).datepicker({dateFormat: 'dd-mm-yy'});	
	});
	
	</script> 
    
    
<style>
.editable img { float:right}
</style>
<h2>
        Detalles del cliente
    </h2>
<div class="main form">
 
 <?php
  session_start(); //Sesión para controlar que admin pueda acceder a todas las fichas de los clientes
  if ($this->session->userdata('admin')==1)
  {
	  $_SESSION['id_dj']=  'admin';
  }
?>
   
<form method="post" enctype="multipart/form-data" id="form_cliente">
	<fieldset class="datos">
    	<legend>Datos de contacto</legend>
       
		<p style="float:left">Para editar los datos haz click sobre el texto</p>
         <p style="text-align:right"><a style="text-decoration:underline" target="_blank" href="<?php echo base_url() ?>admin/clientes/initsession/<?php echo $cliente['id']?>">Iniciar Sesi&oacute;n en la cuenta del usuario</a></p>
         <p style="text-align:right"><a style="text-decoration:underline" target="_blank" href="<?php echo base_url() ?>informes/ficha.php?id_cliente=<?php echo $cliente['id']?>">Descargar ficha del usuario</a></p>
        <br clear="left" />        
        <fieldset style="width:350px">
        	<legend>Datos del Novio</legend>
            <ul class="editable">
            	<li><label>Nombre:</label><span class="edit_box" id="nombre_novio"><?php echo $cliente['nombre_novio']?></span> </li>
                <li><label>Apellidos:</label><span class="edit_box" id="apellidos_novio"><?php echo $cliente['apellidos_novio']?></span></li>
                <li><label>Direcci&oacute;n:</label><span class="edit_box" id="direccion_novio"><?php echo $cliente['direccion_novio']?></span></li>
                <li><label>CP:</label><span class="edit_box" id="cp_novio"><?php echo $cliente['cp_novio']?></span></li>
                <li><label>Poblaci&oacute;n:</label><span class="edit_box" id="poblacion_novio"><?php echo $cliente['poblacion_novio']?></span></li>
                <li><label>Telefono:</label><span class="edit_box" id="telefono_novio"><?php echo $cliente['telefono_novio']?></span></li>
                <li><label>Email:</label><span class="edit_box" id="email_novio"><?php echo $cliente['email_novio']?></span></li>
            </ul>
        </fieldset>
         <fieldset style="width:350px">
        	<legend>Datos de la Novia</legend>
            <ul>
            	<li><label>Nombre:</label><span class="edit_box" id="nombre_novia"><?php echo $cliente['nombre_novia']?></span></li>
                <li><label>Apellidos:</label><span class="edit_box" id="apellidos_novia"><?php echo $cliente['apellidos_novia']?></span></li>
                <li><label>Direcci&oacute;n:</label><span class="edit_box" id="direccion_novia"><?php echo $cliente['direccion_novia']?></span></li>
                <li><label>CP:</label><span class="edit_box" id="cp_novia"><?php echo $cliente['cp_novia']?></span></li>
                <li><label>Poblaci&oacute;n:</label><span class="edit_box" id="poblacion_novia"><?php echo $cliente['poblacion_novia']?></span></li>
                <li><label>Telefono:</label><span class="edit_box" id="telefono_novia"><?php echo $cliente['telefono_novia']?></span></li>
                <li><label>Email:</label><span class="edit_box" id="email_novia"><?php echo $cliente['email_novia']?></span></li>
            </ul>
        </fieldset>
        <br class="clear" />
       (*)Canal de captaci&oacute;n: <select name="canal_captacion">
       							<?php
								foreach($captacion as $capta) {
									if($capta['id']==$cliente['canal_captacion'])
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
       <br class="clear" />
       <br /> 
       (*)Oficina: <select name="oficina">
       							<?php
								foreach($oficinas as $ofi) {
									if($ofi['id_oficina']==$cliente['id_oficina'])
									{?>
                                		<option value="<?php echo $ofi['id_oficina']?>"><?php echo $ofi['nombre']?></option>
                                        <?php
									}
                                }?>
                                
                                <?php
                                foreach($oficinas as $ofi) {
									?>
                                		<option value="<?php echo $ofi['id_oficina']?>"><?php echo $ofi['nombre']?></option>
                                        <?php
									}
								?>
                                </select>
                                <input type="submit" name="update_oficina" value="Cambiar oficina" />
        <br /> 
        <br class="clear" />
        
        (*)Tipo de Cliente: <select name="tipo_cliente">
       							<?php
								foreach($tipos_clientes as $tipo) {
									if($tipo['id_tipo_cliente']==$cliente['id_tipo_cliente'])
									{?>
                                		<option value="<?php echo $tipo['id_tipo_cliente']?>"><?php echo $tipo['tipo_cliente']?></option>
                                        <?php
									}
                                }?>
                                
                                <?php
                                foreach($tipos_clientes as $tipo) {
									?>
                                		<option value="<?php echo $tipo['id_tipo_cliente']?>"><?php echo $tipo['tipo_cliente']?></option>
                                        <?php
									}
								?>
                                </select>
                                <input type="submit" name="update_tipo_cliente" value="Cambiar tipo de cliente" />
        <br />  
        <br class="clear" />
        
        (*)Enviar e-mails al cliente: <select name="enviar_emails" required>
       							<?php
								if($cliente['enviar_emails']=='S')
								{?>
                                		<option value="S">SÍ</option>
                                        <?php
								}else{?>
                                		<option value="N">NO</option>
                                        <?php
								}?>
									
                                    <option value=""></option>
                                	<option value="S">SÍ</option>
                                    <option value="N">NO</option>
                                </select>
                                <input type="submit" name="update_enviar_emails" value="Actualizar envío de e-mails" />
        <br />  
        <br class="clear" />
       

    </fieldset>
	<fieldset class="datos" id="datos_restaurante">
        	<legend>Datos de la boda</legend>
            <fieldset style="width:350px">
        	<legend>Lugar, fecha y hora</legend>
            <ul>
            	<li><label>Fecha de la boda:</label><span class="edit_box" id="fecha_boda"><?php echo $cliente['fecha_boda']?></span></li>
                <li><label>Hora de la boda:</label>
                <span class="edit_box" id="hora_boda"><?php echo $cliente['hora_boda']?></span></li>
                <li><label>Restaurante:</label><select id="restaurante" style="width:200px" required>
                <option value="<?php echo $cliente['id_restaurante']?>"><?php echo $cliente['restaurante']?></option>
                <option value=""></option>
                <?php
				foreach($restaurantes as $r) {
					?>
                    <option value="<?php echo $r['id_restaurante']?>"><?php echo $r['nombre']?></option>
                    <?php
				}
				?>
                </select></li> 
                <li><label>Direcci&oacute;n del Restaurante:</label><span id="direccion_restaurante"><?php echo $cliente['direccion_restaurante']?></span></li>
                <li><label>Tel&eacute;fono del Restaurante:</label><span id="telefono_restaurante"><?php echo $cliente['telefono_restaurante']?></span></li>
                <li><label>Maitre de la boda:</label><span id="maitre"><?php echo $cliente['maitre']?></span></li>
                <li><label>Tel&eacute;fono Maitre:</label><span id="telefono_maitre"><?php echo $cliente['telefono_maitre']?></span></li>
                <ul>
                <?PHP
                if(isset($cliente['restaurante_archivos'])){
					foreach($cliente['restaurante_archivos'] as $ra){
					?>
					<li><label><?php echo $ra['descripcion']?>:</label><span><a href="<?php echo base_url()?>uploads/restaurantes/<?php echo $ra['archivo']?>" target="_blank"><?php echo $ra['archivo']?></a></span></li>
                    <?php
					}
				}
                ?>
                </ul>
            </ul>                
            </fieldset>
            <fieldset style="width:350px">
        	<legend>DJ asignado</legend>
            <ul>
            	<?php 
				if($dj){
				foreach($dj as $p) { ?>
                <li style="display: block; float:left; padding:0 60px; text-align:center; border-bottom:#CCC 1px solid;">
               	<label for="dj<?php echo $p['id']?>" style="float:none; margin:0 auto; width:auto">
                <table>
                <tr>
                	<td align="center">
						<?php if($p['foto'] != '') {?>
                        <img src="<?php echo base_url() ?>uploads/djs/<?php echo $p['foto']?>"/>
                   		 <?php }?>
                	</td>
                </tr>
                <tr>
                	<td align="center">
               	 		<?php echo $p['nombre']?> <br /> Tel: <?php echo $p['telefono']?><br /> E-mail: <?php echo $p['email']?>
               		</td>
                </tr>
                </table>
               </label>
                </li>
              <?php }
				}
				else
				{
					echo "No hay DJ asignado";
				}?>
            </ul>
            Cambiar/Asignar DJ: 
            <select name="dj_id">
            <?php
			foreach($djs as $p) { ?>
            	<option value="<?php echo $p['id']?>"><?php echo $p['nombre']?></option>
                <?php
			}
			?>
            <option value="">No asignar</option>
            </select>
            <input style="width:75px;" type="submit" name="update_dj" value="Cambiar DJ" />
            
            <br><br>
            <center><strong>HORAS DE TRABAJO</strong> <a href="#" onclick="return anade_horas_dj()"><img src="<?php echo base_url() ?>img/anadir.png" width="18px" title="Añadir horas" /></a></center>
            <input type="hidden" id="horas_concepto" name="horas_concepto" value="" />
    		<input type="hidden" id="horas_dj" name="horas_dj" value="">
           <center><table class="tabledata">
           <th>CONCEPTO</th>
           <th>HORAS</th>
           <?php
		   if($horas_dj[0]<>""){
			   foreach($horas_dj as $horas){?>
					<tr>
                    	<?php
						if($horas['horas_dj']<>0){
							?>
							<td><?php echo $horas['concepto']?></td>
							<td><?php echo $horas['horas_dj']?></td>
                            <?php
						}else{
							?>
                            <td colspan="2"><?php echo $horas['concepto']?></td>
                            <?php
						}
						?>
                        <td><a href="#" onclick="return elimina_horas_dj(<?php echo $horas['id_hora_dj']?>,<?php echo $cliente['id']?>)"><img src="<?php echo base_url() ?>img/cancel.gif" width="18px" title="Eliminar horas" /></a></td>
					</tr>
				<?php
			   }
		   }
		   ?>
            <!--<span class="edit_box" id="horas_dj"><?php //echo $cliente['horas_dj']?></span>-->
            </table></center>           
            <br><br>
            Equipo componentes:
            <?php
			if($equipo_componentes_asignado){
				$se_compone_de="";
				foreach($equipo_componentes_asignado as $equipo) {
					$se_compone_de="<font size=\"+1\"><b>ESTE EQUIPO SE COMPONE DE: </b></font><br>(Haz click para ver las reparaciones de cada componente)<br>";
					foreach($componentes as $c){
						if($equipo['id_grupo']==$c['id_grupo']){
							$reparado="";
							$esta_reparado="NO";
							if($reparaciones_totales){
								foreach($reparaciones_totales as $r){
									if($c['id_componente']==$r['id_componente']){
										$reparado=$reparado."\\n".$r['fecha_reparacion']."\\n".$r['reparacion'];
										$esta_reparado="SI";
									}
								}
							}
							if($reparado==""){
								$reparado="Este componente no tiene reparaciones";
							}
							if($esta_reparado=="NO"){
								$se_compone_de=$se_compone_de.'<br><b><a onclick="alert(\''.$reparado.'\');">'.$c['n_registro'].'///'.$c['nombre_componente'].'</a></b>';
							}else{
								$se_compone_de=$se_compone_de.'<br><font color="red"><b><a onclick="alert(\''.$reparado.'\');">'.$c['n_registro'].'///'.$c['nombre_componente'].'</a></b></font>';
							}
						}
					}
					?>
                    <a href="#" onclick="muestra_componentes_equipo('<?php echo addslashes(htmlentities($se_compone_de))?>')"><b><?php echo $equipo['nombre_grupo']?></b></a><br><?php
				}
			}
			else
			{
				?><b>No asignado</b><br><?php
			}
			?>	
            <select name="equipo_componentes">
            <?php
			foreach($equipos_disponibles as $e1) { ?>
            	<option value="<?php echo $e1['id_grupo']?>"><?php echo $e1['nombre_grupo']?></option>
                <?php
			}
			?>
            <option value="">No asignar</option>
            </select>
            <input style="width:60px;" type="submit" name="update_equipo_componentes" value="Cambiar" />
            <br><br>
            Equipo Luces:
            <?php
			if($equipo_luces_asignado){
				$se_compone_de="";
				foreach($equipo_luces_asignado as $equipol) {
					$se_compone_de="<font size=\"+1\"><b>ESTE EQUIPO SE COMPONE DE: </b></font><br>(Haz click para ver las reparaciones de cada componente)<br>";
					foreach($componentes as $c){
						if($equipol['id_grupo']==$c['id_grupo']){
							$reparado="";
							$esta_reparado="NO";
							if($reparaciones_totales){
								foreach($reparaciones_totales as $r){
									if($c['id_componente']==$r['id_componente']){
										$reparado=$reparado."\\n".$r['fecha_reparacion']."\\n".$r['reparacion'];
										$esta_reparado="SI";
									}
								}
							}
							if($reparado==""){
								$reparado="Este componente no tiene reparaciones";
							}
							if($esta_reparado=="NO"){
								$se_compone_de=$se_compone_de.'<br><b><a onclick="alert(\''.$reparado.'\');">'.$c['n_registro'].'///'.$c['nombre_componente'].'</a></b>';
							}else{
								$se_compone_de=$se_compone_de.'<br><font color="red"><b><a onclick="alert(\''.$reparado.'\');">'.$c['n_registro'].'///'.$c['nombre_componente'].'</a></b></font>';
							}
						}
					}
					?>
                    <a href="#" onclick="muestra_componentes_equipo('<?php echo addslashes(htmlentities($se_compone_de))?>')"><b><?php echo $equipol['nombre_grupo']?></b></a><br><?php
				}
			}
			else
			{
				?><b>No asignado</b><br><?php
			}?>
            <select name="equipo_luces">
            <?php
			foreach($equipos_disponibles as $e2) { ?>
            	<option value="<?php echo $e2['id_grupo']?>"><?php echo $e2['nombre_grupo']?></option>
                <?php
			}
			?>
            <option value="">No asignar</option>
            </select>
            <input style="width:60px;" type="submit" name="update_equipo_luces" value="Cambiar" />
            <br><br>
            Equipo Extra1:
            <?php
			if($equipo_extra1_asignado){
				$se_compone_de="";
				foreach($equipo_extra1_asignado as $equipoe1) {
					$se_compone_de="<font size=\"+1\"><b>ESTE EQUIPO SE COMPONE DE: </b></font><br>(Haz click para ver las reparaciones de cada componente)<br>";
					foreach($componentes as $c){
						if($equipoe1['id_grupo']==$c['id_grupo']){
							$reparado="";
							$esta_reparado="NO";
							if($reparaciones_totales){
								foreach($reparaciones_totales as $r){
									if($c['id_componente']==$r['id_componente']){
										$reparado=$reparado."\\n".$r['fecha_reparacion']."\\n".$r['reparacion'];
										$esta_reparado="SI";
									}
								}
							}
							if($reparado==""){
								$reparado="Este componente no tiene reparaciones";
							}
							if($esta_reparado=="NO"){
								$se_compone_de=$se_compone_de.'<br><b><a onclick="alert(\''.$reparado.'\');">'.$c['n_registro'].'///'.$c['nombre_componente'].'</a></b>';
							}else{
								$se_compone_de=$se_compone_de.'<br><font color="red"><b><a onclick="alert(\''.$reparado.'\');">'.$c['n_registro'].'///'.$c['nombre_componente'].'</a></b></font>';
							}
						}
					}
					?>
                    <a href="#" onclick="muestra_componentes_equipo('<?php echo addslashes(htmlentities($se_compone_de))?>')"><b><?php echo $equipoe1['nombre_grupo']?></b></a><br><?php
				}
			}
			else
			{
				?><b>No asignado</b><br><?php
			}?>
            <select name="equipo_extra1">
            <?php
			foreach($equipos_disponibles as $e2) { ?>
            	<option value="<?php echo $e2['id_grupo']?>"><?php echo $e2['nombre_grupo']?></option>
                <?php
			}
			?>
            <option value="">No asignar</option>
            </select>
            <input style="width:60px;" type="submit" name="update_equipo_extra1" value="Cambiar" />
            <br><br>
            Equipo Extra2:
            <?php
			if($equipo_extra2_asignado){
				$se_compone_de="";
				foreach($equipo_extra2_asignado as $equipoe2) {
					$se_compone_de="<font size=\"+1\"><b>ESTE EQUIPO SE COMPONE DE: </b></font><br>(Haz click para ver las reparaciones de cada componente)<br>";
					foreach($componentes as $c){
						if($equipoe2['id_grupo']==$c['id_grupo']){
							$reparado="";
							$esta_reparado="NO";
							if($reparaciones_totales){
								foreach($reparaciones_totales as $r){
									if($c['id_componente']==$r['id_componente']){
										$reparado=$reparado."\\n".$r['fecha_reparacion']."\\n".$r['reparacion'];
										$esta_reparado="SI";
									}
								}
							}
							if($reparado==""){
								$reparado="Este componente no tiene reparaciones";
							}
							if($esta_reparado=="NO"){
								$se_compone_de=$se_compone_de.'<br><b><a onclick="alert(\''.$reparado.'\');">'.$c['n_registro'].'///'.$c['nombre_componente'].'</a></b>';
							}else{
								$se_compone_de=$se_compone_de.'<br><font color="red"><b><a onclick="alert(\''.$reparado.'\');">'.$c['n_registro'].'///'.$c['nombre_componente'].'</a></b></font>';
							}
						}
					}
					?>
                    <a href="#" onclick="muestra_componentes_equipo('<?php echo addslashes(htmlentities($se_compone_de))?>')"><b><?php echo $equipoe2['nombre_grupo']?></b></a><br><?php
				}
			}
			else
			{
				?><b>No asignado</b><br><?php
			}?>
            <select name="equipo_extra2">
            <?php
			foreach($equipos_disponibles as $e2) { ?>
            	<option value="<?php echo $e2['id_grupo']?>"><?php echo $e2['nombre_grupo']?></option>
                <?php
			}
			?>
            <option value="">No asignar</option>
            </select>
            <input style="width:60px;" type="submit" name="update_equipo_extra2" value="Cambiar" />
            </fieldset>
            
            <fieldset style="width:88%">
            	<legend>Encuesta del cliente respecto a la boda:</legend>
                <?php
					foreach($preguntas_encuesta_datos_boda as $preguntas) {
						?><li>- <strong><?php echo $preguntas['pregunta']?></strong></li><br><?php
						if($respuestas_encuesta_datos_boda[0]<>""){
							foreach($respuestas_encuesta_datos_boda as $respuestas) {
								if($respuestas['id_pregunta']==$preguntas['id_pregunta']){
									?><li><?php echo $respuestas['respuesta']?></li><br><?php
								}
							}
						}else{
							?><li>No hay respuesta</li><br><?php
						}
                    }?>
            </fieldset>            
    </fieldset>
    <fieldset class="datos">
        	<legend>Servicios</legend>
            <ul>
            	<?php 
				$arr_servicios = unserialize( $cliente['servicios'] );
				$total = array_sum($arr_servicios);
				$arr_serv_keys = array_keys($arr_servicios); 
				foreach($servicios as $servicio) {
					?>
            	<li><input type="checkbox" name="servicios[<?php echo $servicio['id']?>]" <?php echo in_array($servicio['id'], $arr_serv_keys) ? 'checked="checked"' : '' ?> id="chserv_<?php echo $servicio['id']?>" value="<?php echo in_array($servicio['id'], $arr_serv_keys) ? $arr_servicios[$servicio['id']] : $servicio['precio']?>" style="width:30px; vertical-align:middle" /><?php echo $servicio['nombre'] . " - ";?><input type="text" onchange="$('#chserv_<?php echo $servicio['id']?>').val(this.value)" id="precioserv_<?php echo $servicio['id']?>" name="servicio_precio[<?php echo $servicio['id']?>]" value="<?php echo in_array($servicio['id'], $arr_serv_keys) ? $arr_servicios[$servicio['id']] : $servicio['precio']?>" style="width:50px; text-align:center" /> &euro;</li>
                <?php }?>
                
             </ul>
             
             <input type="submit" name="update_servicios" value="Actualizar servicios" />
             <br /><br />
            Descuento: <input type="text" name="descuento" style="width:80px" value="<?php echo $cliente['descuento']?>" />&euro; &nbsp; <input type="submit" name="update_descuento" value="Actualizar descuento" />	
			 <br /><br />
              Total:
             <?php 
				if($cliente['descuento'] != '' && $cliente['descuento'] != '0' )
				{
					echo $total . "&euro; - " . $cliente['descuento'] . "&euro; = " . ($total - $cliente['descuento']);
					$total = $total - $cliente['descuento'];
				} else	
					echo $total;
				
				?>
               &euro;
    </fieldset>
    <fieldset>
    	<legend>Pagos, Presupuesto &amp; Contrato</legend>
        	
            <ul>
            	<li><strong>Presupuesto:</strong> <?php if($cliente['presupuesto_pdf'] != '') {?>
                <a href="<?php echo base_url() ?>uploads/pdf/<?php echo $cliente['presupuesto_pdf']?>">Descargar</a>
                <?php } else echo "No hay Presupuesto";?></li>
                <li style="padding:8px 0;"><label>Subir Presupuesto:</label> <input type="file" name="presupuesto" /> <input type="submit" name="add_presupuesto" value="Subir" /> </li>
                <li><strong>Contrato:</strong> <?php if($cliente['contrato_pdf'] != '') {?>
                <a href="<?php echo base_url() ?>uploads/pdf/<?php echo $cliente['contrato_pdf']?>">Descargar</a>
                <?php } else echo "No hay Contrato";?></li>
                <li style="padding:8px 0;"><label>Subir Contrato:</label> <input type="file" name="contrato" /> <input type="submit" name="add_contrato" value="Subir" /> </li>
                <li style="padding:8px 0;"><strong>Estado de Pagos</strong></li>
                
            <?php 
			$suma_pagos = 0;
			if(count($pagos) == 0)
				{ 
					echo "<li>A&uacute;n no se han hecho pagos</li>";
					echo '<li style="padding:8px 0;">Pago Inicial: <input type="number" step="0.01" name="valor"> ¿Pago en B? <input type="checkbox" name="tipo_pago"> ¿Enviar e-mail? <input type="checkbox" name="enviar_email_pago" checked> <input type="submit" name="add_pago" value="Subir" /></li>';
				} else {
					foreach($pagos as $p) {
						$suma_pagos = $suma_pagos + $p['valor'];?>
						<li style="padding:8px 0;"><strong><?php echo date("d-m-Y",strtotime($p['fecha'])). " - " . number_format($p['valor'], 2,",",".")?></strong>&euro; <a href="#" onclick="return deletepago('<?php echo $cliente['id']?>','<?php echo $p['valor']?>','<?php echo $p['fecha']?>')"><img src="<?php echo base_url()?>img/delete.gif" width="15" height="15" /></a></li><?php
					}
					if(count($pagos) == 1)
					{
						echo '<li style="padding:8px 0;">Segundo pago: <input type="numer" step="0.01" name="valor" value="'.number_format(($total / 2) - $suma_pagos,2,",",".").'"> ¿Pago en B? <input type="checkbox" name="tipo_pago"> ¿Enviar e-mail? <input type="checkbox" name="enviar_email_pago" checked> <input type="submit" name="add_pago" value="Subir" /></li>';
					} else {
						echo '<li style="padding:8px 0;">Siguiente pago: <input type="number" step="0.01" name="valor" value="'.
						( $cliente['descuento'] != '' && $cliente['descuento'] != '0'  ?
							number_format($total-$suma_pagos-$cliente['descuento'], 2,",",".") : number_format($total-$suma_pagos, 2)).'"> ¿Pago en B? <input type="checkbox" name="tipo_pago"> ¿Enviar e-mail? <input type="checkbox" name="enviar_email_pago" checked> <input type="submit" name="add_pago" value="Subir" /></li>';
					}
				}
				
				?>
                <li style="padding:8px 0;">Pendiente por pagar: <strong><?php 
					echo number_format(count($pagos) == 0 ? $total :  $total-$suma_pagos,2,",",".");
				?></strong>&euro;</li>
            </ul>
           <?php if(isset($msg_pdf)) echo "<p>{$msg_pdf}</p>";?>
    </fieldset>
    <fieldset class="datos">
    <legend>Factura</legend>
		<?php
           if($factura){
				echo "<label>Factura:</label> <a href=".base_url()."uploads/facturas/".urlencode(utf8_decode($factura["factura_pdf"]))." target='_blank'>".$factura["factura_pdf"]."</a>";
		   }
		   else{
			   ?>
               <ul>
               <li><label>CIF/NIF</label><input type="text" name="cif" id="cif" /></li>
               <li><label>Fecha de la factura</label><input type="text" name="fecha_factura" id="fecha_factura" /></li>
               <li><label>Facturar a</label><input type="text" name="facturar_a" id="facturar_a" value="<?php echo $cliente["nombre_novio"].' '.$cliente["apellidos_novio"]?>" /></li>
               <li><label>Dirección</label><input type="text" name="direccion" id="direccion" value="<?php echo $cliente["direccion_novio"]?>" /></li>
               <li><label>Población</label><input type="text" name="poblacion" id="poblacion" value="<?php echo $cliente["poblacion_novio"]?>" /></li>
               <li><label>CP</label><input type="text" name="cp" id="cp" value="<?php echo $cliente["cp_novio"]?>" /></li>
               <li><label>Teléfono</label><input type="text" name="telefono" id="telefono" value="<?php echo $cliente["telefono_novio"]?>" /></li>
               <li><label>E-mail</label><input type="text" name="email" id="email" value="<?php echo $cliente["email_novio"]?>" /></li>
               <li><label>Nº Factura</label><input type="text" name="n_factura" id="n_factura" /></li>
               <li><label>Concepto para ingreso</label><input type="text" name="concepto" id="concepto" /></li><br>
               <li><input type="submit" name="generar_factura" id="generar_factura" value="Generar factura" onClick="return comprueba_datos_factura()" /></li>
			   </ul><?php
		   }
		   ?>
    </fieldset>
     <fieldset class="datos"> 
        <legend>Observaciones</legend>
        <?php 
        if(!$observaciones_cliente) 
	  echo '<p style="text-align:center;padding:20px">Todav&iacute;a no se ha a&ntilde;adido observaciones</p>';
	else {
	  echo "<ul class=\"observaciones obs_admin\">";
	
	  foreach($observaciones_cliente as $observacion) { ?>
	
	    <li id="o_<?php echo $observacion['id']?>"><?php echo $observacion['comentario']." (".$observacion['fecha'] ?>)
		<a href="#" onclick="return deleteobservacion_admin(<?php echo $observacion['id']?>)"><img src="<?php echo base_url() ?>img/delete.gif" width="15" /></a> 
		</li>
	 <?php }
	  
	  echo "</ul>";
	}
	
	  ?>
        <textarea name="observaciones" style="width:600px; height:100px; float:left"></textarea>
        
        <div style="padding:20px; text-align:center"><input type="submit" name="add_observ" value="Añadir"></div>
        <div style="text-align:center; clear: left; margin-top:20px"><?php if(isset($_POST['add_observ'])) echo "Se ha añadido con &eacute;xito";?></div>
     </fieldset>   
     <div class="clear"> </div>
     <fieldset class="datos"> 
        <legend>Listado personas de contacto</legend>
		   <ul>
            	<?php 
				if($personas){
				$arr_pers_contr = explode(",", $cliente['personas_contacto']);	
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
               <input type="checkbox" name="personas_contacto[]" <?php echo in_array($p['id'], $arr_pers_contr) ? 'checked="checked"' : ''?> id="p<?php echo $p['id']?>" value="<?php echo $p['id']?>" style="width:30px" />
               
                </li>
              <?php }
				}?>
            </ul>
        	<p style="text-align:center; clear:left; padding-top:20px"><input type="submit" name="personas" value="Actualizar" /></p>
        </fieldset>
        
        <fieldset class="datos">
    	<legend>Valoración satisfacción del DJ</legend>
		   <table class="tabledata">
           <tr>
           		<th>Pregunta</th>
            	<th>Respuesta</th>
           </tr>
                <?php
				$i=1;
				foreach($valoraciones as $valoracion) { ?>
                <tr>
                	<td><?php echo $valoracion['pregunta'] ?></td>                    
                    
                    
                    <?php
					if($valoracion['id_pregunta']=='5') //pregunta de checkbox
					{
						?>
                        <td align="left" style="margin:0">          
						<?php
						if($valoracion['respuesta']<>"")
						{
							//echo $valoracion['respuesta'];
							$arr_juegos_realizados = explode(",", $valoracion['respuesta']);
							foreach($juegos as $juego) { ?>
                                <input type="checkbox" name="juegos[]" <?php echo in_array($juego['id_juego'], $arr_juegos_realizados) ? 'checked="checked"' : ''?> value="<?php echo $juego['id_juego']?>" style="width:30px; vertical-align:middle" disabled />
                                <?php echo $juego['juego']?><br />
                                <?php
							}
						}
						else
						{
							foreach($juegos as $juego) { ?>
								<input type="checkbox" name="juegos[]" id="j<?php echo $juego['id_juego']?>" value="<?php echo $juego['id_juego']?>"  style="width:30px" disabled /><?php echo $juego['juego']?><br />
								<?php
							}
						}
						?>
                        </td>
                        <?php
                    }
					else if($valoracion['id_pregunta']=='6') //pregunta de campo de texto
					{
						?><td><input type="text" value="<?php echo $valoracion['respuesta']?>" disabled></td><?php
					}
					else
					{
						?>
                        <td>
                        <?php
						if($valoracion['respuesta']<>"")
						{
							?>                    
							<div class="valoracion" data-average="<?php echo $valoracion['respuesta']?>" id="<?php echo $i?>" data-id="<?php echo $i?>"></div>
							<input type="hidden" name="res<?php echo $i?>" id="res<?php echo $i?>" size="2" maxlength="2"  value="<?php echo $valoracion['respuesta']?>" />
							<?php
						}
						else
						{
							?>
							<div class="valoracion" data-average="0" id="<?php echo $i?>" data-id="<?php echo $i?>"></div>
							<input type="hidden" name="res<?php echo $i?>" id="res<?php echo $i?>" size="2" maxlength="2"  value="" />
							<?php
						}
						?>
                        </td>
						<?php
					}
					?>  
                	
                </tr>
                <?php
				$i++;
				} ?>
           </table>
        </fieldset>
        
        <fieldset class="datos">
    		<legend>Incidencias</legend>
            <table class="tabledata">
            <tr><?php
				foreach($incidencias as $incidencia) { ?>
                	
            		<td><textarea name="incidencia" rows="10" cols="100" disabled="disabled"><?php echo $incidencia['incidencia']?></textarea></td>
                <?php
				}
				?>
            </tr>
            </table>
        </fieldset>
        
        <fieldset class="datos">
    		<legend>Canciones</legend>
            <table class="tabledata">
            <tr><?php
				foreach($canciones_pendientes as $canciones_p) { ?>
                	
            		<td><textarea name="texto_canciones_pendientes" rows="10" cols="100" disabled="disabled"><?php echo $canciones_p['canciones']?></textarea></td>
                <?php
				}
				?>
            </tr>
            </table>
        </fieldset>
    <p style="text-align:center"></p>
</form> 

</div>
<div class="clear">
</div>