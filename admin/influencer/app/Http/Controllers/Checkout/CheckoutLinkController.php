<?php

namespace App\Http\Controllers\Checkout;

use App\Http\Resources\LinkResource;
use App\Models\Links;
use Illuminate\Http\Request;

class CheckoutLinkController
{
    public function show($link)
    {
        $link = Links::where('link', $link)->first();
        if (!$link) {
            return response()->json(['error' => 'Link not found'], 404);
        }
        return new LinkResource($link);
    } 
}
