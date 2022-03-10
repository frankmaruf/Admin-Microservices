<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Storage;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $prducts = Product::paginate();
        return ProductResource::collection($prducts);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $file = $request->file('image');
        $fileName = time() . '.' . $file->getClientOriginalExtension();
        $url = Storage::putFileAs('public/products', $file, $fileName);
        $product = Product::create($request->only(['name', 'description', 'price', 'stock', 'status']) + [
            'image' => $fileName,
        ]);
        // $product = Product::create($request->only(['name', 'description', 'image', 'price', 'stock', 'status']));
        return response()->json(new ProductResource($product), Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new ProductResource(Product::findOrFail($id));
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
        $product = Product::findOrFail($id);
        $product->update($request->only(['name', 'description', 'image', 'price', 'stock', 'status']));
        return response()->json(new ProductResource($product), Response::HTTP_ACCEPTED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Product::findOrFail($id)->delete();
        return response('Deleted Successfully', Response::HTTP_NO_CONTENT);
    }
}
