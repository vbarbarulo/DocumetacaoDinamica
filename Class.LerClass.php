<?php

Class LerClass {

    function pegar_campos($NomeArquivo) {
        /**
         * PEGA OS NOMES DOS CAMPOS
         */
        $a = file($NomeArquivo);
        $texto = '';
        foreach ($a as $key => $value) {
            $texto .= $value;
        }
        $texto_campos = html_entity_decode($texto);
        $texto_campos = str_replace('private ', '@private ', $texto_campos);
        $texto_campos = str_replace('public ', '@public ', $texto_campos);
        $texto_campos = str_replace('protected  ', '@protected ', $texto_campos);
        $funcoes = explode('@', $texto_campos);
        $campos_nomes = '';
        foreach ($funcoes as $key => $value) {
            $value = str_replace('{', '', $value);
            $campos = explode('$', $value);
            if ($campos[0] == 'private ' || $campos[0] == 'public ') {
                $campos = explode('=', $campos[1]);
                $campos_nomes .= $campos[0] . ',';
            }
        }
        $campos_nomes = substr($campos_nomes, 0, -1);
        return $campos_nomes;
    }

    function AcharClasses($NomeArquivo) {
        $a = file($NomeArquivo);
        $retorno = array();
        $contador = 0;
        //Percorre todo o arquivo
        foreach ($a as $key => $value) {
            $texto_original = $value;
            //Acha o nome da Class
            $value = str_replace('class ', '^^^^class ', $value);
            $classes = explode('^^^^class ', $value);
            //Achou uma classe faz o tratamento para pegar o nome da mesma
            if (isset($classes[1])) {
                //Verifica se é extendidade se for joga fora
                $classes = explode(' extends', $classes[1]);
                //limpa a chave do nome
                $classes[0] = str_replace('{', '', $classes[0]);
                //adiciona ao vetor e salva o nome em uma variavel para o restante das cosas ficar dentro do mesmo vetor
                $name_class = trim($classes[0]);
                $retorno[$contador] = array("Classe" => $name_class);
            }
        }
        return $retorno;
    }

    function achar_funcoes($NomeArquivo) {
        $a = file($NomeArquivo);
        $retorno = array();
        $contador = 0;
        //Percorre todo o arquivo
        foreach ($a as $key => $value) {
            $texto_original = $value;

            //Subistitui os nomes abaixo para facitar a explioção
            $value = str_replace('private ', '@private ', $value);
            $value = str_replace('public ', '@public ', $value);
            $value = str_replace('protected  ', '@protected ', $value);
            //Exe a explosão 
            $funcoes = explode('@', $value);

            //verifica se a alguma coisa depois do @
            if (isset($funcoes[1])) {
                //Explode os nas chaves para não pegar os atributos apenas os metodos
                $funcoes[1] = str_replace('{', '', $funcoes[1]);

                $campos = explode('$', $funcoes[1]);

                if ($campos[0] == 'private ' || $campos[0] == 'public ') {
//                  //Aqui ele le os campos que não me importa nesse momento
                } else {
                    if ($funcoes[1] != '') {
                        $nome_function = str_replace('public function ', '', $funcoes[1]);
                        $nome_function = explode('(', $nome_function);
                        array_push($retorno, array('funcao_completa' => $funcoes[1], 'name' => $nome_function[0]));
                    }
                }
            }
        }
        return $retorno;
    }

    function LerComentarios($NomeArquivo, $funcoes) {
        $a = file($NomeArquivo);
        $retorno = array();
        $contador = 0;
        //Percorre todo o arquivo
        $texto = '';
        foreach ($a as $key => $value) {
            $texto .= $value;
        }
        $campos = explode(" * @@@InicioFuncao ", $texto);
        unset($campos[0]);
        foreach ($campos as $key => $value) {
            $comentarios = explode('FimFuncao ', $value);
            $comentarios = explode('*', $comentarios[0]);
            $nome = trim($comentarios[0]);
            unset($comentarios[0]);
            $comentario_text = '';
            foreach ($comentarios as $k => $v) {
                $comentario_text .= $v . ' ';
            }
            array_push($retorno, array('nome' => $nome, 'comentario' => $comentario_text));
        }
        return $retorno;
    }

    public function JuntarFuncaoComentario($funcao, $comentarios) {
        $retorno = array();
        foreach ($funcao as $key => $value) {
            for ($i = 0; $i <= count($comentarios); $i++) {
                if ($value['name'] == $comentarios[0]['nome']) {
                    $value['comentario'] = $comentarios[0]['comentario'];
                }
            }
            array_push($retorno, $value);            
        }
        debug($retorno);
    }

}
