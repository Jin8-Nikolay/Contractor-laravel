<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShortLink;
use Illuminate\Support\Str;

class ShortLinkController extends Controller
{
    public function index()
    {
        return view('shortLink', [
            'shortLinks' => ShortLink::latest()->get()
        ]);
    }

    public function store(Request $request)
    {
        $validator = $request->validate([
            'link' => 'required|url'
        ]);

        ShortLink::create([
            'link' => $request->link,
            'code' => str_random(6),
        ]);

        return response()->json(['success' => 'Короткая ссылка успешно создана!', 'recording'=> ShortLink::where('link', $request->link)->first()]);
    }

    public function shortLink($code)
    {
        $link = ShortLink::where('code', $code)->first();
        $link->count++;
        $link->save();

        return redirect($link->link);
    }
}
