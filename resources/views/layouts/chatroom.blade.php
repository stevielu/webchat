@extends('layouts.default',['room'=>$chatroom])
@section('header')
<link rel="stylesheet" href="{{asset('css/app.css')}}"/>
<link rel="stylesheet" href="{{asset('bower_component/bootstrap-toggle/css/bootstrap-toggle.min.css')}}"/>
<link rel="stylesheet" href="//fonts.googleapis.com/css?family=Lato:100">
<script type="text/javascript" src="{{asset('bower_component/bootstrap-toggle/js/bootstrap-toggle.min.js')}}"/></script> 
@endsection
@section('rightboxbody')
               

                <!-- 訊息列表框 -->


                <div id="chat-room" current-channel='' class="row">
                    <div id= 'content-loading' class="loading col-md-12">
                        <img class='img-responsive' src="{{asset('balls-1.svg')}}">
                    </div>
                </div>
               
                <!-- 輸入訊息的表單 -->
               
                <form id="send-message" method="post" action="send-message">
                    {!! csrf_field() !!}
                    
                    <input type="hidden" name="chatroom-id" />
                    <input type="hidden" name="current-channel" />
                    <input type="hidden" name="username" value="{{ $username }}" />
                    <div class="input-group">
                        <label class="input-group-addon">{{ $username }}</label>
                        <input id="message" name="message" type="text" value="" class="form-control" />
                        <span class="input-group-btn">
                            <button class="btn btn-success" id="send"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>

                        </span>
                    </div>
                </form>
                

                 
            

<script src="{{ asset("bower_component/socket.io-client/socket.io.js")}}"></script>
<script src="{{ asset("js/app.js") }}"></script>
@endsection