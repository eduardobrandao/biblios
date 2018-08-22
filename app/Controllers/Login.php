<?php

namespace App\Controllers;
use biblios\Http\Controller as ControllerPai;
use App\Model\Funcionario;

class Login extends ControllerPai{

    public function index(){
        return $this->service->render('login.phtml');
    }

    public function entrar(){
        $cpf = preg_replace( '#[^0-9]#', '', $_POST['strcpf'] ); 
        $funcionario = new Funcionario();
        $funcionario = $funcionario->where('strcpf', $cpf);
        
        if(!$funcionario){
            return $this->response->redirect(url('/login'))->send();            
        }else{
            session_start();
            $_SESSION['user'] = $funcionario[0]['strnomefuncionario'];
            $_SESSION['cpf'] = $funcionario[0]['strcpf'];
            $_SESSION['perfil'] = $funcionario[0]['idfuncionariotipo'];
            $_SESSION['id'] = $funcionario[0]['idfuncionario'];
            return $this->response->redirect(url('/'))->send();                        
        }
    }

    public function sair(){
        session_start();
        unset($_SESSION['user']);
        unset($_SESSION['cpf']);
        unset($_SESSION['perfil']);
        return $this->response->redirect(url('/login'))->send();                        
    }
}