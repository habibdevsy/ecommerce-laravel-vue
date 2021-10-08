<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\Product;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $brands = Brand::all();
        // return response()->json(['data' => $brands], 201);

        $brands = Brand::select('id','name','imageUrl')->with('products:*')
        ->get();
        return response()->json(['data' => $brands], 201);

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
            'name' => 'required',
            'imageUrl' => 'required',
        ]);
        $brand = Brand::create([
            'name' => $request->name,
            'imageUrl' => $request->imageUrl
        ]);
        $success = $brand->save();
        if(!$success) {
            return response()->json(['data' => $success], 000);
        }
        return response()->json(['data' => $success,'msg'=>'success'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $brand = Brand::find($id);
        return response()->json(['data' => $brand], 201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $brand = Brand::find($id);
        $brand->name = $request->name;
        $brand->imageUrl = $request->imageUrl;
        $brand->update($request->all());
        return response()->json(['data'=>$brand,'msg'=>'success'],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Show products for a specific category
     *
     * @return \Illuminate\Http\Response
     */
    public function brandsWithProducts()
    {
       $brands = Brand::select('id','name')->with('products:*')->get();
        return response()->json(['data' => $brands], 200);
    }
}
