<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::orderBy('id')->get();

        return response()->json([
            'status' => 'success',
            'products' => $products
        ]);
    }

    public function filterCategory($filter){

        $product=Product::join("categories","categories.id","=","products.category_id")
                          ->where("categories.name","=",$filter)->get();
        return ($product);
  
      }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductRequest $request)
    {
        $product = Product::create($request->all() + ['user_id' => Auth()->user()->id]);

        return response()->json([
            'status' => true,
            'message' => "Product created successfully!",
            'product' => $product
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        $product->find($product->id);
        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }
        return response()->json($product, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(StoreProductRequest $request, Product $product)
    {
        $user = Auth::user();
        if(!$user->can('edit All products')  && $user->id != $product->user_id){
            return response()->json([
                'status' => false,
                'message' => "You don't have the permission to edit this product!",
            ], 200);
        }
        $product->update($request->all());

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        return response()->json([
            'status' => true,
            'message' => "Product Updated successfully!",
            'product' => $product
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $user = Auth::user();
        if(!$user->can('edit All products')  && $user->id != $product->user_id){
            return response()->json([
                'status' => false,
                'message' => "You don't have the permission to delete this product!",
            ], 200);
        }
        $product->delete();

        if (!$product) {
            return response()->json([
                'message' => 'product not found'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'product deleted successfully'
        ], 200);
    }
}