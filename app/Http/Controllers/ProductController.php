<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Product::join('product_types', 'products.product_type_id', '=', 'product_types.id')
            ->select('products.*', 'product_types.type_name')
            ->get();
        return response([
            "message" => "Product List",
            "data" => $data,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'products_name' => 'required|unique:products,products_name',
            'product_type_id' => 'required|exists:product_types,id',
            'description' => 'required',
            'stock' => 'required|numeric',
            'price' => 'required|numeric',
            'img_url' => 'required|image:jpg,png|max:2048',
        ]);

        $imageNames = time().'.'.$request->img_url->extension();

        $request->img_url->move(public_path('images'), $imageNames);

        Product::create([
            'products_name' => $request->products_name,
            'product_type_id' => $request->product_type_id,
            'description' => $request->description,
            'stock' => $request->stock,
            'price' => $request->price,
            'img_url' => url('images/'.$imageNames),
            'img_name' => $imageNames,
        ]);

        return response([
            "message" => "Product Created Successfully!"
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Product::find($id);
        if($data == null){
            return response([
                "message" => "Product Not Found",
                "data" => [],
            ], 404);
        }

        return response([
            "message" => "Product List",
            "data" => $data,
        ]); 
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'products_name' => 'required|unique:products,products_name',
            'product_type_id' => 'required|exists:products,product_type_id',
            'description' => 'required',
            'stock' => 'required',
            'price' => 'required',
            'img_url' => 'required|image:jpg,png|max:2048',
        ]);

        $imageNames = time().'.'.$request->img_url->extension();

        $request->img_url->move(public_path('images'), $imageNames);


        $data = Product::find($id);
        if($data == null){
            return response([
                "message" => "Product Type Not Found",
                "data" => [],
            ], 404);
        }

        $data->products_name = $request->products_name;
        $data->product_type_id = $request->product_type_id;
        $data->description = $request->description;
        $data->stock = $request->stock;
        $data->price = $request->price;
        $data->img_url = $request->img_url;
        $data->img_name = $imageNames;
        $data->save();

        return response([
            "message" => "Product Created Successfully!"
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Product::find($id);
        if($data == null){
            return response([
                "message" => "Product Not Found",
                "data" => [],
            ], 404);
        }

        $data->delete();

        return response([
            "message" => "Product Deleted Successfully!",
            "data" => $data,
        ], 200);
    }
}
