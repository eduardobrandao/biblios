<?php
//Classe responsavel pelo Template padrão
namespace App\Controllers\BaseController;

use biblios\Http\Controller as ControllerPai;

class MasterController extends ControllerPai{

    public function __loadVars( $request, $response, $app){
        parent::__loadVars( $request, $response, $app);

        $this->service->layout(VIEWS.'/Template/template.phtml');

    }
}