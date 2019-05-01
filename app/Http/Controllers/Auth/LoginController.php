<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

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

    use AuthenticatesUsers {
        validateLogin as laravelValidateLogin;
    }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function validateLogin(Request $request)
    {
        $messages = [
            'required' => ':attribute không được trống.',
            'string' => ':attribute phải là chuỗi kí tự',
            'g-recaptcha-response.string' => 'Yêu cầu xác nhận captcha',
        ];

        $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string',
            'g-recaptcha-response' => ['required', new \App\Rules\ValidRecaptcha]
        ]);
    }
}
