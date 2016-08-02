<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Temas_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get($id = null)
    {
        if (!is_null($id)) {
            if($id=='activo'){
                $query = $this->db->select('*')->from('TEMAS')->where('activo', 'SI')->get();
                if ($query->num_rows() > 0) {
                    return $query->result_array();
                }

                return null;
            }else{
                $query = $this->db->select('*')->from('TEMAS')->where('nombre', $id)->get();
                if ($query->num_rows() === 1) {
                    return $query->row_array();
                }

                return null;
            }
        }

        $query = $this->db->select('*')->from('TEMAS')->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }

        return null;
    }

    public function save($tema)
    {
        $this->db->set($this->_setTema($tema))->insert('TEMAS');

        if ($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }

        return null;
    }

    public function update($tema)
    {
        $id = $tema['id_tema'];

        $this->db->set($this->_setTema($tema))->where('id_tema', $id)->update('TEMAS');

        if ($this->db->affected_rows() === 1) {
            return true;
        }

        return null;
    }

    public function delete($id)
    {
        $this->db->where('id_tema', $id)->delete('TEMAS');

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
    
    private function _setTema($tema)
    {
        return array(
            'nombre' => $tema['nombre'],
            'activo' => $tema['activo'],
            'es_filtro' => $tema['es_filtro']
        );
    }
}