<div class="panel-content">
    <div class="panel-heading" style="    background: rgb(249, 249, 249);color: black;padding: 21px;">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
            <span aria-hidden="true" style="color: white">×</span>
        </button>
        <h4 class="modal-title">Listagem de Carga do Endere&ccedil;o || @{{ endereco.area }}-@{{ endereco.rua }}-@{{
            endereco.modulo }}-@{{ endereco.nivel }}-@{{ endereco.vao }}</h4>
    </div>
    <div class="panel-body">
        <div style="text-align: center" class="center-bock">
            <div class="col-lg-4"></div>
            <div class="col-lg-4" style="text-align: -webkit-center;border: 1px;border-style: inset;background: #f9f9f9;padding: 5px;">
                {!! QrCode::size(300)->generate($encode); !!}
                <p style="font-size: 10px;margin-top: 2px"> &Aacute;rea: @{{ endereco.area }}| Rua:  @{{ endereco.rua }}| M&oacute;dulo: @{{  endereco.modulo }}|
                    N&iacute;vel: @{{ endereco.nivel }}| V&atilde;o:@{{ endereco.vao }}</p>
            </div>
        </div>
    </div>
</div>

