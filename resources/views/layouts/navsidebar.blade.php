<div class="row">
	<div class="col-md-2 side-navbar no-padding">
		@foreach($chatroom as $myroom)
		<div class="chat_btn" room-id="{{$myroom->id}}">
			<a class="sidebar_btn fa fa-pencil-square-o fa-1x" href="#" > 
				
			</a>
		</div>
		@endforeach
	</div>
	<div class="col-md-10 navbar-list no-padding">
		<div class="search-bar">
			 <input type="text" class="form-control empty" id="iconified" placeholder="&#xF002; &nbsp search"/>
		</div>
		<ul class="channel-lists">
			
		</ul>
	</div>
</div>


<script type="text/javascript">
	$('#iconified').on('keyup', function() {
    var input = $(this);
    if(input.val().length === 0) {
        input.addClass('empty');
    } else {
        input.removeClass('empty');
    }
});
</script>