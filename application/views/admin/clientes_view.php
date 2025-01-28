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
			Buscador por: &nbsp;
			<select name="f">
				<option value="clientes.nombre" <?php if (isset($_GET['f']) && $_GET['f'] == 'clientes.nombre') echo 'selected="selected"' ?>>Nombre</option>
				<option value="clientes.apellidos" <?php if (isset($_GET['f']) && $_GET['f'] == 'clientes.apellidos') echo 'selected="selected"' ?>>Apellidos</option>
				<option value="clientes.poblacion" <?php if (isset($_GET['f']) && $_GET['f'] == 'clientes.poblacion') echo 'selected="selected"' ?>>Poblacion</option>
				<option value="clientes.telefono" <?php if (isset($_GET['f']) && $_GET['f'] == 'clientes.telefono') echo 'selected="selected"' ?>>Telefono</option>
				<option value="clientes.fecha_boda" <?php if (isset($_GET['f']) && $_GET['f'] == 'fecha_boda') echo 'selected="selected"' ?>>Fecha boda (dd-mm-aaaa)</option>
				<option value="restaurantes.nombre" <?php if (isset($_GET['f']) && $_GET['f'] == 'restaurante') echo 'selected="selected"' ?>>Restaurante</option>
			</select>
			<input type="text" name="q" value="<?php if (isset($_GET['q'])) echo $_GET['q'] ?>">
			<input type="submit" value="Buscar" style="margin-right:30px" />
			<a href="<?php echo base_url() ?>admin/clientes/view">Limpiar buscador</a>
		</form>
		<?php if ($clientes) {

			if (isset($_GET['q']) && !isset($_GET['p']))
				$url_ord = base_url() . "admin/clientes/view?f=" . $_GET['f'] . "&q=" . $_GET['q'] . "&ord=";
			elseif (isset($_GET['q']) && isset($_GET['p']))
				$url_ord = base_url() . "admin/clientes/view?f=" . $_GET['f'] . "&q=" . $_GET['q'] . "&p=" . $_GET['p'] . "&ord=";
			else
				$url_ord = base_url() . "admin/clientes/view?ord=";

		?>
			<table class="tabledata">
				<tr>
					<th>Foto perfil</th>
					<th style="width:160px"><a style="color:#FFF; text-decoration:underline" href="<?php echo $url_ord ?>clientes.nombre">Nombre</a></th>
					<th><a style="color:#FFF; text-decoration:underline" href="<?php echo $url_ord ?>fecha_boda">Fecha de la boda</a></th>
					<th><a style="color:#FFF; text-decoration:underline" href="<?php echo $url_ord ?>restaurante">Restaurante</a></th>
					<th><a style="color:#FFF; text-decoration:underline" href="<?php echo $url_ord ?>fecha">Fecha Alta</a></th>
					<th style="width:220px"></th>
				</tr>
				<?php foreach ($clientes as $c) {
					if ($c['foto'] == '') {
						$c['foto'] = "desconocido.jpg";
					} ?>
					<?php foreach ($tipos_clientes as $tipo) {
						if ($tipo['id_tipo_cliente'] == $c['id_tipo_cliente']) {
							$color = $tipo['color'];
						}
					} ?>

					<tr>
						<td style="background-color:<?php echo $color ?>"><img src="<?php echo base_url() ?>uploads/foto_perfil/<?php echo $c['foto'] ?>" width="100px" /></td>
						<td style="background-color:<?php echo $color ?>"><?php echo $c['nombre_novia'] . " & " . $c['nombre_novio'] ?></td>
						<td style="background-color:<?php echo $color ?>"><?php echo $c['fecha_boda'] ?></td>
						<td style="background-color:<?php echo $color ?>"><?php echo $c['restaurante'] ?></td>
						<td style="background-color:<?php echo $color ?>"><?php echo $c['fecha_alta'] ?></td>
						<td style="background-color:<?php echo $color ?>">
							<form method="post" onsubmit="return confirmar()">
								<input type="hidden" name="id" value="<?php echo $c['id'] ?>">
								<input type="submit" name="delete_cliente" value="Borrar" style="width:80px">
								<span style="padding:0 15px">|</span>
								<a href="<?php echo base_url() ?>admin/clientes/view/<?php echo $c['id'] ?>">Ver ficha</a>
							</form>
						</td>
					</tr>
				<?php } ?>
			</table>

			<div class="pag">
				<?php
				if (isset($_GET['q']) && !isset($_GET['ord'])) {
					$url_pag = base_url() . "admin/clientes/view?f=" . $_GET['f'] . "&q=" . $_GET['q'] . "&p=";
				} elseif (isset($_GET['q']) && isset($_GET['ord'])) {
					$url_pag = base_url() . "admin/clientes/view?f=" . $_GET['f'] . "&q=" . $_GET['q'] . "&ord=" . $_GET['ord'] . "&p=";
				} else {
					$url_pag = base_url() . "admin/clientes/view?p=";
				}

				if ($num_rows > $rows_page) {
					if ($page > 2) { ?>
						<a class="pP" href="<?= $url_pag . ($page - 1); ?>" title="Pagina <?= $page - 1; ?>">&laquo; Anterior</a>
					<?php }
					if ($page == 2) { ?>
						<a href="<?= $url_pag; ?>1" title="Pagina <?= $page - 1; ?>">&laquo; Anterior</a>
					<?php }
					if ($page > 3) { ?>
						<a href="<?= $url_pag; ?>1">1</a> ...
						<?php }
					for ($i = $page - 2; $i <= $page + 2; $i++) {
						if ($i == 1) { ?>
							<a href="<?= $url_pag; ?>1">1</a>
						<?php }
						if ($i == $page && $i != 1) { ?>
							<a href="#" class="sel"><?= $i; ?></a>
						<?php } elseif ($i > 1 && $i <= $last_page) { ?>
							<a href="<?= $url_pag . $i; ?>" title="Pagina <?= $i; ?>"><?= $i; ?></a>
						<?php }
					}
					if ($i - 1 < $last_page) { ?>
						... <a href="<?= $url_pag . $last_page; ?>" title="Pagina <?= $last_page; ?>"><?= $last_page; ?></a>
					<?php }
					if ($page < $last_page) { ?>
						<a class="nP" href="<?= $url_pag . ($page + 1); ?>" title="Pagina <?= $page + 1; ?>">Siguiente &raquo;</a>
				<?php }
				} ?>
			</div>


		<?php } else {
			echo "No hay datos";
		} ?>

	</fieldset>


</div>
<div class="clear">
</div>