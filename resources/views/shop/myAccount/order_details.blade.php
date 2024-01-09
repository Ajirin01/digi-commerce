@extends('shop.myAccount.account_layout')
@section('account-content')
    <!--Shopping Cart Area Strat-->
    <div class="Shopping-cart-area pt-60 pb-60">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <form action="#">
                        <div class="table-content table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="li-product-thumbnail">images</th>
                                        <th class="cart-product-name">Product</th>
                                        <th class="li-product-price">Unit Price</th>
                                        <th class="li-product-quantity">Quantity</th>
                                        <th class="li-product-subtotal">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($order_details !== null)
                                        @foreach ($order_details as $order_item)
                                            <tr>
                                                <td class="li-product-thumbnail"><a href="/product/{{$order_item->product->id}}"><img src="{{json_decode($order_item->product->photos)[0]}}" alt="Li's Product Image" style="width: 100px; height: 100px"></a></td>
                                                
                                                <td class="li-product-name"><a href="/product/{{$order_item->product->id}}" style="float: left">{{$order_item->product->name}}</a> <br>
                                                    <ul style="display: flex; justify-content: left">
                                                        <li style="background-color: {{optional(json_decode($order_item->variations))->color}}; display: block; width: 20px; height: 20px; border-radius: 50px"></li>
                                                        <li style="margin-left: 10px">
                                                            {{Optional(json_decode($order_item->variations))->size}}
                                                        </li>
                                                    </ul>
                                                </td>
                                                <td class="li-product-price"><span class="amount">&#x20A6;{{$order_item->price}}</span></td>
                                                <td class="quantity">
                                                    <span>{{$order_item->quantity}}</span>
                                                </td>
                                                <td class="product-subtotal"><span class="amount">&#x20A6;{{$order_item->price * $order_item->quantity}}</span></td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--Shopping Cart Area End-->
@endsection