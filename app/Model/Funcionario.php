<?php

namespace App\Model;
use biblios\Http\Model as ModelBase;

class Funcionario extends ModelBase {
    protected $table = 'tblfuncionario';
    protected $primaryKey = 'idfuncionario';
    
    //CONSTATANTES
    const SECRETARIO = 1;
    const ADVOGADO = 2;
    const ESTAGIARIO = 2;
}