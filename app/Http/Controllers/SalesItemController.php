<?php

namespace App\Http\Controllers;

use App\Models\SalesItem;
use Illuminate\Http\Request;

class SalesItemController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'products' => 'required|array',
            'quantities' => 'required|array',
            'rates' => 'required|array',
            'mrps' => 'required|array', 
            'discounts' => 'required|array', 
            'totals' => 'required|array',
        ]);
    
        foreach ($request->products as $index => $productId) {
            SalesItem::create([
                'sale_id' => $request->sale_id,
                'product_id' => $productId,
                'qty' => $request->quantities[$index],
                'rate' => $request->rates[$index],
                'mrp' => $request->mrps[$index], 
                'discount' => $request->discounts[$index], 
                'total' => $request->totals[$index],
            ]);
        }
    
        return redirect()->back()->with('success', 'Sales items added successfully.');
    }

    
}
