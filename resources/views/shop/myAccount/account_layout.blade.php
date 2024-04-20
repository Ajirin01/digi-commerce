@extends('layouts.shop_layout')
@section('content')
    <main class="page-content">
        <!-- Begin Uren's Account Page Area -->
        <div class="account-page-area">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-3">
                        <ul class="nav myaccount-tab-trigger" id="account-page-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link {{ (url()->current() == URL::to('account')) ? 'active' : '' }}" id="account-dashboard-tab" href="{{ URL::to('account')}}"  aria-controls="account-dashboard" aria-selected="{{ json_encode(url()->current() == URL::to('account')) }}">Dashboard</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ (url()->current() == URL::to('account/orders')) ? 'active' : '' }}" id="account-orders-tab" href="{{ URL::to('account/orders')}}"  aria-controls="account-orders" aria-selected="{{ json_encode(url()->current() == URL::to('account/orders')) }}">Orders</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ ( url()->current() == URL::to('account/addresses')) ? 'active' : '' }}" id="account-address-tab" href="{{ URL::to('account/addresses')}}"  aria-controls="account-address" aria-selected="{{ json_encode(url()->current() == URL::to('account/addresses')) }}">Addresses</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ ( url()->current() == URL::to('account/profile')) ? 'active' : '' }}" id="account-profile-tab" href="{{ URL::to('account/profile')}}"  aria-controls="account-details" aria-selected="{{ json_encode(url()->current() == URL::to('account/details')) }}">Account Details</a>
                            </li>
                            {{-- {{Auth::user()->seller->shop}} --}}
                            @if (Auth::user()->seller == null)
                                <li class="nav-item">
                                    <a class="nav-link {{ ( url()->current() == URL::to('become-seller')) ? 'active' : '' }}" id="account-profile-tab" href="{{ URL::to('become-seller')}}"  aria-controls="account-details" aria-selected="{{ json_encode(url()->current() == URL::to('become-seller')) }}">Become a seller</a>
                                </li>
                            @endif
                            
                            @if (Auth::user()->seller != null && Auth::user()->seller->shop)
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ URL::to('shop/'.Auth::user()->seller->shop->id.'/products') }}"  aria-controls="account-details">My Shop({{Auth::user()->seller->shop->status}})</a>
                                </li>
                            @endif

                            <li class="nav-item">
                                <a class="nav-link" id="account-logout-tab" href="{{ URL::to('logout') }}"  aria-selected="false" ng-click="logout()">Logout</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-lg-9">
                        <div class="tab-content myaccount-tab-content" id="account-page-tab-content">
                            @yield('account-content')
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Uren's Account Page Area End Here -->
    </main>
@endsection