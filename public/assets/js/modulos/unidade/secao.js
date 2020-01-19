Vue.component('secao', {
  props: ['secoes', 'unidade'],
  data() {
      return {
          secoes: [],
          secao: {},
          acao: 'adicionar',
          index: null,
          acaoEmExecucao: false,
      }
  },
  beforeMount() {
      this.secao = this.secaoTemplate();
  },
  mounted() {
      this.limparFormulario();
  },
  methods: {
      /**
       * Dados de uma seção limpa.
       */
      secaoTemplate() {
          return {
              id: null,
              descricao: null,
              ativo: null
          }
      },

      /**
       * Salva os dados de uma seção.
       */
      salvar() {
          if (this.acao == 'adicionar') {
              this.adicionar();
          } else {
              this.alterar();
          }
      },

      /**
       * Adiciona uma nova seção.
       */
      adicionar() {
          if (!this.validar()) {
              return;
          }

          // Adiciona seção
          this.acaoEmExecucao = true;
          this.$http.post(constants.SITE_PATH + '/unidades/secoes/salvar/' + this.unidade.slug_id, {
              descricao: this.secao.descricao,
              ativo: this.secao.ativo,
          }).then((response) => {
              Notifica.sucesso('Seção adicionada com sucesso!');

              // Adiciona a seção
              this.secoes.push(response.body.data);
              this.limparFormulario();
          }).catch((e) => {
              var body = e.body;
              var mensagem = 'Houve um erro ao adicionar a seção, contate o suporte técnico.';

              if (body.data && body.data.errors) {
                  var erros = body.data.errors.join('<br>');
                  Notifica.erro(erros, 'Atenção');
                  return false;
              }
              ;
          }).then(() => {
              this.acaoEmExecucao = false;
          });
      },

      /**
       * Valida os dados da seção.
       *
       * @returns {boolean}
       */
      validar() {
          var valido = true, 
              campos = [
                  'descricao', 
                  'ativo', 
              ];

          for (let propriedade in this.secao) {
              if (campos.indexOf(propriedade) != -1) {
                  if (this.secao[propriedade] === '' || this.secao[propriedade] === null) {
                      valido = false;
                  }
              }
          }

          if (!valido) {
              Notifica.erro('Preencha todos os campos.', 'Campos obrigatórios!');
              return false;
          }

          return valido;
      },

      /**
       * Limpa os dados do formulario de seção.
       */
      limparFormulario() {
          this.secao.descricao = null;
          this.secao.ativo = null;

          this.acao = 'adicionar';
          this.index = null;
          this.secao = this.secaoTemplate();
      },

      /**
       * Prepara uma seção para ser editada.
       *
       * @param index
       */
      editar(secao, index) {
          if (secao.id) {
              this.secao = secao;
          } else {
              this.secao = $.extend(secao, {});
          }


          this.acao = 'alterar';
          this.index = index;
      },

      /**
       * Altera os dados de uma seção.
       * @returns {boolean}
       */
      alterar() {
          if (!this.validar()) {
              return false;
          }

          // Altera seção
          this.acaoEmExecucao = true;
          this.$http.post(constants.SITE_PATH + '/unidades/secoes/atualizar/' + this.secao.slug_id, {
              descricao: this.secao.descricao,
              ativo: this.secao.ativo,
          }).then((response) => {
              Notifica.sucesso('Seção alterada com sucesso!');

              var secao = response.body.data;
              this.secoes.splice(this.index, 1, secao);
              this.limparFormulario();
          }).catch((e) => {
              var body = e.body;
              var mensagem = 'Houve um erro ao alterar a seção, contate o suporte técnico.';

              if (body.data && body.data.errors) {
                  var erros = body.data.errors.join('<br>');
                  Notifica.erro(erros, 'Atenção');
                  return false;
              }
              ;
          }).then(() => {
              this.acaoEmExecucao = false;
          });
      },

      /**
       * Verifica se é possível excluir a seção.
       * @param secao
       * @param callback
       */
      validarExclusao(secao, callback) {
          var url = constants.SITE_PATH + '/unidades/secoes/validar-exclusao';
          if (!secao.id) {
              callback();
              return;
          }

          // Verifica se existe alguma movimentação na seção
          this.$http.post(url, {secao_id: secao.id}).then(response => {
              if (response.body.data === false) {
                  Notifica.erro('Seção não pode ser removida, pois a mesma já possui movimentações ou produtos no estoque.', 'Validação');
                  return;
              }

              callback();
          });
      },

      /**
       * Exclui uma seção.
       *
       * @param secao
       */
      excluir(secao) {
          // Valida se exclusão é possível
          this.validarExclusao(secao, () => {
              this.acaoEmExecucao = true;
              this.$http.post(constants.SITE_PATH + '/unidades/secoes/excluir/' + secao.slug_id).then((response) => {
                  Notifica.sucesso('Seção excluída com sucesso!');

                  if (this.index) {
                      this.limparFormulario();
                  }

                  this.secoes.splice(this.secoes.indexOf(secao), 1);
              }).catch((e) => {
                  var body = e.body;
                  var mensagem = 'Houve um erro ao excluir a seção, contate o suporte técnico.';

                  if (body.data && body.data.errors) {
                      var erros = body.data.errors.join('<br>');
                      Notifica.erro(erros, 'Atenção');
                      return false;
                  }
                  ;
              }).then(() => {
                  this.acaoEmExecucao = false;
              });
          });
      },
  }
});
