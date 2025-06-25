<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SlugController extends Controller
{
    public function generate(Request $request)
    {
        $title = $request->input('title');
        $slug = Str::slug($title);

        return response()->json(['slug' => $slug]);
    }
}
