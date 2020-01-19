@section('js')
    @parent
    <script src="{{ asset('assets/js/modulos/gerenciapermissoes.js') }}"></script>
@stop

<div class="tabbable">
    <ul class="nav nav-tabs nav-tabs-bottom">
        <li class="active"><a href="#dados" data-toggle="tab">Dados</a></li>
        <li><a href="#gerenciarpermissoes" data-toggle="tab">Permissões</a></li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane active" id="dados">
            @include('perfil._aba_dados')
        </div>

        <div class="tab-pane" id="gerenciarpermissoes">
            @include('perfil._aba_permissoes')
        </div>
    </div>
</div>


@include('partials.forms.botao_salvar', ['voltar' => 'perfil.index'])