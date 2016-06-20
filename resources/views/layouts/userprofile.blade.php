<div class="col-md-12 account-box">
<form class="form-horizontal" action="profile/<?php echo($accountinfo['name'])?>/edit" method="post" enctype='multipart/form-data'>
	{!! csrf_field() !!}
	<div class="form-group">
	    <label for="inputIntro" class="col-sm-2 control-label">What's up</label>
	    <div class="col-sm-6 intro">
	      <textarea type="text" row='20' class="form-control" name = 'intro' id="inputIntro" placeholder="Introduce yourself"><?php echo($profile['user_intro'])?>
	      </textarea>
	      <p class="character-counter">200</p>
	    </div>
	    <div class="col-sm-3 intro avtar-upload">
		    <div class = 'avatar-container'>
		    	<img class='img-responsive' id="my_avatar" src="{{asset('storage/'.$accountinfo['my_avatar'])}}" height="150" width="180">
		    	
		    </div>
	    	<div class=" col-sm-12" >
	    	<label class="btn btn-default btn-file btn-upload" style="border-radius: 4px !important">
			    Upload 
			    <input type="file" style="display: none;" name='avatar' onchange="readURL(this);">
			</label>
				     <!-- <input type="file" class="btn btn-default btn-upload" style="border-radius: 4px !important">Upload</input> -->
		    </div>
	    </div>
  	</div>
  	<div class="form-group">
	    <label for="sex" class="col-sm-2 control-label">Gender</label>
	    <div class="col-sm-6">
	      	<label class="radio-inline">
			  	<input type="radio" name="gender" id="inlineRadio1" value="male" <?php echo(($profile['user_gender']=='male')?"checked":"unchecked");?>> Male
			</label>
			<label class="radio-inline">
			  	<input type="radio" name="gender" id="inlineRadio2" value="female" <?php echo(($profile['user_gender']=='female')?"checked":"unchecked");?>> Female
			</label>
			<label class="radio-inline">
			  	<input type="radio" name="gender" id="inlineRadio3" value="secret" <?php echo(($profile['user_gender']=='secret')?"checked":"unchecked");?>> Secret
			</label>
	    </div>
  	</div>
  	<div class="form-group">
	    <label for="age" class="col-sm-2 control-label">Age</label>
	    <div class="col-sm-6" id='dob'>
	      <input type="number" class="form-control" name = 'age' id="age" placeholder="Age" value="{{$profile['user_age']}}">
	      
	    </div>
    </div>
    <div class="form-group">
	    <label for="avenue" class="col-sm-2 control-label">Address</label>
	    <div class="col-sm-3" id='avenue'>
	      <input type="text" class="form-control" name = 'suburb' id="avenue" placeholder="Avenue" value="{{$profile['address_suburb']}}">
	    </div>
	    <div class="col-sm-3" id='city'>
	      <input type="text" class="form-control" name = 'city' id="city" placeholder="City" value="{{$profile['address_city']}}">
	    </div>
    </div>
     <div class="form-group">
     	<div class="col-sm-offset-2 col-sm-2">
	     	 <button style='width: 75px' type="submit" class="btn btn-primary">Save</button>
	    </div>
	    <div class="col-sm-3">
	     	 <a href="#"><button style='width: 75px'type="button" class="btn btn-danger">Cancle</button></a>
	    </div>
     </div>
</form>
</div>
<script type="text/javascript">
	
    $("#inputIntro").on('keyup', function() {
    	console.log(this.value);
    	if(this.value!=''){
	    	var words = this.value.match(/\S+/g).length;
	        if (words > 200) {
	            // Split the string on first 200 words and rejoin on spaces
	            var trimmed = $(this).val().split(/\s+/, 200).join(" ");
	            // Add a space at the end to keep new typing making new words
	            $(this).val(trimmed + " ");
	        }
	        else {
	            $('.character-counter').text(200-words);
	        }	
    	}    
    });
    function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#my_avatar').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
    }

</script>