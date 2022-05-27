<?php

namespace App\Http\Controllers\Admin;

use App\Events\ProductUpdateEvent;
use App\Http\Requests\ProductCreateRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Gate;
use Illuminate\Http\Request;
use Storage;
use Symfony\Component\HttpFoundation\Response;

class ProductController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Gate::authorize('view', 'users');
        $products = Product::paginate();
        return ProductResource::collection($products);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductCreateRequest $request)
    {
        Gate::authorize('edit', 'users');
        // $file = $request->file('image');
        // $fileName = time() . '.' . $file->getClientOriginalExtension();
        // $url = Storage::putFileAs('products/images', $file, $fileName);

        $product = Product::create($request->only(['name', 'description', 'image','price','stock', 'status']));
        // $product = Product::create($request->only(['name', 'description', 'image', 'price', 'stock', 'status']));
        event(new ProductUpdateEvent());
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
        Gate::authorize('view', 'users');
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
        Gate::authorize('edit', 'users');
        $product = Product::findOrFail($id);
        $product->update($request->only(['name', 'description', 'image', 'price', 'stock', 'status']));
        event(new ProductUpdateEvent());
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
        Gate::authorize('edit', 'users');
        Product::findOrFail($id)->delete();
        return response('Deleted Successfully', Response::HTTP_NO_CONTENT);
    }
}
