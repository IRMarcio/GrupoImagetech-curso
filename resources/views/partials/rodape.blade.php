<div class="navbar-boxed">
    <ul class="nav navbar-nav visible-xs-block">
        <li>
            <a class="text-center collapsed" data-toggle="collapse" data-target="#footer"><i class="icon-circle-up2"></i></a>
        </li>
    </ul>

    <div class="navbar-collapse collapse" id="footer">
        <div class="navbar-text">
            {{ config('sistema.fornecedor') }} &copy; {{ date('Y') }}
        </div>

        <div class="navbar-right">
            <ul class="nav navbar-nav">
                <li>
                    <a href="">{{ config('sistema.titulo') }} - {{ config('sistema.fornecedor') }} - {{ config('sistema.versao') }}</a>
                </li>
                {{-- <li><a href="#">Contato</a></li> --}}
            </ul>
        </div>
    </div>
</div>
