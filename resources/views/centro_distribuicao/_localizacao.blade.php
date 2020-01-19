<div class="row mb-4">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <div class="alert alert-info alert-styled-left text-blue-800 content-group">
            <span class="text-semibold">clique e arraste a Marca setado no Mapa para selecionar a posição correta do Centro de Distribuição. para auxiliar na localização.</span>
            <button type="button" class="close" data-dismiss="alert">×</button>
        </div>
                <div class="row container-fluid form-group">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="">Latitude</label>
                            <input type="text" id="lat" class="form-control" name="latitude" value="{{ old('cep', isset($centro_distribuicao->endereco) ? $centro_distribuicao->endereco->latitude : '') }}" maxlength="20">
{{--                            <input type="text" id="lat" class="form-control"/>--}}
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="">Longitude</label>
                            <input type="text" id="lng" class="form-control" name="longitude" value="{{ old('cep', isset($centro_distribuicao->endereco) ? $centro_distribuicao->endereco->longitude : '') }}" maxlength="20">
{{--                            <input type="text" id="lng" class="form-control"/>--}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body container-fluid" style="margin-bottom: 10px">
                @if(isset($map))
                    <div class="container-fluid">
                        <i class="fa fa-map"></i> Maps
                        {!! $map['html'] !!}
                    </div>
                @endif
                <div id="directionsDiv"></div>
            </div>
        </div>
    </div>
</div><!--row-->

