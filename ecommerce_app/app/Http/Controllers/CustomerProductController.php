<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;

class CustomerProductController extends Controller
{
    public function index()
    {
        $products = Product::with('variants')
                        ->orderBy('id')
                        ->cursorPaginate(6);
        $categories = Category::all();
        return view('customer.index', compact('products', 'categories')); 
    }
    

    
}
