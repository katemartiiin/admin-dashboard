@extends('layout.default')
@section('title', 'Dashboard')
@section('content')
    <!-- Check if user is logged in -->
    @if (!isset(Auth::user()->email))
    <div class="container">
        <div class="row m-5">
            <div class="col-12 p-5 text-center">
                <p>You do not have access to this page.</p>
                <p>To view this page, you have to <a href="{{url('/')}}">login</a> first.</p>
            </div>
        </div>
    </div>
    @else
    <div class="container">
        <div class="row m-5">
            <div class="col-12 p-5">
                <div class="d-inline">
                    <h2 class="font-weight-bold mr-2">Dashboard</h2>
                    <small class="my-auto float-right"><a href="{{url('/logout')}}">Logout</a></small>
                </div>
                <div class="product-form">
                    <a class="btn btn-primary rounded-0" href="{{url('/new')}}"><small>Create Product</small></a>
                </div>
            </div>
        </div>
    </div>
    @endif
@stop