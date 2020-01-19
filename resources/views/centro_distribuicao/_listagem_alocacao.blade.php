@include('vendor.flash.modal_alocacao')

@forelse($endereco_fisico as $key =>  $registro)

    @foreach($registro->sortKeys() as $k => $value)
        <div class="row">
            <div class="col-lg-12" style="text-align: center;margin-bottom: 15px !important;">
                <div class="col-lg-12"
                     style="text-align: -webkit-center;font-size: x-large;background: #273246;border: 2px;border-style: groove;border-radius: 10px;margin-top: 15px">
                    <div class="col-lg-12">
                        <label for="" class="modulo-padrao"> &Aacute;rea {{$key}} | Rua {{$k}}</label>
                    </div>

                </div>

                <div class="col-lg-6">
                    @foreach($value->sortKeys() as $ky => $val)
                        @if((int)$ky % 2)
                            <div class="col-lg-12">
                                <label for="" class="modulo-padrao modulo-area"> M&oacute;dulo || {{$ky}}</label>
                            </div>
                            <div class="col-lg-12">
                                <table class="table table-xs table-bordered">
                                    <thead>
                                    <tr>
                                        <th colspan="2"><span style="font-size: 10px"><small>N&iacute;vel</small> </span>
                                            ||
                                            Endere&ccedil;o
                                        </th>
                                        <th>Status</th>
                                        <th>Carga</th>
                                        <th>Capacidade</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach($val->sortKeys() as  $reg)
                                        @foreach($reg->sortKeys() as  $registro)

                                            <tr>
                                                <td width="5%">{{ $registro->nivel }}</td>
                                                <td width="30%">
                                                    <a href="{{ route('centro_distribuicao.alterar.endereco', $registro) }}">{{ $registro->area }}.{{ $registro->rua }}.{{ $registro->modulo }}.{{ $registro->nivel }}.{{ $registro->vao }}</a>
                                                </td>
                                                <td style="text-align: center">
                                                    <button @click="show({{ $registro }})" type="button"
                                                            class=" btn btn-xs btn-link" style="padding: 0px">
                                    <span
                                            class="{{ !$registro->carga->isNotEmpty() ? "Livre" : "Ocupado"  }}">
                                        {{ !$registro->carga->isNotEmpty() ? "Livre" : "Ocupado" }}
                                    </span>
                                                    </button>

                                                </td>
                                                <td width="25%"> {{  $registro->carga->isNotEmpty() ?$registro->getSomaQuantidadeCarga():0}}</td>
                                                <td>
                                                    {{$registro->quantidade_produto}}
                                                </td>
                                            </tr>

                                        @endforeach
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    @endforeach
                </div>
                <div class="col-lg-6">
                    @foreach($value->sortKeys() as $ky => $val)
                        @if(!((int)$ky % 2))
                            <div class="col-lg-12">
                                <label for="" class="modulo-padrao modulo-area"> M&oacute;dulo || {{$ky}}</label>
                            </div>
                            <div class="col-lg-12">
                                <table class="table table-xs table-bordered">
                                    <thead>
                                    <tr>
                                        <th colspan="2"><span style="font-size: 10px"><small>N&iacute;vel</small> </span>
                                            ||
                                            Endere&ccedil;o
                                        </th>
                                        <th>Status</th>
                                        <th>Carga</th>
                                        <th>Capacidade</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach($val->sortKeys() as  $reg)
                                        @foreach($reg->sortKeys() as  $registro)

                                            <tr>
                                                <td width="5%">{{ $registro->nivel }}</td>
                                                <td width="30%">
                                                    <a href="{{ route('centro_distribuicao.alterar.endereco', $registro) }}">{{ $registro->area }}.{{ $registro->rua }}.{{ $registro->modulo }}.{{ $registro->nivel }}.{{ $registro->vao }}</a>
                                                </td>
                                                <td style="text-align: center">
                                                    <button @click="show({{ $registro }})" type="button"
                                                            class=" btn btn-xs btn-link" style="padding: 0px">
                                    <span
                                            class="{{ !$registro->carga->isNotEmpty() ? "Livre" : "Ocupado"  }}">
                                        {{ !$registro->carga->isNotEmpty() ? "Livre" : "Ocupado" }}
                                    </span>
                                                    </button>

                                                </td>
                                                <td width="25%"> {{  $registro->carga->isNotEmpty() ?$registro->getSomaQuantidadeCarga():0}}</td>
                                                <td>
                                                    {{$registro->quantidade_produto}}
                                                </td>
                                            </tr>

                                        @endforeach
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    @endforeach
                </div>

            </div>
        </div>
    @endforeach
@empty
    <div>Nada a Declarar</div>
@endforelse

