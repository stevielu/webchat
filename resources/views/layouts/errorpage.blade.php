@extends('layouts.default',['layout'=>'one-column'])
@section('header')
<link rel="stylesheet" href="{{asset('css/error.css')}}"/>
@endsection

@section('mainboxbody')
<div class="error-container">
    <div class='col-md-12'>
        <h1>Error</h1>
        <p>{{ $csrf_error }}</p>
    </div>
</div>

@endsection