<script language="javascript">
function del(id) {	

 if(confirm("Esta seguro?")) {
	$("#elem").val(id);
	return true;
 } else {
 	return false;
 }
 
}
function cancel(id) {
	$("#txt"+id).css('display', '');
	$("#edit"+id).css('display', 'none');
}
function edit(id) {
	$("#txt"+id).css('display', 'none');
	$("#edit"+id).css('display', '');
}
function save(id) {
	$("#id").val(id);
	$("#clave").val($("#clave"+id).val());
	$("#nombre").val($("#nombre"+id).val());
	$("#telefono").val($("#telefono"+id).val());
	$("#email").val($("#email"+id).val());
	$("#solo_eventos").val($("#solo_eventos"+id).val());
	if($("#solo_eventos").val()!='S' && $("#solo_eventos").val()!='N'){
		alert('Sólo eventos tan sólo puede contener S o N');
		$("#solo_eventos").focus();
		return false;
	}
	$("#id_oficina").val($("#id_oficina"+id).val());
	$("#editform").submit();
}
</script>

<script>
$(function() {
	$('#add').click(function(){
		if($('#nombre_nuevo').val()=='')
		{
			alert("Debes añadir el nombre del comercial");
			$('#nombre_nuevo').focus();
			return false;
		}
		if($('#telefono_nuevo').val()=='')
		{
			alert("Debes añadir el teléfono del comercial");
			$('#telefono_nuevo').focus();
			return false;
		}
		if($('#email_nuevo').val()=='')
		{
			alert("Debes añadir el e-mail del comercial");
			$('#email_nuevo').focus();
			return false;
		}
		if($('#clave_nuevo').val()=='')
		{
			alert("Debes añadir la clave del comercial");
			$('#clave_nuevo').focus();
			return false;
		}
     });
});
</script>

 <h2>
        Comerciales
    </h2>
<div class="main form">
   
<form method="post" enctype="multipart/form-data">
	<fieldset class="datos">
    	<legend>Nuevo comercial</legend>
		   <ul>
                <li><label>(*)Nombre:</label><input type="text" name="nombre" id="nombre_nuevo" style="width:200px" /> </li>
                <li><label>(*)Tel&eacute;fono:</label><input type="text" name="telefono" id="telefono_nuevo" style="width:200px" /> </li>
                <li><label>(*)Email:</label><input type="text" name="email" id="email_nuevo" style="width:200px" /> </li>
                <li><label>(*)Clave:</label><input type="password" name="clave" id="clave_nuevo" style="width:200px" /> </li>
                <li><label>(*)Sólo eventos:</label><input type="checkbox" name="solo_eventos" id="solo_eventos_nuevo" style=" margin: -80px; " /> </li>
                <li><label>(*)Oficina:</label>
                	<select name="oficina" id="oficina">
                    	<?php foreach($oficinas as $ofi) { ?>
                        <option value="<?php echo $ofi['id_oficina']?>"><?php echo $ofi['nombre']?></option>
                        <?php } ?>
                    </select>
                 </li>
                <li><label>Foto (max 200px de ancho):</label><input type="file" name="foto" /> </li>
                <li><label>&nbsp;</label><input type="submit" value="A&ntilde;adir" name="add" id="add" style="width:100px" /> </li>
            </ul>
            <?php if(isset($msg)) echo $msg;?>
             
        </fieldset>
       <fieldset class="datos"> 
        <legend>Listado Comerciales</legend>
		   <ul>
            	<?php 
				if($comerciales){
				foreach($comerciales as $comer) { ?>
                <fieldset>
                	<legend><?php echo $comer['nombre']?></legend>
                <li style="border-bottom:#CCC 1px solid; width:730px" id="txt<?php echo $comer['id']?>">
                <table>
                	<tr>
                	<td>
						<?php if($comer['foto'] != '') {?>
                            <img src="<?php echo base_url() ?>uploads/comerciales/<?php echo $comer['foto']?>" align="absmiddle" />
                        <?php }?>
                    </td>
                    </tr>
                    <tr>
                    <td> 
                		Teléfono: <?php echo $comer['telefono']?>
                    </td>
                    </tr>
                    <tr>
                    <td>
                		E-mail: <a style="color:#00C; font-weight:bold"><?php echo $comer['email']?></a>
                    </td>
                    </tr>
                    <tr>
                    <td>
                		Contraseña: <a style="color:#F00; font-weight:bold"><?php echo $comer['clave']?></a>
                    </td>
                    </tr>
                    <tr>
                    <td>
                		Sólo eventos: <a style="color:#F00; font-weight:bold"><?php echo $comer['solo_eventos']?></a>
                    </td>
                    </tr>
                    <tr>
                    <td>
                		Oficina: <?php echo $comer['nombre_oficina']?></a>
                    </td>
                    </tr>
                    <tr>
                    <td>
                		<input style="width:60px;" type="submit" value="Borrar" name="delete" onclick="return del(<?php echo $comer['id']?>)" />
                        <input style="width:60px;" type="button" value="Editar" onclick="edit(<?php echo $comer['id']?>)" />
                    </td>
                    </tr>
                </table>
                </li>
                <li style="border-bottom:#CCC 1px solid; width:850px; display:none" id="edit<?php echo $comer['id']?>">
               	<?php if($comer['foto'] != '') {?>
                	<img src="<?php echo base_url() ?>uploads/comerciales/<?php echo $comer['foto']?>" align="absmiddle" />
                <?php }?>
               <input type="text" id="nombre<?php echo $comer['id']?>" value="<?php echo $comer['nombre']?>" />
                <input type="text" id="telefono<?php echo $comer['id']?>" value="<?php echo $comer['telefono']?>" style="width:80px" />
               <input type="text" id="email<?php echo $comer['id']?>" value="<?php echo $comer['email']?>" style="width:120px"/>
               <input type="text" id="clave<?php echo $comer['id']?>" value="<?php echo $comer['clave']?>" style="width:120px"/>
               <input type="text" id="solo_eventos<?php echo $comer['id']?>" value="<?php echo $comer['solo_eventos']?>" style="width:120px"/>
               <select id="id_oficina<?php echo $comer['id']?>">
               		<?php
                    foreach($oficinas as $ofi) { 
						if($comer['id_oficina']==$ofi['id_oficina'])
						{
							?>
							<option value="<?php echo $ofi['id_oficina']?>"><?php echo $ofi['nombre']?></option>
                            <option value="<?php echo $ofi['id_oficina']?>"></option>
                            <?php
						}
					}
					
					foreach($oficinas as $ofi) {
					?>
                        <option value="<?php echo $ofi['id_oficina']?>"><?php echo $ofi['nombre']?></option>
                    <?php } ?>
               </select>
                <input style="width:80px;" type="button" value="Cancelar" onclick="cancel(<?php echo $comer['id']?>)" /><input style="width:60px;" type="button" id="guardar" value="Guardar" onclick="save(<?php echo $comer['id']?>)" />
                </li>
                </fieldset>
              <?php }
				}?>
            
            <br />
            <input type="hidden" name="elem" id="elem" />
             <?php  if($comerciales){ ?>
             <div style="clear:both">
	Cambiar foto:<br />	
	<input type="file" name="foto_edit" style="width:250px" />
    <select name="foto_id">	
	<?php foreach($comerciales as $comer) { ?>
		    <option value="<?php echo $comer['id']?>"><?php echo $comer['nombre']?></option>
	<?php }
	echo "</select>";
	} ?>
        	<input type="submit" name="change_foto" value="Cambiar" style="width:100px" />
            </div>
        </fieldset>
       
</form>
<form method="post" id="editform">
	<input type="hidden" id="id" name="id" />
    <input type="hidden" id="nombre" name="nombre" />
    <input type="hidden" id="telefono" name="telefono" />
    <input type="hidden" id="email" name="email" />
    <input type="hidden" id="clave" name="clave" />
    <input type="hidden" id="solo_eventos" name="solo_eventos" />
    <input type="hidden" id="id_oficina" name="id_oficina" />
    <input type="hidden" name="edit" value="1" />
</form>


        </div>
        <div class="clear">
        </div>