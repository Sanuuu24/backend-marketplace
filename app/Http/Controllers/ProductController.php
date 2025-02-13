<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Product::join('product_types', 'products.product_type_id', '=', 'product_types.id')
        ->select('products.*', 'product_types.type_name')->get();
        return response([
            "massage" => 'products list',
            "data" => $data
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_name' => 'required|unique:products,product_name',
            'product_type_id' => 'required|exists:product_types,id',
            'description' => 'required',
            'stock' => 'required|numeric',
            'price' => 'required|numeric',
            'img_url' => 'required|mimes:jpg,png,svg,jpeg,webp|max:2048',
        ]);

        $imageName = time().".".$request->img_url->extension();
        $request->img_url->move(public_path('image'),$imageName);

        Product::create([
            'product_name' => $request->product_name,
            'product_type_id' => $request->product_type_id,
            'description' => $request->description,
            'stock' => $request->stock,
            'price' => $request->price,
            'img_url' => url('image/'.$imageName),
            'img_name' => $imageName
        ]);
        return response(["massage" => "product created successfully"],201);
    }
    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Product::find($id);
        if (is_null($data)) {
            return response([
                "massage" => "Product not found",
                "data" => []
            ],404);
        }
        return response([
            "massage" => 'products list',
            "data" => $data
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'product_name' => 'required|unique:products,product_name',
            'product_type_id' => 'required|exists:product_types,id',
            'description' => 'required',
            'stock' => 'required|numeric',
            'price' => 'required|numeric',
            'img_url' => 'required|mimes:jpg,png,svg,jpeg,webp|max:2048',
        ]);

        $data = Product::find($id);
        if (is_null($data)) {
            return response([
                "massage" => "Product not found",
                "data" => []
            ],404);
        }

        $imageName = time().".".$request->img_url->extension();
        $request->img_url->move(public_path('image'),$imageName);

        $data->product_name = $request->product_name;
        $data->product_type_id = $request->product_type_id;
        $data->description = $request->description;
        $data->price = $request->price;
        $data->stock = $request->stock;
        $data->img_url = $request->img_url;
        $data->save();

        return response(["massage" => "product update successfully"],201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Product::find($id);
        if (is_null($data)) {
            return response([
                "massage" => "Product not found",
                "data" => []
            ],404);
        }
        $data->delete();
        return response([
            "massage" => 'Product is deleted successfully',
            "data" => $data
        ]);
    }
}
