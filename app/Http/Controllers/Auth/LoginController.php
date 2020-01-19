<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\ChecagemSenhaPadrao;
use App\Services\GerenciaSession;
use App\Services\Mascarado;
use Exception;
use Hash;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Services\GerenciaConfiguracoes;
use App\Services\Redirecionador;

class LoginController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * @var ChecagemSenhaPadrao
     */
    private $checagemSenhaPadrao;

    /**
     * @var GerenciaSession
     */
    private $gerenciaSession;

    /**
     * @var Redirecionador
     */
    private $redirecionador;

    /**
     * Número máximo de tentativas de login até bloquear a conta do usuário.
     *
     * @var int
     */
    private $maxAttempts;

    /**
     * Create a new controller instance.
     *
     * @param ChecagemSenhaPadrao $checagemSenhaPadrao
     * @param Redirecionador $redirecionador
     * @param GerenciaConfiguracoes $configuracoes
     *
     * @param GerenciaSession $gerenciaSession
     *
     * @throws Exception
     */
    public function __construct(
        ChecagemSenhaPadrao $checagemSenhaPadrao,
        Redirecionador $redirecionador,
        GerenciaConfiguracoes $configuracoes,
        GerenciaSession $gerenciaSession
    ) {
        parent::__construct();
        $this->middleware('guest')->except('logout');

        $this->checagemSenhaPadrao = $checagemSenhaPadrao;
        $this->redirecionador = $redirecionador;
        $this->gerenciaSession = $gerenciaSession;

        $configuracoes = $configuracoes->buscarConfiguracoes();
        $this->maxAttempts = ($configuracoes->max_tentativas_login - 1);
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        // Só exibe o link de esqueci minha senha caso o email de envio de emails do sistema estiver configurado
        $emailConfigurado = !is_null(config('mail.password'));

        return view('auth.login', compact('emailConfigurado'));
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request)
    {
        $this->validateLogin($request);
        $usuarioPortadorCredenciais = $this->buscarUsuarioPortadorCredenciais($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request) && (bool) $usuarioPortadorCredenciais === false) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        // Valida se a conta do usuário portador das credenciais está bloqueada
        if ((bool) $usuarioPortadorCredenciais === true && $this->verificarContaDesativada($usuarioPortadorCredenciais)) {
            return $this->sendLoginDisabledResponse($request);
        }

        // Se requisição tirar parâmetro "acao" com valor "desbloquear-tela"
        // Usuário está com a tela bloqueado e está tentando se "autenticar" para desbloqueá-la
        // Caso contrário (else) faz a autenticação padrão
        if ($request->get('acao', null) === 'desbloquear-tela') {
            // Se credenciais informadas forem válidas
            // Importante essa condição não ficar no (if) acima pois se a mesma falhar irá cair no (else)
            if ((bool) $usuarioPortadorCredenciais === true) {
                $this->gerenciaSession->desbloquearTela($usuarioPortadorCredenciais->id);
                return $this->sendLoginResponse($request);
            }

            // Se credenciais informadas não forem válidas
            // Registra na auditoria tentativa falha de desbloqueio de tela
            if ((bool) $usuarioPortadorCredenciais === false) {
                auditar('usuario', auth()->user()->id, 'desbloqueio_tela_erro', auth()->user()->id, 'I');
            }
        } else if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return void
     */
    protected function validateLogin(Request $request)
    {
        $this->validate($request, [
            'login'    => 'required|string',
            'password' => 'required|string',
        ]);
    }

    /**
     * Busca usuário portador das credenciais
     * 
     * @param  \Illuminate\Http\Request $request
     *
     * @return Usuario
     */
    private function buscarUsuarioPortadorCredenciais(Request $request)
    {
        $credenciais = $this->credentials($request);

        // Busca usuário pelo login informado
        $usuario = Usuario::where('cpf', $credenciais['cpf'])->first();

        if (!$usuario) {
            return false;
        }

        // Senha informada é inválida
        if (!Hash::check($credenciais['password'], $usuario->senha)) {
            return false;
        }

        return $usuario;
    }

    /**
     * Valida usuário possui situação inativa ou bloqueado_tentativa
     *
     * @param Usuario $usuario
     *
     * @return bool
     */
    private function verificarContaDesativada(Usuario $usuario)
    {
        // Se usuário possuir situação inativo ou bloqueado_tentativa e não for super_admin, retorna TRUE
        if ($usuario->temSituacao(['inativo', 'bloqueado_tentativa']) && !$usuario->super_admin) {
            // Registra na auditoria tentativa de login 
            auditar('usuario', $usuario->id, 'login_bloqueado', $usuario->id, 'I');
            return true;
        }

        return false;
    }

    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return array
     */
    protected function credentials(Request $request)
    {
        return [
            'cpf'      => Mascarado::removerMascara($request->get('login')),
            'password' => $request->get('password')
        ];
    }

    /**
     * Response para login desativado.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    protected function sendLoginDisabledResponse(Request $request)
    {
        if ($request->wantsJson()) {
            return response()->json(['data' => [
                'errors' => [
                    'Não foi possível fazer login no sistema, sua conta está desativada.'
                ]
            ]], 403);
        }

        flash('Não foi possível fazer login no sistema, sua conta está desativada.')->error();

        return redirect()->back()->withInput($request->only('login', 'remember'));
    }

    /**
     * Send the response after the user was authenticated.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     * @throws Exception
     */
    protected function sendLoginResponse(Request $request)
    {
        $this->clearLoginAttempts($request);

        if ($request->wantsJson()) {
            return response()->json(['data' => true]);
        }

        return $this->authenticated($request, $this->guard()->user())
            ?: redirect()->intended($this->redirectPath());
    }

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  mixed $user
     *
     * @return mixed
     * @throws Exception
     */
    protected function authenticated(Request $request, $user)
    {
        $redirecionamento = $this->redirecionador->descobrirRedirecionamento($user, $request->password);

        return redirect()->intended($redirecionamento);
    }

    /**
     * Get the failed login response instance.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        // Trata se retorna é ou não json
        if ($request->wantsJson()) {
            return response()->json(['data' => [
                'errors' => [
                    'Login ou senha incorretos. Por favor, tente novamente.'
                ]
            ]], 403);
        }

        flash('Login ou senha incorretos. Por favor, tente novamente.')->error();

        return redirect()->back()->withInput($request->only('login', 'remember'));
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return 'login';
    }
}
