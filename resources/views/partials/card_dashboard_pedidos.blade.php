@if(isset($pedidosDashBoard))
    <div class="spin-icon-left-pedidos" style="color: {{isset($pedidosDashBoard) ? !$pedidosDashBoard['icon_pedido']:'#3f9e2a' ? '#3f9e2a':'#9e512a'}} !important;">
        <i class="fa fa-reply" aria-hidden="true"></i>
    </div>
    <div class="theme-config-left">
        <div class="theme-config-box-left" id="pedidos">
            <div class="skin-settings-left">
                <section class="wrapperr">
                    <div class="row card_row">
                        <div class="column half_whole">
                            <article class="card box_panel">
                                <div class="">
                                    <h1 class="column h6 color_label">Pedidos</h1>
                                </div>
                                <section class="card_body">
                                    <h1 class="column h6 color_label">Solicitações de Carga</h1>
                                </section>
                                <section class="card_more">
                                    <div class="color_label card_more_content card_division">
                                        <a href="{{ route('pedidos.index') }}" class="btn btn-block btn-default">Verificar Pedidos</a>
                                    </div>
                                    <a class="icon icon_after card_more_button button_soft"></a>
                                </section>
                                <section class="stats stats_row">
                                    <div class="stats_item half_whole small_whole">
                                        <div class="txt_faded">
                                            <label class="txt_label space_n_b">
                                                Total
                                            </label>
                                            <div class="txt_serif stats_item_number txt_success"
                                                 style=" font-size: 16px;color: {{isset($pedidosDashBoard['alterado']) ? in_array('total', $pedidosDashBoard['alterado']) ? 'red': '': '' }}"
                                            >
                                                {{$pedidosDashBoard['total']}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="stats_item half_whole">
                                        <div class="txt_faded">
                                            <label class="txt_label space_n_b">
                                                Andamento
                                            </label>
                                            <div class="txt_serif stats_item_number txt_error"
                                                 style=" font-size: 16px;color: {{isset($pedidosDashBoard['alterado']) ?in_array('andamento', $pedidosDashBoard['alterado']) ? 'red': '':''  }}"
                                            >
                                                {{$pedidosDashBoard['andamento']}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="stats_item half_whole">
                                        <div class="txt_faded">
                                            <label class="txt_label space_n_b">
                                                Recusados
                                            </label>
                                            <div class="txt_serif stats_item_number txt_error"
                                                 style=" font-size: 16px;color: {{isset($pedidosDashBoard['alterado']) ? in_array('recusados', $pedidosDashBoard['alterado']) ? 'red': '': '' }}"
                                            >
                                                {{$pedidosDashBoard['recusados']}}
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            </article>
                        </div>
                        <div class="column half_whole">
                            <article class="card box_panel">
                                <label class="card_label">
                                    <h1 class="column h6 color_label">Encaminhados</h1>
                                </label>
                                <section class="card_body">
                                    <h1 class="column h6 color_label">Solicitações</h1>
                                </section>
                                <section class="card_more">
                                    <div class="color_label card_more_content card_division">
                                        <a href="{{ route('pedidos.index') }}" class="btn btn-block btn-warning">Verificar Encaminhados</a>
                                    </div>
                                    <a class="icon icon_after card_more_button button_soft">
                                    </a>
                                </section>
                                <section class="stats stats_row">
                                    <div class="stats_item half_whole">
                                        <div class="txt_faded">
                                            <label class="txt_label space_n_b">
                                                Total
                                            </label>
                                            <div class="txt_serif stats_item_number txt_success"
                                                 style=" font-size: 16px;color: {{isset($pedidosDashBoard['alterado']) ? in_array('encaminhados', $pedidosDashBoard['alterado']) ? 'red': '':''  }}"
                                            >
                                                {{$pedidosDashBoard['encaminhados']}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="stats_item half_whole">
                                        <div class="txt_faded">
                                            <label class="txt_label space_n_b">
                                                Lidas
                                            </label>
                                            <div class="txt_serif stats_item_number txt_error"
                                                 style=" font-size: 16px;color: {{isset($pedidosDashBoard['alterado']) ?in_array('encaminhados_lidos', $pedidosDashBoard['alterado']) ? 'red': '':''  }}"
                                            >
                                                {{$pedidosDashBoard['encaminhados_lidos']}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="stats_item half_whole">
                                        <div class="txt_faded">
                                            <label class="txt_label space_n_b">
                                                Recusados
                                            </label>
                                            <div class="txt_serif stats_item_number txt_error"
                                                 style=" font-size: 16px;color: {{isset($pedidosDashBoard['alterado']) ?in_array('encaminhados_recusados', $pedidosDashBoard['alterado']) ? 'red': '': '' }}"
                                            >
                                                {{$pedidosDashBoard['encaminhados_recusados']}}
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            </article>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
@endif
