<div class="navbar-header">
    <a class="navbar-brand" href="{{ route('dashboard') }}">
{{--         <img src="{{ rotaArquivo("lt=")}}>--}}
        <h4>{{ config('sistema.titulo') }}</h4>
    </a>
    <ul class="nav navbar-nav pull-right visible-xs-block">
        <li><a data-toggle="collapse" data-target="#navbar-mobile"><i class="icon-grid3"></i></a></li>
    </ul>
</div>

<div class="navbar-collapse collapse" id="navbar-mobile">
    <div class="navbar-right">
        <ul class="nav navbar-nav">
            @if (isset($unidadeAtiva))
            <li class="dropdown language-switch">
                <a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    {{ $unidadeAtiva->descricao }}
                </a>
            </li>
            @endif


            <li class="dropdown dropdown-user">
                <a class="dropdown-toggle" data-toggle="dropdown">
                    <img src="{{ asset('assets/images/avatar-usuario.jpg') }}" alt="">

                    <span>{!! isset($perfilAtivo) ? '<strong>' .  $perfilAtivo->nome . '</strong> -' : '' !!} {{ primeiroNome(auth()->user()->nome) }}</span>
                    <i class="caret"></i>
                </a>

                <ul class="dropdown-menu dropdown-menu-right">
                    <li>
                        <a href="{{ route('usuario.alterar_senha') }}"><i class="icon-user"></i> Alterar senha</a>
                    </li>
                    <li>
                        <a href="{{ route('selecionar_unidade') }}"><i class="icon-city"></i> Selecionar centro</a>
                    </li>
                    @if ($qtdPerfis > 1)
                        <li>
                            <a href="{{ route('usuario.alterar_perfil') }}"><i class="icon-git-compare"></i> Alterar perfil</a>
                        </li>
                    @endif
                    {{-- <li>
                        <a href="#" @click.prevent="solicitarBloqueioTela()"><i class="icon-user-lock"></i> Bloquear tela</a>
                    </li> --}}
                    <li class="divider"></li>
                    <li><a href="{{ route('logout') }}"><i class="icon-switch2"></i> Logout</a></li>
                </ul>
            </li>
        </ul>
    </div>
</div>
