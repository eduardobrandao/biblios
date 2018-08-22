<?php

namespace biblios;

//Class para gerenciar $_GET url

class System{

    private $_url;
    private $_controller;
    private $_acao;

    public function __construct(){
        
        $this->setUrl($_GET);
        $this->setController();
        $this->setAcao();
    }

    public function setUrl($url){
        $this->_url = $url;
    }
    public function getUrl(){
        return $this->_url;
    }
    public function setController(){
        $this->_controller = empty($this->_url["controller"]) ? "index" : $this->_url["controller"]; 
    }
    public function getController(){
        return $this->_controller;
    }
    public function setAcao(){
        $this->_acao = empty($this->_url["acao"]) ? "index" : $this->_url["acao"];
    }
    public function getAcao(){
        return $this->_acao;
    }

    public function run(){
        $controller = "App\\Controllers\\".$this->_controller;
        $acao = $this->_acao;
        $instacia = new $controller;
        $instacia->$acao();
    }


}