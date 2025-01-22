  <h2>
        Listar Clientes
    </h2>
<div class="main form">
  <script language="javascript" type="application/javascript">
  function confirmar() {
	if (confirm("\u00BFSeguro que desea borrar la solicitud?")) return true
	return false
}
  </script>
  
	<fieldset class="datos">
    	<legend>Solicitudes</legend>
       		<form method="get" style="margin:10px 0">
            Buscar por: &nbsp;
            <select name="f">
            	<option value="nombre" <?php if(isset($_GET['f']) && $_GET['f'] == 'nombre_novia') echo 'selected="selected"'?>>Nombre</option>
                <option value="apellidos" <?php if(isset($_GET['f']) && $_GET['f'] == 'apellidos_novia') echo 'selected="selected"'?>>Apellidos</option>
                <option value="poblacion" <?php if(isset($_GET['f']) && $_GET['f'] == 'poblacion_novia') echo 'selected="selected"'?>>Población</option>
                <option value="fecha_boda" <?php if(isset($_GET['f']) && $_GET['f'] == 'fecha_boda') echo 'selected="selected"'?>>Fecha boda (dd-mm-aaaa)</option>
                <option value="n_presupuesto" <?php if(isset($_GET['f']) && $_GET['f'] == 'n_presupuesto') echo 'selected="selected"'?>>Nº presupuesto</option>
            </select>            
            
            <input type="text" name="q" value="<?php if(isset($_GET['q'])) echo $_GET['q']?>">
            
            <input type="submit" value="Buscar" style="margin-right:30px" />
            <a href="<?php echo base_url()?>comercial/solicitudes/view">Limpiar buscador</a>
                
                
            <br>
            Estado solicitud: &nbsp;
            <select name="estado_solicitud">
            	<option value=""></option>
            	<?php
				foreach($estados_solicitudes as $estado) {
					?>
                    <option value="<?php echo $estado['id_estado']?>" <?php if(isset($_GET['estado_solicitud']) && $_GET['estado_solicitud']==$estado['id_estado']) echo 'selected="selected"'?>><?php echo $estado['nombre_estado']?></option>
                    <?php
				}
				?>
            </select>
            
                
            </form>
        <?php if($solicitudes) {
			
			if(isset($_GET['q']) && !isset($_GET['p']) && !isset($_GET['estado_solicitud']))
				$url_ord = base_url()."comercial/solicitudes/view?f=".$_GET['f']."&q=".$_GET['q']."&ord=";
		 	elseif(isset($_GET['q']) && isset($_GET['p']) && !isset($_GET['estado_solicitud']))
		 		$url_ord = base_url()."comercial/solicitudes/view?f=".$_GET['f']."&q=".$_GET['q']."&p=".$_GET['p']."&ord=";
			elseif(isset($_GET['q']) && isset($_GET['p']) && isset($_GET['estado_solicitud']))
				$url_ord = base_url()."comercial/solicitudes/view?estado_solicitud=".$_GET['estado_solicitud']."&f=".$_GET['f']."&q=".$_GET['q']."&ord=";
			else
				$url_ord = base_url()."comercial/solicitudes/view?ord=";
			
			?>
		   <table class="tabledata">
           		<tr>
                	<th><a style="color:#FFF; text-decoration:underline" href="<?php echo $url_ord ?>n_presupuesto">Nº Presup.</a></th>
                    <th style="width:100px"><a style="color:#FFF; text-decoration:underline" href="<?php echo $url_ord ?>nombre">Nombre</a></th>
                    <th style="width:160px"><a style="color:#FFF; text-decoration:underline" href="<?php echo $url_ord ?>apellidos">Apellidos</a></th>
                    <th style="width:160px"><a style="color:#FFF; text-decoration:underline" href="<?php echo $url_ord ?>fecha_boda">Fecha boda</a></th>
                    <th style="width:160px"><a style="color:#FFF; text-decoration:underline" href="<?php echo $url_ord ?>restaurante">Restaurante</a></th>
                    <th style="width:200px"><a style="color:#FFF; text-decoration:underline" href="<?php echo $url_ord ?>estado_solicitud">Estado</a></th>
                    
                    <th style="width:250px"></th>
                </tr>
                <?php foreach($solicitudes as $c) { 
				?>
                <tr>
                	<td><?php echo $c['n_presupuesto'] ?></td>
                    <td><?php echo $c['nombre'] ?></td>
                    <td><?php echo $c['apellidos'] ?></td>
                    <td><?php echo $c['fecha_boda'] ?></td>
                    <td><?php echo $c['restaurante'] ?></td>
                    <?php
					foreach($estados_solicitudes as $estado) {
						if($estado['id_estado']==$c['estado_solicitud'])
						{
							?>
							<td><?php echo $estado['nombre_estado'] ?></td>
							<?php
						}
					}
					?>
                    <td> 
                    	<?php
						if($c['id_comercial']==$this->session->userdata('id'))
						{
							?>
							<form method="post" onsubmit="return confirmar()">
							<input type="hidden" name="id" value="<?php echo $c['id_solicitud'] ?>"> 
							<input type="submit" name="delete_solicitud" value="Borrar" style="width:80px" 
							<span style="padding:0 15px">|</span>
                            <a href="<?php echo base_url() ?>comercial/solicitudes/view/<?php echo $c['id_solicitud'] ?>">Ver ficha</a>
							</form>
                            <?php
						}
						else
						{
							?>
							<a href="<?php echo base_url() ?>comercial/solicitudes/view/<?php echo $c['id_solicitud'] ?>">Ver ficha</a>
                            <?php
						}
							?>  
                        </td>
                </tr>
                <?php } ?>
           </table>
           
           <div class="pag">
        <?
		if(isset($_GET['q']) && !isset($_GET['ord']) && !isset($_GET['estado_solicitud']))
			$url_pag =  base_url()."comercial/solicitudes/view?f=".$_GET['f']."&q=".$_GET['q']."&p=";
		elseif(isset($_GET['q']) && isset($_GET['ord']) && !isset($_GET['estado_solicitud']))
			$url_pag =  base_url()."comercial/solicitudes/view?f=".$_GET['f']."&q=".$_GET['q']."&ord=".$_GET['ord']."&p=";
		elseif(isset($_GET['estado_solicitud']) && !isset($_GET['ord']) && !isset($_GET['q']))
			$url_pag =  base_url()."comercial/solicitudes/view?estado_solicitud=".$_GET['estado_solicitud'];
		elseif(isset($_GET['estado_solicitud']) && isset($_GET['ord']))
			$url_pag =  base_url()."comercial/solicitudes/view?estado_solicitud=".$_GET['estado_solicitud']."&ord=".$_GET['ord']."&p=";
		elseif(isset($_GET['estado_solicitud']) && isset($_GET['q']) && !isset($_GET['ord']))
			$url_pag =  base_url()."comercial/solicitudes/view?estado_solicitud=".$_GET['estado_solicitud']."&f=".$_GET['f']."&q=".$_GET['q']."&p=";
		 else 
			$url_pag =  base_url()."comercial/solicitudes/view?p=";
		
		
				  ?>
         <? if ($num_rows > $rows_page) {
			 	if ($page > 2) { ?>
                	<a class="pP" href="<?=$url_pag;?><?=$page-1;?>" title="Pagina <?=$page-1;?>">&laquo; Anterior</a>
				<? } 
				if ($page == 2) { ?>
			    	<a href="<?=$url_pag;?>1" title="Pagina <?=$page-1;?>">&laquo; Anterior</a>
				<? } 
				if ($page > 3) { ?>
			    	<a href="<?=$url_pag;?>1">1</a> ...<?
				}
				for ($i = $page - 2; $i <= $page + 2; $i++) {
					if ($i == 1) { ?>
			    		<a href="<?=$url_pag;?>1">1</a><?
					}
			  		if ($i == $page && $i != 1) { ?>
				    	<a href="#" class="sel"><?=$i;?></a> <?
					} elseif ($i > 1 && $i <= $last_page) { ?>
			        	<a href="<?=$url_pag;?><?=$i;?>" title="Pagina <?=$i;?>"><?=$i;?></a><?
			  		}
		 		}
				if ($i - 1 < $last_page) { ?>
			     	... <a href="<?=$url_pag;?><?=$last_page;?>" title="Pagina <?=$last_page;?>"><?=$last_page;?></a><?
				}
				if ($page < $last_page) { ?>
			  		<a class="nP" href="<?=$url_pag;?><?=$page+1;?>" title="Pagina <?=$page+1;?>">Siguiente &raquo;</a><?
				}
		} ?>       
</div> 

           <?php } else {
			echo "No hay datos";   
		   }?>
           
        </fieldset>
       

        </div>
        <div class="clear">
        </div>