@extends('layouts.app')
@section('main')

<div class="row">
    <h5><i class="bi bi-pencil-square"></i> Edit Product</h5>
    <hr>

    <!-- Breadcrumb -->
    <nav class="my-3">
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="/">Home</a>
          </li>
          <li class="breadcrumb-item active">Edit Product</li>
        </ol>
      </nav>

    <!-- Form Section -->
    <div class="col-md-6">
        <form action="/products/{{ $product->id }}/update" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-12">
                    <label for="name" class="form-label">Product Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                        id="name" name="name" placeholder="Enter product name" 
                        value="{{ old('name',$product->name) }}">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-6">
                    <label for="mrp" class="form-label">MRP</label>
                    <input type="text" class="form-control @error('mrp') is-invalid @enderror" 
                        id="mrp" name="mrp" placeholder="Enter MRP" value="{{ old('mrp',$product->mrp) }}">
                    @error('mrp')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="price" class="form-label">Price</label>
                    <input type="text" class="form-control @error('price') is-invalid @enderror" 
                        id="price" name="price" placeholder="Enter price" value="{{ old('price',$product->price) }}">
                    @error('price')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-12">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" 
                        id="description" name="description" >{{ old('description',$product->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-12">
                    <label for="image" class="form-label">Product Image</label>
                    <input type="file" class="form-control @error('image') is-invalid @enderror" 
                        id="image" name="image">
                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary">updated Product</button>
                    <button type="reset" class="btn btn-danger">Clear All</button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection
