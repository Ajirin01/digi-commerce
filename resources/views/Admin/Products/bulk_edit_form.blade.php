@extends('layouts.admin_base2')
@section('content')
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Products</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Products</li>
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
                <h3 class="card-title">Products bulk edit</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <form action="{{ route('product-bulk-edit') }}" method="post">
                    @csrf
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>Product ID</th>
                            <th>Product Name</th>
                            <th width="100px">Stock</th>
                            <th>Price</th>
                            @can('isAdmin')
                              <th>Status</th>
                            @endcan
                            <th>Add</th>
                        </tr>
                        </thead>
                        <tbody>
                            
                            @foreach ($products as $product)
                            <tr> 
                                <td>{{$product->id}} <input id="product-id{{$product->id}}" type="hidden" name="id[]"  value="{{$product->id}}"></td>
                                <td>{{$product->name}} <input id="product-name{{$product->id}}" type="hidden"  value="{{$product->name}}"></td>
                                <td width="100px" class="form-group">
                                  <input id="quantity{{$product->id}}" name="quantity[]" class="form-control" min="0" type="number"  id="" onchange="getStock({{$product->id}})" value="{{ $product->quantity - $product->sold }}" >
                                </td>
                                <td width="100px">
                                  <input id="price{{$product->id}}" name="price[]" class="form-control" min="0" type="number"  id="" onchange="getPrice({{$product->id}})" value="{{ $product->price }}" >
                                </td>
                                @can('isAdmin')
                                  <td width="100px">
                                    <select name="status[]" id="status{{$product->id}}" class="form-control" onchange="getPrice({{$product->id}})">
                                      <option value="{{strtolower($product->status)}}">{{strtolower($product->status)}}</option>
                                      <option value="{{strtolower($product->status) == 'active' ? 'inactive' : 'active'}}">{{strtolower($product->status) == 'active' ? 'inactive' : 'active'}}</option>
                                    </select>
                                  </td>
                                @endcan
                                <td>
                                    <input type="checkbox" name="checked[]" class="form-control" id="add{{$product->id}}" onclick="return checkall('selector[]',{{$product->id}});">
                                </td>
                            </tr>

                            @endforeach

                            <input type="text" id="cart" style="display: none">

                            
                            <div class="row">
                              <div class="col-lg-12">
                                <div style="float: left" class="col-md-4" class="form-control">Select Bulk Action</div>
                                <div style="float: left" class="col-md-4">
                                  <select name="action" id="" class="form-control">
                                    <option value="update">Update</option>
                                    <option value="delete">Delete</option>
                                  </select>
                                </div>
                                <div style="float: right" class="col-md-4"><input id="continue-btn" class="btn btn-primary form-control" type="submit" value="Continue"></div>
                              </div>
                              
                            </div>
                            
                            
                            {{-- <input id="continue-btn" class="btn btn-primary form-control" type="submit" value="Continue" onclick="showData()"> --}}

                        
                        </tbody>
                        <tfoot>
                        <tr>
                            <th>Product ID</th>
                            <th>Product Name</th>
                            <th>Stock</th>
                            <th>Price</th>
                            @can('isAdmin')
                              <th>Status</th>
                            @endcan
                            <th>Add</th>
                        </tr>
                        </tfoot>
                    
                    </table>
                </form>
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

    <script>
      var continue_btn= document.getElementById('continue-btn')
      continue_btn.style.display = 'none'
      var cart = document.getElementById('cart')
      var data = {}
      var data_array = []

      function getStock(id){
        var check_item = document.getElementById('add'+id)
        var product_id = document.getElementById('product-id'+id)
        var price = document.getElementById('price'+id)
        var product_name = document.getElementById('product-name'+id)
        var quantity = document.getElementById('quantity'+id)
        

        //Find index of specific object using findIndex method.    
        data_array_index = data_array.findIndex((obj => obj.product_id == product_id.value));
        

        //Update object's name property.
        try {
          data_array[data_array_index].quantity = quantity.value
        } catch (error) {
          
        }
        console.log(data_array)
        cart.value = JSON.stringify(data_array)

      }

      function checkall(selector,id){
          console.log("add"+id)
          var check_item = document.getElementById('add'+id)
          var product_id = document.getElementById('product-id'+id)
          var price = document.getElementById('price'+id)
          var product_name = document.getElementById('product-name'+id)
          var quantity = document.getElementById('quantity'+id)

          // cart.name = "cart"
          
          console.log(id+ " is now " +check_item.checked + " quantity " + quantity.value)
          if (check_item.checked == true) {
              // product_id.name = "product_id[]"
              // price.name = "price[]"
              // product_name.name = "product_name[]"
              // quantity.name = "quantity[]"

              data['product_id'] = product_id.value
              data['price'] = price.value
              data['product_name'] = product_name.value
              data['quantity'] = quantity.value

              data_array = [...data_array, data]

              data = {}
              // data_array.push(data)
              
          } else {
              data_array = data_array.filter(arr => arr.product_id !== product_id.value )
              
          }

          if(data_array.length == 0){
            continue_btn.style.display = 'none'
          }else{
            continue_btn.style.display = 'block'
          } 

          console.log(data_array)
          cart.value = JSON.stringify(data_array)
          console.log(cart.value)
      }

      function showData(){
        event.preventDefault()

        console.log(data)
      }

      
    </script>
@endsection