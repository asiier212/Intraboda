
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery/development-bundle/ui/jquery.jeditable.js"></script>
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

function muestra_componentes_equipo(componentes){
	alertify.alert(componentes);
}
</script>
<style>
.editable img { float:right}
</style>
<h2>
        Detalles del cliente
    </h2>
<div class="main form">
<?php
  session_start(); //Sesión para controlar que no puedan acceder DJ a fichas de clientes que NO son suyos
  $_SESSION['id_dj']=  $this->session->userdata('id');
?>

<form method="post" enctype="multipart/form-data">
	<fieldset class="datos">
    	<legend>Datos de contacto</legend>
       
        <p style="text-align:right"><a style="text-decoration:underline" target="_blank" href="<?php echo base_url() ?>dj/clientes/initsession/<?php echo $cliente['id'] ?>">Iniciar Sesi&oacute;n en la cuenta del usuario</a></p>
        <p style="text-align:right"><a style="text-decoration:underline" target="_blank" href="<?php echo base_url() ?>informes/ficha.php?id_cliente=<?php echo $cliente['id']?>">Descargar ficha del usuario</a></p>
        <br clear="left" />        
        <fieldset style="width:350px">
        	<legend>Datos del Novio</legend>
            <ul class="editable">
            	<li><label>Nombre:</label><span id="nombre_novio"><?php echo $cliente['nombre_novio']?></span> </li>
                <li><label>Apellidos:</label><span id="apellidos_novio"><?php echo $cliente['apellidos_novio']?></span></li>
                <li><label>Direcci&oacute;n:</label><span id="direccion_novio"><?php echo $cliente['direccion_novio']?></span></li>
                <li><label>CP:</label><span id="cp_novio"><?php echo $cliente['cp_novio']?></span></li>
                <li><label>Poblaci&oacute;n:</label><span id="poblacion_novio"><?php echo $cliente['poblacion_novio']?></span></li>
                <li><label>Telefono:</label><span id="telefono_novio"><?php echo $cliente['telefono_novio']?></span></li>
                <li><label>Email:</label><span id="email_novio"><?php echo $cliente['email_novio']?></span></li>
            </ul>
        </fieldset>
         <fieldset style="width:350px">
        	<legend>Datos de la Novia</legend>
            <ul>
            	<li><label>Nombre:</label><span id="nombre_novia"><?php echo $cliente['nombre_novia']?></span></li>
                <li><label>Apellidos:</label><span id="apellidos_novia"><?php echo $cliente['apellidos_novia']?></span></li>
                <li><label>Direcci&oacute;n:</label><span id="direccion_novia"><?php echo $cliente['direccion_novia']?></span></li>
                <li><label>CP:</label><span id="cp_novia"><?php echo $cliente['cp_novia']?></span></li>
                <li><label>Poblaci&oacute;n:</label><span id="poblacion_novia"><?php echo $cliente['poblacion_novia']?></span></li>
                <li><label>Telefono:</label><span id="telefono_novia"><?php echo $cliente['telefono_novia']?></span></li>
                <li><label>Email:</label><span id="email_novia"><?php echo $cliente['email_novia']?></span></li>
            </ul>
        </fieldset>
        <br class="clear" />
       

    </fieldset>
	<fieldset class="datos">
        	<legend>Datos de la boda</legend>
            <ul>
            	<li><label>Fecha de la boda:</label><span id="fecha_boda"><?php echo $cliente['fecha_boda']?></span></li>
                <li><label>Hora de la boda:</label>
                <span id="hora_boda"><?php echo $cliente['hora_boda']?></span></li>
                <li><label>Restaurante:</label><span id="restaurante"><?php echo $cliente['restaurante']?></span></li>
                <li><label>Dirreci&oacute;n del Restaurante:</label><span id="direccion_restaurante"><?php echo $cliente['direccion_restaurante']?></span></li>
                <li><label>Tel&eacute;fono del Restaurante:</label><span id="telefono_restaurante"><?php echo $cliente['telefono_restaurante']?></span></li>
                <li><label>Maitre de la boda:</label><span id="maitre"><?php echo $cliente['maitre']?></span></li>
                <li><label>Tel&eacute;fono Maitre:</label><span id="telefono_maitre"><?php echo $cliente['telefono_maitre']?></span></li>
            </ul>
            <?php
            if(isset($cliente['restaurante_archivos'])){
				?><ul><?php
				foreach($cliente['restaurante_archivos'] as $ra){
					?>
					<li><label><?php echo $ra['descripcion']?>:</label><span><a href="<?php echo base_url()?>uploads/restaurantes/<?php echo $ra['archivo']?>" target="_blank"><?php echo $ra['archivo']?></a></span></li>
                    <?php
				}
				?></ul><?php
			}
			?>
            
            <br>
            <?php
            if($horas_dj){
				?>
                <fieldset>
                	<legend>Horas</legend>
				<table class="tabledata">
			   <th>CONCEPTO</th>
			   <th>HORAS</th>
               <?php
				foreach($horas_dj as $h) {
				?>
					<tr>
                    <?php
					if($h['horas_dj']<>0){
						?>
						<td><?php echo $h['concepto']?></td>
						<td><?php echo $h['horas_dj']?></td>
                        <?php
					}else{
						?>
                        <td colspan="2"><?php echo $h['concepto']?></td>
                        <?php
					}
					?>
					</tr>
				<?php
			   }
		   }
		   ?>
            </table>
            </fieldset>
    </fieldset>
    
    <fieldset class="datos">
    	<legend>Equipamiento destinado a la boda</legend>
        
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
            <br>
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
			}
			?>
            <br>
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
			}
			?>
            <br>
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
			}
			?>
        
        
        
        
        
        
        
    </fieldset>
    
    <fieldset class="datos">
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
    
    <fieldset class="datos">
    	<legend>Equipamiento</legend>
    	<ul>
            	<li>Equipo componentes:
                <?php
				if($equipo_componentes_asignado){
					foreach($equipo_componentes_asignado as $equipo) {
						?><b><?php echo $equipo['nombre_grupo']?></b><br><?php
					}
				}
				else
				{
					?><b>No asignado</b><br><?php
				}
				?></li>
                <li>Equipo luces:
                <?php
				if($equipo_luces_asignado){
					foreach($equipo_luces_asignado as $equipol) {
						?><b><?php echo $equipol['nombre_grupo']?></b><br><?php
					}
				}
				else
				{
					?><b>No asignado</b><br><?php
				}
				?></li>
        </ul>
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
            	<li><input type="checkbox" name="servicios[<?php echo $servicio['id']?>]" <?php echo in_array($servicio['id'], $arr_serv_keys) ? 'checked="checked"' : '' ?> id="chserv_<?php echo $servicio['id']?>" value="<?php echo in_array($servicio['id'], $arr_serv_keys) ? $arr_servicios[$servicio['id']] : $servicio['precio']?>" style="width:30px; vertical-align:middle" disabled /><?php echo $servicio['nombre'];?></li>
                <?php }?>
                
             </ul>
             
            
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
        <div style="text-align:center; clear: left; margin-top:20px"><?php if(isset($_POST['add_observ'])) echo "Se ha añdido con &eacute;xito";?></div>
     </fieldset>   
     <div class="clear"> </div>
    <p style="text-align:center"></p>
</form>
        </div>
        <div class="clear">
        </div>