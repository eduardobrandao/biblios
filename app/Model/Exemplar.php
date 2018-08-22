<?php

namespace App\Model;
use biblios\Http\Model as ModelBase;

class Exemplar extends ModelBase {
    protected $table = 'tblexemplar';
    protected $primaryKey = 'idexemplar';

    //CONSTANTES
    const DISPONIVEL = 0;
    const NAODISPONIVEL = 1;

    public function VerificaDisponibilidadeLivro($iSBNs=array()){
        $idsLivros = array();
        foreach($iSBNs as $isbn){

            $objeto = new Exemplar();
            $livros =  $objeto->where('strisbn', $isbn);
            foreach($livros as $livro){
                $obj = new Exemplar();
                $disponivel = $obj->find($livro['idexemplar']);
                if($disponivel['boldisponivel'] == Exemplar::DISPONIVEL){
                    array_push($idsLivros, $disponivel['idexemplar']);
                    break;
                }
            }
        }

        return $idsLivros;
    }
}