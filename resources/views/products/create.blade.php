@extends('layouts.app')
@section('main')

<div class="container my-5">
    <h5 class="text-center mb-4"><i class="bi bi-plus-square-fill"></i> Add New Product</h5>
    
    <!-- Breadcrumb -->
    <nav class="my-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="/">Home</a>
            </li>
            <li class="breadcrumb-item active">Add New Product</li>
        </ol>
    </nav>

    <!-- Form Section -->
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
            <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Product Name -->
                <div class="mb-4">
                    <label for="name" class="form-label">Product Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                           id="name" name="name" placeholder="Enter product name" 
                           value="{{ old('name') }}">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- MRP and Price -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <label for="mrp" class="form-label">MRP</label>
                        <input type="text" class="form-control @error('mrp') is-invalid @enderror" 
                               id="mrp" name="mrp" placeholder="Enter MRP" value="{{ old('mrp') }}">
                        @error('mrp')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="price" class="form-label">selling Price</label>
                        <input type="text" class="form-control @error('price') is-invalid @enderror" 
                               id="price" name="price" placeholder="Enter price" value="{{ old('price') }}">
                        @error('price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Description -->
                <div class="mb-4">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" 
                              id="description" name="description" placeholder="Enter product description">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Product Image -->
                <div class="mb-4">
                    <label for="images" class="form-label">Product Images</label>
                    <input type="file" class="form-control @error('images') is-invalid @enderror" id="images" name="images[]" multiple>

                    @error('images')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                
                    <ul id="imageList" class="list-unstyled mt-3"></ul>
                </div>

                <!-- Buttons -->
                <div class="d-flex justify-content-between mt-4">
                    <button type="submit" class="btn btn-primary">Save Product</button>
                    <button type="reset" class="btn btn-danger">Clear All</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    document.getElementById('images').addEventListener('change', function (e) {
        const imageList = document.getElementById('imageList');
        imageList.innerHTML = ''; // Clear previous list

        Array.from(e.target.files).forEach(file => {
            const li = document.createElement('li');
            li.textContent = file.name;
            imageList.appendChild(li);
        });
    });

    document.querySelector('form').addEventListener('submit', function (e) {
    const mrp = parseFloat(document.getElementById('mrp').value) || 0;
    const price = parseFloat(document.getElementById('price').value) || 0;

    if (price >= mrp) {
        e.preventDefault(); // Prevent form submission
        alert('The selling price must be less than the MRP.');
    }
});

</script>

@endsection
