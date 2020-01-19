<table class="table table-striped" width="100%">
    <thead>
    <tr>
        <th>CATMAT</th>
        <th>Produto</th>
        <th>Fornecedor</th>
        <th>Controle/Lote</th>
        <th>Quantidade</th>
        <th>Validade</th>
        {{-- <th>Destino</th> --}}
    </tr>
    </thead>
    <tbody data-link="row" class="rowlink">
    @forelse($dados as $registro)
        <tr>
            <td>{{ $registro->catmat->codigo }}</td>
            <td>{{ $registro->catmat->descricao }}</td>
            <td>{{ $registro->produto_carga->fornecedor->nome_razao_social}}</td>
            <td>{{ $registro->relacao_produto_carga->controle_lote }}</td>
            <td>{{ $registro->quantidade }}</td>
            <td>{{ formatarData($registro->data_validade_lote) }}</td>
            {{-- <td> - </td> --}}
        </tr>
    @empty
        <tr>
            <td colspan="99">Nenhum registro encontrado.</td>
        </tr>
    @endforelse
    </tbody>
</table>
