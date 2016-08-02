<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Preguntas_voto_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get($id = null)
    {
        if (!is_null($id)) {
            
                $query = $this->db->select('*')->from('PREGUNTAS_VOTO')->where('id_usuario', $id)->get();
                if ($query->num_rows() > 0) {
                    return $query->result_array();
                }

                return null;
            
        }

        $query = $this->db->select('*')->from('PREGUNTAS_VOTO')->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }

        return null;
    }

    public function save($preguntas_voto)
    {
        $this->db->set($this->_setPreguntas_voto($preguntas_voto))->insert('PREGUNTAS_VOTO');

        if ($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }

        return null;
    }

    public function update($preguntas_voto)
    {
        $id = $preguntas_voto['id'];

        $this->db->set($this->_setPreguntas_voto($preguntas_voto))->where('id_usuario', $id)->update('PREGUNTAS_VOTO');

        if ($this->db->affected_rows() === 1) {
            return true;
        }

        return null;
    }

    public function delete($id)
    {
        $this->db->where('id_voto', $id)->delete('PREGUNTAS_VOTO');

        if ($this->db->affected_rows() === 1) {
            return true;
        }

        return null;
    }

    public function obtener_token($id)
    {
        $this->db->select('*')->from('TOKENS')->where('token', $id);

        $query = $this->db->get();
        if ($query->num_rows()===1) {
            return $query->row_array();
        }

        return null;
    }
    
    private function _setPreguntas_voto($preguntas_voto)
    {
        return array(
            'id_usuario' => $preguntas_voto['id_usuario'],
            'id_pregunta' => $preguntas_voto['id_pregunta']
        );
    }
}