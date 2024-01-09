@extends('layouts.shop_layout')
@section('content')
    <!-- Begin Uren's Breadcrumb Area -->
    <div class="breadcrumb-area">
        <div class="container">
            <div class="breadcrumb-content">
                <h2>Checkout</h2>
                <ul>
                    <li><a href="index.html">Home</a></li>
                    <li class="active">Checkout</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- Uren's Breadcrumb Area End Here -->
    <!--Checkout Area Strat-->
    <div class="checkout-area pt-60 pb-30">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <span>
                        @if (session('error'))
                            <b class="text-danger">
                                {{session('error')}}
                                @php
                                    echo "<script> errorAlert('".session('error')."') </script>";
                                @endphp
                            </b>
                        @endif
                    </span>

                    <br>
                    @guest
                        <div class="coupon-accordion">
                            <!--Accordion Start-->
                            <h3>Returning customer? <span id="showlogin">Click here to login</span></h3>
                            <div id="checkout-login" class="coupon-content">
                                <div class="coupon-info">
                                    <form action="{{URL::to('customer_login')}}" method="POST">
                                        @csrf
                                        <p class="form-row-first">
                                            <label>Username or email <span class="required">*</span></label>
                                            <input type="email" name="email">
                                        </p>
                                        <p class="form-row-last">
                                            <label>Password  <span class="required">*</span></label>
                                            <input type="password" name="password">
                                        </p>
                                        <input type="hidden" name="cart" value="[[cart]]">
                                        <p class="form-row">
                                            <input value="Login" type="submit">
                                        </p>
                                        <p class="lost-password"><a href="{{URL::to('password-reset')}}">Lost your password?</a></p>
                                    </form>
                                </div>
                            </div>
                            <!--Accordion End-->
                        </div>
                    @endguest
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-12">
                    <form action="{{ URL::to('place-order') }}" id="place_order_form" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="checkbox-form">
                            <h3>Billing Details</h3>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="checkout-form-list">
                                        <label>First Name <span class="required">*</span></label>
                                        <input placeholder="" id="first_name" type="text" name="shipping_first_name" value="{{explode(' ', optional(Auth::user())->name ?? ' ')[0]}}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="checkout-form-list">
                                        <label>Last Name <span class="required">*</span></label>
                                        <input placeholder="" id="last_name" type="text" name="shipping_last_name" value="{{explode(' ', optional(Auth::user())->name ?? ' ')[1]}}" required>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="checkout-form-list">
                                        <label>Address <span class="required">*</span></label>
                                        @auth
                                            <input placeholder="Street address" id="address" type="text" name="shipping_address" value="{{optional(Auth::user()->addresses->first())->street_address}}" required>
                                        @endauth
                                        @guest
                                            <input placeholder="Street address" id="address" type="text" name="shipping_address" value="" required>
                                        @endguest
                                        {{-- <input placeholder="Street address" id="address" type="text" name="shipping_address" value="{{optional(Auth::user()->addresses->first())->street_address}}" required> --}}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="checkout-form-list">
                                        <label>State<span class="required">*</span></label>
                                        {{-- <input placeholder="" type="text" name="shipping_state"> --}}
                                        <input type="hidden" id="state" name="shipping_state" value="[[(shippingState | parseJSON).state]]">
                                        <select id="state_select" ng-model="shippingState" class="form-control">
                                            <option value="" selected>Please select your state</option>
                                            <option ng-repeat="state in statesAndLgas" value="[[state | stringifyJSON]]">[[state.alias]]</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="checkout-form-list">
                                        <label>City/Town<span class="required">*</span></label>
                                        @guest
                                            <input placeholder="" id="city" type="text" name="shipping_city" id="city" value="" required>
                                        @endguest
                                        @auth
                                            <input placeholder="" id="city" type="text" name="shipping_city" id="city" value="{{optional(Auth::user()->addresses->first())->city}}" required>
                                        @endauth
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="checkout-form-list">
                                        <label>L.G.A <span class="required">*</span></label>
                                        {{-- <input type="text" name="shipping_city"> --}}
                                        <select name="shipping_lga" id="lga" ng-model="shipping_cost" class="form-control">
                                            {{-- <option value='[200, "Ibeju-Lekki"]'>Ibeju-lekki</option> --}}
                                            <option ng-repeat="lga in (shippingState | parseJSON).lgas" value='["[[lga | setShippingCost : (shippingState | parseJSON).alias]]", "[[lga]]"]'>[[lga]]</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="checkout-form-list">
                                        <label>Email Address <span class="required">*</span></label>
                                        @guest
                                            <input placeholder="" id="email" type="email" name="shipping_email">
                                        @endguest
                                            
                                        @auth
                                            <input placeholder="" id="email" type="email" name="shipping_email" readonly value="{{Auth::user()->email}}">
                                        @endauth
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="checkout-form-list">
                                        <label>Phone  <span class="required">*</span></label> 
                                        @guest
                                            <input type="tel" id="phone" name="shipping_mobile_number" value="" class="form-control">
                                        @endguest
                                        @auth
                                            <input type="tel" id="phone" name="shipping_mobile_number" value="{{optional(Auth::user())->phone}}" class="form-control">
                                        @endauth
                                    </div>
                                </div>


                                <input type="hidden" name="checkout_cart" value="[[checkout]]">
                                <input type="hidden" name="order_total" value="[[checkout_sub_total + (shipping_cost | number : 0)]]">
                                <input type="hidden" id="selected_payment_method" name="selected_payment_method" value="[[paymentMethod]]">
                                <input type="hidden" name="shop_cart" value="[[cart]]">

                               @guest
                                    <div class="col-md-12">
                                        <div class="checkout-form-list create-acc">
                                            <input id="cbox" type="checkbox" name="shipping_create_account">
                                            <label>Create an account?</label>
                                        </div>
                                        <div id="cbox-info" class="checkout-form-list create-account">
                                            <p>Create an account by entering the information below. If you are a returning customer please login at the top of the page.</p>
                                            <label>Account password  <span class="required">*</span></label>
                                            <input placeholder="password" type="password" name="shipping_create_account_password">
                                        </div>

                                        
                                    </div>
                                @endguest
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-lg-6 col-12">
                    <div class="your-order">
                        <h3>Your order</h3>
                        <div class="your-order-table table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="cart-product-name">Product</th>
                                        <th class="cart-product-total">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="cart_item" ng-repeat="checkout_item in checkout">
                                      <td class="cart-product-name"> [[checkout_item.product_name]]<strong class="product-quantity"> × [[checkout_item.product_quantity]]</strong></td>
                                      <td class="cart-product-total"><span class="amount">&#x20A6;[[checkout_item.product_price]]</span></td>  
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr class="cart-subtotal">
                                        <th>Cart Subtotal</th>
                                        <td><span class="amount">&#x20A6;[[checkout_sub_total]]</span></td>
                                    </tr>
                                    <tr class="cart-subtotal">
                                        <th>Shipping Cost</th>
                                        <td><span class="amount">&#x20A6;[[(shipping_cost | number : 0)]]</span></td>
                                    </tr>
                                    <tr class="order-total">
                                        <th>Order Total</th>
                                        <td><strong><span class="amount">&#x20A6;[[checkout_sub_total + (shipping_cost | number : 0)]]</span></strong></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="payment-method">
                            <div class="payment-accordion">
                                <div id="accordion">
                                  <div class="card">
                                    <div class="card-header" id="#payment-2">
                                      <h5 class="panel-title">
                                        <a class="collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                          Pay on delivery
                                        </a>
                                        
                                        <input type="radio" name="payment_method" id="" ng-model="paymentMethod" value="pay_on_delivery" style="width: 20px; height: 20px; transform: translateY(5px)">
                                      </h5>
                                    </div>
                                    <div id="collapseTwo" class="collapse" data-parent="#accordion">
                                      <div class="card-body">
                                        <p>Make your payment at delivery to our agent. Please note that our delivery agants don't carry change.</p>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="card">
                                    <div class="card-header" id="#payment-3">
                                      <h5 class="panel-title">
                                        <a class="collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                          Pay online
                                        </a>
                                        <input type="radio" name="payment_method" id="" ng-model="paymentMethod" value="card_payment" style="width: 20px; height: 20px; transform: translateY(5px)">
                                      </h5>
                                    </div>
                                    <div id="collapseThree" class="collapse" data-parent="#accordion">
                                      <div class="card-body">
                                        <p>Make your payment directly into our bank account using your card or bank transfer. Your order won’t be shipped until the funds have cleared in our account.</p>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <div class="order-button-payment">
                                    <input value="Place order" type="submit" ng-click="placeOrder()">
                                </div>
                            </div>

                            <div class="payment-accordion">
                                <ul class="text-danger">
                                    <li ng-repeat="error in errors">
                                        <b>*[[error]]</b>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--Checkout Area End-->
    
    <!-- Uren's Shop Left Sidebar Area End Here -->
    @include('includes.footer_brands')
@endsection