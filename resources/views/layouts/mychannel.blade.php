<div class="add-channel">
	 <div class="ch-headding">
	 	<div class="col-md-6 pull-left" style="height: 100%"><p>My Channel</p></div>
	 	<div class="col-md-2 button pull-right" style="height: 100%;display: flex;align-items: center;">
	 		<div data-toggle="tooltip" data-placement="bottom" title="Add Channel">
		 	<a class="btn btn-b1 fa fa-plus" data-toggle="modal" data-target=".addch">
			</a>
			</div>
		 	<div class="modal fade addch" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
		  		<div class="modal-dialog">
				    <div class="modal-content">
				      	<div class="modal-header">
				        	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				        <p class="modal-title">Add Channel</p>
				      	</div>
				      	<form class="form-horizontal" method="post" action="create-channel"  id="sub-chn">
				      		{!! csrf_field() !!}
				      		<input type="hidden" id='create-roomid' name="id" />
					      	<div class="modal-body">
					        		<div class="form-group">
									    <label for="channelName" class="col-sm-3 control-label"><p>Channel Name</p></label>
									    <div class="col-sm-6">
									      <input type="text" class="form-control" name="channelName" placeholder="Name">
									    </div>
								  	</div>
								  	<div class="form-group">
									    <label for="chpwd" class="col-sm-3 control-label"><p>Password</p></label>
									    <div class="col-sm-6">
									      <input type="password" disabled class="form-control" id="chpwd" name="channelPassword" placeholder="Password">
									    </div>
								  	</div>
								 <input type="checkbox" id='swRoomType' name='channelType' data-toggle="toggle" data-on="private" data-off="Public" data-size="mini" value="private" data-onstyle="b2"> 	
					      	</div>
					      	<div class="modal-footer" style="background-color: #434444">
					        	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					        	<button id='saved' class="btn btn-b1">Save changes</button>
			      			</div>
		      			</form>
				    </div>
			     	
			  	</div>
			</div>
		</div>
	 </div>
</div>


<div class="search-bar">
			 <input type="text" class="form-control empty" id="iconified" placeholder="&#xF002; &nbsp search"/>
</div>
		
<ul class="channel-lists">
	
</ul>
