@if(isset($requerimentoDashBoard))
    <div class="spin-icon-left-andamentos"
         style="color: {{isset($requerimentoDashBoard) ? !$requerimentoDashBoard['icon_requerimentos']: '#3f9e2a' ? '#3f9e2a':'#9e512a'}} !important;">
        <i class="fa fa-share-square-o" aria-hidden="true"></i>
    </div>
    <div class="theme-config-left">

        <div class="theme-config-box-left " id="andamentos">
            <div class="skin-settings-left">
                <section class="wrapperr">
                    <div class="row card_row">
                        <div class="column half_whole">
                            <article class="card box_panel">
                                <label class="card_label">
                                    REQUERIMENTOS
                                </label>
                                <section class="card_body">
                                    <h2 class="column h6 color_label">Requerimentos Recebidos</h2>
                                    <h1 class="column h6 color_label"><small>Solicitação de Carga</small></h1>
                                </section>
                                <section class="card_more">
                                    <div class="color_label card_more_content card_division">
                                        <a href="{{ route('pedidos.requerimento_index') }}" class="btn btn-block btn-default">Verificar Requerimento</a>
                                    </div>
                                    <a class="icon icon_after card_more_button button_soft"></a>
                                </section>
                                <section class="stats stats_row" style="margin-bottom: 10px">
                                    <div class="stats_item half_whole">
                                        <div class="txt_faded">
                                            <label class="txt_label space_n_b">
                                                Total/Req.
                                            </label>
                                            <div class="txt_serif stats_item_number txt_success"
                                                 style=" font-size: 16px;color: {{isset($requerimentoDashBoard['alterado']) ? in_array('total', $requerimentoDashBoard['alterado']) ? 'red': '': '' }}"
                                            >
                                                {{$requerimentoDashBoard['total']}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="stats_item half_whole">
                                        <div class="txt_faded">
                                            <label class="txt_label space_n_b">
                                                Enviados
                                            </label>
                                              <div class="txt_serif stats_item_number txt_success"
                                                 style=" font-size: 16px;color: {{isset($requerimentoDashBoard['alterado']) ? in_array('enviados', $requerimentoDashBoard['alterado']) ? 'red': '': '' }}"
                                            >
                                                {{$requerimentoDashBoard['enviados']}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="stats_item half_whole">
                                        <div class="txt_faded">
                                            <label class="txt_label space_n_b">
                                                Lidos
                                            </label>
                                            <div class="txt_serif stats_item_number txt_success"
                                                 style=" font-size: 16px;color: {{isset($requerimentoDashBoard['alterado']) ? in_array('lidos', $requerimentoDashBoard['alterado']) ? 'red': '': '' }}"
                                            >
                                                {{$requerimentoDashBoard['lidos']}}
                                            </div>
                                        </div>
                                    </div>
                                </section>

                                <section class="stats stats_row divider">
                                    <div class="stats_item half_whole">
                                        <div class="txt_faded">
                                            <label class="txt_label space_n_b">
                                                Finalizados
                                            </label>
                                            <div class="txt_serif stats_item_number txt_success"
                                                 style=" font-size: 16px;color: {{isset($requerimentoDashBoard['alterado']) ? in_array('finalizados', $requerimentoDashBoard['alterado']) ? 'red': '': '' }}"
                                            >
                                                {{$requerimentoDashBoard['finalizados']}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="stats_item half_whole">
                                        <div class="txt_faded">
                                            <label class="txt_label space_n_b">
                                                Parcial
                                            </label>
                                            <div class="txt_serif stats_item_number txt_success"
                                                 style=" font-size: 16px;color: {{isset($requerimentoDashBoard['alterado']) ? in_array('parcial', $requerimentoDashBoard['alterado']) ? 'red': '': '' }}"
                                            >
                                                {{$requerimentoDashBoard['parcial']}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="stats_item half_whole">
                                        <div class="txt_faded">
                                            <label class="txt_label space_n_b">
                                                Negados
                                            </label>
                                            <div class="txt_serif stats_item_number txt_success"
                                                 style=" font-size: 16px;color: {{isset($requerimentoDashBoard['alterado']) ? in_array('negados', $requerimentoDashBoard['alterado']) ? 'red': '': '' }}"
                                            >
                                                {{$requerimentoDashBoard['negados']}}
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
