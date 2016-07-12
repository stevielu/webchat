
            <div style="margin-left:-15px;height:100%">
                @include('layouts.visitorlist')

                <div id="chat-room" current-channel='' class="row">
                    
                    <div id= 'content-loading' class="loading col-md-12">
                        <img class='img-responsive' src="{{asset('balls-1.svg')}}">
                    </div>
                    <div id = 'login-channel'><h1 style="text-align: center;color: #D0D0D0;padding-top: 100px;">Please Login, This is Private Channel</h1></div>
                    <div id = 'content-box'></div>
                </div>
            </div>   
                <!-- 輸入訊息的表單 -->
               @include('layouts.viewprofile')
                <form id="send-message" method="post" action="send-message">
                    {!! csrf_field() !!}
                    
                    <input type="hidden" name="chatroom-id" />
                    <input type="hidden" name="current-channel" />
                    <input type="hidden" name="username" value="{{ $username }}" />
                    <div class="input-group">
                        <label id='myname' class="input-group-addon">{{ $username }}</label>
                        <input id="message" name="message" type="text" value="" class="form-control" />
                        <span class="input-group-btn">
                            <button class="btn btn-success" id="send"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>

                        </span>
                    </div>
                </form>
<script src="{{ asset("bower_component/socket.io-client/socket.io.js")}}"></script>
<script src="{{ asset("js/app.js") }}"></script>
<script src="{{ asset("js/jquery-dateFormat.js") }}"></script>
<script type="text/javascript">
    
    $('#message').focus(function(){
        if($messageInput.val()==''){
            $('#send').prop('disabled',true);
        }
        
    });

    $('#message').keyup(function(){
        if($messageInput.val()==''){
            $('#send').prop('disabled',true);
        }
        else{
            $('#send').prop('disabled',false);
        }
        
    });

    
    
    //$(window).scroll(function() {
        $(window).bind('visit', function(){
            $(window).bind('mousewheel', function(e) {
                if($('.date').html()=='Last Recordes'){
                    return;
                }
                else if ($('#chat-room').scrollTop() == 0) {
                    if(e.originalEvent.wheelDelta / 12 > 5) {
                       //$("#animate-loading-history").fadeIn();
                       
                       $ch = $('[name = "current-channel"]').val();
                       if($lock == 1){
                            $(".reminderinfo-icon").fadeOut();
                            $("#animate-loading-history").css("display", "flex").fadeIn();
                            $date = new Date($.cookie("current-date"));

                            // $yesterday = new Date($date);


                            // $yesterday.setDate($date.getDate() - 1);
                           
                            // $.cookie("current-date",$yesterday);
                            

                            var $dd = $date.getDate();
                            var $mm = $date.getMonth()+1; //January is 0!
                            var $yyyy = $date.getFullYear();

                            if($dd<10){$dd='0'+$dd} 
                            if($mm<10){$mm='0'+$mm} 
                            $date = $yyyy+'-'+$mm+'-'+$dd;

                            getHistory($ch,$date);

                            $lock = 0;
                       }
                      
                       
                    }
                }
            });
            
        });

        function unlock(){
            $lock = 1;
            setTimeout(unlock,1500);
        }

        window.setTimeout(unlock,1500);
    
// });
</script>
 