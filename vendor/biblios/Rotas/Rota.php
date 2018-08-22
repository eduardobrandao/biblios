<?php

namespace biblios\Rotas;
use Klein\Klein as RotaBase;

class Rota extends RotaBase{
    
    public function get($rota ='*', $call = null)
    {   
        if(is_string($call)){
            
            //Caminho dos controlles "App\\Controllers\\Controller@acao
            $explode = explode("@",$call);
            $controller = "App\\Controllers\\".$explode[0];
            $acao = $explode[1];
            $this->respond("GET", $rota, function( $request, $response, $service, $app ) use ($controller,$acao){
                $class = new $controller;
                $class->__loadVars( $request, $response,  $app);
                return $class->$acao();                
            });
            
        }else{
            $this->respond("GET",$rota,$call);
            echo "estou aki";
        }        
    }

    public function post($rota ='*', $call = null)
    {
        if(is_string($call)){
            
            //Caminho dos controlles "App\\Controllers\\Controller@acao
            $explode = explode("@",$call);
            $controller = "App\\Controllers\\".$explode[0];
            $acao = $explode[1];
            $this->respond("POST", $rota, function( $request, $response, $service, $app ) use ($controller,$acao){
                $class = new $controller;
                $class->__loadVars( $request, $response,  $app);
                return $class->$acao();                
            });
            
        }else{
            $this->respond("POST",$rota,$call);
            echo "estou aki";
        }
    }
}