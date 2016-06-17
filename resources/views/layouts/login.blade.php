@extends('layouts.default',['layout'=>'one-column'])
@section('header')
<link rel="stylesheet" href="{{asset('css/login.css')}}"/>
<script type="text/javascript" src="{{asset('js/strength.js')}}"></script>
@endsection

@section('mainboxbody')
<div class="login-container">
	<div class="col-md-7 banner">

		<div class="login-title">
			<h2>Hi There,</h2><h2>Feel Free To Chat In Here.</h2>
		</div>
		<div class="banner-box">
			<p>Hi, I am Stevie. This is my personal portflio. It's a Chatroom which was built by Laravel 5.2 & Nodejs. If you enjoy it. You can visit the source code in my github:&nbsp<a target="_BLANK" href="https://github.com/stevielu/webchat">https://github.com/stevielu/webchat</a></p>
			<p>No Accouts?</p>
			<button type="button" id='create-page'>Create Account</button>
		</div>

	</div>
	<div class="col-md-5 visitor">
		<img src="{{asset('login7.jpeg')}}">
		<div class="img-mask1"></div>
		<div class="login-title">
			<h2>Welcome-Login</h2>

			
		</div>
		<form class="login-box"  method="post">
			{!! csrf_field() !!}
			<input type = 'email' name='email' placeholder="Your Email"></input>
			<input type='password' require='6' name='password' placeholder="Your Password"></input>
			<button type="submit">Login</button>
			<a href="#">Forget Password ?</a>
			@if(Session::has('loginStauts'))
				<?php $loginError = Session::get('loginStauts')?>
				@if($loginError=='fail')
				<h2 class="error_info">Password or Account Error</h2>
				@endif
			@endif
		</form>

	</div>
	@if($registerStauts)
	<div class="col-md-5 register" style="right:0px !important;display: block;">
	@else
	<div class="col-md-5 register">
	@endif
			
			<a href="#" id="dismiss-register" class="fa fa-times" style="z-index:999;color: #fff !important;display: block;padding: 15px;"></a>
			<div class="login-title">
				<h2>Register Here</h2>

			</div>
			<form id='create-accout' action="create" class="login-box">
				<input type = 'text' required name='name' placeholder="Your Name"></input>
				<input type = 'email' required name='email' placeholder="Your Email"></input>
				<input id='create-pass' type='password' name='password' required min="6" placeholder="Your Password"></input>
				<span class="fa fa-times" style="color:#fff; padding-left: 5px;"></span>
				<span class="fa fa-check" style="color:#DCE775; padding-left: 5px;"></span>
				@if($registerStauts)
					<p>{{$registerStauts->first("name")}}</p>
					<p>{{$registerStauts->first("password")}}</p>
					<p>{{$registerStauts->first("email")}}</p>
				@endif
				
				<!-- <input id='confirm-pass' type='password' required min="6" placeholder="Re-Enter Your Password"></input><span class="fa fa-times" style="color:#424242; padding-left: 5px;"></span> -->
				<button type="submit">Submit</button>
			</form>
		
	</div>
</div>
<script type="text/javascript">
	$('#create-page').click(function() {
		$( ".register" ).show();
		$( ".register" ).animate({ "right": "0px" }, "fast" );
	});

	$('#dismiss-register').click(function(){
		$( ".register" ).animate({ "right": " -41.66666667%" }, "slow" );
		$( ".register" ).hide('fast');
		
	});

	$(document).ready(function ($) {

    	$("#create-pass").strength();
    	$('.fa-check').insertBefore('.button_strength');
    	$wrongPass = $('#create-accout').find('.fa-times')
    	$wrongPass.insertBefore('.button_strength');
    	var filter =false;

    	$("#create-pass").keyup(function(){
    		if(this.value.match(/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{9,}$/)){
    			$('.fa-check').show();
    			$wrongPass.hide();
    			filter = true;
    		}
    		else{//not match password regular expression
    			$wrongPass.show();
    			$('.fa-check').hide();
    			filter = false;
    		}
    	});
    	$('#create-accout').on('submit',function(){
    		if(!filter){
    			$('.fa-times').show();
    			$('.fa-check').hide();
    			return false;
    		}
		});
    	

	});
</script>
@endsection