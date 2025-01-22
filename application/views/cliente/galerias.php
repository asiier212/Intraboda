  <h2>
        Galerias de fotos
    </h2>
<div class="main">
  
    <fieldset class="datos">
    	<legend>Mis Galerias</legend>
			<ul>
           <?php if($galerias){
				foreach($galerias as $g) { ?>
                <li><label><strong><?php echo $g['nombre'] ?></strong></label><a href="<?php echo base_url() ?>galeria/show/<?php echo $g['id'] ?>/<?php echo $g['auth_code'] ?>">Ver & Compartir</a> | <a href="<?php echo base_url() ?>cliente/galeria/<?php echo $g['id'] ?>">Gestionar fotos</a> </li>
           	<?php }
		   } else { ?>
           		<li>Todavia no tienes ninguna galeria</li>
           <?php } ?>     
            </ul>
        
        
    </fieldset>
    <form method="post">
    <fieldset class="datos">
    	<legend>Nueva Galeria</legend>
        <ul>
           	<li><label>Nombre:</label><input type="text" name="nombre" /><input type="submit" style="width:100px; margin-left:10px" value="A&ntilde;adir" /></li>
         
        </ul>        
    </fieldset>
    </form>
 </div>
<div class="clear"></div>