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