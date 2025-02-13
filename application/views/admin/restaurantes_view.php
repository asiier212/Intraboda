  <h2>
        Listar Restaurantes
    </h2>
<div class="main form">
  <script language="javascript" type="application/javascript">
  function confirmar() {
	if (confirm("\u00BFSeguro que desea borrar el restaurante?")) return true
	return false
}
  </script>
  
	<fieldset class="datos">
    	<legend>Restaurantes</legend>
        	<input type="button" value="Añadir un nuevo restaurante" onClick="location.href='<?php echo base_url()?>admin/restaurantes/add'"><br><br>
       		<form method="get" style="margin:10px 0">
            Buscador por: &nbsp;
            <select name="f">
            	<option value="nombre" <?php if(isset($_GET['f']) && $_GET['f'] == 'nombre') echo 'selected="selected"'?>>Nombre</option>
                <option value="direccion" <?php if(isset($_GET['f']) && $_GET['f'] == 'direccion') echo 'selected="selected"'?>>Dirección</option>
                <option value="telefono" <?php if(isset($_GET['f']) && $_GET['f'] == 'telefono') echo 'selected="selected"'?>>Teléfono</option>
                <option value="maitre" <?php if(isset($_GET['f']) && $_GET['f'] == 'maitre') echo 'selected="selected"'?>>Maitre</option>
            </select>
            	<input type="text" name="q" value="<?php if(isset($_GET['q'])) echo $_GET['q']?>">
                <input type="submit" value="Buscar" style="margin-right:30px" />
                <a href="<?php echo base_url()?>admin/restaurantes/view">Limpiar buscador</a>
            </form>
        <?php if($restaurantes) {
			
			if(isset($_GET['q']) && !isset($_GET['p']))
				$url_ord = base_url()."admin/restaurantes/view?f=".$_GET['f']."&q=".$_GET['q']."&ord=";
		 	elseif(isset($_GET['q']) && isset($_GET['p']))
		 		$url_ord = base_url()."admin/restaurantes/view?f=".$_GET['f']."&q=".$_GET['q']."&p=".$_GET['p']."&ord=";
		 	else
				$url_ord = base_url()."admin/restaurantes/view?ord=";
			
			?>
		   <table class="tabledata">
           		<tr>
                	<th><a style="color:#FFF; text-decoration:underline" href="<?php echo $url_ord ?>nombre">Nombre</a></th>
                    <th><a style="color:#FFF; text-decoration:underline" href="<?php echo $url_ord ?>direccion">Dirección</a></th>
                    <th><a style="color:#FFF; text-decoration:underline" href="<?php echo $url_ord ?>maitre">Maitre</a></th>
                    <th><a style="color:#FFF; text-decoration:underline" href="<?php echo $url_ord ?>telefono_maitre">Teléfono Maitre</a></th>
                    <th><a style="color:#FFF; text-decoration:underline" href="<?php echo $url_ord ?>hora_limite_fiesta">Hora límite de fiesta</a></th>
                    <th style="width:220px"></th>
                </tr>
                <?php foreach($restaurantes as $r) { 
				?>
                <tr>
                    <td><?php echo $r['nombre']?></td>
                    <td><?php echo $r['direccion'] ?></td>
                    <td><?php echo $r['maitre'] ?></td>
                    <td><?php echo $r['telefono_maitre'] ?></td>
                    <td><?php echo $r['hora_limite_fiesta'] ?></td>
                    <td> 
                    	<form method="post" onsubmit="return confirmar()">
                        <input type="hidden" name="id" value="<?php echo $r['id_restaurante'] ?>"> 
                        <input type="submit" name="delete_restaurante" value="Borrar" style="width:80px"> 
                        <span style="padding:0 15px">|</span>
                        <a href="<?php echo base_url() ?>admin/restaurantes/view/<?php echo $r['id_restaurante'] ?>">Ver ficha</a>
                        </form>
                        </td>
                </tr>
                <?php } ?>
           </table>
           
           <div class="pag">
        <?
		if(isset($_GET['q']) && !isset($_GET['ord']))
			$url_pag = base_url()."admin/restaurantes/view?f=".$_GET['f']."&q=".$_GET['q']."&p=";
		elseif(isset($_GET['q']) && isset($_GET['ord']))
			$url_pag =  base_url()."admin/restaurantes/view?f=".$_GET['f']."&q=".$_GET['q']."&ord=".$_GET['ord']."&p=";
		 else 
			$url_pag =  base_url()."admin/restaurantes/view?p=";
		
		
				  ?>
         <? if ($num_rows > $rows_page) {
			 	if ($page > 2) { ?>
                	<a class="pP" href="<?php=$url_pag;?><?php=$page-1;?>" title="Pagina <?php=$page-1;?>">&laquo; Anterior</a>
				<? } 
				if ($page == 2) { ?>
			    	<a href="<?php=$url_pag;?>1" title="Pagina <?php=$page-1;?>">&laquo; Anterior</a>
				<? } 
				if ($page > 3) { ?>
			    	<a href="<?php=$url_pag;?>1">1</a> ...<?
				}
				for ($i = $page - 2; $i <= $page + 2; $i++) {
					if ($i == 1) { ?>
			    		<a href="<?php=$url_pag;?>1">1</a><?
					}
			  		if ($i == $page && $i != 1) { ?>
				    	<a href="#" class="sel"><?php=$i;?></a> <?
					} elseif ($i > 1 && $i <= $last_page) { ?>
			        	<a href="<?php=$url_pag;?><?php=$i;?>" title="Pagina <?php=$i;?>"><?php=$i;?></a><?
			  		}
		 		}
				if ($i - 1 < $last_page) { ?>
			     	... <a href="<?php=$url_pag;?><?php=$last_page;?>" title="Pagina <?php=$last_page;?>"><?php=$last_page;?></a><?
				}
				if ($page < $last_page) { ?>
			  		<a class="nP" href="<?php=$url_pag;?><?php=$page+1;?>" title="Pagina <?php=$page+1;?>">Siguiente &raquo;</a><?
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