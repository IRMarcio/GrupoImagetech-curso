<?php

namespace App\Services;

/**
 * Classe utilitária que formata alguns dados e adiciona mascaras, caso necessário.
 *
 * @package App\Services
 */
class Mascarado
{

    /**
     * Formata um número para o formato de CPF.
     *
     * @param string $valor O valor a ser formatado.
     *
     * @return string
     */
    public static function formatarCpf($valor)
    {
        return self::adicionarMascara($valor, '###.###.###-##');
    }

    /**
     * Formata um valor para a mascara especificada.
     *
     * @param  string $valor O valor a ser formatado.
     * @param  string $mascara A mascara para aplicar no conteúdo.
     *
     * @return string
     */
    private static function adicionarMascara($valor, $mascara)
    {
        if (!empty($valor) && mb_strlen($valor) > 0) {
            $mascarado = '';
            $k = 0;
            $tamanho = strlen($mascara);

            for ($i = 0; $i <= $tamanho - 1; $i++) {
                if ($mascara[$i] == '#') {
                    if (isset($valor[$k])) {
                        $mascarado .= $valor[$k++];
                    }
                } else {
                    if (isset($mascara[$i])) {
                        $mascarado .= $mascara[$i];
                    }
                }
            }

            return $mascarado;
        }

        return $valor;
    }

    /**
     * Formata um número para o formato de CEP.
     *
     * @param string $valor O valor a ser formatado.
     *
     * @return string
     */
    public static function formatarCep($valor)
    {
        return self::adicionarMascara($valor, '#####-###');
    }

    /**
     * Formata um número para o formato de CNPJ.
     *
     * @param string $valor O valor a ser formatado.
     *
     * @return string
     */
    public static function formatarCnpj($valor)
    {
        return self::adicionarMascara($valor, '##.###.###/####-##');
    }

    /**
     * Remove máscara de um valor específico.
     *
     * @param  string $valor Valor para editar.
     * @param  mixed $outros Caso deseja passar outros valores a serem removidos.
     *
     * @return string
     */
    public static function removerMascara($valor, $outros = null)
    {
        $remover = [
            '.', ',', '/', '-', '(', ')', '[', ']', ' ', '+', '_',
        ];

        if (!is_null($outros)) {
            if (!is_array($outros)) {
                $outros = [$outros];
            }

            $remover = array_merge($remover, $outros);
        }

        return str_replace($remover, '', $valor);
    }
}
