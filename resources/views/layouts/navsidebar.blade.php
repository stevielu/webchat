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
<div class="modal fade proom" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
		<div class="modal-dialog">
	    <div class="modal-content">
	      	<div class="modal-header">
	        	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <p class="modal-title" style="color: #F44336">Private Channel</p>
	      	</div>
	      	<form class="form-horizontal" method="post" action="login-pch"  id="login-chn">
	      		{!! csrf_field() !!}
	      		<input type="hidden" id='privatech-roomid' name="p-id" />
	      		<input type="hidden" id='privatech-chn' name="p-chn" />
		      	<div class="modal-body">
			      	<div class="login-fail alert alert-danger">
				    	<strong>Password Wrong!</strong> Please try again...
				  	</div>
				  	<div class="form-group">
					    <label for="chpwd" class="col-sm-3 control-label"><p style="color: #F44336">Password</p></label>
					    <div class="col-sm-6">
					      <input type="password" class="form-control" id="pwd" name="loginPass" placeholder="Password">
					    </div>
				  	</div>	
		      	</div>
		      	<div class="modal-footer" style="background-color: #434444">
		        	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		        	<button id='submit-chpwd' class="btn btn-b1">OK</button>
      			</div>
  			</form>
	    </div>
     	
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