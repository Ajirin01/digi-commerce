@extends('layouts.shop_layout')
@section('content')
    <!-- Begin Uren's Breadcrumb Area -->
    <div class="breadcrumb-area">
        <div class="container">
            <div class="breadcrumb-content">
                <h2>Shop</h2>
                <ul>
                    <li><a href="/">Home</a></li>
                    <li class="active">Shop: <b>{{$shop->name}}</b></li>
                    @if (Auth::user()->seller != null && Auth::user()->seller->shop)
                        @if (Auth::user()->seller->shop == $shop)
                            <li class="nav-item">
                                <a class="nav-link" href="{{ URL::to('admin/products') }}"  aria-controls="account-details">Manage Products</a>
                            </li>
                        @endif
                        
                    @endif
                </ul>
            </div>
        </div>
    </div>
    <!-- Uren's Breadcrumb Area End Here -->
    @include('includes.product_listing_with_sidebar')
    <!-- Begin Uren's Shop Left Sidebar Area -->
    
    <!-- Uren's Shop Left Sidebar Area End Here -->
    @include('includes.footer_brands')
@endsection