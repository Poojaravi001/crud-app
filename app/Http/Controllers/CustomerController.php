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
       
        $lastSale = Sale::latest('id')->first();
        
       
        $newBillNo = $lastSale ? $lastSale->bill_no + 1 : 1; 
    
      
        $customers = Customer::all();
        $products = Product::all();
    
        
        return view('products.customer', compact('customers', 'products', 'newBillNo'));
    }
    

    public function store(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'bill_no' => 'required|string|max:255',
            'bill_date' => 'required|date',
            'customer_name' => 'required|exists:customers,name',
            'grand_total' => 'required|numeric',
            'products' => 'required|array', 
            'quantities' => 'required|array',
            'rates' => 'required|array',
            'totals' => 'required|array',
            'mrps' => 'required|array', 
            'discounts' => 'required|array', 
        ]);
    
        // Use the customer name to fetch the customer_id
        $customer = Customer::where('name', $request->customer_name)->first();
    
        
        $sale = new Sale();
        $sale->bill_no = $request->bill_no;
        $sale->bill_date = $request->bill_date;
        $sale->customer_id = $customer->id; // Set the foreign key
        $sale->grand_total = $request->grand_total;
        $sale->save();
    
        // Store sales items
        foreach ($request->products as $index => $productId) {
            SalesItem::create([
                'sale_id' => $sale->id, 
                'product_id' => $productId,
                'qty' => $request->quantities[$index],
                'rate' => $request->rates[$index],
                'total' => $request->totals[$index],
                'mrp' => $request->mrps[$index], 
                'discount' => $request->discounts[$index], 
            ]);
        }
    
        // Redirect back to the customer index with a success message
        return redirect()->route('customers.index')->with('success', 'Sale recorded successfully!');
    }
    
}
