@extends('layout.default')
@section('title', 'Dashboard')
@section('content')
    <!-- Check if user is logged in -->
    @if (!isset(Auth::user()->email))
    <div class="col-12 p-5 text-center">
        <p>You do not have access to this page.</p>
        <p>To view this page, you have to <a href="{{url('/')}}">login</a> first.</p>
    </div>
    @else
    <div class="col-12 p-5">
        
    </div>
    @endif
@stop