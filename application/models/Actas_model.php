<?php
if (! defined('BASEPATH')) exit('No direct script access allowed');

class Actas_model extends CI_Model
{    
	public function __construct(){ parent::__construct(); }
    
	public function listaActas($where)
    {
        $this->db->select('a.*,LPAD(a.correlativo,5,0) as cor,DATE_FORMAT(a.fecha,"%d/%m/%Y") as fecha');
        $this->db->from('acta a');
		$this->db->where($where);
		$this->db->order_by('a.correlativo', 'desc');
        $result = $this->db->get();
		return ($result->num_rows() > 0)? $result->result() : array();
    }
	public function listaActa($where)
    {
        $this->db->select('a.*,DATE_FORMAT(a.fecha,"%Y-%m-%d") as fecha');
        $this->db->from('acta a');
		$this->db->where($where);
		$this->db->order_by('a.correlativo', 'desc');
        $result = $this->db->get();
		return ($result->num_rows() > 0)? $result->row() : array();
    }
	public function anio($where)
	{
		$rs = $this->db->where($where)->from('anio')->get();
		return $rs->num_rows() > 0? $rs->result() : array();
	}
	public function correlativo($where)
	{
		return $this->db->where($where)->from('acta')->count_all_results();
	}
	public function actualizar($data,$where,$tabla)
	{
		$this->db->db_debug = FALSE;
		$this->db->where($where);
		if($this->db->update($tabla,$data)) return true;
        else return false;
	}
	public function listaConvocatoria($where)
    {
        $this->db->select('*,DATE_FORMAT(fecha_inicio,"%Y-%m-%d %H:%i") as fecha_inicio,DATE_FORMAT(fecha_fin,"%Y-%m-%d %H:%i") as fecha_fin');
        $this->db->from('convocatoria_locadores');
		$this->db->where($where);
        $result = $this->db->get();
		return ($result->num_rows() > 0)? $result->row() : array();
    }
	public function listaPostulantes($where)
    {
        $this->db->select('pl.*,p.profesion,n.nivel');
        $this->db->from('convocatoria_locadores_postulantes pl');
		$this->db->join('profesion p','p.idprofesion = pl.idprofesion');
		$this->db->join('nivel n','n.idnivel = pl.idnivel');
		$this->db->where($where);
		$this->db->order_by('pl.fecha_postulacion', 'desc');
        $result = $this->db->get();
		return ($result->num_rows() > 0)? $result->result() : array();
    }
	public function dependencia($where)
	{
		$this->db->select('*');
		$this->db->from('dependencia');
		$this->db->where($where);
		$result = $this->db->get();
		return ($result->num_rows() > 0)? $result->result() : array();
	}
	public function estado($where)
	{
		$this->db->select('*');
		$this->db->from('estado');
		$this->db->where($where);
		$result = $this->db->get();
		return ($result->num_rows() > 0)? $result->result() : array();
	}
	public function registrar($data)
	{
		if($this->db->insert('acta', $data))return true;
        //else return $error['code'];
		else return false;
	}
	public function registrarBatch($where,$data,$tabla)
	{
		$this->db->trans_begin();
		
		$this->db->where($where);
		$this->db->delete($tabla);
		if(!empty($data))
			$this->db->insert_batch($tabla, $data);
		
		if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return false;
		}else{
			$this->db->trans_commit();
			return true;
		}
	}
	public function ver($where)
	{
		$this->db->select('cp.*,cl.*,e.descripcion as estado');
        $this->db->from('convocatoria_locadores_postulantes cp');
		$this->db->join('convocatoria_locadores cl','cp.idconvocatoria = cl.idconvocatoria');
		$this->db->join('estado e','e.idestado = cl.idestado');
		$this->db->where($where);
		$this->db->order_by('cp.puntaje', 'DESC');
        $result = $this->db->get();
		return ($result->num_rows() > 0)? $result->result() : array();
	}
}