@extends('layouts.app')

@section('main')

<div class="container my-5">
    <h5 class="text-center mb-4">Product Details</h5>
    
    <!-- Breadcrumb -->
    <nav class="my-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="/">Home</a>
            </li>
            <li class="breadcrumb-item active">Product Details</li>
        </ol>
    </nav>

    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ $product->name }}</h5>
                    <p class="card-text"><strong>MRP:</strong> {{ $product->mrp }}</p>
                    <p class="card-text"><strong>Price:</strong> {{ $product->price }}</p>
                    <p class="card-text"><strong>Description:</strong> {{ $product->description }}</p>

                   
                    <h6 class="mt-4">Product Images:</h6>
                    <div class="row">
                        @foreach ($product->images as $image)
                            <div class="col-md-3 mb-3">
                                <img src="{{ asset('products/' . $image->image) }}" alt="Product Image" class="img-fluid gallery-image"> <!-- Display smaller images -->
                            </div>
                        @endforeach
                    </div>

                    <!-- Optionally, you could add buttons to edit or delete the product -->
                    {{-- <div class="mt-4">
                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning">Edit Product</a>

                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this product?')">Delete Product</button>
                        </form>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

<!-- Add CSS styles -->
<style>
.main-image {
    width: 100%; /* Set width to 100% of the parent column */
    height: auto; /* Auto height to maintain aspect ratio */
    max-height: 400px; /* Set a maximum height */
    object-fit: cover; /* Maintain aspect ratio and cover the area */
    border: 1px solid #ddd; /* Optional: Add a border for better visibility */
    border-radius: 5px; /* Optional: Rounded corners */
}

.gallery-image {
    width: 100%; /* Set width to 100% of the parent column */
    height: 150px; /* Set a fixed height for smaller images */
    object-fit: cover; /* Cover the area without distortion */
    border: 1px solid #ddd; /* Optional: Add a border for better visibility */
    border-radius: 5px; /* Optional: Rounded corners */
}
</style>
