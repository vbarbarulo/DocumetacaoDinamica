<?php
/* 	
  ==========================| Criação |===============================
  /*	Este Script PHP Foi criado por Vinicius Barbarulo
  /*	Esta classe conta todas as Funções para conexão
  /*	com o banco de dados MYSQLI. 
  ====================================================================
 */
class Banco {
    //CONEXAO
    private $SQL_HOST = '';
    private $SQL_USER = '';
    private $SQL_PASSWORD = '';
    private $SQL_DATA_BASE = '';
    //COMANDOS        
    private $tabela = '';
    private $condicao = '';
    private $sql = '';
    private $campos = '';
    private $complemento = '';
    function __construct($SQL_HOST = '',$SQL_USER = '',$SQL_PASSWORD  = '',$SQL_DATA_BASE  = '') {  
        $this->SQL_DATA_BASE = $SQL_DATA_BASE;
        $this->SQL_HOST = $SQL_HOST;
        $this->SQL_USER = $SQL_USER;
        $this->SQL_PASSWORD = $SQL_PASSWORD;
    }
    public function __set_tabela($v) {
        $this->tabela = $v;
    }

    public function __set_condicao($v) {
        $this->condicao = $v;
    }

    public function __set_sql($v) {
        $this->sql = $v;
    }

    public function __set_campos($v) {
        $this->campos = $v;
    }

    public function __set_complemento($v) {
        $this->complemento = $v;
    }

    function MontaConsulta() {
        $ret = "";
        if ($this->campos == '') {
            $campos = " * ";
        } else {
            $campos = $this->campos;
        }
        $ret .= " SELECT  " . $campos . ' ';
        $ret .= " FROM  " . $this->tabela . ' ';
        if ($this->condicao != '') {
            $ret .= " WHERE  " . $this->condicao . ' ';
        }
        if ($this->complemento != '') {
            $ret .= " " . $this->complemento . ' ';
        }
        return $ret;
    }

 
    function MontaInsert() {
        $ret = '';
        $ret .= ' INSERT INTO ';
        $ret .= $this->tabela . ' (';
        foreach ($this->campos as $key => $value) {
            $ret .= $key . ',';
        }
        $ret = substr($ret, 0, -1);
        $ret .= ') VALUES (';
        foreach ($this->campos as $key => $value) {
            if (is_int($value)) {
                $ret .= $value . ",";
            } else {
                $ret .= "'" . $value . "',";
            }
        }
        $ret = substr($ret, 0, -1);
        $ret .= ')';
        return $ret;
    }

   
    function MontaUpdate() {
        $ret = '';
        $ret .= ' UPDATE ';
        $ret .= $this->tabela . ' SET ';

        $campos = array_filter($this->campos);
        foreach ($campos as $key => $value) {
            $ret .= $key . "='" . $value . "',";
        }
        $ret = substr($ret, 0, -1);
        $ret .= ' WHERE ' . $this->condicao;
        return $ret;
    }

   
    function ExeSql($sql) {
        $banco = new Banco();  
        $exe = $banco->Conexao_Banco($this->SQL_HOST,$this->SQL_USER,$this->SQL_PASSWORD,$this->SQL_DATA_BASE);   
        $exe->query($sql) or die(debug($this->campos).'<h1>Erro ao Registrar ou alterar:</h1><br>'.$sql.'<br><br>'. $exe->error . '<br><br>');
        $banco->des_conectar($this->SQL_HOST,$this->SQL_USER,$this->SQL_PASSWORD,$this->SQL_DATA_BASE);
        return mysqli_insert_id($exe);
    }

   
    function ExeConsulta($sql = '') {
        
        if ($sql == "") {
            $sql = $this->MontaConsulta();;
        } else {
            $sql = $sql;
        }
        
        $banco = new Banco();  
        $exe = $banco->Conexao_Banco($this->SQL_HOST,$this->SQL_USER,$this->SQL_PASSWORD,$this->SQL_DATA_BASE);    
        $retorno_banco = $exe->query($sql) or die(debug($this->campos).'<h1>Erro ao Registrar ou alterar:</h1><br>'.$sql.'<br><br>'. $exe->error . '<br><br>');
        $this->des_conectar($this->SQL_HOST,$this->SQL_USER,$this->SQL_PASSWORD,$this->SQL_DATA_BASE);
       
        $retorno = array();
        while ($res = mysqli_fetch_array($retorno_banco)) {
            $q_valores = count($res) / 2;
            for ($i = 0; $i <= $q_valores; $i++) {
                unset($res[$i]);
            }
            array_push($retorno, $res);
        }
        return $retorno;
    }
    
    function Conexao_Banco($SQL_HOST,$SQL_USER,$SQL_PASSWORD,$SQL_DATA_BASE){     
//  echo $SQL_HOST.'-'.$SQL_USER.'-'.$SQL_PASSWORD.'-'.$SQL_DATA_BASE;exit();
    $Conecta = new MySQLi($SQL_HOST,$SQL_USER,$SQL_PASSWORD,$SQL_DATA_BASE);
    // Verifica se ocorreu um erro e exibe a mensagem de erro
    if (mysqli_connect_errno()) {
        echo trigger_error(mysqli_connect_error(), E_USER_ERROR);
    }
    
    $Conecta->query("SET NAMES 'utf8'") OR trigger_error($Conecta->error, E_USER_ERROR);
    $Conecta->query("set character_set_connection=utf8") OR trigger_error($Conecta->error, E_USER_ERROR);
    $Conecta->query("set character_set_client=utf8") OR trigger_error($Conecta->error, E_USER_ERROR);
    $Conecta->query("set character_set_results=utf8") OR trigger_error($Conecta->error, E_USER_ERROR);
    return $Conecta; 

    }

    function des_conectar($SQL_HOST,$SQL_USER,$SQL_PASSWORD,$SQL_DATA_BASE) {
        $Conecta = new MySQLi($SQL_HOST,$SQL_USER,$SQL_PASSWORD,$SQL_DATA_BASE);
        $Conecta->close();
    }
}

?>