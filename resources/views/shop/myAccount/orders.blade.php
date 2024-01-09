@extends('shop.myAccount.account_layout')
@section('account-content')
    <div>
        <div class="myaccount-orders">
            <h4 class="small-title">MY ORDERS</h4>
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <tbody>
                        <tr>
                            <th>ORDER</th>
                            <th>DATE</th>
                            <th>STATUS</th>
                            <th>TOTAL</th>
                            <th></th>
                        </tr>
                        @foreach ($orders as $order)
                            <tr>
                                <td><a class="account-order-id" href="javascript:void(0)">#{{$order->id}}</a></td>
                                <td>{{$order->created_at}}</td>
                                <td>{{$order->status}}</td>
                                <td>&#x20A6;{{$order->total_with_shipping}} for {{count(json_decode($order->order_details))}}  items</td>
                                <td><a href="{{ URL::to('order-details') }}/{{$order->id}}" class="uren-btn uren-btn_dark uren-btn_sm"><span>View</span></a>
                                </td>
                            </tr>
                        @endforeach
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection