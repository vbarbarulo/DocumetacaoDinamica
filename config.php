<?php

function debug($objeto, $morre = false) {
    echo '<h2>DEBUG</h2>';
    echo '<pre style="font-family: Arial;">';
    print_r($objeto);
    echo '</pre>';
    if ($morre) {
        die();
    }
}

function ler_arquivo($nome_arquivo){
    $ponteiro = fopen ($nome_arquivo,"r");
    $texto = '';
    while (!feof ($ponteiro)) {
      $linha = fgets($ponteiro,4096);
      $texto=$linha;
    }
    fclose ($ponteiro);
    return $texto;
}





function padroniza_nome($nome){
    $nome = utf8_encode($nome);
    $nome =str_replace("'", '', $nome);
    return  $nome;
}


