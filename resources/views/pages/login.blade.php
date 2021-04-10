@extends('layout.login')
@section('title', 'Login')
@section('content')
    <!-- Check if user is already logged in -->
    @if (isset(Auth::user()->email))
        <script>window.location = '/dashboard';</script>
    @endif
    <!-- Login errors -->
    @if ($message = Session::get('error'))
        <div class="alert alert-danger alert-block">
        <button type="button" class="close" data-dismiss="alert">x</button>
        <strong>{{ $message }}</strong>
        </div>
    @endif

    @if (count($errors) > 0)
        <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
        </div>
    @endif
    <!-- Login Page -->
    <div class="container mt-5">
        <div class="row pt-5">
            <div class="col-4 mx-auto pt-5">
                <h3 class="text-center font-weight-bold my-5">ADMIN LOGIN</h3>
                <form method="post" action="{{url('/login')}}">
                    @csrf
                    <input type="text" class="form-control my-2 rounded-0" name="useremail" placeholder="Username or email" />
                    <input type="password" class="form-control my-2 rounded-0" name="password" placeholder="Password" />
                    <input type="checkbox" class="my-2 rounded-0" name="remember" /> Remember me?
                    <input type="submit" class="form-control my-4 rounded-0 text-white dashboard-login" name="login" value="Login"/>
                </form>
            </div>
        </div>
    </div>

@stop