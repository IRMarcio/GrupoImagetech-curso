<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;

class RefreshToken extends BaseMiddleware
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     *
     * @return mixed
     * @throws JWTException
     */
    public function handle($request, \Closure $next)
    {
        // Checa se a token está presente
        $this->checkForToken($request);

        try {
            // Chega se encontrou o usuário e também verifica se a token já expirou.
            if (!$this->auth->parseToken()->authenticate()) {
                throw new UnauthorizedHttpException('jwt-auth', 'Usuário não encontrado');
            }
            $payload = $this->auth->manager()->getPayloadFactory()->buildClaimsCollection()->toPlainArray();

            // Token está válida e usuário está logado, retorna a response normalmente
            return $next($request);
        }
        catch (TokenExpiredException $t) { // Token expired. User not logged.
            info('A TOKEN EXPIROU TENTANDO GERAR OUTRA');
            $payload = $this->auth->manager()->getPayloadFactory()->buildClaimsCollection()->toPlainArray();
            $key = 'block_refresh_token_for_user_' . $payload['sub'];
            $cachedBefore = (int)Cache::has($key);
            // Se a token já foi renovada e enviada para o usuário nos ultimos JWT_BLACKLIST_GRACE_PERIOD segundos.
            if ($cachedBefore) {
                info('TOKEN GERADA CACHED BEFORE');
                // Loga o usuário utilizando o id
                \Auth::onceUsingId($payload['sub']);

                // Token expirou, retorna a response sem nenhuma token porque está no grace period.
                return $next($request);
            }
            try {
                info('GERANDO NOVA TOKEN');
                // Gera uma nova token
                $newtoken = $this->auth->refresh();
                $gracePeriod = $this->auth->manager()->getBlacklist()->getGracePeriod();
                $expiresAt = Carbon::now()->addSeconds($gracePeriod);
                Cache::put($key, $newtoken, $expiresAt);
                info('TOKEN GERADA E GUARDADA NO CACHE');
            }
            catch (JWTException $e) {
                info('ALGO DEU ERRADO AO GERAR NOVA TOKEN');
                throw new UnauthorizedHttpException('jwt-auth', $e->getMessage(), $e, $e->getCode());
            }
        }

        info('TUDO OK');

        $response = $next($request);

        return $this->setAuthenticationHeader($response, $newtoken);
    }

}
