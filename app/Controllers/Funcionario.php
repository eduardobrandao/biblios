<?php

namespace App\Controllers;

// use biblios\Http\Controller as ControllerPai;
use Klein\Response;
use App\Controllers\BaseController\MasterController as Controller;
use App\Model\Funcionario as FuncionarioModel;
use App\Model\FuncionarioTipo;
// use App\Model\ExemplarArea;
// use App\Model\Exemplar;

class Funcionario extends Controller{

    public function listar(){
        $this->autenticarSecretaria();        
        $funcionario = new FuncionarioModel();
        #Pegando todos os funcionarios
        $lista = $funcionario->funcionarios();
        
        return $this->service->render('Funcionario/listaFuncionarios.phtml', ['lista' => $lista]);
    }

    public function form(){
        $this->autenticarSecretaria();        
        $funcionarios = new FuncionarioTipo();
        #Pegando os tipos de funcionario
        $tipos = $funcionarios->all();

        $id = $this->request->id ? $this->request->id : false ;
        if($id){
            $funcionario = new FuncionarioModel();
            $funcionario = $funcionario->find($id);
        }else{
            $funcionario = array();
        }

        return $this->service->render('Funcionario/formFuncionario.phtml', ['funcionario' => $funcionario ,'tipos'=> $tipos]);
    }

    public function save(){
        $this->autenticarSecretaria();        
        $id = $_POST['id'];
        $info = array(
            'strnomefuncionario' => $_POST['strnomefuncionario'],
            'strcpf' => preg_replace( '#[^0-9]#', '', $_POST['strcpf'] ),
            'dtanascimento' => $_POST['dtanascimento'],
            'stroab' => $_POST['stroab'],
            'strtelefone' => $_POST['strtelefone'],
            'idfuncionariotipo' => $_POST['idfuncionariotipo']
        );
        $funcionario = new FuncionarioModel();
        #### DEPOIS NÃO ESQUECER DE ADICIONAR MAIS UMA CAMADA DE PROTEÇÃO
        if($id){
            $salvar = $funcionario->update($info, $id);
        }else{
            $salvar = $funcionario->save($info);
        }        

        if($salvar){
            return $this->response->redirect(url('/funcionario'))->send();  
        }else{
            return 'Tente Novamente' ;
        }
    }

    public function excluir(){
        $this->autenticarSecretaria();        
        $id = $this->request->id ? $this->request->id : false ;
        $funcionario =  new FuncionarioModel();
        if($funcionario->delete($id)){
            return $this->response->redirect(url('/funcionario'))->send();
        }else{
            return 'Não foi possivel excluir';
        }
    }

}