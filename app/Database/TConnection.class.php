<?php

/*
**  Classe para Conexão com o Banco de Dados
**  através de arquivos de configuração
*/



class TConnection
{
    /*
     * método construtor
     * não existirão instâncias de TConnection, por isso estamos marcado-o como private
    */
    private function __construct(){} 
   
    # Método abrirConexao()
    # recebe o nome do banco de dados e instancia o objeto PDO
    public static function abrirConexao(){
        $arquivoDeConfiguracao = 'app/config/database.ini';
        
        #Uma verificação simples para saber se o arquivo foi carregado, se não, é lançado uma exceção
        if(!$configuracao = parse_ini_file($arquivoDeConfiguracao,TRUE))
            throw new exception('Não foi possivel ler '.$arquivoDeConfiguracao.'.');

        #Concatenando e atribuindo as config da conexão a uma variavel
        $dns = $configuracao['database']['driver'] . ':host=' . $configuracao['database']['host'] . ';port=' . $configuracao['database']['port'] . ';dbname=' . $configuracao['database']['name'];
        
        
        #Chamando o metodo construtor da Classe PDO
        $conexao = new PDO($dns, $configuracao['database']['user'], $configuracao['database']['password']);
        
        #define para que o PDO lance execeções na ocorrência de erros
        $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        #retorna o objeto instanciado
        return $conexao;
    }
}

?>