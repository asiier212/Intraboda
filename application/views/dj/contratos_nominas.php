<link rel="stylesheet" href="<?php echo base_url() ?>js/jquery/development-bundle/themes/base/jquery.ui.all.css">
	
<script src="<?php echo base_url() ?>js/jquery/development-bundle/ui/jquery-ui-1.8.16.custom.min.js"></script>   

<script type="text/javascript" src="<?php echo base_url() ?>js/jquery/development-bundle/ui/jquery-ui-sliderAccess.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/tooltip.js"></script>
        
    
	
	<link rel="stylesheet" href="<?php echo base_url() ?>js/jquery/development-bundle/demos/demos.css">
	<script>
	$(function() {
		
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
	
</script>
        
 <h2>
        CONTRATOS Y NÓMINAS
 </h2>
<div class="main form">


<?php
if($dj){
	foreach($dj as $p) { 
		$id_dj=$p['id'];
	?>

<fieldset class="datos">
	<legend>Contratos y nóminas</legend>
    
    <fieldset>
    	<legend>Datos del DJ</legend>
        <ul>
              <li style="border-bottom:#CCC 1px solid; width:200px" id="txt<?php echo $p['id']?>">
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
<?php }?></ul></fieldset><?php
  }?>
  
    
    
    
	
    <fieldset>
	<legend>Contratos</legend>
    <div style="float:left; width:200px;">
    <form method="post">
    <?php
    if(isset($contratos[0]['id_contrato'])){
		?>
        <b>AÑO</b> <input type="text" name="ano_contrato" id="ano_contrato" value="<?php echo $contratos[0]['ano_contrato'];?>" style="width:40px"><input type="submit" value="Buscar" name="buscar_contrato" id="buscar_contrato" style="width:60px"></form>
        <br><br>
        <ul><?php
		foreach($contratos as $c) {
            echo "<li><a onMouseOver=\"Tip('Nombre: ".$c['nombre_contrato']." <br>Fecha: ".$c['fecha_contrato']."')\" onMouseOut=\"UnTip()\" href=".base_url()."uploads/contratos_djs/".$c["contrato_pdf"]." target='_blank'>".$c["contrato_pdf"]."</a></li>";
		}
		?></ul><?php
	}
	else
	{
		?><b>AÑO</b> <input type="text" name="ano_contrato" id="ano_contrato" value="<?php echo $contratos[0]['ano_contrato'];?>" style="width:40px"><input type="submit" value="Buscar" name="buscar_contrato" id="buscar_contrato" style="width:60px"></form><?php
	}
	?>
    </div>
	</fieldset>
    
    <fieldset>
	<legend>Nóminas</legend>
    <div style="float:left; width:200px;">
    	<form method="post">
	<?php
    if(isset($nominas[0]['id_nomina'])){
		?>
        <b>AÑO</b> <input type="text" name="ano_nomina" id="ano_nomina" value="<?php echo $nominas[0]['ano_nomina'];?>" style="width:40px"><input type="submit" value="Buscar" name="buscar_nomina" id="buscar_nomina" style="width:60px"></form>
        <br><br>
        <ul><?php
		foreach($nominas as $n) {
            echo "<li><a onMouseOver=\"Tip('Nombre: ".$n['nombre_nomina']." <br>Fecha: ".$n['fecha_nomina']."')\" onMouseOut=\"UnTip()\" href=".base_url()."uploads/nominas_djs/".$n["nomina_pdf"]." target='_blank'>".$n["nomina_pdf"]."</a></li>";
		}
		?></ul><?php
	}
	else
	{
		?><b>AÑO</b> <input type="text" name="ano_nomina" id="ano_nomina" value="<?php echo $nominas[0]['ano_nomina'];?>" style="width:40px"><input type="submit" value="Buscar" name="buscar_nomina" id="buscar_nomina" style="width:60px"></form><?php
	}?>
    </div>
    </fieldset>
</fieldset>
<div class="clear">
</div>