<?php

namespace App\Controllers;
use biblios\Http\Controller as ControllerPai;
use App\Model\FuncionarioTipo;

class Controller extends ControllerPai{

    public function index(){
        return $this->response->redirect(url('/acervo'))->send();
    }

    public function teste(){
        $teste = new FuncionarioTipo();
        $inserir_values = array('strnometipo' => 'advogado');
        $ver = $teste->save($inserir_values);
        if($ver){
            return 'este é um teste';
        }else{
            return 'lascou'.$ver;
        }
    }
}