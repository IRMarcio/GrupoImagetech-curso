@if(isset($logisticaExpedicao))
    <div class="theme-config">
        <div class="theme-config-box {{ $logisticaExpedicao['icon']?  $mostrar == true ? 'show':'': '' }}">
            <div class="spin-icon" style="color: {{!$logisticaExpedicao['icon'] ? '#3f9e2a':'#9e512a'}} !important;">
                <i class="fa fa-exchange" aria-hidden="true"></i>
            </div>

            <div class="skin-settings">
                <div class="title">Insumos Geral<br>
                    <small style="text-transform: none;font-weight: 400">
                        Sistema de Controle de Insumos Logística/Expedição
                    </small>
                </div>
                <div class="setings-item" style="padding: 5px !important;"></div>
                <div class="title">Logística</div>
                <div class="setings-item">
                    <span>
                        Recebimentos de Insumos
                    </span>
                    <div class="switch">

                        @if($logisticaExpedicao['recebimento_insumos'][0] > 0 )
                            <a href="{{ route('entrada_medicamentos.index') }}">
                                <i class="fa fa-arrow-right icon-left-bar" style="color: yellow"></i>
                            </a>
                        @endif
                        <span> Aguardando: {{ $logisticaExpedicao['recebimento_insumos'][0] }} <br>
                        Encamihados:  {{$logisticaExpedicao['recebimento_insumos'][1]}}</span>
                    </div>
                </div>
                <div class="setings-item">
                    <span>
                        Previsão de Entrega
                    </span>

                    <div class="switch">
                        <div class="onoffswitch">
                            <span> Andamento: {{ $logisticaExpedicao['previsao_entrega'] }}</span>
                        </div>
                    </div>
                </div>
                <div class="setings-item">
                    <span>
                        Controle de Portaria
                    </span>

                    <div class="switch">
                        <div class="onoffswitch">
                            @if($logisticaExpedicao['controle_portaria'] > 0)
                                <a href="{{ route('controle_portaria.index') }}">
                                    <i class="fa fa-arrow-right icon-left-bar pendente"></i>
                                </a>
                            @endif
                            <span> Pendente: {{ $logisticaExpedicao['controle_portaria'] }}</span>
                        </div>
                    </div>
                </div>
                <div class="setings-item">
                    <span>
                        Inspeção Triagen
                    </span>

                    <div class="switch">
                        <div class="onoffswitch">
                            @if($logisticaExpedicao['inspecao_triagem'] > 0)
                                <a href="{{ route('inspecao_triagem.index') }}">
                                    <i class="fa fa-arrow-right icon-left-bar pendente"></i>
                                </a>
                            @endif
                            <span> Pendente: {{ $logisticaExpedicao['inspecao_triagem'] }}</span>
                        </div>
                    </div>
                </div>
                <div class="setings-item">
                    <span>
                        Estocagem
                    </span>

                    <div class="switch">
                        <div class="onoffswitch">
                            @if($logisticaExpedicao['estocagem'] > 0)
                                <a href="{{ route('estocagem.index') }}">
                                    <i class="fa fa-arrow-right icon-left-bar pendente"></i>
                                </a>
                            @endif
                            <span> Pendente: {{ $logisticaExpedicao['estocagem'] }}</span>
                        </div>
                    </div>
                </div>
                <div class="setings-item" style="padding: 5px !important;margin-bottom: 10px"></div>
                <div class="title">Expedição</div>
                <div class="setings-item">
                    <span>
                        Conhecimento de Embarque
                    </span>


                    <div class="switch">
                        @if($logisticaExpedicao['conhecimento_embarque'] [0] > 0)
                            <a href="{{ route('conhecimento_embarque.index') }}">
                                <i class="fa fa-arrow-right icon-left-bar" style="color: yellow"></i>
                            </a>
                        @endif
                        <span> Total Embarques: {{ $logisticaExpedicao['conhecimento_embarque'] [0]}} <br>
                        Encaminhados:  {{ $logisticaExpedicao['conhecimento_embarque'] [1]}}
                        </span>
                    </div>
                </div>
                <div class="setings-item">
                    <span>
                        Nota de Despacho
                    </span>

                    <div class="switch">
                        @if($logisticaExpedicao['nota_despacho'] > 0 )
                            <a href="{{ route('nota_despacho.index') }}">
                                <i class="fa fa-arrow-right icon-left-bar pendente"></i>
                            </a>
                        @endif
                        <span> Pendente: {{ $logisticaExpedicao['nota_despacho'] }}</span>
                    </div>
                </div>

                <div class="setings-item">
                    <span>
                        Lista de Embalagens
                    </span>

                    <div class="switch">
                        @if($logisticaExpedicao['lista_embalagens'] > 0 )
                            <a href="{{ route('lista_embalagens.index') }}">
                                <i class="fa fa-arrow-right icon-left-bar pendente"></i>
                            </a>
                        @endif
                        <span> Pendente: {{ $logisticaExpedicao['lista_embalagens'] }}</span>
                    </div>
                </div>
                <div class="setings-item">
                    <span>
                        Expedição
                    </span>

                    <div class="switch">
                        @if($logisticaExpedicao['expedicao'] > 0 )
                            <a href="{{ route('expedicao.index') }}">
                                <i class="fa fa-arrow-right icon-left-bar pendente"></i>
                            </a>
                        @endif
                        <span> Pendente: {{ $logisticaExpedicao['expedicao'] }}</span>
                    </div>
                </div>
                <div class="setings-item" style="margin-bottom: 10px">
                    <span>
                        Manifesto de Expedição
                    </span>

                    <div class="switch">
                        @if($logisticaExpedicao['manifesto_expedicao'] > 0 )
                            <a href="{{ route('manifesto_expedicao.index') }}">
                                <i class="fa fa-arrow-right icon-left-bar pendente"></i>
                            </a>
                        @endif
                        <span> Pendente: {{ $logisticaExpedicao['manifesto_expedicao'] }}</span>
                    </div>
                </div>
                <div class="setings-item" style="padding: 5px !important;margin-bottom: 10px"></div>
            </div>

        </div>
    </div>
@endif
