<?php

namespace indiashopps\Http\Controllers\v3;

use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use indiashopps\Events\CompanyCreated;
use indiashopps\Models\Referral;
use indiashopps\User;

class AuthController extends BaseController
{
    /**
     * @param Request $request
     * @return $this|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function login(Request $request)
    {
        if (Auth::check()) {
            //Redirect to Myaccount page, if already Logged in..
            return redirect()->route('cashback.earnings')->with("message", "Already Logged in.. !");
        }

        if ($request->isMethod('post')) {
            $validator = \Validator::make($request->all(), [
                'email'    => 'required|email',
                'password' => 'required',
            ]);

            // Validation Failed..
            if ($validator->fails()) {
                $messages = $validator->messages();
                return redirect()->back()->with("errors", $messages);
            } elseif (Auth::attempt([
                'email'    => $request->get('email'),
                'password' => $request->get('password')
            ], $request->has('remember'))
            ) {
                auth()->user()->userConditionChecks();

                // Valid Login attempt.....
                if ($request->has('redirect_url')) {
                    return redirect($request->redirect_url);
                } else {
                    return redirect()
                        ->route('cashback.earnings')
                        ->withCookie(cookie()->forever('ext_user_id', auth()->user()->id));
                }
            } else {
                //Invalid Login attempt..
                $errors = new MessageBag(['password' => ['Email and/or password invalid.']]);
                return redirect()->back()->withInput()->withErrors($errors);
            }
        }

        $data['cats']       = \helper::get_categories();
        $data['registered'] = false;

        if (session()->has('success')) {
            $data['success'] = session("success");
        }

        $this->seo->setTitle("Login to IndiaShopps");

        return view('v3.auth.login');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function signup(Request $request)
    {
        if (Auth::check()) {
            //Redirect If already Loggedn in, with Success Message...
            return redirect()->route('cashback.earnings')->with("message", "Already Logged in.. !");
        }

        if ($request->isMethod('post')) {
            // POST Form Validation
            $rules = [
                'email'    => 'required|email|unique:and_user',
                'name'     => 'required',
                'mobile'   => 'nullable|digits:10',
                'password' => 'required|min:6',
                'gender'   => 'required',
            ];

            $msg = [];

            if (!empty($request->get('referral_code'))) {
                $rules['referral_code']      = 'exists:referrals,code';
                $msg['referral_code.exists'] = 'Invalid Referral Code !';
            }

            if ($request->get('user_type') == 'corporate') {
                $rules['company_name'] = 'required';
                $rules['address']      = 'required';
                if ($request->has('gst') && $request->get('gst')) {
                    $rules['gst'] = 'required|regex:/^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$/';
                }
            }

            $validator = \Validator::make($request->all(), $rules, $msg);

            if ($validator->fails()) {
                //If Validation Fails
                return redirect()->back()->withInput()->with("errors", $validator->messages());
            }

            // ELSE create a new User
            $data['email']     = $request->get('email');
            $data['gender']    = $request->get('gender');
            $data['interests'] = json_encode($request->get('interests'));
            $data['password']  = \Hash::make($request->get('password'));
            $data['name']      = $request->get('name');
            $data['mobile']    = $request->get('mobile');
            $data['join_date'] = Carbon::now()->toDateTimeString();

            if (!empty($request->get('referral_code'))) {
                $referrer            = Referral::whereCode($request->get('referral_code'))->first();
                $data['referrer_id'] = $referrer->id;
            }

            $user = new User($data);
            $user->save();

            if ($request->get('user_type') == 'corporate') {
                event(new CompanyCreated($user, $request->all()));
            }

            //Login the user by Default once user Registers..
            if ($user->id) {
                \Auth::loginUsingId($user->id);

                auth()->user()->userConditionChecks();

                if ($request->has('redirect_url')) {
                    return redirect($request->redirect_url);
                }
                return redirect()
                    ->route('cashback.earnings')
                    ->withCookie(cookie()->forever('ext_user_id', auth()->user()->id));;
            }
        }

        //If any Error Message is set..
        if (session()->has('errors')) {
            $data['errors'] = session("errors");
        }

        // Get Top level Categories to show as suggestion to the user..
        $data['cats']        = \helper::get_categories();
        $data['home']        = json_decode(file_get_contents(config('url.home_json_url')));
        $data['brand_names'] = $data['home']->block1->tab1->brands_name;

        unset($data['home']);

        $this->seo->setTitle("Create Your IndiaShopps Account");

        return view('v3.auth.register', $data);
    }
}
