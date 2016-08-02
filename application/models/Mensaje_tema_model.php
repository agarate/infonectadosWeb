<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mensaje_tema_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get($id = null)
    {
        if (!is_null($id)) {
            
                $query = $this->db->select('*')->from('MENSAJE_TEMA')->where('id_mensaje', $id)->get();
                if ($query->num_rows() >0) {
                    return $query->result_array();
                }
                return null;
            
        }

        $query=$this->db->query("CALL Mensajes_temas()");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }

        return null;
    }

    public function save($mensaje_tema)
    {
        $this->db->set($this->_setMensaje_tema($mensaje_tema))->insert('MENSAJE_TEMA');

        if ($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }

        return null;
    }

    public function update($mensaje_tema)
    {
        $id = $mensaje_tema['id'];

        $this->db->set($this->_setMensaje_tema($mensaje_tema))->where('id_usuario', $id)->update('MENSAJE_TEMA');

        if ($this->db->affected_rows() === 1) {
            return true;
        }

        return null;
    }

    public function delete($id)
    {
        $this->db->where('id_usuario', $id)->delete('MENSAJE_TEMA');

        if ($this->db->affected_rows() >0) {
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
    
    private function _setMensaje_tema($mensaje_tema)
    {
        return array(
            'id_mensaje' => $mensaje_tema['id_mensaje'],
            'id_tema' => $mensaje_tema['id_tema']
        );
    }
}