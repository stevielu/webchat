 <link rel="stylesheet" href="{{asset('css/user.css')}}"/>
<script type="text/javascript" src="{{asset('js/strength.js')}}"></script>

 <div class="row user-container">

	<div class="account-wrap col-md-9"> 
	@if(Session::has('errorinfo'))
		<div class="wrap-title" style="color: #FF5722">
			Error !
		</div>
		<div class="extra-space-mid"></div>
		<div class="col-md-12 account-box" style="color: #FF5722;text-align: center;">
			<?php $error = Session::get('errorinfo')?>
			<p>{{$error->first('name')}}</p>
			<p>{{$error->first('email')}}</p>
			<p>{{$error->first('password')}}</p>
			<p>{{$error->first('phone')}}</p>
			<p>{{$error->first('avatar')}}</p>
			<p>{{$error->first('city')}}</p>
			<p>{{$error->first('suburb')}}</p>
			<p>{{$error->first('age')}}</p>

			<p> 
				<div class=" col-sm-10 back-button" >
				     <a href="{{URL::to('/user/back')}}" class="btn btn-default">Back</a>
			    </div>
		    </p>
			
		</div>
		
		
	@else
		<div class="wrap-title">
			Change your settings
		</div>
		<div class="extra-space-mid">
			@if(Session::has('update_status'))
				<div class="alert alert-success" role="alert">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					{{Session::get('update_status')}}
				</div>
			@endif
		</div>
		@if($section == 'default')
			@include('layouts.useraccount')
		@elseif($section == 'profile')
			@include('layouts.userprofile')
		@endif
	@endif
	</div>	
 </div>
