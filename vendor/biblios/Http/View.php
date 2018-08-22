<?php

namespace biblios\Http;
use Klein\ServiceProvider;

class View extends ServiceProvider {

    public function render($view, array $data = array()){
        parent::render('app/Views/'.$view, $data);
    }

    public function var($variavel){
        return $this->sharedData()->get($variavel);
    }
}