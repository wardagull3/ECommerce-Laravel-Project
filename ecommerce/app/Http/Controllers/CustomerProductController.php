<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class CustomerProductController extends Controller
{
    public function index()
    {
        $products = Product::all(); 
        return view('customer.index', compact('products')); 
    }

    
}
