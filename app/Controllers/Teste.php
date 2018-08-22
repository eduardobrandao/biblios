<?php

namespace App\Controllers;
use biblios\Http\Controller as ControllerPai;

class Teste Extends ControllerPai{

    public function teste(){
        $this->service->render('login.phtml');
    }
}