<div class="page-title">
    <h4>@yield('titulo_pagina')</h4>
    <a class="heading-elements-toggle"><i class="icon-more"></i></a>
</div>

<div class="heading-elements">
    <ul class="breadcrumb heading-text">
        <li><a href="{{ route('dashboard') }}"><i class="icon-home2 position-left"></i> Dashboard</a></li>
        @yield('breadcrumbs')
    </ul>
</div>