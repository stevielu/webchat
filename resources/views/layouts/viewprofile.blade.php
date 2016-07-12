<!-- Modal -->
<div class="modal fade bs-example-modal-sm" id="viewprofile" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-mid" role="document">
    <div class="modal-content">
      <div class="modal-header profile-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Profile</h4>
      </div>
      <div class="modal-body">
        <div class='profile-top'>
          <span class="profile-avtar col-sm-3">
              <img id="avatar"  width="100" height="100" class="img-responsive">
          </span>
          <span class="profile-account col-sm-9">
            <div class="row">
              <h4 id='profile-name'></h4>
              <span id='profile-gender' class="fa fa-mars" style='padding-left:5px;' aria-hidden="true"></span>
            </div>
            <div class="row profile-email">
              <p>Email:&nbsp</p><p id='profile-email' style="padding-left: 0"></p>
            </div>
             <div class="row profile-email">
              <p>Age:&nbsp</p><p id='profile-age' style="padding-left: 0"></p>
              <p style="padding-left: 35px">Address:&nbsp</p>
              <p id='profile-suburb' style="padding-left: 0"></p>
              <p id='profile-city' style="padding-left: 0"></p>
            </div>
          </span>
        </div>
        <div class='profile-body'>
          <span id='profile-intro'>
            
          </span>
        </div>
        <div class='profile-footer'>
            <span>Phone:&nbsp</span><span id='profile-phone' style="padding-left: 0"></span>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <a href="#" class="btn btn-danger chat-to" style="float: left;">Send Message</a>
       <!--  <button type="button" class="btn btn-primary">Save changes</button> -->
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
$('.chat-to').click(function(){
  $(this).attr('href','/chatto/'+$('#profile-name').html())
  // $.get('chatto/'+user,function(data){
              
  // }
});

  
</script>