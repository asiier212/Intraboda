   <h2>
        Listar Servicios
    </h2>
    
<div class="main form">
 
<form method="post">
	<fieldset class="datos">
    	<legend>Nuevo Servicio</legend>
        <ul>
            	<li><label>Nombre:</label><input type="text" name="nombre" style="width:300px" /> </li>
                <li><label>Precio:</label><input type="text" name="precio" /> </li>
                 <li><label>Precio Oferta:</label><input type="text" name="precio_oferta" /> </li>
                <li><label>&nbsp;</label><input type="submit" style="width:120px" value="A&ntilde;adir" /> </li>
            </ul>
    </fieldset>
	<fieldset class="datos">
    	<legend>Servicios</legend>
		   <table class="tabledata">
           		<tr>
                	<th style="width:400px">Nombre</th>
                    <th>Precio</th>
                    <th>Oferta</th>
                    <th></th>
                </tr>
                <?php foreach($servicios as $servicio) { ?>
                <tr>
                	<td><?php echo $servicio['nombre'] ?></td>
                    <td><?php echo $servicio['precio'] ?></td>
                    <td><?php echo $servicio['precio_oferta'] ?></td>
                    <td><a href="<?php echo base_url() ?>dj/servicios/edit/<?php echo $servicio['id'] ?>">Editar</a></td>
                </tr>
                <?php } ?>
           </table>
        </fieldset>
       
</form>
        </div>
        <div class="clear">
        </div>