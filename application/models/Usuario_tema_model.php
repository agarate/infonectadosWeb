<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuario_tema_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get($id = null)
    {
        if (!is_null($id)) {
            if(strpos($id, '-') !== false){
                trim($id, '-');
                $query = $this->db->select('*')->from('USUARIO_TEMA')->where('id_usuario', $id)->get();
                if ($query->num_rows() >0) {
                    return $query->result_array();
                }
                return null;
            }
            else if(strpos($id, 'w') !== false){
                $new=trim($id, 'w');
                $query=$this->db->query("CALL Mensajes_estudiante($new)");
                if ($query->num_rows() >0) {
                    return $query->result_array();
                }
                return null;
            }
            else{
                $query = $this->db->select('*')->from('USUARIO_TEMA')->where('id_tema', $id)->get();
                if ($query->num_rows() > 0) {
                    return $query->result_array();
                }

                return null;
            }
        }

        $query = $this->db->select('*')->from('USUARIO_TEMA')->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }

        return null;
    }

    public function save($usuario_tema)
    {
        $this->db->set($this->_setUsuario_tema($usuario_tema))->insert('USUARIO_TEMA');

        if ($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }

        return null;
    }

    public function update($usuario_tema)
    {
        $id = $usuario_tema['id'];

        $this->db->set($this->_setUsuario_tema($usuario_tema))->where('id_usuario', $id)->update('USUARIO_TEMA');

        if ($this->db->affected_rows() === 1) {
            return true;
        }

        return null;
    }

    public function delete($id)
    {
        $this->db->where('id_usuario', $id)->delete('USUARIO_TEMA');

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
    
    private function _setUsuario_tema($usuario_tema)
    {
        return array(
            'id_usuario' => $usuario_tema['id_usuario'],
            'id_tema' => $usuario_tema['id_tema']
        );
    }
}