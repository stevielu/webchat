'use strict';
var $chatRoom = $('#chat-room');
var $sendMessage = $('#send-message');
var $createChannel = $('#sub-chn');
var $loginPrivateChannel = $('#login-chn');
var $messageInput = $('#message');//$sendMessage.find('input[name=message]');
var io = window.io;
var socket = io.connect('ec2-54-213-119-114.us-west-2.compute.amazonaws.com:3000/');
var chList = [];

var contentsUserlist = [];
var defaultPage  =    '<div id="animate-loading-history" >'+
                        '<img class="" src="'+localhref+'/public/hourglass-2.svg">'+
                      '</div>';
    defaultPage  +=   '<div class="fa fa-angle-double-up reminderinfo-icon" aria-hidden="true"></div>'+
                      '<div class="reminderinfo-sm"><p>No Messages Today</p></div>';
    defaultPage  +=   '<div id= "content-loading" class="loading col-md-12">';
    defaultPage  +=   '<img class="img-responsive" src="'+localhref+"/public/balls-1.svg"+'">';
    defaultPage  +=   '</div>';
    defaultPage  +=   '<div id = "login-channel"><h1 style="text-align: center;color: #D0D0D0;padding-top: 100px;">Please Login, This is Private Channel</h1></div>';
    defaultPage  +=   '<div id = "content-box"></div>';

//var avatar_url = window.location.origin+'/public/storage/user-avatar/'+name+'.jpg';
//var avatar_url = window.location.origin+'/public/no-thumb.png';
function imageExists(name){
    var avatar_url;

    if(!contentsUserlist.hasOwnProperty(name)){//add new user
        $.ajax(
            {type:"GET",
            url:'viewprofile/'+name,
            async:false
            }).done(function(data) { 
                if(data['user'].my_avatar!=''){
                    avatar_url = window.location.origin+'/public/storage/'+data['user'].my_avatar;
                }
                else{
                   avatar_url = window.location.origin+'/public/no-thumb.png';
                }
                contentsUserlist[name] =avatar_url;
            });
    }
    return contentsUserlist[name];
}                
function getProfile(link){
    $.get(link,function(data){
        if(data['user'].my_avatar!=''){
            var path = window.location.origin+'/public/storage/'+data['user'].my_avatar;
        }
        else{
            var path = window.location.origin+'/public/no-thumb.png';
        }
        $('#avatar').attr('src',path);
        $('#profile-name').html(data['user'].name);
        $('#profile-gender').removeClass();
        switch(data['profile'].user_gender){
            case 'male':
                    $('#profile-gender').addClass('fa fa-mars gender_blue');
                break;
            case 'female':
                 $('#profile-gender').addClass('fa fa-venus gender_red');
                break;
            default:
                 $('#profile-gender').addClass('fa fa-question-circle-o gender_grey');
                 break;
        }
        $('#profile-email').html(data['user'].email);
        $('#profile-intro').html(data['profile'].user_intro);
        $('#profile-age').html(data['profile'].user_age);
        $('#profile-city').html(data['profile'].address_city);
        if(data['profile'].address_suburb!=''){
            $('#profile-suburb').html(data['profile'].address_suburb+',');
        }
        $('#profile-phone').html(data['user'].phone);
        

    });
}

function joinCh(username){
    var path = imageExists(username);
    var html = '<a class="viewprofile" link="viewprofile/'+username+'" href="#" data-toggle="modal" data-target="#viewprofile">';
    html += '<img class="img-circle"  alt="64x64" src="'+path+'" data-holder-rendered="true" style="width: 50px; height: 50px;"></a>';
    html += '<p>'+username+'</p>';
    $('#visitor-list').append('<li id="visitor-'+username+'">'+html+'</li>');
}
function leaveCh(username){
    $('#visitor-'+username).remove();
}

function bindSocket(ch){
     socket.on(ch+':App\\Events\\userAction', function (payload) {
        if(payload.username != $('#myname').html()){
            if(payload['action'] == 'joinch'){
                var currentCh = $('[channel-name = "'+ch+'"]');
                if(currentCh.hasClass('channel-actived')==true){
                    joinCh(payload.username);
                }     
            }
            if(payload['action'] == 'leavech'){
                if($('#visitor-'+payload.username)!=null){
                    leaveCh(payload.username);
                }
            }
        }
     });
     socket.on(ch+':App\\Events\\messageCreate', function (payload) {
            var currentCh = $('[channel-name = "'+ch+'"]');

            if(currentCh.hasClass('channel-actived')==true){   

                var name = payload.username;
                var userattr = payload.userAttribute;


                //var name = str.substring(0,str.indexOf(':')); 
                //var avatar_url = window.location.origin+'/public/storage/user-avatar/'+name+'.jpg';
                //var path = imageExists(userattr['avatar']);
                //console.log(path);
                if(userattr['avatar']!=null){
                   var path =  window.location.origin+'/public/storage/'+userattr['avatar'];
                }
                else{
                   var path = window.location.origin+'/public/no-thumb.png';
                }
                 
                 
                // var html = '<div class="media channel_review">';
                // html += '<div class="media-body media-middle msg-container">';
                // html += '<p class="msg-box-right pull-right">';
                // html += payload.message+'</p>';
                // html += '</div>';
                // html += '<div class="media-right ">';
            
                // html += '<a class="viewprofile" link="viewprofile/'+name+'" href ="#" data-toggle="modal" data-target="#viewprofile"><img class="media-object img-circle" data-src="holder.js/64x64" alt="64x64" src="'+path+'" data-holder-rendered="true" style="width: 50px; height: 50px;"></a>';
                // html += '</div></div>';
                var myname = $('#myname').html();

                if(myname == name){ 
                    var html = '<div class="media channel_review">';
                    html += '<div class="media-body media-middle msg-container">';
                    html += '<p class="msg-box-right pull-right">';
                    html += payload.message+'</p>';
                    html += '</div>';
                    html += '<div class="media-right ">';
                
                    html += '<a class="viewprofile" link="viewprofile/'+name+'" href ="#" data-toggle="modal" data-target="#viewprofile"><img class="media-object img-circle" data-src="holder.js/64x64" alt="64x64" src="'+path+'" data-holder-rendered="true" style="width: 50px; height: 50px;"></a>';
                    html += '</div></div>';
                }
                else{
                    var html = '<div class="media channel_review"><div class="media-left ">';
                
                    html += '<a class="viewprofile" link="viewprofile/'+name+'" href ="#" data-toggle="modal" data-target="#viewprofile"><img class="media-object img-circle" data-src="holder.js/64x64" alt="64x64" src="'+path+'" data-holder-rendered="true" style="width: 50px; height: 50px;"></a>';
                    html += '</div>';
                    html += '<div class="media-body media-middle msg-container">';
                    html += '<p class="msg-box">';
                    html += payload.message+'</p>';
                    //html += '<p style="color:#B5B1B1">user312312:test</p>';
                    html += '</div>'; 
                }
                // var html = '<div class="media channel_review"><div class="media-left ">';
                //     //html += '<?php echo //file_exists(realpath("/public/storage/user-avatar/'+name+'.jpg"));?>';                  
                //     html += '<a href="'+name+'"><img class="media-object img-circle" data-src="holder.js/64x64" alt="64x64" src="'+path+'" data-holder-rendered="true" style="width: 50px; height: 50px;"></a>';
                //     html += '</div>';
                //     html += '<div class="media-body media-middle msg-container">';
                //     html += '<p class="msg-box">';
                //     html += payload.message+'</p>';
                //     html += '</div>';
                    //html += payload.username + ': ';
                    // html += payload.message;
                    // html += '</div>';
                   
                    var $message = $(html);

                    $chatRoom.append($message);

                    $('.viewprofile').click(function(){
                        // body...
                        var $link = $(this).attr('link');
                        $('#avatar').attr('src',window.location.origin+'/public/default.gif');
                        getProfile($link);
                    });

                    $message.fadeIn('fast');
                    $chatRoom.animate({scrollTop: $chatRoom[0].scrollHeight}, 1000);


            }
            else{
                var obj = currentCh.find('.cont-badge');
                console.log(obj);
                var count = parseInt(obj.html(),10)+1;
                if(count>99){
                   obj.html('99+');
                }
                else{
                        obj.html(count);
                        
                    }

                obj.addClass('noti-visible');
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


function loadingContents(data,history){
     //console.log(data['contents']);

    //loading visitor list in current channel
    //flush list
   
    //loading list
    if(!history){ 
        $('#visitor-list').html('<li>Online Users</li>');
        for (var key in data.visitorlist) {
                joinCh(data.visitorlist[key]);
            }
    }
   

    

    //set history date
    $.cookie("current-date",data['date']);
    var $date = $.cookie("current-date");
    $date = $.format.date($date, "dd-MM-yyyy"); 

    if(data['empty']=='true'){
        $('.reminderinfo-sm').fadeIn();
        $('.reminderinfo-icon').fadeIn();
        $('#content-box').prepend('<div id="'+$date+'"></div>');
        $('.reminderinfo-sm').html('<p class="date">No Messages in </br>'+$date+'</p>');
        $(window).trigger("visit");

    }
    else if(data['empty'] == 'null recordes'){
        $('.reminderinfo-sm').fadeIn();
        $('.reminderinfo-icon').fadeOut();
        $('.reminderinfo-sm').html('<p class="date">No Recordes</p>');
        $(window).unbind('mousewheel');
    }
    else{
        if(data['empty'] == 'last recordes'){
            $(window).off('mousewheel');
            //console.log($ret);
            $('.reminderinfo-sm').fadeIn();
            $('.reminderinfo-icon').fadeOut();
            $('.reminderinfo-sm').html('<p class="date">Last Recordes</p>');
            $("#animate-loading-history").css('display','none');
            
        }
        else{
            $('.reminderinfo-sm').fadeOut();
            $('.reminderinfo-icon').fadeIn();
        }

        var myname = data['username'];
        data = data['contents'].split("\n");

        $('#content-box').prepend('<div id="'+$date+'"><hr class="style1"><p class="date">'+$date+'</p></div>');
        data.forEach(function(data){

            //console.log(data);
            // obj['channels'].forEach(function(name){
                var str = data;
                var path = window.location.origin+'/public/no-thumb.png';
                var name = str.substring(str.indexOf('*')+1,str.indexOf(':')); 

                var userattr = str.substring(0,str.indexOf('*'));

                var correctOlderfile =  str.substring(0,str.indexOf(':'));
                //var path = imageExists(name);
                data = str.substring(str.indexOf(':')+1);
                console.log(imageExists(name));
                //if(userattr != ''){
                path = imageExists(name);// window.location.origin+'/public/storage/'+userattr;
                //}
                if(myname == name){ 
                    var html = '<div class="media channel_review">';
                    html += '<div class="media-body media-middle msg-container">';
                    html += '<p class="msg-box-right pull-right">';
                    html += data+'</p>';
                    html += '</div>';
                    html += '<div class="media-right ">';
                
                    html += '<a class="viewprofile" link="viewprofile/'+name+'" href ="#" data-toggle="modal" data-target="#viewprofile"><img class="media-object img-circle" data-src="holder.js/64x64" alt="64x64" src="'+path+'" data-holder-rendered="true" style="width: 50px; height: 50px;"></a>';
                    html += '</div></div>';
                }
                else{
                    var html = '<div class="media channel_review"><div class="media-left ">';
                
                    html += '<a class="viewprofile" link="viewprofile/'+name+'" href ="#" data-toggle="modal" data-target="#viewprofile"><img class="media-object img-circle" data-src="holder.js/64x64" alt="64x64" src="'+path+'" data-holder-rendered="true" style="width: 50px; height: 50px;"></a>';
                    html += '</div>';
                    html += '<div class="media-body media-middle msg-container">';
                    html += '<p class="msg-box">';
                    html += data+'</p>';
                    //html += '<p style="color:#B5B1B1">user312312:test</p>';
                    html += '</div>'; 
                }
                
               $('.viewprofile').click(function(){
                    // body...
                    var $link = $(this).attr('link');
                    $('#avatar').attr('src',window.location.origin+'/public/default.gif');
                    getProfile($link);
                });
                var $message = $(html);
            // });
            $('#'+$date).append($message);
            //$chatRoom.animate({scrollTop: $chatRoom[0].scrollHeight}, 1000);
        });
       

        var old_height = $.cookie("oldheight");
        if(old_height == '0'){//first loading
            old_height = $('#content-box').height();
        }
        $.cookie("oldheight",$('#content-box').height());
        $('#chat-room').scrollTop($('#content-box').height() - old_height); 
        

        $(window).trigger("visit");
    }

}

function getContents(ch){
  $.get('chat/content/'+ch,function(data){
        $('#content-loading').css('display','none');
        $('#chat-room').html(defaultPage);
        $('[name = "current-channel"]').val(ch);
        loadingContents(data,false);
        });
}

function getHistory(ch,date){
  $.get('chat/content/'+ch+'/'+date,function(data){
        
        //$('#chat-room').html(defaultPage);
        $('[name = "current-channel"]').val(ch);
        loadingContents(data,true);
        }
    ).always(function() {
        $("#animate-loading-history").css('display','none');
        $('#content-loading').css('display','none');
    });
}

$sendMessage.on('submit', function () {
    $.post(this.action, $sendMessage.serialize());
    //console.log($sendMessage.serialize());
    $('.reminderinfo-sm').html('<p></p>');
    $messageInput.val('');
    return false;
});

$createChannel.on("submit",function(){
    $('#create-roomid').val($("[name = 'chatroom-id']").val());
    $.post(this.action, $createChannel.serialize());
    //console.log($sendMessage.serialize());
    return false;
});


$loginPrivateChannel.on("submit",function(){
    
    $.post(this.action, $loginPrivateChannel.serialize(),function(data){
         if(data.ch_login!='success'){
                $('.login-fail').fadeIn("slow");
            }
        else{   
                    $('.proom').modal('hide');
                    $('.login-fail').fadeOut( "slow");
                    $('#content-loading').css('display','none');
                    $('#send-message').fadeIn();
                    var currentCh = $('[channel-name = "'+data['channel']+'"]');
                    currentCh.find('.cont-badge').removeClass('noti-visible');
                    currentCh.find('.cont-badge').html('0');

                    $('#chat-room').html(defaultPage);
                    $('[name = "current-channel"]').val(data['channel']);
                    //getContents(data,data['channel'])
                    loadingContents(data,false);
                    
            }
            // $('li').removeClass("channel-actived");
            // $(this).addClass("channel-actived");
    });
    //console.log($sendMessage.serialize());
    return false;
});

$('.chat_btn').one("click",function(){
    //console.log();
        $('#send-message').hide();
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
                    html += '<span class="cont-badge">0</span>'
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
                    $.cookie("current-date", new Date());
                    $.cookie("oldheight",'0');

                    if(($(this).attr('channel-type'))=="private"){
                        $('#privatech-chn').val($(this).attr('channel-name'));
                        $('#privatech-roomid').val($("[name = 'chatroom-id']").val());
                        $('#chat-room').html(defaultPage);
                        $('#login-channel').fadeIn();
                        $('#send-message').fadeOut('slow');
                        $('li').removeClass("channel-actived");
                        $(this).addClass("channel-actived");
                        $(window).unbind('mousewheel');
                        return;
                    }
                    $('#send-message').fadeIn('slow');
                    $('#content-loading').css('display','flex');
                    $(this).find('.cont-badge').removeClass('noti-visible');
                    $(this).find('.cont-badge').html('0');

                    var $ch = $(this).attr('channel-name');
                    getContents($ch);
                    
                   
                    $('li').removeClass("channel-actived");
                    $(this).addClass("channel-actived");
                }//endif
            });//end channel review
        });//end get roomid
      
});//end btn click

socket.on('controller-channel'+':App\\Events\\ChannelOperation', function (payload) {
    if(payload.result == 'Done'){
        if(payload.command == 'create'){
            var html = '<li class="media channel_review" channel-type = "'+payload['channeltype']+'"channel-name="'+payload['channelname']+'"';
            
            if(payload['channeltype']=="private"){
                html += 'data-toggle = "modal"';
                html += 'data-target = ".proom"';
                } 

            html += '><a href="#"><div class="media-left">';
                
            //html += '<img class="media-object img-circle" data-src="holder.js/64x64" alt="64x64" src="'+window.location.origin+'/public/no-thumb.png" data-holder-rendered="true" style="width: 54px; height: 54px;">';
            html += '</div>';
            html += '<div class="media-body">';
            html += '<p class="media-heading" aria-hidden="true">';
            html += '<i class=" fa fa-users"></i>'+payload['channelname'];
            html += '<sapn class="pull-right">';
            html += '<span id="noti-cont" class="noti-visible">';
            html += '<span class="cont-badge">0</span>'
            html += '</span>';
            html += '</span></p>';
            //html += '<p style="color:#B5B1B1">user312312:test</p>';
            html += '</div></a></li>';
            
            var $list = $(html);
            $('.channel-lists').append($list);

            var $newch = payload['channelname'];
            chList.push($newch);
            
            $('[channel-name= "'+$newch+'"]').on('click',function(){
            if($(this).hasClass('channel-actived')!=true){
                $.cookie("current-date", new Date());
                $.cookie("oldheight",'0');
                var $ch = $(this).attr('channel-name');

                if(($(this).attr('channel-type'))=="private"){
                    $('#privatech-chn').val($(this).attr('channel-name'));
                    $('#privatech-roomid').val($("[name = 'chatroom-id']").val());
                    $('#chat-room').html(defaultPage);
                    $('#login-channel').fadeIn();
                    $('#send-message').fadeOut('slow');
                    $(window).unbind('mousewheel');
                }
                else{
                    $('#send-message').fadeIn('slow');
                    $('#content-loading').css('display','flex');
                    $(this).find('.cont-badge').removeClass('noti-visible');
                    $(this).find('.cont-badge').html('0');
                    getContents($ch);
                    
                }

                $('li').removeClass("channel-actived");
                $(this).addClass("channel-actived");
            }//endif
        });//end channel review
        }
    }
});



$('.chat_btn').trigger('click');

