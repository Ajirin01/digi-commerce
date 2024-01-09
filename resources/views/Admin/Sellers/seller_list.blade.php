@extends('layouts.admin_base2')
@section('content')
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Sellers</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Sellers</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">All Sellers</h3>
                <a style="float: right" href="{{route('sellers.create')}}"><h3 class="card-title">Add Seller</h3></a>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Seller Name</th>
                    <th>Account Number</th>
                    <th>Account Name</th>
                    {{-- <th>Status</th> --}}
                    <th>Actions</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach ($sellers as $seller)
                      <tr>
                        <td>{{$seller->user->name}}</td>
                        <td>{{$seller->account_number}}</td>
                        <td>{{$seller->bank_name}}</td>
                        {{-- <td>{{$seller->status}}</td> --}}
                        <td>
                            <a class="btn" href="{{ route('sellers.edit', $seller->id) }}">
                                <i class="fas fa-edit text-warning"></i> Edit
                            </a>
                            <form action="{{ route('sellers.destroy', $seller->id) }}" method="post" id="seller-id{{$seller->id}}">
                              @method('DELETE')
                              @csrf
                            </form>
                            <a class="btn" onclick="event.preventDefault();
                            var nxt =  confirm('Are you sure you want to delete?');
                            if(nxt){
                              document.getElementById('seller-id'+{{$seller->id}}).submit()
                            }else{
                              ;
                            }
                             ">
                                <i class="fas fa-trash text-danger" ></i> Delete
                            </a>
                            {{-- <a class="btn">
                                <i class="fas fa-pause"></i> Pause
                            </a> --}}
                        </td>
                      </tr>
                    @endforeach
                    
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>Seller Name</th>
                    <th>Account Number</th>
                    <th>Account Name</th>
                    {{-- <th>Status</th> --}}
                    <th>Actions</th>
                  </tr>
                  </tfoot>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
@endsection