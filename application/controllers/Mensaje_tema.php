<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . '/libraries/REST_Controller.php';


class Mensaje_tema extends REST_Controller
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
        $this->load->model('mensaje_tema_model');
    }

    //Obtiene todos los mensaje_tema desde la base de datos
    public function index_get()
    {
        $headers = apache_request_headers();

        if(isset($headers["Authorization"])){
            $token=$this->mensaje_tema_model->obtener_token($headers["Authorization"]);
            if($headers["Authorization"]== $token['TOKEN']){
                $mensaje_tema = $this->mensaje_tema_model->get();

                if (!is_null($mensaje_tema)) {
                    $this->response(array('response' => $mensaje_tema), 200);
                } else {
                    $this->response(array('error' => 'No hay mensaje_tema en la base de datos...'), 404);
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
            $token=$this->mensaje_tema_model->obtener_token($headers["Authorization"]);
            if($headers["Authorization"]== $token['TOKEN']){
                if (!$id) {
                    $this->response(null, 400);
                }
                $mensaje_tema_id = $this->mensaje_tema_model->get($id);

                if (!is_null($mensaje_tema_id)) {
                    $this->response(array('response' => $mensaje_tema_id), 200);
                } else {
                    $this->response(array('error' => 'Mensaje no encontrado...'), 404);
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
            $token=$this->mensaje_tema_model->obtener_token($headers["Authorization"]);
            if($headers["Authorization"]== $token['TOKEN']){
                if (!$this->post('mensaje_tema')) {
                    $this->response(null, 400);
                }

                $id = $this->mensaje_tema_model->save($this->post('mensaje_tema'));

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
            $token=$this->mensaje_tema_model->obtener_token($headers["Authorization"]);
            if($headers["Authorization"]== $token['TOKEN']){
                if (!$this->put('mensaje_tema')) {
                    $this->response(null, 400);
                }

                $update = $this->mensaje_tema_model->update($this->put('mensaje_tema'));

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
            $token=$this->mensaje_tema_model->obtener_token($headers["Authorization"]);
            if($headers["Authorization"]== $token['TOKEN']){
                if (!$id) {
                    $this->response(null, 400);
                }

                $delete = $this->mensaje_tema_model->delete($id);

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
