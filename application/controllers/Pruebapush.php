<?php

class Pruebapush extends CI_Controller {
/*	
public function __construct() {

        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        $method = $_SERVER['REQUEST_METHOD'];
        if($method == "OPTIONS") {
            die();
        }
        parent::__construct();
    }*/
	public function index()
	{
        $json = file_get_contents('php://input');
        if($json){

            $datos = json_decode($json, true);
            $ids = $datos['data']['ids'];
            $title = $datos['data']['mensaje']['title'];
            $message = $datos['data']['mensaje']['message'];
    		$data=['title'=>$title, 'message' => $message];

        	$apiKey= 'AIzaSyDQClttn7mOUCG_5Q_HqEHral_6JGu7WVs';

        	//Armo el mensaje

            //Indico los id y los datos del mensaje
            $fields = array(
                'registration_ids'  => $ids,
                'data'          => $data
            );
             
            //Header de la petición post
            $headers = array(
                'Authorization: key=' . $apiKey,
                'Content-Type: application/json'
            );
             
            //Armo el curl y envio el mensaje
            $ch = curl_init();
            curl_setopt( $ch,CURLOPT_URL, 'http://gcm-http.googleapis.com/gcm/send' );
            curl_setopt( $ch,CURLOPT_POST, true );
            curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
            curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
            curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
            curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
            $result = curl_exec($ch );
            curl_close( $ch );
            echo $result;
            
    	}
    }
}
