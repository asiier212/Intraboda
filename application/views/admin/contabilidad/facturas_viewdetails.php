<script type="text/javascript" src="<?php echo base_url() ?>js/jquery/development-bundle/ui/jquery.jeditable.js"></script>
    


 <script language="javascript">
$(document).ready(function() {
	 $('.edit_box').editable('<?php echo base_url() ?>index.php/ajax/updatefacturamanual/<?php echo $factura['id_factura']?>', { 
         type      : 'text',
        submit    : '<img src="<?php echo base_url() ?>img/save.gif" />',
         tooltip   : 'Click para editar...',
     });
});

</script>
    

<h2>
        Detalles de la factura
</h2>
<div class="main form">
 
<form method="post" >
	<fieldset class="datos">
    	<legend>Datos de la factura</legend>
       
            <ul class="editable">
            	<li><label>Nº Factura:</label><span class="edit_box" id="n_factura"><?php echo $factura['n_factura']?></span> </li>
                <li><label>Importe bruto:</label><span class="edit_box" id="importe_bruto"><?php echo $factura['importe_bruto']?></span> </li>
                <li><label>IVA:</label><span class="edit_box" id="iva"><?php echo $factura['iva']?></span> </li>
                <li><label>Importe Neto:</label><span class="edit_box" id="importe_neto"><?php echo $factura['importe_neto']?></span> </li>
                <li><label>Fecha factura:</label><span class="edit_box" id="fecha_factura"><?php echo $factura['fecha_factura']?></span> </li>
                <li><label>Observaciones:</label><span class="edit_box" id="observaciones"><?php echo $factura['observaciones']?></span> </li>
                <li><label>Tipo Factura:</label>
                	<select name="tipo_factura" id="tipo_factura">
                    	<option value="<?php echo $factura['tipo_factura']?>"><?php echo $factura['tipo_factura']?></option>
                        <option value="soportada">Soportada</option>
                    	<option value="emitida">Emitida</option>
                    </select>
                    <input type="submit" name="cambiar_tipo_factura" id="cambiar_tipo_factura" value="Cambiar">
                </li>
            </ul>
        
    </fieldset>
    <p style="text-align:center"></p>
</form> 

</div>
<div class="clear">
</div>