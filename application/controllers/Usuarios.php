<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . '/libraries/REST_Controller.php';


class Usuarios extends REST_Controller
{
    public function __construct()
    {

        parent::__construct();
        $this->load->model('usuarios_model');
        
    }

    //Obtiene todos los usuarios desde la base de datos
    public function index_get()
    {

        $headers = apache_request_headers();
        $token = '00e84c40ad7782afbc261ac068016a54';
        
        if(isset($headers["Authorization"])){
            if($headers["Authorization"]== $token){
                $usuarios = $this->usuarios_model->get();

                if (!is_null($usuarios)) {
                    $this->response(array('response' => $usuarios), 200);
                } else {
                    $this->response(array('error' => 'No hay usuarios en la base de datos...'), 404);
                }
            }else{
                $this->response(array('response' => 'Authorization Required'), 401);
            }
        }
    }

    //Muestra el usuario buscado segun id de la base de datos
    public function find_get($id)
    {
        $headers = apache_request_headers();
        $token = '00e84c40ad7782afbc261ac068016a54';

        if(isset($headers["Authorization"])){
            if($headers["Authorization"]== $token){
                if (!$id) {
                    $this->response(null, 400);
                }
                $usuario = $this->usuarios_model->get($id);

                if (!is_null($usuario)) {
                    $this->response(array('response' => $usuario), 200);
                } else {
                    $this->response(array('response' => $usuario), 404);
                }
            }else{
            $this->response(array('response' => 'Authorization Required'), 401);
            }
        }
    }

    //Inserta un usuario a la base de datos
    public function index_post()
    {
        $headers = apache_request_headers();
        $token = '00e84c40ad7782afbc261ac068016a54';

        if(isset($headers["Authorization"])){
            if($headers["Authorization"]== $token){
                if (!$this->post('usuario')) {
                    $this->response(null, 400);
                }

                $id = $this->usuarios_model->save($this->post('usuario'));

                if (!is_null($id)) {
                    $this->response(array('response' => $id), 200);
                   echo $id;
                } else {
                    $this->response(array('error', 'Algo se ha roto en el servidor...'), 400);
                }
            }else{
                $this->response(array('response' => 'Authorization Required'), 401);
            }
        }
    }

    //Actualiza un usuario segun id de la base de datos desde la base de datos
    public function index_put()
    {
        $headers = apache_request_headers();
        $token = '00e84c40ad7782afbc261ac068016a54';

        if(isset($headers["Authorization"])){
            if($headers["Authorization"]== $token){
                if (!$this->put('usuario')) {
                    $this->response(null, 400);
                }

                $update = $this->usuarios_model->update($this->put('usuario'));

                if (!is_null($update)) {
                    $this->response(array('response' => 'usuario actualizado!'), 200);
                } else {
                    $this->response(array('error', 'Algo se ha roto en el servidor...'), 400);
                }
            }else{
                $this->response(array('response' => 'Authorization Required'), 401);
            }
        }
    }

    //Elimina un usuario de la base de datos
    public function index_delete($id)
    {
        $headers = apache_request_headers();
        $token = '00e84c40ad7782afbc261ac068016a54';

        if(isset($headers["Authorization"])){
            if($headers["Authorization"]== $token){
                if (!$id) {
                    $this->response(null, 400);
                }

                $delete = $this->usuarios_model->delete($id);

                if (!is_null($delete)) {
                    $this->response(array('response' => 'usuario eliminado!'), 200);
                } else {
                    $this->response(array('error', 'Algo se ha roto en el servidor...'), 400);
                }
            }else{
                $this->response(array('response' => 'Authorization Required'), 401);
            }
        }
    }
}