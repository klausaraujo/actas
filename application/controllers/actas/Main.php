<?php
if (! defined("BASEPATH")) exit("No direct script access allowed");

class Main extends CI_Controller
{
	private $usuario;
	
    public function __construct()
	{
		parent::__construct();
		date_default_timezone_set('America/Lima');
		if($this->session->userdata('user')) $this->usuario = json_decode($this->session->userdata('user'));
		else header('location:' .base_url());
	}

    public function index(){}
	
	public function listaActas()
	{
		$this->load->model('Actas_model');
		$anio = $this->input->post('anio');
		$actas = $this->Actas_model->listaActas(['anio' => $anio, 'activo' => 1]);
		/*$this->load->model('Locadores_model');
		$locadores = $this->Locadores_model->listaLocadores(); $hoy = time();
		foreach($locadores as $row):
			if((strtotime($row->fecha_fin) - $hoy) < 0){
				$cta = $this->Locadores_model->validaLista(['idconvocatoria' => $row->idconvocatoria]);
				if($cta === 0)
					$this->Locadores_model->actualizar(
						['idestado' => 4],
						['idconvocatoria' => $row->idconvocatoria,'idestado' => 1],
						'convocatoria_locadores'
					);
				elseif($cta > 0)
					$this->Locadores_model->actualizar(
						['idestado' => 2],
						['idconvocatoria' => $row->idconvocatoria,'idestado' => 1],
						'convocatoria_locadores'
					);
			}
		endforeach;
		$listaactualizada = $this->Locadores_model->listaLocadores();*/
		
		echo json_encode(['data' => $actas]);
	}
	public function nueva()
	{
		if($this->uri->segment(1) === 'nuevaacta')header('location:' .base_url(). 'actas/nueva');
		else{
			$this->load->model('Actas_model');
			$acta = array();
			$anio = $this->Actas_model->anio(['activo' => 1]);
			
			if($this->uri->segment(2) === 'editar'){
				$id = $this->input->get('id');
				$acta = $this->Actas_model->listaActa(['idacta' => $id]);
			}
			$data = array(
				'acta' => $acta,
				'anio' => $anio,
			);
			$this->load->view('main',$data);
		}
	}
	public function registrar()
	{
		$this->load->model('Actas_model');
		$this->session->set_flashdata('claseMsg', 'alert-danger');
		$anio = date_format(date_create($this->input->post('fecha')),'Y');
		
		$data = array(
			'anio' => $anio,
			'descripcion' => $this->input->post('descripcion'),
			'fecha' => $this->input->post('fecha'),
		);
		
		if($this->input->post('tiporegistro') === 'registrar'){
			$this->session->set_flashdata('flashMessage', 'No se pudo registrar el <b>Acta</b>');
			$correlativo = $this->Actas_model->correlativo(['anio' => $anio]);
			$data['correlativo'] = $correlativo + 1;
			$data['idusuario_creacion'] = $this->usuario->idusuario;
			$data['fecha_creacion'] = date('Y-m-d H:i:s');
			$data['activo'] = 1;
			if($this->Actas_model->registrar($data)){
				$this->session->set_flashdata('flashMessage', '<b>Acta</b> Registrada');
				$this->session->set_flashdata('claseMsg', 'alert-primary');
			}
		}elseif($this->input->post('tiporegistro') === 'editar'){
			$id = $this->input->post('idacta');
			$this->session->set_flashdata('flashMessage', 'No se pudo actualizar el <b>Acta</b>');
			
			$data['idusuario_edicion'] = $this->usuario->idusuario;
			$data['fecha_edicion'] = date('Y-m-d H:i:s');
			
			if($this->Actas_model->actualizar($data, ['idacta' => $id], 'acta')){
				$this->session->set_flashdata('flashMessage', '<b>Acta</b> Actualizada');
				$this->session->set_flashdata('claseMsg', 'alert-primary');
			}
		}
		header('location:'.base_url().'actas');
	}
	public function anular()
	{
		$this->load->model('Actas_model');
		$id = $this->input->get('id'); $msg = 'No se pudo Anular el Acta'; $status = 500;
		
		if($this->Actas_model->actualizar(
			['activo' => 0,'idusuario_anulacion' => $this->usuario->idusuario,'fecha_anulacion' => date('Y-m-d H:i')],
			['idacta' => $id],
			'acta'
		)){
			$status = 200;
			$msg = 'Acta Anulada';
		}
		
		$data = array(
			'status' => $status,
			'msg' => $msg
		);
		
		echo json_encode($data);
	}
	public function cargaanexo($file,$i,$n)
	{
		$path =  $_SERVER['DOCUMENT_ROOT'].'/contrataciones/public/adjuntos/anexos_locadores/'; $status = 500; $nombre = '';
		
		if($file['name'] !== ''){
			$split = explode('.',$file['name']);
			$nombre = (date('YmdHis')+$i).'.'.end($split);
			
			$config['upload_path'] = $path;
			$config['file_name'] = $nombre;
			$config['allowed_types'] = 'docx|doc|pdf';
			$config['max_size'] = 0;
			$config['max_width'] = 0;
			$config['max_height'] = 0;
			$config['overwrite'] = true;
			
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			
			if($this->upload->do_upload($n)) $status = 200;
		}
		return array('status' => $status, 'nombre' => $nombre);
	}
	public function descargar()
	{
		$path =  $_SERVER['DOCUMENT_ROOT'].'/contrataciones/public/adjuntos/anexos_locadores/';
		$filen = basename($this->input->get('file')); $type = '';
		if(is_file($path.$filen)){
			$size = filesize($path.$filen);
		 
			if(function_exists('mime_content_type')) {
				$type = mime_content_type($path.$filen);
			}else if (function_exists('finfo_file')) {
				$info = finfo_open(FILEINFO_MIME);
				$type = finfo_file($info, $path.$filen);
				finfo_close($info);
			}
		 
			if ($type == '') {
				$type = "application/force-download";
			}
			header('Content-Description: File Transfer');
			header("Content-Type: $type");
			header("Content-Disposition: attachment; filename=$filen");
			header('Content-Transfer-Encoding: binary');
			header('Expires: 0');
			header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
			header('Pragma: public');
			header("Content-Length: $size");
			ob_clean();
			flush();
			readfile($path.$filen);
			exit();
		}
	}
	public function descargarp()
	{
		$path =  $_SERVER['DOCUMENT_ROOT'].'/contrataciones/public/adjuntos/anexos_postulantes/';
		$filen = basename($this->input->get('file')); $type = '';
		if(is_file($path.$filen)){
			$size = filesize($path.$filen);
		 
			if(function_exists('mime_content_type')) {
				$type = mime_content_type($path.$filen);
			}else if (function_exists('finfo_file')) {
				$info = finfo_open(FILEINFO_MIME);
				$type = finfo_file($info, $path.$filen);
				finfo_close($info);
			}
		 
			if ($type == '') {
				$type = "application/force-download";
			}
			header('Content-Description: File Transfer');
			header("Content-Type: $type");
			header("Content-Disposition: attachment; filename=$filen");
			header('Content-Transfer-Encoding: binary');
			header('Expires: 0');
			header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
			header('Pragma: public');
			header("Content-Length: $size");
			ob_clean();
			flush();
			readfile($path.$filen);
			exit();
		}
	}
	public function evaluar()
	{
		$this->load->model('Locadores_model'); $id = $this->input->get('id');
		$postulantes = $this->Locadores_model->listaPostulantes(['idconvocatoria' => $id]);
		$this->load->view('main', ['data' => $postulantes]);
	}
	public function evaluado()
	{
		$this->load->model('Locadores_model');
		$this->session->set_flashdata('flashMessage', 'No se pudo Evaluar'); $this->session->set_flashdata('claseMsg', 'alert-danger');
		$data = json_decode($_GET['json']);
		foreach($data as $row):
			if($this->Locadores_model->actualizar(['puntaje' => $row->puntaje,'ganador' => $row->ganador],
					['idpostulacion' => $row->idpostulacion],'convocatoria_locadores_postulantes')){
				if($this->Locadores_model->actualizar(['calificado' => 1],['idconvocatoria' => $row->idconvocatoria],'convocatoria_locadores')){
					$this->session->set_flashdata('flashMessage', 'Evaluado con &Eacute;xito');
					$this->session->set_flashdata('claseMsg', 'alert-primary');
				}
			}
		endforeach;
		header('location:'.base_url().'locadores');
	}
	public function ver()
	{
		$this->load->model('Locadores_model');
		$versionphp = 7; $a5 = 'A4'; $direccion = 'portrait'; $html = null;
		$img = file_get_contents('http://'.$_SERVER['HTTP_HOST'].'/contrataciones/public/images/logo-white.png');
		$data = $this->Locadores_model->ver(['cp.idconvocatoria' => $this->input->get('id'),'calificado' => 1]);
		$fecha = date_format(date_create($data[0]->fecha_inicio),'d/m/Y'); $denom = $data[0]->denominacion; $estado = $data[0]->estado;
		
		$html =
			'<!doctype html>
			<html lang="es">
				<head>
				<title>Resultados</title>
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
					<style>
						/** Margenes de la pagina en 0 **/
						@page { margin: 0cm 0cm; }
						/** Márgenes reales de cada página en el PDF **/
						body{ width:21cm;font-family:Helvetica;margin-top:3cm;margin-bottom:2cm }
						/** Reglas del encabezado **/
						header {
							position: fixed;
							top: 0cm;
							left: 0cm;
							right: 0cm;
							width: 100%;
						}

						/** Reglas del pie de página **/
						footer {
							position: fixed; 
							bottom: 0cm; 
							left: 0cm; 
							right: 0cm;
							height: 1.3cm;
							width: 100%;
						}
						table.footer{font-size:8px;height:2cm;border-top:0.5px solid #AAA;width:20.5cm;line-height:1em}
						
						/** Reglas del contenido **/
						/* *{ text-transform: uppercase; }*/
						*{ font-size: 13px; }
						.acciones td, .acciones th{border:1px solid #b9b9b9; border-collapse: collapse; font-size: 12px;}
						.acc td{border:1px solid #ababab;}
						.stroke { text-shadow: -1.5px 1px 1px #85C1E9, 1.5px 1px 1px #85C1E9, -1.5px 1px 1px #85C1E9, 1.5px 1px 1px #85C1E9 }
					</style>
				</head>
				<body>
					<!-- Defina bloques de encabezado y pie de página antes de su contenido -->
					<header>
						<table style="width:16cm;margin-top:5mm" cellspacing="1" align="center">
							<tr>
								<td width="10"><img src="data:image/png;base64,'.base64_encode($img).'" style="height:70px" /></td>
								<td><span style="font-size:2rem;font-weight:bold;margin-left:5mm;color:#3f9cd4" class="stroke">Red Prestacional Sabogal</span></td>
							</tr>
						</table>
					</header>
					<main style="width:100%">
						<div style="text-align:center;font-weight:bold;margin:5mm;font-size:14px">PROCESO DE CONVOCATORIA PARA LOCADORES DE SERVICIO</div>
						<table cellspacing="0" style="width:14cm" cellpadding="1" align="center" bgcolor="dcdcdc" class="acciones">
							<tr>
								<td style="width:5cm;padding-left:3mm;font-weight:bold">DEPENDENCIA</td><td style="width:3mm;text-align:center">:</td>
								<td style="padding-left:3mm;font-weight:bold">OFICINA DE SOPORTE INFORM&Aacute;TICO</td>
							</tr>
							<tr bgcolor="#eeeeee">
								<td style="width:5cm;padding-left:3mm;font-weight:bold">FECHA CONVOCATORIA</td><td style="width:3mm;text-align:center">:</td>
								<td style="padding-left:3mm">'.$fecha.'</td>
							</tr>
							<tr>
								<td style="width:5cm;padding-left:3mm;font-weight:bold">DENOMINACI&Oacute;N</td><td style="width:3mm;text-align:center">:</td>
								<td style="padding-left:3mm">'.$denom.'</td>
							</tr>
							<tr bgcolor="#eeeeee">
								<td style="width:5cm;padding-left:3mm;font-weight:bold">ESTADO CONVOCATORIA</td><td style="width:3mm;text-align:center">:</td>
								<td style="padding-left:3mm">'.$estado.'</td>
							</tr>
						</table>
						<div style="text-align:center;font-weight:bold;margin:5mm 0;font-size:14px">RESULTADOS</div>
						<table cellspacing="0" style="width:14cm" cellpadding="1" align="center" class="acciones acc">
							<tr bgcolor="#000" style="color:#fff"><th>DNI/CE</th><th>POSTULANTE</th><th>PUNTAJE</th><th>STATUS</th></tr>';
							foreach($data as $row):
								$html .= '<tr><td>'.$row->numero_documento.'</td><td>'.$row->nombre.'</td><td style="text-align:right">'.$row->puntaje.'</td>
									<td style="text-align:center">'.($row->ganador === '1'? 'GANADOR' : '-').'</td></tr>';
							endforeach;
							
		$html .=			'<tr bgcolor="#ccc"><td colspan="3" style="text-align:right;padding-right:3mm">TOTAL POSTULANTES</td>
							<td style="font-weight:bold;text-align:center">'.count($data).'</td></tr>
						</table>
					</main>
				</body>
			</html>';
		
		if(floatval(phpversion()) < $versionphp){
			$this->load->library('dom');
			$dom = new Dom();
			$dom->generate($direccion, $a5, $html, 'Informe');
		}else{
			$this->load->library('dom1');
			$dom = new Dom1();
			$dom->generate($direccion, $a5, $html, 'Informe');
		}
	}
}