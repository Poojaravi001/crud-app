<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    // Method to handle supplier form submission and display phone number
    public function getSupplierDetails($id)
    {
        $supplier = Supplier::find($id);
    
        if ($supplier) {
            return response()->json(['phone' => $supplier->phone]);
        }
    
        return response()->json(['error' => 'Supplier not found'], 404);
    }
    
}
