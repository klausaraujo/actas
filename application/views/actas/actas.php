						<? $usuario = json_decode($this->session->userdata('user')); ?>
						<div class="col-12 card px-0 my-3">
							<div class="card-body">
								<!--<h4 class="">Listado General de Convocatorias para Contratación de Locadores de Servicio</h4>
								<hr>-->
								<div class="row justify-content-center">
									<?if($this->session->flashdata('claseMsg')){?><div class="alert <?=$this->session->flashdata('claseMsg')?> py-0 px-5 msg fade show" role="alert">
										<div class="iq-alert-text"><?=$this->session->flashdata('flashMessage')?></div>
									</div><?}?>
									<div class="col-md-12 text-center resp" style="font-size:1.3em"></div>
								</div>
								<div class="row">
									
								</div>
								<div class="container-fluid">
									<div class="row my-1">
										<label class="control-label col-md-2 align-self-center mb-0 mx-0" for="anio">A&ntilde;o:</label>
										<div class="col-md-2">
											<div class="row">
												<select class="form-control form-control-sm" name="anio" id="anio">
												<?	foreach($anio as $row): ?>
													<option value="<?=$row->anio;?>"><?=$row->anio;?></option>
												<?	endforeach; ?>
												</select>
											</div>
										</div>
										<div class="col-2 ml-auto"><a href="<?=base_url();?>nuevaacta" class="btn btn-small btn-sabogal">Nuevo Registro</a></div>
									</div>
									<hr>
									<div class="row">
										<div class="col-12 mx-auto" style="overflow-x:auto">
											<table id="tablaActas" class="table table-striped table-hover table-bordered mb-0 mx-auto" style="width:100%"></table>
										</div>
									</div>
								</div>
							</div>
						</div>