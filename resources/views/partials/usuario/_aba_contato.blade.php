<div class="row">
    <div class="col-sm-6 col-md-2 col-lg-2">
        <div class="form-group">
            <label for="tel_residencial">Telefone residencial</label>
            <input type="text" class="form-control mask-phone" name="tel_residencial" value="{{ old('tel_residencial', isset($registro) ? $registro->tel_residencial : '') }}" />
        </div>
    </div>
    <div class="col-sm-6 col-md-2 col-lg-2">
        <div class="form-group">
            <label for="tel_celular">Telefone celular</label>
            <input type="text" class="form-control mask-phone" name="tel_celular" value="{{ old('tel_celular', isset($registro) ? $registro->tel_celular : '') }}" />
        </div>
    </div>
    <div class="col-sm-6 col-md-6 col-lg-6">
        <div class="form-group">
            <label for="email">E-mail</label>
            <input type="text" class="form-control mail" name="email" value="{{ old('email', isset($registro) ? $registro->email : '') }}" required maxlength="150"/>
        </div>
    </div>
</div>
