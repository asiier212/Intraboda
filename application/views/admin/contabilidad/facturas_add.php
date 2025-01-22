<link rel="stylesheet" href="<?php echo base_url() ?>js/jquery1.10.4/themes/smoothness/jquery-ui.css">
<script src="<?php echo base_url() ?>js/jquery1.10.4/js/jquery-1.10.2.js"></script>
<script src="<?php echo base_url() ?>js/jquery1.10.4/js/jquery-ui-1.10.4.js"></script>
  
<script src="<?php echo base_url() ?>js/jquery/development-bundle/ui/jquery-ui-timepicker-addon.js"></script>

<script>
	$(function() {
		$( "#fecha_factura" ).datepicker();	
	});
	
	</script>
   
   <h2>
        Añadir Factura
    </h2>
    
<div class="main form">
 
<form method="post">
	<fieldset class="datos">
    	<legend>Nueva Factura</legend>
        <ul>
            	<li><label>(*) Nº Factura:</label><input type="text" id="n_factura" name="n_factura" required /> </li>
                <li><label>(*) Importe bruto:</label><input type="number" step="0.01" id="importe_bruto" name="importe_bruto" required /> </li>
                <li><label>(*) IVA:</label><input type="number" step="0.01" id="iva" name="iva" required /> </li>
                <li><label>(*) Importe neto:</label><input type="number" step="0.01" id="importe_neto" name="importe_neto" required /> </li>
                <li><label>(*) Fecha factura:</label><input type="text" id="fecha_factura" name="fecha_factura" required /> </li>
                <li><label>(*) Tipo factura:</label>
                	<select id="tipo_factura" name="tipo_factura">
                    	<option value="soportada">Soportada</option>
                    	<option value="emitida">Emitida</option>
                    </select>
                
                </li>
                <li><label>Observaciones:</label><textarea name="observaciones" style="width:600px; height:100px; float:left"></textarea> </li>
                <li><label>&nbsp;</label><input type="submit" style="width:120px" id="anadir_factura" name="anadir_factura" value="A&ntilde;adir Factura" /> </li>
            </ul>
    </fieldset>
	
</form>
        </div>
        <div class="clear">
        </div>