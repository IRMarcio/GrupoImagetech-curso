<?php

use App\Models\Arquivo;
use App\Services\Auditor;
use App\Services\Mascarado;
use Carbon\Carbon;
use Illuminate\Support\Facades\Route;

if (!function_exists('rotasCrud')) {
    /**
     * Rotas padrões para CRUD simples.
     *
     * @param  string  $controller
     * @param  string  $bind
     * @param  string  $class
     */
    function rotasCrud($controller, $bind = null, $class = null)
    {
        if (!is_null($class)) {
            Route::model($bind, $class);
        }

        Route::get('/', ['uses' => "$controller@index", 'as' => 'index']);
        Route::get('adicionar/{'.$bind.'?}', ['uses' => "$controller@adicionar", 'as' => 'adicionar']);
        Route::post('adicionar/{'.$bind.'?}', ['uses' => "$controller@salvar", 'as' => 'adicionar.post']);
        Route::get('alterar/{'.$bind.'}', ['uses' => "$controller@alterar", 'as' => 'alterar']);
        Route::post('alterar/{'.$bind.'}', ['uses' => "$controller@atualizar", 'as' => 'alterar.post']);
        Route::get('excluir/{'.$bind.'}', ['uses' => "$controller@excluir", 'as' => 'excluir']);
        Route::post('excluir', ['uses' => "$controller@excluirVarios", 'as' => 'excluir_varios.post']);
    }
}

if (!function_exists('dataFormatadaPadrao')) {
    function dataFormatadaPadrao($date)
    {
        $date = date_create($date);

        return date_format($date, "d/m/Y");
    }
}


if (!function_exists('formatarData')) {
    /**
     * Formata data para o formato informado.
     *
     * @param $data
     * @param  null  $formato
     *
     * @return false|string
     */
    function formatarData($data, $formato = null)
    {
        if (!$data) {
            return '';
        }


        if (is_null($formato)) {
            $formato = 'd/m/Y';
        }

        $data = str_replace('/', '-', $data);

        return date($formato, strtotime($data));
    }
}

if (!function_exists('diferencaDatasPorExtenso')) {
    /**
     * Retorna por extenso a diferença de 2 datas.
     *
     * @param  string  $data1
     * @param  string  $data2
     *
     * @return string
     */
    function diferencaDatasPorExtenso($data1, $data2 = null)
    {
        if (is_null($data2)) {
            $data2 = date('Y-m-d');
        }

        $data1 = new \DateTime($data1);
        $data2 = new \DateTime($data2);

        $diferenca = $data2->diff($data1);

        return "{$diferenca->y} anos, {$diferenca->m} meses e {$diferenca->d} dias";
    }
}

if (!function_exists('transformarDiasEmSemanas')) {
    /**
     * Retorna por extenso a quantidade de semanas/dias
     *
     * @param  int  $quanDias
     *
     * @return string
     */
    function transformarDiasEmSemanas($quantDias)
    {
        $semanas = floor($quantDias / 7);
        $dias = $quantDias % 7;

        return "{$semanas} semana(s) e {$dias} dia(s)";
    }
}

if (!function_exists('primeiroNome')) {
    /**
     * Retorna o Primeiro nome de uma sentence
     *
     * @param $nome
     *
     * @return string
     */
    function primeiroNome($nome)
    {
        $split = explode(" ", $nome);
        return  array_shift($split);
    }
}

if (!function_exists('diferencaDatasEmAnos')) {
    /**
     * Retorna diferença de 2 datas em anos.
     *
     * @param  string  $data1
     * @param  string  $data2
     *
     * @return string
     */
    function diferencaDatasEmAnos($data1, $data2 = null)
    {
        if (is_null($data2)) {
            $data2 = date('Y-m-d');
        }

        $data1 = new \DateTime($data1);
        $data2 = new \DateTime($data2);

        $diferenca = $data2->diff($data1);

        return $diferenca->y;
    }
}

if (!function_exists('diferencaDatasEmDias')) {
    /**
     * Retorna diferença de 2 datas em anos.
     *
     * @param  string  $data1
     * @param  string  $data2
     *
     * @return string
     */
    function diferencaDatasEmDias($data1, $data2 = null)
    {
        if (is_null($data2)) {
            $data2 = date('Y-m-d');
        }

        $data1 = new \DateTime($data1);
        $data2 = new \DateTime($data2);

        $diferenca = $data2->diff($data1);

        return $diferenca->days;
    }
}

if (!function_exists('formatarDecimal')) {
    /**
     * Formata data para o formato informado.
     *
     * @param $valor
     *
     * @return float
     */
    function formatarDecimal($valor)
    {
        return str_replace(['.', ','], ['', '.'], $valor);
    }
}

if (!function_exists('enderecoIp')) {
    /**
     * Retorna o endereço IP do usuário acessando o site.
     *
     * @return string
     */
    function enderecoIp()
    {
        return request()->ip();
    }
}


if (!function_exists('formatarCpf')) {
    /**
     * Formata um número para o formato de CPF.
     *
     * @param  string  $cpf
     *
     * @return string
     */
    function formatarCpf($cpf)
    {
        return Mascarado::formatarCpf($cpf);
    }
}

if (!function_exists('formatarCnpj')) {
    /**
     * Formata um número para o formato de CNPJ.
     *
     * @param  string  $cnpj
     *
     * @return string
     */
    function formatarCnpj($cnpj)
    {
        return Mascarado::formatarCnpj($cnpj);
    }
}

if (!function_exists('temAlgumaPermissao')) {
    /**
     * Verifica se o usuário tem pelo menos uma das permissões especificadas.
     *
     * @param  array  $rotas
     *
     * @return bool
     */
    function temAlgumaPermissao($rotas)
    {
        foreach ($rotas as $rota) {
            if (!is_null($rota)) {
                if (\Gate::check($rota)) {
                    return true;
                }
            }
        }

        return false;
    }
}

if (!function_exists('montarArvore')) {
    /**
     * Montar árvore baseado em um array hierárquico.
     *
     * @param  array  $arrayElemen
     * @param  string  $campoId
     * @param  string  $campoIdPai
     * @param  array  $elemPai
     *
     * @return array
     */
    function montarArvore($arrayElemen, $campoId, $campoIdPai, $elemPai = null)
    {
        $arrayRetorno = [];

        if (!$arrayElemen) {
            return $arrayRetorno;
        }

        foreach ($arrayElemen as $elem) {
            if ((is_null($elemPai) && empty($elem[$campoIdPai])) || (!is_null($elemPai) && $elem[$campoIdPai] == $elemPai[$campoId])) {
                $elem['filhos'] = montarArvore($arrayElemen, $campoId, $campoIdPai, $elem);
                $arrayRetorno[] = $elem;
            }
        }

        return $arrayRetorno;
    }
}

/**
 * Dado o dia de semana em numeros, retorna o nome por extenso.
 */
if (!function_exists('diaSemanaExtenso')) {
    function diaSemanaExtenso($diaSemana)
    {
        $arraySemana = ["Domingo", "Segunda", "Terça", "Quarta", "Quinta", "Sexta", "Sábado"];

        return $arraySemana[$diaSemana];
    }
}

/**
 * Dado o mes em numero, retorna o nome por extenso.
 */
if (!function_exists('mesExtenso')) {
    function mesExtenso($mes = null)
    {
        $meses = [
            1 => 'Janeiro', 2 => 'Fevereiro', 3 => 'Março', 4 => 'Abril', 5 => 'Maio', 6 => 'Junho',
            7 => 'Julho', 8 => 'Agosto', 9 => 'Setembro', 10 => 'Outubro', 11 => 'Novembro', 12 => 'Dezembro'
        ];

        if (is_null($mes)) {
            return $meses;
        }

        return $meses[$mes];
    }
}

/**
 * Valida se a data informada para a visita é válida.
 *
 * @param  string  $dataHora
 *
 * @return bool
 */
if (!function_exists('dataEstaFutura')) {
    function dataEstaFutura($dataHora, $formato = 'Y-m-d')
    {
        $dataHora = Carbon::createFromFormat($formato, $dataHora, config('app.timezone'));

        return $dataHora->isFuture();
    }
}


/**
 * Inclui o arquivo de rotas de um módulo especifico.
 *
 * @return string
 */
if (!function_exists('incluirRota')) {
    function incluirRota($modulo, $arquivo, $namespace = null)
    {
        require base_path("modules/$modulo/routes/$arquivo");
    }
}

/**
 * Inclui o arquivo de rotas.
 *
 * @return string
 */
if (!function_exists('incluirRotaDireta')) {
    function incluirRotaDireta($arquivo)
    {
        require base_path("routes/_routes/$arquivo");
    }
}


/**
 * Dado um arquivo, exemplo: /css/base.css, substitui com uma string contendo
 * o arquivo mtime, exemplo. /css/base.1221534296.css.
 */
if (!function_exists('auto_version')) {
    function auto_version($file)
    {
        if (!file_exists(public_path($file))) {
            return $file;
        }

        $mtime = filemtime(public_path($file));

        return preg_replace('{\\.([^./]+)$}', ".$mtime.\$1", $file);
    }
}

if (!function_exists('auditar')) {
    function auditar($tabela, $id, $rota, $usuarioId, $acao = 'I', $descricao = null)
    {
        /** @var Auditor $auditor */
        $auditor = app(Auditor::class);
        $auditor->adicionarAlteracaoSimples($tabela, $id, $rota, $usuarioId, $acao, $descricao);
        session()->forget('auditoria_id');
    }
}


if (!function_exists('readableBytes')) {
    function readableBytes($bytes)
    {
        $i = floor(log($bytes) / log(1024));
        $sizes = ['B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];

        return sprintf('%.02F', $bytes / pow(1024, $i)) * 1 .' '.$sizes[$i];
    }
}

if (!function_exists('rotaArquivo')) {
    function rotaArquivo(Arquivo $arquivo)
    {
        $hashId = null;
        if (!$arquivo->publico) {
            $hashId = base64_encode(Hash::make(auth()->user()->id));
        }

        return route('arquivo.visualizar', [$arquivo, $hashId]);
    }
}
