<script type="text/javascript" src="<?php echo base_url() ?>js/jquery/development-bundle/ui/jquery.jeditable.js"></script>
    


 <script language="javascript">
$(document).ready(function() {
	 $('.edit_box').editable('<?php echo base_url() ?>index.php/ajax/updatepartidapresupuestaria/<?php echo $partida['id_partida']?>', { 
         type      : 'text',
        submit    : '<img src="<?php echo base_url() ?>img/save.gif" />',
         tooltip   : 'Click para editar...',
     });
});

</script>
    

<h2>
        Detalles de la partida presupuestaria
</h2>
<div class="main form">
 
<form method="post" >
	<fieldset class="datos">
    	<legend>Datos de la partida</legend>
       
            <ul class="editable">
            	<li><label>Concepto:</label><span class="edit_box" id="concepto"><?php echo $partida['concepto']?></span> </li>
                <li><label>Importe:</label><span class="edit_box" id="importe"><?php echo $partida['importe']?></span> </li>
                <li><label>Año:</label><span class="edit_box" id="ano"><?php echo $partida['año']?></span> </li>
            </ul>
        
    </fieldset>
    <p style="text-align:center"></p>
</form> 

</div>
<div class="clear">
</div>