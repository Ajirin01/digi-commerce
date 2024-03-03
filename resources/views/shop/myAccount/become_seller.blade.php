@extends('shop.myAccount.account_layout')
@section('account-content')
    <div class="tab-pane fade show active" id="account-dashboard" role="tabpanel" aria-labelledby="account-dashboard-tab">
        <form id="seller-form" action="{{ URL::to('become-seller-request')}}" method="post" enctype="multipart/form-data">
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
                    <input type="file" class="form-control" name="logo" id="logoInput" required>
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
                    <div id="loadingIndicator" style="display: none;">
                        {{-- <img src="path/to/loading.gif" alt="Loading..."> --}}
                        <em class="text-primary">Verifying account Information, please wait...</em> <br>
                    </div>
                    <input id="submit-btn" type="submit" value="submit" class="btn btn-primary form-control">
              </div>
          <!-- </div> -->
          </form>
    </div>


    <script src="{{ asset('assets/js/vendor/jquery-1.12.4.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#submit-btn').click(function(e) {
                e.preventDefault(); // Prevent form submission

                // Show loading indicator
                $('#loadingIndicator').show();
            
                
                // Make AJAX request to verify bank details
                $.ajax({
                    url: "{{ URL::to('verify-bank-details')}}",
                    type: "POST",
                    data: $('#seller-form').serialize(),
                    success: function(response) {
                        // console.log(response)
                        // Hide loading indicator
                        $('#loadingIndicator').hide();

                        // Display bank details in confirmation dialog
                        if (confirm("Bank Details:\nAccount Number: " + response.account_information.account_number + "\nAccount Name: " + response.account_information.account_name + "\n\nProceed?")) {
                            // User confirms, submit the form
                            $('#seller-form').submit();
                        } else {
                            // User wants to edit details, do nothing or handle as needed
                        }
                    },
                    error: function(xhr, status, error) {
                        // Hide loading indicator
                        $('#loadingIndicator').hide();
                        alert("Error verifying bank details");
                    }
                });
            });
        });
    </script>
@endsection


