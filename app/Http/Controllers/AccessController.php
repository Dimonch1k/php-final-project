<?php

namespace App\Http\Controllers;

use App\Models\Access;
use Illuminate\Http\Request;

class AccessController extends Controller
{
    public function store(Request $request, $gallery_id)
    {
        // dd($request);
        // sleep(20);
        $request->validate([
            'user_id' => 'required',
        ]);

        if ($request->user_id === auth()->id()) {
            return redirect()->back()->with(['error' => 'You can not give access to yourself']);
        }

        $access = Access::create([
            'user_id' => $request->user_id,
            'gallery_id' => $gallery_id
        ]);

        return redirect()->back()->with(['success' => 'The access was created successfully']);
    }

    public function destroy($id)
    {
        $access = Access::findOrFail($id);
        $access->delete();
        return redirect()->back()->with(['success' => 'The access was deleted successfully']);
    }
}