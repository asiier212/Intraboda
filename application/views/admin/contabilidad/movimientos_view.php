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
		
	});
</script>

<script language="javascript" type="application/javascript">
  function borrar_movimiento(id) {
	if (confirm("\u00BFSeguro que desea borrar el movimiento?")){
		$.ajax({
			type: 'POST',   
			url: '<?php echo base_url() ?>index.php/ajax/deletemovimiento', 
			data: 'id='+id, 
			success: function(data) {
					location.href= '<?php echo base_url() ?>admin/movimientos/view';
				}
		});
		 return true
	}else{
		return false
	}
}
</script>

<h2>
        Movimientos y saldos
    </h2>
<div class="main form">

<input value="<?php echo base_url()?>" id="hiddenurl" type="hidden"> 

<form method="post">
	<fieldset class="datos">
    	<legend>Movimientos</legend>
        	<ul>
            	<li><label>Desde:</label><input type="text" name="fecha_desde" id="fecha_desde" value="<?php echo $fecha_desde?>" required /></li>
                <li><label>Hasta:</label><input type="text" name="fecha_hasta" id="fecha_hasta"  value="<?php echo $fecha_hasta?>" required /></li>
                <li><label>Tipo de movimiento:</label>
                	<select name="tipo_movimiento" id="tipo_movimiento">
                    	<option value=""></option>
                        <option value="ingreso">Ingreso</option>
                        <option value="gasto">Gasto</option>
                    </select>
                </li>
                <li><label>Lugar del movimiento:</label>
                	<select name="lugar" id="lugar">
                    	<option value=""></option>
                        <option value="cuenta">Cuenta Bancaria</option>
                        <option value="caja">Caja</option>
                    </select>
                </li>
                <li><label>Dónde:</label>
                	<select name="tipo_lugar" id="tipo_lugar">
                    	<option value=""></option>
                    </select>
                </li>
                <li id="li_oficina" style="display:none"><label>Oficina:</label>
                	<select name="oficina" id="oficina">
                    	<option value=""></option>
                    <?php
					foreach($oficinas as $ofi){
						?><option value="<?php echo $ofi['id_oficina']?>"><?php echo $ofi['nombre']?></option><?php
					}
					?>
                    </select>
                </li>
                <li><input type="submit" value="Filtrar" /></li>
            </ul>
            
            <br><br>
            
            <p><fieldset>
            <legend>Movimientos entre <?php echo $fecha_desde?> y <?php echo $fecha_hasta?></legend>
            
            <table class="tabledata" style="float:left;">
            <th>CUENTA BANCARIA</th>
            <th>SALDO</th>
            	<?php
				$total_cuentas=0;
				if($cuentas_bancarias[0]<>""){
					foreach($cuentas_bancarias as $cuenta){
						$saldo=0;
						?>
						<tr>
							<td align="center"><?php echo $cuenta['entidad']." - ".$cuenta['IBAN']."  ".$cuenta['codigo_entidad']."  ".$cuenta['codigo_oficina']."  ".$cuenta['codigo_control']."  ".$cuenta['numero_cuenta']?></td>
							<?php
							if($movimientos[0]<>""){
								foreach($movimientos as $mov){
									if($mov['lugar']=='cuenta' && ($mov['tipo_lugar']==$cuenta['id_cuenta'])){
										if($mov['tipo_movimiento']=='ingreso'){
											$saldo=$saldo+$mov['importe'];
										}else{
											$saldo=$saldo-$mov['importe'];
										}
									}
								}
							}
							$total_cuentas=$total_cuentas+$saldo;
							?>
						<td align="center"><?php echo number_format($saldo,2,",",".")?> &#8364;</td>
					</tr>
					<?php
					}
				}
				?>
                <tr>
                    <td><strong>SUBTOTAL</strong></td>
                    <td><?php echo number_format($total_cuentas,2,",",".")?> &#8364;</td>
                </tr>
            </table>
            
            <table class="tabledata" style="float:right;">
            <th>OFICINA</th>
            <th>CAJA A</th>
            <th>CAJA B</th>
            <?php
			$total_saldo_caja_A=0;
			$total_saldo_caja_B=0;
			
				foreach($oficinas as $ofi){
					$saldo_caja_A=0;
					$saldo_caja_B=0;
					?>
                    <tr>
                        <td align="center"><?php echo $ofi['nombre']?></td>
                        <?php
						if($movimientos[0]<>""){
							foreach($movimientos as $mov){
								if($mov['lugar']=='caja' && ($mov['tipo_lugar']=='A') && ($ofi['id_oficina']==$mov['id_oficina'])){
									if($mov['tipo_movimiento']=='ingreso'){
										$saldo_caja_A=$saldo_caja_A+$mov['importe'];
									}else{
										$saldo_caja_A=$saldo_caja_A-$mov['importe'];
									}
								}
								if($mov['lugar']=='caja' && ($mov['tipo_lugar']=='B') && ($ofi['id_oficina']==$mov['id_oficina'])){
									if($mov['tipo_movimiento']=='ingreso'){
										$saldo_caja_B=$saldo_caja_B+$mov['importe'];
									}else{
										$saldo_caja_B=$saldo_caja_B-$mov['importe'];
									}
								}
							}
						}
						?>
                    <td align="center"><?php echo number_format($saldo_caja_A,2,",",".")?> &#8364;</td>
                    <td align="center"><?php echo number_format($saldo_caja_B,2,",",".")?> &#8364;</td>
                </tr>
                <?php
					$total_saldo_caja_A=$total_saldo_caja_A+$saldo_caja_A;
					$total_saldo_caja_B=$total_saldo_caja_B+$saldo_caja_B;
				}
				?>
                <tr>
                	<td><strong>SUBTOTAL</strong>
                    <td><?php echo number_format($total_saldo_caja_A,2,",",".")?> &#8364;</td>
                    <td><?php echo number_format($total_saldo_caja_B,2,",",".")?> &#8364;</td>
                </tr>
                <tr>
                	<td><strong>TOTAL</strong>
                    <td colspan="2" align="center"><strong><?php echo number_format(($total_cuentas+$total_saldo_caja_A+$total_saldo_caja_B),2,",",".")?> &#8364;</strong></td>
                </tr>
            </table>
            <br class="clear" /><br class="clear" />
            
            <table class="tabledata" style="clear:both;">
            <th>Movimiento</th>
            <th>Lugar</th>
            <th>Tipo</th>
            <th>Oficina</th>
            <th>Fecha</th>
            <th>Concepto</th>
            <th>Importe</th>
            <th>Acción</th>
			<?php
			if($movimientos[0]<>""){
				foreach($movimientos as $mov)
				{
					if($mov['tipo_movimiento']=="ingreso"){
						$color="#00b050";
						$color_letra="#000000";
					}else{
						$color="#ff0000";
						$color_letra="#ffffff";
					}
					?>
                    <tr>
                    <?php
                    if($mov['tipo_movimiento']=="ingreso"){
						?><td style="background-color:<?php echo $color?>; color:<?php echo $color_letra?>;">Ingreso</td><?php
					}else{
						?><td style="background-color:<?php echo $color?>; color:<?php echo $color_letra?>;">Gasto</td><?php
					}
					if($mov['lugar']=="cuenta"){
						?><td style="background-color:<?php echo $color?>; color:<?php echo $color_letra?>;">Cuenta Bancaria</td><?php
					}else{
						?><td style="background-color:<?php echo $color?>; color:<?php echo $color_letra?>;">Caja</td><?php
					}
					if($mov['tipo_lugar']<>"A" && $mov['tipo_lugar']<>"B"){
						foreach($cuentas_bancarias as $cuenta){
							if($cuenta['id_cuenta']==$mov['tipo_lugar']){
								?><td style="background-color:<?php echo $color?>; color:<?php echo $color_letra?>;"><?php echo $cuenta['entidad']." - ".$cuenta['IBAN']."  ".$cuenta['codigo_entidad']."  ".$cuenta['codigo_oficina']."  ".$cuenta['codigo_control']."  ".$cuenta['numero_cuenta']?></td><?php
							}
						}
					}elseif($mov['tipo_lugar']=="A"){
						?><td style="background-color:<?php echo $color?>; color:<?php echo $color_letra?>;">Caja A</td><?php
                    }else{
						?><td style="background-color:<?php echo $color?>; color:<?php echo $color_letra?>;">Caja B</td><?php
					}
					if($mov['id_oficina']<>""){
						foreach($oficinas as $ofi){
							if($mov['id_oficina']==$ofi['id_oficina']){
								?><td style="background-color:<?php echo $color?>; color:<?php echo $color_letra?>;"><?php echo $ofi['nombre']?></td><?php
							}
						}
					}else{
						?><td style="background-color:<?php echo $color?>"></td><?php
					}?>
                    <td style="background-color:<?php echo $color?>; color:<?php echo $color_letra?>;"><?php echo $mov['fecha']?></td>
                    <td style="background-color:<?php echo $color?>; color:<?php echo $color_letra?>;"><?php echo $mov['concepto']?></td>
                    <td style="background-color:<?php echo $color?>; color:<?php echo $color_letra?>;"><?php echo $mov['importe']?> &#8364;</td>
                    <td style="background-color:<?php echo $color?>; color:<?php echo $color_letra?>;"><input type="button" name="delete_retencion" value="Borrar" style="width:50px" onclick="borrar_movimiento(<?php echo $mov['id_movimiento']?>)"> | <a href="<?php echo base_url() ?>admin/movimientos/view/<?php echo $mov['id_movimiento'] ?>" target="_blank">Ver</a></td>
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