<link rel="stylesheet" href="<?php echo base_url() ?>js/jquery1.10.4/themes/smoothness/jquery-ui.css">
<script src="<?php echo base_url() ?>js/jquery1.10.4/js/jquery-1.10.2.js"></script>
<script src="<?php echo base_url() ?>js/jquery1.10.4/js/jquery-ui-1.10.4.js"></script>
  
<script src="<?php echo base_url() ?>js/jquery/development-bundle/ui/jquery-ui-timepicker-addon.js"></script>

<script>
	$(function() {
		$( "#fecha" ).datepicker();
		
		$("#lugar").change(function(event){
			$("#tipo_lugar").empty();
			$("<option value=''></option>").appendTo("#tipo_lugar");
			
           if($("#lugar").val()=='caja'){
           		$("<option value='A'>Caja A</option>").appendTo("#tipo_lugar"); 
				$("<option value='B'>Caja B</option>").appendTo("#tipo_lugar");
				$("#li_oficina").show();
		   }
		   else{
			   $("#li_oficina").hide();
			   var fullurl = $('#hiddenurl').val() + 'index.php/ajax/buscarcuentasbancarias/';
       
				$.getJSON(fullurl,function(result){
					var elements = [];
					var ids = [];
					$.each(result,function(i,val){
						elements.push(val.entidad+" - "+val.IBAN+" "+val.codigo_entidad+" "+val.codigo_oficina+" "+val.codigo_control+" "+val.numero_cuenta);
						ids.push(val.id_cuenta);
					});
						
					for (i=0; i<elements.length; i++){
						$("<option value='"+ids[i]+"'>"+elements[i]+"</option>").appendTo("#tipo_lugar");
					}
				});
		   }
        });
		
		
		$("#fecha").change(function(event){
			$("#partida_presupuestaria").empty();
			if($("#tipo_movimiento").val()=='gasto'){
					var searched = $('#fecha').val();
					var searched = searched.substr(0,4);//Cogemos sólo el año
					var fullurl = $('#hiddenurl').val() + 'index.php/ajax/buscarpartidaspresupuestarias/' + encodeURIComponent(searched);
		   
					$.getJSON(fullurl,function(result){
						var elements = [];
						var ids = [];
						$.each(result,function(i,val){
							elements.push(val.concepto);
							ids.push(val.id_partida);
						});
							
						for (i=0; i<elements.length; i++){
							$("<option value='"+ids[i]+"'>"+elements[i]+"</option>").appendTo("#partida_presupuestaria");
						}
					});
			   }
		 });
		 
		 $("#tipo_movimiento").change(function(event){
			if($("#tipo_movimiento").val()=='gasto'){
				$("#li_partida_presupuestaria").show();
			}
			else{
				$("#li_partida_presupuestaria").hide();
			}
		 });
	});
	
	</script>
   
   <h2>
        Actualizar Movimiento
    </h2>
    
<div class="main form">
<input value="<?php echo base_url()?>" id="hiddenurl" type="hidden">

<form method="post">
	<fieldset class="datos">
    	<legend>Actualizar Movimiento</legend>
        <ul>
        		<li><label>(*) Tipo de movimiento:</label>
                	<select name="tipo_movimiento" id="tipo_movimiento" required>
                    	<?php
						if($movimiento['tipo_movimiento']=="ingreso"){
							?><option value="ingreso">Ingreso</option>
                        	  <option value="gasto">Gasto</option><?php
						}else{
							?><option value="gasto">Gasto</option>
                        	  <option value="ingreso">Ingreso</option><?php
						}?>
                    </select>
                </li>
                
            	<li><label>(*) Lugar del ingreso:</label>
                	<select name="lugar" id="lugar" required>
                    	<?php
						if($movimiento['lugar']=="cuenta"){
							?><option value="cuenta">Cuenta Bancaria</option>
                        	  <option value="caja">Caja</option><?php
						}else{
							?><option value="caja">Caja</option>
                        	  <option value="cuenta">Cuenta Bancaria</option><?php
						}?>
                    </select>
                </li>
                <li><label>(*) Dónde:</label>
                	<select name="tipo_lugar" id="tipo_lugar" required>
                	<?php
					if($movimiento['tipo_lugar']<>"A" && $movimiento['tipo_lugar']<>"B"){
						foreach($cuentas_bancarias as $cuenta){
							if($cuenta['id_cuenta']==$movimiento['tipo_lugar']){
								?><option value="<?php echo $cuenta['id_cuenta']?>"><?php echo $cuenta['entidad']." - ".$cuenta['IBAN']."  ".$cuenta['codigo_entidad']."  ".$cuenta['codigo_oficina']."  ".$cuenta['codigo_control']."  ".$cuenta['numero_cuenta']?></option><?php
							}
						}
						?><option value=""></option><?php
						foreach($cuentas_bancarias as $cuenta){
							?><option value="<?php echo $cuenta['id_cuenta']?>"><?php echo $cuenta['entidad']." - ".$cuenta['IBAN']."  ".$cuenta['codigo_entidad']."  ".$cuenta['codigo_oficina']."  ".$cuenta['codigo_control']."  ".$cuenta['numero_cuenta']?></option><?php
						}
					}
					elseif($movimiento['tipo_lugar']=="A"){
						?><option value="A">Caja A</option>
						  <option value="B">Caja B</option><?php
					}else{
						?><option value="B">Caja B</option>
						  <option value="A">Caja A</option><?php
					}?>
                    </select>
                </li>
                <?php
				if($movimiento['id_oficina']==""){
					?><li id="li_oficina" style="display:none"><?php
				}else{
					?><li id="li_oficina"><?php
				}?>
                <label>(*) Oficina:</label>
                	<select name="oficina" id="oficina">
                    <?php
					foreach($oficinas as $ofi){
						if($movimiento['id_oficina']==$ofi['id_oficina']){
							?><option value="<?php echo $ofi['id_oficina']?>"><?php echo $ofi['nombre']?></option><?php
						}
					}
					?><option value=""></option><?php
					foreach($oficinas as $ofi){		
						?><option value="<?php echo $ofi['id_oficina']?>"><?php echo $ofi['nombre']?></option><?php
					}
					?>
                    </select>
                </li>
                <li><label>(*) Fecha:</label><input type="text" id="fecha" name="fecha" value="<?php echo $movimiento['fecha']?>" required /> </li>
                <li><label>(*) Concepto:</label><input type="text" id="concepto" name="concepto" value="<?php echo $movimiento['concepto']?>" required /> </li>
                <li><label>(*) Importe:</label><input type="number" step="0.01" id="importe" name="importe" value="<?php echo $movimiento['importe']?>" required /> </li>
                <?php
				if($movimiento['partida_presupuestaria']==""){
					?><li id="li_partida_presupuestaria" style="display:none"><?php
				}else{
					?><li id="li_partida_presupuestaria"><?php
				}?>
                <label>(*) Partida Presupuestaria:</label>
                	<select name="partida_presupuestaria" id="partida_presupuestaria">
                    	<?php
							foreach($partidas_presupuestarias_ano as $pa){
								if($movimiento['partida_presupuestaria']==$pa['id_partida']){
									?><option value="<?php echo $pa['id_partida']?>"><?php echo $pa['concepto']?></option><?php
								}
							}
							?><option value=""></option><?php
							foreach($partidas_presupuestarias_ano as $pa){		
								?><option value="<?php echo $pa['id_partida']?>"><?php echo $pa['concepto']?></option><?php
							}
						?>
                    </select>
                </li>
                <li><label>&nbsp;</label><input type="submit" id="actualizar_movimiento" name="actualizar_movimiento" value="Actualizar movimiento" /> </li>
            </ul>
    </fieldset>

<input value="<?php echo $movimiento['id_movimiento']?>" name="id_movimiento" id="id_movimiento" type="hidden">
</form>
        </div>
        <div class="clear">
        </div>