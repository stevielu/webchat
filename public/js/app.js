'use strict';
var $chatRoom = $('#chat-room');
var $sendMessage = $('#send-message');
var $createChannel = $('#sub-chn');
var $messageInput = $('#message');//$sendMessage.find('input[name=message]');
var io = window.io;
var socket = io.connect('localhost:3000/');
var chList = [];

function bindSocket(ch){
     socket.on(ch+':App\\Events\\messageCreate', function (payload) {
            var currentCh = $('[channel-name = "'+ch+'"]');
            if(currentCh.hasClass('channel-actived')==true){   

               

                var html = '<div class="media channel_review"><div class="media-left ">';
                                            
                    html += '<a><img class="media-object img-circle" data-src="holder.js/64x64" alt="64x64" src="'+window.location.origin+'/public/no-thumb.png" data-holder-rendered="true" style="width: 50px; height: 50px;"></a>';
                    html += '</div>';
                    html += '<div class="media-body media-middle msg-container">';
                    html += '<p class="msg-box">';
                    html += payload.message+'</p>';
                    html += '</div>';
                    //html += payload.username + ': ';
                    // html += payload.message;
                    // html += '</div>';
            
                    var $message = $(html);

                    $chatRoom.append($message);
                    $message.fadeIn('fast');
                    $chatRoom.animate({scrollTop: $chatRoom[0].scrollHeight}, 1000);
            }
            else{
                var count = parseInt($('#cont-badge').html(),10)+1;
                if(count>99){
                    $('#cont-badge').html('99+');
                }
                else{
                        $('#cont-badge').html(count);
                        
                    }

                $('#cont-badge').addClass('noti-visible');
            }
                   
        });
};


function pollCh(){
    if(chList.length!=0){
        for (var i = chList.length-1; i >=0 ; i--) {
           console.log(chList[i]);
           bindSocket(chList[i]);
           chList.pop();
        }
    }
    setTimeout(pollCh,500);
}
window.setTimeout(pollCh(),500);


$sendMessage.on('submit', function () {
    $.post(this.action, $sendMessage.serialize());
    //console.log($sendMessage.serialize());
    $messageInput.val('');
    return false;
});

$createChannel.on("submit",function(){
    $('#create-roomid').val($("[name = 'chatroom-id']").val());
    $.post(this.action, $createChannel.serialize());
    //console.log($sendMessage.serialize());
    return false;
});



$('.chat_btn').one("click",function(){
    //console.log();
    $("[name = 'chatroom-id']").val($(this).attr('room-id'));
    $.get('chat/'+$(this).attr('room-id'),function(data){
        data.forEach(function(obj){
            // obj['channels'].forEach(function(name){
                
                var html = '<li class="media channel_review" channel-type = "'+obj['channel_type']+'" channel-name="'+obj['channel_name']+'"';

                if(obj['channel_type']=="private"){
                    html += 'data-toggle = "modal"';
                    html += 'data-target = ".proom"';
                } 
                html += '><a href="#"><div class="media-left">';
                //html += '<img class="media-object img-circle" data-src="holder.js/64x64" alt="64x64" src="'+window.location.origin+'/public/no-thumb.png" data-holder-rendered="true" style="width: 54px; height: 54px;">';
                
                html += '</div>';
                html += '<div class="media-body">';
                html += '<p class="media-heading" aria-hidden="true">';
                html += '<i class=" fa fa-users"></i>'+obj['channel_name'];
                html += '<sapn class="pull-right">';
                html += '<span id="noti-cont" class="noti-visible">';
                html += '<span id="cont-badge" class="">0</span>'
                html += '</span>';
                html += '</span></p>';
                //html += '<p style="color:#B5B1B1">user312312:test</p>';
               
                html += '</div></a>';  
                html += '</li>';
                
                var $message = $(html);
                $('.channel-lists').append($message);
                chList.push(obj['channel_name']);
            // });
            
        });
        $('.channel_review').on('click',function(){
            if($(this).hasClass('channel-actived')!=true){
                if(($(this).attr('channel-type'))=="Private"){

                }

                $('#content-loading').css('display','flex');
                $('#cont-badge').removeClass('noti-visible');
                $('#cont-badge').html('0');

                var $ch = $(this).attr('channel-name');
                $.get('chat/content/'+$ch,function(data){
                    //console.log(data['contents']);
                    $('#content-loading').css('display','none');
                    $('#chat-room').html('');
                    $('[name = "current-channel"]').val($ch);
                    data = data['contents'].split("\n");
                    data.forEach(function(data){
                        console.log(data);
                        // obj['channels'].forEach(function(name){
                            var html = '<div class="media channel_review"><div class="media-left ">';
                            
                            html += '<a><img class="media-object img-circle" data-src="holder.js/64x64" alt="64x64" src="'+window.location.origin+'/public/no-thumb.png" data-holder-rendered="true" style="width: 50px; height: 50px;"></a>';
                            html += '</div>';
                            html += '<div class="media-body media-middle msg-container">';
                            html += '<p class="msg-box">';
                            html += data+'</p>';
                            //html += '<p style="color:#B5B1B1">user312312:test</p>';
                            html += '</div>';
                            
                            var $message = $(html);
                            $('#chat-room').append($message);
                        // });
                        
                    });

                });

               
                $('li').removeClass("channel-actived");
                $(this).addClass("channel-actived");
            }//endif
        });//end channel review
    });//end get roomid  
});//end btn click

socket.on('controller-channel'+':App\\Events\\ChannelOperation', function (payload) {
    console.log(payload);
    if(payload.result == 'Done'){
        if(payload.command == 'create'){
            var html = '<li class="media channel_review" channel-name="'+payload['channelname']+'"><a href="#"><div class="media-left">';
                
            //html += '<img class="media-object img-circle" data-src="holder.js/64x64" alt="64x64" src="'+window.location.origin+'/public/no-thumb.png" data-holder-rendered="true" style="width: 54px; height: 54px;">';
            html += '</div>';
            html += '<div class="media-body">';
            html += '<p class="media-heading" aria-hidden="true">';
            html += '<i class=" fa fa-users"></i>'+payload['channelname']+'</p>';
            //html += '<p style="color:#B5B1B1">user312312:test</p>';
            html += '</div></a></li>';
            
            var $list = $(html);
            $('.channel-lists').append($list);

            var $newch = payload['channelname'];
            chList.push($newch);
            
            $('[channel-name= "'+$newch+'"]').on('click',function(){
            if($(this).hasClass('channel-actived')!=true){
                var $ch = $(this).attr('channel-name');
                $.get('chat/content/'+$ch,function(data){
                    //console.log(data['contents']);
                    $('#chat-room').html('');
                    $('[name = "current-channel"]').val($ch);
                    data = data['contents'].split("\n");
                    data.forEach(function(data){
                        console.log(data);
                        // obj['channels'].forEach(function(name){
                            var html = '<div class="media channel_review"><div class="media-left ">';
                            
                            html += '<a><img class="media-object img-circle" data-src="holder.js/64x64" alt="64x64" src="'+window.location.origin+'/public/no-thumb.png" data-holder-rendered="true" style="width: 50px; height: 50px;"></a>';
                            html += '</div>';
                            html += '<div class="media-body media-middle msg-container">';
                            html += '<p class="msg-box">';
                            html += data+'</p>';
                            //html += '<p style="color:#B5B1B1">user312312:test</p>';
                            html += '</div>';
                            
                            var $history = $(html);
                            $('#chat-room').append($history);
                        // });
                        
                    });

                });

                // socket.on($ch+':App\\Events\\messageCreate', function (payload) {
                //     var html = '<div class="media channel_review"><div class="media-left ">';
                                            
                //     html += '<a><img class="media-object img-circle" data-src="holder.js/64x64" alt="64x64" src="'+window.location.origin+'/public/no-thumb.png" data-holder-rendered="true" style="width: 50px; height: 50px;"></a>';
                //     html += '</div>';
                //     html += '<div class="media-body media-middle msg-container">';
                //     html += '<p class="msg-box">';
                //     html += payload.message+'</p>';
                //     html += '</div>';
                //     //html += payload.username + ': ';
                //     // html += payload.message;
                //     // html += '</div>';

                //     var $new = $(html);
                //     $chatRoom.append($new);
                //     $new.fadeIn('fast');
                //     $chatRoom.animate({scrollTop: $chatRoom[0].scrollHeight}, 1000);
                // });
                $('li').removeClass("channel-actived");
                $(this).addClass("channel-actived");
            }//endif
        });//end channel review
        }
    }
});



$('.chat_btn').trigger('click');

