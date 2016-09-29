<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . '/libraries/REST_Controller.php';


class Tokens extends REST_Controller
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
        $this->load->model('tokens_model');
        
    }

    //Obtiene todos los tokens desde la base de datos
    public function index_get()
    {

        $headers = apache_request_headers();
        $token = '00e84c40ad7782afbc261ac068016a54';
        
        if(isset($headers["Authorization"])){
            if($headers["Authorization"]== $token){
                $tokens = $this->tokens_model->get();

                if (!is_null($tokens)) {
                    $this->response(array('response' => $tokens), 200);
                } else {
                    $this->response(array('error' => 'No hay tokens en la base de datos...'), 404);
                }
            }else{
                $this->response(array('response' => 'Authorization Required'), 401);
            }
        }
    }

    //Muestra el token buscado segun id de la base de datos
    public function find_get($id)
    {
        $headers = apache_request_headers();
        $token = '00e84c40ad7782afbc261ac068016a54';

        if(isset($headers["Authorization"])){
            if($headers["Authorization"]== $token){
                if (!$id) {
                    $this->response(null, 400);
                }
                $tokens = $this->tokens_model->get($id);

                if (!is_null($tokens)) {
                    $this->response(array('response' => $tokens), 200);
                } else {
                    $this->response(array('response' => $tokens), 404);
                }
            }else{
            $this->response(array('response' => 'Authorization Required'), 401);
            }
        }
    }

    //Inserta un token a la base de datos
    public function index_post()
    {
        $headers = apache_request_headers();
        $token = '00e84c40ad7782afbc261ac068016a54';

        if(isset($headers["Authorization"])){
            if($headers["Authorization"]== $token){
                if (!$this->post('token')) {
                    $this->response(null, 400);
                }

                $id = $this->tokens_model->save($this->post('token'));

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

    //Actualiza un token segun id de la base de datos desde la base de datos
    public function index_put()
    {
        $headers = apache_request_headers();
        $token = '00e84c40ad7782afbc261ac068016a54';

        if(isset($headers["Authorization"])){
            if($headers["Authorization"]== $token){
                if (!$this->put('token')) {
                    $this->response(null, 400);
                }

                $update = $this->tokens_model->update($this->put('token'));

                if (!is_null($update)) {
                    $this->response(array('response' => 'token actualizado!'), 200);
                } else {
                    $this->response(array('error', 'Algo se ha roto en el servidor...'), 400);
                }
            }else{
                $this->response(array('response' => 'Authorization Required'), 401);
            }
        }
    }

    //Elimina un token de la base de datos
    public function index_delete($id)
    {
        $headers = apache_request_headers();
        $token = '00e84c40ad7782afbc261ac068016a54';

        if(isset($headers["Authorization"])){
            if($headers["Authorization"]== $token){
                if (!$id) {
                    $this->response(null, 400);
                }

                $delete = $this->tokens_model->delete($id);

                if (!is_null($delete)) {
                    $this->response(array('response' => 'token eliminado!'), 200);
                } else {
                    $this->response(array('error', 'Algo se ha roto en el servidor...'), 400);
                }
            }else{
                $this->response(array('response' => 'Authorization Required'), 401);
            }
        }
    }
}
