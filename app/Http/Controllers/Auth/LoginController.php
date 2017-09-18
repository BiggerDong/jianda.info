<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Question;
use App\User;
use Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Overtrue\LaravelSocialite\Socialite;

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
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        $message = User::all();
        $question = Question::all();
        return view('auth.login',compact('message','question'));
    }

    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function validateLogin(Request $request)
    {
        $this->validate($request, [
            $this->username() => 'required|string',
            'password' => 'required|string',
            'captcha' => 'required|captcha',
        ]);
    }

    public function weibo()
    {
        return Socialite::driver('weibo')->redirect();
    }

    public function weiboCallback()
    {
        $weiboUser = Socialite::driver('weibo')->user();
        $allUser = User::all();

        if ($allUser->contains('auth_type','weibo') && $allUser->contains('auth_id',$weiboUser['id'])) {
            $loginUser = User::where('auth_type','weibo')->where('auth_id',$weiboUser['id'])->first();
            Auth::login($loginUser);
            return redirect('/');
        }
        $content = file_get_contents($weiboUser['avatar']);
        $fileName = 'avatars/'.md5($weiboUser['id'].time());
        $disk = Storage::disk('qiniu');
        $disk->put($fileName, $content);
        User::create([
            'auth_type' => 'weibo',
            'auth_id' => $weiboUser['id'],
            'uid' => time().rand(10000,99999),
            'name' => $weiboUser['name'],
            'avatar' => 'http://'.env('QINIU_DOMAIN').'/'.$fileName,
            'api_token' => str_random('60'),
            'settings' => ['city' => '','school' => '','company' => '']
        ]);
        $loginUser = User::where('auth_type','weibo')->where('auth_id',$weiboUser['id'])->first();
        Auth::login($loginUser);
        return redirect('/');
    }

    public function qq()
    {
        return Socialite::driver('qq')->redirect();
    }

    public function qqCallback()
    {
        $qqUser = Socialite::driver('qq')->user();
        $allUser = User::all();

        if ($allUser->contains('auth_type','qq') && $allUser->contains('auth_id',$qqUser['id'])) {
            $loginUser = User::where('auth_type','qq')->where('auth_id',$qqUser['id'])->first();
            Auth::login($loginUser);
            return redirect('/');
        }
        $content = file_get_contents($qqUser['avatar']);
        $fileName = 'avatars/'.md5($qqUser['id'].time());
        $disk = Storage::disk('qiniu');
        $disk->put($fileName, $content);
        User::create([
            'auth_type' => 'qq',
            'auth_id' => $qqUser['id'],
            'uid' => time().rand(10000,99999),
            'name' => $qqUser['name'],
            'avatar' => 'http://'.env('QINIU_DOMAIN').'/'.$fileName,
            'api_token' => str_random('60'),
            'settings' => ['city' => '','school' => '','company' => '']
        ]);
        $loginUser = User::where('auth_type','qq')->where('auth_id',$qqUser['id'])->first();
        Auth::login($loginUser);
        return redirect('/');
    }

    public function github()
    {
        return Socialite::driver('github')->redirect();
    }

    public function githubCallback()
    {
        $githubUser = Socialite::driver('github')->user();
        $allUser = User::all();

        if ($allUser->contains('auth_type','github') && $allUser->contains('auth_id',$githubUser['id'])) {
            $loginUser = User::where('auth_type','github')->where('auth_id',$githubUser['id'])->first();
            Auth::login($loginUser);
            return redirect('/');
        }
        $content = file_get_contents($githubUser['avatar']);
        $fileName = 'avatars/'.md5($githubUser['id'].time());
        $disk = Storage::disk('qiniu');
        $disk->put($fileName, $content);
        User::create([
            'auth_type' => 'github',
            'auth_id' => $githubUser['id'],
            'uid' => time().rand(10000,99999),
            'name' => $githubUser['name'],
            'avatar' => 'http://'.env('QINIU_DOMAIN').'/'.$fileName,
            'api_token' => str_random('60'),
            'settings' => ['city' => '','school' => '','company' => '']
        ]);
        $loginUser = User::where('auth_type','github')->where('auth_id',$githubUser['id'])->first();
        Auth::login($loginUser);
        return redirect('/');
    }



}
