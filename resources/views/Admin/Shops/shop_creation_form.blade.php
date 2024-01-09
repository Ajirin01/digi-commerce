@extends('layouts.admin_base2')
@section('content')
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Add Seller</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Add Seller</li>
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
              Seller Details
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
            <form action="{{ route('shops.store')}}" method="post" enctype="multipart/form-data">
              @csrf
              <div class="mb-3">
                <div class="form-group">
                  <label>Seller</label>
                  <select class="form-control" name="seller_id">
                      @foreach ($sellers as $seller)
                          <option value="{{ $seller->id }}">
                              {{ $seller->user->name }}
                          </option>
                      @endforeach
                  </select>
                </div>
              
                <div class="form-group">
                    <label>Shop Name</label>
                    <input type="text" class="form-control" name="name">
                </div>
            
                <div class="form-group">
                    <label>Shop Description</label>
                    <textarea class="form-control" name="description"></textarea>
                </div>
            
                <div class="form-group">
                  <label>Shop Logo</label>
                  <input type="file" class="form-control" name="logo" id="logoInput">
                  <img id="logoPreview" alt="No Logo" class="mt-2" style="max-width: 100px; display: none;">
                </div>
            
                <div class="form-group">
                    <label>Shop Status</label>
                    <select class="form-control" name="status">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>
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