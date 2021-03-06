@extends('layouts.default',['room'=>$chatroom,'layout'=>'two-columnleft'])
@section('header')
<link rel="stylesheet" href="{{asset('css/app.css')}}"/>
<link rel="stylesheet" href="{{asset('bower_component/bootstrap-toggle/css/bootstrap-toggle.min.css')}}"/>

<script type="text/javascript" src="{{asset('bower_component/bootstrap-toggle/js/bootstrap-toggle.min.js')}}"/></script> 
<script src="{{ asset("js/jquery.cookie.js") }}"></script>
<script type="text/javascript">
    var localhref = window.location.protocol + "//" + window.location.host;
</script>
@endsection
@section('rightboxbody')


@if($currentfocus == 'sidebar_userdashboard')
    @include('layouts.user')
    
@else
                <div id="chat-room" current-channel='' class="row">
                    
                    <div id= 'content-loading' class="loading col-md-12">
                        <img class='img-responsive' src="{{asset('balls-1.svg')}}">
                    </div>
                    <div id = 'login-channel'><h1 style="text-align: center;color: #D0D0D0;padding-top: 100px;">Please Login, This is Private Channel</h1></div>
                    <div id = 'content-box'></div>
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
                
@endif
                 
            



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
                if ($('#chat-room').scrollTop() == 0) {
                    if(e.originalEvent.wheelDelta / 12 > 5) {
                       //$("#animate-loading-history").fadeIn();
                       
                       $ch = $('[name = "current-channel"]').val();
                       if($lock == 1){
                            $(".reminderinfo-icon").fadeOut();
                            $("#animate-loading-history").css("display", "flex").fadeIn();
                            $date = new Date($.cookie("current-date"));
                            // $yesterday = new Date($today);
                            $yesterday = new Date($date);
                            // console.log($.cookie("current-date"));
                            // console.log($yesterday);

                            $yesterday.setDate($date.getDate() - 1);
                           
                            $.cookie("current-date",$yesterday);
                            

                            var $dd = $yesterday.getDate();
                            var $mm = $yesterday.getMonth()+1; //January is 0!
                            var $yyyy = $yesterday.getFullYear();

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
            setTimeout(unlock,1000);
        }

        window.setTimeout(unlock,1000);
    
// });
</script>
@endsection