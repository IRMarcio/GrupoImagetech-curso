<div class="row">
    <div class="col-sm-6 col-md-2 col-lg-2">
        <div class="form-group">
            <label for="telefone">Telefone</label>
            <input type="text" class="form-control mask-phone" name="telefone" value="{{ old('telefone', isset($centro_distribuicao->endereco) ? $centro_distribuicao->endereco->telefone : '') }}"/>
        </div>
    </div>
    <div class="col-sm-6 col-md-2 col-lg-2">
        <div class="form-group">
            <label for="fax">Fax</label>
            <input type="text" class="form-control mask-phone" name="fax" value="{{ old('fax', isset($centro_distribuicao->endereco) ? $centro_distribuicao->endereco->fax : '') }}"/>
        </div>
    </div>
    <div class="col-sm-6 col-md-8 col-lg-8">
        <div class="form-group">
            <label for="email">E-mail</label>
            <input type="text" class="form-control mail" name="email" value="{{ old('email', isset($centro_distribuicao->endereco) ? $centro_distribuicao->endereco->email : '') }}" maxlength="150"/>
        </div>
    </div>
</div>
