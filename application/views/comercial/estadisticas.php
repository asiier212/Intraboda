<link rel="stylesheet" href="<?php echo base_url() ?>js/jquery/development-bundle/themes/base/jquery.ui.all.css">
	
<script src="<?php echo base_url() ?>js/jquery/development-bundle/ui/jquery-ui-1.8.16.custom.min.js"></script>   
<script src="<?php echo base_url() ?>js/jquery/development-bundle/ui/jquery-ui-timepicker-addon.js"></script>

<script type="text/javascript" src="<?php echo base_url() ?>js/jquery/development-bundle/ui/jquery-ui-sliderAccess.js"></script>
<script type="text/javascript" src="http://code.highcharts.com/highcharts.js"></script>
        
    
<link rel="stylesheet" href="<?php echo base_url() ?>js/jquery/development-bundle/demos/demos.css">

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
		$( "#calendar_desde" ).datepicker();
		$( "#calendar_hasta" ).datepicker();
		
	});
</script>
    
<h2>
        Estadísticas
</h2>
<div class="main form">
<form method="post">
	<fieldset class="datos">
    	<legend>Porcentaje de contratación</legend>
		
        <div style="float:left">
        
        <ul>
        	<li><label>Desde:</label><input type="text" name="fecha_desde" id="calendar_desde" value="<?php echo $fecha_desde?>" /></li>
            <li><label>Hasta:</label><input type="text" name="fecha_hasta" id="calendar_hasta"  value="<?php echo $fecha_hasta?>"/></li>
            <li><input type="submit" value="Filtrar" /></li>
        </ul>
            </form>
            <br><br>
            
            
            <table class="tabledata">
            <tr>
            	<th style="width:400px" colspan="3">Presupuestos del <?php echo $porcentaje_contratacion[0]['fecha_desde']?> hasta <?php echo $porcentaje_contratacion[0]['fecha_hasta']?></th>
            </tr>
            <tr>
                	<th style="width:100px" align="center">Totales</th>
                    <th style="width:100px" align="center">Enviados</th>
                    <th style="width:100px" align="center">Firmados</th>
            </tr>
            <tr>
            	<td align="center"><?php echo $porcentaje_contratacion[0]['presupuestos_totales']?></td>
            	<td align="center"><?php echo $porcentaje_contratacion[0]['presupuestos_enviados']?></td>
            	<td align="center"><?php echo $porcentaje_contratacion[0]['presupuestos_firmados']?></td>
            </tr>
            <tr>
       			<th style="width:400px" colspan="3">Porcentaje de contratación: <?php echo $porcentaje_contratacion[0]['porcentaje_contratacion']?>%</th>
            </tr>
            </table>
            </div>
            <div style="float:left;width:400px; margin-left:20px;">
				<?php if (isset($charts)) echo $charts; ?>
                
            </div>
            
    </fieldset>



        </div>
        <div class="clear">
        </div>