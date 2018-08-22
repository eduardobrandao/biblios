<?php

namespace App\Controllers;
// use biblios\Http\Controller as ControllerPai;
use Klein\Response;
use App\Controllers\BaseController\MasterController as Controller;
use App\Model\Exemplar;
use App\Model\Funcionario;
use App\Model\Emprestimo;

class Home extends Controller{

    public function index(){
        $this->autenticarSecretaria();
        $livros = new Exemplar(); $livros = $livros->totalRegistro();
        $funcionarios = new Funcionario(); $funcionarios = $funcionarios->totalRegistro(); 
        $emprestimos = new Emprestimo(); $emprestimos = $emprestimos->totalRegistro(); 
        
        return $this->service->render('Template/home.phtml', [
            'livros' => $livros[0],
            'funcionarios' => $funcionarios[0],
            'emprestimos' => $emprestimos[0] ]);
    }
}