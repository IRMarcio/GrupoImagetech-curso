@section('css')
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/core.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/components.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/colors.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/plugins/c3.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/icons/icomoon/styles.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/icons/fontawesome/styles.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/dados.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/card-dashboard.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/time-line.css') }}" rel="stylesheet" type="text/css">
    <style>
        .vao {
            width: 130px;
            margin-right: 3px;
            margin-top: 3px;
            background-color: #273246;
            border: 1px;
            border-style: groove;
            border-color: darkgreen;
            height: 50px;
            text-align: center;
            padding: 5px;
            border-radius: 5px;
            float: left;
        }

        .span-estocagem {
            font-weight: 500 !important;
            background: whitesmoke !important;
            border: 1px solid #727fad !important;
            padding: 4px 17px 4px 17px !important;
            text-transform: uppercase !important;
            border-radius: 4px !important;
            color: cadetblue !important;
        }
        .span-endereco{
            background-color: #2196f3;
            padding: 3px 5px 3px 5px;
            border: 1px solid #ce6d6d;
            color: azure;
            border-radius: 5px;
            font-weight: bolder;
            font-size: 11px;
        }

        .tg {
            border-collapse: collapse;
            border-spacing: 0;
        }

        .tg td {
            font-family: Arial, sans-serif;
            font-size: 14px;
            padding: 10px 5px;
            border-style: solid;
            border-width: 1px;
            overflow: hidden;
            word-break: normal;
            border-color: black;
        }

        .tg th {
            font-family: Arial, sans-serif;
            font-size: 14px;
            font-weight: normal;
            padding: 10px 5px;
            border-style: solid;
            border-width: 1px;
            overflow: hidden;
            word-break: normal;
            border-color: black;
        }

        .tg .tg-c3ow {
            border-color: inherit;
            text-align: center;
            vertical-align: top
        }

        .tg .tg-uys7 {
            border-color: inherit;
            text-align: center
        }

        .tg .tg-0pky {
            border-color: inherit;
            text-align: left;
            vertical-align: top
        }
        .c3-axis-y0 {
            /*visibility: hidden !important;*/
        }

        /*select 2 -- conhecimento embarque-adicionar/alterar*/
        #relacao_produto .select2-selection__rendered {
            display: block;
            width: 750px !important;
            padding-left: 12px;
            padding-right: 31px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        /*layout -- listagem enderecos centro distribuicao*/
        .modulo-padrao {
            padding: 3px 10px 3px 10px;
            border-radius: 2px;
            margin-top: 5px;
            font-size: 17px;
            font-weight: 800;
            color: white;
        }
        .modulo-area {
            font-weight: 600 !important;
            color: #000 !important;
            font-size: 14px !important;
        }
        .Livre{
            padding: 3px 5px 3px 5px;
            background: #ebf3f0;
            border-radius: 5px;
            font-size: 10px;
            font-weight: bolder;
            text-transform: uppercase;
        }
        .Ocupado{
            text-transform: uppercase;
            padding: 3px 5px 3px 5px;
            background: rgba(146, 26, 26, 0.08);
            border-radius: 5px;
            font-size: 10px;
            font-weight: bolder;
        }

        /* layout span form - _listagem_alocacao.blade

        */
        .span-link{
            color: blue;
            background-color: rgba(179, 215, 255, 0.26);
            padding: 0px 5px 0px 5px;
            border-radius: 4px;
        }
        .button-endereco{
            margin-top: 11px;
            padding: 0px 8px 0px 8px;
            position: absolute;
            margin-left: -192px
        }

        /* formulário de entrada de enderecos _dados_adicionar_enderecos*/
        .span-adicionar-p{
            color: blue;
            text-transform: uppercase;
            font-size: 10px
        }

        #_endereco tbody tr td{
            padding: 5px 0px 5px 20px;
        }

    </style>
@show
