<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . '/libraries/REST_Controller.php';


class Usuario_tema extends REST_Controller
{
    public function __construct()
    {
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        $method = $_SERVER['REQUEST_METHOD'];
        if($method == "OPTIONS") {
            die();
        }
        parent::__construct();
        $this->load->model('usuario_tema_model');
    }

    //Obtiene todos los usuario_tema desde la base de datos
    public function index_get()
    {
        $headers = apache_request_headers();

        if(isset($headers["Authorization"])){
            $token=$this->usuario_tema_model->obtener_token($headers["Authorization"]);
            if($headers["Authorization"]== $token['TOKEN']){

                $usuario_tema = $this->usuario_tema_model->get();

                if (!is_null($usuario_tema)) {
                    $this->response(array('response' => $usuario_tema), 200);
                } else {
                    $this->response(array('error' => 'No hay usuario_tema en la base de datos...'), 404);
                }
            }else{
                $this->response(array('response' => 'Authorization Required'), 401);
            }
        }
    }

    //Muestra el mensaje buscado segun id de la base de datos
    public function find_get($id)
    {
        $headers = apache_request_headers();

        if(isset($headers["Authorization"])){
            $token=$this->usuario_tema_model->obtener_token($headers["Authorization"]);
            if($headers["Authorization"]== $token['TOKEN']){

                if (!$id) {
                    $this->response(null, 400);
                }
                $usuario_tema_id = $this->usuario_tema_model->get($id);

                if (!is_null($usuario_tema_id)) {
                    $this->response(array('response' => $usuario_tema_id), 200);
                } else {
                    $this->response(array('error' => 'Tema no encontrado...'), 404);
                }
            }else{
                $this->response(array('response' => 'Authorization Required'), 401);

            }
        }
    }

    //Inserta un mensaje a la base de datos
    public function index_post()
    {
        $headers = apache_request_headers();

        if(isset($headers["Authorization"])){
            $token=$this->usuario_tema_model->obtener_token($headers["Authorization"]);
            if($headers["Authorization"]== $token['TOKEN']){
                if (!$this->post('usuario_tema')) {
                    $this->response(null, 400);
                }

                $id = $this->usuario_tema_model->save($this->post('usuario_tema'));

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

    //Actualiza un mensaje segun id de la base de datos desde la base de datos
    public function index_put()
    {
        $headers = apache_request_headers();

        if(isset($headers["Authorization"])){
            $token=$this->usuario_tema_model->obtener_token($headers["Authorization"]);
            if($headers["Authorization"]== $token['TOKEN']){
                if (!$this->put('usuario_tema')) {
                    $this->response(null, 400);
                }

                $update = $this->usuario_tema_model->update($this->put('usuario_tema'));

                if (!is_null($update)) {
                    $this->response(array('response' => 'Mensaje actualizada!'), 200);
                } else {
                    $this->response(array('error', 'Algo se ha roto en el servidor...'), 400);
                }
            }else{
                $this->response(array('response' => 'Authorization Required'), 401);

            }
        }
    }

    //Elimina un mensaje de la base de datos
    public function index_delete($id)
    {
        $headers = apache_request_headers();

        if(isset($headers["Authorization"])){
            $token=$this->usuario_tema_model->obtener_token($headers["Authorization"]);
            if($headers["Authorization"]== $token['TOKEN']){
                if (!$id) {
                    $this->response(null, 400);
                }

                $delete = $this->usuario_tema_model->delete($id);

                if (!is_null($delete)) {
                    $this->response(array('response' => 'Mensaje eliminado!'), 200);
                } else {
                    $this->response(array('error', 'Algo se ha roto en el servidor...'), 400);
                }
            }else{
                $this->response(array('response' => 'Authorization Required'), 401);

            }
        }
    }
}
