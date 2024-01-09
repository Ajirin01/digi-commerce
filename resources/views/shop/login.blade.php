@extends('layouts.shop_layout')
@section('content')
    <!-- Begin Uren's Breadcrumb Area -->
    <div class="breadcrumb-area">
        <div class="container">
            <div class="breadcrumb-content">
                <h2>Login</h2>
                <ul>
                    <li><a href="/">Home</a></li>
                    <li class="active">Login</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- Uren's Breadcrumb Area End Here -->
    <!-- Begin Uren's Login Register Area -->
    <div class="uren-login-register_area">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-sm-12 col-md-12 col-xs-12 col-lg-6">
                    <!-- Login Form s-->
                    <form action="{{ URL::to('login') }}" method="POST">
                        @csrf
                        <div class="login-form">
                            <h4 class="login-title text-center">Login</h4>
                            <span class="text-danger">
                                @if (Session::has('error'))
                                    {{session('error')}}
                                @endif
                            </span>
                            <div class="row">
                                <div class="col-md-12 col-12">
                                    <label>Email Address*</label>
                                    <input type="email" name="email" required placeholder="Email Address">
                                </div>
                                <div class="col-12 mb--20">
                                    <label>Password</label>
                                    <input type="password" name="password" required placeholder="Password">
                                </div>
                                <input type="hidden" name="previousRoute" value="{{$previousRoute}}">
                                <!-- <div class="col-md-8">
                                    <div class="check-box">
                                        <input type="checkbox" id="remember_me">
                                        <label for="remember_me">Remember me</label>
                                    </div>
                                </div> -->
                                <div class="col-md-12">
                                    <div class="forgotton-password_info">
                                        <a href="#"> Forgotten pasward?</a>
                                    </div>

                                    <div class="forgotton-password_info">
                                        <a class="text-primary" href="{{ URL::to('register') }}"> Register Instead</a>
                                    </div>
                                </div>

                                <input type="hidden" name="cart" value="[[cart]]">

                                <div class="col-md-12">
                                    <button class="uren-login_btn">Login</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Uren's Login Register Area  End Here -->
@endsection