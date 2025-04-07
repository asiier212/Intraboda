<?php

/** @var array $oficinas */ ?>
<?php /** @var array $cuentas_bancarias */ ?>

<script language="javascript">
	function del(id) {
		if (confirm("Esta seguro?")) {
			$("#elem").val(id);
			return true;
		} else {
			return false;
		}
	}

	function cancel(id) {
		$("#txt" + id).css('display', '');
		$("#edit" + id).css('display', 'none');
	}

	function edit(id) {
		$("#txt" + id).css('display', 'none');
		$("#edit" + id).css('display', '');
	}

	function save(id) {
		$("#id_oficina").val(id);
		$("#nombre").val($("#nombre" + id).val());
		$("#direccion").val($("#direccion" + id).val());
		$("#poblacion").val($("#poblacion" + id).val());
		$("#cp").val($("#cp" + id).val());
		$("#telefono").val($("#telefono" + id).val());
		$("#movil").val($("#movil" + id).val());
		$("#fax").val($("#fax" + id).val());
		$("#email").val($("#email" + id).val());
		$("#web").val($("#web" + id).val());
		$("#numero_cuenta").val($("#numero_cuenta" + id).val());
		$("#editform").submit();
	}
</script>

<script>
	$(function() {
		$('#add').click(function() {
			if ($('#nombre_nuevo').val() == '') {
				alert("Debes añadir el nombre de la oficina");
				$('#nombre_nuevo').focus();
				return false;
			}
			if ($('#direccion_nuevo').val() == '') {
				alert("Debes añadir la dirección de la oficina");
				$('#direccion_nuevo').focus();
				return false;
			}
			if ($('#poblacion_nuevo').val() == '') {
				alert("Debes añadir la poblacion de la oficina");
				$('#poblacion_nuevo').focus();
				return false;
			}
			if ($('#cp_nuevo').val() == '') {
				alert("Debes añadir el código postal de la oficina");
				$('#cp_nuevo').focus();
				return false;
			}
			if ($('#telefono_nuevo').val() == '') {
				alert("Debes añadir el teléfono de la oficina");
				$('#telefono_nuevo').focus();
				return false;
			}
			if ($('#movil_nuevo').val() == '') {
				alert("Debes añadir el móvil de la oficina");
				$('#movil_nuevo').focus();
				return false;
			}
			if ($('#email_nuevo').val() == '') {
				alert("Debes añadir el e-mail de la oficina");
				$('#email_nuevo').focus();
				return false;
			}
			if ($('#web_nuevo').val() == '') {
				alert("Debes añadir la web de la oficina");
				$('#web_nuevo').focus();
				return false;
			}
			if ($('#logo_mail_nuevo').val() == '') {
				alert("Debes añadir el logo del mail de la oficina");
				$('#logo_mail_nuevo').focus();
				return false;
			}
			if ($('#numero_cuenta_nuevo').val() == '') {
				alert("Debes seleccionar una cuenta bancaria");
				$('#numero_cuenta_nuevo').focus();
				return false;
			}
		});
	});
</script>

<h2>Oficinas</h2>
<div class="main form">
	<form method="post" enctype="multipart/form-data">
		<fieldset class="datos">
			<legend>Nueva oficina</legend>
			<ul>
				<li><label>(*)Nombre:</label><input type="text" name="nombre" id="nombre_nuevo" style="width:200px" /></li>
				<li><label>(*)Dirección:</label><input type="text" name="direccion" id="direccion_nuevo" style="width:200px" /></li>
				<li><label>(*)Población:</label><input type="text" name="poblacion" id="poblacion_nuevo" style="width:200px" /></li>
				<li><label>(*)CP:</label><input type="text" name="cp" id="cp_nuevo" style="width:80px" /></li>
				<li><label>(*)Teléfono:</label><input type="text" name="telefono" id="telefono_nuevo" style="width:200px" /></li>
				<li><label>(*)Móvil:</label><input type="text" name="movil" id="movil_nuevo" style="width:200px" /></li>
				<li><label>Fax:</label><input type="text" name="fax" id="fax_nuevo" style="width:200px" /></li>
				<li><label>(*)Email:</label><input type="text" name="email" id="email_nuevo" style="width:200px" /></li>
				<li><label>(*)Web:</label><input type="text" name="web" id="web_nuevo" style="width:200px" />
					<font size="-2">(Con http://)</font>
				</li>
				<li><label>(*)Logo Mail:</label><input type="file" name="logo_mail" id="logo_mail_nuevo" /></li>
				<li><label>(*)Cuenta Bancaria:</label>
					<select name="numero_cuenta" id="numero_cuenta_nuevo" style="width:210px">
						<option value="">Selecciona una cuenta</option>
						<?php foreach ($cuentas_bancarias as $cuenta): ?>
							<option value="<?php echo $numero_completo ?>">
							<?php
								$numero_completo = $cuenta['entidad'] . " - " . $cuenta['iban'] . " " . $cuenta['codigo_entidad'] . " " . $cuenta['codigo_oficina'] . " " . $cuenta['codigo_control'] . " " . $cuenta['numero_cuenta'];
								echo $numero_completo;
								?>
							</option>
						<?php endforeach; ?>
					</select>
				</li>
				<li><label>&nbsp;</label><input type="submit" value="Añadir" name="add" id="add" style="width:100px" /></li>
			</ul>
			<?php if (isset($msg)) echo $msg; ?>
		</fieldset>
		<fieldset class="datos">
			<legend>Listado Oficinas</legend>
			<ul>
				<?php if ($oficinas): foreach ($oficinas as $ofi): ?>
						<fieldset>
							<legend><?php echo $ofi['nombre'] ?></legend>
							<li style="border-bottom:#CCC 1px solid; width:730px" id="txt<?php echo $ofi['id_oficina'] ?>">
								<table>
									<tr>
										<td><?php if ($ofi['logo_mail']) { ?><img src="<?php echo base_url() ?>uploads/oficinas/<?php echo $ofi['logo_mail'] ?>" width="239" /><?php } ?></td>
									</tr>
									<tr>
										<td>Dirección: <?php echo $ofi['direccion'] ?></td>
									</tr>
									<tr>
										<td>Población: <?php echo $ofi['poblacion'] ?></td>
									</tr>
									<tr>
										<td>CP: <?php echo $ofi['cp'] ?></td>
									</tr>
									<tr>
										<td>Teléfono: <?php echo $ofi['telefono'] ?></td>
									</tr>
									<tr>
										<td>Móvil: <?php echo $ofi['movil'] ?></td>
									</tr>
									<tr>
										<td>Fax: <?php echo $ofi['fax'] ?></td>
									</tr>
									<tr>
										<td>E-mail: <?php echo $ofi['email'] ?></td>
									</tr>
									<tr>
										<td>Web: <?php echo $ofi['web'] ?></td>
									</tr>
									<tr>
										<td>Numero de Cuenta: <?php echo $ofi['numero_cuenta'] ?></td>
									</tr>
									<tr>
										<td><input type="submit" value="Borrar" name="delete" onclick="return del(<?php echo $ofi['id_oficina'] ?>)" />
											<input type="button" value="Editar" onclick="edit(<?php echo $ofi['id_oficina'] ?>)" />
										</td>
									</tr>
								</table>
							</li>
							<li style="display:none" id="edit<?php echo $ofi['id_oficina'] ?>">
								<?php if ($ofi['logo_mail']): ?><img src="<?php echo base_url() ?>uploads/oficinas/<?php echo $ofi['logo_mail'] ?>" width="286" /><br /><br /><?php endif; ?>
								<input type="text" id="nombre<?php echo $ofi['id_oficina'] ?>" value="<?php echo $ofi['nombre'] ?>" />
								<input type="text" id="direccion<?php echo $ofi['id_oficina'] ?>" value="<?php echo $ofi['direccion'] ?>" />
								<input type="text" id="poblacion<?php echo $ofi['id_oficina'] ?>" value="<?php echo $ofi['poblacion'] ?>" />
								<input type="text" id="cp<?php echo $ofi['id_oficina'] ?>" value="<?php echo $ofi['cp'] ?>" />
								<input type="text" id="telefono<?php echo $ofi['id_oficina'] ?>" value="<?php echo $ofi['telefono'] ?>" />
								<input type="text" id="movil<?php echo $ofi['id_oficina'] ?>" value="<?php echo $ofi['movil'] ?>" />
								<input type="text" id="fax<?php echo $ofi['id_oficina'] ?>" value="<?php echo $ofi['fax'] ?>" />
								<input type="text" id="email<?php echo $ofi['id_oficina'] ?>" value="<?php echo $ofi['email'] ?>" />
								<input type="text" id="web<?php echo $ofi['id_oficina'] ?>" value="<?php echo $ofi['web'] ?>" />
								<select id="numero_cuenta<?php echo $ofi['id_oficina'] ?>" style="width:210px">
									<option value="">Selecciona una cuenta</option>
									<?php foreach ($cuentas_bancarias as $cuenta):
										$numero_completo = $cuenta['entidad'] . " - " . $cuenta['iban'] . " " . $cuenta['codigo_entidad'] . " " . $cuenta['codigo_oficina'] . " " . $cuenta['codigo_control'] . " " . $cuenta['numero_cuenta']; ?>
										<option value="<?php echo $numero_completo ?>" <?php if ($ofi['numero_cuenta'] == $numero_completo) echo 'selected' ?>>
											<?php echo $numero_completo; ?>
										</option>
									<?php endforeach; ?>
								</select>


								<input type="button" value="Cancelar" onclick="cancel(<?php echo $ofi['id_oficina'] ?>)" />
								<input type="button" value="Guardar" onclick="save(<?php echo $ofi['id_oficina'] ?>)" />
							</li>
						</fieldset>
				<?php endforeach;
				endif; ?>
			</ul>
			<input type="hidden" name="elem" id="elem" />
			<?php if ($oficinas): ?>
				<div style="clear:both">
					Cambiar logo mail:<br />
					<input type="file" name="logo_mail_edit" style="width:250px" />
					<select name="logo_mail_id">
						<?php foreach ($oficinas as $ofi): ?>
							<option value="<?php echo $ofi['id_oficina'] ?>"><?php echo $ofi['nombre'] ?></option>
						<?php endforeach; ?>
					</select>
					<input type="submit" name="change_logo_mail" value="Cambiar" style="width:100px" />
				</div>
			<?php endif; ?>
		</fieldset>
	</form>
	<form method="post" id="editform">
		<input type="hidden" id="id_oficina" name="id_oficina" />
		<input type="hidden" id="nombre" name="nombre" />
		<input type="hidden" id="direccion" name="direccion" />
		<input type="hidden" id="poblacion" name="poblacion" />
		<input type="hidden" id="cp" name="cp" />
		<input type="hidden" id="telefono" name="telefono" />
		<input type="hidden" id="movil" name="movil" />
		<input type="hidden" id="fax" name="fax" />
		<input type="hidden" id="email" name="email" />
		<input type="hidden" id="web" name="web" />
		<input type="hidden" id="numero_cuenta" name="numero_cuenta" />
		<input type="hidden" name="edit" value="1" />
	</form>
</div>
<div class="clear"></div>