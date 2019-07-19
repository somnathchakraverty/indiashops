<?php namespace indiashopps\Http\Controllers;

use Carbon\Carbon;
use DB;
use Illuminate\Support\Facades\Cache;
use indiashopps\Console\Commands\HeaderJson;
use indiashopps\Http\Controllers\Controller;
use indiashopps\Helpers\helper;
use indiashopps\AndUser;
use Illuminate\Http\Request;
use Illuminate\Hashing;
use Illuminate\Support\Facades\Session;
use Auth;
use Laravel\Socialite\Facades\Socialite;

class ExtensionController extends Controller
{
    /**
     * Thank you page ONCE the user install a NEW Chrome extension..
     *
     * @var \Illuminate\Http\Request
     */

    public function thankyou(Request $request)
    {
        // echo date("Y-m-d h:i:s");exit;
        $code = str_replace(" ", "+", $request->get("code"));

        if (empty($code)) {
            //Invalid access to the page..
            return redirect('/?utm_source=chrome-extension&medium=incorrect-code');
        }

        // Save the user information..
        if ($request->isMethod('post')) {
            $data['email']        = $request->get('username');
            $data['gender']       = $request->get('gender');
            $data['interests']    = json_encode($request->get('interests'));
            $data['password']     = \Hash::make($request->get('password'));
            $data['extension_id'] = $this->decode($code);
            $data['join_date']    = Carbon::now()->toDateTimeString();

            $user = $this->saveUser($data);

            $cookie = cookie()->forever('indshp_user_gender', $data['gender']);

            return redirect('/?utm_source=chrome-extension&medium=success')->withCookie($cookie);
        }

        $data['cats']       = helper::get_categories();
        $data['registered'] = $this->decode($code, true);

        if ($data['registered'] == "incorrect") {
            //Invalid Hash Key Specified.
            return redirect('/?utm_source=chrome-extension&medium=incorrect-code');
        } else {
            Session::set('ext_id', $this->decode($code));
        }

        return view('v1.extension.thankyou', $data);
    }

    /**
     * Social Login and registration Using Facebook, Google+
     *
     * @uses HybriAuth Library /library/hybridauth
     * @var Social Site Provider
     */
    public function login($provider)
    {
        try {
            $social = Socialite::driver($provider);

            if ($provider == 'facebook') {
                $social->setScopes([
                    'email',
                    'user_birthday',
                    'user_hometown',
                    'user_location',
                    'user_gender'
                ]);
            }

            return $social->redirect();
        }
        catch (Exception $e) {
            echo "Ooophs, we got an error: " . $e->getMessage();
        }
    }

    public function saveUser($data)
    {
        $user = AndUser::where('email', '=', $data['email'])->first();

        if (empty($user)) {
            $user = new AndUser($data);
            $user->save();
        }

        return $user;
    }

    /**
     * This is the function when user is authenticated and then sent to the social login control
     * Check the config file under hybridAuth for more settings..
     *
     */
    public function processFbAuth()
    {
        $user = Socialite::driver('facebook')->user();

        if (!empty($user->birthYear) && !empty($user->birthMonth) && !empty($user->birthDay)) {
            $bday = date("Y-m-d", strtotime("$user->birthYear-$user->birthMonth-$user->birthDay"));
        } else {
            $bday = "0000-00-00";
        }

        $info = collect($user->user);
        //Save user information from Social Login..
        $data['pimage']    = $user->avatar;
        $data['name']      = $user->name;
        $data['gender']    = $info->get('gender');
        $data['bday']      = $bday;
        $data['email']     = $info->get('email');
        $data['city']      = $info->get('city');
        $data['device_id'] = "site";
        $data['active']    = 1;
        $data['join_date'] = Carbon::now()->toDateTimeString();

        return $this->saveDetail($data);

    }

    /**
     * This is the function when user is authenticated and then sent to the social login control
     * Check the config file under hybridAuth for more settings..
     *
     */
    public function processGoogleAuth()
    {
        $user = Socialite::driver('google')->user();

        $info = collect($user->user);

        if (!empty($info->birthYear) && !empty($info->birthMonth) && !empty($info->birthDay)) {
            $bday = date("Y-m-d", strtotime("$info->birthYear-$info->birthMonth-$info->birthDay"));
        } else {
            $bday = "0000-00-00";
        }

        //Save user information from Social Login..
        $data['pimage']    = $user->avatar;
        $data['name']      = $user->name;
        $data['gender']    = $info->get('gender');
        $data['bday']      = $bday;
        $data['email']     = $user->getEmail();
        $data['city']      = $info->get('city');
        $data['device_id'] = "site";
        $data['active']    = 1;
        $data['join_date'] = Carbon::now()->toDateTimeString();

        return $this->saveDetail($data, 'google_login');

    }

    public function saveDetail($data, $source = 'facebook_login')
    {
        if (Session::has('ext_id')) {
            $data['extension_id'] = Session::get('ext_id');
            Session::forget('ext_id');
        }

        $user = $this->saveUser($data);

        Auth::loginUsingId($user->id);

        if (isMobile()) {
            Cache::forget(HeaderJson::getMenuCacheKey());
        }

        // Sets the user gender in the browser cookie for search results from the search page.

        $gender  = cookie()->forever('indshp_user_gender', $data['gender']);
        $user_id = cookie()->forever('ext_user_id', $user->id);

        $params = ['utm_source' => $source, 'medium' => 'success'];

        return redirect()->route('cashback.earnings', $params)->withCookie($gender)->withCookie($user_id);
    }

    /**
     * Decode the Hashed Key for extention installation and verifying the Hash Key..
     *
     * @var Hashed Code
     */
    private function decode($code, $verify = false)
    {
        if (empty($code) || strlen($code) < 22) {
            return "incorrect";
        } else {
            $key = "nitishExt@1708";

            try {
                $data = base64_decode($code);

                $iv = substr($data, 0, mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC));

                $decrypted = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_128, hash('sha256', $key, true), substr($data, mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC)), MCRYPT_MODE_CBC, $iv), "\0");
            }
            catch (Exception $e) {
                return redirect("/");
            }

            if ($verify) {
                $count = AndUser::where('extension_id', '=', $decrypted)->count();

                if ($count == 0) {
                    return false;
                } else {
                    if (is_numeric($decrypted)) {
                        return $decrypted;
                    } else {
                        return "incorrect";
                    }
                }
            } else {
                if (is_numeric($decrypted)) {
                    return $decrypted;
                } else {
                    return false;
                }
            }
        }
    }
}