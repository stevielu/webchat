<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;
use App\Http\Requests;
/*model*/
use App\Models\Chat;
use App\Models\Profiles;
/*Auth*/
use App\User;
use Validator;
use Auth;
use Session;
use Storage;
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


    public function editProfile(Request $profile){
        $file = $profile->file('avatar');
        return;
        $user = Profiles::where('user_id',$this->accountinfo['id'])->exists();

        $data = array(
                'user_id' => $this->accountinfo['id'],
                'user_intro' => $profile['intro'],
                'address_city' => $profile['city'],
                'address_suburb' => $profile['suburb'],
                'user_age' => $profile['age'],
                'user_gender' => $profile['gender'],
                );

        $rules = array(
          'age' => 'numeric|max:200',
          'city' => 'max:10',
          'suburb' => 'max:20'
        );

        $validator = Validator::make($profile->all(), $rules);

        if ($validator->fails())
        {
            $this->section = 'errorpage';
            return redirect()->back()->with('errorinfo',$validator->errors());
        }

        if($user == false){
            Profiles::create($data);
        }
        else{
            Profiles::where('user_id',$this->accountinfo['id'])->update($data);
        }


        if ($file) {
            $rules = array(
              'avatar' => 'mimes:jpeg,jpg,png,gif|siz:1000'
            );
            $validator = Validator::make($profile->all(), $rules);

            if ($validator->fails())
            {
                $this->section = 'errorpage';
                return redirect()->back()->with('errorinfo',$validator->errors());
            }
            else{
                $filename  = $this->username['name'].'.'.$file->getClientOriginalExtension();
                $path = config('filepath.user.profile').$filename;
                $background = Image::canvas(150, 150);
                $img = Image::make($file)->resize(150, null, function ($c) {
                                                        $c->aspectRatio();
                                                        $c->upsize();
                                                    });
                $background->insert($img, 'top');
                Storage::put($path, $background->stream());

                User::where('id',$this->accountinfo['id'])->update(
                ['my_avatar' => $path]);
            }

        }
        return redirect('/user/profile')->with('update_status','Update Success');
        
        
        //$profile->file('photo')->move($destinationPath, $fileName);
    }

    public function getProfile(){
        $this->section = 'profile';
        $username = $this->username['name'];
        $chatroom = $this->chatroom;
        $currentfocus = $this->currentfocus;
        $section = $this->section;
        $accountinfo = $this->accountinfo;

        $profile = Profiles::where('user_id',$this->accountinfo['id'])->first();
        //$new = (object) array_merge((array) $this->accountinfo, (array) $profile);
        if($this->accountinfo['my_avatar']==NUll){
            $accountinfo['my_avatar'] = 'user-avatar/no-thumb.png';
        }
        return view('layouts/chatroom', compact('username','chatroom','currentfocus','accountinfo','section','profile'));
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
