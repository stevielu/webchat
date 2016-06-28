@extends('layouts.default',['layout'=>'one-column'])
@section('header')
<link rel="stylesheet" href="{{asset('css/error.css')}}"/>
@endsection

@section('mainboxbody')
<div class="error-container">
    <div class='col-md-12'>
        <h1>Error</h1>
        @if(Session::has('csrf_error'))
                <?php $token_error = Session::get('csrf_error')?>
               
                <h2 class="error_info">{{$token_error}}</h2>

        @endif
    </div>
</div>

@endsection