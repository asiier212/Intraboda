 <style>
 .page{
	 width:auto!important;
 }
 
 table.tablec{
    font-family: "Trebuchet MS", sans-serif;
    font-size: 16px;
    font-weight: bold;
    line-height: 1.4em;
    font-style: normal;
    border-collapse:separate;
	padding-bottom: 4%;
	margin: 0 auto;
}
.tablec thead tr td{
    padding:15px;
    color:#fff;
    text-shadow:1px 1px 1px #568F23;
    border:1px solid #93CE37;
    border-bottom:3px solid #9ED929;
    background-color:#9DD929;
    background:-webkit-gradient(
        linear,
        left bottom,
        left top,
        color-stop(0.02, rgb(123,192,67)),
        color-stop(0.51, rgb(139,198,66)),
        color-stop(0.87, rgb(158,217,41))
        );
    background: -moz-linear-gradient(
        center bottom,
        rgb(123,192,67) 2%,
        rgb(139,198,66) 51%,
        rgb(158,217,41) 87%
        );
    -webkit-border-top-left-radius:5px;
    -webkit-border-top-right-radius:5px;
    -moz-border-radius:5px 5px 0px 0px;
    border-top-left-radius:5px;
    border-top-right-radius:5px;
	height:1.4em;
	font-size:1.2em;
	v-align:center;
}



.tablec tbody td{
    padding:10px;
    text-align:center;
    background-color:#DEF3CA;
    border: 2px solid #E7EFE0;
    -moz-border-radius:2px;
    -webkit-border-radius:2px;
    border-radius:2px;
    color:#666;
    text-shadow:1px 1px 1px #fff;
	
}
 
 </style>
 <h2 style="text-align:center;">
        Canciones más elegidas
    </h2>
<div class="main">
<?php
$momentoActual = ''; 
foreach($topsongs as $data){
	foreach($data as $song){
		if($song['momento'] !== $momentoActual){
			if($momentoActual!==''){
				echo '</table></div>';
			}?>
		<div style="overflow-x:auto;">
       <!-- <legend><?php echo $song['momento']?></legend>-->
		<table border="0" width="600px" class="tablec">
		   <thead>
			<tr> 
			
			<td colspan="3" align="center" style="vertical-align:middle;"> <?php echo $song["momento"]?></td></tr>
			<tr>
			<td align="center" style="">Pos</td>
			<td align="center">Canción</td>
			<td align="center">Veces</td>
			</tr>
			</thead>
		<?php 
			$momentoActual=$song['momento'];
		} ?>
		<tr>
			<td align="center" ><?php echo $song['orden']?>ª</td>
			<td align="center"><?php echo $song['artista'] . '-' . $song['cancion'] ?></td>
			<td align="center"><?php echo $song['cuantas'] ?></td>
		</tr>
		
	<?php 
	} ?>
	
	
<?php	
}
?>
 </div>
<div class="clear"></div>