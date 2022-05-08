<?php

namespace App\Http\Controllers\Influencer;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class InfluencerProductController
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        # search by name and description
        $products = Product::where('name', 'like', '%' . $search . '%')
            ->orWhere('description', 'like', '%' . $search . '%')->paginate();
        # search by name
        // $products = Product::where('name', 'like', '%' . $search . '%')->paginate(10);
        // return with pagination
        return ProductResource::collection($products);
    }
}
