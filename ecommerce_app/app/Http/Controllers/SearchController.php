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
        $query = $request->input('query');

        if ($query) {
            $products = Product::where('title', 'like', '%' . $query . '%')
                ->orWhere('description', 'like', '%' . $query . '%')
                ->orderby('id')
                ->cursorPaginate(6);
        } else {
            $products = Product::orderby('id')->cursorPaginate(6);
        }

        $categories = Category::all();

        return view('customer.index', compact('products', 'categories'));
    }

    public function filter(Request $request)
    {

        $category = $request->input('category');
        $priceRange = $request->input('price');

        $products = Product::query();


        if ($category) {
            $products->whereHas('categories', function ($query) use ($category) {
                $query->where('categories.id', $category);
            });
        }


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


        $products = $products->orderBy('id')->cursorPaginate(6);


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


        $products = $products->orderBy('id')->cursorPaginate(6);
        return view('customer.index', compact('products', 'categories'));
    }
}
