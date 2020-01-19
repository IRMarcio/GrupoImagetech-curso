<div class="row">
    <div class="col-sm-6 col-md-2 col-lg-2">
        <div class="form-group">
            <label for="telefone">Telefone</label>
            <input type="text" class="form-control mask-phone" name="telefone" value="{{ old('telefone', isset($unidade) ? $unidade->telefone : '') }}"/>
        </div>
    </div>
    <div class="col-sm-6 col-md-2 col-lg-2">
        <div class="form-group">
            <label for="fax">Fax</label>
            <input type="text" class="form-control mask-phone" name="fax" value="{{ old('fax', isset($unidade) ? $unidade->fax : '') }}"/>
        </div>
    </div>
    <div class="col-sm-6 col-md-8 col-lg-8">
        <div class="form-group">
            <label for="email">E-mail</label>
            <input type="text" class="form-control mail" name="email" value="{{ old('email', isset($unidade) ? $unidade->email : '') }}" maxlength="150"/>
        </div>
    </div>
</div>
