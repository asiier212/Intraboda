    <script type="text/javascript" src="<?php echo base_url() ?>js/jquery/development-bundle/ui/jquery.jeditable.js"></script>
 <script language="javascript">
$(document).ready(function() {
	 $('.edit_box').editable('<?php echo base_url() ?>index.php/ajax/updatedatocliente', { 
         type      : 'text',
        submit    : '<img src="<?php echo base_url() ?>img/save.gif" />',
         tooltip   : 'Click para editar...'
     });

});
</script>	
<style>
.editable img { float:right}
</style>
    <h2>
        Nuestros datos
    </h2>
<div class="main form">

<form method="post" enctype="multipart/form-data">

	<fieldset class="datos">
    	<legend>Datos de contacto</legend>
		<span style="font-size:11px">Para editar los datos haz click sobre el texto</span>
        <br clear="left" />        
        <fieldset style="width:350px">
        	<legend>Datos del Novio</legend>
            <ul class="editable">
            	<li><label>Nombre:</label><span id="nombre_novio"><?php echo $cliente['nombre_novio']?></span> </li>
                <li><label>Apellidos:</label><span id="apellidos_novio"><?php echo $cliente['apellidos_novio']?></span></li>
                <li><label>Direcci&oacute;n:</label><span id="direccion_novio"><?php echo $cliente['direccion_novio']?></span></li>
                <li><label>CP:</label><span id="cp_novio"><?php echo $cliente['cp_novio']?></span></li>
                <li><label>Poblaci&oacute;n:</label><span class="edit_box" id="poblacion_novio"><?php echo $cliente['poblacion_novio']?></span></li>
                <li><label>Tel&eacute;fono:</label><span id="telefono_novio"><?php echo $cliente['telefono_novio']?></span></li>
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
                <li><label>Tel&eacute;fono:</label><span id="telefono_novia"><?php echo $cliente['telefono_novia']?></span></li>
                <li><label>Email:</label><span id="email_novia"><?php echo $cliente['email_novia']?></span></li>
            </ul>
        </fieldset>
     </fieldset>
        <br class="clear" />
       <div style="clear:left; text-align:center; margin-top:20px">
     
      <?php if($cliente['foto'] != '') {
       	echo '<img width="400" src="'.base_url().'uploads/foto_perfil/'.$cliente['foto'].'"/>';
        } ?>
        
        <br />
       
         <!--Subir foto: <input type="file" name="foto" /> <input type="submit" style="width:90px; margin-left:50px" name="subir_foto" value="Subir" />-->
       
         <?php if(isset($msg_foto)) echo "<br>".$msg_foto;?>
         
       </div>

    </fieldset>
	<fieldset class="datos">
        	<legend>Datos de la boda</legend>
            <fieldset style="width:350px">
        	<legend>Lugar, fecha y hora</legend>
            <ul>
	<li><label>Hora de la boda:</label><span id="hora_boda"><?php echo $cliente['hora_boda']?></span></li>            	
<li><label>Fecha de la boda:</label><span id="fecha_boda"><?php echo $cliente['fecha_boda']?></span></li>

		
                <li><label>Restaurante:</label><span id="restaurante"><?php echo $cliente['restaurante']?></span></li>
                <li><label>Direcci&oacute;n del Restaurante:</label><span id="direccion_restaurante"><?php echo $cliente['direccion_restaurante']?></span></li>
                <li><label>Tel&eacute;fono del Restaurante:</label><span id="telefono_restaurante"><?php echo $cliente['telefono_restaurante']?></span></li>
                <li><label>Maitre de la boda:</label><span id="maitre"><?php echo $cliente['maitre']?></span></li>
                <li><label>Tel&eacute;fono Maitre:</label><span id="telefono_maitre"><?php echo $cliente['telefono_maitre']?></span></li>
            </ul>
            </fieldset>
            <fieldset style="width:350px">
        	<legend>DJ asignado</legend>
            <ul>
            	<?php 
				if($dj){
				foreach($dj as $p) { ?>
                <li style="display: block; float:left; padding:0 60px; text-align:center">
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
            	<li><input type="checkbox" name="servicios[<?php echo $servicio['id']?>]" <?php echo in_array($servicio['id'], $arr_serv_keys) ? 'checked="checked"' : '' ?> id="chserv_<?php echo $servicio['id']?>" value="<?php echo in_array($servicio['id'], $arr_serv_keys) ? $arr_servicios[$servicio['id']] : $servicio['precio']?>" style="width:30px; vertical-align:middle" disabled /><?php echo $servicio['nombre'];?></li>
                <?php }?>
                
             </ul>         
    </fieldset>
    <p style="text-align:center"></p>
</form>
        </div>
        <div class="clear">
        </div>