@foreach($menus as $menu)
    @if (count($menu->filhos) == 0)
        @can($menu->url)
            <li><a href="{{ route($menu->url) }}">{{ $menu->descricao }}</a></li>
        @endcan
    @else
        @if ($menu->tipo_menu == 'MEGA')
            @include('partials.menu.mega')
        @elseif ($menu->tipo_menu == 'SIMPLES')
            @include('partials.menu.simples')
        @endif
    @endif
@endforeach