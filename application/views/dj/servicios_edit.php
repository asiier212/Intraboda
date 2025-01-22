   <h2>
        Editar Servicio
    </h2>
<div class="main form">
 
<form method="post" enctype="multipart/form-data">
	<fieldset class="datos">
    	<legend>Nuevo servicio</legend>
		   <ul>
            	<li><label>Nombre:</label><input type="text" name="nombre" style="width:300px" value="<?php echo $servicio['nombre']?>" /> </li>
                <li><label>Precio:</label><input type="text" name="precio" value="<?php echo $servicio['precio']?>" /> </li>
                <li><label>Precio oferta:</label><input type="text" name="precio_oferta" value="<?php echo $servicio['precio_oferta']?>" /> </li>
                <li><input type="submit" name="delete" value="Borrar" /> <input type="submit" value="Actualizar" /> </li>
            </ul>
        </fieldset>
       
</form>
        </div>
        <div class="clear">
        </div>