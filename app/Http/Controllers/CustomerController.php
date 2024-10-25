<?php

namespace App\Http\Controllers;

use App\Models\Customer; // Import the Customer model
use App\Models\Product; // Import the Product model
use App\Models\Sale; // Import the Sale model
use App\Models\SalesItem;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        // Fetch the last sale record
        $lastSale = Sale::latest('id')->first();
        
        // Auto-generate the next bill number by incrementing the last one
        $newBillNo = $lastSale ? $lastSale->bill_no + 1 : 1; // Start from 1 if no previous bills
    
        // Fetch all customers and products from the database
        $customers = Customer::all();
        $products = Product::all();
    
        // Pass customers, products, and the new bill number to the view
        return view('products.customer', compact('customers', 'products', 'newBillNo'));
    }
    

    public function store(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'bill_no' => 'required|string|max:255',
            'bill_date' => 'required|date',
            'customer_name' => 'required|exists:customers,name', // Ensure customer exists
            'grand_total' => 'required|numeric',
            'products' => 'required|array', // Ensure products are provided
            'quantities' => 'required|array',
            'rates' => 'required|array',
            'totals' => 'required|array',
            'mrps' => 'required|array', // Validate MRP array
            'discounts' => 'required|array', // Validate Discount array
        ]);
    
        // Use the customer name to fetch the customer_id
        $customer = Customer::where('name', $request->customer_name)->first();
    
        // Save the sales record
        $sale = new Sale();
        $sale->bill_no = $request->bill_no;
        $sale->bill_date = $request->bill_date;
        $sale->customer_id = $customer->id; // Set the foreign key
        $sale->grand_total = $request->grand_total;
        $sale->save();
    
        // Store sales items
        foreach ($request->products as $index => $productId) {
            SalesItem::create([
                'sale_id' => $sale->id, // Link the sale_id
                'product_id' => $productId,
                'qty' => $request->quantities[$index],
                'rate' => $request->rates[$index],
                'total' => $request->totals[$index],
                'mrp' => $request->mrps[$index], // Add MRP value
                'discount' => $request->discounts[$index], // Add Discount value
            ]);
        }
    
        // Redirect back to the customer index with a success message
        return redirect()->route('customers.index')->with('success', 'Sale recorded successfully!');
    }
    
}
