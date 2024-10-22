@extends('layouts.app')
@section('main')

<div class="row justify-content-center">
    <h5 class="text-center"><i class="bi bi-plus-square-fill"></i> Add New Product</h5>
    <hr class="mb-4 w-100">

    <!-- Breadcrumb -->
    <nav class="my-3 w-100">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="/">Home</a>
            </li>
            <li class="breadcrumb-item active">Add New Product</li>
        </ol>
    </nav>

    <!-- Form Section -->
    <div class="col-md-8 col-lg-6">
        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Product Name -->
            <div class="mb-3">
                <label for="name" class="form-label">Product Name</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                    id="name" name="name" placeholder="Enter product name" 
                    value="{{ old('name') }}">
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- MRP and Price -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="mrp" class="form-label">MRP</label>
                    <input type="text" class="form-control @error('mrp') is-invalid @enderror" 
                        id="mrp" name="mrp" placeholder="Enter MRP" value="{{ old('mrp') }}">
                    @error('mrp')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="price" class="form-label">Price</label>
                    <input type="text" class="form-control @error('price') is-invalid @enderror" 
                        id="price" name="price" placeholder="Enter price" value="{{ old('price') }}">
                    @error('price')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Description -->
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control @error('description') is-invalid @enderror" 
                    id="description" name="description" placeholder="Enter product description">{{ old('description') }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Product Image -->
            <div class="mb-3">
                <label for="image" class="form-label">Product Image</label>
                <input type="file" class="form-control @error('image') is-invalid @enderror" 
                    id="image" name="image">
                @error('image')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Buttons -->
            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-primary">Save Product</button>
                <button type="reset" class="btn btn-danger">Clear All</button>
            </div>
        </form>
    </div>
</div>

@endsection
