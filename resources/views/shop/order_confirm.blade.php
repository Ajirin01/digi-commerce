@extends('layouts.shop_layout')
@section('content')
    <div class="error404-area">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 ml-auto mr-auto text-center">
                    <div class="search-error-wrapper">
                        <h1>Thanks!</h1>
                        <h2>Order Confirmed</h2>
                        <p class="short_desc">Your order has been successfully placed! <br> Please if you are paying on delivery, meet our delivery agent with exact amount because they don't carry change.</p>
                        <div class="uren-btn-ps_center"></div>
                        <a href="/" class="uren-error_btn">Back To Home Page</a>

                        <input type="hidden" name="orderItems" value="{{session('orderItems')}}" id="orderItems">
                    </div>
                </div>
            </div>
        </div>
    </div> 
@endsection
