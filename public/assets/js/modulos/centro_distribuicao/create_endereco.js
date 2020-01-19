Vue.component('create-endereco', {
    props: ['_enderecos'],
    data() {
        return {
            areas: [],
            ruas: [],
            modulos: [],
            niveis: [],
            enderecos: [],
            createIn: [],
            acao: null,
            selecionado: {
                area: null,
                rua: null,
                modulo: null,
                nivel: null,
                vao: null,
                tipo: null
            },
            obj_area: {
                q_area: 0,
                q_rua: 0,
                q_modulo: 0,
                q_nivel: 0,
                q_vao: 0,
                tipo: 0

            },
            obj_rua: {
                q_rua: 0,
                q_modulo: 0,
                q_nivel: 0,
                q_vao: 0,
                tipo: 0
            },
            obj_modulo: {
                q_modulo: 0,
                q_nivel: 0,
                q_vao: 0,
                tipo: 0
            },
            obj_nivel: {
                q_nivel: 0,
                q_vao: 0,
                tipo: 0
            },
            obj_vao: {
                q_vao: 0,
                tipo: 0
            }
        }
    },
    watch: {
        'selecionado.area'(newValue, oldValue) {
            if (newValue !== oldValue) {
                this.ruas = [];
                this.selecionado.rua = null;
                this.rua(this.ruas);
            }
        },
        'selecionado.rua'(newValue, oldValue) {
            if (newValue !== oldValue) {
                this.modulos = [];
                this.selecionado.modulo = null;
                this.modulo(this.modulos);
            }
        },
        'selecionado.modulo'(newValue, oldValue) {
            if (newValue !== oldValue) {
                this.niveis = [];
                this.selecionado.nivel = null;
                this.nivel(this.niveis);
            }
        }
    },
    beforeMount() {
        enderecos = this._enderecos || [];
        _map = enderecos.map(function (item) {
            return {
                id: item.id,
                area: item.area,
                rua: item.rua,
                modulo: item.modulo,
                nivel: item.nivel,
                vao: item.vao,
            }
        });
        this.enderecos = _map;
        this.area(this.areas, 'area');
    },
    methods: {
        _reset(acao) {
            this.acao = acao;
            _ar = [this.selecionado, this.obj_area, this.obj_rua, this.obj_modulo, this.obj_nivel, this.obj_vao];
            _ar.forEach((item) => {
                _keys = Object.keys(item);
                _keys.forEach(field => {
                    if (field !== 'tipo')
                        item[field] = item.tipo === 0 ? 0 : null;
                })
            });
        },
        area(objects, field) {
            this.enderecos.forEach((item) => {
                let duplicated = objects.findIndex(redItem => {
                    return item[field] === redItem[field];
                }) > -1;
                if (!duplicated) {
                    objects.push(item);
                }
            });

            let order = objects.slice(0);
            order.sort(function (a, b) {
                x = a.area.toLowerCase();
                y = b.area.toLowerCase();
                return x < y ? -1 : x > y ? 1 : 0;
            });
            this.areas = order;

        },
        rua(objects) {
            _filtrado = this.enderecos.filter((item) => {
                return item['area'] === this.selecionado.area;
            });

            _filtrado.forEach((item) => {
                let duplicated = objects.findIndex(redItem => {
                    return item['rua'] === redItem['rua'];
                }) > -1;
                if (!duplicated) {
                    objects.push(item);
                }
            });
        },
        modulo(objects) {
            _filtrado = this.enderecos.filter((item) => {
                return item['area'] === this.selecionado.area && item['rua'] === this.selecionado.rua;
            });

            _filtrado.forEach((item) => {
                let duplicated = objects.findIndex(redItem => {
                    return item['modulo'] === redItem['modulo'];
                }) > -1;
                if (!duplicated) {
                    objects.push(item);
                }
            });
        },
        nivel(objects) {
            _filtrado = this.enderecos.filter((item) => {
                return item['area'] === this.selecionado.area && item['rua'] === this.selecionado.rua && item['modulo'] === this.selecionado.modulo;
            });

            _filtrado.forEach((item) => {
                let duplicated = objects.findIndex(redItem => {
                    return item['nivel'] === redItem['nivel'];
                }) > -1;
                if (!duplicated) {
                    objects.push(item);
                }
            });
        },
        getAcao() {
            _var = null;
            switch (this.acao) {
                case 'area':
                    _var = this.obj_area;
                    break;
                case 'rua':
                    _var = this.obj_rua;
                    break;
                case 'modulo':
                    _var = this.obj_modulo;
                    break;
                case 'nivel':
                    _var = this.obj_nivel;
                    break;
                case 'vao':
                    _var = this.obj_vao;
                    break;
                default:
                    console.log('algo de errado não esta certo....');
            }
            $valida = true;
            this.createIn = JSON.stringify(Object.assign({}, {
                query: this.selecionado,
                obj: _var
            }));

            $valida = this.validaSelecionado($valida);
            $valida = this.validaObj(_var, $valida);

            return $valida
        },
        validaSelecionado(valida){

            switch (this.acao) {
                case 'rua':
                    _val = ['area'];
                    break;
                case 'modulo':
                    _val = ['area', 'rua'];
                    break;
                case 'nivel':
                    _val = ['area', 'rua', 'modulo'];
                    break;
                case 'vao':
                    _val = ['area', 'rua', 'modulo', 'nivel'];
                    break;
            }
            _val.forEach(item=> {
                if(!this.selecionado[item]){
                    valida = false
                }
            });
            return valida;
        },
        validaObj(_var,valida){
            if(!valida){
                Notifica.info(`Preencha Todos os campos acima para continuar com o cadastro.`);
            }else {
                if (
                    _.indexOf(Object.values(this.reject(_var, 'tipo')), 0) !== -1 ||
                    _.indexOf(Object.values(this.reject(_var, 'tipo')), "0") !== -1) {
                    valida = false;
                    $msg = '';
                    Object.keys(this.reject(_var, 'tipo')).forEach(item => {
                        $msg += item.replace('q_', '') + ", ";
                    });
                    Notifica.erro(`Os Campo(s) ${$msg} não podem conter valor em branco, ou Zero`);
                }
            }

            return valida;
        },
        reject(obj, keys) {
            return Object.keys(obj)
                .filter(k => !keys.includes(k))
                .map(k => Object.assign({}, {[k]: obj[k]}))
                .reduce((res, o) => Object.assign(res, o), {});
        },
        /**
         * Inicia o salvamento do centro de distribuicao, mas antes faz a validação dos dados.
         *
         * @param e
         */
        salvar(e) {
            // Só vamos validar o resto dos dados de outras abas se o formulario principal estiver valido
            let formularioValido = $(this.$el).valid(), self = this;
            if (formularioValido) {
                // Valida as escalas de cada tipo de atendimento, separadamente
                let valido = true;
                valido = this.getAcao();
                console.log(valido);
                if (!valido) {
                e.preventDefault();
                return;
                }
            }
        }
        ,
        closeModal() {
            $("#modal-image").modal('hide');
        }
        ,
        showImage() {
            $("#modal-image").modal();
        }
        ,
    }
})
;
