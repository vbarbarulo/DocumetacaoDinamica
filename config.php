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
function padroniza_nome($nome){
    $nome = utf8_encode($nome);
    $nome =str_replace("'", '', $nome);
    return  $nome;
}

function formatarCPF_CNPJ($campo, $formatado = true){
	//retira formato
	$codigoLimpo = trim($campo);
	// pega o tamanho da string menos os digitos verificadores
	$tamanho = (strlen($codigoLimpo) -2);
	//verifica se o tamanho do código informado é válido
	if ($tamanho != 9 && $tamanho != 12){
		return false; 
	}
 
	if ($formatado){ 
		// seleciona a máscara para cpf ou cnpj
		$mascara = ($tamanho == 9) ? '###.###.###-##' : '##.###.###/####-##'; 
 
		$indice = -1;
		for ($i=0; $i < strlen($mascara); $i++) {
			if ($mascara[$i]=='#') $mascara[$i] = $codigoLimpo[++$indice];
		}
		//retorna o campo formatado
		$retorno = $mascara;
 
	}else{
		//se não quer formatado, retorna o campo limpo
		$retorno = $codigoLimpo;
	}
 
	return $retorno;
 
}
set_time_limit(21600000);


function Verificar_categoria($categoria) {
    /* Função para Verificar Qual Area de Atuação */
    switch ($categoria) {
        case 'Administrativo/ Escritório': $Area = 336;
            break;
        case 'Comercial e Vendas': $Area = 355;
            break;
        case 'Indústria, Manufatura e Produção': $Area = 367;
            break;
        case 'Comércio Varejista/ Atacadista': $Area = 412;
            break;
        case 'Restaurantes e bares': $Area = 346;
            break;
        case 'Informática/TI e Internet': $Area = 380;
            break;
        case 'Saúde, Trat.Terapêuticos e Hospitalar': $Area = 387;
            break;
        case 'Financeiro/ Contabilidade/ Economia': $Area = 374;
            break;
        case 'Serviços Gerais e Domiciliares': $Area = 413;
            break;
        case 'Técnicos (Manutenção, Instalação e Reparos)': $Area = 385;
            break;
        case 'Telemarketing / Atendimento ao Cliente': $Area = 348;
            break;
        case 'Educação, Treinamento e Idiomas': $Area = 361;
            break;
        case 'Logística/ Distribuição': $Area = 384;
            break;
        case 'Recursos Humanos': $Area = 398;
            break;
        case 'Construção Civil': $Area = 363;
            break;
        case 'Marketing': $Area = 386;
            break;
        case 'Esportes/ Educação Física/ Academias': $Area = 370;
            break;
        case 'Transporte (Terrestre, Marítimo e Aéreo)': $Area = 411;
            break;
        case 'Turismo e Hotelaria': $Area = 378;
            break;
        case 'Jurídico': $Area = 383;
            break;
        case 'Publicidade e Propaganda': $Area = 394;
            break;
        case 'Estética, Moda e Beleza': $Area = 389;
            break;
        case 'Química/ Farmacêutica': $Area = 396;
            break;
        case 'Segurança do Trabalho': $Area = 402;
            break;
        case 'Engenharia - Outros': $Area = 363;
            break;
        case 'Arquitetura, Decoração e Urbanismo': $Area = 343;
            break;
        case 'Auditoria/ Controladoria': $Area = 358;
            break;
        case 'Telecomunicações': $Area = 407;
            break;
        case 'Comunicação/ Relações Públicas': $Area = 399;
            break;
        case 'Engenharia Elétrica/ Eletrônica': $Area = 368;
            break;
        case 'Jornalismo e Mídia (Veíc. Comunic.)': $Area = 382;
            break;
        case 'Comércio Exterior': $Area = 356;
            break;
        case 'Engenharia de Produção / Industrial': $Area = 367;
            break;
        case 'Engenharia Mecânica/ Mecatrônica': $Area = 369;
            break;
        case 'Ciências, Pesquisa e Desenvolvimento': $Area = 358;
            break;
        case 'Engenharia Civil': $Area = 363;
            break;
        case 'Agricultura, Pecuária e Pesca': $Area = 341;
            break;
        case 'Veterinária, Zoologia, Zootecnia': $Area = 341;
            break;
        case 'Seguro e Previdência Privada': $Area = 404;
            break;
        case 'Setor Público /ONGs': $Area = 400;
            break;
        case 'Artes, Lazer, Literatura e Entretenimento': $Area = 344;
            break;
        case 'Meio Ambiente /Ecologia': $Area = 388;
            break;
        default: $Area = 1994;
            break;
    }
    return $Area;
}
