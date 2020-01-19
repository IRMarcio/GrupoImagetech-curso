<div class="col-lg-12" style="align-items: center">
    <input type="hidden" name="id" value="{{ isset($endereco)?$endereco->id: '' }}">
    <input type="hidden" name="url" value="{{ url()->previous() }}">
    <input type="hidden" name="acao" :value="acao">
    <input type="hidden" name="createIn" :value="createIn">
    <div class="col-lg-10">
        <div class="row">


        </div>
        <div class="col-lg-12">
            <fieldset class="content-group">
                <div class="card">
                    <div class="card-header">
                        Adicionar Endere&ccedil;o de Aloca&ccedil;&atilde;o no centro de distribui&ccedil;&atilde;o
                    </div>
                    <div class="card-body">
                        <blockquote class="blockquote mb-0">

                            <p></p>
                            <table class="table table-striped" id="_endereco">
                                <thead>
                                <tr>
                                    <th colspan="3">Selecione de acordo com as novas atribuições de alocação</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>&Aacute;rea</td>
                                    <td>Entre com a quantidade de</td>
                                    <td>
                                        <a @click="_reset('area')" href="#dados-area" data-toggle="tab"
                                           class="btn btn-default btn-xs btn-block"><span
                                                    class="span-adicionar-p">áreas->ruas->modulos->niveis->vão</span></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Rua</td>
                                    <td>Selecione a Área para entrar com a quantidade de</td>
                                    <td><a @click="_reset('rua')" href="#dados-rua" data-toggle="tab"
                                           class="btn btn-default btn-xs btn-block"><span
                                                    class="span-adicionar-p">ruas->modulos->niveis->vão</span> </a></td>
                                </tr>
                                <tr>
                                    <td>M&oacute;dulos</td>
                                    <td>Selecione a Área e Rua para entrar com a quantidade de</td>
                                    <td><a @click="_reset('modulo')" href="#dados-modulo" data-toggle="tab"
                                           class="btn btn-default btn-xs btn-block"><span
                                                    class="span-adicionar-p">modulos->niveis->vão</span></a></td>
                                </tr>
                                <tr>
                                    <td>N&iacute;veis</td>
                                    <td>Selecione a Área e Rua o Módulo para entrar com a quantidade de</td>
                                    <td><a @click="_reset('nivel')" href="#dados-nivel" data-toggle="tab"
                                           class="btn btn-default btn-xs btn-block"><span
                                                    class="span-adicionar-p">niveis->vão</span></a></td>
                                </tr>
                                <tr>
                                    <td>Vão</td>
                                    <td>Selecione a Área e Rua o Módulo e Nível para entrar com a quantidade de</td>
                                    <td><a @click="_reset('vao')" href="#dados-vao" data-toggle="tab"
                                           class="btn btn-default btn-xs btn-block"><span
                                                    class="span-adicionar-p">vão</span></a></td>
                                </tr>
                                </tbody>
                            </table>

                            <footer class="blockquote-footer" style="background-color: rgba(128, 113, 110, 0.129412);">
                                Estrutura de cadastro de
                                <cite title="Source Title"> ALOCA&Ccedil;&Otilde;ES.</cite></footer>
                        </blockquote>
                    </div>
                </div>


            </fieldset>
        </div>
    </div>
    <div class="col-lg-2" style="text-align: center; padding-top: 80px">
        <button type="button" @click="showImage('img/mapa_estrutura.png')">
            <small>Estrutura Organizacional</small>
            <img src="{{ asset('img/mapa_estrutura.png') }}" alt="" width="150" height="100">
            <small>clique na imagem para visualizar</small>
        </button>
    </div>

</div>

