<?php

namespace App\Services;

use File;
use Illuminate\Http\UploadedFile;
use Log;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

/**
 * Classe geral de uploads de arquivos utilizada pelo sistema inteiro.
 *
 * @package App\Services
 */
class ArquivoUploader
{

    public static $pastaArquivos = '_arquivos' . DIRECTORY_SEPARATOR;

    /**
     * Faz upload de um arquivo para o servidor.
     *
     * @param UploadedFile $arquivo
     * @param string $pasta
     * @param string|null $extensoesPermitidas
     *
     * @return string Nome do arquivo feito upload.
     */
    public function upload($arquivo, $pasta, $extensoesPermitidas = null)
    {
        if ($extensoesPermitidas) {
            $podeEnviar = $this->verificaExtensaoPermitida($arquivo, $extensoesPermitidas);
            if (!$podeEnviar) {
                throw new FileException('Não é permitido enviar arquivos com a extensão selecionada.');
            }
        }

        $nome = $arquivo->getClientOriginalName();
        //$destino = public_path($this->pastaArquivos . $pasta . DIRECTORY_SEPARATOR);
        $destino = self::$pastaArquivos . $pasta . DIRECTORY_SEPARATOR;
        $fullPath = public_path($destino . $nome);

        // Trata nome de arquivos repetidos
        if (File::exists($fullPath)) {
            $pathInfo = pathinfo($fullPath);
            $extension = isset($pathInfo['extension']) ? ('.' . $pathInfo['extension']) : '';

            if (preg_match('/(.*?)(\d+)$/', $pathInfo['filename'], $match)) {
                $base = $match[1];
                $number = intVal($match[2]);
            } else {
                $base = $pathInfo['filename'];
                $number = 0;
            }

            do {
                $nome = $base . ++$number . $extension;
                $fullPath = $pathInfo['dirname'] . DIRECTORY_SEPARATOR . $nome;
            } while (File::exists($fullPath));
        }

        $arquivo->move($destino, $nome);

        return $destino . $nome;
    }

    /**
     * Verifica se o arquivo sendo enviado tem a extensão permitida.
     *
     * @param UploadedFile $arquivo
     * @param string $extensoesPermitidas
     *
     * @return bool
     */
    private function verificaExtensaoPermitida($arquivo, $extensoesPermitidas)
    {
        $extensoesPermitidas = array_map(function ($extensao) {
            return trim(str_replace('.', '', $extensao));
        }, explode(',', $extensoesPermitidas));

        $extensao = $arquivo->getClientOriginalExtension();

        return in_array($extensao, $extensoesPermitidas);
    }
}
