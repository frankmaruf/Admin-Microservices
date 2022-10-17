<?php

namespace App\Http\Controllers;

use App\Common\UserService;
use App\Http\Resources\LinkResource;
// use App\Jobs\LinkCreated;
use App\Models\LinkProducts;
use App\Models\Links;
use App\Models\Product;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class InfluencerLinkController
{
    private $userService;
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    public function store(Request $request)
    {
        $user = $this->userService->getUser();
        $link = new Links();
        $link->user_id = $user->id;
        $link->link = Str::random(10);
        $link->save();
        $linkProducts = [];

        foreach ($request->input('products') as $product_id) {
            if(Product::findOrFail($product_id)) {
                $linkProduct = LinkProducts::create([
                    'links_id' => $link->id,
                    'product_id' => $product_id,
                ]);
                $linkProducts[] = $linkProduct->toArray();
            }
        }
        // LinkCreated::dispatch($link,$linkProducts)->onQueue("checkout_queue");
        return new LinkResource($link);
    }
}
