<?php
include 'config.php';





$NomeArquivo = 'Class.Banco.php';
$a = file($NomeArquivo);
echo ' <b>Nome do arquivo:</b> ' . $NomeArquivo . '<br>';
echo '<table border="1" width="800">';
foreach ($a as $key => $value) {
        
    $value = str_replace('class ', '^^^^class ', $value);
    $classes = explode('^^^^class ', $value);
    if (isset($classes[1])) {
        $classes = explode(' extends', $classes[1]);
        echo '<tr><td colspan="2" >' . $classes[0] . '</td></tr>';
//        echo $classes[0].'<br>';
    }

    $value = str_replace('private ', '@private ', $value);
    $value = str_replace('public ', '@public ', $value);
    $value = str_replace('protected  ', '@protected ', $value);
    $funcoes = explode('@', $value);
    if (isset($funcoes[1])) {
        $funcoes[1] = str_replace('{', '', $funcoes[1]);
        $funcoes[1] = str_replace(';', '', $funcoes[1]);
        echo '<tr><td>' . $funcoes[1] . '</td><td width="600"></td></tr>';
//        echo $funcoes[1].'<br>';
    }

//    echo $value.'<br>';
}
echo '</table>';



