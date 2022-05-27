<?php

namespace App\Http\Controllers\Influencer;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use Cache;
use Illuminate\Http\Request;
use Str;

class InfluencerProductController
{
    public function index(Request $request)
    {

        $products = Cache::remember('products', 60*30, function () use ($request) {
            sleep(2);
            return Product::all();
        });

        if($search = $request->input('search')){
            $products = $products->filter(function (Product $product) use ($search) {
                return Str::contains($product->name, $search) || Str::contains($product->description, $search);
            });
        }
        return ProductResource::collection($products);

        // return Cache::remember('products', 60*30, function () use ($request) {
        // sleep(2);
        // $search = $request->input('search');
        # search by name and description
        // $products = Product::where('name', 'like', '%' . $search . '%')
            // ->orWhere('description', 'like', '%' . $search . '%')->paginate();
        # search by name
        // $products = Product::where('name', 'like', '%' . $search . '%')->paginate(10);
        // return with pagination
        // $resource =  ProductResource::collection($products);
        // return $resource;
        // });
        
        // $result = Cache::get('products');
        // if($result){
        //     return $result;
        // }
        // sleep(2);
        // $search = $request->input('search');
        # search by name and description
        // $products = Product::where('name', 'like', '%' . $search . '%')
            // ->orWhere('description', 'like', '%' . $search . '%')->paginate();
        # search by name
        // $products = Product::where('name', 'like', '%' . $search . '%')->paginate(10);
        // return with pagination
        // $resource =  ProductResource::collection($products);
        // Cache::set('products', $resource, 10);
        // return $resource;
    }
    // public function influencerProducts(Request $request){
    //     return Cache::remember('influencer_products', 5, function () use ($request) {
    //         $user = $request->user();
    //         $products = Product::where('user_id', $user->id)->get();
    //         return $products->map(function (Product $product) {
    //             return new ProductResource($product);
    //         });
    //     });
    // }
}
