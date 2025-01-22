<?php
include("../application/config/config2.php");

$link = mysql_connect($host, $usuario, $pass);
mysql_select_db($database, $link);

?>
<!doctype html>
<html>
<head>
	<title>Encuesta para conseguir descuento en el presupuesto</title>

<script type='text/javascript' src="../js/jquery/js/jquery-1.7.2.min.js"></script>
<script type="text/javascript">
function comprueba_respuestas (num_preguntas){
	var error=false;
	for (var i=1; i<=num_preguntas; i++)
	{
		if ( $('.resp_'+i).is( ':checked' ) ){
			//alert("OK");
		}
		else{
		alert("DEBES RELLENAR TODA LA ENCUESTA");
			return false;
		}
	}
	document.getElementById('formulario').submit();
}
function muestra_descuento(num_preg){
	if(document.getElementById('descuento_'+num_preg).style.display=='none') {
		document.getElementById('descuento_'+num_preg).style.display = "block";
		var total=parseFloat(document.getElementById('total_importe_descuento').innerHTML);
		var importe_descuento= parseFloat(document.getElementById('importe_descuento_'+num_preg).innerHTML);
		total=total+importe_descuento;
		document.getElementById('total_importe_descuento').innerHTML=total.toFixed(2);
	}
}
</script>

	<style>
	body   
	{
		background: #EBC3DD url(../img/fondo-home-encuesta.jpg) no-repeat center top;
		
	  /* background:url(../img/main-bg.gif);*/
		font-size: .80em;
		font-family: "Helvetica Neue", "Lucida Grande", "Segoe UI", Arial, Helvetica, Verdana, sans-serif;
		margin: 0px;
		padding: 0px;
		color: #696969;
	}
	.page
	{
		width: 960px;
	   /*background-color: #fff;*/
		margin: 20px auto 0px auto;
	   /* border: 1px solid #496077;*/
		position:relative;
		z-index:2;
	}
	
	.header
	{
		position: relative;
		margin: 0px;
		padding: 0px;
		/*background: #4b6c9e;*/
		width: 100%;
		overflow:hidden;
	}
	.title
	{
		display: block;
		float: left;
		text-align: left;
		width: auto;
	}
	.title img{
		float:left;
	}
	.title h1{
		float:left;
		padding-left: 30px;
		padding-top: 50px;
		text-align:center;
		font-size:30px;
		color:#000;
		font-weight:bold;
	}
	.title h2{
		float:left;
		padding-left: 30px;
		padding-top: 50px;
		text-align:center;
		font-size:20px;
		color:#000;
		font-weight:bold;
	}
	.descuento_total
	{
		display: block;
		float: right;
		text-align: left;
		width: auto;
		padding-left: 80px;
		padding-top: 10px;
		text-align:center;
		font-size:20px;
		color:#000;
		font-weight:bold;
	}
	.main
	{
		padding: 0px 12px 10px 12px;
		margin: 45px 8px 8px 8px;
		min-height: 420px;
		background:#EBC3DD;
	}
	.tabledata th { background-color:#631268; color:#fff; border:#000 1px solid}
	.tabledata td { background-color: #EBEBEB; color: #000; border:#000 1px solid}
	.tabledata th, .tabledata td { padding:5px 8px}
	
	.rojo{
		color:red;
		font-weight:bold;
	}
	</style>
</head>
<body>

<?php
//COMPROBACIONES PARA NO HACER LA ENCUESTA VARIAS VECES
$num_veces_encuesta=0;
$id_solicitud="";
	
$result =mysql_query("SELECT id_solicitud, id_comercial FROM solicitudes WHERE id_solicitud='".$_GET['id_solicitud']."' AND email='".html_entity_decode($_GET['email'])."'", $link);
while ($fila = mysql_fetch_array($result)) {
	$id_solicitud=$fila['id_solicitud'];
	$id_comercial=$fila['id_comercial'];
}

if($id_solicitud<>""){
	$result =mysql_query("SELECT COUNT(id_solicitud) as num_veces_encuesta FROM encuestas_solicitudes WHERE id_solicitud='".$_GET['id_solicitud']."'", $link);
	while ($fila = mysql_fetch_array($result)) {
		$num_veces_encuesta=$fila['num_veces_encuesta'];
	}
}
//FIN COMPROBACIONES PARA NO HACER LA ENCUESTA VARIAS VECES

//NOTIFICAMOS AL USUARIO SI QUIERE HACER LA ENCUESTA MÁS DE UNA VEZ
if($num_veces_encuesta<>0){
	?>
	<div id="top"></div>
		<div class="page">
			<div class="header">
					<div class="title"> 
						 <img src="../img/logo_intranet.png" />
						 <h1>LA ENCUESTA YA HA SIDO REALIZADA</h1>
                         <br>
						 <h2>Muchas gracias</h2>
					</div>
				</div>
			</div>
		<div class="main">
	</div>
   <?php
}
	
if($num_veces_encuesta==0 && $id_solicitud<>""){

		$consulta_oficina=mysql_query("SELECT oficinas.nombre as nombre_oficina FROM oficinas, comerciales WHERE comerciales.id_oficina=oficinas.id_oficina AND comerciales.id='".$id_comercial."'");
		while ($fila_nombre_oficina = mysql_fetch_array($consulta_oficina)) {
			$nombre_oficina=$fila_nombre_oficina['nombre_oficina'];
		}
	
		if($_POST){
			$error='0';
			for($i=1;$i<=$_POST['numero_preguntas'];$i++){
				if(mysql_query("INSERT INTO encuestas_solicitudes (id_solicitud, id_pregunta, id_respuesta) VALUES('".$_POST['id_solicitud']."','".$_POST['pregunta_'.$i]."','".$_POST['resp_'.$i]."')",$link)){
				}
				else{
					$error='1';
					echo "INSERT INTO encuestas_solicitudes (id_solicitud, id_pregunta, id_respuesta) VALUES('".$_POST['id_solicitud']."','".$_POST['pregunta_'.$i]."','".$_POST['resp_'.$i]."')<br>";
				}
			}
			if($error=='0'){
				?>
				<div id="top"></div>
				<div class="page">
					<div class="header">
						<div class="title"> 
							 <img src="../img/logo_intranet.png" />
							 <h1>SE HA ENVIADO EL RESULTADO DE LA ENCUESTA A <?php echo strtoupper($nombre_oficina)?> Y YA PUEDES DISFRUTAR DE TU DESCUENTO ADICIONAL</h1>
							 <br>
							 <h2>Muchas gracias</h2>
						</div>
					</div>
				</div>
				<div class="main">
				</div>
				<?php
			}
			
		}
		else
		{
			?>
		<div id="top"><div>&nbsp;</div></div>
			<div class="page">
				<div class="header">
					<div class="title"> 
						 <img src="../img/logo_intranet.png" />
						 <h1>ENCUESTA</h1>
					</div>
					<div class="descuento_total">
						Total de Descuento: <span id="total_importe_descuento">0.00</span> &euro;
					</div>
				</div>
				<div class="main">
					<form name="formulario" id="formulario" method="post">
					<?php				
					$cont_preguntas =mysql_query("SELECT COUNT(id_pregunta) AS num_preguntas FROM preguntas_encuesta", $link);
					while ($cont = mysql_fetch_array($cont_preguntas)) {
						$numero_preguntas=$cont['num_preguntas'];
					}
					
					$i=1;
					$preguntas =mysql_query("SELECT * FROM preguntas_encuesta ORDER BY id_pregunta ASC", $link);
					while ($preg = mysql_fetch_assoc($preguntas)) {
						?>
						<table class="tabledata" width="100%">
						<tr align="left">
						<th><?php echo $preg['pregunta']?></th>
						</tr>
						<tr>
						<td>
							<div style="float:left;">
							<?php
							$respuestas =mysql_query("SELECT * FROM respuestas_encuesta WHERE id_pregunta='".$preg['id_pregunta']."' ORDER BY id_respuesta ASC", $link);
							while ($resp = mysql_fetch_assoc($respuestas)) {
									?>
									<input type= "radio"
									 name = "resp_<?php echo $i?>"
                                     class = "resp_<?php echo $i?>"
									 value = "<?php echo $resp['id_respuesta']?>" onClick="muestra_descuento(<?php echo $i?>)" />
									<?php echo $resp['respuesta']?>
									<br>
									<?php
							}
							?>
							<input type="hidden" id="pregunta_<?php echo $i?>" name="pregunta_<?php echo $i?>" value="<?php echo $preg['id_pregunta']?>" />
							</div>
							<div style="float:right; display:none; height:100%; border:dotted" id="descuento_<?php echo $i?>">
							Descuento de <span class="rojo" id="importe_descuento_<?php echo $i?>"><?php
							echo $preg['importe_descuento']?></span> &euro;
							</div>
		
						</td>
						</tr>
						</table>
						<?php
							$i++;
					}
					?>	
					
					<input type="hidden" name="numero_preguntas" id="numero_preguntas" value="<?php echo $numero_preguntas?>">
					<input type="hidden" name="id_solicitud" id="id_solicitud" value="<?php echo $_GET['id_solicitud']?>">
					<br>
					<center><input type="button" onClick="comprueba_respuestas(<?php echo $numero_preguntas?>)" id="enviar_encuesta" value="Enviar encuesta a <?php echo $nombre_oficina?>"></center>
					</form>
				</div>
			 </div> 
		<?php
	}
}
?>	
</body>
</html>
