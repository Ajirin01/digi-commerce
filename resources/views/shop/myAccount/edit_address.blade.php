@extends('shop.myAccount.account_layout')
@section('account-content')
    <div class="col-lg-12">
        <div class="row">
            <div class="col-lg-12 col-12">
                <form action="{{ URL::to('account/address') }}/{{$address->id}}" method="POST">
                    @csrf
                    @method("PUT")
                    <div class="checkbox-form">
                        <h3>Billing Details</h3>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="checkout-form-list">
                                    <label>Street Address <span class="required">*</span></label>
                                    <input placeholder="Street address" id="address" type="text" name="street_address" value="{{$address->street_address}}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="checkout-form-list">
                                    <label>State<span class="required">*</span></label>
                                    {{-- <input placeholder="" type="text" name="shipping_state"> --}}
                                    <input type="hidden" id="state" name="state" value="[[(shippingState | parseJSON).state]]">
                                    <select id="state_select" ng-model="shippingState" required class="form-control">
                                        <option value="" selected>Please select your state</option>
                                        <option ng-repeat="state in statesAndLgas" value="[[state | stringifyJSON]]">[[state.alias]]</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="checkout-form-list">
                                    <label>City/Town<span class="required">*</span></label>
                                    <input placeholder="" id="city" type="text" name="city" id="city" value="{{$address->city}}" required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="checkout-form-list">
                                    <label>L.G.A <span class="required">*</span></label>
                                    {{-- <input type="text" name="shipping_city"> --}}
                                    <select name="lga" id="lga" ng-model="shipping_cost" required class="form-control">
                                        {{-- <option value='[200, "Ibeju-Lekki"]'>Ibeju-lekki</option> --}}
                                        <option ng-repeat="lga in (shippingState | parseJSON).lgas" value='["[[lga | setShippingCost : (shippingState | parseJSON).alias]]", "[[lga]]"]'>[[lga]]</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="checkout-form-list">
                                    <label>Phone  <span class="required">*</span></label> 
                                    <input type="tel" id="phone" name="phone" value="{{$address->phone}}" class="form-control">
                                </div>
                            </div>

                            <input type="hidden" name="user_id" value="{{Auth::user()->id}}">

                            <div class="col-md-12">
                                <div class="checkout-form-list">
                                    <button class="uren-login_btn">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection