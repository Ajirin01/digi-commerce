@extends('shop.myAccount.account_layout')
@section('account-content')
    <div class="tab-pane fade show active" id="account-dashboard" role="tabpanel" aria-labelledby="account-dashboard-tab">
        <form action="{{ URL::to('become-seller-request')}}" method="post" enctype="multipart/form-data">
            @csrf
            <h3 class="card-title">
                Shop Information
            </h3>
            <div class="mb-3">
                <div class="form-group">
                    <label>Shop Name</label>
                    <input type="text" class="form-control" name="name" required>
                </div>
            
                <div class="form-group">
                    <label>Shop Description</label>
                    <textarea class="form-control" name="description" required></textarea>
                </div>
            
                <div class="form-group">
                    <label>Shop Logo</label>
                    <input type="file" class="form-control" name="logo" id="logoInput">
                    <img id="logoPreview" alt="No Logo" class="mt-2" style="max-width: 100px; display: none;">
                </div>

                <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
            </div>

            <h3 class="card-title">
                Payout Information
            </h3>

            <div class="mb-3">
                <div class="form-group">
                    <label>Account Number</label>
                    <input type="text" class="form-control" name="account_number" required>
                </div>
            
                <div class="form-group">
                    <label>Bank Name</label>
                    <select name="bank_name" id="" class="form-control" required>
                        @foreach ($banks as $bank)
                            <option value="{{$bank->code}}">{{$bank->name}}</option>
                        @endforeach
                    </select>
                    {{-- <input type="text" class="form-control" name="bank_name" required> --}}
                </div>
            </div>
            <!-- <div class="mb-3"> -->
              <div class="col-12">
                  <input type="submit" value="submit" class="btn btn-primary form-control">
              </div>
          <!-- </div> -->
          </form>
    </div>
@endsection