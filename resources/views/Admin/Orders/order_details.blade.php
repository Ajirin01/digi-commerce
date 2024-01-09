@extends('layouts.admin_base2')
@section('content')
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Order</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Order</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <!-- Content Wrapper. Contains page content -->
  
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Order Summary</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ url('admin.dashboard') }}">Home</a></li>
              <li class="breadcrumb-item active">Order Summary</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">

        <!-- Timelime example  -->
        <div class="row">
          <div class="col-md-12">
            <!-- The time line -->
            <div class="timeline">
              <!-- timeline time label -->
              <div class="time-label">
                <span class="bg-red">{{ $order->created_at }}</span>
              </div>
              <!-- /.timeline-label -->
              <!-- timeline item -->
              <div>
                <i class="fas fa-shopping-order bg-blue"></i>
                <div class="timeline-item">
                  <span class="time"><i class="fas fa-clock"></i> SALE #{{$order->order_number}}</span>
                  <h3 class="timeline-header"><a href="#" onclick="event.preventDefault()">Order List</a></h3>

                  <div class="timeline-body">
                    <div class="card">
                      <!-- /.card-header -->
                      <div class="card-body p-0">
                        <table class="table table-sm">
                          <thead>
                            <tr>
                              <th style="width: 10px">#</th>
                              <th>Product Name</th>
                              <th>Product Price (Naira)</th>
                              <th>Product Quantity</th>
                              <th>Subtotal</th>
                              <th>Product Shop</th>
                            </tr>
                          </thead>
                          <tbody>
                            {{-- {{$order_order}} --}}
                            @foreach ($order_cart as $order_item)
                              @php
                                  $product = $order_item->product;
                                  $shop = App\Models\Shop::find($product->shop_id);
                                  // return response()->json($cart);
                                  // $product = json_decode($product);
                              @endphp
                              <tr>
                                <td>{{$order_item->product_id}}</td>
                                <td><a href="/product/{{$product->id}}">{{$product->name}}</a>
                                  <ul style="display: flex; justify-content: left; list-style: none">
                                      <li style="background-color: {{optional(json_decode($order_item->variations))->color}}; display: block; width: 20px; height: 20px; border-radius: 50px"></li>
                                      <li style="margin-left: 10px">
                                          {{Optional(json_decode($order_item->variations))->size}}
                                      </li>
                                  </ul>
                                </td>
                                <td>{{$product->price}}</td>
                                <td>{{$order_item->quantity}}</td>
                                <td>{{$product->price * $order_item->quantity}}</td>
                                {{-- <td><a href="{{ URL::to('shop') }}/{{$product->shop->id}}">{{$product->shop->name}}</a></td> --}}
                                <td><a href="javascript:void(0)"data-toggle="modal" data-target="#exampleModalCenter{{$shop->id}}">{{$shop->name}}</a></td>
                                @include('includes.shop_detail_modal')
                              </tr>
                            @endforeach
                          </tbody>
                        </table>
                      </div>
                      <!-- /.card-body -->
                    </div>
                  </div>
                </div>
              </div>
              <!-- END timeline item -->
              <!-- timeline item -->
              <div>
                <i class="fas fa-money-bill bg-green"></i>
                <div class="timeline-item">
                  <span class="time"><i class="fas fa-clock"></i>  SALE #{{$order->order_number}}</span>
                  <h3 class="timeline-header no-border"><a href="#">Total with shipping</a> &#x20A6; {{$order->total_with_shipping}}</h3>
                </div>
              </div>
              <!-- END timeline item -->
              <!-- timeline item -->
              <div>
                <i class="fas fa-money-bill bg-yellow"></i>
                <div class="timeline-item">
                  <span class="time"><i class="fas fa-money-bill"></i> {{$order->payment_method}}</span>
                  <h3 class="timeline-header"><a href="#">Payment Method</a></h3>

                  {{-- <h3 class="timeline-header"><a href="#">{{$order->payment_method}}</a></h3> --}}
                    
                  {{-- </div> --}}
                  
                </div>
              </div>
              <!-- END timeline item -->
              <!-- timeline item -->
              <div>
                <i class="fas fa-shipping-fast bg-blue"></i>
                <div class="timeline-item">
                  <span class="time"><i class="fas fa-shipping-fast"></i> Shipping Address</span>
                  <h3 class="timeline-header"><a href="#">Shipping Address</a></h3>
                  <ul>
                    <li>
                        <strong>Full Name: </strong>{{optional($order->user)->name?? $order->shipping_name}}
                    </li>
                    <li>
                        <strong>Phone Number: </strong>{{optional($order->user)->phone?? $order->shipping_phone}}
                    </li>
                    <li>
                        <strong>Email Address: </strong>{{optional($order->user)->email?? $order->shipping_email}}
                    </li>
                    <li>
                        <strong>Street Address: </strong>{{$address}}
                    </li>
                </ul>
                  
                </div>
              </div>
              <!-- END timeline item -->
            </div>
          </div>
          <!-- /.col -->
        </div>
      </div>
      <!-- /.timeline -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  
@endsection