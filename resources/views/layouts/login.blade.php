@extends('layouts.default',['layout'=>'one-column'])
@section('header')
<link rel="stylesheet" href="{{asset('css/login.css')}}"/>
@endsection

@section('mainboxbody')
<div class="login-container">
	<div class="col-md-7 banner">
		<div class="login-title">
			<h2>Hi There,</h2><h2>Feel Free To Chat In Here.</h2>
		</div>
		<div class="banner-box">
			<p>Hi, I am Stevie. This is my personal portflio. It's a Chatroom which was built by Laravel 5.2 & Nodejs. If you enjoy it. You can visit the source code in my github:<a href="https://github.com/stevielu/webchat">https://github.com/stevielu/webchat</a></p>
		</div>

	</div>
	<div class="col-md-5 visitor">
		<img src="{{asset('login7.jpeg')}}">
		<div class="img-mask1"></div>
		<div class="login-title">
			<h2>Welcome-Login</h2>
		</div>
		<form class="login-box">
			<input placeholder="Your Email"></input>
			<input placeholder="Your Password"></input>
			<button type="submit">Login</button>
			<a href="#">Forget Password ?</a>
		</form>
	</div>
</div>
@endsection