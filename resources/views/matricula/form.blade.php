<div class="row">
    <div class="col-lg-12">
        <div class="col-lg-6">
            <fieldset class="content-group">
                <legend class="text-bold">Selecione o Aluno para Matrícula</legend>

                <div class="panel panel-default">
                    <div class="panel-body">Matrícula</div>
                    <div class="form-group container-fluid">
                        <label>Aluno:</label>
                        <select v-model="alunos_id" name="alunos_id" class="form-control alunos" required>
                            <option value=""></option>
                            @foreach($alunos as $aluno)
                                <option value="{{ $aluno->id }}" {{ isset($matricula) ? $matricula->alunos_id == $aluno->id ? "selected":'':'' }} > {{ $aluno->nome }} </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </fieldset>
        </div>
        <div class="col-lg 6">
            <fieldset class="content-group">
                <legend class="text-bold">Selecione o Curso para Matrícula do Aluno</legend>

                <div class="panel panel-default">
                    <div class="panel-body">Curso Disponíveis</div>
                    <div class="form-group container-fluid">

                        <div class="col-lg-8">
                            <label>Curso:</label>
                            <select v-model="centro_cursos_id" name="centro_cursos_id" class="form-control " required>
                                <option value=""></option>
                                @foreach($centroCursos as $centroCurso)
                                    <option value="{{ $centroCurso->id }}" {{ isset($matricula) ? $matricula->centro_cursos_id ? "selected":'':'' }} >
                                        {{ $centroCurso->curso->nome . ' - { ' .  $centroCurso->periodo->descricao . ' } - Turma: ' . formatarDataAno($centroCurso->data_inicio)  }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-lg-4">
                            <label>Status:</label>
                            <select name="status" class="form-control " required>
                                <option value=""></option>
                                @foreach($statusAll as $key => $status)
                                    <option value="{{ $key }}" {{ isset($matricula) ? $matricula->status == $key? "selected":'':'' }} >
                                        {{ $status }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </fieldset>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="col-lg-12">
            <fieldset class="content-group">
                <legend class="text-bold">Painel de Informação do aluno:</legend>
                <div class="col-lg-6">
                    <div class="panel panel-default">
                        <div class="panel-body">Dados Pessoais</div>
                        <div class="form-group container-fluid" v-for="item in aluno" :key="item">
                            <div class="col-lg-12">
                                <div class="col-lg-6">
                                    <p>Nome: @{{ item.nome }}</p>
                                    <p>Telefone: @{{ item.telefone }}</p>

                                </div>
                                <div class="col-lg-6">
                                    <p>Cpf: @{{ item.cpf }}</p>
                                    <p>Email: @{{ item.email }}</p>
                                </div>
                            </div>
                            <table width="100%">
                                <td style="background-color: #b3c6e5;padding: 10px;font-size: 16px;color: white;text-align: center">
                                    @{{ ativo ? 'Aluno Ativo' : 'Aluno Inativo' }}
                                </td>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <table class="table table-bordered table-striped" width="100%">
                        <thead>
                        <tr>
                            <th colspan="3" style="padding: 6px">Dados dos Curso do Aluno Matriculados</th>
                        </tr>
                        <tr>
                            <th>Curso</th>
                            <th>Turma</th>
                            <th>Período</th>
                        </tr>
                        </thead>
                        <tbody v-for="subitem in cursos" :key="subitem.id">

                            <tr v-for="itens in subitem.centro_cursos" :key="itens.id">
                            <td>@{{ itens.curso.nome}}</td>
                            <td>@{{ moment(itens.data_inicio, 'YYYY').format('YYYY') }}</td>
                            <td>@{{ itens.periodo.descricao }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </fieldset>
        </div>
    </div>
</div>

@include('partials.forms.botao_salvar', ['voltar' => 'matricula.index'])
