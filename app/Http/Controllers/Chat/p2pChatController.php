<?php

namespace App\Http\Controllers\\Chat;

use Illuminate\Http\Request;
use App\Models\Chat;
use App\Models\Channels;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Session;

class p2pChatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        // $this->middleware('guest', ['except' => 'getLogout']);
        $user = Session::get('loginInfo');
        //$username = User::select('name')->where('email',$user['email'])->first();
        $this->user = User::where('email',$user['email'])->first();
        //var_dump($test['my_avatar']);
        $user = Session::put('loginInfo.name',$this->user['name']);

    }

    public function index()
    {
        $username = $this->user['name'];
        //get chat room from database
        $chatroom = Chat::with('SubClass')->get();
        $this->chatroom = $chatroom;
        $currentfocus = 'sidebar_recent';
        return view('layouts/chatroom', compact('username','chatroom','currentfocus'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
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
    public function show($user)
    {
       Session::put('chatRecentLists',array_add($users = Session::get('chatRecentLists'),$user,$user));
       return redirect('/chatto')->with('chat-to',$user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
}
