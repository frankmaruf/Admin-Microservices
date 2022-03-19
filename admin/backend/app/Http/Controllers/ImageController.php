<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImageUploadRequest;
use Gate;
use Illuminate\Http\Request;
use Storage;

class ImageController extends Controller
{
    public function upload(ImageUploadRequest $request,$product_id)
    {
        Gate::authorize('edit', 'users');
        $file = $request->file('image');
        $fileName =$file->hashName() ?? null.''. time() . '.' . $file->extension();
        $url = Storage::putFileAs('products/images/'.$product_id."/", $file, $fileName);
        return response()->json(['url' => url($url)]);
    }
    public function delete(Request $request,$product_id)
    {
        Gate::authorize('edit', 'users');
        $file = $request->input('file');
        $fileName = basename($file);
        Storage::delete('products/images/'.$product_id.'/'.$fileName);
        return response()->json(['message' => 'File deleted successfully']);
    }
}
