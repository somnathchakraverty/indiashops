<?php namespace indiashopps\Http\Controllers\v2;

use helper;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use indiashopps\AndUser;
use indiashopps\Http\Controllers\Controller;

class AuthController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function login(Request $request)
    {
        if (Auth::check()) {
            //Redirect to Myaccount page, if already Logged in..
            return redirect("myaccount")->with("success", array("Already Logged in.. !"));
        }

        if ($request->isMethod('post')) {
            $validator = \Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required',
            ]);

            // Validation Failed..
            if ($validator->fails()) {
                $messages = $validator->messages();
                return redirect()->back()->with("errors", $messages);
            } elseif (Auth::attempt(['email' => $request->get('email'), 'password' => $request->get('password')], $request->has('remember'))) {
                // Valid Login attempt.....
                return redirect()->route('home_v2');
            } else {
                //Invalid Login attempt..
                $errors = new MessageBag(['password' => ['Email and/or password invalid.']]);
                return redirect()->back()->withInput()->withErrors($errors);
            }
        }

        $data['cats'] = helper::get_categories();
        $data['registered'] = false;

        if (session()->has('success')) {
            $data['success'] = session("success");
        }

        return view('v2.auth.login');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function signup(Request $request)
    {
        if (Auth::check()) {
            //Redirect If already Loggedn in, with Success Message...
            return redirect("myaccount")->with("success", array("Already Logged in.. !"));
        }

        if ($request->isMethod('post')) {
            // POST Form Validation
            $validator = \Validator::make($request->all(), [
                'email' => 'required|email|unique:and_user',
                'name' => 'required',
                'password' => 'required|min:6',
                'gender' => 'required',
            ]);

            if ($validator->fails()) {
                //If Validation Fails
                $messages = $validator->messages();
                return redirect()->back()->with("errors", $messages);
            }

            // ELSE create a new User
            $data['email'] = $request->get('email');
            $data['gender'] = $request->get('gender');
            $data['interests'] = json_encode($request->get('interests'));
            $data['password'] = \Hash::make($request->get('password'));
            $data['name'] = $request->get('name');
            $data['join_date'] = Carbon::now()->toDateTimeString();

            $user = new AndUser($data);
            $user->save();

            //Login the user by Default once user Registers..
            if ($user->id) {
                Auth::loginUsingId($user->id);

                return redirect()->route('home_v2');
            }
        }

        //If any Error Message is set..
        if (session()->has('errors')) {
            $data['errors'] = session("errors");
        }

        // Get Top level Categories to show as suggestion to the user..
        $data['cats'] = helper::get_categories();
        $data['home'] = json_decode(file_get_contents(config('url.home_json_url')));
        $data['brand_names'] = $data['home']->block1->tab1->brands_name;

        unset($data['home']);

        return view('v2.auth.register', $data );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

}
