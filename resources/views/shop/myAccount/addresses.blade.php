@extends('shop.myAccount.account_layout')
@section('account-content')
    <div>
        @if (session()->has('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <div class="myaccount-address">
            <p>The following addresses will be used on the checkout page by default. <a href="{{ URL::to('account/add-address') }}"><i class="fa fa-plus-circle"></i></a></p>
            @foreach ($addresses as $address)
                <div class="row" style="margin-bottom: 30px">
                    <div class="col">
                        <h4 class="small-title">{{$address->street_address}}</h4>
                        <address>
                            {{$address->street_address}}, {{$address->state}}, {{json_decode($address->lga)[1]}} {{$address->city}}
                        </address>
                        
                        <div style="display: flex; justify-content: space-between">
                            <div style="width: 80px;">
                                <a href="{{ URL::to('account/address/') }}/{{$address->id}}" class="uren-btn uren-btn_dark uren-btn_sm"><span>Update</span></a>
                            </div>
                            <div style="width: 80px;">
                                <i class="fa fa-trash" ng-click="removeAddress({{$address->id}})"></i>
                                {{-- <a href="{{ URL::to('account/address/') }}/{{$address->id}}" class="uren-btn uren-btn_dark uren-btn_sm"><span>Remove</span></a> --}}
                            </div>
                        </div>
                        

                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection