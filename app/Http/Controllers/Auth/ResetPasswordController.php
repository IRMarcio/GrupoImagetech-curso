<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\Mascarado;
use App\Services\ValidaSenhaAlterada;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use App\Services\Usuario\AlterarSenha;


class ResetPasswordController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/login';

    /**
     * @var ValidaSenhaAlterada
     */
    private $validaSenhaAlterada;

    /**
     * @var AlterarSenha
     */
    private $alterarSenha;

    /**
     * Create a new controller instance.
     *
     * @param ValidaSenhaAlterada $validaSenhaAlterada
     * @param AlterarSenha $alterarSenha
     */
    public function __construct(ValidaSenhaAlterada $validaSenhaAlterada, AlterarSenha $alterarSenha)
    {
        parent::__construct();

        $this->middleware('guest');
        $this->validaSenhaAlterada = $validaSenhaAlterada;
        $this->alterarSenha = $alterarSenha;
    }

    /**
     * Display the password reset view for the given token.
     *
     * If no token is present, display the link request form.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  string|null $token
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showResetForm(Request $request, $token = null)
    {
        return view('auth.resetar')->with(
            ['token' => $token]
        );
    }

    /**
     * Reset the given user's password.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function reset(Request $request)
    {
        $this->validate($request, $this->rules(), $this->validationErrorMessages());

        // Busca o usuário para podermos validar a senha inserida por ele
        $usuario = Auth::guard()->getProvider()->retrieveByCredentials(
            Arr::except($this->credentials($request), 'token')
        );

        if (!$usuario) {
            return $this->sendInvalidResetResponse();
        }

        $valido = $this->validaSenhaAlterada->validar($usuario, $request->password);
        if (!$valido) {
            return $this->sendInvalidResetResponse();
        }

        // Here we will attempt to reset the user's password. If it is successful we
        // will update the password on an actual user model and persist it to the
        // database. Otherwise we will parse the error and return the response.
        $response = $this->broker()->reset($this->credentials($request), function ($user, $password) {
            $this->resetarSenha($user, $password);
        });

        // If the password was successfully reset, we will redirect the user back to
        // the application's home authenticated view. If there is an error we can
        // redirect them back to where they came from with their error message.
        return $response == Password::PASSWORD_RESET
            ? $this->sendResetResponse($response)
            : $this->sendResetFailedResponse($request, $response);
    }

    /**
     * Get the password reset validation rules.
     *
     * @return array
     */
    protected function rules()
    {
        return [
            'token'    => 'required',
            'login'    => 'required',
            'password' => 'required|confirmed|min:3',
        ];
    }

    /**
     * Get the password reset credentials from the request.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return array
     */
    protected function credentials(Request $request)
    {
        $data = $request->only(
            'password', 'password_confirmation', 'token'
        );

        $data['cpf'] = $this->getSanitize($request->get('login'));

        return $data;
    }

    /**
     * Envia uma response indicando que a senha digitada é invalida baseada em algumas regras do próprio sistema.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendInvalidResetResponse()
    {
        flash('A nova senha informada não está de acordo com os padrões de segurança do sistema. Tente outra senha mais segura.')->error();

        return redirect()->back();
    }

    /**
     * Reset the given user's password.
     *
     * @param  \Illuminate\Contracts\Auth\CanResetPassword|\Illuminate\Contracts\Auth\Authenticatable $user
     * @param  string $password
     *
     * @return void
     * @throws \Exception
     */
    protected function resetarSenha($user, $password)
    {
        $this->alterarSenha->alterar($user, $password);

        $this->guard()->login($user);
    }

    /**
     * Envia a response indicando que algo deu errado ao resetar a senha.
     *
     * @param  \Illuminate\Http\Request
     * @param  string $response
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendResetFailedResponse(Request $request, $response)
    {
        flash('Houve um erro ao gerar a nova senha, contate o suporte técnico.', 'danger');

        return redirect()->back();
    }

    /**
     * Reset the given user's password.
     *
     * @param  \Illuminate\Contracts\Auth\CanResetPassword|\Illuminate\Contracts\Auth\Authenticatable $user
     * @param  string $password
     *
     * @return void
     */
    protected function resetPassword($user, $password)
    {
        $user->forceFill(
            [
                'senha' => $password
            ]
        )->save();

        $this->guard()->login($user);
    }

    private function getSanitize($data)
    {
        return Mascarado::removerMascara($data);
    }
}
