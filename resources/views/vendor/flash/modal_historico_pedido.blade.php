<div class="modal fade fadeInDown " id="historico-pedido-modal" tabindex="-1" role="dialog" style="margin-top: 200px !important;z-index: 2000 !important;    ">
    <div class="modal-xl center-block" role="document">
        <div class="modal-content">

            <div class="modal-header" style="    background: #273246;color: white;padding: 21px;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
                    <span aria-hidden="true" style="color: white">×</span>
                </button>
                <h4 class="modal-title">Histórico de Pedido</h4>
            </div>

            <div class="modal-body container-timeline" >
                <div id="timeline">
                    <div v-for="(historico, index) in historicos" class="timeline-item">
                        <div class="timeline-icon" :class="[historico.icon_color]">
                            <i class="fa fa-2x" :class="historico.icon" style="top: 10px;left: 10px"></i>
                        </div>
                        <div class="timeline-content" :class="historico.lado" >
                            <h2 :class="[historico.icon_color]" > @{{moment(historico.created_at,'YYYY-MM-DD h:m:s').format('DD/MM/YYYY h:m:s')  }} </h2>
                            <h5><span :class="[historico.icon_color]"> || @{{historico.descricao}}</span></h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

