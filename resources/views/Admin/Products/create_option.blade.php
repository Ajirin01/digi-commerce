@extends('layouts.admin_base2')
@section('content')
  <!-- Main content -->
  <section class="content" style="margin-top: 100px">
    <div class="row">
      <div class="col-md-12">
        <div class="card card-outline card-info">
          <div class="card-header">
            <h3 class="card-title">
             Select Options
            </h3>
            <!-- tools box -->
            <div class="card-tools">
              <button type="button" class="btn btn-tool btn-sm" data-card-widget="collapse" data-toggle="tooltip"
                      title="Collapse">
                <i class="fas fa-minus"></i></button>
            <!-- /. tools -->
          </div>
          <!-- /.card-header -->
          
            <div class="card-body pad" >
                <form action="{{ route('products.create')}}" method="GET">
                    @csrf 
                    <div class="mb-12">
                        <div class="form-group">
                            <label>Select Shop</label>
                            <select name="shop_id" class="form-control">
                                @foreach ($shops as $shop)
                                    <option value="{{$shop->id}}">{{$shop->name}}</option>
                                @endforeach
                            </select>
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