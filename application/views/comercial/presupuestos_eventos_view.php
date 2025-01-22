  <h2>
        Listar Presupuestos Eventos
    </h2>
<div class="main form">
  <script language="javascript" type="application/javascript">
  function confirmar() {
	if (confirm("\u00BFSeguro que desea borrar el presupuesto?")) return true
	return false
}
  </script>
  
	<fieldset class="datos">
    	<legend>Presupuestos Eventos</legend>
       		<form method="get" style="margin:10px 0">
            Buscar por: &nbsp;
            <select name="f">
            	<option value="nombre" <?php if(isset($_GET['f']) && $_GET['f'] == 'nombre_novia') echo 'selected="selected"'?>>Nombre</option>
                <option value="apellidos" <?php if(isset($_GET['f']) && $_GET['f'] == 'apellidos_novia') echo 'selected="selected"'?>>Apellidos</option>
                <option value="poblacion" <?php if(isset($_GET['f']) && $_GET['f'] == 'poblacion_novia') echo 'selected="selected"'?>>Población</option>
                <option value="fecha_boda" <?php if(isset($_GET['f']) && $_GET['f'] == 'fecha_boda') echo 'selected="selected"'?>>Fecha boda (dd-mm-aaaa)</option>
                <option value="restaurante" <?php if(isset($_GET['f']) && $_GET['f'] == 'restaurante') echo 'selected="selected"'?>>Restaurante</option>
                <option value="fecha_alta" <?php if(isset($_GET['f']) && $_GET['f'] == 'fecha_alta') echo 'selected="selected"'?>>Fecha de alta</option>
            </select>            
            
            <input type="text" name="q" value="<?php if(isset($_GET['q'])) echo $_GET['q']?>">
            
            <input type="submit" value="Buscar" style="margin-right:30px" />
            <a href="<?php echo base_url()?>comercial/presupuestos_eventos/view">Limpiar buscador</a>
   
            <br />
            Evento: &nbsp;
            <select name="evento">
            	<option value=""></option>
            	<?php
				foreach($eventos as $ev) {
					?>
                    
                    <option value="<?php echo $ev['id_evento']?>"><?php echo $ev['nombre_evento']?></option>
                    <?php
				}
				?>
            </select>
            <br />
            Estado: &nbsp;
            <select name="estado_solicitud">
                <option value=""></option>
            	<?php
				foreach($estados_solicitudes as $estado) {
					?>

                    <option value="<?php echo $estado['id_estado']?>"><?php echo $estado['nombre_estado']?></option>
                    <?php
				}
				?>
            </select>
            
                
            </form>
        <?php if($presupuestos_eventos) {
			
			if(isset($_GET['q']) && !isset($_GET['p']))
				$url_ord = base_url()."comercial/presupuestos_eventos/view?f=".$_GET['f']."&q=".$_GET['q']."&ord=";
		 	elseif(isset($_GET['q']) && isset($_GET['p']))
		 		$url_ord = base_url()."comercial/presupuestos_eventos/view?f=".$_GET['f']."&q=".$_GET['q']."&p=".$_GET['p']."&ord=";
		 	else
				$url_ord = base_url()."comercial/presupuestos_eventos/view?ord=";
			
			?>
            TOTAL: <?php echo $presupuestos_eventos[0]['total'];?>
		   <table class="tabledata">
           		<tr>
                    <th style="width:100px"><a style="color:#FFF; text-decoration:underline" href="<?php echo $url_ord ?>nombre">Nombre</a></th>
                    <th style="width:160px"><a style="color:#FFF; text-decoration:underline" href="<?php echo $url_ord ?>apellidos">Apellidos</a></th>
                    <th style="width:160px"><a style="color:#FFF; text-decoration:underline" href="<?php echo $url_ord ?>fecha_boda">Fecha boda</a></th>
                    <th style="width:160px"><a style="color:#FFF; text-decoration:underline" href="<?php echo $url_ord ?>restaurante">Restaurante</a></th>
                    <th style="width:200px"><a style="color:#FFF; text-decoration:underline" href="<?php echo $url_ord ?>evento">Evento</a></th>
                    <th style="width:200px"><a style="color:#FFF; text-decoration:underline" href="<?php echo $url_ord ?>evento">Fecha alta</a></th>
                    <th style="width:250px"></th>
                </tr>
                <?php foreach($presupuestos_eventos as $c) { 
				?>
                <tr>
                    <td><?php echo $c['nombre'] ?></td>
                    <td><?php echo $c['apellidos'] ?></td>
                    <td><?php echo $c['fecha_boda'] ?></td>
                    <td><?php echo $c['restaurante'] ?></td>
                    <?php
					foreach($eventos as $ev) {
						if($ev['id_evento']==$c['evento'])
						{
							?>
							<td><?php echo $ev['nombre_evento'] ?></td>
							<?php
						}
					}
					?>
                    <td><?php echo $c['fecha_alta'] ?></td>
                    <td> 
                    	<?php
						if($c['id_comercial']==$this->session->userdata('id'))
						{
							?>
							<form method="post" onsubmit="return confirmar()">
							<input type="hidden" name="id" value="<?php echo $c['id_presupuesto'] ?>"> 
							<input type="submit" name="delete_solicitud" value="Borrar" style="width:80px" 
							<span style="padding:0 15px">|</span>
                            <a href="<?php echo base_url() ?>comercial/presupuestos_eventos/view/<?php echo $c['id_presupuesto'] ?>">Ver ficha</a>
							</form>
                            <?php
						}
						else
						{
							?>
							<a href="<?php echo base_url() ?>comercial/presupuestos_eventos/view/<?php echo $c['id_presupuesto'] ?>">Ver ficha</a>
                            <?php
						}
							?>  
                        </td>
                </tr>
                <?php } ?>
           </table>
           
           <div class="pag">
        <?
		if(isset($_GET['q']) && !isset($_GET['ord']))
			$url_pag =  base_url()."comercial/presupuestos_eventos/view?f=".$_GET['f']."&q=".$_GET['q']."&p=";
		elseif(isset($_GET['q']) && isset($_GET['ord']))
			$url_pag =  base_url()."comercial/presupuestos_eventos/view?f=".$_GET['f']."&q=".$_GET['q']."&ord=".$_GET['ord']."&p=";
		if(isset($_GET['evento']))
			$url_pag=$url_pag."&evento=".$_GET['evento']."&p=";
		if(isset($_GET['estado_solicitud']))
			$url_pag=$url_pag."&estado_solicitud=".$_GET['estado_solicitud']."&p=";
		 else 
			$url_pag =  base_url()."comercial/presupuestos_eventos/view?p=";
		
		
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