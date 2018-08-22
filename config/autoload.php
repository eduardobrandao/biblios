<?php

#Carrega arquivo de configuraçao
require_once __DIR__."/configuracoes.php";
#Carrega arquivo com funções de ajuda
require_once __DIR__."/helpers.php";
#Carrega o autoload do composer
require_once __DIR__."/../vendor/autoload.php";


#Configurações da variavel global que será usada para rotas
$base  = dirname($_SERVER['PHP_SELF']);
// Update request when we have a subdirectory    
if(ltrim($base, '/')){ 

    $_SERVER['REQUEST_URI'] = substr($_SERVER['REQUEST_URI'], strlen($base));
}else{
    echo 'merda';
}

#Carrega o nosso plugin de rotas
$rota = new biblios\Rotas\Rota();
#carrega aruqivo de rotas
require_once __DIR__."/../app/Rotas.php"; 
#Retorna rotas
return $rota;