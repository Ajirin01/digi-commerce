@extends('layouts.shop_layout')
@section('content')
    <!-- Begin Uren's Breadcrumb Area -->
    <div class="breadcrumb-area">
        <div class="container">
            <div class="breadcrumb-content">
                <h2>Cart</h2>
                <ul>
                    <li><a href="/">Home</a></li>
                    <li class="active">Cart</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- Uren's Breadcrumb Area End Here -->
    <!-- Begin Uren's Cart Area -->
    <div class="uren-cart-area">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <form action="javascript:void(0)">
                        <div class="table-content table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="uren-product-remove">remove</th>
                                        <th class="uren-product-thumbnail">images</th>
                                        <th class="cart-product-name">Product</th>
                                        <th class="uren-product-price">Unit Price</th>
                                        <th class="uren-product-quantity">Quantity</th>
                                        <th class="uren-product-subtotal">Total</th>
                                        {{-- <th class="uren-product-subtotal"><input type="checkbox" ng-model="allSelected" ng-change="selectAll()" name="select-product" id="select-product"></th> --}}
                                        <th class="uren-product-subtotal"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr ng-repeat="item in cart | filter:searchText">
                                    {{-- <tr ng-repeat="item in cart"> --}}
                                        <td class="uren-product-remove"><a href="javascript:void(0)" ng-click="removeFromCart(item.product_id)"><i class="fa fa-trash"
                                            title="Remove"></i></a></td>
                                        <td class="uren-product-thumbnail"><a href="/product/[[item.product_id]]"><img ng-src="[[getImageUrl(item.product)]]" width="100" height="100" alt="Uren's Cart Thumbnail"></a></td>
                                        <td class="uren-product-name">
                                            <a href="/product/[[item.product_id]]">[[getProductObject(item.product).name]]</a>
                                            <ul style="display: flex; justify-content: left">
                                                <li style="background-color: [[getCartItemVariations(item.variations).color]]; display: block; width: 20px; height: 20px; border-radius: 50px"></li>
                                                <li style="margin-left: 10px">
                                                    [[getCartItemVariations(item.variations).size]]
                                                </li>
                                            </ul>
                                        </td>
                                        <td class="uren-product-price"><span class="amount">&#x20A6;[[item.price]]</span></td>
                                        <td class="quantity">
                                            <input name="cart_product_quantity[]" ng-change="quantityChanged(item.product_id, item.product_quantity)" ng-model="item.quantity" type="number" min="1" 
                                            style="width: 50px; height: 50px; border: 1px rgba(128, 128, 128, 0.596) solid; text-align: center; font-size: 1rem">
                                        </td>
                                        <td class="product-subtotal"><span class="amount">&#x20A6;[[item.price * item.quantity]]</span></td>
                                        <td class="product-subtotal"><span class="amount"><input type="checkbox" ng-model="itemAdded" ng-checked="[[product | arrayAtIndex : item.id]]" ng-change="changeItemStatusInCart(item, itemAdded)"></span></td>
                                    </tr>
                                </tbody>
                            </table>
                            <br>
                            <input type="text" ng-model="searchText" placeholder="Search">

                            {{-- <div>
                                <button ng-disabled="currentPage == 1" ng-click="currentPage = currentPage - 1">Previous</button>
                                Page [[currentPage]] of [[numberOfPages()]]
                                <button ng-disabled="currentPage == numberOfPages()" ng-click="currentPage = currentPage + 1">Next</button>
                            </div> --}}
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="coupon-all">
                                    <!-- <div class="coupon">
                                        <input id="coupon_code" class="input-text" name="coupon_code" value="" placeholder="Coupon code" type="text">
                                        <input class="button" name="apply_coupon" value="Apply coupon" type="submit">
                                    </div> -->
                                    <div class="coupon2">
                                        <input class="button" name="update_cart" value="Update cart" type="submit" ng-click="updateCart()">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-5 ml-auto">
                                <div class="cart-page-total">
                                    <h2>Cart totals</h2>
                                    <ul>
                                        <li>Checkout Total <span>&#x20A6;[[checkout_sub_total]]</span></li>
                                    </ul>
                                    <a href="{{URL::to('checkout')}}">Proceed to checkout</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Uren's Cart Area End Here -->
@endsection