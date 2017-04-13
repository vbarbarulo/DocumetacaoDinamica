<!--<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />-->
<!--<meta charset="UTF-8">-->

<?php
include 'Class.Banco.php';
include 'config.php';


//$tipo_banco =  array('1' => 'mysql', '2'=>'mariadb');
$tipo_banco = 2;

//$nome_banco = 'leiabibliafacil';
//$BANCO_EXTERNO = new Banco('leiabibliafacil.com.br', 'leiabibliafacil', 'vinicius4651', $nome_banco);
$nome_banco = 'contratando';
$BANCO_EXTERNO = new Banco('localhost', 'vinicius', '123456', $nome_banco);

$retorno = array();
$SQL = "SHOW TABLES;";
$tabelas = $BANCO_EXTERNO->ExeConsulta($SQL);
foreach ($tabelas as $key => $value) {
    
     $SQL_COMENTARIO_TABELA = "SELECT TABLE_COMMENT
            FROM information_schema.tables
            WHERE table_schema = '".$nome_banco."' AND table_name = '".$value['Tables_in_'.$nome_banco]."'";
    $comentario_banco = $BANCO_EXTERNO->ExeConsulta($SQL_COMENTARIO_TABELA);
    $retorno[$value['Tables_in_'.$nome_banco]] = array();
    $retorno[$value['Tables_in_'.$nome_banco]]['name'] = $value['Tables_in_'.$nome_banco];
    $retorno[$value['Tables_in_'.$nome_banco]]['comentario'] = $comentario_banco[0]['TABLE_COMMENT'];
    
   
    
    $SQL_1 = "SHOW COLUMNS FROM ".$value['Tables_in_'.$nome_banco];           
    $colunas = $BANCO_EXTERNO->ExeConsulta($SQL_1);
  
    if($tipo_banco == '1'){
        $SQL_COMENTARIO = "SELECT column_comments
            FROM information_schema.tables
            WHERE table_schema = '".$nome_banco."' AND table_name = '".$value['Tables_in_'.$nome_banco]."'";
    }
    if($tipo_banco == '2'){
        $SQL_COMENTARIO = "
            SELECT column_comment
            FROM information_schema.columns
            WHERE table_schema = '".$nome_banco."' AND table_name = '".$value['Tables_in_'.$nome_banco]."'";
    }  
    $comentario = $BANCO_EXTERNO->ExeConsulta($SQL_COMENTARIO);
    foreach ($colunas as $k => $v) {
        $colunas[$k]['column_comment'] = $comentario[$k]['column_comment'];
    }
    $retorno[$value['Tables_in_'.$nome_banco]]['campos'] = $colunas;
   
}
 debug($retorno);

?>
