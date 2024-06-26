@extends('layouts.admin_base2')
@section('content')
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Add Shop</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Add Shop</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="card card-outline card-info">
          <div class="card-header">
            <h3 class="card-title">
              Shop Details
            </h3>
            <!-- tools box -->
            <div class="card-tools">
              <button type="button" class="btn btn-tool btn-sm" data-card-widget="collapse" data-toggle="tooltip"
                      title="Collapse">
                <i class="fas fa-minus"></i></button>
              <button type="button" class="btn btn-tool btn-sm" data-card-widget="remove" data-toggle="tooltip"
                      title="Remove">
                <i class="fas fa-times"></i></button>
            </div>
            <!-- /. tools -->
          </div>
          <!-- /.card-header -->
          <div class="card-body pad">
            <form action="{{ route('shops.update', $seller->shop->id)}}" method="post" enctype="multipart/form-data">
              @csrf
              @method("PATCH")
              <div class="mb-3">
                  <div class="form-group">
                      <label>Shop Bank Name</label>
                      <input type="text" class="form-control" name="bank_name" value="{{$seller->bank_name}}">
                  </div>

                  <div class="form-group">
                    <label>Shop Account Number</label>
                    <input type="tel" class="form-control" name="account_number" value="{{$seller->account_number}}">
                </div>
              </div>
              <!-- <div class="mb-3"> -->
                  <div class="col-12">
                      <input type="submit" value="submit" class="btn btn-primary form-control">
                  </div>
              <!-- </div> -->
            </form>
          </div>
          
        </div>
      </div>
      <!-- /.col-->
    </div>
    <!-- ./row -->
  </section>
@endsection