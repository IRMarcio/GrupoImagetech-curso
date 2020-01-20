<div class="panel panel-white">
    <div class="panel-heading">
        <h6 class="panel-title">Registros</h6>
    </div>

    @if (isset($crud) && $crud == true || !isset($crud))
        <div class="panel-toolbar panel-toolbar-inbox">
            <div class="navbar navbar-default navbar-component no-margin-bottom">
                <ul class="nav navbar-nav visible-xs-block no-border">
                    <li>
                        <a class="text-center collapsed" data-toggle="collapse"
                           data-target="#inbox-toolbar-toggle-single">
                            <i class="icon-circle-down2"></i>
                        </a>
                    </li>
                </ul>

                <div class="navbar-collapse collapse" id="inbox-toolbar-toggle-single">
                    <div class="btn-group navbar-btn">
                        <div class="acoes-com-registros-selecionados">
                            <span><strong>Com selecionados:</strong></span>
                            @section('acoes-com-registros-selecionados')
                                @can("$prefixo.excluir")
                                    @include('partials.forms.botao_excluir', ['url' => route("$prefixo.excluir_varios.post")])
                                @endcan
                            @show
                        </div>
                    </div>

                    @can("$prefixo.adicionar")
                        @if(isset($adicionar) ? $adicionar : true)
                            <div class="navbar-right">
                                @include('partials.forms.botao_adicionar',
                                [
                                'url' => route("$prefixo.adicionar"),
                                'label' => isset($label) ? $label : null
                                ])
                            </div>
                        @endif
                    @endcan
                </div>
            </div>
        </div>
    @endif

    @if (isset($listagem))
        @include($listagem)
    @else
        @include("$prefixo.listagem")
    @endif

    @if (isset($dados) && method_exists($dados, 'total') && $dados->total() > 0)
        <div class="panel-footer panel-footer-condensed">
            <div class="heading-elements">
                {{ $dados->appends(request()->query())->links() }}
            </div>
        </div>
    @endif
</div>
