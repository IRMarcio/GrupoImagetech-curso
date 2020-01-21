@if(temAlgumaPermissao(collect($menu->filhos)->pluck('url')->toArray()))
    <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            {{ $menu->descricao }} <span class="caret"></span>
        </a>

        <ul class="dropdown-menu width-400">
            @foreach($menu->filhos as $menuFilho)
                @can($menuFilho->url)
                    <li>
                        <a href="{{ $menuFilho->url ? route($menuFilho->url) : '#' }}">
                            <i class="{{ $menuFilho->icone }}"></i> {{ $menuFilho->descricao }}
                        </a>
                    </li>
                @endcan
                @if (!$menuFilho->url)
                    <li>
                        <a href="#" style="color: #ccc">
                            <i class="{{ $menuFilho->icone }}"></i> {{ $menuFilho->descricao }}
                        </a>
                    </li>
                @endif
            @endforeach
        </ul>
    </li>
@endif
