<?php

namespace App\Http\Controllers;

use App\Models\ProductType;
use Illuminate\Http\Request;

class ProductTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = ProductType::all();
        return response([
            "massage" => 'product_types list',
            "data" => $data
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'type_name' => 'required|unique:product_types,type_name',
        ]);

        ProductType::create(['type_name' => $request->type_name,]);
        return response(["massage" => "product type created successfully"],201);
    }
    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = ProductType::find($id);
        if (is_null($data)) {
            return response([
                "massage" => "Product type not found",
                "data" => []
            ],404);
        }
        return response([
            "massage" => 'product_types list',
            "data" => $data
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'type_name' => 'required|unique:product_types,type_name',
        ]);

        $data = ProductType::find($id);
        if (is_null($data)) {
            return response([
                "massage" => "Product type not found",
                "data" => []
            ],404);
        }
        $data->type_name = $request->type_name;
        $data->save();
        return response(["massage" => "product type updated successfully"],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = ProductType::find($id);
        if (is_null($data)) {
            return response([
                "massage" => "Product type not found",
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
