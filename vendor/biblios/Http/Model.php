<?php

namespace biblios\Http;
use \PDO;

// use App\Database\ConexaoBD;

class Model {
    
    //Atributos necessarios
    protected $table;        #Nome da tabela
    protected $primaryKey;   #Chave primaria da tabela
    protected $data;
    
    ####### SUJEITO A MODIFICAÇÕES

    public function __construct(){
        $this->setPDO();
    }

    private $_pdo;
    private function setPDO(){
        $this->_pdo = new PDO('mysql:host=localhost;dbname=DBBIBLIOS', 'root', 'eduardo1976');
    }
    
    
    /**
    * Este é o método para INSERT
    * armazena o objeto na tabela
    */
    public function save(array $campos_values)
    {
        $campos_array = array_keys($campos_values);
        $values_array = array_values($campos_values);

        $insert_campos = implode(",", $campos_array);
        $insert_values = implode("','", $values_array);

        try {
            // $sql = "INSERT INTO $this->table ($insert_campos) VALUES ('$insert_values')";        
            $insert = $this->_pdo->prepare("INSERT INTO {$this->table} ({$insert_campos}) VALUES ('{$insert_values}')");
            if($insert->execute()) return $this->_pdo->lastInsertId();
        } catch (Exception $e) {
            return print "Ocorreu um erro ao tentar executar esta ação, tente novamente mais tarde. <br>".$e->getCode() . " Mensagem: " . $e->getMessage();
        }
    }
            
    public function update(array $campos_values, $id, $campoDoUpdate = false)
    {   
        $sql_text_array = array();
        foreach($campos_values as $campo =>$valor){
            array_push($sql_text_array, "{$campo}= '{$valor}'");
        }

        $sql_text = implode(",", $sql_text_array);

        // try {
            if($campoDoUpdate){
                $update = $this->_pdo->prepare("UPDATE {$this->table} SET {$sql_text} WHERE {$campoDoUpdate} = {$id}");                
            }else{
                $update = $this->_pdo->prepare("UPDATE {$this->table} SET {$sql_text} WHERE {$this->primaryKey} = {$id}");
            }
            // $sql = "INSERT INTO $this->table ($insert_campos) VALUES ('$insert_values')";        
            return $update->execute();
        // } catch (Exception $e) {
            // return print "Ocorreu um erro ao tentar executar esta ação, tente novamente mais tarde. <br>".$e->getCode() . " Mensagem: " . $e->getMessage();
        // }
    }
    
    public function delete($id, $campoDoDelete){
         try {
            if($campoDoDelete){
                $sql = "DELETE FROM {$this->table} WHERE {$campoDoDelete} = {$id};";
            }else{
                $sql = "DELETE FROM {$this->table} WHERE {$this->primaryKey} = {$id};";
            }
            $delete = $this->_pdo->query($sql);
            // print_r($result);
            return $delete;
        } catch(PDOException $e ){
            return print "Ocorreu um erro ao tentar executar esta ação, tente novamente mais tarde. <br>".$e->getCode() . " Mensagem: " . $e->getMessage();            
        }
            return false;
    }


        
    public function find($id){
        try {
            $sql = "SELECT * FROM {$this->table} WHERE {$this->primaryKey}={$id};";
            $find = $this->_pdo->prepare($sql);
            $find->execute();
            $result = $find->fetch();
            // print_r($result);
            return $result;
        } catch(PDOException $e ){
            return print "Ocorreu um erro ao tentar executar esta ação, tente novamente mais tarde. <br>".$e->getCode() . " Mensagem: " . $e->getMessage();            
        }
        
    }
    
    public  function all(){
        try {
            $sql = "SELECT * FROM {$this->table};";
            $all = $this->_pdo->query($sql);
            $result = $all->fetchAll();
            // print_r($result);
            return $result;
        } catch(PDOException $e ){
            return print "Ocorreu um erro ao tentar executar esta ação, tente novamente mais tarde. <br>".$e->getCode() . " Mensagem: " . $e->getMessage();            
        }
    }

    public function where($campo, $valor){
        try {
            $sql = "SELECT * FROM {$this->table} WHERE {$campo}={$valor};";
            $find = $this->_pdo->prepare($sql);
            $find->execute();
            $result = $find->fetchall();
            // print_r($result);
            return $result;
        } catch(PDOException $e ){
            return print "Ocorreu um erro ao tentar executar esta ação, tente novamente mais tarde. <br>".$e->getCode() . " Mensagem: " . $e->getMessage();            
        }
    }

    public function totalRegistro($campo = false, $valor = false){
        try {
            if(!$campo && !$valor){
                $sql = "SELECT COUNT(*) FROM {$this->table}";                
            }else{
                $sql = "SELECT COUNT(*) FROM {$this->table} WHERE {$campo} = {$valor}";                
            }
            $total = $this->_pdo->query($sql);
            $total->execute();
            $result = $total->fetch();
        } catch(PDOExecption $e ){
            return print "Ocorreu um erro ao tentar executar esta ação, tente novamente mais tarde. <br>".$e->getCode() . " Mensagem: " . $e->getMessage();                        
        }

        return $result;
    }

    public function groupByISBN($disponiveis, $filtro = null, $pesquisa = null ){
        try {
            if($disponiveis){
                $sql = "select count(*) as quantidade, strisbn, strnomeexemplar, streditora, strautor, strpreco, boldisponivel from tblexemplar where boldisponivel = 0";           
            }else{
                $sql = "select count(*) as quantidade, strisbn, strnomeexemplar, streditora, strautor, strpreco from tblexemplar ";
            }

            if($disponiveis && ($filtro || $pesquisa )){
                if($filtro != 'todos' && !empty($pesquisa)){
                    $sql = $sql." AND {$filtro} LIKE '%{$pesquisa}%' ";
                }
            }
            if(!$disponiveis && ($filtro || $pesquisa )){
                if($filtro != 'todos' && !empty($pesquisa)){
                    $sql = $sql." WHERE {$filtro} LIKE '%{$pesquisa}%' ";
                }
            }
            
            if($disponiveis){
                $sql = $sql." group by strisbn, strnomeexemplar, streditora, strautor, strpreco, boldisponivel";
            }else{
                $sql = $sql." group by strisbn, strnomeexemplar, streditora, strautor, strpreco";                
            }
            
            $group = $this->_pdo->query($sql);
            $result = $group->fetchall();
            // print_r($result);
            return $result;
        } catch(PDOException $e ){
            return print "Ocorreu um erro ao tentar executar esta ação, tente novamente mais tarde. <br>".$e->getCode() . " Mensagem: " . $e->getMessage();            
        }
    }

    public function emprestimosAtivos($id = false){
        try {
            if(!$id){
                $sql = "select (select count(*) from tblexemplar ex where ex.idemprestimo in(e.idemprestimo)) as livros ,(select strnometipo from tblfuncionariotipo where idfuncionariotipo = f.idfuncionariotipo group by f.idfuncionario ) as cargo, e.idemprestimo, e.dtaemprestimo, e.dtadevolucao, e.bolfinalizado, f.idfuncionario, f.strnomefuncionario,
	                f.strcpf, stroab
                    from tblemprestimo e inner join tblfuncionario f on f.idfuncionario = e.idfuncionario where e.bolfinalizado = 0 ";
            } else {
                $sql = "select (select count(*) from tblexemplar ex where ex.idemprestimo in(e.idemprestimo)) as livros ,(select strnometipo from tblfuncionariotipo where idfuncionariotipo = f.idfuncionariotipo group by f.idfuncionario ) as cargo, e.idemprestimo, e.dtaemprestimo, e.dtadevolucao, e.bolfinalizado, f.idfuncionario, f.strnomefuncionario,
	                f.strcpf, stroab
                    from tblemprestimo e inner join tblfuncionario f on f.idfuncionario = e.idfuncionario where e.idemprestimo = {$id} ";
            }
            $group = $this->_pdo->query($sql);
            $result = $group->fetchall();
            // print_r($result);
            return $result;
        } catch(PDOException $e ){
            return print "Ocorreu um erro ao tentar executar esta ação, tente novamente mais tarde. <br>".$e->getCode() . " Mensagem: " . $e->getMessage();            
        }
    }

    public function funcionarios(){
        try {
            $sql = "select * from tblfuncionario f inner join tblfuncionariotipo tf on f.idfuncionariotipo = tf.idfuncionariotipo ";
            $group = $this->_pdo->query($sql);
            $result = $group->fetchall();
            // print_r($result);
            return $result;
        } catch(PDOException $e ){
            return print "Ocorreu um erro ao tentar executar esta ação, tente novamente mais tarde. <br>".$e->getCode() . " Mensagem: " . $e->getMessage();            
        }
    }

    public function funcionarioEmprestimo($idfuncionario){
        try {
            $sql = "select (select strnometipo from tblfuncionariotipo where idfuncionariotipo = f.idfuncionariotipo) as cargo , 
e.idemprestimo, e.dtaemprestimo, e.dtadevolucao, e.bolfinalizado, f.idfuncionario, f.strnomefuncionario,
	f.strcpf, stroab
 from tblemprestimo e inner join tblfuncionario f on e.idfuncionario = f.idfuncionario where e.idfuncionario = 5 AND e.bolfinalizado = 0;";
            $group = $this->_pdo->query($sql);
            $result = $group->fetchall();
            // print_r($result);
            return $result;
        } catch(PDOException $e ){
            return print "Ocorreu um erro ao tentar executar esta ação, tente novamente mais tarde. <br>".$e->getCode() . " Mensagem: " . $e->getMessage();            
        }
    }

    

    
}