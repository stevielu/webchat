<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>chatroom</title>
    <link rel="stylesheet" href="{{asset('fonts/font-awesome/css/font-awesome.min.css')}}"/>
    
    <link href='https://fonts.googleapis.com/css?family=Raleway:200' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="{{asset('css/bootstrap.css')}}" type="text/css"/>
    <link href='https://fonts.googleapis.com/css?family=Josefin+Sans:100,300' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Lato:100">
    <link href='https://fonts.googleapis.com/css?family=Poiret+One' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Raleway+Dots' rel='stylesheet' type='text/css'>
     <!-- Compiled and minified CSS -->
    

  <!-- Compiled and minified JavaScript -->
  
    <!-- <link rel="stylesheet" href="{{asset('css/material-fullpalette.min.css')}}" type="text/css"/>
    <link rel="stylesheet" href="{{asset('css/material.min.css')}}" type="text/css"/>
    <link rel="stylesheet" href="{{asset('css/ripples.min.css')}}" type="text/css"/>
    <link rel="stylesheet" href="{{asset('css/roboto.min.css')}}" type="text/css"/> -->

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="blog">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="author" content="stevie">
    <script type="text/javascript" src="{{asset('js/jquery.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/jquery-ui.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/bootstrap.min.js')}}"/></script> 
    @yield('header')
</head>
<body>
        <div class="container-fluid">
            <div class="row">
                @if($layout == 'two-columnleft')
                <div class="col-md-4 leftbar">
                        @include('layouts.navsidebar')
                        
                </div>
                <div class="col-md-8 rightbox">
                    @yield('rightboxbody')
                </div>
                @endif

                @if($layout == 'one-column')
                    
                    @yield('mainboxbody')
                    
                @endif
            </div>
            
        </div>
</body>
</html>