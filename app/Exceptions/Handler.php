<?php

namespace App\Exceptions;


use ErrorException;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Foundation\Http\Exceptions\MaintenanceModeException;
use Illuminate\Http\Exceptions\PostTooLargeException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{

    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        HttpException::class,
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception $exception
     *
     * @return void
     * @throws Exception
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception $exception
     *
     * @return Response
     */
    public function render($request, Exception $exception)
    {

        // Erros relacionado ao banco de dados
        if ($exception instanceof QueryException) {
            $retorno = $this->tratarQueryException($request, $exception);
            if ($retorno) {
                return $retorno;
            }
        }

        // O tamanho dos dados POST muito grande
        if ($exception instanceof PostTooLargeException) {
            $mensagem = 'Os dados enviados via $_POST ultrapassam o limite do servidor.';
            if ($request->wantsJson()) {
                return response()->json(['data' => ['errors' => $mensagem]], 500);
            }

            flash($mensagem)->error();

            return back();
        }

        // Erro de validação de dados
        if ($exception instanceof ValidationException) {
            if ($request->wantsJson()) {
                return response()->json(['data' => ['errors' => $exception->validator->errors()->all()]], $exception->status);
            }

            // lockout (muitas tentativas de login)
            if ($exception->status == 423) {
                return back();
            }
        }

        // Usuário tentou buscar um registro que não existe/sistema não pode encontrar
        if ($exception instanceof ModelNotFoundException) {

            $mensagem = $exception->getMessage();
            isset($mensagem)?:$mensagem = 'O registro solicitado não foi encontrado no banco de dados.';
            if ($request->wantsJson()) {
                return response()->json(['data' => $mensagem], 404);
            }

            flash($mensagem)->error();

            return back();
        }

        // Página não encontrada e método não permitido (acessar POST via GET)
        if ($exception instanceof NotFoundHttpException || $exception instanceof MethodNotAllowedHttpException) {
            return response()->view('errors.404', ['message' => $exception->getMessage()], 404);
        }

        //  Erros genéricos
        if ($exception instanceof ErrorException) {
            if ($request->wantsJson()) {
                return response()->json(['errors' => [$exception->getMessage()]]);
            }

            if (env('APP_DEBUG') == false) {
                return response()->view('errors.500', [], 500);
            }
        }

        // Se o sistema estiver em manutenção, queremos exibir uma página customizada
        if ($exception instanceof MaintenanceModeException) {
            return response()->view('errors.503', [], 503);
        }

        // E por final, deixa o Laravel administrar o erro, caso ele não seja nenhum dos especificados acima
        return parent::render($request, $exception);
    }

    /**
     * Trata o erro quando é especifico QueryException.
     *
     * @param $request
     * @param $exception
     *
     * @return bool|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    private function tratarQueryException($request, $exception)
    {
        $code = $exception->errorInfo[1];

        // Message: Cannot delete or update a parent row: a foreign key constraint fails (%s)
        if ($code == 1451) {
            $mensagem = 'Não foi possível excluir o registro, ele está relacionado com outros registros no sistema.';
            if ($request->wantsJson()) {
                return response()->json(['errors' => [$mensagem]], 500);
            }

            // Exibe a mensagem amigável para o usuário
            flash($mensagem)->error();

            return back();
        }

        // Não queremos tratar caso o erro não seja o que especificamos na condição acima, deixa para o Laravel
        return false;
    }

    /**
     * Render the given HttpException.
     *
     * @param HttpException $e
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function renderHttpException(HttpException $e)
    {

        if (!view()->exists("errors.{$e->getStatusCode()}")) {
            return response()->view('errors.500', ['exception' => $e], 500, $e->getHeaders());
        }

        return parent::renderHttpException($e);
    }

    /**
     * O contexto que é logado juntamento no arquivo de log.
     *
     * @return array
     */
    protected function context()
    {
        try {
            return array_filter(
                [
                    'usuario_id' => auth()->user() ? auth()->user()->getAuthIdentifier() : null,
                    'email'          => auth()->user() ? auth()->user()->email : null,
                    'rota'           => request()->route()->getName(),
                    'requisicao'     => request()->method()
                ]
            );
        }
        catch (Throwable $e) {
            return [];
        }
    }
}
