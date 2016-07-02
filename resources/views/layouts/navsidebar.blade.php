<div class="row">
	<div class="col-md-2 side-navbar no-padding">
		@foreach($chatroom as $myroom)
		<div id ='btn-pointer' current-btn = '{{$currentfocus}}'></div>
		<div class="chat_btn" room-id="{{$myroom->id}}">
			<a class="sidebar_btn sidebar_chat fa fa-comment-o fa-1x" href="/public/chat" > 
			</a>
			
		</div>
		<a class="sidebar_btn sidebar_userdashboard fa fa-user fa-1x" href="/public/user/account" > 
				
		</a>
		<a class="sidebar_btn logout_btn fa fa-sign-out fa-1x" href="/public/logout" > 
			
		</a>
		@endforeach
	</div>
	<div class="col-md-10 navbar-list no-padding">
	@if($currentfocus == 'sidebar_userdashboard')
    	@include('layouts.usersidebar')
	@else
		@include('layouts.mychannel')
	@endif
		
		

	</div>
</div>

<script>

	$('.proom').on('shown.bs.modal','.channel_review', function (e) {
  		var $invoker = $(e.relatedTarget);
  		$('#privatech-chn').val($invoker.attr('channel-name'));
    	$('#privatech-roomid').val($("[name = 'chatroom-id']").val());
  		 
	})
  $(function() {
    $('#swRoomType').change(function() {
    	if($('#chpwd').attr('disabled')){
      		$('#chpwd').prop('disabled', false);
      	}
		else
			$('#chpwd').prop('disabled', true);
    });
    $('#saved').click(function(){
    	$('.addch').modal('hide');
    });
  })

  // $('.sidebar_btn').on('click',function(){
  // 	$('.sidebar_btn').removeClass('btn_acctived');
  // 	$(this).addClass('btn_acctived');

  // })

  	$acctiveTarget = $('.'+$('#btn-pointer').attr('current-btn'));
	$acctiveTarget.addClass('btn_acctived');

	if($('.sidebar_chat').hasClass('btn_acctived')){
		$('.channel-lists').show();
		$('#chat-room').show();
	}
	else{
		$('#send-message').hide();
		$('#chat-room').hide();
		$('.channel-lists').hide();
	}

</script>

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