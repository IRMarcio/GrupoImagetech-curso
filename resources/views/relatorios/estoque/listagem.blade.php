<table class="table table-striped" width="100%">
    <thead>
    <tr>
        <th width="13%">CATMAT</th>
        <th width="40%">Produto</th>
        <th width="20%">Fornecedor</th>
        <th width="10%">Quantidade</th>
        <th style="text-align: center">Lotes</th>
        <th>Validade</th>
        {{-- <th>Destino</th> --}}
    </tr>
    </thead>
    <tbody data-link="row" class="rowlink">
    @forelse($dados as $registro)

        @if($registro)
            <tr>
                <td>{{ isset($registro->catmat)?$registro->catmat->codigo : ''}}</td>
                <td>{{ isset($registro->catmat)? $registro->catmat->descricao : '' }}</td>
                <td>{{ isset($registro->produto_carga) ? $registro->produto_carga->fornecedor->nome_razao_social: ''}}</td>
                <td>{{ $registro->produto_carga->relacao_produto_carga->first()->getSomaQuantidadeMovimento() }}</td>
                <td>
                    <a id="ficha{{$registro->id}}" class="toggleQuestionTable btn btn-sm" href="#">
                        <i class="icon icon-presentation"></i>Lotes Descrição</a>
                </td>
                <td>{{ formatarData($registro->data_validade_lote) }}</td>
            </tr>
            <tr>
                <td colspan="99" class="container" style="padding: 0px;">
                    <table class="table table-striped  ficha{{$registro->id}}" width="100%"
                           style="display: none;background: #f2f3f5;">
                        <thead>
                        <tr>
                            <td>Quantidade do Lote</td>
                            <td>Data Validade</td>
                            <td>Tipo de Movimento</td>
                            <td>Data do Movimento</td>
                            <td style="text-align: center">Endereço Lote</td>
                        </tr>
                        </thead>
                        <tbody data-link="row" class="rowlink">
                        @foreach($registro->produto_carga->relacao_produto_carga->first()->estocagems as $end)

                            @if($end->estocagem_end_locacao)
                                @if(isset(request()->end_centro_id)  && (int)request()->end_centro_id === $end->estocagem_end_locacao->endereco->id)
                                    <tr style="background:rgba(120, 239, 0, 0.13);">
                                @else
                                    <tr style="background: #f2f3f5;">
                                        @endif

                                        <td>Total de : {{ $end->movimentacao->quantidade_movimento  }}</td>
                                        <td>{{ formatarData($end->movimentacao->data_validade_lote)}}</td>
                                        @if(isset($end->movimentacao->tipoMovimento))
                                            <td>{{ $end->movimentacao->tipoMovimento->descricao}}</td>
                                        @else
                                            <td> S/D </td>
                                        @endif
                                        <td>{{ formatarData($end->movimentacao->created_at)}}</td>
                                        <td style="text-align: center"><span
                                                    class="span-endereco">{{$end->estocagem_end_locacao->endereco->enderecoFormatado() }}</span>
                                        </td>
                                    </tr>
                                @endif
                                @endforeach
                        </tbody>
                    </table>
                </td>
            </tr>
        @endif
    @empty
        <tr>
            <td colspan="99">Nenhum registro encontrado.</td>
        </tr>
    @endforelse
    </tbody>
</table>
