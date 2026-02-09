<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    public function uploadAvatar(Request $request)
    {
        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('tmp', 'public');
        }
        return $path;
    }

    public function deleteAvatar(Request $request)
    {
        if ($request->getContent()) {
            Storage::disk('public')->delete($request->getContent());
        }

        return response()->noContent();
    }
}
