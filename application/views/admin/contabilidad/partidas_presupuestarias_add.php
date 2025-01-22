  
   <h2>
        Añadir Partida Presupuestaria
    </h2>
    
<div class="main form">
 
<form method="post">
	<fieldset class="datos">
    	<legend>Nueva Partida</legend>
        <ul>
            	<li><label>(*) Concepto:</label><textarea name="concepto" style="width:600px; height:100px; float:left" required></textarea> </li>
                <li><label>(*) Importe bruto:</label><input type="number" step="0.01" id="importe" name="importe" required /> </li>
                <li><label>(*) Año:</label><input type="number" id="ano" name="ano" required /> </li>
                <li><input type="submit" id="anadir_partida" name="anadir_partida" value="A&ntilde;adir Partida Presupuestaria" /> </li>
            </ul>
    </fieldset>
	
</form>
        </div>
        <div class="clear">
        </div>