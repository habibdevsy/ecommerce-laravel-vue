<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Category::select('id','name')->with('products:*')->get();
        return response()->json(['data' => $products], 201);
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
            'price' => 'required',
            'isBest' => 'required',
            'brand_id' => 'required',
            'category_id' => 'required',
        ]);
        $product = Product::create([
            'name' => $request->name,
            'imageUrl' => $request->imageUrl,
            'price' => $request->price,
            'isBest' => $request->isBest,
            'brand_id' => $request->brand_id,
            'category_id' => $request->category_id
        ]);

        $category = Category::find($request->category_id);
        $brand = Brand::find($request->brand_id);
        $category =$category->products()->save($product);
        $brand = $brand->products()->save($product);
        return response()->json(['data' => $product, 'msg' => 'success'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::find($id);
        return response()->json(['data' => $product], 201);
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
        //
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
    public function productsOfCategory( $category_id)
    {
        //without category name
        $products  = Product::select()
                        ->where('category_id','=',$category_id)
                        ->get();
        // with category name
    //    $products = Category::select('id','name')->with('products:*')->find($category_id);
        return response()->json(['data' => $products], 200);
    }

    /**
     * Show products for a specific brand
     *
     * @param  int  $brand_id
     * @return \Illuminate\Http\Response
     */
    public function productsOfBrand( $brand_id)
    {
        //without brand name
        $products  = Product::select()
                        ->where('brand_id','=',$brand_id)
                        ->paginate(1);
                        // ->get();
        // with brand name
    //    $products = Brand::select('id','name')->with('products:*')->find($brand_id);
        return response()->json(['data' => $products,'status_code'=>200], 200);
    }

    /**
     * Show products best
     *
     * @return \Illuminate\Http\Response
     */
    public function productsBest()
    {
        $products  = Product::select()

                        ->where('isBest','=',1)
                        // ->paginate(10);
                        ->get();
        return response()->json(['data' => $products], 200);
    }

}
