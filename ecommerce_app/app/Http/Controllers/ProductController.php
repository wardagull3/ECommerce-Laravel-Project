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

    // Only admins can access these routes
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        $products = Product::with('variants')->get();

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
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'categories' => 'required|array',
            'is_on_sale' => 'boolean',
            'discount_percentage' => 'nullable|numeric|min:0|max:100',
            'discount_start_date' => 'nullable|date',
            'discount_end_date' => 'nullable|date'
        ]);


        // Store multiple images
        $images = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('public/storage/images');
                $images[] = basename($path);
            }
        }

        // Create a new product
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
        // Set a default value for is_on_sale if the checkbox is not checked
        $request->merge(['is_on_sale' => $request->has('is_on_sale') ? 1 : 0]);

        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'sku' => 'required|unique:products,sku,' . $product->id,
            'stock_status' => 'required',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'categories' => 'required|array',
            'is_on_sale' => 'boolean',
            'discount_percentage' => 'nullable|numeric|min:0|max:100',
            'discount_start_date' => 'nullable|date',
            'discount_end_date' => 'nullable|date'
        ]);

        // Update images if new ones are uploaded
        $images = json_decode($product->images, true);
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('public/images');
                $images[] = basename($path);
            }
        }

        // Update the product
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
        // Validate that a file is uploaded
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt',
        ]);

        // Read the CSV file
        $path = $request->file('csv_file')->getRealPath();
        $csv = Reader::createFromPath($path, 'r');
        $csv->setHeaderOffset(0);

        $records = $csv->getRecords();

        // Begin a database transaction
        DB::beginTransaction();

        try {
            foreach ($records as $record) {
                // Validate the individual record fields
                $validator = Validator::make($record, [
                    'title' => 'required|string|max:255',
                    'description' => 'nullable|string',
                    'price' => 'required|numeric',
                    'stock_status' => 'required|string',
                    'sku' => 'required|string|max:255',
                    'images' => 'nullable|string',
                ]);

                if ($validator->fails()) {
                    continue; 
                }

                // Process each row in the CSV file
                $product = new Product();

                $product->title = $record['title'];
                $product->description = $record['description'];
                $product->price = $record['price'];
                $product->stock_status = $record['stock_status'];
                $product->sku = $record['sku'];

                // Handle product images (if any)
                $imagePaths = [];
                if (!empty($record['images'])) {
                    $images = explode(',', $record['images']);
                    foreach ($images as $image) {
                        $imagePath = 'images/' . Str::random(10) . '_' . trim($image);
                        $fullImagePath = public_path('storage/images/' . trim($image));

                        // Check if the image file exists
                        if (file_exists($fullImagePath)) {
                            Storage::disk('public')->put($imagePath, file_get_contents($fullImagePath));
                            $imagePaths[] = $imagePath;
                        } else {
                            continue; 
                        }
                    }
                }

                $product->images = json_encode($imagePaths); 
                $product->save();
            }

            DB::commit();

            return redirect()->route('products.index')->with('success', 'Products uploaded successfully.');
        } catch (\Exception $e) {

            DB::rollback();

            return redirect()->route('products.index')->with('error', 'An error occurred while uploading products: ' . $e->getMessage());
        }
    }
}
