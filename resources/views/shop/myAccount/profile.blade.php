@extends('shop.myAccount.account_layout')
@section('account-content')
<div>
    @if (session()->has('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if (session()->has('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="myaccount-details">
        <form action="{{ route('submitProfileChange') }}" method="POST" class="uren-form">
            @csrf
            <div class="uren-form-inner">
                <div class="single-input single-input-half">
                    <label for="account-details-firstname">First Name*</label>
                    <input type="text" id="account-details-firstname" name="first_name" required value="{{ explode(' ', $user->name)[0] }}">
                </div>
                <div class="single-input single-input-half">
                    <label for="account-details-lastname">Last Name*</label>
                    <input type="text" id="account-details-lastname" name="last_name" required value="{{ explode(' ', $user->name)[1] }}">
                </div>
                <div class="single-input">
                    <label for="account-details-email">Email*</label>
                    <input type="email" id="account-details-email" name="email" required value="{{$user->email}}">
                </div>
                <div class="single-input">
                    <label for="account-details-phone">Phone*</label>
                    <input type="tel" id="account-details-phone" name="phone" required value="{{$user->phone}}">
                </div>
                <div class="single-input">
                    <label for="account-details-oldpass">Current Password(leave blank to leave
                        unchanged)</label>
                    <input type="password" id="account-details_oldpass" name="old_password">
                </div>
                <div class="single-input">
                    <label for="account-details-newpass">New Password (leave blank to leave
                        unchanged)</label>
                    <input type="password" id="account-details-newpass" name="new_password">
                </div>
                <div class="single-input">
                    <label for="account-details-confpass">Confirm New Password</label>
                    <input type="password" id="account-details-confpass" name="confirm_password">
                </div>
                <div class="single-input">
                    <button class="uren-btn uren-btn_dark" type="submit"><span>SAVE
                    CHANGES</span></button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection