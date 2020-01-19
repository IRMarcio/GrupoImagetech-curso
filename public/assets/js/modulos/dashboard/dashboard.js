$(function () {

 var chart,chartDonut ;
    let dasboard = {
        init: function () {
            this.orient();
            this.chartBarras();
            this.chartArea();
            this.chartCatmat();
            this.chartDonut();
            this.optionsChartBarra();
            this.optionChartdonut();

        },
        getValues: function () {
            var i, result = [];
            for (i = 0; i < 10; i++) {
                result.push(parseInt(Math.random() * 1000 + 181));
            }
            return result;
        },
        orient: function () {
            return [
                ['Transferências'].concat(this.getValues()),
                ['Movimentações'].concat(this.getValues()),
                ['Estoque'].concat(this.getValues())
            ];
        },
        data: function () {
            return [
                ['Transferências'].concat(Object.values(chartValues.chartTransferencia)),
                ['Movimentações'].concat(Object.values(chartValues.chartMovimento)),
                ['Estoque'].concat(Object.values(chartValues.chartEstoque))
            ]
        },
        chartBarras: function () {
            chart =   c3.generate({
                bindto: '#c3-transform',
                data: {
                    columns: [],
                    types: {
                        Estoque: 'bar', // ADD
                        ['Movimentações']: 'bar' // ADD
                    }
                },
                axis: {
                    x: {
                        type: 'category',
                        categories: ['jan', 'fev', 'mar', 'abr', 'mai', 'jun', 'jul', 'ago', 'set', 'out', 'nov', 'dez'],
                    }
                },
                title: {
                    text: 'Gráfico Geral de Medicamentos em Estoque/Movimentações/Transferências por Mensal'
                }
            });
        },
        chartArea: function () {
            c3.generate({
                bindto: '#c3-transform-area',
                data: {
                    columns: [
                        ['Medicamentos'].concat(Object.values(chartValues.produtos_total.value)),
                    ],
                    types: {
                        Medicamentos: 'area-step'
                        // 'line', 'spline', 'step', 'area', 'area-step' are also available to stack
                    },
                    groups: [
                        ['Medicamentos']
                    ]
                }
            });
        },
        chartDonut: function () {
             chartDonut = c3.generate({
                        bindto: '#c3-transform-donut',
                        data: {
                            columns: [],
                            type: 'donut',
                            onclick: function (d, i) {
                                // console.log("onclick", d, i);
                            },
                            onmouseover: function (d, i) {
                                // console.log("onmouseover", d, i);
                            },
                            onmouseout: function (d, i) {
                                // console.log("onmouseout", d, i);
                            }
                        },
                        donut: {
                            title: "Esto./ Movim./ Transf."
                        }
                    });
        },
        chartCatmat: function (){
            c3.generate({
                        bindto: '#c3-transform-catmat',
                        data: {
                            columns: [
                                ['Medicamentos'].concat(Object.values(chartValues.produtos_total.value))
                            ],
                            type: 'bar'
                        },
                        axis: {
                            rotated: true,
                            x: {
                                type: "categorized",
                                categories: Object.values(chartValues.produtos_total.key),
                                tick: {
                                    rotate: -60,
                                    multiline: false
                                },
                                height: 100,
                            },
                            y: {
                                tick: {
                                    rotate: -60
                                },
                                height: 50,
                            }
                        },
                        bar: {
                            width: {
                                ratio: 0.4
                            },
                        },
                        title: {
                            text: 'Gráfico Geral de Estoque por Medicamentos'
                        }, grid: {
                            x: {
                                show: true
                            },
                            y: {
                                show: true
                            }
                        }
                    });
        },
        optionsChartBarra: function () {
            let orient = this.orient();
            let data = this.data();
            setTimeout(function () {
                chart.load({
                    columns: orient
                });
            }, 1000);
            setTimeout(function () {
                chart.load({
                    columns: orient
                });
            }, 1500);
            setTimeout(function () {
                chart.load({
                    columns: data
                });
            }, 2500);
        },
        optionChartdonut: function () {
            let data = this.data();
            setTimeout(function () {
                chartDonut.load({
                    columns: data
                });
            }, 1500);
        }


    }
    dasboard.init();
});
