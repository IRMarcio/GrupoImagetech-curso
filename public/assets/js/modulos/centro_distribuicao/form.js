Vue.component('form-us', {
    props: ['registro', 'registros', 'user'],
    data() {
        return {
            validacao: [],
            estocagem: [],
            endereco: [],
            enderecos: [],
            produtos: [],
            qtdCaixas: 0,
            qtd_produto_anterior: 0,
            qtd_produto_atual: 0,
            deletar: false,
            statementIsTrue: 'Yes'
        }
    },
    computed: {},
    beforeMount() {
        if (this.registro)
            if (this.registro.hasOwnProperty('id')) {
                this.setEndereco(this.registro);
                _id = this.registro.id;
                if (this.registro.carga.length === 0) this.deletar = true;
            }

        enderecos = this.registros || [];
        enderecos = enderecos.map((item) => {
            if (_id !== item.id)
                return {
                    id: item.id,
                    area: item.area,
                    rua: item.rua,
                    modulo: item.modulo,
                    nivel: item.nivel,
                    vao: item.vao,
                    capacidade: item.produtos === null ? 0 : item.produtos,
                    caixas: item.caixas === null ? 0 : item.caixas,
                    paletes: item.paletes === null ? 0 : item.paletes,
                    total_carga: this.getCargaTotal(item),
                    alocacao: null
                }
        });

        enderecos.filter(function (item, x) {
            if (item === undefined)
                enderecos.splice(x, 1)
        });
        this.enderecos = enderecos;
    },
    methods: {
        getCargaTotal(item) {
            soma = 0;
            item.carga.filter((item) => {
                soma += item.movimento[0].quantidade_movimento;
            });
            return soma === 0 ? 'Livre' : " [ Total Carga :" + soma + " ] [ Capacidade: " + (item.produtos === null ? 'S/N' : item.produtos) + " ]";
        },
        closeModal() {
            $("#modal-image").modal('hide');
        },
        showImage() {
            $("#modal-image").modal();
        },
        setEndereco(registro) {
            this.endereco = registro;
            this.produtos = [];
            this.qtdCaixas = 0;
            this.qtd_produto_anterior = 0;
            this.qtd_produto_atual = 0;

            this.endereco.carga.forEach(item => {
                _item = item;
                item.movimento.forEach(item => {
                    this.qtdCaixas = this.qtdCaixas + item.estocagem.relacao.qtd_caixas;
                    this.qtd_produto_anterior = this.qtd_produto_anterior + item.estocagem.relacao.quantidade;
                    this.qtd_produto_atual = this.qtd_produto_atual + item.quantidade_movimento;
                    const lista = Object.assign({},
                        item.catmat,
                        {
                            movimento_id: item.id,
                            carga: _item,
                            quantidade_atual: item.quantidade_movimento,
                            data_validade_lote: item.data_validade_lote,
                            quantidade_selecionada: null,
                            _sustentavel: (item.catmat.sustentavel === true) ? "Sim" : "Não",
                            re_alocacao: null
                        }
                    );
                    if (lista.quantidade_atual > 0)
                        this.produtos.push(lista);
                })
            })
        },
        /**
         * Dispara Evento de Visualização de Cargas e detalhes de endereço;
         * */
        show(registro) {
            $(".centro-distribuicao-endereco").modal();
            this.setEndereco(registro);
        },
        /**
         * Inicia o salvamento da centro de distribuicao, mas antes faz a validação dos dados.
         *
         * @param e
         */
        salvar(e) {
            // Só vamos validar o resto dos dados de outras abas se o formulario principal estiver valido
            let formularioValido = $(this.$el).valid(), self = this;
            if (formularioValido) {
                // Valida as escalas de cada tipo de atendimento, separadamente
                let valido = true;

                if (!valido) {
                    e.preventDefault();
                    return;
                }
            }
        },
        execDeletar(event) {
            _end = this.endereco;
            sweetAlert({
                width: 600,
                title: 'Deletar Endereço de Alocaçao',
                text: 'O Endereço será removido do depósito do Centro de Distribuição!!!',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'confirma, Deletar Endereço ' + _end.area + '-' + _end.rua + '-' + _end.modulo + '-' + _end.nivel + '-' + _end.vao
            }).then((result) => {
                if (result.value) {
                    var location = $('#rotaDelete').val();
                    this.$refs.exec.action = location;
                    this.$refs.exec.submit()
                } else {
                    event.preventDefault();
                    return;
                }
            });
        },
        /**
         * Adiciona um novo responsável.
         */
        selecionarProduto(produto) {
            if (produto.quantidade_selecionada <= 0 || produto.quantidade_atual <= 0 || produto.quantidade_selecionada > produto.quantidade_atual) {
                return false
            }

            const qntCarga = parseInt(produto.quantidade_selecionada)
            // Notifica.info('Transferência de Carga de Endereço Encaminhada. Selecione Realocação','Transferência de Carga');
            produto.quantidade_atual -= parseInt(produto.quantidade_selecionada);
            const novoProduto = Object.assign({}, produto,
                {
                    quantidade_selecionada: parseInt(produto.quantidade_selecionada)
                }
            );
            sweetAlert({
                title: 'Transferência de Carga',
                text: 'Transferência a ser realizada,com autorização do usuário. ' + this.user.nome,
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'sim, Transferir'
            }).then((result) => {
                if (result.value) {
                    this.estocagem.push(novoProduto);
                    sweetAlert(
                        'Movimento de Transferência',
                        'Selecione o endereço para realocação da carga',
                        'success'
                    )
                } else {
                    produto.quantidade_atual += qntCarga;
                }
            });

            produto.quantidade_selecionada = null;
        },
        removerDaEstocagem(registro, index) {
            this.estocagem.splice(index, 1);
            produto = this.produtos.filter((produto) => {
                return produto.id === registro.id && produto.data_validade_lote === registro.data_validade_lote;
            })[0];
            this.reporDataLotes(registro, produto);
        },
        reporDataLotes(registro, produto) {
            this.produtos.filter(lote => {
                if (lote.id === produto.id) {
                    if (lote.data_validade_lote === produto.data_validade_lote) {
                        lote.quantidade_atual += registro.quantidade_selecionada
                    }
                }
            });
        }

    }
});
