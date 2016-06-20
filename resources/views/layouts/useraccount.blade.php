<div class="col-md-12 account-box">
			<form class="form-horizontal" action="account/<?php echo($accountinfo['name'])?>/edit" method="get">
				  <div class="form-group">
				    <label for="inputEmail3" class="col-sm-2 control-label">Email</label>
				    <div class="col-sm-6">
				      <input disabled type="email" class="form-control" name = 'email' id="inputEmail3" placeholder="Email" value = "<?php echo($accountinfo['email'])?>">
				    </div>
				  </div>
				  <div class="form-group">
				    <label for="inputEmail3" class="col-sm-2 control-label">User Name</label>
				    <div class="col-sm-6">
				      <input disabled type="test" class="form-control" name = 'name' id="inputEmail3" placeholder="Name" value = "<?php echo($accountinfo['name'])?>">
				    </div>
				  </div>
				  <div class="form-group pass">
				    <label for="inputPassword3" class="col-sm-2 control-label">New Password</label>
				    <div class="col-sm-6" id='edit-pass'>
				      <input type="text" class="form-control" min = '9' name = 'password' id="change-pass" placeholder="Password">
				      
				    </div>
				    <span class="fa fa-times-circle-o" style="color:#F57C00; padding-left: 5px;padding-right:5px;line-height: 34px"><p style="margin: 0;float: right;padding-left: 5px;font-size: 10px;">At least include 1 letter&number.Min 9 words</p></span>
					<span class="fa fa-check-circle-o" style="color:#4CAF50; padding-left: 5px;line-height: 34px"></span>
				  </div>
				  <div class="form-group">
				    <label for="inputEmail3" class="col-sm-2 control-label">Phone</label>
				    <div class="col-sm-6">
				      <input type="number" class="form-control" name = 'phone' id="inputEmail3" placeholder="Phone" value = "<?php echo($accountinfo['phone'])?>">
				    </div>
				  </div>
				  <div class="form-group">
				    <div class="col-sm-offset-2 col-sm-10">
				      <button type="submit" id='edit-save'class="btn btn-primary">Save</button>
				    </div>
				  </div>
			</form>
</div>
		<script type="text/javascript">
			$("#change-pass").strength({
		        strengthClass: 'strength',
	       	 	strengthButtonTextToggle: 'Hide Password'
    		});
    		$('#edit-pass').find('.button_strength').hide();
    		$('.pass > .fa-check-circle-o').hide();
			$('.pass > .fa-times-circle-o').hide();
    		
				var editpass_filter =false;

		    	$("#change-pass").keyup(function(){
		    		if(this.value.match(/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{9,}$/)){
		    			$('.pass > .fa-check-circle-o').show();
		    			$('.pass > .fa-times-circle-o').hide();
		    			editpass_filter = true;
		    		}
		    		else{//not match password regular expression
		    			$('.pass > .fa-check-circle-o').hide();
		    			$('.pass > .fa-times-circle-o').show();
		    			editpass_filter = false;
		    		}
		    	});
		    	$('#edit-save').on('submit',function(){
		    		if(!editpass_filter){
		    			// $('.fa-times').show();
		    			// $('.fa-check').hide();
		    			return false;
		    		}
				});
    		
    		
		</script>