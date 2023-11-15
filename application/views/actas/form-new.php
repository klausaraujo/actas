					<div class="col-12 iq-card my-3">
						<div class="iq-card-header d-flex justify-content-between">
							<div class="iq-header-title"><h4>Registro de Actas</h4></div>
						</div>
						<div class="iq-card-body">
							<form method="post" id="form_actas" action="<?=base_url()?>actas/registrar" class="form">
								<input type="hidden" name="tiporegistro" value="registrar" />
								<div class="form-row">
									<div class="col-12 row">
										<label class="control-label col-md-3 align-self-center mb-0 mx-0" for="anio">A&ntilde;o:</label>
										<div class="col-md-2">
											<div class="row">
												<select class="form-control form-control-sm" name="anio" id="anio">
												<?	foreach($anio as $row): ?>
													<option value="<?=$row->anio;?>"><?=$row->anio;?></option>
												<?	endforeach; ?>
												</select>
											</div>
										</div>
									</div>
									<div class="col-12 row mt-2">
										<label class="control-label col-md-3 align-self-center mb-0" for="descripcion">Descripci&oacute;n:</label>
										<div class="col-md-6">
											<div class="row">
												<textarea class="form-control mayusc" name="descripcion" required=""></textarea>
												<div class="invalid-feedback">Campo requerido</div>
											</div>
										</div>
									</div>
									<div class="col-12 row mt-2">
										<label class="control-label col-md-3 align-self-center mb-0" for="fecha">Fecha:</label>
										<div class="col-md-3">
											<div class="row">
												<input type="date" class="form-control" value="<?=date('Y-m-d')?>"
														min="<?=date('Y-m-d')?>" name="fecha" id="fecha" />
											</div>
										</div>
									</div>
								</div>
								<div class="container-fluid row"><hr class="col-sm-12"></div>
								<div class="col-sm-12 mx-auto pb-2">
									<button type="submit" class="btn btn-sabogal ml-3 mr-4" id="btnEnviar">Guardar Acta</button>
									<button type="reset" class="btn btn-cancel btn-cancelar">Cancelar</button>
								</div>
							</form>
						</div>
					</div>
			