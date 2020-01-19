<div class="text-left pull-right">
    <div class="btn-group ">
        <a  href="javascript: {{$submit}}" class="btn btn-primary button-forms " >
            <i class="icon-database-check"></i>
            Salvar
        </a>
    </div>
    <a href="{{ route($voltar) }}" class="btn btn-default"><i
                class="icon-arrow-left5"></i> Voltar</a>
</div>
<input type="hidden" name="_token" value="{{ csrf_token() }}">