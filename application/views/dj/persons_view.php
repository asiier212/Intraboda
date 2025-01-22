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
	$("#tipo").val($("#tipo"+id).val());
	$("#nombre").val($("#nombre"+id).val());
	$("#telefono").val($("#telefono"+id).val());
	$("#email").val($("#email"+id).val());
	$("#editform").submit();
}
</script>
 <h2>
        Personas de contacto
    </h2>
<div class="main form">
   
<form method="post" enctype="multipart/form-data">
	<fieldset class="datos">
    	<legend>Nuevo contacto</legend>
		   <ul>
            	<li><label>Tipo:</label><input type="text" name="tipo" style="width:200px" /> </li>
                <li><label>Nombre:</label><input type="text" name="nombre" style="width:200px" /> </li>
                <li><label>Tel&eacute;fono:</label><input type="text" name="telefono" style="width:200px" /> </li>
                <li><label>Email:</label><input type="text" name="email" style="width:200px" /> </li>
                <li><label>Foto (max 200px de ancho):</label><input type="file" name="foto" /> </li>
                <li><label>&nbsp;</label><input type="submit" value="A&ntilde;adir" name="add" style="width:100px" /> </li>
            </ul>
            <?php if(isset($msg)) echo $msg;?>
             
        </fieldset>
       <fieldset class="datos"> 
        <legend>Listado personas de contacto</legend>
		   <ul>
            	<?php 
				if($personas){
				foreach($personas as $p) { ?>
                <li style="border-bottom:#CCC 1px solid; width:630px" id="txt<?php echo $p['id']?>">
               	<?php if($p['foto'] != '') {?>
                	<img src="<?php echo base_url() ?>uploads/personas_contacto/<?php echo $p['foto']?>" align="absmiddle" />
                <?php }?>
                <?php echo $p['tipo']?>
                <?php echo $p['nombre']?>
                <?php echo $p['telefono']?>
                <?php echo $p['email']?>
                <input style="width:60px;" type="submit" value="Borrar" name="delete" onclick="return del(<?php echo $p['id']?>)" /><input style="width:60px;" type="button" value="Editar" onclick="edit(<?php echo $p['id']?>)" />
                </li>
                <li style="border-bottom:#CCC 1px solid; width:850px; display:none" id="edit<?php echo $p['id']?>">
               	<?php if($p['foto'] != '') {?>
                	<img src="<?php echo base_url() ?>uploads/personas_contacto/<?php echo $p['foto']?>" align="absmiddle" />
                <?php }?>
                <input type="text" id="tipo<?php echo $p['id']?>" value="<?php echo $p['tipo']?>" style="width:120px" />
               <input type="text" id="nombre<?php echo $p['id']?>" value="<?php echo $p['nombre']?>" />
                <input type="text" id="telefono<?php echo $p['id']?>" value="<?php echo $p['telefono']?>" style="width:80px" />
               <input type="text" id="email<?php echo $p['id']?>" value="<?php echo $p['email']?>" style="width:120px"/>
                <input style="width:80px;" type="button" value="Cancelar" onclick="cancel(<?php echo $p['id']?>)" /><input style="width:60px;" type="button" value="Guardar" onclick="save(<?php echo $p['id']?>)" />
                </li>
              <?php }
				}?>
            </ul>
            <input type="hidden" name="elem" id="elem" />
             <?php  if($personas){ ?>
	Cambiar foto:<br />	
	<input type="file" name="foto_edit" style="width:250px" />
    <select name="foto_id">	
	<?php foreach($personas as $p) { ?>
		    <option value="<?php echo $p['id']?>"><?php echo $p['nombre']?></option>
	<?php }
	echo "</select>";
	} ?>
        	<input type="submit" name="change_foto" value="Cambiar" style="width:100px" />
        </fieldset>
       
</form>
<form method="post" id="editform">
	<input type="hidden" id="id" name="id" />
	<input type="hidden" id="tipo" name="tipo" />
    <input type="hidden" id="nombre" name="nombre" />
    <input type="hidden" id="telefono" name="telefono" />
    <input type="hidden" id="email" name="email" />
    <input type="hidden" name="edit" value="1" />
</form>


        </div>
        <div class="clear">
        </div>