<div class="col-md-12 account-box">
<form class="form-horizontal" action="profile/<?php echo($accountinfo['name'])?>/edit" method="get">
	
	<div class="form-group">
	    <label for="inputIntro" class="col-sm-2 control-label">What's up</label>
	    <div class="col-sm-6 intro">
	      <textarea type="text" row='5' maxlength="140" class="form-control" name = 'intro' id="inputIntro" placeholder="Introduce yourself"><?php echo($accountinfo['email'])?>
	      </textarea>
	      <p class="character-counter">140</p>
	    </div>
	    <div class="col-sm-3 intro avtar-upload">
	    	<img class='img-responsive' src="{{asset($accountinfo['my_avatar'])}}">
	    	<div class=" col-sm-12" >
				     <button type="file" class="btn btn-default btn-upload" style="border-radius: 4px !important">Upload</button>
		    </div>
	    </div>
  	</div>
  	<div class="form-group">
	    <label for="sex" class="col-sm-2 control-label">Gender</label>
	    <div class="col-sm-6">
	      	<label class="radio-inline">
			  	<input type="radio" name="inlineRadioOptions" id="inlineRadio1" value="male"> Male
			</label>
			<label class="radio-inline">
			  	<input type="radio" name="inlineRadioOptions" id="inlineRadio2" value="female"> Female
			</label>
			<label class="radio-inline">
			  	<input type="radio" name="inlineRadioOptions" id="inlineRadio3" value="secret"> Secret
			</label>
	    </div>
  	</div>
  	<div class="form-group">
	    <label for="age" class="col-sm-2 control-label">Age</label>
	    <div class="col-sm-6" id='dob'>
	      <input type="number" class="form-control" name = 'age' id="age" placeholder="Age">
	      
	    </div>
    </div>
    <div class="form-group">
	    <label for="avenue" class="col-sm-2 control-label">Address</label>
	    <div class="col-sm-3" id='avenue'>
	      <input type="text" class="form-control" name = 'avenue' id="avenue" placeholder="Avenue">
	    </div>
	    <div class="col-sm-3" id='city'>
	      <input type="text" class="form-control" name = 'city' id="city" placeholder="City">
	    </div>
    </div>
</form>
</div>
<script type="text/javascript">
	
    $("#inputIntro").on('keyup', function() {
    	console.log(this.value);
    	if(this.value!=''){
	    	var words = this.value.match(/\S+/g).length;
	        if (words > 140) {
	            // Split the string on first 200 words and rejoin on spaces
	            var trimmed = $(this).val().split(/\s+/, 140).join(" ");
	            // Add a space at the end to keep new typing making new words
	            $(this).val(trimmed + " ");
	        }
	        else {
	            $('.character-counter').text(140-words);
	        }	
    	}    
    });

</script>