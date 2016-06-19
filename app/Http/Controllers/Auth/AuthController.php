<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use Auth;
use Hash;
use Session;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;
    protected $auth;
    protected $login;
    protected $registerStauts;
    protected $loginStauts;
    protected $users;
    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/chat';
    //protected $redirectLogin= '/chat';
    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct(Guard $auth,User $users)
    {
        // $this->middleware('guest', ['except' => 'getLogout']);
        $this->auth = $auth;
        $this->login ='unlogin';
        $this->registerStauts = null;
        $this->users = $users;
    }

    public function index()
    {
    
        if ($this->auth->check()){
            // $status = null;
            //return redirect()->back();
            return redirect('/chat');
        }
        return view('layouts.login',['registerStauts'=>$this->registerStauts]);
        //return;
    }
    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    public function store(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (Auth::attempt(['email'=> $credentials['email'], 'password' =>  $credentials['password']], $request->has('remember'))){
            $this->login = 'logined';
            Session::forget('loginInfo');
            Session::put('loginInfo',$credentials);
            return redirect('/chat');
            //return view('layouts.index',['loginStauts'=>$this->login]);
        }
        else{
            $loginStauts = 'fail';
            return redirect('/')->with('loginStauts',$loginStauts);
            // return view('layouts.login',['loginStauts'=>$this->loginStauts]);
        }
        
    }
    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */

    public function getLogout()
    {
        Auth::logout();
        return redirect('/');
    }

    protected function create(Request $data)
    {
        $rules = array(
          'name' => 'required|max:25|unique:users',
          'email' => 'required|email|max:255|unique:users',
          'password' => 'required|min:6|regex:/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{9,}$/'
        );
        $validator = Validator::make($data->all(), $rules);
        if($validator->fails()){
            return view('layouts.login',['registerStauts'=>$validator->errors()]);
          // ->withErrors($validator)
          // ->withInput();
        }
        Auth::login($this->users->create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password'])
        ]));
        
        Session::put('loginInfo.email',$data['email']);
        return redirect('/chat');
        
    }


}
