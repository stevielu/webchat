'use strict';
var $chatRoom = $('#chat-room');
var $sendMessage = $('#send-message');
var $messageInput = $('#message');//$sendMessage.find('input[name=message]');
var io = window.io;
var socket = io.connect('localhost:3000/');

$sendMessage.on('submit', function () {
    $.post(this.action, $sendMessage.serialize());
    //console.log($sendMessage.serialize());
    $messageInput.val('');
    return false;
});

$('.chat_btn').one("click",function(){
    //console.log();
    $("[name = 'chatroom-id']").val($(this).attr('room-id'));
    $.get('chat/'+$(this).attr('room-id'),function(data){
        data.forEach(function(obj){
            // obj['channels'].forEach(function(name){
                var html = '<li class="media channel_review" channel-name="'+obj['channel_name']+'"><a href="#"><div class="media-left">';
                
                html += '<img class="media-object img-circle" data-src="holder.js/64x64" alt="64x64" src="'+window.location.origin+'/public/no-thumb.png" data-holder-rendered="true" style="width: 54px; height: 54px;">';
                html += '</div>';
                html += '<div class="media-body">';
                html += '<p class="media-heading" aria-hidden="true">';
                html += '<i class=" fa fa-users"></i>'+obj['channel_name']+'</p>';
                //html += '<p style="color:#B5B1B1">user312312:test</p>';
                html += '</div></a></li>';
                
                var $message = $(html);
                $('.channel-lists').append($message);
            // });
            
        });
        $('.channel_review').on('click',function(){
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
                            
                            html += '<a><img class="media-object img-circle" data-src="holder.js/64x64" alt="64x64" src="'+window.location.origin+'/public/no-thumb.png" data-holder-rendered="true" style="width: 54px; height: 54px;"></a>';
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

                socket.on($ch+':App\\Events\\messageCreate', function (payload) {
                    var html = '<div class="media channel_review"><div class="media-left ">';
                                            
                    html += '<a><img class="media-object img-circle" data-src="holder.js/64x64" alt="64x64" src="'+window.location.origin+'/public/no-thumb.png" data-holder-rendered="true" style="width: 54px; height: 54px;"></a>';
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
                });
                $('li').removeClass("channel-actived");
                $(this).addClass("channel-actived");
            }//endif
        });//end channel review
    });//end get roomid  
});//end btn click





