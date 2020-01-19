<div class="row">
    <div class="col-sm-12 col-md-12 col-lg-12">
        <table class="table situacoes-usuario">
            <thead>
            <tr>
                <th>Situação</th>
                <th>Adicionada em</th>
            </tr>
            </thead>
            <tbody>
            @forelse($registro->situacoes as $situacao)
                <tr data-situacao-id="{{ $situacao->id }}">
                    <td>{{ $situacao->descricao }}</td>
                    <td>{{ formatarData($situacao->pivot->created_at, 'd/m/Y \à\s H:i') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="99">Nenhuma situação foi adicionada a este usuário.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>

