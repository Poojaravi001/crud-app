@extends('layouts.app')
@section('main')
<div class="row">
    <div class="d-flex justify-content-between">
      <h5><i class="bi bi-link-45deg"></i> Product Details</h5>
      <a href="products/create" class="btn btn-primary"><i class="bi bi-plus"></i>New Product</a>
    </div>

    <div class="col-md-12 table-responsive mt-3">
      <table class="table table-bordered table-hover">
        <thead>
          <tr>
            <td>S.No</td>
            <td> Image</td>
            <td>Product
            </td>
            <td>
              MRP
            </td>
            <td> selling Price</td>
            <td>Action</td>
          </tr>
        </thead>
        <tbody>
          @foreach ($products as $product)
          @php 
         $index = ($products->currentPage() - 1) * $products->perPage() + $loop->iteration;
          @endphp
          <tr>
            <td>{{$index}}</td>
            <td><img src="products/{{ $product->image }}" style="width: 50px; height: 50px; object-fit: cover;"
                class="img-fluid"></td>
            <td><a href="products/{{ $product->id }}/show">{{ $product->name }}</a></td>
            <td>{{ $product->mrp }}</td>
            <td>{{ $product->price }}</td>
            <td>
              <a href="products/{{ $product->id }}/edit" class="btn btn-primary btn-sm"><i class="bi bi-pencil-square"></i>Edit</a>
              <a href="products/{{ $product->id }}/delete"  onclick="return confirm('Are you sure want to delete this product?')" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i>Delete</a>

            </td>
          </tr>
        @endforeach


        </tbody>
      </table>
      {{ $products->links() }}
    </div>

  </div>
@endsection

