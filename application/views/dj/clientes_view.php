<h2>
	Listar Clientes
</h2>
<div class="main form">
	<script language="javascript" type="application/javascript">
		function confirmar() {
			if (confirm("\u00BFSeguro que desea borrar el cliente?")) return true
			return false
		}
	</script>

	<fieldset class="datos">
		<legend>Clientes</legend>
		<form method="get" style="margin:10px 0">
			Buscar por: &nbsp;
			<select name="f">
				<option value="nombre_novia" <?php if (isset($_GET['f']) && $_GET['f'] == 'nombre_novia') echo 'selected="selected"' ?>>Nombre novia</option>
				<option value="nombre_novio" <?php if (isset($_GET['f']) && $_GET['f'] == 'nombre_novio') echo 'selected="selected"' ?>>Nombre novio</option>
				<option value="apellidos_novia" <?php if (isset($_GET['f']) && $_GET['f'] == 'apellidos_novia') echo 'selected="selected"' ?>>Apellidos novia</option>
				<option value="apellidos_novio" <?php if (isset($_GET['f']) && $_GET['f'] == 'apellidos_novio') echo 'selected="selected"' ?>>Apellidos novio</option>
				<option value="poblacion_novia" <?php if (isset($_GET['f']) && $_GET['f'] == 'poblacion_novia') echo 'selected="selected"' ?>>Poblacion novia</option>
				<option value="poblacion_novio" <?php if (isset($_GET['f']) && $_GET['f'] == 'poblacion_novio') echo 'selected="selected"' ?>>Poblacion novio</option>
				<option value="fecha_boda" <?php if (isset($_GET['f']) && $_GET['f'] == 'fecha_boda') echo 'selected="selected"' ?>>Fecha boda (dd-mm-aaaa)</option>
				<option value="restaurantes.nombre" <?php if (isset($_GET['f']) && $_GET['f'] == 'restaurante') echo 'selected="selected"' ?>>Restaurante</option>
			</select>
			<input type="text" name="q" value="<?php if (isset($_GET['q'])) echo $_GET['q'] ?>">
			<input type="submit" value="Buscar" style="margin-right:30px" />
			<a href="<?php echo base_url() ?>dj/clientes/view">Limpiar buscador</a>
		</form>
		<?php if ($clientes) {

			if (isset($_GET['q']) && !isset($_GET['p']))
				$url_ord = base_url() . "dj/clientes/view?f=" . $_GET['f'] . "&q=" . $_GET['q'] . "&ord=";
			elseif (isset($_GET['q']) && isset($_GET['p']))
				$url_ord = base_url() . "dj/clientes/view?f=" . $_GET['f'] . "&q=" . $_GET['q'] . "&p=" . $_GET['p'] . "&ord=";
			else
				$url_ord = base_url() . "dj/clientes/view?ord=";

		?>
			<table class="tabledata">
				<tr>
					<th>Foto perfil</th>
					<th style="width:160px"><a style="color:#FFF; text-decoration:underline" href="<?php echo $url_ord ?>nombre_novia">Novia</a> | <a style="color:#FFF; text-decoration:underline" href="<?php echo $url_ord ?>nombre_novio">Novio</a></th>
					<th><a style="color:#FFF; text-decoration:underline" href="<?php echo $url_ord ?>fecha_boda">Fecha de la boda</a></th>
					<th><a style="color:#FFF; text-decoration:underline" href="<?php echo $url_ord ?>restaurante">Restaurante</a></th>
					<th><a style="color:#FFF; text-decoration:underline" href="<?php echo $url_ord ?>fecha">Fecha Alta</a></th>
					<th style="width:220px"></th>
				</tr>
				<?php foreach ($clientes as $c) {
					if ($c['foto'] == '') {
						$c['foto'] = "desconocido.jpg";
					} ?>
					<tr>
						<td><img src="<?php echo base_url() ?>uploads/foto_perfil/<?php echo $c['foto'] ?>" width="100px" /></td>
						<td><?php echo $c['nombre_novia'] . " & " . $c['nombre_novio'] ?></td>
						<td><?php echo $c['fecha_boda'] ?></td>
						<td><?php echo $c['restaurante'] ?></td>
						<td><?php echo $c['fecha_alta'] ?></td>
						<td>
							<form method="post" onsubmit="return confirmar()">
								<input type="hidden" name="id" value="<?php echo $c['id'] ?>">
								<!--<input type="submit" name="delete_cliente" value="Borrar" style="width:80px" 
                        <span style="padding:0 15px">|</span>>-->
								<a href="<?php echo base_url() ?>dj/clientes/view/<?php echo $c['id'] ?>">Ver ficha</a>
							</form>
						</td>
					</tr>
				<?php } ?>
			</table>

			<div class="pag">
				<?
				if (isset($_GET['q']) && !isset($_GET['ord']))
					$url_pag = base_url() . "dj/clientes/view?f=" . $_GET['f'] . "&q=" . $_GET['q'] . "&p=";
				elseif (isset($_GET['q']) && isset($_GET['ord']))
					$url_pag = base_url() . "dj/clientes/view?f=" . $_GET['f'] . "&q=" . $_GET['q'] . "&ord=" . $_GET['ord'] . "&p=";
				else
					$url_pag = base_url() . "dj/clientes/view?p=";


				?>
				<? if ($num_rows > $rows_page) {
					if ($page > 2) { ?>
						<a class="pP" href="<?= $url_pag; ?><?= $page - 1; ?>" title="Pagina <?= $page - 1; ?>">&laquo; Anterior</a>
					<? }
					if ($page == 2) { ?>
						<a href="<?= $url_pag; ?>1" title="Pagina <?= $page - 1; ?>">&laquo; Anterior</a>
					<? }
					if ($page > 3) { ?>
						<a href="<?= $url_pag; ?>1">1</a> ...<?
														}
														for ($i = $page - 2; $i <= $page + 2; $i++) {
															if ($i == 1) { ?>
						<a href="<?= $url_pag; ?>1">1</a><?
															}
															if ($i == $page && $i != 1) { ?>
						<a href="#" class="sel"><?= $i; ?></a> <?
															} elseif ($i > 1 && $i <= $last_page) { ?>
						<a href="<?= $url_pag; ?><?= $i; ?>" title="Pagina <?= $i; ?>"><?= $i; ?></a><?
																							}
																						}
																						if ($i - 1 < $last_page) { ?>
					... <a href="<?= $url_pag; ?><?= $last_page; ?>" title="Pagina <?= $last_page; ?>"><?= $last_page; ?></a><?
																													}
																													if ($page < $last_page) { ?>
					<a class="nP" href="<?= $url_pag; ?><?= $page + 1; ?>" title="Pagina <?= $page + 1; ?>">Siguiente &raquo;</a><?
																													}
																												} ?>
			</div>

		<?php } else {
			echo "No hay datos";
		} ?>

	</fieldset>


</div>
<div class="clear">
</div>