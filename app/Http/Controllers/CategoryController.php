<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();
        return response()->json(['data' => $categories], 201);
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
        $category = Category::create([
            'name' => $request->name,
            'imageUrl' => $request->imageUrl
        ]);
        $success = $category->save();
        if(!$success) {
            return response()->json(['data' => $success], 000);
        }
        return response()->json(['data' => $success], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = Category::find($id);
        return response()->json(['data' => $category], 201);
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
        $category = Category::find($id);
        $category->name = $request->name;
        $category->imageUrl = $request->imageUrl;
        $category->update($request->all());
        return response()->json(['data'=>$category,'msg'=>'success'],200);
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
     * @param  int  $category_id
     * @return \Illuminate\Http\Response
     */
    public function categoriesWithProducts()
    {
       $categories = Category::select('id','name')->with('products:*')->get();
        return response()->json(['data' => $categories], 200);
    }
}
