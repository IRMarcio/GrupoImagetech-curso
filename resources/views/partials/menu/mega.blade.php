@if(temAlgumaPermissao(collect($menu->filhos)->pluck('url')->toArray()))
    <li class="dropdown mega-menu mega-menu-wide">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            {{ $menu->descricao }}
            <span class="caret"></span>
        </a>

        <div class="dropdown-menu dropdown-content">
            <div class="dropdown-content-body">
                <div class="row">
                    <div class="col-md-3">
                        @foreach($menu->filhos as $menuFilho)
                            @can($menuFilho->url)
                                @if ($menuFilho->tipo_menu == 'HEADER')
                                    @if (isset($abriuHeader) && $abriuHeader)
                                        </ul>
                                        </div>
                                        <div class="col-md-3">
                                    @endif
                                    <span class="menu-heading underlined">{{ $menuFilho->descricao }}</span>
                                    <ul class="menu-list">
                                    @php($abriuHeader = true)
                                @else
                                    <li>
                                        <a href="{{ $menuFilho->url ? route($menuFilho->url) : '#' }}"><i class="{{ $menuFilho->icone }}"></i> {{ $menuFilho->descricao }}</a>
                                    </li>
                                @endif
                            @endcan
                        @endforeach
                        </ul>
                </div>
            </div>
        </div>
    </li>
@endif