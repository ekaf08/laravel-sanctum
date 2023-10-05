<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Product::orderBy('name', 'asc')->get();
        return response()->json([
            'status' => true,
            'message' => 'data ditemukan',
            'data' => $data,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $newproduk = new Product();
        $rules = [
            'name' => 'required',
            'price' => 'required',
            'description' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'proses validasi gagal',
                'data' => $validator->errors(),
            ], 401);
        }

        $newproduk->name = $request->name;
        $newproduk->price = $request->price;
        $newproduk->description = $request->description;
        $newproduk->save();

        return response()->json([
            'status' => true,
            'message' => 'produk berhasil ditambahkan',
            'data' => $newproduk,
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}
