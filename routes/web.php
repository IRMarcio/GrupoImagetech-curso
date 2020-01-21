<?php

use Illuminate\Support\Facades\Route;


/**
 * @see Base Rotas sem Autenticação
 * @since  Rotas Atuais -> [@internal]
 * @internal    (dashboard),(broadcasting/auth), (aceite_termos_uso), (login), (bloquear-tela)
 * @internal   (visualizar/{arquivo}/{usuarioId?}), (esqueci), (selecionar/buscar-perfis)
 **/
incluirRotaDireta("_base_rotas_geral.php");


Route::group(['middleware' => ['web', 'logado', 'unidade-ativa', 'descobrir-centro-distribuicao']], function () {

    /**
     * @see DashBoard Rotas Iniciais
     * @since  Rotas Atuais -> [@internal]
     * @internal   (Selecionar Unidade), (Usuario Alterar Perfil), (Usuario Alterar Senha)
     **/
    incluirRotaDireta("_dashboard.php");


    /**
     * @see Configurações/Auditoria
     * @since  Rotas Atuais -> [@internal]
     * @internal   (Configurações), (Auditoria)
     **/
    incluirRotaDireta("_configuracoes.php");

    /**
     * @see Crudes Dependencias
     * @since  Rotas Atuais -> [@internal]
     * @internal   (Veículos), (Motoristas), (Endereçamentos), (CatMat), (Estados),
     * @internal   (Tipo de Produtos), (Municípios), (Transportadoras), (Fornecedores)
     * @internal   (Entrada de Produtos), (Perfil(s))
     **/
    incluirRotaDireta("_crude_dependencias.php");

    /**
     * @see Usuários
     * @since  Rotas Atuais -> [@internal]
     * @internal   (Usuários), (Perfil(s)), (Usuario/Perfis), (Permissões)
     **/
    incluirRotaDireta("_usuarios.php");

    /**
     * @see  Unidades
     * @since Rotas Atuais -> [@internal]
     * @internal (Unidades), (Unidades/Secoes)
     * */
    incluirRotaDireta("_unidades.php");

    /**
     * @see  Centro de Distribuição
     * @since Rotas Atuais -> [@internal]
     * @internal (Centro Distribição), (Endereçamento de Cargas)
     * */
    incluirRotaDireta("_centro_distribuicao.php");

    /**
     * @see  Alunos
     * @since Rotas Atuais -> [@internal]
     * @internal (Alunos)
     * */
    incluirRotaDireta("_aluno.php");

    /**
     * @see  Tipo de Períodos
     * @since Rotas Atuais -> [@internal]
     * @internal (tipos de Períodos)
     * */
    incluirRotaDireta("_tipo_periodo.php");

    /**
     * @see  Cursos
     * @since Rotas Atuais -> [@internal]
     * @internal (Cursos)
     * */
    incluirRotaDireta("_curso.php");

    /**
     * @see  Matrículas
     * @since Rotas Atuais -> [@internal]
     * @internal (Matrículas)
     * */
    incluirRotaDireta("_matricula.php");

    /**
     * @see  Centro Cursos - add Curso para Centro de Distribuição Estudantil
     * @since Rotas Atuais -> [@internal]
     * @internal (Centro Cursos)
     * */
    incluirRotaDireta("_centro_curso.php");


});
