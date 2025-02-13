<link rel="stylesheet" href="<?php echo base_url() ?>js/jquery1.10.4/themes/smoothness/jquery-ui.css">
<script src="<?php echo base_url() ?>js/jquery1.10.4/js/jquery-1.10.2.js"></script>
<script src="<?php echo base_url() ?>js/jquery1.10.4/js/jquery-ui-1.10.4.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery1.10.4/js/jquery.jeditable.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/tooltip.js"></script>



<script language="javascript">
$(document).ready(function() 
	{
		$('.pestana').hide().eq(0).show();
		$('.tabs li').click(function(e)
		{
			e.preventDefault();
			$('.pestana').hide();
			$('.tabs li').removeClass("selected");
			var id = $(this).find("a").attr("href");
			$(id).fadeToggle();
			$(this).addClass("selected");
		});
		//Con esto logramos que se si realiza un búsqueda en el tab2 se mantenga el foco en esa pestaña
		<?php
			if($tab2==true){
				?>
				$('#tab-1').fadeOut(0);
				$('#tab-2').fadeIn(0);
				<?php
			}
		?>
	});

function deleteasociacioncomponenteequipo(id){
	if (confirm("\u00BFSeguro que desea desvincular la asociaci\u00f3n\u003F")) 
	{
		//$("#result").html("Actualizando...");
		$.ajax({
			type: 'POST',   
			url: '<?php echo base_url() ?>index.php/ajax/deleteasociacioncomponenteequipo', 
			data: 'id='+id, 
			success: function(data) {
					//$("#can_" + id).css("display", "none");
					//$("#result").html("");
					//location.reload();
					location.href= '<?php echo base_url() ?>admin/mantenimiento_equipos';
				}
		});
	}
	return false
}

function deleteequipo(id){
	if (confirm("\u00BFSeguro que desea borrar el equipo y todas las asociaciones\u003F")) 
	{
		//$("#result").html("Actualizando...");
		$.ajax({
			type: 'POST',   
			url: '<?php echo base_url() ?>index.php/ajax/deleteequipo', 
			data: 'id='+id, 
			success: function(data) {
					//$("#can_" + id).css("display", "none");
					//$("#result").html("");
					//location.reload();
					location.href= '<?php echo base_url() ?>admin/mantenimiento_equipos';
				}
		});
	}
	return false
}

function deletecomponente(id){
	if (confirm("\u00BFSeguro que desea borrar el componente\u003F")) 
	{
		//$("#result").html("Actualizando...");
		$.ajax({
			type: 'POST',   
			url: '<?php echo base_url() ?>index.php/ajax/deletecomponente', 
			data: 'id='+id, 
			success: function(data) {
					//$("#can_" + id).css("display", "none");
					//$("#result").html("");
					//location.reload();
					location.href= '<?php echo base_url() ?>admin/mantenimiento_equipos';
				}
		});
	}
	return false
}
function deletereparacioncomponente(id){
	if (confirm("\u00BFSeguro que desea borrar la reparación\u003F")) 
	{
		//$("#result").html("Actualizando...");
		$.ajax({
			type: 'POST',   
			url: '<?php echo base_url() ?>index.php/ajax/deletereparacioncomponente', 
			data: 'id='+id, 
			success: function(data) {
					//$("#can_" + id).css("display", "none");
					//$("#result").html("");
					//location.reload();
					location.href= '<?php echo base_url() ?>admin/mantenimiento_equipos';
				}
		});
	}
	return false
}

$(function() {
	$('#anadir_equipo').click(function(){
		if($('#nombre_equipo').val()=='')
		{
			alert("Debes añadir un nombre para el equipo");
			$('#nombre_equipo').focus();
			return false;
		}
     });
	 $('#anadir_componente').click(function(){
		if($('#n_registro').val()=='')
		{
			alert("Debes añadir un número de registro para el componente");
			$('#n_registro').focus();
			return false;
		}
		
		if($('#nombre_componente').val()=='')
		{
			alert("Debes añadir un nombre para el componente");
			$('#nombre_componente').focus();
			return false;
		}
		if($('#descripcion_componente').val()=='')
		{
			alert("Debes añadir una descripción para el componente");
			$('#descripcion_componente').focus();
			return false;
		}
     });
	 
	 $('#n_registro').focusout(function(e){
		 //alert('Hola');
		 var componentes=new Array();
		 <?php foreach($componentes as $c){?>
		 componentes.push("<?php echo $c['n_registro']?>");
		 <?php }?>
		 for(i=0; i<componentes.length; i++)
		 {
			if (componentes[i] == $('#n_registro').val()){
				alert("Ya existe un componente con ese número de serie");
				$('#n_registro').val('');
				$('#n_registro').focus();
				break;
			}
		  }
	 });
	 
	  $('#editar_grupo_equipos').change(function(event){
		  var fullurl = $('#hiddenurl').val() + 'index.php/ajax/buscardatosequipo/' + encodeURIComponent($('#editar_grupo_equipos').val());

		  $.getJSON(fullurl,function(result){
			  $.each(result,function(i,val){
				 $('#editar_nombre_equipo').val(val.nombre_grupo);
			  });
			
		  });
	 });
	 
	 $('#editar_grupo_componentes').change(function(event){
		  var fullurl = $('#hiddenurl').val() + 'index.php/ajax/buscardatoscomponente/' + encodeURIComponent($('#editar_grupo_componentes').val());

		  $.getJSON(fullurl,function(result){
			  $.each(result,function(i,val){
				 $('#editar_n_registro').val(val.n_registro);
				 $('#editar_nombre_componente').val(val.nombre_componente);
				 $('#editar_descripcion_componente').val(val.descripcion_componente);
			  });
			
		  });
	 }); 
});
</script>
    
<style>
.editable img { float:right}
</style>

<link href="<?php echo base_url() ?>css/pestanas.css" rel="stylesheet" type="text/css" />


<h2>
        Base de Datos de Equipamiento
    </h2>
<div class="main form">
 
 <input value="<?php echo base_url()?>" id="hiddenurl" type="hidden"> 

<ul class="tabs">
	<?php
	//Con esto logramos que se si realiza un búsqueda en el tab2 se mantenga seleccionada esa pestaña
	if($tab1==true){ //Esta variable viene de admin.php indicando que se va a usar de inicio el tab2
		?>
		<li class="selected"><a href="#tab-1">Equipos y componentes</a></li>
        <li><a href="#tab-2">Reparaciones</a></li>
        <?php
	}else{
		?>
        <li><a href="#tab-1">Equipos y componentes</a></li>
        <li class="selected"><a href="#tab-2">Reparaciones</a></li>
        <?php
    }
	?>
</ul>

<div class="pestana" id="tab-1"> 

	<fieldset class="datos">
    	<legend>A&ntilde;adir Equipos y componentes</legend>
        
            <div style="float:left">
            <form method="post">
            <fieldset>
            <legend>Equipo</legend>
            <label style="width:100px">Nombre:</label>
            <input type="text" name="nombre_equipo" id="nombre_equipo" required />
            <br><br>
            <input type="submit" style="width:100px; margin-left:10px; margin-left:150px;" name="anadir_equipo" id="anadir_equipo" value="A&ntilde;adir" /> 
            </fieldset>
            </form>
            </div>
            
            <div style="float:left">
            <form method="post">
            <fieldset>
            <legend>Componente</legend>
            <label style="width:100px">Nº de registro:</label>
            <input type="text" name="n_registro" id="n_registro" required /><br><br>
            <label style="width:100px">Nombre:</label>
            <input type="text" name="nombre_componente" id="nombre_componente" required /><br><br>
            <label style="width:100px">Descripción:</label>
            <textarea name="descripcion_componente" id="descripcion_componente" cols="30" rows="5" required></textarea>
            <br><br><br>
            <input type="submit" style="width:100px; margin-left:10px; margin-left:150px;" name="anadir_componente" id="anadir_componente" value="A&ntilde;adir" />
            </fieldset>
            </form>
            </div> 
               
    </fieldset>

<fieldset class="datos">
    <legend>Modificar equipos y/o componentes</legend>
    <div style="float:left">
    <fieldset>
        <form method="post">
        <legend>Equipos</legend>
            <label>Equipos:</label>
            <select style="display:block; float:left" name="editar_grupo_equipos" id="editar_grupo_equipos" required>
            	<option value="">Selecciona Equipo</option>
                <option value=""></option>
                <?php foreach($equipos as $e){?>
                <option value="<?php echo $e['id_grupo']?>"><?php echo $e['nombre_grupo']?></option>
             <?php }?>
            </select>
            <br><br><br>
            <label style="width:100px">Nombre:</label>
            <input type="text" name="editar_nombre_equipo" id="editar_nombre_equipo" required />
            <br><br><br>
            <center><input type="submit" style="width:100px;"  id="modificar_equipo"  name="modificar_equipo" value="Modificar" /></center>
        </form>
    </fieldset>
    </div>
    
    <div style="float:left">
    <fieldset>
        <form method="post">
        <legend>Componentes</legend>
            <label>Componentes:</label>
            <select style="display:block; float:left" name="editar_grupo_componentes" id="editar_grupo_componentes" required>
            	<option value="">Selecciona Componente</option>
                <option value=""></option>
                <?php foreach($componentes as $c){?>
                <option value="<?php echo $c['id_componente']?>"><?php echo $c['n_registro']?></option>
                <?php }?>
            </select>
            <br><br><br>
            <label style="width:100px">Nº de registro:</label>
            <input type="text" name="editar_n_registro" id="editar_n_registro" required /><br><br>
            <label style="width:100px">Nombre:</label>
            <input type="text" name="editar_nombre_componente" id="editar_nombre_componente" required /><br><br>
            <label style="width:100px">Descripción:</label>
            <textarea name="editar_descripcion_componente" id="editar_descripcion_componente" required cols="30" rows="5"></textarea>
            <br><br><br>
            <center><input type="submit" style="width:100px;" id="modificar_componente"  name="modificar_componente" value="Modificar" /></center>
        </form>
   </fieldset>
   </div>
</fieldset>

<form method="post">    
    <fieldset class="datos">
    	<legend>Asociar Equipos a componentes</legend>
        <label style="width:150px">Equipos:</label>
            <select style="display:block; float:left" name="grupo_equipos">
            	<?php foreach($equipos as $e){?>
            	<option value="<?php echo $e['id_grupo']?>"><?php echo $e['nombre_grupo']?></option>
                <?php }?>
            </select>
        
        <label style="width:150px">Componentes:</label>
            <select style="display:block; float:left" name="grupo_componentes">
            	<?php foreach($componentes_no_asociados as $c){?>
            	<option value="<?php echo $c['id_componente']?>"><?php echo $c['n_registro']?></option>
                <?php }?>
            </select>
            <input type="submit" style="width:100px; margin-left:10px; margin-left:150px;" name="asociar" value="Asociar" />
    </fieldset>
    
    <fieldset class="datos">
    	<legend>Equipamiento</legend>
        <?php foreach($equipos as $e){?>
        	<fieldset>
            <legend><?php echo $e['nombre_grupo']?></legend>
            <?php 
			 if($componentes_asociados != false) {
			 	?>
                <ul><?php
                foreach($componentes_asociados as $ca){
                        if($e['id_grupo'] == $ca['id_grupo']) {
							$reparaciones_realizadas="";
							if($reparaciones_totales){
								foreach($reparaciones_totales as $r) {
									if($r['id_componente']==$ca['id_componente']){
										$reparaciones_realizadas=$reparaciones_realizadas."<br>".$r['fecha_reparacion']."<br>".$r['reparacion']."<br>";
									}
								}
							}
							if($reparaciones_realizadas==""){
								$reparaciones_realizadas="<br>No hay reparaciones de este componente";
							}
                            ?><li style="list-style:none"><a onMouseOver="Tip('Nombre: <?php echo $ca['nombre_componente']?><br>Descripción: <?php echo $ca['descripcion_componente']?><br><br>Reparaciones: <?php echo $reparaciones_realizadas?>')" onMouseOut="UnTip()"><?php echo $ca['n_registro']?></a><a href="#" onclick="return deleteasociacioncomponenteequipo(<?php echo $ca['id_componente']?>)"><img src="<?php echo base_url() ?>img/cancel.gif" width="15" /></a></li><?php
                        }
				?>
                </ul><?php
                }
			 }?>
            </fieldset>
            <?php
		}?>
    </fieldset>
</form>
    
<fieldset class="datos">
    <legend>Listado Equipos y componentes</legend>
    
        <div style="float:left">
        <fieldset>
        <legend>Equipos</legend>
        <?php 
         if($equipos != false) {
            ?>
            <ul><?php
            foreach($equipos as $e){
                ?><li style="list-style:none"><?php echo $e['nombre_grupo']?><a href="#" onclick="return deleteequipo(<?php echo $e['id_grupo']?>)"><img src="<?php echo base_url() ?>img/cancel.gif" width="15" /></a></li><?php
            ?>
            </ul><?php
            }
         }?>
        </fieldset>
        </div>
        
        <div style="float:left">
        <fieldset>
        <legend>Componentes</legend>
        <?php 
         if($componentes != false) {
            ?>
            <ul><?php
            foreach($componentes as $c){
                ?><li style="list-style:none"><a onMouseOver="Tip('Nombre: <?php echo $c['nombre_componente']?><br>Descripción: <?php echo $c['descripcion_componente']?>')" onMouseOut="UnTip()"><?php echo $c['n_registro']?></a><a href="#" onclick="return deletecomponente(<?php echo $c['id_componente']?>)"><img src="<?php echo base_url() ?>img/cancel.gif" width="15" /></a></li><?php
            ?>
            </ul><?php
            }
         }?>             
        </fieldset>
        </div>   
</fieldset>
</div>

<div class="pestana" id="tab-2">
<fieldset class="datos">
    	<legend>A&ntilde;adir reparación</legend>
        
            <div style="float:left">
            <form method="post">
            <label style="width:100px">Componente:</label>
            <select style="display:block; float:left" name="reparacion_componente" id="reparacion_componente" required>
            	<option value="">Selecciona Componente</option>
                <option value=""></option>
                <?php foreach($componentes as $c){?>
                <option value="<?php echo $c['id_componente']?>"><?php echo $c['n_registro']?></option>
                <?php }?>
            </select><br>
            <label style="width:100px">Reparación:</label>
            <textarea name="descripcion_reparacion" id="descripcion_reparacion" cols="30" rows="5" required /></textarea>            <br><br>
            <input type="submit" style="width:100px; margin-left:10px; margin-left:150px;" name="anadir_reparacion" id="anadir_reparacion" value="A&ntilde;adir" /> 
            </form>
            </div>               
    </fieldset>
    
	<fieldset class="datos">
    	<legend>Reparaciones realizadas</legend>
       		<form method="get" style="margin:10px 0">
            Buscador por: &nbsp;
            <select name="f">
                <option value="n_registro" <?php if(isset($_GET['f']) && $_GET['f'] == 'componentes.n_registro') echo 'selected="selected"'?>>Nº registro componente</option>
                <option value="nombre_componente" <?php if(isset($_GET['f']) && $_GET['f'] == 'componentes.nombre_componente') echo 'selected="selected"'?>>Nombre componente</option>
                <option value="fecha_reparacion" <?php if(isset($_GET['f']) && $_GET['f'] == 'reparaciones.componentes.fecha_reparacion') echo 'selected="selected"'?>>Fecha reparacion (dd-mm-aaaa)</option>
            </select>
            	<input type="text" name="q" value="<?php if(isset($_GET['q'])) echo $_GET['q']?>">
                <input type="submit" value="Buscar" style="margin-right:30px" />
                <a href="<?php echo base_url()?>admin/mantenimiento_equipos">Limpiar buscador</a>
            </form>
        <?php 
		if($reparaciones) {
			
			if(isset($_GET['q']) && !isset($_GET['p']))
				$url_ord = base_url()."admin/mantenimiento_equipos?f=".$_GET['f']."&q=".$_GET['q']."&ord=";
		 	elseif(isset($_GET['q']) && isset($_GET['p']))
		 		$url_ord = base_url()."admin/mantenimiento_equipos?f=".$_GET['f']."&q=".$_GET['q']."&p=".$_GET['p']."&ord=";
		 	else
				$url_ord = base_url()."admin/mantenimiento_equipos?ord=";
			
			?>
		   <table class="tabledata" width="100%">
           		<tr>
                	<th width="10%">Nº registro</th>
                	<th width="25%">Componente</th>
                    <th width="25%">Fecha de reparación</a></th>
                    <th width="40%">Reparación</th>
                    <th></th>
                </tr>
                <?php 
				foreach($reparaciones as $r) { ?>
					<tr>
						<td><?php echo $r['n_registro']?></td>
						<td><?php echo $r['nombre_componente']?></td>
						<td><?php echo $r['fecha_reparacion'] ?></td>
						<td><?php echo $r['reparacion'] ?></td>
						<td><a href="#" onclick="return deletereparacioncomponente(<?php echo $r['id_reparacion']?>)"><img src="<?php echo base_url() ?>img/cancel.gif" width="15" /></a></td>
					</tr>
					<?php 
				}?>
           </table>
           
           <div class="pag">
        <?php
		if(isset($_GET['q']) && !isset($_GET['ord']))
			$url_pag = base_url()."admin/mantenimiento_equipos?f=".$_GET['f']."&q=".$_GET['q']."&p=";
		elseif(isset($_GET['q']) && isset($_GET['ord']))
			$url_pag =  base_url()."admin/mantenimiento_equipos?f=".$_GET['f']."&q=".$_GET['q']."&ord=".$_GET['ord']."&p=";
		 else 
			$url_pag =  base_url()."admin/mantenimiento_equipos?p=";
		
		
				  ?>
         <?php if ($num_rows > $rows_page) {
			 	if ($page > 2) { ?>
                	<a class="pP" href="<?php=$url_pag;?><?php=$page-1;?>" title="Pagina <?php=$page-1;?>">&laquo; Anterior</a>
				<?php } 
				if ($page == 2) { ?>
			    	<a href="<?php=$url_pag;?>1" title="Pagina <?php=$page-1;?>">&laquo; Anterior</a>
				<?php } 
				if ($page > 3) { ?>
			    	<a href="<?php=$url_pag;?>1">1</a> ...<?php
				}
				for ($i = $page - 2; $i <= $page + 2; $i++) {
					if ($i == 1) { ?>
			    		<a href="<?php=$url_pag;?>1">1</a><?php
					}
			  		if ($i == $page && $i != 1) { ?>
				    	<a href="#" class="sel"><?php=$i;?></a> <?php
					} elseif ($i > 1 && $i <= $last_page) { ?>
			        	<a href="<?php=$url_pag;?><?php=$i;?>" title="Pagina <?php=$i;?>"><?php=$i;?></a><?php
			  		}
		 		}
				if ($i - 1 < $last_page) { ?>
			     	... <a href="<?php=$url_pag;?><?php=$last_page;?>" title="Pagina <?php=$last_page;?>"><?php=$last_page;?></a><?php
				}
				if ($page < $last_page) { ?>
			  		<a class="nP" href="<?php=$url_pag;?><?php=$page+1;?>" title="Pagina <?php=$page+1;?>">Siguiente &raquo;</a><?php
				}
		 }?>       
</div> 

           <?php } else {
			echo "No hay datos";   
		   }?>
           
        </fieldset>
</div>
<p style="text-align:center"></p>

</div>
<div class="clear">
</div>