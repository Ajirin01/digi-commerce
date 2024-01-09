@extends('layouts.shop_layout')
@section('content')
    <!-- Begin Uren's Breadcrumb Area -->
    <div class="breadcrumb-area">
        <div class="container">
            <div class="breadcrumb-content">
                <h2>Register</h2>
                <ul>
                    <li><a href="/">Home</a></li>
                    <li class="active">Register</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- Uren's Breadcrumb Area End Here -->
    <!-- Begin Uren's Login Register Area -->
    <div class="uren-login-register_area">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-sm-12 col-md-12 col-lg-6 col-xs-12">
                    <form action="{{ route('submitRegister') }}" method="POST">
                        @csrf
                        
                        <div class="login-form">
                            <h4 class="login-title text-center">Register</h4>
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="row">
                                <div class="col-md-6 col-12 mb--20">
                                    <label>First Name</label>
                                    <input type="text" name="first_name" placeholder="First Name" required>
                                </div>
                                <div class="col-md-6 col-12 mb--20">
                                    <label>Last Name</label>
                                    <input type="text" name="last_name" placeholder="Last Name" required>
                                </div>
                                <div class="col-md-12">
                                    <label>Phone Number*</label>
                                    <input type="tel" name="phone" placeholder="Phone Number" required>
                                </div>
                                <div class="col-md-12">
                                    <label>Email Address*</label>
                                    <input type="email" name="email" placeholder="Email Address" required>
                                </div>
                                <div class="col-md-12">
                                    <label>Password</label>
                                    <input type="password" name="password" placeholder="Password" required>
                                </div>
                                <input type="hidden" name="cart" value="[[cart]]">
                                <input type="hidden" name="previousRoute" value="{{$previousRoute}}">
                                <div class="col-12">
                                    <button class="uren-register_btn">Register</button>
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