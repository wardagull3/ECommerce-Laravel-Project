<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        // Get the products based on the search query
        $query = $request->input('query');
        
        // If there's a query, apply the search filters
        if ($query) {
            $products = Product::where('title', 'like', '%' . $query . '%')
                ->orWhereHas('categories', function ($query) use ($request) {
                    $query->where('name', 'like', '%' . $request->input('query') . '%');
                })
                ->orWhere('description', 'like', '%' . $query . '%')
                ->get();
        } else {
            // Otherwise, show all products
            $products = Product::all();
        }

        $categories = Category::all();


        return view('customer.index', compact('products','categories'));
    }

    public function filter(Request $request)
{
    // Get filters
    $category = $request->input('category');
    $priceRange = $request->input('price');
    
    $products = Product::query();

    // Filter by category
    if ($category) {
        $products->whereHas('categories', function ($query) use ($category) {
            $query->where('categories.id', $category);
        });
    }

    // Filter by price range
    if ($priceRange) {
        switch ($priceRange) {
            case '1':
                $products = $products->where('price', '<', 50);
                break;
            case '2':
                $products = $products->whereBetween('price', [50, 100]);
                break;
            case '3':
                $products = $products->whereBetween('price', [100, 200]);
                break;
            case '4':
                $products = $products->where('price', '>', 200);
                break;
        }
    }

    // Get the filtered products
    $products = $products->get();

    // Fetch all categories for the category dropdown
    $categories = Category::all();

    return view('customer.index', compact('products', 'categories'));
}

public function sort(Request $request)
{
    $products = Product::query();

    if ($request->has('sort') && in_array($request->sort, ['asc', 'desc'])) {
        $products = $products->orderBy('price', $request->sort);
    }

    $categories = Category::all();

    $products = $products->get();

    return view('customer.index', compact('products', 'categories'));
}


}
