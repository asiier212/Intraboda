<link rel="stylesheet" href="<?php echo base_url() ?>js/jquery/development-bundle/themes/base/jquery.ui.all.css">
	
<script src="<?php echo base_url() ?>js/jquery/development-bundle/ui/jquery-ui-1.8.16.custom.min.js"></script>   
<script src="<?php echo base_url() ?>js/jquery/development-bundle/ui/jquery-ui-timepicker-addon.js"></script>

<script type="text/javascript" src="<?php echo base_url() ?>js/jquery/development-bundle/ui/jquery-ui-sliderAccess.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/tooltip.js"></script>
        
    
	
	<link rel="stylesheet" href="<?php echo base_url() ?>js/jquery/development-bundle/demos/demos.css">
	<script>
	$(function() {
		$( "#calendar" ).datepicker();
		$( "#calendar_nomina" ).datepicker();
		
		$('#anadir_contrato').click(function(){
			if($('#nombre_contrato').val()=='')
			{
				alert("Debes añadir un nombre al contrato");
				$('#nombre_contrato').focus();
				return false;
			}
			if($('#calendar').val()=='')
			{
				alert("Debes añadir una fecha al contrato");
				$('#calendar').focus();
				return false;
			}
			if($('#contrato_pdf').val()=='')
			{
				alert("Debes añadir un contrato");
				$('#contrato_pdf').focus();
				return false;
			}
     	});
		
		$('#anadir_nomina').click(function(){
			if($('#nombre_nomina').val()=='')
			{
				alert("Debes añadir un nombre a la nómina");
				$('#nombre_nomina').focus();
				return false;
			}
			if($('#calendar_nomina').val()=='')
			{
				alert("Debes añadir una fecha a la nómina");
				$('#calendar_nomina').focus();
				return false;
			}
			if($('#nomina_pdf').val()=='')
			{
				alert("Debes añadir una nómina");
				$('#nomina_pdf').focus();
				return false;
			}
     	});
		
		$("#buscar_contrato").click(function() {  
        if (isNaN($("#ano_contrato").val()))
		{
			alert("El año del contrato no es válido");
			$("#ano_contrato").focus();
			return false;
		} 
    	});
		
		$("#buscar_nomina").click(function() {  
        if (isNaN($("#ano_nomina").val()))
		{
			alert("El año de la nómina no es válido");
			$("#ano_nomina").focus();
			return false;
		} 
    	});
	});
	
function deletecontratodj(id, id_dj){
	if (confirm("\u00BFSeguro que desea eliminar el contrato\u003F")) 
	{
		//$("#result").html("Actualizando...");
		$.ajax({
			type: 'POST',   
			url: '<?php echo base_url() ?>index.php/ajax/deletecontratodj', 
			data: 'id='+id, 
			success: function(data) {
					//$("#can_" + id).css("display", "none");
					//$("#result").html("");
					//location.reload();
					location.href= '<?php echo base_url() ?>admin/djs/view/'+id_dj;
				}
		});
	}
	return false
}

function deletenominadj(id, id_dj){
	if (confirm("\u00BFSeguro que desea eliminar la nómina\u003F")) 
	{
		//$("#result").html("Actualizando...");
		$.ajax({
			type: 'POST',   
			url: '<?php echo base_url() ?>index.php/ajax/deletenominadj', 
			data: 'id='+id, 
			success: function(data) {
					//$("#can_" + id).css("display", "none");
					//$("#result").html("");
					//location.reload();
					location.href= '<?php echo base_url() ?>admin/djs/view/'+id_dj;
				}
		});
	}
	return false
}
	
</script>
        
 <h2>
        DETALLE DE DJS
 </h2>
<div class="main form">

<?php 
if($dj){
foreach($dj as $p) { 
	$id_dj=$p['id'];?>   
    <fieldset class="datos"> 
      <legend>Datos del DJ</legend>
         <ul>
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
                  	Nombre: <?php echo $p['nombre']?>
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
              </table>
              </li>
<?php }?></ul><?php
  }?>
</fieldset>

<form method="post"  enctype="multipart/form-data">
<fieldset class="datos">
	<legend>Contratos</legend>
    <fieldset>
    	<legend>Nuevo contrato</legend>
		   <ul>
                <li><label>(*) Nombre:</label><input type="text" name="nombre_contrato" id="nombre_contrato" style="width:200px" /> </li>
                <li><label>(*) Fecha:</label><input type="text" name="fecha_contrato" id="calendar" style="width:200px" /> </li>
                <li><label>(*) Contrato:</label><input type="file" name="contrato_pdf" id="contrato_pdf" /> </li>
                <li><label>&nbsp;</label><input type="submit" value="A&ntilde;adir" name="anadir_contrato" id="anadir_contrato" style="width:100px" /> </li>
                <input type="hidden" name="id_dj" id="id_dj" value="<?php echo $id_dj?>">
            </ul>             
    </fieldset>
    <div style="float:left">
    <?php
    if(isset($contratos[0]['id_contrato'])){
		?>
        <b>AÑO</b> <form method="post"><input type="text" name="ano_contrato" id="ano_contrato" value="<?php echo $contratos[0]['ano_contrato'];?>" style="width:40px"><input type="submit" value="Buscar" name="buscar_contrato" id="buscar_contrato" style="width:60px"></form>
        <br><br>
        <ul><?php
		foreach($contratos as $c) {
            echo "<li><a onMouseOver=\"Tip('Nombre: ".$c['nombre_contrato']." <br>Fecha: ".$c['fecha_contrato']."')\" onMouseOut=\"UnTip()\" href=".base_url()."uploads/contratos_djs/".$c["contrato_pdf"]." target='_blank'>".$c["contrato_pdf"]."</a> <a href='#' onclick='return deletecontratodj(".$c['id_contrato'].", ".$id_dj.")'><img src='".base_url()."img/cancel.gif' width='15' /></a></li>";
		}
		?></ul><?php
	}
	else
	{
		?><b>AÑO</b> <form method="post"><input type="text" name="ano_contrato" id="ano_contrato" value="<?php echo $contratos[0]['ano_contrato'];?>" style="width:40px"><input type="submit" value="Buscar" name="buscar_contrato" id="buscar_contrato" style="width:60px"></form><?php
	}
	?>
    </div>
</fieldset>
</form>

<form method="post"  enctype="multipart/form-data">
<fieldset class="datos">
	<legend>Nóminas</legend>
    <fieldset>
    	<legend>Nueva nomina</legend>
		   <ul>
                <li><label>(*) Nombre:</label><input type="text" name="nombre_nomina" id="nombre_nomina" style="width:200px" /> </li>
                <li><label>(*) Fecha:</label><input type="text" name="fecha_nomina" id="calendar_nomina" style="width:200px" /> </li>
                <li><label>(*) Nómina:</label><input type="file" name="nomina_pdf" id="nomina_pdf" /> </li>
                <li><label>&nbsp;</label><input type="submit" value="A&ntilde;adir" name="anadir_nomina" id="anadir_nomina" style="width:100px" /> </li>
                <input type="hidden" name="id_dj" id="id_dj" value="<?php echo $id_dj?>">
            </ul>             
    </fieldset>
    <div style="float:left">
    <?php
    if(isset($nominas[0]['id_nomina'])){
		?>
        <b>AÑO</b> <form method="post"><input type="text" name="ano_nomina" id="ano_nomina" value="<?php echo $nominas[0]['ano_nomina'];?>" style="width:40px"><input type="submit" value="Buscar" name="buscar_nomina" id="buscar_nomina" style="width:60px"></form>
        <br><br>
        <ul><?php
		foreach($nominas as $n) {
            echo "<li><a onMouseOver=\"Tip('Nombre: ".$n['nombre_nomina']." <br>Fecha: ".$n['fecha_nomina']."')\" onMouseOut=\"UnTip()\" href=".base_url()."uploads/nominas_djs/".$n["nomina_pdf"]." target='_blank'>".$n["nomina_pdf"]."</a> <a href='#' onclick='return deletenominadj(".$n['id_nomina'].", ".$id_dj.")'><img src='".base_url()."img/cancel.gif' width='15' /></a></li>";
		}
		?></ul><?php
	}
	else
	{
		?><b>AÑO</b> <form method="post"><input type="text" name="ano_nomina" id="ano_nomina" value="<?php echo $nominas[0]['ano_nomina'];?>" style="width:40px"><input type="submit" value="Buscar" name="buscar_nomina" id="buscar_nomina" style="width:60px"></form><?php
	}?>
    </div>
</fieldset>
</form>
<div class="clear">
</div>