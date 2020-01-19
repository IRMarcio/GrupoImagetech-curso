function regraCpf(value, element) {
    value = $.trim(value);

    value = value.replace('.', '');
    value = value.replace('.', '');
    cpf = value.replace('-', '');
    while (cpf.length < 11) cpf = "0" + cpf;
    var expReg = /^0+$|^1+$|^2+$|^3+$|^4+$|^5+$|^6+$|^7+$|^8+$|^9+$/;
    var a = [];
    var b = new Number;
    var c = 11;
    for (i = 0; i < 11; i++) {
        a[i] = cpf.charAt(i);
        if (i < 9) b += (a[i] * --c);
    }
    if ((x = b % 11) < 2) {
        a[9] = 0
    } else {
        a[9] = 11 - x
    }
    b = 0;
    c = 11;
    for (y = 0; y < 10; y++) b += (a[y] * c--);
    if ((x = b % 11) < 2) {
        a[10] = 0;
    } else {
        a[10] = 11 - x;
    }

    var retorno = true;
    if ((cpf.charAt(9) != a[9]) || (cpf.charAt(10) != a[10]) || cpf.match(expReg)) retorno = false;

    return this.optional(element) || retorno;
}

function regraCnpj(value, element) {
    cnpj = $.trim(value);

    // DEIXA APENAS OS NÚMEROS
    cnpj = cnpj.replace('/', '');
    cnpj = cnpj.replace('.', '');
    cnpj = cnpj.replace('.', '');
    cnpj = cnpj.replace('-', '');

    var numeros, digitos, soma, i, resultado, pos, tamanho, digitos_iguais;
    digitos_iguais = 1;

    if (cnpj.length < 14 && cnpj.length < 15) {
        return false;
    }
    for (i = 0; i < cnpj.length - 1; i++) {
        if (cnpj.charAt(i) != cnpj.charAt(i + 1)) {
            digitos_iguais = 0;
            break;
        }
    }

    if (!digitos_iguais) {
        tamanho = cnpj.length - 2
        numeros = cnpj.substring(0, tamanho);
        digitos = cnpj.substring(tamanho);
        soma = 0;
        pos = tamanho - 7;

        for (i = tamanho; i >= 1; i--) {
            soma += numeros.charAt(tamanho - i) * pos--;
            if (pos < 2) {
                pos = 9;
            }
        }
        resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
        if (resultado != digitos.charAt(0)) {
            return false;
        }
        tamanho = tamanho + 1;
        numeros = cnpj.substring(0, tamanho);
        soma = 0;
        pos = tamanho - 7;
        for (i = tamanho; i >= 1; i--) {
            soma += numeros.charAt(tamanho - i) * pos--;
            if (pos < 2) {
                pos = 9;
            }
        }
        resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
        if (resultado != digitos.charAt(1)) {
            return false;
        }
        return true;
    } else {
        return false;
    }
}

function regraCns(value, element) {
    var soma = new Number;
    var resto = new Number;
    var dv = new Number;
    var pis = new String;
    var resultado = new String;
    var tamCNS = value.length;

    if ((value.substring(0, 1) == "7") || (value.substring(0, 1) == "8") || (value.substring(0, 1) == "9")) {
        return regraCnsProvisorio(value, element);
    }


    if ((tamCNS) != 15) {
        return false;
    }
    pis = value.substring(0, 11);
    soma = (((Number(pis.substring(0, 1))) * 15) +
        ((Number(pis.substring(1, 2))) * 14) +
        ((Number(pis.substring(2, 3))) * 13) +
        ((Number(pis.substring(3, 4))) * 12) +
        ((Number(pis.substring(4, 5))) * 11) +
        ((Number(pis.substring(5, 6))) * 10) +
        ((Number(pis.substring(6, 7))) * 9) +
        ((Number(pis.substring(7, 8))) * 8) +
        ((Number(pis.substring(8, 9))) * 7) +
        ((Number(pis.substring(9, 10))) * 6) +
        ((Number(pis.substring(10, 11))) * 5));
    resto = soma % 11;
    dv = 11 - resto;
    if (dv == 11) {
        dv = 0;
    }
    if (dv == 10) {
        soma = (((Number(pis.substring(0, 1))) * 15) +
            ((Number(pis.substring(1, 2))) * 14) +
            ((Number(pis.substring(2, 3))) * 13) +
            ((Number(pis.substring(3, 4))) * 12) +
            ((Number(pis.substring(4, 5))) * 11) +
            ((Number(pis.substring(5, 6))) * 10) +
            ((Number(pis.substring(6, 7))) * 9) +
            ((Number(pis.substring(7, 8))) * 8) +
            ((Number(pis.substring(8, 9))) * 7) +
            ((Number(pis.substring(9, 10))) * 6) +
            ((Number(pis.substring(10, 11))) * 5) + 2);
        resto = soma % 11;
        dv = 11 - resto;
        resultado = pis + "001" + String(dv);
    } else {
        resultado = pis + "000" + String(dv);
    }
    if (value != resultado) {
        return false;
    } else {
        return true;
    }
}

function regraCnsProvisorio(value, element) {
    var pis;
    var resto;
    var dv;
    var soma;
    var resultado;
    var result;
    result = 0;

    pis = value.substring(0, 15);

    if (pis == "") {
        return false;
    }

    if ((value.substring(0, 1) != "7") && (value.substring(0, 1) != "8") && (value.substring(0, 1) != "9")) {
        return false;
    }

    soma = (   (parseInt(pis.substring(0, 1), 10)) * 15)
        + ((parseInt(pis.substring(1, 2), 10)) * 14)
        + ((parseInt(pis.substring(2, 3), 10)) * 13)
        + ((parseInt(pis.substring(3, 4), 10)) * 12)
        + ((parseInt(pis.substring(4, 5), 10)) * 11)
        + ((parseInt(pis.substring(5, 6), 10)) * 10)
        + ((parseInt(pis.substring(6, 7), 10)) * 9)
        + ((parseInt(pis.substring(7, 8), 10)) * 8)
        + ((parseInt(pis.substring(8, 9), 10)) * 7)
        + ((parseInt(pis.substring(9, 10), 10)) * 6)
        + ((parseInt(pis.substring(10, 11), 10)) * 5)
        + ((parseInt(pis.substring(11, 12), 10)) * 4)
        + ((parseInt(pis.substring(12, 13), 10)) * 3)
        + ((parseInt(pis.substring(13, 14), 10)) * 2)
        + ((parseInt(pis.substring(14, 15), 10)) * 1);

    resto = soma % 11;

    if (resto == 0) {
        return true;
    }
    else {
        return false;
    }
}

function regraData(value, element) {
    if (value.length != 10) return false;

    var data = value;
    var dia = data.substr(0, 2);
    var barra1 = data.substr(2, 1);
    var mes = data.substr(3, 2);
    var barra2 = data.substr(5, 1);
    var ano = data.substr(6, 4);
    if (data.length != 10 || barra1 != "/" || barra2 != "/" || isNaN(dia) || isNaN(mes) || isNaN(ano) || dia > 31 || mes > 12) return false;
    if ((mes == 4 || mes == 6 || mes == 9 || mes == 11) && dia == 31) return false;
    if (mes == 2 && (dia > 29 || (dia == 29 && ano % 4 != 0))) return false;
    if (ano < 1900) return false;
    return true;
}

$.validator.addMethod("cpf", regraCpf, "Informe um CPF válido.");
$.validator.addMethod("cnpj", regraCnpj, "Informe um CNPJ válido.");
$.validator.addMethod("cns", regraCns, "Informe um CNS válido.");
$.validator.addMethod("data", regraData, "Informe uma data válida");  // Mensagem padrão