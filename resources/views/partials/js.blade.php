@section('js')
    @if (auth()->user())
        {{--         <script src="//{{ Request::getHost() }}:6001/socket.io/socket.io.js"></script>--}}
    @endif



    <script type="text/javascript" src="{{ asset('assets/js/core/libraries/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/jquery.maskMoney.min.js') }}" type="text/javascript"></script>
    <script type="text/javascript" src="{{ asset('assets/js/core/libraries/bootstrap.min.js') }}"></script>



    <script src="{{ asset('assets/js/core/libraries/vue.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/libraries/vue-resource.min.js') }}"></script>

    <script type="text/javascript" src="{{ asset('assets/js/plugins.min.js') }}"></script>

    <script type="text/javascript" src="{{ asset('assets/js/core/template.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/core/sistema.js') }}"></script>

    <script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>


    @if(isset($map))
        {!! $map['js'] !!}
    @endif

    @yield('vue-componentes')
    <script type="text/javascript" src="{{ asset('assets/js/app.min.js') }}"></script>

    <script>

        $('.card_more_button').on('click',
            function () {
                $(this).closest('.card').toggleClass('card_full');
                $(this).siblings('.card_more_content').slideToggle('fast');
                $(this).toggleClass('flipY');
            }
        );

        $('.spin-icon').click(function () {
            $(".theme-config-box").toggleClass("show");
        });

        $('.spin-icon-left-andamentos').click(function () {
            $this = $(".spin-icon-left-andamentos");
            $("#andamentos").toggleClass("show");
            $this.toggleClass("show");

            $let = $(".spin-icon-left-pedidos");
            if ($let.hasClass('clear_label_card')) {
                $this.toggleClass('ajuste-in');
                setTimeout(function () {
                    $let.toggleClass("clear_label_card");
                }, 600)
            } else {
                $let.toggleClass("clear_label_card");
                $this.toggleClass('ajuste-in');
            }

        });

        $('.spin-icon-left-pedidos').click(function () {
            $("#pedidos").toggleClass("show");
            $(".spin-icon-left-pedidos").toggleClass("show");
            $let = $(".spin-icon-left-andamentos");
            if ($let.hasClass('clear_label_card')) {
                setTimeout(function () {
                    $let.toggleClass("clear_label_card");
                }, 600)
            } else {
                $let.toggleClass("clear_label_card")
            }
        });

        $("a.toggleQuestionTable").click(function () {
            theId = $(this).attr("id");
            $("table." + theId).slideToggle();
            return false;
        });

        $("#assinatura").blur(function (e) {
            vigencia = new Date(document.getElementById("vigencia").value);
            assinatura = new Date(document.getElementById("assinatura").value);
            prazo_dia = document.getElementById("prazo_dias");

            diffMilissegundos = assinatura - vigencia;
            diffSegundos = diffMilissegundos / 1000;
            diffMinutos = diffSegundos / 60;
            diffHoras = diffMinutos / 60;
            diffDias = diffHoras / 24;
            diffMeses = diffDias / 30;
            if (!isNaN(Math.round(diffDias) * -1))
                prazo_dia.value = Math.round(diffDias) * -1;
        });

        $("#assinatura").on("change", function (e) {
            vigencia = new Date(document.getElementById("vigencia").value);
            assinatura = new Date(document.getElementById("assinatura").value);
            prazo_dia = document.getElementById("prazo_dias");

            diffMilissegundos = assinatura - vigencia;
            diffSegundos = diffMilissegundos / 1000;
            diffMinutos = diffSegundos / 60;
            diffHoras = diffMinutos / 60;
            diffDias = diffHoras / 24;
            diffMeses = diffDias / 30;
            if (!isNaN(Math.round(diffDias) * -1))
                prazo_dia.value = Math.round(diffDias) * -1;
        });

        $("#vigencia").blur(function (e) {
            vigencia = new Date(document.getElementById("vigencia").value);
            assinatura = new Date(document.getElementById("assinatura").value);
            prazo_dia = document.getElementById("prazo_dias");

            diffMilissegundos = assinatura - vigencia;
            diffSegundos = diffMilissegundos / 1000;
            diffMinutos = diffSegundos / 60;
            diffHoras = diffMinutos / 60;
            diffDias = diffHoras / 24;
            diffMeses = diffDias / 30;
            if (!isNaN(Math.round(diffDias) * -1))
                prazo_dia.value = Math.round(diffDias) * -1;
        });

        $("#vegencia").on("change", function (e) {
            vigencia = new Date(document.getElementById("vigencia").value);
            assinatura = new Date(document.getElementById("assinatura").value);
            prazo_dia = document.getElementById("prazo_dias");

            diffMilissegundos = assinatura - vigencia;
            diffSegundos = diffMilissegundos / 1000;
            diffMinutos = diffSegundos / 60;
            diffHoras = diffMinutos / 60;
            diffDias = diffHoras / 24;
            diffMeses = diffDias / 30;
            if (!isNaN(Math.round(diffDias) * -1))
                prazo_dia.value = Math.round(diffDias) * -1;
        });

        $('#sandbox-container .input-daterange').datepicker({
            beforeShowYear: function (date) {
                if (date.getFullYear() == 2007) {
                    return false;
                }
            }
        });

    </script>
@show
