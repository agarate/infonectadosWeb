<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . '/libraries/REST_Controller.php';


class Preguntas extends REST_Controller
{
    public function __construct()
    {

        parent::__construct();
        $this->load->model('preguntas_model');
    }

    //Obtiene todos los preguntas desde la base de datos
    public function index_get()
    {
        $headers = apache_request_headers();

        if(isset($headers["Authorization"])){
            $token=$this->preguntas_model->obtener_token($headers["Authorization"]);
            if($headers["Authorization"]== $token['TOKEN']){
                $preguntas = $this->preguntas_model->get();

                if (!is_null($preguntas)) {
                    $this->response(array('response' => $preguntas), 200);
                } else {
                    $this->response(array('error' => 'No hay preguntas en la base de datos...'), 404);
                }
            }else{
                $this->response(array('response' => 'Authorization Required'), 401);
            }
        }
    }

    //Muestra el pregunta buscado segun id de la base de datos
    public function find_get($id)
    {
        $headers = apache_request_headers();

        if(isset($headers["Authorization"])){
            $token=$this->preguntas_model->obtener_token($headers["Authorization"]);
            if($headers["Authorization"]== $token['TOKEN']){
                if (!$id) {
                    $this->response(null, 400);
                }
                $pregunta = $this->preguntas_model->get($id);

                if (!is_null($pregunta)) {
                    $this->response(array('response' => $pregunta), 200);
                } else {
                    $this->response(array('error' => 'pregunta no encontrado...'), 404);
                }
            }else{
                $this->response(array('response' => 'Authorization Required'), 401);
            }
        }
    }

    //Inserta un pregunta a la base de datos
    public function index_post()
    {
        $headers = apache_request_headers();

        if(isset($headers["Authorization"])){
            $token=$this->preguntas_model->obtener_token($headers["Authorization"]);
            if($headers["Authorization"]== $token['TOKEN']){
                if (!$this->post('pregunta')) {
                    $this->response(null, 400);
                }

                $id = $this->preguntas_model->save($this->post('pregunta'));

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

    //Actualiza un pregunta segun id de la base de datos desde la base de datos
    public function index_put()
    {
        $headers = apache_request_headers();

        if(isset($headers["Authorization"])){
            $token=$this->preguntas_model->obtener_token($headers["Authorization"]);
            if($headers["Authorization"]== $token['TOKEN']){
                if (!$this->put('pregunta')) {
                    $this->response(null, 400);
                }

                $update = $this->preguntas_model->update($this->put('pregunta'));

                if (!is_null($update)) {
                    $this->response(array('response' => 'pregunta actualizada!'), 200);
                } else {
                    $this->response(array('error', 'Algo se ha roto en el servidor...'), 400);
                }
            }else{
                $this->response(array('response' => 'Authorization Required'), 401);
            }
        }
    }

    //Elimina un pregunta de la base de datos
    public function index_delete($id)
    {
        $headers = apache_request_headers();

        if(isset($headers["Authorization"])){
            $token=$this->preguntas_model->obtener_token($headers["Authorization"]);
            if($headers["Authorization"]== $token['TOKEN']){
                if (!$id) {
                    $this->response(null, 400);
                }

                $delete = $this->preguntas_model->delete($id);

                if (!is_null($delete)) {
                    $this->response(array('response' => 'pregunta eliminado!'), 200);
                } else {
                    $this->response(array('error', 'Algo se ha roto en el servidor...'), 400);
                }
            }else{
                $this->response(array('response' => 'Authorization Required'), 401);
            }
        }
    }
}