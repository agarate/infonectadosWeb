<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mensajes_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get($id = null)
    {
        if (!is_null($id)) {
            $query = $this->db->select('*')->from('MENSAJES')->where('id_mensaje', $id)->get();
            if ($query->num_rows() === 1) {
                return $query->row_array();
            }

            return null;
        }
        $query=$this->db->query("CALL All_mensajes()");
        //$query = $this->db->select('*')->from('MENSAJES')->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }

        return null;
    }

    public function save($mensaje)
    {
        $this->db->set($this->_setMensaje($mensaje))->insert('MENSAJES');

        if ($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }

        return null;
    }

    public function update($mensaje)
    {
        $id = $mensaje['id'];

        $this->db->set($this->_setMensaje($mensaje))->where('id_mensaje', $id)->update('MENSAJES');

        if ($this->db->affected_rows() === 1) {
            return true;
        }

        return null;
    }

    public function delete($id)
    {
        $this->db->where('id_mensaje', $id)->delete('MENSAJES');

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

    private function _setMensaje($mensaje)
    {
        return array(
            'id_usuario' => $mensaje['id_usuario'],
            'titulo' => $mensaje['titulo'],
            'contenido' => $mensaje['contenido']
        );
    }
}