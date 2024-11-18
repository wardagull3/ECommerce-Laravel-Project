<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Notifications\LowStockNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use League\Csv\Reader;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
       
        $products = Product::with('variants') 
                       ->orderBy('id')    
                       ->cursorPaginate(10);

        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'sku' => 'required|unique:products',
            'stock_status' => 'required',
            'images.*' => 'image',
            'categories' => 'required|array',
            'is_on_sale' => 'boolean',
            'discount_percentage' => 'nullable|numeric|min:0|max:100',
            'discount_start_date' => 'nullable|date',
            'discount_end_date' => 'nullable|date'
        ]);


        $images = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('public/images');
                $images[] = basename($path);
            }
        }

        $product = Product::create([
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'sku' => $request->sku,
            'stock_status' => $request->stock_status,
            'images' => json_encode($images),
            'is_on_sale' => $request->has('is_on_sale') ? $request->is_on_sale : 0,
            'discount_percentage' => $request->discount_percentage,
            'discount_start_date' => $request->discount_start_date,
            'discount_end_date' => $request->discount_end_date

        ]);

        $product->categories()->attach($request->categories);
        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $request->merge(['is_on_sale' => $request->has('is_on_sale') ? 1 : 0]);

        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'sku' => 'required|unique:products,sku,' . $product->id,
            'stock_status' => 'required',
            'images.*' => 'image',
            'categories' => 'required|array',
            'is_on_sale' => 'boolean',
            'discount_percentage' => 'nullable|numeric|min:0|max:100',
            'discount_start_date' => 'nullable|date',
            'discount_end_date' => 'nullable|date'
        ]);

        $images = [];
        if ($request->hasFile('images')) {
        $images = json_decode($product->images, true);
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('public/images');
                $images[] = basename($path);
            }
        }
    }

        $product->update([
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'sku' => $request->sku,
            'stock_status' => $request->stock_status,
            'images' => json_encode($images),
            'is_on_sale' => $request->is_on_sale,
            'discount_percentage' => $request->discount_percentage,
            'discount_start_date' => $request->discount_start_date,
            'discount_end_date' => $request->discount_end_date
        ]);

        $product->categories()->sync($request->categories);
        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }

    public function bulkUpload(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt',
        ]);

        $path = $request->file('csv_file')->getRealPath();
        $csv = Reader::createFromPath($path, 'r');
        $csv->setHeaderOffset(0); 
        $records = $csv->getRecords();

        DB::beginTransaction();


        foreach ($records as $record) {
            $validator = Validator::make($record, [
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'price' => 'required|numeric',
                'stock_status' => 'required|string',
                'sku' => 'required|string|max:255',
            ]);

            if ($validator->fails()) {
                continue; 
            }

            $product = new Product();

            $product->title = $record['title'];
            $product->description = $record['description'];
            $product->price = $record['price'];
            $product->stock_status = $record['stock_status'];
            $product->sku = $record['sku'];

            $product->save();
        }

        DB::commit();

        return redirect()->route('products.index')->with('success', 'Products uploaded successfully.');
    }
}
