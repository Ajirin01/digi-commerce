@extends('layouts.admin_base2')
@section('content')
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Edit Product</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Edit Product</li>
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
              Product Details
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
                <form action="{{ route('products.update', $product->id )}}" method="post" enctype="multipart/form-data">
                    @csrf 
                    @method('PUT')
                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                    <div class="mb-3">
                        <div class="form-group">
                            <label>Product Sale Type</label>
                            <select name="sale_type" class="form-control">
                                <option value="normal">please select or leave empty</option>
                                <option value="new_arrival">new arrival</option>
                                <option value="featured">featured</option>
                                <option value="hot_sale">hot sale</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                      <div class="form-group">
                          <label>Category</label>
                          <select name="category_id" class="form-control">
                              <option value="{{optional($category)->id}}">Select or leave empty if not updating</option>
                              @foreach ($categories as $cat)
                                <option value="{{$cat->id}}">{{$cat->name}}</option>
                              @endforeach
                          </select>
                      </div>
                    </div>
                    <div class="mb-3">
                        <div class="form-group">
                            <label>Brand</label>
                            <select name="brand_id" class="form-control">
                              <option value="{{optional($brand)->id}}">Select or leave empty if not updating</option>
                                @foreach ($brands as $bra)
                                  <option value="{{$bra->id}}">{{$bra->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                  <div class="mb-3">
                      <div class="form-group">
                          <label>Product Name</label>
                          <input type="text" class="form-control" name="name" value="{{ $product->name }}" placeholder="Enter Product Name">
                      </div>
                  </div>
                  <div class="mb-3">
                    <label>Product Photos</label>
                    <input type="file" name="photos[]" class="form-control" multiple accept="image/*" onchange="previewPhotos(this)">
                    <div id="photo-preview" class="mt-2">
                      @foreach ((json_decode($product->photos)) as $photo)
                          <img class="preview-image" src="{{$photo}}" alt="">
                      @endforeach
                    </div>
                  </div>
                  <div class="mb-3">
                    <div class="mb-3">
                      <label>Variation</label><br>

                      <div id="color-variation">
                        <span>Color</span>
                        <div id="color-area">
                          @foreach (optional(json_decode($product->variations))->colors ?? [] as $colorCode => $price)
                            <div class="input-group" ondblclick="deleteLastComponent(this)">
                              <input name="color_price[]" type="text" placeholder="Color price" value="{{$price}}" class="form-control">
                              <select name="color[]" class="form-control">
                                <option value="{{$colorCode}}" selected><span style="color: {{$colorCode}}">Select New or leave empty</span></option>
                                <option value="#FF0000" style="background-color: #FFFFFF; color: black">White</option>
                                <option value="#000000" style="background-color: #000000; color: #FFFFFF">Black</option>
                                <option value="#FFFF00" style="background-color: #FFFF00; color: black">Yellow</option>
                                <option value="#FF0000" style="background-color: #FF0000; color: black">Red</option>
                                <option value="#0000FF" style="background-color: #0000FF; color: #FFFFFF">Blue</option>
                                <option value="#A52A2A" style="background-color: #A52A2A; color: #FFFFFF">Brown</option>
                                <option value="#FFA500" style="background-color: #FFA500; color: #FFFFFF">Orange</option>
                                <option value="#008000" style="background-color: #008000; color: #FFFFFF">Green</option>
                                <option value="#808080" style="background-color: #808080; color: #FFFFFF">Gray</option>
                              </select>
                              <input name="" type="text"  class="form-control" style="background-color: {{$colorCode}}">
                            </div>
                          @endforeach
                        </div>

                        <i class="fa fa-plus" onclick="addColors()"></i>
                      </div>
                      
                      <div id="size-variation">
                        <span>Size</span>
                        <div id="size-area">
                          @foreach (optional(json_decode($product->variations))->sizes?? [] as $sizeCode => $price)
                            <div class="input-group" ondblclick="deleteLastComponent(this)">
                                <input name="size_price[]" type="text" placeholder="Size price" value="{{$price}}" class="form-control">
                                <select name="size[]" class="form-control" value="">
                                  <option value="{{$sizeCode}}">{{$sizeCode}}</option>
                                  <option value="M">Medium</option>
                                  <option value="L">Large</option>
                                  <option value="XL">Extra Large</option>
                                  <option value="XXL">Extra Extra Large</option>
                                  <option value="38">38</option>
                                  <option value="40">40</option>
                                  <option value="41">41</option>
                                  <option value="42">42</option>
                                  <option value="43">43</option>
                                  <option value="44">44</option>
                                  <option value="45">45</option>
                                  <option value="46">46</option>
                                  <option value="47">47</option>
                                </select>
                            </div>
                          @endforeach

                        </div>

                        <i class="fa fa-plus" onclick="addSizes()"></i>
                      </div>
                  </div>
                  <div class="mb-3">
                      <label>Prouduct Description</label>
                      <textarea name="description" class="textarea" placeholder="Place some text here"
                              style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">{{ $product->description }}</textarea>
                  </div>

                  <div class="mb-3">
                    <label>Prouduct Stock</label>
                    <input type="number" name="quantity" id="" value="{{$product->quantity}}" class="form-control">
                  </div>
                  <div class="mb-3">
                    <label>Prouduct Price</label>
                    <input type="number" name="price" id="" value="{{$product->price}}" class="form-control">
                  </div>
                  <div class="mb-3">
                    <label>Percentage off</label>
                    <input type="number" name="percent_off" id="" value="{{$product->percent_off}}" class="form-control">
                  </div>
                  <div class="mb-3">
                    <label>Sale starts</label>
                    <input type="datetime-local" name="sale_start" id="" value="{{$product->sale_start}}" class="form-control">
                  </div>

                  <div class="mb-3">
                    <label>Sale ends</label>
                    <input type="datetime-local" name="sale_end" value="{{$product->sale_end}}" class="form-control">
                </div>

                  @can('isAdmin')
                      <div class="mb-3">
                        <div class="form-group">
                            <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                <input name="status" type="checkbox" class="custom-control-input" id="customSwitch3">
                                <label class="custom-control-label" for="customSwitch3">Change the product to active(green) or inactive(red)</label>
                            </div>
                        </div>
                    </div>
                  @endcan
                  
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

  <script>
    var colorArea = document.getElementById('color-area');
    var sizeArea = document.getElementById('size-area');
    var counter = 0

    var colorComponent = `
        <div class="input-group" ondblclick="deleteLastComponent(this)">
            <input name="color_price[]" type="text" placeholder="Color price" class="form-control">
            <select name="color[]" class="form-control" ng-model="_color${counter}">
                <option value="#FF0000" style="background-color: #FFFFFF; color: black">White</option>
                <option value="#000000" style="background-color: #000000; color: #FFFFFF">Black</option>
                <option value="#FFFF00" style="background-color: #FFFF00; color: black">Yellow</option>
                <option value="#FF0000" style="background-color: #FF0000; color: black">Red</option>
                <option value="#0000FF" style="background-color: #0000FF; color: #FFFFFF">Blue</option>
                <option value="#A52A2A" style="background-color: #A52A2A; color: #FFFFFF">Brown</option>
                <option value="#FFA500" style="background-color: #FFA500; color: #FFFFFF">Orange</option>
                <option value="#008000" style="background-color: #008000; color: #FFFFFF">Green</option>
                <option value="#808080" style="background-color: #808080; color: #FFFFFF">Gray</option>
            </select>
            <input type="text" class="form-control" ng-style="{backgroundColor: _color${counter}}">
        </div>`;

    var sizeComponent = `
        <div class="input-group" ondblclick="deleteLastComponent(this)">
            <input name="size_price[]" type="text" placeholder="Size price" value="" class="form-control">
            <select name="size[]" class="form-control" value="">
                <option value="M">Medium</option>
              <option value="L">Large</option>
              <option value="XL">Extra Large</option>
              <option value="XXL">Extra Extra Large</option>
              <option value="38">38</option>
              <option value="40">40</option>
              <option value="41">41</option>
              <option value="42">42</option>
              <option value="43">43</option>
              <option value="44">44</option>
              <option value="45">45</option>
              <option value="46">46</option>
              <option value="47">47</option>
            </select>
        </div>`;

    function addColors() {
        colorArea.insertAdjacentHTML('beforeend', colorComponent);
        counter++
    }

    function deleteLastComponent(element) {
        let confirmDelete = confirm("Are you sure you want to delete this item")
        if (confirmDelete){
          if (element.parentElement) {
              element.parentElement.removeChild(element);
              counter--;
          }
          alert("Item deleted!")
        }
    }

    function addSizes() {
        sizeArea.insertAdjacentHTML('beforeend', sizeComponent);
    }
</script>
<!-- Add this inside your script -->
<script>
  function previewPhotos(input) {
      var previewArea = document.getElementById('photo-preview');
      previewArea.innerHTML = '';

      if (input.files) {
          for (var i = 0; i < input.files.length; i++) {
              var reader = new FileReader();

              reader.onload = function (e) {
                  var img = document.createElement('img');
                  img.src = e.target.result;
                  img.className = 'preview-image';
                  previewArea.appendChild(img);
              };

              reader.readAsDataURL(input.files[i]);
          }
      }
  }
</script>

<style>
  .preview-image {
    width: 100px;
    height: 100px;
    margin-right: 10px;
}
</style>
@endsection