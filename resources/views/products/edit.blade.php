@extends('layouts.app')

@section('main')
<div class="container my-5">
    <h5 class="text-center mb-4"><i class="bi bi-pencil-square"></i> Edit Product</h5>

    <!-- Breadcrumb -->
    {{-- <nav class="my-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item active">Edit Product</li>
        </ol>
    </nav> --}}

  
        <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
              <div class="row justify-content-center">
            <div class="col-md-10 col-lg-8">

                <!-- Product Name -->
                <div class="mb-4">
                    <label for="name" class="form-label">Product Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                           id="name" name="name" placeholder="Enter product name" 
                           value="{{ old('name', $product->name) }}">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- MRP and Price -->
                <div class="row mb-4">
                    <div class="col-md-4">
                        <label for="mrp" class="form-label">MRP</label>
                        <input type="text" class="form-control @error('mrp') is-invalid @enderror" 
                               id="mrp" name="mrp" placeholder="Enter MRP" 
                               value="{{ old('mrp', $product->mrp) }}">
                        @error('mrp')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label for="price" class="form-label">Selling Price</label>
                        <input type="text" class="form-control @error('price') is-invalid @enderror" 
                               id="price" name="price" placeholder="Enter selling price" 
                               value="{{ old('price', $product->price) }}">
                        <small id="mrpError" class="text-danger small d-none">Selling Price must be lesser than or equal to MRP.</small>
                        @error('price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-4">
                        <label for="purchase_cost" class="form-label">Purchase Cost</label>
                        <input type="text" class="form-control @error('purchase_cost') is-invalid @enderror" 
                               id="purchase_cost" name="purchase_cost" placeholder="Enter purchase cost" 
                               value="{{ old('purchase_cost', $product->purchase_cost) }}">
                        <small id="costError" class="text-danger small d-none">Purchase Cost must be lesser than or equal to Selling Price.</small>
                        @error('purchase_cost')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Description -->
                <div class="mb-4">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" 
                              id="description" name="description" placeholder="Enter product description">{{ old('description', $product->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Add New Product Images -->
                <div class="mb-4">
                    <label for="images" class="form-label">Add New Images</label>
                    <input type="file" class="form-control @error('images.*') is-invalid @enderror" 
                           id="images" name="images[]" multiple>
                    @error('images.*')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </form>
                <!-- Existing Images -->
                <h6 class="mt-4">Current Images:</h6>
                <div class="row mb-4">
                    @foreach ($product->images as $image)
                        <div class="col-md-4 mb-3">
                            <img src="{{ asset('products/' . $image->image) }}" alt="Product Image" class="img-fluid" style="height: 150px; object-fit: cover;">
                            <h6 class="mt-3">{{ $image->image }}</h6>
                            <form action="{{ route('products.image.destroy', [$product->id, $image->id]) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this image?');" class="mt-2">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </div>
                    @endforeach
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <button type="submit" class="btn btn-primary">Update Product</button>
                    <button type="reset" class="btn btn-danger">Clear All</button>
                </div>
            </div>
       
    </div>
</div>




@endsection
