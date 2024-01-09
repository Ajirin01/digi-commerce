@extends('layouts.shop_layout')
@section('content')
    <!-- Begin Uren's Breadcrumb Area -->
    <div class="breadcrumb-area">
        <div class="container">
            <div class="breadcrumb-content">
                <h2>Wish List</h2>
                <ul>
                    <li><a href="index.html">Home</a></li>
                    <li class="active">Wishlist</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- Uren's Breadcrumb Area End Here -->
    <!--Begin Uren's Wishlist Area -->
    <div class="uren-wishlist_area">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <form action="javascript:void(0)">
                        <div class="table-content table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="uren-product_remove">remove</th>
                                        <th class="uren-product-thumbnail">images</th>
                                        <th class="cart-product-name">Product</th>
                                        <th class="uren-product-price">Unit Price</th>
                                        <th class="uren-product-stock-status">Stock Status</th>
                                        <th class="uren-cart_btn">add to cart</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($wishList as $item)
                                        <tr>
                                            <td class="uren-product_remove"><a href="javascript:void(0)" ng-click="removeFromWishList({{$item->id}})"><i class="fa fa-trash"
                                                title="Remove"></i></a></td>
                                            <td class="uren-product-thumbnail"><a href="/product/{{$item->product->id}}"><img width="100" height="100" src="{{json_decode($item->product->photos)[0]}}" alt="Uren's Wishlist Thumbnail"></a>
                                            </td>
                                            <td class="uren-product-name"><a href="/product/{{$item->product->id}}">{{$item->product->name}}</a></td>
                                            <td class="uren-product-price"><span class="amount">{{$item->product->price}}</span></td>
                                            @if ($item->product->sold < $item->product->quantity)
                                                <td class="uren-product-stock-status"><span class="in-stock">in stock</span></td>
                                                <td class="uren-cart_btn"><a href="javascript:void(0)" ng-click="addToCart({{$item->product->id}})">add to cart</a></td>
                                            @else
                                                <td class="uren-product-stock-status"><span class="in-stock">Out of stock</span></td>
                                            @endif
                                        </tr>

                                        <input type="hidden" name="product{{$item->product->id}}" id="product{{$item->product->id}}" value="{{$item->product}}">
                                        <input type="hidden" name="product_id{{$item->product->id}}" id="product_id{{$item->product->id}}" value="{{$item->product->id}}">
                                        <input type="hidden" name="quantity{{$item->product->id}}" id="quantity{{$item->product->id}}" value="1">
                                        <input type="hidden" name="product_price{{$item->product->id}}" id="product_price{{$item->product->id}}" value="{{$item->product}}">
                                    @endforeach
                                    
                                </tbody>
                            </table>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Uren's Wishlist Area End Here -->
@endsection