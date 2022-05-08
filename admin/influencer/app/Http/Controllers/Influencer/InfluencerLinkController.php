<?php

namespace App\Http\Controllers\Influencer;

use App\Http\Controllers\Controller;
use App\Http\Resources\LinkResource;
use App\Models\LinkProducts;
use App\Models\Links;
use App\Models\Product;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class InfluencerLinkController
{
    public function store(Request $request)
    {
        // $request->validate([
        //     'link' => 'required|url|unique:links,link',
        // ]);
        $link = new Links();
        // $link->link = $request->input('link');
        $link->user_id = Auth::user()->id;
        $link->link = Str::random(10);
        $link->save();
        // create LinkProducts
        foreach ($request->input('products') as $product_id) {
            if(Product::findOrFail($product_id)) {
                LinkProducts::create([
                    'links_id' => $link->id,
                    'product_id' => $product_id,
                ]);
            }
        }
        return new LinkResource($link);
    }
}
