@extends('shop.myAccount.account_layout')
@section('account-content')
    <div class="tab-pane fade show active" id="account-dashboard" role="tabpanel" aria-labelledby="account-dashboard-tab">
        <div class="myaccount-dashboard">
            <p>Hello <b>{{Auth::user()->name}}</b> (not {{Auth::user()->name}}? <a href="{{ URL::to('logout') }}" ng-click="logout()">Sign
                    out</a>)</p>
            <p>From your account dashboard you can view your recent orders, manage your shipping and
                billing addresses and <a href="javascript:void(0)">edit your password and account details</a>.</p>

            @if(session('success'))
                <div class="alert alert-success">
                    <h3>{{ session('success') }}</h3>
                </div>
            @endif
        </div>
    </div>
@endsection