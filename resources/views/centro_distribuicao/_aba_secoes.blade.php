<fieldset class="content-group">
    <legend class="text-bold">Gerenciamento dos Armazens</legend>
    @can("centro_distribuicao.adicionar_armazens")
        <div class="navbar-right">
            @can('centro_distribuicao.adicionar_armazens')
                @include('partials.forms.botao_adicionar', ['url' => route("centro_distribuicao.adicionar_armazens",[$centro_distribuicao->id])])
            @endcan
        </div>
    @endcan

    @include('centro_distribuicao.armazem._armazem_component')
</fieldset>
