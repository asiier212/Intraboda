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
	$("#editform").submit();
}
</script>
 <h2>
        DJs
    </h2>
<div class="main form">
   
<form method="post" enctype="multipart/form-data">
	<fieldset class="datos">
    	<legend>Nuevo DJ</legend>
		   <ul>
                <li><label>Nombre:</label><input type="text" name="nombre" style="width:200px" /> </li>
                <li><label>Tel&eacute;fono:</label><input type="text" name="telefono" style="width:200px" /> </li>
                <li><label>Email:</label><input type="text" name="email" style="width:200px" /> </li>
                <li><label>Clave:</label><input type="password" name="clave" style="width:200px" /> </li>
                <li><label>Foto (max 200px de ancho):</label><input type="file" name="foto" /> </li>
                <li><label>&nbsp;</label><input type="submit" value="A&ntilde;adir" name="add" style="width:100px" /> </li>
            </ul>
            <?php if(isset($msg)) echo $msg;?>
             
        </fieldset>
       <fieldset class="datos"> 
        <legend>Listado DJs</legend>
		   <ul>
            	<?php 
				if($djs){
				foreach($djs as $p) { ?>
                <fieldset>
                	<legend><a href="<?php echo base_url() ?>admin/djs/view/<?php echo $p['id'] ?>"><?php echo $p['nombre']?></a></legend>
                <li style="border-bottom:#CCC 1px solid; width:730px" id="txt<?php echo $p['id']?>">
                <table>
                	<tr>
                	<td>
						<?php if($p['foto'] != '') {?>
                            <img src="<?php echo base_url() ?>uploads/djs/<?php echo $p['foto']?>" align="absmiddle" />
                        <?php }?>
                    </td>
                    </tr>
                    <tr>
                    <td> 
                		Teléfono: <?php echo $p['telefono']?>
                    </td>
                    </tr>
                    <tr>
                    <td>
                		E-mail: <a style="color:#00C; font-weight:bold"><?php echo $p['email']?></a>
                    </td>
                    </tr>
                    <tr>
                    <td>
                		Contraseña: <a style="color:#F00; font-weight:bold"><?php echo $p['clave']?></a>
                    </td>
                    </tr>
                    <tr>
                    <td>
                		<input style="width:60px;" type="submit" value="Borrar" name="delete" onclick="return del(<?php echo $p['id']?>)" />
                        <input style="width:60px;" type="button" value="Editar" onclick="edit(<?php echo $p['id']?>)" />
                    </td>
                    </tr>
                </table>
                </li>
                <li style="border-bottom:#CCC 1px solid; width:850px; display:none" id="edit<?php echo $p['id']?>">
               	<?php if($p['foto'] != '') {?>
                	<img src="<?php echo base_url() ?>uploads/djs/<?php echo $p['foto']?>" align="absmiddle" />
                <?php }?>
               <input type="text" id="nombre<?php echo $p['id']?>" value="<?php echo $p['nombre']?>" />
                <input type="text" id="telefono<?php echo $p['id']?>" value="<?php echo $p['telefono']?>" style="width:80px" />
               <input type="text" id="email<?php echo $p['id']?>" value="<?php echo $p['email']?>" style="width:120px"/>
               <input type="text" id="clave<?php echo $p['id']?>" value="<?php echo $p['clave']?>" style="width:120px"/>
                <input style="width:80px;" type="button" value="Cancelar" onclick="cancel(<?php echo $p['id']?>)" /><input style="width:60px;" type="button" value="Guardar" onclick="save(<?php echo $p['id']?>)" />
                </li>
                </fieldset>
              <?php }
				}?>
            
            <br />
            <input type="hidden" name="elem" id="elem" />
             <?php  if($djs){ ?>
             <div style="clear:both">
	Cambiar foto:<br />	
	<input type="file" name="foto_edit" style="width:250px" />
    <select name="foto_id">	
	<?php foreach($djs as $p) { ?>
		    <option value="<?php echo $p['id']?>"><?php echo $p['nombre']?></option>
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
    <input type="hidden" name="edit" value="1" />
</form>


        </div>
        <div class="clear">
        </div>