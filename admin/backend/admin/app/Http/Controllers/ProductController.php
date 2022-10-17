<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductCreateRequest;
use App\Http\Resources\ProductResource;
use App\Jobs\ProductCreated;
use App\Jobs\ProductDeleted;
use App\Jobs\ProductUpdated;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Common\UserService;
class ProductController
{
    private $userService;
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    public function index()
    {
        $this->userService->allows('view', 'products');
        $products = Product::paginate();
        return ProductResource::collection($products);
    }
    public function store(ProductCreateRequest $request)
    {
        $this->userService->allows('edit', 'products');
        $product = Product::create($request->only(['name', 'description', 'image','price','stock', 'status']));
        ProductCreated::dispatch($product->toArray())->onQueue("checkout_queue");
        return response()->json(new ProductResource($product), 201);
    }

    public function show($id)
    {
        $this->userService->allows('view', 'products');
        return new ProductResource(Product::findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $this->userService->allows('edit', 'products');
        $product = Product::findOrFail($id);
        $product->update($request->only(['name', 'description', 'image', 'price', 'stock', 'status']));
        ProductUpdated::dispatch($product->toArray(),$id)->onQueue("checkout_queue");
        return response()->json(new ProductResource($product), 202);
    }

    public function destroy($id)
    {
        $this->userService->allows('edit', 'products');
        Product::findOrFail($id)->delete();
        ProductDeleted::dispatch($id)->onQueue("checkout_queue");
        return response('Deleted Successfully', 204);
    }
}
