<div class="form">
    @section('js')
        @parent
        <script src="{{ asset('assets/js/modulos/carregaperfis.js') }}"></script>
        <script src="{{ asset('assets/js/modulos/usuario/form.js') }}"></script>
    @stop

    @section('vue-componentes')
        @parent
        <script src="{{ asset('assets/js/modulos/usuario/gerenciarperfis.js') }}"></script>
    @stop

    @if ($usuario->created_at)
        <input type="hidden" name="id" value="{{ $usuario->id }}"/>
    @endif

    <div class="tabbable">
        <ul class="nav nav-tabs nav-tabs-bottom">
            <li class="active"><a href="#dados-gerais" data-toggle="tab">Dados gerais</a></li>
            <li><a href="#perfis" data-toggle="tab">Perfis</a></li>
        </ul>

        <div class="tab-content">
            <div class="tab-pane active" id="dados-gerais">
                <fieldset class="content-group">
                    <legend class="text-bold">Identificação/Geral</legend>

                    @include('partials.usuario._aba_dados_gerais', ['registro' => $usuario])
                    @include('partials.usuario._aba_contato', ['registro' => $usuario])
                </fieldset>

                @if ($usuario->created_at)
                    <fieldset class="content-group">
                        <legend class="text-bold">Situação do usuário</legend>
                        @include('partials.usuario._aba_situacoes', ['registro' => $usuario])
                    </fieldset>
                @endif
            </div>

            <div class="tab-pane" id="perfis">
                @include('partials.usuario._aba_perfis', ['registro' => $usuario])
                <br/>
            </div>
        </div>
    </div>

    @include('partials.forms.botao_salvar', ['voltar' => 'usuario.index'])
</div>
