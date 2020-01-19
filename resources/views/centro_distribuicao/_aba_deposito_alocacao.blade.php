@if($centro_distribuicao->endAlocacao->count()  == 0)
    <fieldset class="content-group">
        <legend class="text-bold">Estrutura de Organiza&ccedil;&atilde;o de Aloca&ccedil;&atilde;o Dep&oacute;sito</legend>
        @include('centro_distribuicao._dados_endereco_alocacao')
    </fieldset>
@endif
@if($centro_distribuicao->endAlocacao->count()  !== 0)
    <fieldset class="content-group">
        <legend class="text-bold" style="padding-bottom: 15px">
            Gerenciamento das Aloca&ccedil;&otilde;es do Centro Distribui&ccedil;&atilde;o {{ $centro_distribuicao->descricao }}
            <a href="{{ route('enderecamento_cargas.adicionar',[]) }}"
               class="btn  btn-xs pull-right ">
                Adicionar Endere&ccedil;o
            </a>

        </legend>
        @include('centro_distribuicao._listagem_alocacao')
    </fieldset>
@endif
