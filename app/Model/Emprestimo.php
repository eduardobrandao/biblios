<?php

namespace App\Model;

use biblios\Http\Model as ModelBase;
use biblios\Http\Exemplar;

class Emprestimo extends ModelBase {
    protected $table = 'tblemprestimo';
    protected $primaryKey = 'idemprestimo';

    const NAOFINALIZADO = 0 ;
    const FINALIZADO = 1 ;
    
    public function livrosEmprestados($livros = array(),$idemprestimo){
        foreach($livros as $livro){
            $exemplar = new Exemplar();
            $exemplar = $exemplar->find($livro);
            $info = array(
                'idemprestimo' => $idemprestimo
            );
            $exemplar = $exemplar->update($info, $livro);

            if(!$xemeplar){
                return 'Deu merda';
            }
        }

        return true;
    }

}

