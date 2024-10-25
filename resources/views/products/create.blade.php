@extends('layouts.app')
@section('main')

<div class="container my-5">
    <h5 class="text-center mb-4"><i class="bi bi-plus-square-fill"></i> Add New Product</h5>

    <!-- Breadcrumb -->
    {{-- <nav class="my-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="/">Home</a>
            </li>
            <li class="breadcrumb-item active">Add New Product</li>
        </ol>
    </nav> --}}

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

                <!-- MRP, Price, and Purchase Cost -->
                <div class="row mb-4">
                    <div class="col-md-4">
                        <label for="mrp" class="form-label">MRP</label>
                        <input type="text" class="form-control @error('mrp') is-invalid @enderror"
                               id="mrp" name="mrp" placeholder="Enter MRP" value="{{ old('mrp') }}">
                        @error('mrp')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label for="price" class="form-label">Selling Price</label>
                        <input type="text" class="form-control @error('price') is-invalid @enderror"
                               id="price" name="price" placeholder="Enter selling price" value="{{ old('price') }}">
                        <small id="mrpError" class="text-danger form-text small d-none">Selling Price must be lesser than or equal to MRP.</small>
                        @error('price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-4 mb-4">
                        <label for="purchase_cost" class="form-label">Purchase Cost</label>
                        <input type="text" class="form-control @error('purchase_cost') is-invalid @enderror"
                               id="purchase_cost" name="purchase_cost" placeholder="Enter purchase cost" 
                               value="{{ old('purchase_cost') }}">
                        <small id="costError" class="text-danger form-text small d-none">Purchase Cost must be lesser than or equal to Selling Price.</small>
                        @error('purchase_cost')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
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

                <!-- Product Images -->
                <div class="mb-4">
                    <label for="images" class="form-label">Product Images</label>
                    <input type="file" class="form-control @error('images') is-invalid @enderror"
                           id="images" name="images[]" multiple>
                    <ul id="imageList" class="list-unstyled mt-3"></ul>
                    @error('images')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
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
    // Display selected image names
    document.getElementById('images').addEventListener('change', function (e) {
        const imageList = document.getElementById('imageList');
        imageList.innerHTML = ''; // Clear previous list

        Array.from(e.target.files).forEach(file => {
            const li = document.createElement('li');
            li.textContent = file.name;
            imageList.appendChild(li);
        });
    });

    // Real-time validation
    document.getElementById('price').addEventListener('input', validateFields);
    document.getElementById('mrp').addEventListener('input', validateFields);
    document.getElementById('purchase_cost').addEventListener('input', validateFields);

    function validateFields() {
        const mrp = parseFloat(document.getElementById('mrp').value) || 0;
        const price = parseFloat(document.getElementById('price').value) || 0;
        const purchaseCost = parseFloat(document.getElementById('purchase_cost').value) || 0;

        const mrpError = document.getElementById('mrpError');
        const costError = document.getElementById('costError');

        // Validate MRP vs Price
        if (price > mrp) {
            mrpError.classList.remove('d-none');
        } else {
            mrpError.classList.add('d-none');
        }

        // Validate Purchase Cost vs Price
        if (purchaseCost > price) {
            costError.classList.remove('d-none');
        } else {
            costError.classList.add('d-none');
        }
    }
</script>

<style>
    .text-danger {
    font-size: 0.85rem; /* Adjust the font size as needed */
    color: #dc3545; /* Bootstrap's danger color */
}

.form-text {
    font-size: 0.75rem; /* Slightly smaller for additional context */
}

</style>



@endsection
