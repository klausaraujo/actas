					<div class="col-12 iq-card my-3">
						<div class="iq-card-header d-flex justify-content-between">
							<div class="iq-header-title"><h4>Registro de Acuerdos</h4></div>
						</div>
						<div class="iq-card-body">
							<form method="post" id="form_actas" class="form">
								<input type="hidden" name="idacta" id="idacta" value="<?=$this->input->get('id')?>" />
								<div class="form-row">
									<div class="col-12 row">
										<label class="control-label col-md-2 align-self-center mb-0 mx-0" for="correlativo">Correlativo:</label>
										<div class="col-md-1">
											<div class="row">
												<input class="form-control form-control-sm" type="text" name="correlativo" id="correlativo" value="<?=$corr?>" readonly />
											</div>
										</div>
									</div>
									<div class="col-12 row mt-2">
										<label class="control-label col-md-2 align-self-center mb-0" for="acuerdo">Acuerdo:</label>
										<div class="col-md-9">
											<div class="row">
												<input type="text" class="form-control form-control-sm mayusc" name="acuerdo" id="acuerdo" />
											</div>
										</div>
									</div>
									<div class="col-12 row mt-2">
										<label class="control-label col-md-2 align-self-center mb-0" for="responsables">Responsables:</label>
										<div class="col-md-9">
											<div class="row">
												<input type="text" class="form-control form-control-sm mayusc" name="responsables" id="responsables" />
											</div>
										</div>
									</div>
									<div class="col-12 row mt-2">
										<label class="control-label col-md-2 align-self-center mb-0" for="finicio">Fecha Inicial:</label>
										<div class="col-md-2">
											<div class="row">
												<input type="date" class="form-control form-control-sm" value="<?=date('Y-m-d')?>"
														min="<?=date('Y-m-d')?>" name="finicio" id="finicio" />
											</div>
										</div>
										<label class="control-label col-md-2 align-self-center mb-0" for="ffin">Fecha Final:</label>
										<div class="col-md-2">
											<div class="row">
												<input type="date" class="form-control form-control-sm" value="<?=date('Y-m-d')?>"
														min="<?=date('Y-m-d')?>" name="ffin" id="ffin" />
											</div>
										</div>
									</div>
									<div class="col-3 ml-auto"><button type="submit" class="btn btn-sabogal ml-5 mr-1" id="btnAgregar">Agregar al Detalle</button></div>
									<div class="col-md-12 text-center resp" style="font-size:1.1em"></div>
									<div class="container-fluid">
										<hr>
										<div class="row">
											<div class="col-12 mx-auto" style="overflow-x:auto">
												<table id="tablaAcuerdos" class="table table-striped table-hover table-bordered mb-0 mx-auto" style="width:100%"></table>
											</div>
										</div>
									</div>
								</div>
							</form>
							<!--<div class="container-fluid row"><hr class="col-sm-12"></div>
							<div class="col-sm-12 mx-auto pb-2">
								<button class="btn btn-sabogal ml-3 mr-4" id="guardar" name="guardar">Guardar/Actualizar Detalle</button>
							</div>-->
						</div>
					</div>
					
					<!-- Modal Sucursales -->
						<div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
							<div class="modal-dialog" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<h4 class="modal-title" id="myModalLabel">Editar Acuerdo</h4>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									</div>
									<form method="POST" id="form_edit">
										<input type="hidden" id="eidacuerdo" name="eidacuerdo" value="" />
										<div class="modal-body" style="overflow: hidden;">
											<div class="row col-sm-12">
												<div class="container">
													<div class="row">
														<div class="col-12 row">
															<label class="control-label col-md-4 align-self-center mb-0 mx-0" for="ecorrelativo">Correlativo:</label>
															<div class="col-md-2">
																<div class="row">
																	<input class="form-control form-control-sm" type="text" name="ecorrelativo" id="ecorrelativo" readonly />
																</div>
															</div>
														</div>
														<div class="col-12 row mt-2">
															<label class="control-label col-md-4 align-self-center mb-0" for="eacuerdo">Acuerdo:</label>
															<div class="col-md-8">
																<div class="row">
																	<input type="text" class="form-control form-control-sm mayusc" name="eacuerdo" id="eacuerdo" />
																</div>
															</div>
														</div>
														<div class="col-12 row mt-2">
															<label class="control-label col-md-4 align-self-center mb-0" for="eresponsables">Responsables:</label>
															<div class="col-md-8">
																<div class="row">
																	<input type="text" class="form-control form-control-sm mayusc" name="eresponsables" id="eresponsables" />
																</div>
															</div>
														</div>
														<div class="col-12 row mt-2">
															<label class="control-label col-md-4 align-self-center mb-0" for="efinicio">Fecha Inicial:</label>
															<div class="col-md-4">
																<div class="row">
																	<input type="date" class="form-control form-control-sm" value="<?=date('Y-m-d')?>"
																			min="<?=date('Y-m-d')?>" name="efinicio" id="efinicio" />
																</div>
															</div>
														</div>
														<div class="col-12 row mt-2">
															<label class="control-label col-md-4 align-self-center mb-0" for="effin">Fecha Final:</label>
															<div class="col-md-4">
																<div class="row">
																	<input type="date" class="form-control form-control-sm" value="<?=date('Y-m-d')?>"
																			min="<?=date('Y-m-d')?>" name="effin" id="effin" />
																</div>
															</div>
														</div>
														<div class="col-12 row mt-2">
															<label class="control-label col-md-3 align-self-center mb-0" for="eini">Iniciado:</label>
															<div class="custom-control custom-switch ml-3">
																<input type="checkbox" class="custom-control-input" id="ceini" name="ceini">
																<label class="custom-control-label" for="ceini"></label>
															</div>
															<div class="col-md-4">
																<div class="row">
																	<input type="text" class="form-control form-control-sm d-none datepicker" name="eini" id="eini" />
																</div>
															</div>
														</div>
														<div class="col-12 row mt-2">
															<label class="control-label col-md-3 align-self-center mb-0" for="efin">Finalizado:</label>
															<div class="custom-control custom-switch ml-3">
																<input type="checkbox" class="custom-control-input" id="cefin" name="cefin">
																<label class="custom-control-label" for="cefin"></label>
															</div>
															<div class="col-md-4">
																<div class="row">
																	<input type="text" class="form-control form-control-sm d-none datepicker" name="efin" id="efin" />
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="modal-footer">
											<div class="row">
												<div class="col-md-12">
													<button class="btn btn-light mr-3" data-dismiss="modal" id="cancelAcuerdo">Cancelar</button>
													<button type="submit" class="btn btn-sabogal" data-dismiss="modal" id="editAcuerdo">Actualizar</button>
												</div>
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>