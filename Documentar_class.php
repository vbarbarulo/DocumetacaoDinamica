<?php
//chama os arquivos
include 'config.php';
include 'Class.LerClass.php';

//INSTANCIA
$ler = new LerClass();

//O arquivo que será documentado
$NomeArquivo = 'Class.Banco.php';
echo ' <b>Nome do arquivo:</b> ' . $NomeArquivo . '<br>';

echo $ler->pegar_campos($NomeArquivo);
echo '<hr>';
$classe = $ler->AcharClasses($NomeArquivo);
$funcao = $ler->achar_funcoes($NomeArquivo);
$comentarios = $ler->LerComentarios($NomeArquivo,$funcao);


//debug($classe);
//debug($funcao);
//debug($comentarios);


 $ler->JuntarFuncaoComentario($funcao,$comentarios);






