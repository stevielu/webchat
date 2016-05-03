'use strict';
var $chatRoom = $('#chat-room');
var $sendMessage = $('#send-message');
var $messageInput = $('#message');//$sendMessage.find('input[name=message]');
var io = window.io;
var socket = io.connect('ec2-54-213-119-114.us-west-2.compute.amazonaws.com:3000/');

$sendMessage.on('submit', function () {
    $.post(this.action, $sendMessage.serialize());
    //console.log($sendMessage.serialize());
    $messageInput.val('');
    return false;
});

$('#test').on("click",function(){
    console.log('sad'+$messageInput.val());
})
socket.on('chat-channel:App\\Events\\messageCreate', function (payload) {

    var html = '<div class="message alert-info" style="display: none;">';
    html += payload.username + ': ';
    html += payload.message;
    html += '</div>';

    var $message = $(html);
    $chatRoom.append($message);
    $message.fadeIn('fast');
    $chatRoom.animate({scrollTop: $chatRoom[0].scrollHeight}, 1000);
});
