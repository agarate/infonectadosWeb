<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get($id = null)
    {

        if (!is_null($id)) {
            if($id=="admin"){
                $this->db->select('*')->from('USUARIOS')->where('tipo', $id);
                $query = $this->db->get();
                if ($query->num_rows()>0) {
                    return $query->result_array();
                }

            return null;
            }else if(strpos($id, '-') !== false){
                trim($id, '-');
                $query = $this->db->select('TIPO')->from('USUARIOS')->where('id_usuario', $id)->get();
                if ($query->num_rows() === 1) {
                    return $query->row_array();
                }

                return null;

            }else if(strpos($id, '_') !== false){
                trim($id, '_');
                $query = $this->db->select('*')->from('USUARIOS')->where('id_usuario', $id)->get();
                if ($query->num_rows() === 1) {
                    return $query->row_array();
                }

                return null;

            }else if($id=="congcm"){
                $this->db->select('ID_USUARIO,GCM_REGID')->from('USUARIOS');
                $this->db->where('gcm_regid!=','NO');
                $query = $this->db->get();
                if ($query->num_rows() >0) {
                    return $query->result_array();
                }

                return null;

            }else{
                $query = $this->db->select('*')->from('USUARIOS')->where('usuario', $id)->get();
                if ($query->num_rows() === 1) {
                    return $query->row_array();
                }

                return null;
            }
        }

        $query = $this->db->select('*')->from('USUARIOS')->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }

        return null;
    }

    public function save($usuario)
    {
        $this->db->set($this->_setUsuario($usuario))->insert('USUARIOS');

        if ($this->db->affected_rows() === 1) {
            $insert_id = $this->db->insert_id();

            return  $insert_id;
        }

        return null;
    }

    public function update($usuario)
    {
        $id = $usuario['id_usuario'];

        $this->db->set($this->_setUsuario($usuario))->where('id_usuario', $id)->update('USUARIOS');

        if ($this->db->affected_rows() === 1) {
            return true;
        }

        return null;
    }

    public function delete($id)
    {
        $this->db->where('id_usuario', $id)->delete('USUARIOS');

        if ($this->db->affected_rows() === 1) {
            return true;
        }

        return null;
    }

    private function _setUsuario($usuario)
    {
        return array(
            'usuario' => $usuario['usuario'],
            'tipo' => $usuario['tipo'],
            'gcm_regid' => $usuario['gcm_regid']
        );
    }
}