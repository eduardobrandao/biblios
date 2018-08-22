<?php

//Classe de Conexão com o Banco de Dados

namespace App\Database;
use \PDO;

class ConexaoBD {

    #declarando uma variavel instance
    public static $instance;

    #tornando o construtor privado para que somente a propria classe tenha acesso
    private function __construct() {
    //
    }

    #Criando método para abrir conexão com o banco de dados
    public static function getInstance() {
        if (!isset(self::$instance)) {
            self::$instance = new PDO('mysql:host=localhost;dbname=DBBIBLIOS', 'root', 'vertrigo');
            self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$instance->setAttribute(PDO::ATTR_ORACLE_NULLS, PDO::NULL_EMPTY_STRING);
        }

    return self::$instance;
    }

}