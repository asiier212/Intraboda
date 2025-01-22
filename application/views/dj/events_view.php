<script language="javascript">
function del(id) {	

 if(confirm("Esta seguro?")) {
	$("#elem").val(id);
	return true;
 } else {
 	return false;
 }
 
}
</script>
  <h2>
        Momentos especiales
    </h2>
<div class="main form">
  
<form method="post" enctype="multipart/form-data">
	<fieldset class="datos">
    	<legend>Nuevo Momento especial</legend>
		   <ul>
            	<li><label>Nombre:</label><input type="text" name="nombre" style="width:300px" /> </li>
                <li><label>&nbsp;</label><input type="submit" value="A&ntilde;adir" name="add" style="width:100px" /> </li>
            </ul>
        </fieldset>
       <fieldset class="datos"> 
        <legend>Listado de Momentos especiales</legend>
		   <ul>
            	<?php 
				if($momentos){
				foreach($momentos as $m) { ?>
                <li style="border-bottom:#CCC 1px solid; width:330px"><label style="width:250px; text-align:center"><?php echo $m['nombre']?></label><input style="width:60px;" type="submit" value="Borrar" name="delete" onclick="return del(<?php echo $m['id']?>)" /></li>
              <?php }
				}
			  ?>
            </ul>
        	<input type="hidden" name="elem" id="elem" />
        </fieldset>
       
</form>
        </div>
        <div class="clear">
        </div>