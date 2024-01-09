@extends('layouts.admin_base2')
@section('content')
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Add Category</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Add Category</li>
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
              Category Details
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
            <form action="{{ route('categories.update', $category->id)}}" method="post" enctype="multipart/form-data" id="categoryForm">
                @csrf
                @method('PATCH')
        
                <div class="mb-3">
                    <div class="form-group">
                        <label>Parent Category</label>
                        <select name="parent_id" class="form-control">
                            <option value="">Select parent or leave empty</option>
                            @foreach ($categories as $_category)
                                <option value="{{$_category->id}}" {{ $_category->id == $category->parent_id ? 'selected' : '' }}>
                                    {{$_category->name}}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
        
                <div class="mb-3">
                    <div class="form-group">
                        <label>Category Name</label>
                        <input type="text" class="form-control" value="{{$category->name}}" name="name" placeholder="Category Name">
                    </div>
                </div>
        
                <div class="mb-3">
                    <div class="form-group">
                        <label>Category Photo</label>
                        @if ($category->photo)
                            <img src="{{ asset('storage/' . $category->photo) }}" alt="Category Photo" class="img-fluid mb-2" id="photoPreview">
                        @else
                            <img src="" alt="Category Photo" class="img-fluid mb-2" id="photoPreview" style="display: none;">
                        @endif
                        <input type="file" name="photo" class="form-control-file" id="photoInput" onchange="previewPhoto()">
                    </div>
                </div>
        
                <div class="col-12">
                    <input type="submit" value="Submit" class="btn btn-primary form-control">
                </div>
            </form>
        
            <script>
                function previewPhoto() {
                    var input = document.getElementById('photoInput');
                    var preview = document.getElementById('photoPreview');
        
                    var reader = new FileReader();
        
                    reader.onload = function (e) {
                        preview.src = e.target.result;
                        preview.style.display = 'block';
                    };
        
                    reader.readAsDataURL(input.files[0]);
                }
            </script>
        </div>
        
        
          
        </div>
      </div>
      <!-- /.col-->
    </div>
    <!-- ./row -->
  </section>
@endsection