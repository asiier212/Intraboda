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
  function borrar_retencion(id) {
	if (confirm("\u00BFSeguro que desea borrar la retención?")){
		$.ajax({
			type: 'POST',   
			url: '<?php echo base_url() ?>index.php/ajax/deleteretencion', 
			data: 'id='+id, 
			success: function(data) {
					location.href= '<?php echo base_url() ?>admin/retenciones/view';
				}
		});
		 return true
	}else{
		return false
	}
}
  </script>

<h2>
        IRPF y SS
    </h2>
<div class="main form">

<input value="<?php echo base_url()?>" id="hiddenurl" type="hidden"> 

<form method="post">
	<fieldset class="datos">
    	<legend>IRPF y SS</legend>
        	<ul>
            	<li><label>(*) Desde:</label><input type="text" name="fecha_desde" id="fecha_desde" value="<?php echo $fecha_desde?>" required /></li>
                <li><label>(*) Hasta:</label><input type="text" name="fecha_hasta" id="fecha_hasta"  value="<?php echo $fecha_hasta?>" required /></li>
                <li><label>Tipo de retención:</label>
                	<select name="tipo_retencion" id="tipo_retencion">
                    	<option value=""></option>
                        <option value="IRPF">IRPF</option>
                        <option value="SS">SS</option>
                    </select>
                </li>
                <li><label>Año Resumen por meses IRPF y SS:</label>
                <?php
				$anio_actual=date("Y");
				?>
                <select name="anio" id="anio">
                	<option value="<?php echo $anio_actual?>"><?php echo $anio_actual?></option>
                	<?php
					for($i=$anio_actual-5;$i<=$anio_actual+5;$i++){
						?>
                        <option value="<?php echo $i?>"><?php echo $i?></option>
                        <?php
					}?>
                </select>
                <li><label>Oficina:</label>
                	<select name="oficina" id="oficina">
                    <?php
					foreach($oficinas as $ofi){
						?><option value="<?php echo $ofi['id_oficina']?>"><?php echo $ofi['nombre']?></option><?php
						if($id_oficina==$ofi['id_oficina']){
							$nombre_oficina=$ofi['nombre'];
						}
					}
					?>
                    </select>
                </li>
                <li><input type="submit" value="Filtrar" /></li>
            </ul>
            
            <br><br>
            
            <p><fieldset>
            <legend>IRPF y SS entre <?php echo $fecha_desde?> y <?php echo $fecha_hasta?> en la oficina <?php echo $nombre_oficina?></legend>
            
            <table class="tabledata">
            <tr><th colspan="14">Resumen por meses de IRPF y SS del año <?php echo $anio?> y la oficina <?php echo $nombre_oficina?></th></tr>
            <th>Tipo</th>
            <th>Enero</th>
            <th>Febrero</th>
            <th>Marzo</th>
            <th>Abril</th>
            <th>Mayo</th>
            <th>Junio</th>
            <th>Julio</th>
            <th>Agosto</th>
            <th>Sept.</th>
            <th>Octubre</th>
            <th>Noviem.</th>
            <th>Diciem.</th>
            <th>TOTAL</th>
            <?php			
           
				?>
                <tr>
				<td><strong>IRPF</strong></td>
                <?php
				$total=0;
				if($retenciones_anuales[0]<>""){
					for($mes=1;$mes<=12;$mes++){
						$imp="";
						foreach($retenciones_anuales as $reten){
							if($reten['tipo_retencion']=='IRPF' && $mes==$reten['mes']){
								$imp=$reten['total_importe'];
							}
						}
						if($imp<>""){
							?><td><?php echo number_format($imp,2,",",".")?></td><?php
							$total=$total+$imp;
							$imp="";
						}else{
							?><td>0,00</td><?php
						}
					}
					?><td><?php echo number_format($total,2,",",".")?></td><?php
						$total=0;
				}else{
					for($celdas=1;$celdas<=13;$celdas++){
						?><td>0,00</td><?php
					}
				}
				?>
                </tr>
                <tr>
				<td><strong>SS</strong></td>
                <?php
				$total=0;
				if($retenciones_anuales[0]<>""){
					for($mes=1;$mes<=12;$mes++){
						$h="";
						foreach($retenciones_anuales as $reten){
							if($reten['tipo_retencion']=='SS' && $mes==$reten['mes']){
								$imp=$reten['total_importe'];
							}
						}
						if($imp<>""){
							?><td><?php echo number_format($imp,2,",",".")?></td><?php
							$total=$total+$imp;
							$imp="";
						}else{
							?><td>0,00</td><?php
						}
					}
					?><td><?php echo number_format($total,2,",",".")?></td><?php
						$total=0;
				}else{
					for($celdas=1;$celdas<=13;$celdas++){
						?><td>0,00</td><?php
					}
				}
				?>
                </tr>
               
            </table>
            
            
            <br class="clear" /><br class="clear" />
            
            <table class="tabledata" style="clear:both;">
            <th>Tipo</th>
            <th>Fecha</th>
            <th>Oficina</th>
            <th>Concepto</th>
            <th>Importe</th>
            <th>Observaciones</th>
            <th>Fecha Venc.</th>
            <th>Acción</th>
			<?php
			if($retenciones[0]<>""){
				foreach($retenciones as $ret)
				{
					?>
                    <tr>
                    <td><?php echo $ret['tipo_retencion']?></td>
                    <td><?php echo $ret['fecha']?></td><?php
                    foreach($oficinas as $ofi){
						if($ret['id_oficina']==$ofi['id_oficina']){
							?><td><?php echo $ofi['nombre']?></td><?php
						}
					}?>
                    <td><?php echo $ret['concepto']?></td>
					<td><?php echo number_format($ret['importe'],2,",",".")?></td>
                    <td><?php echo $ret['observaciones']?></td>
                    <td><?php echo $ret['fecha_vencimiento']?></td>
                    <td>            
                        <input type="button" name="delete_retencion" value="Borrar" style="width:80px" onclick="borrar_retencion(<?php echo $ret['id_retencion']?>)"> 
                        <span style="padding:0 15px">|</span>
                        <a href="<?php echo base_url() ?>admin/retenciones/view/<?php echo $ret['id_retencion'] ?>" target="_blank">Ver</a></td>                        
					</tr><?php
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