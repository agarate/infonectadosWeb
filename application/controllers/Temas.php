<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . '/libraries/REST_Controller.php';


class Temas extends REST_Controller
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
        $this->load->model('temas_model');
    }

    //Obtiene todos los temas desde la base de datos
    public function index_get()
    {
        $headers = apache_request_headers();

        if(isset($headers["Authorization"])){
            $token=$this->temas_model->obtener_token($headers["Authorization"]);
            if($headers["Authorization"]== $token['TOKEN']){

                $temas = $this->temas_model->get();

                if (!is_null($temas)) {
                    $this->response(array('response' => $temas), 200);
                } else {
                    $this->response(array('error' => 'No hay temas en la base de datos...'), 404);
                }
            }else{
                $this->response(array('response' => 'Authorization Required'), 401);

            }
        }
    }

    //Muestra el tema buscado segun id de la base de datos
    public function find_get($id)
    {
        $headers = apache_request_headers();
        
        if(isset($headers["Authorization"])){
            $token=$this->temas_model->obtener_token($headers["Authorization"]);
            if($headers["Authorization"]== $token['TOKEN']){
                if (!$id) {
                    $this->response(null, 400);
                }
                $tema = $this->temas_model->get($id);

                if (!is_null($tema)) {
                    $this->response(array('response' => $tema), 200);
                } else {
                    $this->response(array('error' => 'tema no encontrado...'), 404);
                }
            }else{
                $this->response(array('response' => 'Authorization Required'), 401);

            }
        }
    }

    //Inserta un tema a la base de datos
    public function index_post()
    {
        $headers = apache_request_headers();
        
        if(isset($headers["Authorization"])){
            $token=$this->temas_model->obtener_token($headers["Authorization"]);
            if($headers["Authorization"]== $token['TOKEN']){
                if (!$this->post('tema')) {
                    $this->response(null, 400);
                }

                $id = $this->temas_model->save($this->post('tema'));

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

    //Actualiza un tema segun id de la base de datos desde la base de datos
    public function index_put()
    {
        $headers = apache_request_headers();
        
        if(isset($headers["Authorization"])){
            $token=$this->temas_model->obtener_token($headers["Authorization"]);
            if($headers["Authorization"]== $token['TOKEN']){
                if (!$this->put('tema')) {
                    $this->response(null, 400);
                }

                $update = $this->temas_model->update($this->put('tema'));

                if (!is_null($update)) {
                    $this->response(array('response' => $update), 200);
                } else {
                    $this->response(array('error'=> $update), 400);
                }
            }else{
                $this->response(array('response' => 'Authorization Required'), 401);

            }
        }
    }

    //Elimina un tema de la base de datos
    public function index_delete($id)
    {
        $headers = apache_request_headers();
        
        if(isset($headers["Authorization"])){
            $token=$this->temas_model->obtener_token($headers["Authorization"]);
            if($headers["Authorization"]== $token['TOKEN']){
                if (!$id) {
                    $this->response(null, 400);
                }

                $delete = $this->temas_model->delete($id);

                if (!is_null($delete)) {
                    $this->response(array('response' => 'tema eliminado!'), 200);
                } else {
                    $this->response(array('error', 'Algo se ha roto en el servidor...'), 400);
                }
            }else{
                $this->response(array('response' => 'Authorization Required'), 401);

            }
        }
    }
}
