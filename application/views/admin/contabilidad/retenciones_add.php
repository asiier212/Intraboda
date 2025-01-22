<link rel="stylesheet" href="<?php echo base_url() ?>js/jquery1.10.4/themes/smoothness/jquery-ui.css">
<script src="<?php echo base_url() ?>js/jquery1.10.4/js/jquery-1.10.2.js"></script>
<script src="<?php echo base_url() ?>js/jquery1.10.4/js/jquery-ui-1.10.4.js"></script>
  
<script src="<?php echo base_url() ?>js/jquery/development-bundle/ui/jquery-ui-timepicker-addon.js"></script>

<script>
	$(function() {
		$( "#fecha" ).datepicker();
		
		$("#fecha").change(function(event){
			
           if($("#tipo_retencion").val()=='IRPF'){
           		var mes=$("#fecha").val().substr(5,2);
				var anio=$("#fecha").val().substr(0,4);
				var anio_vencimiento=anio;
				var mes_vencimiento="";
				if(mes>=1 && mes<=3){
					mes_vencimiento="04";
				}else if(mes>=4 && mes<=6){
					mes_vencimiento="07";
				}else if(mes>=7 && mes<=9){
					mes_vencimiento="10";
				}else if(mes>=10 && mes<=12){
					mes_vencimiento="01";
					anio_vencimiento++;
				}
				$("#fecha_vencimiento").val(anio_vencimiento+"-"+mes_vencimiento+"-01");
		   }
		   else{
				var mes=$("#fecha").val().substr(5,2);
				var anio=$("#fecha").val().substr(0,4);
				var anio_vencimiento=anio;
				var mes_vencimiento=parseInt(mes)+1;
				if(parseInt(mes)==12){
					anio_vencimiento=parseInt(anio_vencimiento)+1;
					mes_vencimiento="01";
				}
				$("#fecha_vencimiento").val(anio_vencimiento+"-"+mes_vencimiento+"-01");
		   }
		});
		
	});
	
	</script>
   
   <h2>
        Añadir Retención
    </h2>
    
<div class="main form">
<input value="<?php echo base_url()?>" id="hiddenurl" type="hidden">

<form method="post">
	<fieldset class="datos">
    	<legend>Nueva Retención</legend>
        <ul>
        		<li><label>(*) Tipo de retención:</label>
                	<select name="tipo_retencion" id="tipo_retencion" required>
                    	<option value=""></option>
                        <option value="IRPF">IRPF</option>
                        <option value="SS">SS</option>
                    </select>
                </li>
                <li><label>(*) Oficina:</label>
                	<select name="oficina" id="oficina">
                    <?php
					foreach($oficinas as $ofi){
						?><option value="<?php echo $ofi['id_oficina']?>"><?php echo $ofi['nombre']?></option><?php
					}
					?>
                    </select>
                </li>
                <li><label>(*) Fecha:</label><input type="text" id="fecha" name="fecha" required /> </li>
                <li><label>(*) Fecha Vencimiento:</label><input type="text" id="fecha_vencimiento" name="fecha_vencimiento" readonly required /> </li>
                <li><label>(*) Concepto:</label><input type="text" id="concepto" name="concepto" required /> </li>
                <li><label>(*) Importe:</label><input type="number" step="0.01" id="importe" name="importe" required /> </li>
                <li><label>Observaciones:</label><textarea name="observaciones" id="observaciones" rows="5" cols="30"></textarea></li>
                <li><label>&nbsp;</label><input type="submit" style="width:120px" id="anadir_retencion" name="anadir_retencion" value="A&ntilde;adir Retención" /> </li>
            </ul>
    </fieldset>
	
</form>
        </div>
        <div class="clear">
        </div>