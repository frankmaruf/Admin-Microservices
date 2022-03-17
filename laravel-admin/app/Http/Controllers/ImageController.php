<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImageUploadRequest;
use Gate;
use Illuminate\Http\Request;
use Storage;

class ImageController extends Controller
{
    public function upload(ImageUploadRequest $request)
    {
        Gate::authorize('edit', 'users');
        $file = $request->file('image');
        $fileName = time() . '.' . $file->getClientOriginalExtension();
        $url = Storage::putFileAs('products/images', $file, $fileName);
        return response()->json(['url' => url($url)]);
    }
}
