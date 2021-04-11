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
    <div class="col-12 p-5 dashboard-card">
        <div class="row">
            <div class="col-md-6">
                <p>Welcome, <strong>{{Auth::user()->first_name}}</strong>!</p>
                <p>This is the admin dashboard created using Laravel and VueJS.</p><br>
                <p class="text-info"><strong>How to setup this project?</strong></p>
                <p>A readme file is included on this repository as guide for project setup.</p><br>
                <p class="text-success"><strong>Default Admins</strong></p>
                <span>1. Admin Zero<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;<strong>Username:</strong> admin.zero<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;<strong>Email:</strong> admin_zero@mail.com<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;<strong>Password:</strong> admin0
                </span><br><br>
                <span>2. Admin One<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;<strong>Username:</strong> admin.one<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;<strong>Email:</strong> admin_one@mail.com<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;<strong>Password:</strong> admin1
                </span>
            </div>
            <div class="col-md-6">
                <p class="text-danger"><strong>Project Requirements</strong></p>
                <p class="ml-3">1. Create an Admin Dashboard</p>
                <p class="ml-3">2. Implement Authentication</p>
                <p class="ml-3">3. Implement Product Model/Migration</p>
                <p class="ml-3">4. Implement Product Index</p>
                <p class="ml-3">5. Implement CRUD</p>
            </div>
        </div>
    </div>
    @endif
@stop