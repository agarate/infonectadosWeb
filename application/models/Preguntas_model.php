<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Preguntas_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get($id = null)
    {
        if (!is_null($id)) {
            $query = $this->db->select('*')->from('PREGUNTAS')->where('id_pregunta', $id)->get();
            if ($query->num_rows() === 1) {
                return $query->row_array();
            }

            return null;
        }

        $query = $this->db->select('*')->from('PREGUNTAS')->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }

        return null;
    }

    public function save($pregunta)
    {
        $this->db->set($this->_setPregunta($pregunta))->insert('PREGUNTAS');

        if ($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }

        return null;
    }

    public function update($pregunta)
    {
        $id = $pregunta['id_pregunta'];

        $this->db->set($this->_setPregunta($pregunta))->where('id_pregunta', $id)->update('PREGUNTAS');

        if ($this->db->affected_rows() === 1) {
            return true;
        }

        return null;
    }

    public function delete($id)
    {
        $this->db->where('id_pregunta', $id)->delete('PREGUNTAS');

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

    private function _setPregunta($pregunta)
    {
        return array(
            'id_usuario' => $pregunta['id_usuario'],
            'enunciado' => $pregunta['enunciado'],
            'importancia' => $pregunta['importancia'],
            'tema' => $pregunta['tema'],
            'respuesta' => $pregunta['respuesta'],
            'votos' => $pregunta['votos']
        );
    }
}