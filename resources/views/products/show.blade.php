@extends('layouts.app')
@section('main')
<h5><i class="bi bi-eye"></i> Product Details</h5>

<!-- Breadcrumb -->
<nav class="my-3">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">Home</a>
        </li>
        <li class="breadcrumb-item active">View Product</li>
    </ol>
</nav>

<!-- Product Card -->
  <div class="card">
     <img src="/products/{{$product->image}}" class="card-img-top" alt="{{$product->name}}" style="height: 300px; object-fit: cover;">
          <div class="card-body">
        <h5 class="card-title fw-bold">{{$product->name}}</h5>
        
        <p class="card-text text-secondary">
            {{$product->description}}
        </p>

     

        <p class="fw-semibold">
            MRP: 
            <small class="text-danger text-decoration-line-through">{{@$product->mrp}}</small>
        </p>

        <p class="fw-semibold">
            Selling Price: 
            <small class="text-success">{{$product->price}}</small>
        </p>
    </div>
</div>


@endsection

