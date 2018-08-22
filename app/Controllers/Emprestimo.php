<?php

namespace App\Controllers;

use App\Controllers\BaseController\MasterController;
use App\Model\Exemplar;
use App\Model\Emprestimo as EmprestimoModel;
use App\Model\Funcionario;

class Emprestimo extends MasterController{
    
    const BOLFINALIZADO = 0 ;

    public function listarLivros(){

        $this->autenticarSecretaria();
        $livros = new Exemplar();
        $livros = $livros->groupByISBN(true);

        return $this->service->render('Emprestimo/listaLivros.phtml', ['livros' => $livros]);
    }

    public function formEmprestimo(){
        $this->autenticarSecretaria();        
        $_POST['strisbn'] ? $livros = $_POST['strisbn'] : $livros = false;
        // session_start();
        $_SESSION['livros'] = $livros;

        if($livros){
            return $this->service->render('Emprestimo/formEmprestimo.phtml',['livros' => $livros]);              
        }
        
        return "Volte e selecione algum livro";
    }

    public function emprestar(){
        $this->autenticarSecretaria();        
        session_start();
        $_POST['strcpf'] ? $cpf = $_POST['strcpf'] : $cpf = false;
        
        if(!$cpf) return 'Informe CPF';

        $funcionario = new Funcionario();
        $funcionario = $funcionario->where('strcpf', $cpf);
        $idfuncionario = intval($funcionario[0]['idfuncionario']);
        if(!$idfuncionario) return "Desculpe este funcionario não existe";

        $livros = $_SESSION['livros'];
        $exemplar = new Exemplar();        
        $livroDisponiveis = $exemplar->VerificaDisponibilidadeLivro($livros);
        
        if(empty($livroDisponiveis)) return 'Não temos livro disponivel';

        $emprestimo = new EmprestimoModel();
        $info = array(
            'idfuncionario' => $idfuncionario,
            'dtaemprestimo' => date('Y-m-d'),
            'dtadevolucao' => date('Y-m-d', strtotime("+4 days",strtotime(date('Y-m-d')))),
            'bolfinalizado' => EmprestimoModel::NAOFINALIZADO 
        );
        $id = $emprestimo->save($info);
        if($id){
            $emprestimo = new EmprestimoModel();
            $emprestimo = $emprestimo->find($id);
            foreach ($livroDisponiveis as $livro) {
                $exemplar = new Exemplar();
                $exemplar = $exemplar->find($livro);
                //print_r($exemplar);
                $info = array(
                    'idemprestimo' => $id,
                    'boldisponivel'   => Exemplar::NAODISPONIVEL
                );
                $livroEmprestimo = new Exemplar();
                $livroEmprestimo = $livroEmprestimo->update($info, $livro);
                if(!$livroEmprestimo){
                    return 'Deu merda';
                }
            }
            return $this->response->redirect(url('/emprestimo'))->send();
        }else {
            return "Desculpe mais o codigo não funcionou";
        }
        
    }


    public function listarEmprestimos(){
        $this->autenticarSecretaria();        
        $emprestimos = new EmprestimoModel();
        $emprestimos = $emprestimos->emprestimosAtivos();

        return $this->service->render('Emprestimo/listaEmprestimo.phtml',
        ['emprestimos' => $emprestimos]);              
    }

    public function devolver(){
        $this->autenticarSecretaria();
        $id = $this->request->emprestimoid ? $this->request->emprestimoid : false ;
        $livroObj = new Exemplar();
        $livros   = $livroObj->where('idemprestimo',$id);
        
        foreach($livros as $livro){
            $livroObj = new Exemplar();            
            $update = $livroObj->update(['boldisponivel' => Exemplar::DISPONIVEL], $livro['idexemplar'], false);
            // print_r($update);
            if(!$update) return "Não foi possivel finalizar o emprestimo";
        }
        $emprestimoObj = new EmprestimoModel();
        // $emprestimoFinalizado = $emprestimoObj->find($id);
        // $emprestimoFinalizado['bolfinzalizado'] = EmprestimoModel::FINALIZADO;
        $finzalizado =  $emprestimoObj->update(['bolfinalizado' => EmprestimoModel::FINALIZADO], $id);
        
        if(!$finzalizado) {
            return "Livros devolvidos ao acervo, mas o emprestimo não foi finalizado!";
        }
        
        return $this->response->redirect(url('/emprestimo/lista'))->send();        
    }

    public function visualizar(){
        $this->autenticar();
        $id = $this->request->emprestimoid ? $this->request->emprestimoid : false ;                
        $emprestimos = new EmprestimoModel();
        $emprestimos = $emprestimos->emprestimosAtivos($id);
        $livros = new Exemplar();
        $livros = $livros->where('idemprestimo', $id);
        // print_r($emprestimos);
        return $this->service->render('Emprestimo/visualizar.phtml',
        ['emprestimo' => $emprestimos[0], 'livros' => $livros]);              
    }


    public function meusEmprestimos(){
        $this->autenticar();
        // session_start();
        $emprestimoObj = new EmprestimoModel();
        $emprestimos   = $emprestimoObj->funcionarioEmprestimo($_SESSION['id']);
        return $this->service->render('Emprestimo/usuarioEmprestimo.phtml',
        ['emprestimos' => $emprestimos]);
    }

}