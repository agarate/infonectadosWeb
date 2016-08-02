<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TOKENS_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get($id = null)
    {
        if (!is_null($id)) {
            $query = $this->db->select('*')->from('TOKENS')->where('token', $id)->get();
            if ($query->num_rows() === 1) {
                return $query->row_array();
            }

            return null;
        }
        $query = $this->db->select('*')->from('TOKENS')->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }

        return null;
    }

    public function save($token)
    {
        $this->db->set($this->_setToken($token))->insert('TOKENS');

        if ($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }

        return null;
    }

    public function update($token)
    {
        $id = $token['id'];

        $this->db->set($this->_setToken($token))->where('token', $id)->update('TOKENS');

        if ($this->db->affected_rows() === 1) {
            return true;
        }

        return null;
    }

    public function delete($id)
    {
        $this->db->where('token', $id)->delete('TOKENS');

        if ($this->db->affected_rows() === 1) {
            return true;
        }

        return null;
    }

    private function _setToken($token)
    {
        return array(
            'id_usuario' => $token['id_usuario'],
            'token' => $token['token']
        );
    }
}