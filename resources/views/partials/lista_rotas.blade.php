<div class="row">
    @forelse($rotas as $tipo => $lista)
        <div class="col-lg-12">
            <table class="table">
                <thead>
                <tr class="active">
                    <td colspan="2">
                        <span class="text-semibold">{{ $tipo }}</span>
                        <div class="pull-right">
                            <small>
                                <a class="permitir-todos" href="javascript:void(0);">
                                    <span>Selecionar todos</span>
                                </a>
                                <a style="margin-left: 10px;" class="desmarcar-todos" href="javascript:void(0);">
                                    <span>Desmarcar todos</span>
                                </a>
                            </small>
                        </div>
                    </td>
                </tr>
                </thead>
                <tbody>
                @foreach($lista as $permissao)
                    <tr>
                        <td width="1%">
                            <input type="checkbox" {{ in_array($permissao->id, $permissoes) ? 'checked' : '' }} name="rotas[]" value="{{ $permissao->id }}" class="styled" style="position: absolute;">
                        </td>
                        <td style="text-align: left;" width="99%">
                            {{ $permissao->descricao }}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @empty
        <div class="col-lg-12">
            <p>Nenhuma rota cadastrada para o sistema/módulo informado.</p>
        </div>
    @endforelse
</div>