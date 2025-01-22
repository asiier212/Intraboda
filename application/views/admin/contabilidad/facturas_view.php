<link rel="stylesheet" href="<?php echo base_url() ?>js/jquery1.10.4/themes/smoothness/jquery-ui.css">
<script src="<?php echo base_url() ?>js/jquery1.10.4/js/jquery-1.10.2.js"></script>
<script src="<?php echo base_url() ?>js/jquery1.10.4/js/jquery-ui-1.10.4.js"></script>

<script>
	$.datepicker.regional['es'] = {
	 closeText: 'Cerrar',
	 prevText: '<Ant',
	 nextText: 'Sig>',
	 currentText: 'Hoy',
	 monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
	 monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
	 dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
	 dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
	 dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
	 weekHeader: 'Sm',
	 //dateFormat: 'dd/mm/yy',
	 dateFormat: 'yy-mm-dd',
	 firstDay: 1,
	 isRTL: false,
	 showMonthAfterYear: false,
	 yearSuffix: ''
	 };
	 $.datepicker.setDefaults($.datepicker.regional['es']);
	 
	 
	$(function() {
		$( "#fecha_desde" ).datepicker();
		$( "#fecha_hasta" ).datepicker();
		
	});
</script>

<script language="javascript" type="application/javascript">
  function borrar_factura(id) {
	if (confirm("\u00BFSeguro que desea borrar la factura?")){
		$.ajax({
			type: 'POST',   
			url: '<?php echo base_url() ?>index.php/ajax/deletefacturamanual', 
			data: 'id='+id, 
			success: function(data) {
					location.href= '<?php echo base_url() ?>admin/facturas/view';
				}
		});
		 return true
	}else{
		return false
	}
}
</script>

<h2>
        Facturas e IVAs
    </h2>
<div class="main form">
 

<form method="post">
	<fieldset class="datos">
    	<legend>Facturas</legend>
        	<ul>
            	<li><label>Desde:</label><input type="text" name="fecha_desde" id="fecha_desde" value="<?php echo $fecha_desde?>" /></li>
                <li><label>Hasta:</label><input type="text" name="fecha_hasta" id="fecha_hasta"  value="<?php echo $fecha_hasta?>"/></li>
                <li><input type="submit" value="Filtrar" /></li>
            </ul>
            
            <br><br>
            
            <?php
			//sumo los ivas de las facturas manuales
			$iva_soportado=0;
			$iva_emitido=0;
			
			if($facturas[0]<>""){
				foreach($facturas as $f){
					if($f['tipo_factura']=='soportada'){
						$iva_soportado=$iva_soportado+$f['iva'];
					}else{
						$iva_emitido=$iva_emitido+$f['iva'];
					}
				}
			}

			?>
       		
            <p><fieldset>
            <legend>Facturas entre <?php echo $fecha_desde?> y <?php echo $fecha_hasta?></legend>
            
            <table class="tabledata">
            <th>IVA Repercutido</th>
            <th>IVA Soportado</th>
            <tr>
                <td align="center"><?php echo number_format($iva_emitido,2)?> &#8364;</td>
                <td align="center"><?php echo number_format($iva_soportado,2)?> &#8364;</td>
            </tr>
            </table>
            <br>
            
            <table class="tabledata">
            <th>Fecha Factura</th>
            <th>Nº Factura</th>
            <th>Importe Bruto</th>
            <th>IVA</th>
            <th>Importe Neto</th>
            <th>Tipo Factura</th>
            <th>Acción</th>
			<?php
			if($facturas[0]<>""){
				foreach($facturas as $f)
				{
					?>
					<tr>
					<td><?php echo $f['fecha_factura']?></td>
					<td><?php echo $f['n_factura']?></td>
                    <td><?php echo $f['importe_bruto']?> &#8364;</td>
                    <td><?php echo $f['iva']?> &#8364;</td>
                    <td><?php echo $f['importe_neto']?> &#8364;</td>
                    <td><?php echo $f['tipo_factura']?></td>
                    <td>
                    	<?php
                        if($f['tipo_factura']=='Factura Cliente'){
							?><a href="<?php echo base_url() ?>admin/clientes/view/<?php echo $f['id_factura'] ?>" target="_blank">Ver ficha cliente</a></td><?php
						}else{
							?><input type="button" name="delete_factura" value="Borrar" style="width:50px" onclick="borrar_factura(<?php echo $f['id_factura']?>)"> |<a href="<?php echo base_url() ?>admin/facturas/view/<?php echo $f['id_factura'] ?>" target="_blank">Ver factura</a></td><?php
						}
						?>
					</tr>
					<?php
				}
			}
            ?>
            </table>
            </fieldset></p>

        <br class="clear" />
    </fieldset>
    <p style="text-align:center"></p>
</form> 

</div>
<div class="clear">
</div>