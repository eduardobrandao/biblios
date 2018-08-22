<?php

namespace biblios\Http;

abstract class Controller {

    protected $request;
    protected $response;
    protected $service;
    protected $app;


    public function __loadVars( $request, $response, $app){
        $this->request = $request;
        $this->response = $response;
        $this->service = new View($request, $response);
        $this->app = $app;        
    }

    public function autenticar(){
        session_start();
        if( isset($_SESSION['user']) && isset($_SESSION['cpf']) && isset($_SESSION['perfil'])){
            return true;
        }else{
            return $this->response->redirect(url('/login'))->send();                    
        }
    }

    public function autenticarSecretaria(){
        session_start();
        if(isset($_SESSION['perfil']) && $_SESSION['perfil'] == 1 ){
            return true;
        }else{
            return $this->response->redirect(url('/acervo'))->send();                    
        }
    }
}