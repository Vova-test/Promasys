<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Services\PanicService;
use App\Services\MailService;
use Carbon\Carbon;

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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(PanicService $panicService, MailService $mailService)
    {
        $this->panicService = $panicService;
        $this->mailService = $mailService;
    }

    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string',
            'g-recaptcha-response' => 'required|captcha',
        ]);
    }

    protected function panic(Request $request)
    {
        $response = $this->panicService->panic();

        if (is_array($response)) {
            $this->guard()->logout();

            $request->session()->invalidate();

            $request->session()->regenerateToken();

            $this->mailService->send($response['email'], 'mail.panic', ['newPassword' => $response['password']]);
        }

        return redirect('/');
    }

    protected function authenticated(Request $request, $user)
    {
        $data = [
            'name' => $user->name,
            'loginAt' => Carbon::now()->toDateTimeString()
        ];

        $this->mailService
             ->send($user->email, 'mail.login', $data);

        return  redirect()->intended($this->redirectPath());
    }
}
