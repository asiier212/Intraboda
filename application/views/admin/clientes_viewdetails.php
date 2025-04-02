<script type="text/javascript" src="<?php echo base_url() ?>js/jquery/development-bundle/ui/jquery.jeditable.js"></script>

<script type="text/javascript" src="<?php echo base_url() ?>js/tooltip.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/alertify/lib/alertify.js"></script>
<link rel="stylesheet" href="<?php echo base_url() ?>js/alertify/themes/alertify.core.css" />
<link rel="stylesheet" href="<?php echo base_url() ?>js/alertify/themes/alertify.default.css" />


<script language="javascript">
	$(document).ready(function() {
		$('.edit_box').editable('<?php echo base_url() ?>index.php/ajax/updatedatocliente/<?php echo $cliente['id'] ?>', {
			type: 'text',
			submit: '<img src="<?php echo base_url() ?>img/save.gif" />',
			tooltip: 'Click para editar...',
		});
	});

	function deleteobservacion_admin(id) {
		if (confirm("\u00BFSeguro que desea borrar la observaci\u00f3n?")) {

			$.ajax({
				type: 'POST',
				url: '<?php echo base_url() ?>index.php/ajax/deleteobservacion_admin',
				data: 'id=' + id,
				success: function(data) {
					$("#o_" + id).css("display", "none");
					$("#result").html("");
				}
			});
		}
		return false
	}

	function deletepago(id, valor, fecha) {
		if (confirm("\u00BFSeguro que desea borrar el pago?")) {
			$.ajax({
				type: 'POST',
				url: '<?php echo base_url() ?>index.php/ajax/deletepago',
				data: 'id=' + id + '&valor=' + valor + '&fecha=' + fecha,
				success: function(data) {
					location.href = '<?php echo base_url() ?>admin/clientes/view/' + id;
				}
			});
		}
		return false
	}

	function anade_horas_dj() {

		alertify.prompt("Añade el concepto:", function(e, con) {
			if (e) {
				$("#horas_concepto").val(con);

				alertify.prompt("Añade el número de horas:", function(e2, ho) {
					if (e2) {
						$("#horas_dj").val(ho);

						if ($("#horas_concepto").val() != "" && $("#horas_dj").val() != "") {
							$("#form_cliente").submit();
						}
					}
				});
			} else {
				return false;
			}
		});

	}

	function elimina_horas_dj(id, id_cliente) {
		if (confirm("\u00BFSeguro que desea borrar el trabajo?")) {
			$.ajax({
				type: 'POST',
				url: '<?php echo base_url() ?>index.php/ajax/elimina_horas_dj',
				data: 'id=' + id,
				success: function(data) {
					location.href = '<?php echo base_url() ?>admin/clientes/view/' + id_cliente;
				}
			});
		}
		return false
	}

	function muestra_componentes_equipo(componentes) {
		alertify.alert(componentes);
	}
</script>

<script type="text/javascript" src="<?php echo base_url() ?>js/jrating/jquery/jRating.jquery.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$(".valoracion").jRating({
			step: true,
			type: 'big', // type of the rate.. can be set to 'small' or 'big'
			length: 10, // nb of stars
			rateMax: 10, // número máximo de valoración
			bigStarsPath: "<?php echo base_url() ?>js/jrating/jquery/icons/stars.png", //Path de las estrellas
			isDisabled: true
		});

		$('#generar_factura').click(function(e) {

			if ($("#fecha_factura").val() == "") {
				alert("Debes rellenar el campo fecha de la factura, antes de generar la factura");
				return false;
			}
			if ($("#n_factura").val() == "") {
				alert("Debes rellenar el campo Nº de Factura, antes de generar la factura");
				return false;
			}
		});


		$('#restaurante').change(function() {

			var id_cliente = <?php echo $cliente['id'] ?>;
			var id_restaurante = $("#restaurante").val();

			$.ajax({
				type: 'POST',
				dataType: 'json',
				url: '<?php echo base_url() ?>index.php/ajax/actualizarestaurantecliente',
				data: 'id_cliente=' + id_cliente + "&id_restaurante=" + id_restaurante,
				success: function(data) {
					$("#direccion_restaurante").text(data.direccion);
					$("#telefono_restaurante").text(data.telefono_restaurante);
					$("#maitre").text(data.maitre);
					$("#telefono_maitre").text(data.telefono_maitre);
					$("#datos_restaurante ul ul li").remove();
					$.each(data.archivos, function(i, archivos) {
						//alert(archivos.descripcion);
						$("#datos_restaurante ul ul").append('<li><label>' + archivos.descripcion + ':</label><span><a href="<?php echo base_url() ?>uploads/restaurantes/' + archivos.archivo + '" target="_blank">' + archivos.archivo + '</a></span></li>');
					});
				}
			});

		});


	});
</script>
<link rel="stylesheet" href="<?php echo base_url() ?>js/jrating/jquery/jRating.jquery.css" type="text/css" />


<link rel="stylesheet" href="<?php echo base_url() ?>js/jquery/development-bundle/themes/base/jquery.ui.all.css">

<script src="<?php echo base_url() ?>js/jquery/development-bundle/ui/jquery-ui-1.8.16.custom.min.js"></script>
<script src="<?php echo base_url() ?>js/jquery/development-bundle/ui/jquery-ui-timepicker-addon.js"></script>

<script type="text/javascript" src="<?php echo base_url() ?>js/jquery/development-bundle/ui/jquery-ui-sliderAccess.js"></script>
<script>
	$(function() {
		$("#fecha_factura").datepicker({
			dateFormat: 'dd-mm-yy'
		});
	});
</script>


<style>
	.editable img {
		float: right
	}
</style>
<h2>
	Detalles del cliente
</h2>
<div class="main form">

	<?php
	session_start(); //Sesión para controlar que admin pueda acceder a todas las fichas de los clientes
	if ($this->session->userdata('admin') == 1) {
		$_SESSION['id_dj'] =  'admin';
	}
	?>
	<form method="post" enctype="multipart/form-data" id="form_cliente">
		<fieldset class="datos">
			<legend>Datos de contacto</legend>

			<p style="float:left">Para editar los datos haz click sobre el texto</p>
			<p style="text-align:right"><a style="text-decoration:underline; cursor:pointer;" target="_blank" href="<?php echo base_url() ?>admin/clientes/initsession/<?php echo $cliente['id'] ?>">Iniciar Sesi&oacute;n en la cuenta del usuario</a></p>
			<p style="text-align:right"><a style="text-decoration:underline; cursor:pointer;" target="_blank" href="<?php echo base_url() ?>informes/ficha.php?id_cliente=<?php echo $cliente['id'] ?>">Descargar ficha del usuario</a></p>
			<p style="text-align:right"><a style="text-decoration:underline; cursor:pointer;" onclick="mostrarPopup()">Reenviar Clave</a></p>

			<!--Popup reenviar clave-->
			<div id="popupReenviarClave" class="popup" style="display: none;">
				<div class="popup-content">
					<p>¿A quién quieres reenviar la clave?</p>
					<input type="submit" onclick="reenviarClave('novio')" value="<?php echo $cliente['nombre_novio'] ?>" /><br><br>
					<input type="submit" onclick="reenviarClave('novia')" value="<?php echo $cliente['nombre_novia'] ?>" /><br><br>
					<input type="submit" onclick="reenviarClave('ambos')" value="Ambos" /><br><br>
					<input type="submit" onclick="cerrarPopup()" value="Cancelar" />
				</div>
			</div>



			<script>
				function mostrarPopup() {
					document.getElementById("popupReenviarClave").style.display = "flex";
				}

				function cerrarPopup() {
					document.getElementById("popupReenviarClave").style.display = "none";
				}

				window.onclick = function(event) {
					let popup = document.getElementById("popupReenviarClave");
					if (event.target === popup) {
						cerrarPopup();
					}
				};

				function obtenerIdCliente() {
					const pathParts = window.location.pathname.split("/");
					return pathParts[pathParts.length - 1];
				}


				console.log("ID del cliente:", obtenerIdCliente());

				function reenviarClave(destinatario) {
					var idCliente = obtenerIdCliente(); // Asegúrate de que devuelve un valor correcto

					console.log("Enviando datos:", {
						id_cliente: idCliente,
						destinatario
					});

					fetch("<?php echo site_url('admin/reenviar_clave'); ?>", {
							method: "POST",
							headers: {
								"Content-Type": "application/x-www-form-urlencoded"
							},
							body: `id_cliente=${encodeURIComponent(idCliente)}&destinatario=${encodeURIComponent(destinatario)}`
						})
						.then(response => response.json())
						.then(data => {
							console.log("Respuesta del servidor:", data);
							alert(data.message);
							cerrarPopup();
						})
				}
			</script>


			<br clear="left" />
			<fieldset style="width:350px">
				<legend>Datos Cliente 1</legend>
				<ul class="editable">
					<li><label>Nombre:</label><span class="edit_box" id="nombre_novio"><?php echo $cliente['nombre_novio'] ?></span> </li>
					<li><label>Apellidos:</label><span class="edit_box" id="apellidos_novio"><?php echo $cliente['apellidos_novio'] ?></span></li>
					<li><label>Direcci&oacute;n:</label><span class="edit_box" id="direccion_novio"><?php echo $cliente['direccion_novio'] ?></span></li>
					<li><label>CP:</label><span class="edit_box" id="cp_novio"><?php echo $cliente['cp_novio'] ?></span></li>
					<li><label>Poblaci&oacute;n:</label><span class="edit_box" id="poblacion_novio"><?php echo $cliente['poblacion_novio'] ?></span></li>
					<li><label>Telefono:</label><span class="edit_box" id="telefono_novio"><?php echo $cliente['telefono_novio'] ?></span></li>
					<li><label>Email:</label><span class="edit_box" id="email_novio"><?php echo $cliente['email_novio'] ?></span></li>
				</ul>
			</fieldset>
			<fieldset style="width:350px">
				<legend>Datos Cliente 2</legend>
				<ul>
					<li><label>Nombre:</label><span class="edit_box" id="nombre_novia"><?php echo $cliente['nombre_novia'] ?></span></li>
					<li><label>Apellidos:</label><span class="edit_box" id="apellidos_novia"><?php echo $cliente['apellidos_novia'] ?></span></li>
					<li><label>Direcci&oacute;n:</label><span class="edit_box" id="direccion_novia"><?php echo $cliente['direccion_novia'] ?></span></li>
					<li><label>CP:</label><span class="edit_box" id="cp_novia"><?php echo $cliente['cp_novia'] ?></span></li>
					<li><label>Poblaci&oacute;n:</label><span class="edit_box" id="poblacion_novia"><?php echo $cliente['poblacion_novia'] ?></span></li>
					<li><label>Telefono:</label><span class="edit_box" id="telefono_novia"><?php echo $cliente['telefono_novia'] ?></span></li>
					<li><label>Email:</label><span class="edit_box" id="email_novia"><?php echo $cliente['email_novia'] ?></span></li>
				</ul>
			</fieldset>
			<br class="clear" />
			(*)Canal de captaci&oacute;n: <select name="canal_captacion">
				<?php
				foreach ($captacion as $capta) {
					if ($capta['id'] == $cliente['canal_captacion']) { ?>
						<option value="<?php echo $capta['id'] ?>"><?php echo $capta['nombre'] ?></option>
				<?php
					}
				} ?>
				<option value=""></option>
				<?php
				foreach ($captacion as $capta) {
				?>
					<option value="<?php echo $capta['id'] ?>"><?php echo $capta['nombre'] ?></option>
				<?php
				}
				?>
			</select>
			<input type="submit" name="update_canal_captacion" value="Cambiar canal de captación" />
			<br class="clear" />
			<br />
			(*)Oficina: <select name="oficina">
				<?php
				foreach ($oficinas as $ofi) {
					if ($ofi['id_oficina'] == $cliente['id_oficina']) { ?>
						<option value="<?php echo $ofi['id_oficina'] ?>"><?php echo $ofi['nombre'] ?></option>
				<?php
					}
				} ?>

				<?php
				foreach ($oficinas as $ofi) {
				?>
					<option value="<?php echo $ofi['id_oficina'] ?>"><?php echo $ofi['nombre'] ?></option>
				<?php
				}
				?>
			</select>
			<input type="submit" name="update_oficina" value="Cambiar oficina" />
			<br />
			<br class="clear" />

			(*)Tipo de Cliente: <select name="tipo_cliente">
				<?php
				foreach ($tipos_clientes as $tipo) {
					if ($tipo['id_tipo_cliente'] == $cliente['id_tipo_cliente']) { ?>
						<option value="<?php echo $tipo['id_tipo_cliente'] ?>"><?php echo $tipo['tipo_cliente'] ?></option>
				<?php
					}
				} ?>

				<?php
				foreach ($tipos_clientes as $tipo) {
				?>
					<option value="<?php echo $tipo['id_tipo_cliente'] ?>"><?php echo $tipo['tipo_cliente'] ?></option>
				<?php
				}
				?>
			</select>
			<input type="submit" name="update_tipo_cliente" value="Cambiar tipo de cliente" />
			<br />
			<br class="clear" />

			(*)Enviar e-mails al cliente: <select name="enviar_emails" required>
				<?php
				if ($cliente['enviar_emails'] == 'S') { ?>
					<option value="S">SÍ</option>
				<?php
				} else { ?>
					<option value="N">NO</option>
				<?php
				} ?>

				<option value=""></option>
				<option value="S">SÍ</option>
				<option value="N">NO</option>
			</select>
			<input type="submit" name="update_enviar_emails" value="Actualizar envío de e-mails" />
			<br />
			<br class="clear" />


		</fieldset>
		<fieldset class="datos" id="datos_restaurante">
			<legend>Datos de la boda</legend>
			<fieldset style="width:350px">
				<legend>Lugar, fecha y hora</legend>
				<ul>
					<li><label>Fecha de la boda:</label><span class="edit_box" id="fecha_boda"><?php echo $cliente['fecha_boda'] ?></span></li>
					<li><label>Hora de la boda:</label>
						<span class="edit_box" id="hora_boda"><?php echo $cliente['hora_boda'] ?></span>
					</li>
					<li><label>Restaurante:</label><select id="restaurante" style="width:200px" required>
							<option value="<?php echo $cliente['id_restaurante'] ?>"><?php echo $cliente['restaurante'] ?></option>
							<option value=""></option>
							<?php
							foreach ($restaurantes as $r) {
							?>
								<option value="<?php echo $r['id_restaurante'] ?>"><?php echo $r['nombre'] ?></option>
							<?php
							}
							?>
						</select></li>
					<li><label>Direcci&oacute;n del Restaurante:</label><span id="direccion_restaurante"><?php echo $cliente['direccion_restaurante'] ?></span></li>
					<li><label>Tel&eacute;fono del Restaurante:</label><span id="telefono_restaurante"><?php echo $cliente['telefono_restaurante'] ?></span></li>
					<li><label>Maitre de la boda:</label><span id="maitre"><?php echo $cliente['maitre'] ?></span></li>
					<li><label>Tel&eacute;fono Maitre:</label><span id="telefono_maitre"><?php echo $cliente['telefono_maitre'] ?></span></li>
					<ul>
						<?PHP
						if (isset($cliente['restaurante_archivos'])) {
							foreach ($cliente['restaurante_archivos'] as $ra) {
						?>
								<li><label><?php echo $ra['descripcion'] ?>:</label><span><a href="<?php echo base_url() ?>uploads/restaurantes/<?php echo $ra['archivo'] ?>" target="_blank"><?php echo $ra['archivo'] ?></a></span></li>
						<?php
							}
						}
						?>
					</ul>
				</ul>
			</fieldset>
			<fieldset style="width:350px">
				<legend>DJ asignado</legend>
				<ul>
					<?php
					if ($dj) {
						foreach ($dj as $p) { ?>
							<li style="display: block; float:left; padding:0 60px; text-align:center; border-bottom:#CCC 1px solid;">
								<label for="dj<?php echo $p['id'] ?>" style="float:none; margin:0 auto; width:auto">
									<table>
										<tr>
											<td align="center">
												<?php if ($p['foto'] != '') { ?>
													<img src="<?php echo base_url() ?>uploads/djs/<?php echo $p['foto'] ?>" />
												<?php } ?>
											</td>
										</tr>
										<tr>
											<td align="center">
												<?php echo $p['nombre'] ?> <br /> Tel: <?php echo $p['telefono'] ?><br /> E-mail: <?php echo $p['email'] ?>
											</td>
										</tr>
									</table>
								</label>
							</li>
					<?php }
					} else {
						echo "No hay DJ asignado";
					} ?>
				</ul>
				Cambiar/Asignar DJ:
				<select name="dj_id">
					<?php
					foreach ($djs as $p) { ?>
						<option value="<?php echo $p['id'] ?>"><?php echo $p['nombre'] ?></option>
					<?php
					}
					?>
					<option value="">No asignar</option>
				</select>
				<input style="width:75px;" type="submit" name="update_dj" value="Cambiar DJ" />

				<br><br>
				<center><strong>HORAS DE TRABAJO</strong> <a href="#" onclick="return anade_horas_dj()"><img src="<?php echo base_url() ?>img/anadir.png" width="18px" title="Añadir horas" /></a></center>
				<input type="hidden" id="horas_concepto" name="horas_concepto" value="" />
				<input type="hidden" id="horas_dj" name="horas_dj" value="">
				<center>
					<table class="tabledata">
						<th>CONCEPTO</th>
						<th>HORAS</th>
						<?php
						if ($horas_dj[0] <> "") {
							foreach ($horas_dj as $horas) { ?>
								<tr>
									<?php
									if ($horas['horas_dj'] <> 0) {
									?>
										<td><?php echo $horas['concepto'] ?></td>
										<td><?php echo $horas['horas_dj'] ?></td>
									<?php
									} else {
									?>
										<td colspan="2"><?php echo $horas['concepto'] ?></td>
									<?php
									}
									?>
									<td><a href="#" onclick="return elimina_horas_dj(<?php echo $horas['id_hora_dj'] ?>,<?php echo $cliente['id'] ?>)"><img src="<?php echo base_url() ?>img/cancel.gif" width="18px" title="Eliminar horas" /></a></td>
								</tr>
						<?php
							}
						}
						?>
						<!--<span class="edit_box" id="horas_dj"><?php //echo $cliente['horas_dj']
																	?></span>-->
					</table>
				</center>
				<br><br>
				Equipo componentes:
				<?php
				if ($equipo_componentes_asignado) {
					$se_compone_de = "";
					foreach ($equipo_componentes_asignado as $equipo) {
						$se_compone_de = "<font size=\"+1\"><b>ESTE EQUIPO SE COMPONE DE: </b></font><br>(Haz click para ver las reparaciones de cada componente)<br>";
						foreach ($componentes as $c) {
							if ($equipo['id_grupo'] == $c['id_grupo']) {
								$reparado = "";
								$esta_reparado = "NO";
								if ($reparaciones_totales) {
									foreach ($reparaciones_totales as $r) {
										if ($c['id_componente'] == $r['id_componente']) {
											$reparado = $reparado . "\\n" . $r['fecha_reparacion'] . "\\n" . $r['reparacion'];
											$esta_reparado = "SI";
										}
									}
								}
								if ($reparado == "") {
									$reparado = "Este componente no tiene reparaciones";
								}
								if ($esta_reparado == "NO") {
									$se_compone_de = $se_compone_de . '<br><b><a onclick="alert(\'' . $reparado . '\');">' . $c['n_registro'] . '///' . $c['nombre_componente'] . '</a></b>';
								} else {
									$se_compone_de = $se_compone_de . '<br><font color="red"><b><a onclick="alert(\'' . $reparado . '\');">' . $c['n_registro'] . '///' . $c['nombre_componente'] . '</a></b></font>';
								}
							}
						}
				?>
						<a href="#" onclick="muestra_componentes_equipo('<?php echo addslashes(htmlentities($se_compone_de)) ?>')"><b><?php echo $equipo['nombre_grupo'] ?></b></a><br><?php
																																													}
																																												} else {
																																														?><b>No asignado</b><br><?php
																																																			}
																																																				?>
				<select name="equipo_componentes">
					<?php
					foreach ($equipos_disponibles as $e1) { ?>
						<option value="<?php echo $e1['id_grupo'] ?>"><?php echo $e1['nombre_grupo'] ?></option>
					<?php
					}
					?>
					<option value="">No asignar</option>
				</select>
				<input style="width:60px;" type="submit" name="update_equipo_componentes" value="Cambiar" />
				<br><br>
				Equipo Luces:
				<?php
				if ($equipo_luces_asignado) {
					$se_compone_de = "";
					foreach ($equipo_luces_asignado as $equipol) {
						$se_compone_de = "<font size=\"+1\"><b>ESTE EQUIPO SE COMPONE DE: </b></font><br>(Haz click para ver las reparaciones de cada componente)<br>";
						foreach ($componentes as $c) {
							if ($equipol['id_grupo'] == $c['id_grupo']) {
								$reparado = "";
								$esta_reparado = "NO";
								if ($reparaciones_totales) {
									foreach ($reparaciones_totales as $r) {
										if ($c['id_componente'] == $r['id_componente']) {
											$reparado = $reparado . "\\n" . $r['fecha_reparacion'] . "\\n" . $r['reparacion'];
											$esta_reparado = "SI";
										}
									}
								}
								if ($reparado == "") {
									$reparado = "Este componente no tiene reparaciones";
								}
								if ($esta_reparado == "NO") {
									$se_compone_de = $se_compone_de . '<br><b><a onclick="alert(\'' . $reparado . '\');">' . $c['n_registro'] . '///' . $c['nombre_componente'] . '</a></b>';
								} else {
									$se_compone_de = $se_compone_de . '<br><font color="red"><b><a onclick="alert(\'' . $reparado . '\');">' . $c['n_registro'] . '///' . $c['nombre_componente'] . '</a></b></font>';
								}
							}
						}
				?>
						<a href="#" onclick="muestra_componentes_equipo('<?php echo addslashes(htmlentities($se_compone_de)) ?>')"><b><?php echo $equipol['nombre_grupo'] ?></b></a><br><?php
																																													}
																																												} else {
																																														?><b>No asignado</b><br><?php
																																																			} ?>
				<select name="equipo_luces">
					<?php
					foreach ($equipos_disponibles as $e2) { ?>
						<option value="<?php echo $e2['id_grupo'] ?>"><?php echo $e2['nombre_grupo'] ?></option>
					<?php
					}
					?>
					<option value="">No asignar</option>
				</select>
				<input style="width:60px;" type="submit" name="update_equipo_luces" value="Cambiar" />
				<br><br>
				Equipo Extra1:
				<?php
				if ($equipo_extra1_asignado) {
					$se_compone_de = "";
					foreach ($equipo_extra1_asignado as $equipoe1) {
						$se_compone_de = "<font size=\"+1\"><b>ESTE EQUIPO SE COMPONE DE: </b></font><br>(Haz click para ver las reparaciones de cada componente)<br>";
						foreach ($componentes as $c) {
							if ($equipoe1['id_grupo'] == $c['id_grupo']) {
								$reparado = "";
								$esta_reparado = "NO";
								if ($reparaciones_totales) {
									foreach ($reparaciones_totales as $r) {
										if ($c['id_componente'] == $r['id_componente']) {
											$reparado = $reparado . "\\n" . $r['fecha_reparacion'] . "\\n" . $r['reparacion'];
											$esta_reparado = "SI";
										}
									}
								}
								if ($reparado == "") {
									$reparado = "Este componente no tiene reparaciones";
								}
								if ($esta_reparado == "NO") {
									$se_compone_de = $se_compone_de . '<br><b><a onclick="alert(\'' . $reparado . '\');">' . $c['n_registro'] . '///' . $c['nombre_componente'] . '</a></b>';
								} else {
									$se_compone_de = $se_compone_de . '<br><font color="red"><b><a onclick="alert(\'' . $reparado . '\');">' . $c['n_registro'] . '///' . $c['nombre_componente'] . '</a></b></font>';
								}
							}
						}
				?>
						<a href="#" onclick="muestra_componentes_equipo('<?php echo addslashes(htmlentities($se_compone_de)) ?>')"><b><?php echo $equipoe1['nombre_grupo'] ?></b></a><br><?php
																																														}
																																													} else {
																																															?><b>No asignado</b><br><?php
																																																				} ?>
				<select name="equipo_extra1">
					<?php
					foreach ($equipos_disponibles as $e2) { ?>
						<option value="<?php echo $e2['id_grupo'] ?>"><?php echo $e2['nombre_grupo'] ?></option>
					<?php
					}
					?>
					<option value="">No asignar</option>
				</select>
				<input style="width:60px;" type="submit" name="update_equipo_extra1" value="Cambiar" />
				<br><br>
				Equipo Extra2:
				<?php
				if ($equipo_extra2_asignado) {
					$se_compone_de = "";
					foreach ($equipo_extra2_asignado as $equipoe2) {
						$se_compone_de = "<font size=\"+1\"><b>ESTE EQUIPO SE COMPONE DE: </b></font><br>(Haz click para ver las reparaciones de cada componente)<br>";
						foreach ($componentes as $c) {
							if ($equipoe2['id_grupo'] == $c['id_grupo']) {
								$reparado = "";
								$esta_reparado = "NO";
								if ($reparaciones_totales) {
									foreach ($reparaciones_totales as $r) {
										if ($c['id_componente'] == $r['id_componente']) {
											$reparado = $reparado . "\\n" . $r['fecha_reparacion'] . "\\n" . $r['reparacion'];
											$esta_reparado = "SI";
										}
									}
								}
								if ($reparado == "") {
									$reparado = "Este componente no tiene reparaciones";
								}
								if ($esta_reparado == "NO") {
									$se_compone_de = $se_compone_de . '<br><b><a onclick="alert(\'' . $reparado . '\');">' . $c['n_registro'] . '///' . $c['nombre_componente'] . '</a></b>';
								} else {
									$se_compone_de = $se_compone_de . '<br><font color="red"><b><a onclick="alert(\'' . $reparado . '\');">' . $c['n_registro'] . '///' . $c['nombre_componente'] . '</a></b></font>';
								}
							}
						}
				?>
						<a href="#" onclick="muestra_componentes_equipo('<?php echo addslashes(htmlentities($se_compone_de)) ?>')"><b><?php echo $equipoe2['nombre_grupo'] ?></b></a><br><?php
																																														}
																																													} else {
																																															?><b>No asignado</b><br><?php
																																																				} ?>
				<select name="equipo_extra2">
					<?php
					foreach ($equipos_disponibles as $e2) { ?>
						<option value="<?php echo $e2['id_grupo'] ?>"><?php echo $e2['nombre_grupo'] ?></option>
					<?php
					}
					?>
					<option value="">No asignar</option>
				</select>
				<input style="width:60px;" type="submit" name="update_equipo_extra2" value="Cambiar" />
			</fieldset>
			<style>
				fieldset.fieldsetencuesta label {
					width: 100%;
					float: left;
					text-align: left;
					padding-right: 20px;
				}


				fieldset.datos input[type="radio"],
				fieldset.datos input[type="checkbox"] {
					width: 20px;
				}

				.fieldsetencuesta {
					width: 95%;
				}
			</style>

			<fieldset class="fieldsetencuesta">
				<legend>Encuesta del cliente respecto a la boda:</legend>

				<?php if (!empty($preguntas_encuesta_datos_boda)) { ?>
					<form>
						<?php foreach ($preguntas_encuesta_datos_boda as $pregunta) { ?>
							<span>
								<strong><?php echo htmlspecialchars($pregunta['pregunta']); ?></strong>
								<?php if (!empty($pregunta['descripcion'])) { ?>
									<span><?php echo $pregunta['descripcion']; ?></span>
								<?php } else { ?>
									<br><br>
								<?php } ?>

								<?php
								$respuestas = array();
								foreach ($opciones_respuestas_encuesta_datos_boda as $resp) {
									if (intval($resp['id_pregunta']) === intval($pregunta['id_pregunta'])) {
										$respuestas[] = $resp;
									}
								}

								if (!is_array($respuesta_cliente)) {
									$respuesta_cliente = array();
								}

								$respuesta_cliente_actual = null;
								$respuestas_seleccionadas = array();

								foreach ($respuesta_cliente as $resp) {
									if ($resp['id_pregunta'] == $pregunta['id_pregunta']) {
										if ($pregunta['tipo_pregunta'] == 'multiple') {
											$respuestas_seleccionadas = array_merge($respuestas_seleccionadas, array_map('trim', explode(',', $resp['respuesta'])));
										} else {
											$respuesta_cliente_actual = $resp['respuesta'];
										}
									}
								}

								$tipo = isset($pregunta['tipo_pregunta']) ? strtolower($pregunta['tipo_pregunta']) : '';
								?>

								<?php if ($tipo == 'rango') { ?>
									<input type="range" min="0" max="10" value="<?php echo htmlspecialchars(!empty($respuesta_cliente_actual) ? $respuesta_cliente_actual : 5); ?>" disabled>
									<span><?php echo htmlspecialchars(!empty($respuesta_cliente_actual) ? $respuesta_cliente_actual : 'No respondido'); ?></span>

								<?php } elseif ($tipo == 'opciones' && !empty($respuestas)) { ?>
									<?php
									$respuesta_encontrada = false;
									foreach ($respuestas as $respuesta) {
										if (!empty($respuesta_cliente_actual) && $respuesta_cliente_actual == $respuesta['respuesta']) {
											$respuesta_encontrada = true;
										}
									}
									?>

									<?php foreach ($respuestas as $respuesta) { ?>
										<label>
											<input type="radio" disabled
												<?php echo (!empty($respuesta_cliente_actual) && $respuesta_cliente_actual == $respuesta['respuesta']) ? 'checked' : ''; ?>>
											<?php echo htmlspecialchars($respuesta['respuesta']); ?>
										</label><br>
									<?php } ?>

									<?php if (!$respuesta_encontrada && !empty($respuesta_cliente_actual)) { ?>
										<!-- Mostrar input de número si la respuesta no coincide con ninguna opción -->
										<label>
											<input type="radio" disabled checked>
											Número exacto:
											<input type="number" value="<?php echo htmlspecialchars($respuesta_cliente_actual); ?>" disabled>
										</label><br>
									<?php } ?>

								<?php } elseif ($tipo == 'multiple' && !empty($respuestas)) { ?>
									<?php
									$respuestas_disponibles = array_map(function ($r) {
										return trim($r['respuesta']);
									}, $respuestas);

									$respuestas_extra = array_filter($respuestas_seleccionadas, function ($r) use ($respuestas_disponibles) {
										return !in_array($r, $respuestas_disponibles);
									});
									?>

									<?php foreach ($respuestas as $respuesta) { ?>
										<label>
											<input type="checkbox" disabled
												<?php echo (!empty($respuestas_seleccionadas) && in_array(trim($respuesta['respuesta']), $respuestas_seleccionadas)) ? 'checked' : ''; ?>>
											<?php echo htmlspecialchars($respuesta['respuesta']); ?>
										</label><br>
									<?php } ?>

									<?php foreach ($respuestas_extra as $respuesta_extra) { ?>
										<label>
											<input type="checkbox" disabled checked>
											<?php echo htmlspecialchars($respuesta_extra); ?>
										</label><br>
									<?php } ?>

								<?php } elseif ($tipo == 'texto') { ?>
									<input type="text" value="<?php echo htmlspecialchars(!empty($respuesta_cliente_actual) ? $respuesta_cliente_actual : 'No respondido'); ?>" disabled>

								<?php } else { ?>
									<p>El tipo de pregunta <strong><?php echo htmlspecialchars($tipo); ?></strong> no está soportado.</p>
								<?php } ?>
							</span>
							<br><br>
						<?php } ?>
					</form>
				<?php } else { ?>
					<li>No se ha realizado la encuesta</li>
				<?php } ?>
			</fieldset>

		</fieldset>

		<?php
		// Deserializar datos
		$arr_servicios = !empty($cliente['servicios']) ? unserialize($cliente['servicios']) : [];

		// Revisar si el formato es el antiguo o el nuevo
		foreach ($arr_servicios as $id => $valor) {
			// Si el formato es antiguo (solo tiene precio como string)
			if (!is_array($valor)) {
				$arr_servicios[$id] = array(
					'precio' => floatval($valor), // Convertimos el precio a número
					'descuento' => 0 // Asignamos 0 por defecto
				);
			}
		}

		$total = !empty($arr_servicios) ? array_sum(array_column($arr_servicios, 'precio')) : 0;
		$totalDescuento = 0;
		$descuento1 = $cliente['descuento'];
		?>

		<form method="POST" action="">
			<fieldset class="datos">
				<legend>Servicios</legend>
				<ul>
					<?php foreach ($servicios as $servicio):
						$id = $servicio['id'];
						$precio = isset($arr_servicios[$id]['precio']) ? $arr_servicios[$id]['precio'] : $servicio['precio'];
						$descuento = isset($arr_servicios[$id]['descuento']) ? $arr_servicios[$id]['descuento'] : 0;
						$totalDescuento += $descuento;
					?>
						<li>
							<input type="checkbox" name="servicios[<?php echo $id; ?>][activo]"
								value="1"
								<?php echo isset($arr_servicios[$id]) ? 'checked="checked"' : ''; ?>
								id="chserv_<?php echo $id; ?>" style="width:30px; vertical-align:middle" />

							<?php echo $servicio['nombre'] . " - "; ?>

							<input type="text"
								onchange="$('#chserv_<?php echo $id; ?>').prop('checked', true);"
								id="precioserv_<?php echo $id; ?>"
								name="servicios[<?php echo $id; ?>][precio]"
								value="<?php echo $precio; ?>"
								style="width:50px; text-align:center" /> &euro;

							Dto <input type="text"
								onchange="$('#chserv_<?php echo $id; ?>').prop('checked', true);"
								id="dtoserv_<?php echo $id; ?>"
								name="servicios[<?php echo $id; ?>][descuento]"
								value="<?php echo $descuento; ?>"
								style="width:50px; text-align:center" /> &euro;
						</li>
					<?php endforeach; ?>
				</ul>

				<!-- Input oculto para asegurarse de que siempre haya datos en $_POST['servicios'] -->
				<input type="hidden" name="servicios_check" value="1">

				<!-- Otros inputs del formulario -->
				<input type="hidden" name="id_cliente" value="<?php echo isset($cliente['id']) ? $cliente['id'] : ''; ?>">
				<br>
				<input type="submit" style="width:15%" name="update_servicios" value="Actualizar servicios y descuentos" />

				<br /><br />
				<label style="width: 20%; text-align: left;">Descuento1: <?php echo $descuento1 ?>€</label><br>
				<label style="width: 20%; text-align: left;">Descuento2: <?php echo $totalDescuento ?>€</label><br>

				<br />
				<label style="width: 20%; text-align: left; font-size: 1.3em">
					<strong>Total:
						<?php
						$descuento1_text = $descuento1 != 0 ? " - " . $descuento1 . "€" : "";
						$totalDescuento_text = $totalDescuento != 0 ? " - " . $totalDescuento . "€" : "";
						$total_final = $total - $descuento1 - $totalDescuento;
						echo $total . "€" . $descuento1_text . $totalDescuento_text . " = " . $total_final . "€";
						?>
					</strong>
				</label>
			</fieldset>
		</form>



		<script>
			function actualizarTotalDescuento() {
				let total = 0;

				document.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
					if (checkbox.checked) {
						let servicioId = checkbox.id.replace("chserv_", ""); // Obtener el ID del servicio
						let descuentoInput = document.getElementById("dtoserv_" + servicioId);

						if (descuentoInput) {
							total += parseFloat(descuentoInput.value) || 0;
						}
					}
				});

				document.getElementById("totalDescuento").innerText = total.toFixed(2) + "€";
				document.getElementById("input_totalDescuento").value = total.toFixed(2);
			}
		</script>

		<form method="post" action="" enctype="multipart/form-data">
			<fieldset>
				<legend>Pagos, Presupuesto &amp; Contrato</legend>

				<ul>
					<!-- Presupuesto -->
					<li><strong>Presupuesto:</strong>
						<?php if (!empty($cliente['presupuesto_pdf'])) { ?>
							<a href="<?php echo base_url() ?>uploads/pdf/<?php echo $cliente['presupuesto_pdf'] ?>">Descargar</a>
						<?php } else echo "No hay Presupuesto"; ?>
					</li>
					<li style="padding:8px 0;">
						<label>Subir Presupuesto:</label>
						<input type="file" name="presupuesto" />
						<input type="hidden" name="cliente_id" value="<?php echo $cliente['id']; ?>">
						<input type="submit" name="add_presupuesto" value="Subir" />
					</li>

					<!-- Contrato -->
					<li><strong>Contrato:</strong>
						<?php if (!empty($cliente['contrato_pdf'])) { ?>
							<a href="<?php echo base_url() ?>uploads/pdf/<?php echo $cliente['contrato_pdf'] ?>">Descargar</a>
						<?php } else echo "No hay Contrato"; ?>
					</li>
					<li style="padding:8px 0;">
						<label>Subir Contrato:</label>
						<input type="file" name="contrato" />
						<input type="hidden" name="cliente_id" value="<?php echo $cliente['id']; ?>">
						<input type="submit" name="add_contrato" value="Subir" />
					</li>

					<!-- Estado de Pagos -->
					<li style="padding:8px 0;"><strong>Estado de Pagos</strong></li>

					<?php
					$suma_pagos = 0;
					if (count($pagos) == 0) {
						echo "<li>Aún no se han hecho pagos</li>";
						echo '<li style="padding:8px 0;">Pago Inicial: 
                    <input type="number" step="0.01" name="valor"> 
                    ¿Pago en B? <input type="checkbox" name="tipo_pago"> 
                    ¿Enviar e-mail? <input type="checkbox" name="enviar_email_pago" checked> 
                    <input type="submit" name="add_pago" value="Subir" />
                	</li>';
					} else {
						foreach ($pagos as $p) {
							$suma_pagos += $p['valor']; ?>
							<li style="padding:8px 0;">
								<strong><?php echo date("d-m-Y", strtotime($p['fecha'])) . " - " . number_format($p['valor'], 2, ",", ".") ?></strong>€
								<a href="#" onclick="return deletepago('<?php echo $cliente['id'] ?>','<?php echo $p['valor'] ?>','<?php echo $p['fecha'] ?>')">
									<img src="<?php echo base_url() ?>img/delete.gif" width="15" height="15" />
								</a>
							</li>
					<?php }

						if (count($pagos) == 1) {
							echo '<li style="padding:8px 0;">Segundo pago: <input type="numer" step="0.01" name="valor" value="' . number_format(($total / 2) - $suma_pagos, 2, ",", ".") . '"> ¿Pago en B? <input type="checkbox" name="tipo_pago"> ¿Enviar e-mail? <input type="checkbox" name="enviar_email_pago" checked> <input type="submit" name="add_pago" value="Subir" /></li>';
						} else {
							echo '<li style="padding:8px 0;">Siguiente pago: <input type="number" step="0.01" name="valor" value="' .
								($cliente['descuento'] != '' && $cliente['descuento'] != '0'  ?
									number_format($total - $suma_pagos - $cliente['descuento'], 2, ",", ".") : number_format($total - $suma_pagos, 2)) . '"> ¿Pago en B? <input type="checkbox" name="tipo_pago"> ¿Enviar e-mail? <input type="checkbox" name="enviar_email_pago" checked> <input type="submit" name="add_pago" value="Subir" /></li>';
						}
					}

					// Nuevo cálculo de "pendiente por pagar"
					$pendiente = $total - $suma_pagos - $descuento1 - $totalDescuento;
					?>

					<!-- Total pendiente corregido -->
					<li style="padding:8px 0;">Pendiente por pagar:
						<strong><?php echo number_format($pendiente, 2, ",", "."); ?></strong>€
					</li>
				</ul>

				<!-- Mostrar mensaje si hay error o éxito -->
				<?php if (isset($msg_pdf)) echo "<p>{$msg_pdf}</p>"; ?>

			</fieldset>
		</form>



		<fieldset class="datos">
			<legend>Factura</legend>
			<?php if ($factura) { ?>
				<label>Factura:</label>
				<a href="<?php echo base_url() . "uploads/facturas/" . urlencode($factura["factura_pdf"]); ?>" target="_blank">
					<?php echo $factura["factura_pdf"]; ?>
				</a>
				<form method="POST" action="<?php echo base_url('admin/eliminar_factura'); ?>">
					<input type="hidden" name="id_factura" value="<?php echo $factura["id_factura"]; ?>">
					<input type="submit" name="eliminar_factura" value="Eliminar" onclick="return confirm('¿Estás seguro de que quieres eliminar esta factura?');">
				</form>

			<?php } else { ?>
				<form method="POST" enctype="multipart/form-data">
					<input type="hidden" name="id_cliente" value="<?php echo $cliente['id_cliente']; ?>" />
					<ul>
						<li><label>Fecha de la factura</label><input type="text" name="fecha_factura" id="fecha_factura" /></li>
						<li><label>Nº Factura</label><input type="text" name="n_factura" id="n_factura" /></li>
						<li><label>Subir Factura:</label> <input type="file" name="factura" /></li>
						<li><input type="submit" name="add_factura" value="Guardar"></li>
					</ul>
				</form>
			<?php } ?>
		</fieldset>





		<fieldset class="datos">
			<legend>Observaciones</legend>

			<?php if (!$observaciones_cliente): ?>
				<p style="text-align:center;padding:20px">Todavía no se han añadido observaciones</p>
			<?php else: ?>
				<ul class="observaciones obs_admin" id="lista_observaciones">
					<?php foreach ($observaciones_cliente as $observacion): ?>
						<li id="o_<?php echo $observacion['id']; ?>" style="margin-bottom: 10px; padding: 10px; border: 1px solid #ccc; border-radius: 5px; background-color: #f9f9f9; display: flex; justify-content: space-between; align-items: flex-start;">

							<!-- Contenido de la observación -->
							<div style="flex: 1;">
								<p style="margin: 0 0 5px 0;"><strong>Observación:</strong> <?php echo nl2br($observacion['comentario']); ?></p>

								<?php
								$url = trim($observacion['link']);
								if (!empty($url)) {
									if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
										$url = "http://" . $url;
									}
									echo '<p style="margin: 0 0 5px 0;"><span>Link:</span> <a href="' . htmlspecialchars($url, ENT_QUOTES, 'UTF-8') . '" target="_blank" style="color: #007bff; text-decoration: none;">' . htmlspecialchars($observacion['link'], ENT_QUOTES, 'UTF-8') . '</a></p>';
								}
								?>

								<small style="color: #666;">Fecha: <?php echo date('d/m/Y', strtotime($observacion['fecha'])); ?></small>
							</div>

							<!-- Acciones: eliminar y ocultar -->
							<div style="display: flex; flex-direction: column; align-items: center; margin-top: auto; margin-bottom: auto;">
								<a href="#" onclick="return deleteobservacion_admin(<?php echo $observacion['id']; ?>)" title="Eliminar">
									<img style="margin: 0" src="<?php echo base_url(); ?>img/delete.gif" width="18" alt="Eliminar" />
								</a>

								<label title="Ocultar Observacion a Invitados y Restaurantes" style="text-align: center; margin-top: 6px; font-size: 12px; padding: 0;">
									Ocultar<br>
									<input type="checkbox"
										name="ocultar"
										id="ocultar_<?php echo $observacion['id']; ?>"
										value="<?php echo $observacion['id']; ?>"
										<?php echo $observacion['ocultar'] == 1 ? 'checked' : ''; ?>
										style="margin-top: 2px;">
								</label>
							</div>

						</li>

					<?php endforeach; ?>
				</ul>
			<?php endif; ?>

			<li style="padding:8px 0;"><strong>Añadir Observación:</strong></li>

			<form method="post" action="" id="form_observacion" style="display: flex; flex-direction: column; align-items: left;">
				<textarea name="observaciones" id="observaciones" style="width:100%; height:50px; float:left;"
					placeholder="Observación"></textarea>
				<br>

				<li style="padding:8px 0;"><strong>Link:</strong></li>
				<input style="text-align: left" type="text" name="link" id="link"
					placeholder="Ej.: https://www.youtube.com/watch?v=a1Femq4NPxs" style="width:300px; float:left" />
				<br>
				<input type="submit" name="add_observ" value="Añadir">
			</form>

			<script>
				$(document).ready(function() {
					$('input[type=checkbox][name=ocultar]').change(function() {
						var id = $(this).val();
						var ocultar = $(this).is(':checked') ? 1 : 0;

						$.ajax({
							url: '<?php echo base_url() ?>index.php/ajax/update_observacion_ocultar',
							type: 'POST',
							data: {
								id: id,
								ocultar: ocultar
							},
							success: function(response) {
								console.log("Estado actualizado: " + response);
							},
							error: function(xhr, status, error) {
								alert("Error al actualizar el estado de ocultar.");
							}
						});
					});
				});
			</script>


			<!-- Cargar TinyMCE -->
			<script src="<?php echo base_url() . "js/tinymce/tinymce.min.js" ?>"></script>

			<script>
				// Inicialización de TinyMCE
				document.addEventListener("DOMContentLoaded", function() {
					tinymce.init({
						selector: 'textarea',
						toolbar: 'bold italic fontsizeselect',
						font_size_formats: '8pt 10pt 12pt 14pt 18pt 24pt 36pt',
						content_style: 'body { font-size: 14px; }',
						branding: false,
						menubar: false,
						height: 200,
					});
				});

				document.addEventListener("DOMContentLoaded", function() {
					var form = document.getElementById("form_observacion");
					var textarea = document.getElementById("observaciones");

					// Eliminar required porque el campo está oculto
					textarea.removeAttribute("required");

					// Agregar validación en el submit
					form.addEventListener("submit", function(event) {
						var editor = tinymce.get("observaciones"); // Obtener instancia de TinyMCE
						var content = editor ? editor.getContent().trim() : textarea.value.trim(); // Obtener contenido

						if (!content) {
							alert("El campo de observación no puede estar vacío.");
							event.preventDefault(); // Evita el envío del formulario
						}
					});
				});
			</script>

			<div style="text-align:center; clear: left; margin-top:20px">
				<?php if ($this->session->flashdata('msg')): ?>
					<p><?php echo $this->session->flashdata('msg'); ?></p>
				<?php endif; ?>
			</div>
		</fieldset>


		<div class="clear"> </div>
		<fieldset class="datos">
			<legend>Listado personas de contacto</legend>
			<ul>
				<?php
				if ($personas) {
					$arr_pers_contr = explode(",", $cliente['personas_contacto']);
					foreach ($personas as $p) { ?>
						<li style="display: block; float:left; padding:0 20px; text-align:center; height:360px">
							<label for="p<?php echo $p['id'] ?>" style="float:none; text-align:center; width:auto">
								<?php if ($p['foto'] != '') { ?>
									<img style="max-height:320px" src="<?php echo base_url() ?>uploads/personas_contacto/<?php echo $p['foto'] ?>" />
								<?php } ?>
								<br />
								<?php echo $p['tipo'] ?>
								<?php echo $p['nombre'] ?>
							</label>
							<input type="checkbox" name="personas_contacto[]" <?php echo in_array($p['id'], $arr_pers_contr) ? 'checked="checked"' : '' ?> id="p<?php echo $p['id'] ?>" value="<?php echo $p['id'] ?>" style="width:30px" />

						</li>
				<?php }
				} ?>
			</ul>
			<p style="text-align:center; clear:left; padding-top:20px"><input type="submit" name="personas" value="Actualizar" /></p>
		</fieldset>

		<fieldset class="datos">
			<legend>Valoración satisfacción del DJ</legend>
			<table class="tabledata">
				<tr>
					<th>Pregunta</th>
					<th>Respuesta</th>
				</tr>
				<?php
				$i = 1;
				foreach ($valoraciones as $valoracion) { ?>
					<tr>
						<td><?php echo $valoracion['pregunta'] ?></td>


						<?php
						if ($valoracion['id_pregunta'] == '5') //pregunta de checkbox
						{
						?>
							<td align="left" style="margin:0">
								<?php
								if ($valoracion['respuesta'] <> "") {
									//echo $valoracion['respuesta'];
									$arr_juegos_realizados = explode(",", $valoracion['respuesta']);
									foreach ($juegos as $juego) { ?>
										<input type="checkbox" name="juegos[]" <?php echo in_array($juego['id_juego'], $arr_juegos_realizados) ? 'checked="checked"' : '' ?> value="<?php echo $juego['id_juego'] ?>" style="width:30px; vertical-align:middle" disabled />
										<?php echo $juego['juego'] ?><br />
									<?php
									}
								} else {
									foreach ($juegos as $juego) { ?>
										<input type="checkbox" name="juegos[]" id="j<?php echo $juego['id_juego'] ?>" value="<?php echo $juego['id_juego'] ?>" style="width:30px" disabled /><?php echo $juego['juego'] ?><br />
								<?php
									}
								}
								?>
							</td>
						<?php
						} else if ($valoracion['id_pregunta'] == '6') //pregunta de campo de texto
						{
						?><td><input type="text" value="<?php echo $valoracion['respuesta'] ?>" disabled></td><?php
																											} else {
																												?>
							<td>
								<?php
																												if ($valoracion['respuesta'] <> "") {
								?>
									<div class="valoracion" data-average="<?php echo $valoracion['respuesta'] ?>" id="<?php echo $i ?>" data-id="<?php echo $i ?>"></div>
									<input type="hidden" name="res<?php echo $i ?>" id="res<?php echo $i ?>" size="2" maxlength="2" value="<?php echo $valoracion['respuesta'] ?>" />
								<?php
																												} else {
								?>
									<div class="valoracion" data-average="0" id="<?php echo $i ?>" data-id="<?php echo $i ?>"></div>
									<input type="hidden" name="res<?php echo $i ?>" id="res<?php echo $i ?>" size="2" maxlength="2" value="" />
								<?php
																												}
								?>
							</td>
						<?php
																											}
						?>

					</tr>
				<?php
					$i++;
				} ?>
			</table>
		</fieldset>

		<fieldset class="datos">
			<legend>Incidencias</legend>
			<table style="width:100%" class="tabledata">
				<tr><?php
					foreach ($incidencias as $incidencia) { ?>

						<td><textarea name="incidencia" rows="10" cols="100" disabled="disabled"><?php echo $incidencia['incidencia'] ?></textarea></td>
					<?php
					}
					?>
				</tr>
			</table>
		</fieldset>

		<fieldset class="datos">
			<legend>Canciones</legend>
			<table style="width:100%" class="tabledata">
				<tr><?php
					foreach ($canciones_pendientes as $canciones_p) { ?>

						<td><textarea name="texto_canciones_pendientes" rows="10" cols="100" disabled="disabled"><?php echo $canciones_p['canciones'] ?></textarea></td>
					<?php
					}
					?>
				</tr>
			</table>
		</fieldset>
		<p style="text-align:center"></p>
	</form>

</div>
<div class="clear">
</div>


<style>
	.popup {
		display: none;
		position: fixed;
		z-index: 9999;
		left: 0;
		top: 0;
		width: 100%;
		height: 100%;
		background-color: rgba(0, 0, 0, 0.5);
		display: flex;
		justify-content: center;
		align-items: center;
	}

	.popup-content {
		background: white;
		padding: 20px;
		border-radius: 10px;
		text-align: center;
		box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
	}

	.popup button {
		margin: 3px;
		padding: 0px 4px
	}
</style>