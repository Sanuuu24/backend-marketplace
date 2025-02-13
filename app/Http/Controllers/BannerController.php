<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Banner::all();
        return response([
            "massage" => 'Banner List',
            "data" => $data
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'banner_img_url' => 'required|mimes:jpg,png,svg,jpeg,webp|max:2048',
        ]);

        $imageName = time().".".$request->banner_img_url->extension();
        $request->banner_img_url->move(public_path('image'),$imageName);

        Banner::create([
            'banner_img_url' => url('image/'.$imageName),
            'banner_img_name' => $imageName
        ]);
        return response(["massage" => "Banner created successfully"],201);
    }
    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Banner::find($id);
        if (is_null($data)) {
            return response([
                "massage" => "Banner not found",
                "data" => []
            ],404);
        }
        return response([
            "massage" => 'banners list',
            "data" => $data
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'banner_img_url' => 'required|mimes:jpg,png,svg,jpeg,webp|max:2048',
        ]);

        $data = Banner::find($id);
        if (is_null($data)) {
            return response([
                "massage" => "Banner not found",
                "data" => []
            ],404);
        }

        $imageName = time().".".$request->banner_img_url->extension();
        $request->banner_img_url->move(public_path('image'),$imageName);

        $data->banner_img_url = $request->banner_img_url;
        $data->save();
        return response(["massage" => "Banner updated successfully"],201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Banner::find($id);
        if (is_null($data)) {
            return response([
                "massage" => "Banner type not found",
                "data" => []
            ],404);
        }
        $data->delete();
        return response([
            "massage" => 'Banner is deleted successfully',
            "data" => $data
        ]);
    }
}
