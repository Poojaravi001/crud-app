<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // List Products with Pagination
    public function index()
    {
        $products = Product::latest()->paginate(5);
        return view('products.index', ['products' => $products]);
    }

    // Show Create Product Form
    public function create()
    {
        return view('products.create');
    }

    // Store New Product with Image Handling
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'mrp' => 'required|numeric|min:0',
            'price' => 'required|numeric|min:0|lt:mrp',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10000',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10000',
        ]);

        // Handle Main Product Image
        $imageName = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . uniqid() . '.' . $image->extension();
            $image->move(public_path('products'), $imageName);
        }

        // Create Product Record
        $product = Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'mrp' => $request->mrp,
            'price' => $request->price,
            'image' => $imageName,
        ]);

        // Handle Additional Product Images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imageName = time() . '_' . uniqid() . '.' . $image->extension();
                $image->move(public_path('products'), $imageName);

                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $imageName,
                ]);
            }
        }

        return back()->with('success', 'Product created successfully.');
    }

    // Show Single Product with Images
    public function show($id)
    {
        $product = Product::with('images')->findOrFail($id);
        return view('products.show', ['product' => $product]);
    }

    // Show Edit Form for Product
    public function edit($id)
    {
        $product = Product::with('images')->findOrFail($id);
        return view('products.edit', ['product' => $product]);
    }

    // Update Product with Image Handling
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'mrp' => 'required|numeric',
            'price' => 'required|numeric|lt:mrp',
            'description' => 'nullable|string',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $product = Product::findOrFail($id);

        // Update product fields
        $product->update($request->only('name', 'mrp', 'price', 'description'));

        // Handle new images upload if any
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imageName = time() . '_' . uniqid() . '.' . $image->extension();
                $image->move(public_path('products'), $imageName);

                // Create new image record in product_images table
                $product->images()->create(['image' => $imageName]);
            }
        }

        return redirect()->route('products.edit', $product->id)->with('success', 'Product updated successfully.');
    }

    // Delete Product and Associated Images
    public function destroy($id)
    {
        $product = Product::with('images')->findOrFail($id);

        // Delete associated images from storage and database
        foreach ($product->images as $image) {
            $imagePath = public_path('products/' . $image->image);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
            $image->delete();
        }

        // Delete product record
        $product->delete();

        return back()->with('success', 'Product deleted successfully.');
    }

    // Delete Specific Image
    public function destroyImage($productId, $imageId)
    {
        $image = ProductImage::findOrFail($imageId);

        // Delete image file from storage
        $imagePath = public_path('products/' . $image->image);
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }

        // Delete image record from database
        $image->delete();

        return back()->with('success', 'Image deleted successfully.');
    }
}
