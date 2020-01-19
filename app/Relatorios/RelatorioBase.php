<?php

namespace App\Relatorios;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;
use Mpdf\Mpdf;
use PDF;
use Response;

class RelatorioBase
{

    /**
     * Quantidade de itens por página.
     *
     * @var int
     */
    protected $porPagina = 10;

    /**
     * Filtros do relatório
     *
     * @var array
     */
    protected $filtros = [];

    /**
     * Exporta o relatório.
     *
     * @param array $filtros
     * @param array $with
     *
     * @return mixed
     */
    public function exportar($filtros, $with = [])
    {
        $this->filtros = $filtros;
        
        $dados = $this->gerar($filtros, false, $with);

        return $this->imprimir($filtros, $dados, $this->view);
    }

    public function imprimir($filtros, $dados, $view)
    {
        $tipo = $filtros['relformato'];
        $filtrosTexto = $this->aplicaFiltrosTexto($filtros);

        $conteudo = view($view)
            ->with('filtros', $filtros)
            ->with('filtrosTexto', $filtrosTexto)
            ->with(compact('dados'))
            ->with('titulo', $this->titulo())
            ->with('tipo', $tipo);

        $nomeArquivo = $this->gerarNomeArquivo();

        switch ($tipo) {
            case 'xls':
                $response = Response::make($conteudo, 200);
                $response->header('Content-Type', 'application/msexcel');
                $response->header('Content-disposition', "attachment; filename=$nomeArquivo.xls");
                break;
            case 'html':
                $response = $conteudo;
                break;
            case 'pdf':
                $mpdf = new Mpdf(
                    [
                        '',
                        'A4',
                        '',
                        '',
                        15,
                        15,
                        30,
                        15,
                        'tempDir' => storage_path('app' . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . '_mpdf')
                    ]
                );
                $mpdf->simpleTables = true;
                $mpdf->useSubstitutions = true;
                $mpdf->use_kwt = true;
                $mpdf->WriteHTML($conteudo);

                return $mpdf->Output();
                break;
        }

        return $response;
    }

    public function aplicaFiltrosTexto($filtros)
    {
        $filtrosTexto = [];
        if (!empty($filtros['data'])) {
            $filtrosTexto[] = 'Data: ' . $filtros['data'];
        }

        if (!empty($filtros['data_inicial'])) {
            $filtrosTexto[] = 'Data inicial: ' . $filtros['data_inicial'];
        }

        if (!empty($filtros['data_final'])) {
            $filtrosTexto[] = 'Data final: ' . $filtros['data_final'];
        }

        return $filtrosTexto;
    }

    public function titulo()
    {
        return $this->titulo;
    }

    /**
     * Gera o nome do arquivo a ser feito download pelo usuário.
     *
     * @return string
     */
    private function gerarNomeArquivo()
    {
        $titulo = Str::ascii($this->titulo);
        $titulo = Str::slug($titulo) . '_' . date('d-m-Y');

        return "$titulo";
    }

    /**
     * Atualiza o tanto de registros que será paginado por pagina.
     *
     * @param $qnt
     */
    public function setPorPagina($qnt)
    {
        $this->porPagina = $qnt;
    }

    public function identificarEadgerLoading($filtros)
    {
        $with = [];
        if (isset($filtros['with'])) {
            $with = $filtros['with'];
            if (!is_array($with)) {
                $with = explode(',', $with);
            }
        }

        return $with;
    }

    /**
     * Pagina o resultado de uma query feita no banco.
     *
     * @param int $pagina
     * @param mixed $dados
     *
     * @return LengthAwarePaginator|mixed
     */
    protected function paginar($pagina, $dados)
    {
        $itemsPaginaAtual = $dados->forPage($pagina, $this->porPagina);
        $dados = new LengthAwarePaginator($itemsPaginaAtual, count($dados), $this->porPagina, $pagina, ['path' => '?']);

        return $dados;
    }
}
