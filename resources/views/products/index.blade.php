@extends('layouts.app')
@section('main')
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="page-title"><i class="bi bi-box"></i> Product Inventory</h5>
        <a href="products/create" class="btn btn-primary new-product-btn">
            <i class="bi bi-plus"></i> Add New Product
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-striped product-table">
            <thead>
                <tr>
                    <th>S.No</th>
                    <th>Image</th>
                    <th>Product</th>
                    <th>MRP</th>
                    <th>Selling Price</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                @php 
                    $index = ($products->currentPage() - 1) * $products->perPage() + $loop->iteration;
                @endphp
                <tr>
                    <td>{{$index}}</td>
                    <td>
                        <img src="products/{{ $product->image }}" 
                             class="product-image" 
                             alt="{{ $product->name }}">
                    </td>
                    <td><a href="products/{{ $product->id }}/show" class="product-name">{{ $product->name }}</a></td>
                    <td><span class="mrp">{{ $product->mrp }}</span></td>
                    <td><span class="selling-price">{{ $product->price }}</span></td>
                    <td class="action-buttons">
                        <a href="products/{{ $product->id }}/edit" class="btn btn-outline-primary btn-sm"><i class="bi bi-pencil-square"></i> Edit</a>
                        <a href="products/{{ $product->id }}/delete" onclick="return confirm('Are you sure you want to delete this product?')" class="btn btn-outline-danger btn-sm"><i class="bi bi-trash"></i> Delete</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
   
            {{ $products->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection
