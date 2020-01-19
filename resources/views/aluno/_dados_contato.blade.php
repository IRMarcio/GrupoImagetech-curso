<div class="row">
    <div class="col-sm-8 col-md-6 col-lg-4">
        <div class="form-group">
            <label>Contato:</label>
            <input type="text" class="form-control" name="contato" value="{{ old('contato', isset($aluno) ? $aluno->contato : '') }}" required maxlength="200">
        </div>
    </div>
    <div class="col-sm-6 col-md-2 col-lg-2">
        <div class="form-group">
            <label for="telefone">Telefone</label>
            <input type="text" class="form-control mask-phone" name="telefone" value="{{ old('telefone', isset($aluno) ? $aluno->telefone : '') }}"/>
        </div>
    </div>
    <div class="col-sm-6 col-md-2 col-lg-2">
        <div class="form-group">
            <label for="fax">Fax</label>
            <input type="text" class="form-control mask-phone" name="fax" value="{{ old('fax', isset($aluno) ? $aluno->fax : '') }}"/>
        </div>
    </div>
    <div class="col-sm-6 col-md-8 col-lg-4">
        <div class="form-group">
            <label for="email">E-mail</label>
            <input type="text" class="form-control"  name="email" value="{{ old('email', isset($aluno) ? $aluno->email : '') }}" maxlength="150"/>
        </div>
    </div>
</div>
