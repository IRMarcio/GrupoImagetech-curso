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

  },
  methods: {
      /**
       * Dados de uma seção limpa.
       */
      secaoTemplate() {
          return {
              id: null,
              municipio: null,
              descricao: null,
              ativo: null
          }
      }

  }
});
