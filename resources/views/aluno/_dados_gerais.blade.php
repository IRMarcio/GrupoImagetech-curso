<div class="row">
    <div class="col-sm-6 col-md-3 col-lg-3">
        <div class="form-group">
            <label for="inscricao">Nome:</label>
            <input type="text" class="form-control" name="nome" value="{{ old('nome', isset($aluno) ? $aluno->nome : '') }}" required maxlength="255" {{ $aluno->nome ? 'readonly' : '' }}/>
        </div>
    </div>
    <div class="col-sm-4 col-md-4 col-lg-2">
        <div class="form-group">
            <label for="cpf">CPF:</label>
            <input autofocus type="text" class="form-control mask-cpf text-right" data-rule-cpf="true" name="cpf" value="{{ old('cpf', isset($aluno) ? $aluno->cpf : '') }}" required/>
        </div>
    </div>
    <div class="col-sm-4 col-md-4 col-lg-2">
        <div class="form-group">
            <label for="cpf">RG:</label>
            <input autofocus type="text" class="form-control  text-right"  name="rg" value="{{ old('rg', isset($aluno) ? $aluno->rg : '') }}" required/>
        </div>
    </div>
    <div class="col-sm-6 col-md-2 col-lg-2">
        <div class="form-group">
            <label for="tel_residencial">Telefone residencial</label>
            <input type="text" class="form-control mask-phone" name="telefone" value="{{ old('telefone', isset($aluno) ? $aluno->telefone : '') }}"/>
        </div>
    </div>
    <div class="col-sm-3 col-md-3 col-lg-2">
        <div class="form-group">
            <label>Data de Nascimento:</label>
            <input type="text" placeholder="dd/mm/aaaa" class="form-control input-datepicker mask-date" name="dt_nascimento" value="{{ old('dt_nascimento', isset($aluno) ? $aluno->dt_nascimento : '') }}">
        </div>
    </div>

</div>
