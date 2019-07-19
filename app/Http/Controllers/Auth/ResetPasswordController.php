<?php

namespace indiashopps\Http\Controllers\Auth;

use Illuminate\Http\Request;
use indiashopps\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use indiashopps\Models\PasswordReset;

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
    protected $redirectTo = '/myaccount';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Display the password reset view for the given token.
     *
     * If no token is present, display the link request form.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  string|null $token
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showResetForm(Request $request, $token = null)
    {
        $tokens = PasswordReset::all();
        $exists = false;

        foreach ($tokens as $req) {
            if (\Hash::check($token, $req->token)) {
                $exists = true;
                break;
            }
        }

        if ($exists) {
            if (isMobile()) {
                return view('v3.mobile.auth.passwords.reset')->with(['token' => $token, 'email' => $req->email]);
            } else {
                return view('v3.auth.passwords.reset')->with(['token' => $token, 'email' => $req->email]);
            }
        }

        return redirect()->route('password.reset_form')->withErrors('Invalid / Expired LINK..');
    }
}
