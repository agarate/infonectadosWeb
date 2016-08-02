<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . '/libraries/REST_Controller.php';


class Preguntas_voto extends REST_Controller
{
    public function __construct()
    {
  
        parent::__construct();
        $this->load->model('preguntas_voto_model');
    }

    //Obtiene todos los preguntas_voto desde la base de datos
    public function index_get()
    {
        $headers = apache_request_headers();

        if(isset($headers["Authorization"])){
            $token=$this->preguntas_voto_model->obtener_token($headers["Authorization"]);
            if($headers["Authorization"]== $token['TOKEN']){
                $preguntas_voto = $this->preguntas_voto_model->get();

                if (!is_null($preguntas_voto)) {
                    $this->response(array('response' => $preguntas_voto), 200);
                } else {
                    $this->response(array('error' => 'No hay preguntas_voto en la base de datos...'), 404);
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
            $token=$this->preguntas_voto_model->obtener_token($headers["Authorization"]);
            if($headers["Authorization"]== $token['TOKEN']){
                if (!$id) {
                    $this->response(null, 400);
                }
                $preguntas_voto_id = $this->preguntas_voto_model->get($id);

                if (!is_null($preguntas_voto_id)) {
                    $this->response(array('response' => $preguntas_voto_id), 200);
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
            $token=$this->preguntas_voto_model->obtener_token($headers["Authorization"]);
            if($headers["Authorization"]== $token['TOKEN']){
                if (!$this->post('preguntas_voto')) {
                    $this->response(null, 400);
                }

                $id = $this->preguntas_voto_model->save($this->post('preguntas_voto'));

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
            $token=$this->preguntas_voto_model->obtener_token($headers["Authorization"]);
            if($headers["Authorization"]== $token['TOKEN']){
                if (!$this->put('preguntas_voto')) {
                    $this->response(null, 400);
                }

                $update = $this->preguntas_voto_model->update($this->put('preguntas_voto'));

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
            $token=$this->preguntas_voto_model->obtener_token($headers["Authorization"]);
            if($headers["Authorization"]== $token['TOKEN']){
                if (!$id) {
                    $this->response(null, 400);
                }

                $delete = $this->preguntas_voto_model->delete($id);

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