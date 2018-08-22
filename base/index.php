<?php

#função __autoload
include_once 'app/database/TConnection.class.php';

echo 'teste';


    $con = TConnection::abrirConexao();

    
?>