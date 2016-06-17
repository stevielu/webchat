<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
/*model*/
use App\Models\Chat;
/*Auth*/
use App\User;
use Validator;
use Auth;
use Session;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Hash;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public $currentfocus;
    public $section;
    public $chatroom;
    public $accountinfo;
    public $user;
    public $username;
    public function __construct()
    {
        // $this->middleware('guest', ['except' => 'getLogout']);
        $this->user = Session::get('loginInfo');
        $this->accountinfo = User::where('email', $this->user['email'])->first();

        $this->currentfocus ='sidebar_userdashboard';
        $this->section ='default';
        $this->chatroom = Chat::with('SubClass')->get();
        $this->username = User::select('name')->where('email',$this->user['email'])->first();
        Session::put('loginInfo.name',$this->username['name']);
    }

    public function index()
    {
       
        $username = $this->username['name'];
        

        //$username = $username['name'];
        
        //get chat room from database
        $chatroom = $this->chatroom;
        $currentfocus = $this->currentfocus;
        $section = $this->section;
        $accountinfo = $this->accountinfo;

        return view('layouts/chatroom', compact('username','chatroom','currentfocus','accountinfo','section'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }
    public function getProfile(){
        $this->section = 'profile';
        $username = $this->username['name'];
        $chatroom = $this->chatroom;
        $currentfocus = $this->currentfocus;
        $section = $this->section;
        $accountinfo = $this->accountinfo;
        if($accountinfo['my_avatar']==NUll){
            $accountinfo['my_avatar'] = 'no-thumb.png';
        }
        return view('layouts/chatroom', compact('username','chatroom','currentfocus','accountinfo','section'));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $user)
    {

        $rules = array(
          'name' => 'required|max:255',
          'email' => 'required|email|max:255',
          'password' => 'min:9|regex:/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{9,}$/',
          'phone' => 'required|numeric|min:10'
        );
        $validator = Validator::make($user->all(), $rules);
        if($validator->fails()){
            $this->section = 'errorpage';
            return redirect()->back()->with('errorinfo',$validator->errors());
          // ->withErrors($validator)
          // ->withInput();
        }
            
        if($user['password']!=''){
            User::where('name',$this->username['name'])->update(
                ['password' => bcrypt($user['password'])]);
        }

        User::where('name',$this->username['name'])->update([
            'name' => $user['name'],
            'email' => $user['email'],
            'phone' => $user['phone']
        ]);
        Session::put('loginInfo.email',$user['email']); 
        
        return redirect('/user/account');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function back(){
        return redirect()->back();
    }
}
