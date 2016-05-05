<!DOCTYPE html>
<html>
<head>
<title>Laravel</title>

<link rel="stylesheet" href="//fonts.googleapis.com/css?family=Lato:100">
<link rel="stylesheet" href="{{asset('css/app.css')}}"/>
<link rel="stylesheet" href="{{asset('css/bootstrap.css')}}" type="text/css"/>
<style type="text/css">

</style>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <h1>Chat Room Demo</h1>

            <!-- 訊息列表框 -->
            <div id="chat-room">
            <?php 
                $history = explode(PHP_EOL, $contents);
            ?>
            @foreach($history as $msg)
                <div class="message alert-info">
                    {{$msg}}
                </div>
            @endforeach
            </div>

            <!-- 輸入訊息的表單 -->
            @foreach($chatroom as $room)
            <form id="send-message" method="post" action="send-message">
                {!! csrf_field() !!}
                
                <input type="hidden" name="chatroom-id" value="{{$room->id}}" />
                <input type="hidden" name="username" value="{{ $username }}" />
                <div class="input-group">
                    <label class="input-group-addon">{{ $username }}</label>
                    <input id="message" name="message" type="text" value="" class="form-control" />
                    <span class="input-group-btn">
                        <button class="btn btn-success" id="send">Send</button>

                    </span>
                </div>
            </form>
            @endforeach

             
        </div>
    </div>
</div>
<script src="{{ asset("bower_component/socket.io-client/socket.io.js")}}"></script>
<script src="{{ asset("js/jquery.js") }}"></script>
<script src="{{ asset("js/app.js") }}"></script>

</body>
