@extends('layouts.default',['layout'=>'one-column'])
@section('header')
<link rel="stylesheet" href="{{asset('css/error.css')}}"/>
@endsection

@section('mainboxbody')
<div class="error-container">
    <div class='col-md-12'>
        <h1>Opps! Page Error</h1>
        @if(Session::has('csrf_error'))
                <?php $token_error = Session::get('csrf_error')?>
               
                <h3 class="error_info">{{$token_error}}</h3>
                <a href='/'>Go back</a>
        @endif
    </div>
</div>

@endsection