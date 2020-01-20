<table class="table table-striped" width="100%">
    <thead>
    <tr>
        <th width="15%">Curso</th>
        <th width="10%">Período</th>
        <th width="10%">Data de Início</th>
        <th width="15%">Quantidade de Vagas</th>
        <th width="15%">Quantidade Ocupada</th>
        <th width="15%">Atualizado em</th>
    </tr>
    </thead>
    <tbody data-link="row" class="rowlink">

    @forelse($dados as $registro)
        <tr>

            <td>{{ $registro->curso->nome }}</td>
            <td>{{ $registro->periodo->descricao }}</td>
            <td>{{  formatarData($registro->data_inicio) }}</td>
            <td>{{ $registro->quantidade_vagas }}</td>
            <td>0</td>
            <td>
                {{ $registro->atualizado_em }}
            </td>


        </tr>
    @empty
        <tr>
            <td colspan="99">Nenhum registro encontrado.</td>
        </tr>
    @endforelse
    </tbody>
</table>
