@extends('layouts.app')

@section('main')

<div class="container my-5 product-container">
    <h5 class="text-center section-title">Product Details</h5>

    <!-- Breadcrumb -->
    <nav class="my-3 breadcrumb-section">
        <ol class="breadcrumb slide-in-breadcrumb">
            <li class="breadcrumb-item">
                <a href="/">Home</a>
            </li>
            <li class="breadcrumb-item active">Product Details</li>
        </ol>
    </nav>

    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
            <div class="card product-card">
                <div class="card-body text-center">
                    <h5 class="card-title product-name">{{ $product->name }}</h5>
                    <p class="card-text"><strong>MRP:</strong> <span class="mrp">{{ $product->mrp }}</span></p>
                    <p class="card-text"><strong>Price:</strong> <span class="price">{{ $product->price }}</span></p>
                    <p class="card-text"><strong>Description:</strong> {{ $product->description }}</p>

                    <!-- Main Image Display -->
                    <div class="main-image-container">
                        <img id="mainImage" 
                             src="{{ asset('products/' . $product->images[0]->image) }}" 
                             alt="Product Image" 
                             class="main-image">
                    </div>

                    <h6 class="gallery-title">Product Images:</h6>
                    <div class="row">
                        @foreach ($product->images as $image)
                            <div class="col-md-3 mb-3 gallery-item">
                                <img src="{{ asset('products/' . $image->image) }}" 
                                     alt="Product Image" 
                                     class="gallery-image clickable-image"
                                     onclick="changeMainImage(this)">
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

<!-- Add JavaScript -->
<script>
    function changeMainImage(img) {
        const mainImage = document.getElementById('mainImage');
        mainImage.src = img.src; // Update the main image
        mainImage.classList.add('image-zoom-effect'); // Add animation

        setTimeout(() => mainImage.classList.remove('image-zoom-effect'), 500); // Reset animation
    }
</script>

<!-- Add CSS Styles -->
<style>
/* Animation Keyframes */
@keyframes slideIn {
    from { transform: translateX(-100px); opacity: 0; }
    to { transform: translateX(0); opacity: 1; }
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes bounce {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-10px); }
}

@keyframes zoomInEffect {
    from { transform: scale(0.8); opacity: 0; }
    to { transform: scale(1); opacity: 1; }
}

/* Product Container */
.product-container {
    animation: fadeIn 1.2s ease-in-out;
}

/* Section Title */
.section-title {
    animation: bounce 1.5s infinite;
    font-weight: bold;
    color: #333;
}

/* Breadcrumb Styles */
.breadcrumb-section {
    animation: slideIn 1s ease;
}

.breadcrumb {
    background-color: transparent;
}

.breadcrumb-item a {
    color: #3498db;
    text-decoration: none;
    transition: color 0.3s;
}

.breadcrumb-item a:hover {
    color: #2980b9;
}

/* Product Card */
.product-card {
    border-radius: 16px;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
    animation: zoomInEffect 0.8s ease-in-out;
    transition: transform 0.3s, box-shadow 0.3s;
}

.product-card:hover {
    transform: scale(1.03);
    box-shadow: 0 12px 32px rgba(0, 0, 0, 0.2);
}

/* Product Name */
.product-name {
    animation: bounce 2s infinite alternate;
    font-size: 24px;
    font-weight: bold;
    color: #4a4a4a;
}

/* Main Image Styles */
.main-image-container {
    margin-top: 20px;
}

.main-image {
    max-height: 400px;
    width: 100%;
    object-fit: cover;
    border-radius: 12px;
    transition: transform 0.5s;
}

.image-zoom-effect {
    transform: scale(1.1);
}

/* Gallery Styles */
.gallery-title {
    margin-top: 30px;
    font-weight: 500;
    color: #555;
    animation: fadeIn 1.5s ease-in-out;
}

.gallery-item {
    transition: transform 0.3s, box-shadow 0.3s;
}

.gallery-item:hover {
    transform: scale(1.05);
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
}

.gallery-image {
    width: 100%;
    height: 150px;
    object-fit: cover;
    border-radius: 8px;
    cursor: pointer;
}
</style>
