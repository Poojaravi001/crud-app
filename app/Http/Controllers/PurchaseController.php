<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    public function index()
    {
        // Get the maximum receipt_no and increment it by 1
        $newReceiptNo = Purchase::max('receipt_no') + 1;

        $suppliers = Supplier::all();
        $products = Product::all();

        return view('purchase.index', compact('suppliers', 'products', 'newReceiptNo'));
    }

    public function store(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'receipt_no' => 'required|unique:purchases,receipt_no', 
            'receipt_date' => 'required|date',
            'supplier_id' => 'required',
            'invoice_no' => 'required',
            'invoice_date' => 'required|date',
            'grand_total' => 'required|numeric',
        ]);

        // Create the Purchase
        $purchase = Purchase::create($validatedData);

        // Store Purchase Items
        foreach ($request->products as $index => $productId) {
            PurchaseItem::create([
                'purchase_id' => $purchase->id, 
                'product_id' => $productId,
                'quantity' => $request->quantities[$index],
                'price' => $request->prices[$index],
                'purchase_cost' => $request->costs[$index],
                'total' => $request->totals[$index],
                'tax_amount' => $request->tax_amount,
                'tax_percentage' => $request->tax_percentage,
            ]);
        }

        return redirect()->back()->with('success', 'Purchase saved successfully!');
    }
}

