<div class="add-channel">
	 <div class="ch-headding">
	 	<div class="col-md-6 pull-left" style="height: 100%"><p>Recent Contacts</p></div>
	 	
	 </div>
</div>
<div class="search-bar">
			 <input type="text" class="form-control empty" id="iconified" placeholder="&#xF002; &nbsp search"/>
</div>
<ul class="userpannel-lists">

@foreach ($recentContacts as $user)
<li>	
	<a href="#">
		<div class="media-left"></div>
		<div class="media-body">
			<p class="media-heading" aria-hidden="true">
				<img class="img-circle" alt="64x64" src="{{$user->avatar}}" data-holder-rendered="true" style="width: 50px; height: 50px;">
				{{$user->name}}
				<sapn class="pull-right">
					<span id="noti-cont" class="noti-visible">
						<span class="cont-badge">0</span>
					</span>
				</sapn>
			</p>
		</div>
	</a>
</li>
@endforeach	

	
</ul>