<?php

namespace App\Controllers;
// use biblios\Http\Controller as ControllerPai;
use Klein\Response;
use App\Controllers\BaseController\MasterController as Controller;
use App\Model\ExemplarArea;
use App\Model\Exemplar;

class Livro extends Controller{

    public function lista()
    {   
        isset($_GET['pesquisa']) ? $pesquisa = $_GET['pesquisa'] : $pesquisa = false;
        isset($_GET['filtro']) ? $filtro = $_GET['filtro'] : $filtro = false;

        session_start();
        $livros = new Exemplar();
        $livros = $livros->groupByISBN( false, $filtro, $pesquisa);
        return $this->service->render('Livro/acervo.phtml',['livros' => $livros]);
    }

    public function form(){
        $this->autenticarSecretaria();        
        $areas = new ExemplarArea();
        $areas = $areas->all();
        $isbn = $this->request->isbn ? $this->request->isbn : false ;
        
        if($isbn){
            $livro = new Exemplar();
            $livro = $livro->where('strisbn',$isbn);
            $livro = $livro[0];
        }else{
            $livro = array();
        }
        
        return $this->service->render('Livro/formLivro.phtml',['areas' => $areas, 'livro' => $livro]);
    }


    public function save()
    {   
        $this->autenticarSecretaria();        
        $isbn = $_POST['strisbn'];
        $quantidade = $_POST['quantidade'];
        $info = array(
            'strnomeexemplar' => $_POST['titulo'],
            'streditora' => $_POST['editora'],
            'idexemplararea' => $_POST['area'],
            'strautor' => $_POST['autor'],
            'strpreco' => $_POST['preco'],
            'dtaano' => $_POST['ano'],
            'strisbn' => $_POST['strisbn'],
            'boldisponivel' => Exemplar::DISPONIVEL,
        );
        // var_dump($info);
        #### DEPOIS NÃO ESQUECER DE ADICIONAR MAIS UMA CAMADA DE PROTEÇÃO
        if(!$quantidade){
            $exemplar = new Exemplar();
            $update = $exemplar->update($info, $isbn, 'strisbn');
            if(!$update) return "Não foi possivel editar";
            return $this->response->redirect(url('/acervo'))->send();  

        }else{
            for($i = 0; $i < $quantidade; $i++){
                $exemplar = new Exemplar();            
                $salvar = $exemplar->save($info);
                if(!$salvar) return 'Desculpe não foi possivel salvar!';
            }
            // $salvar = true;
        }        
        if(!$salvar) return 'Nãoi possivel Cadastrar' ;            
        return $this->response->redirect(url('/acervo'))->send();
    }

    public function excluir(){
        $this->autenticarSecretaria();
        $this->autenticarSecretaria();

        $id = $this->request->isbn ? $this->request->isbn : false ;
        $exemplar =  new Exemplar();
        if($exemplar->delete($id, 'strisbn')){
            return $this->response->redirect(url('/acervo'))->send();
        }else{
            return 'Não foi possivel excluir';
        }
    }

}