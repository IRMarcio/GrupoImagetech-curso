<div class="row">
    @if($matriz)
        @include('centro_distribuicao._matriz')
    @else
        @if(isset($centro_distribuicao) && $centro_distribuicao->matriz === 1)
            <div class="alert alert-info alert-styled-left text-blue-800 content-group">
                <span class="text-semibold">Centro de Distribuição Matriz</span>
                <button type="button" class="close" data-dismiss="alert">×</button>
            </div>
        @else
            <div class="alert alert-info alert-styled-left text-blue-800 content-group">
                <span class="text-semibold">Centro de Distribuição Filial</span>
                <button type="button" class="close" data-dismiss="alert">×</button>
            </div>
        @endif

    @endif
</div>
