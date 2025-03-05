<?php

namespace App\Http\Controllers;

use App\Models\Access;
use App\Models\Gallery;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $galleries = Gallery::all();
        $accesses = Access::where('user_id', Auth::id())->get();

        return view('galleries.index', compact('galleries', 'accesses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|min:2',
        ]);

        $gallery = Gallery::create([
            'title' => $request->title,
            'user_id' => auth()->id(),
            'images' => '[]'
        ]);

        return redirect()->route('galleries.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $gallery = Gallery::find($id);

        // If the user is the owner
        if ($gallery->user_id === Auth::id()) {
            $gallery->images = json_decode($gallery->images);
            $accesses = Access::where('gallery_id', $gallery->id)
                ->where('user_id', '!=', Auth::id())
                ->get();
            return view('galleries.gallery', compact('gallery', 'accesses'));
        }

        if (Auth::user()->role === 'admin') {
            $gallery->images = json_decode($gallery->images);
            return view('galleries.gallery', compact('gallery'));
        }

        // If the user is viewer and check if he has access
        $hasAccess = Access::where('gallery_id', $id)
            ->where('user_id', Auth::id())
            ->exists();

        if ($hasAccess) {
            $gallery->images = json_decode($gallery->images);
            return view('galleries.gallery', compact('gallery'));
        }

        abort(403, 'Unauthorized access');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|min:2',
        ]);

        $gallery = Gallery::findOrFail($id);
        $gallery->title = $request->title;
        $gallery->save();
        return redirect()->route('galleries.index')->with([
            'success' => "The gallery has been updated successfully!",
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $gallery = Gallery::find($id);
        $gallery->delete();
        return redirect()->route('galleries.index')->with([
            'success' => "The gallery has been deleted successfully!",
        ]);
    }

    public function createImg(Request $request, $id)
    {
        $request->validate([
            'image' => ['required', 'string', 'url'],
            'title' => 'required|min:2',
        ]);

        if ($error = $this->checkImageUrl($request->image)) {
            return redirect()->back()->with(['error' => $error]);
        }

        $gallery = Gallery::findOrFail($id);
        $images = json_decode($gallery->images, true) ?? [];

        $images[] = [
            'path' => $request->image,
            'title' => $request->title,
        ];

        $gallery->images = json_encode($images);
        $gallery->save();

        return redirect()->route('galleries.show', $gallery->id)->with([
            'success' => "The gallery item has been created successfully!",
        ]);
    }

    public function updateImgTitle(Request $request, $id)
    {
        $gallery = Gallery::findOrFail($id);
        $imageIndex = $request->input('image_index');
        $newTitle = $request->input('title');

        $images = collect(json_decode($gallery->images))->map(function ($image, $index) use ($imageIndex, $newTitle) {
            if ($index == $imageIndex) {
                $image->title = $newTitle;
            }
            return $image;
        });

        $gallery->images = json_encode($images->all());
        $gallery->save();
        return redirect()->route('galleries.show', $gallery->id)->with([
            'success' => "The gallery item has been updated successfully!",
        ]);
    }

    public function destroyImg(Request $request, $id)
    {
        $gallery = Gallery::findOrFail($id);
        $imageIndex = $request->input('image_index');

        $gallery->images = json_encode(
            collect(json_decode($gallery->images))
                ->reject(fn($image, $index) => $index == $imageIndex)
                ->map(fn($image) => (object) [
                    'path' => $image->path,
                    'title' => $image->title,
                ])
                ->values()
                ->all()
        );

        $gallery->save();
        return redirect()->route('galleries.show', $gallery->id)->with([
            'success' => "The gallery item has been deleted successfully!",
        ]);
    }


    private function checkImageUrl($url)
    {
        $allowedExtensions = ['jpg', 'jpeg', 'png'];
        $extension = pathinfo(parse_url($url, PHP_URL_PATH), PATHINFO_EXTENSION);

        if (!in_array(strtolower($extension), $allowedExtensions)) {
            return 'The image URL must be a valid JPG or PNG.';
        }

        try {
            $headers = get_headers($url, 1);
            if (!isset($headers['Content-Length']) || $headers['Content-Length'] > 5 * 1024 * 1024) {
                return 'The image URL must be less than 5MB.';
            }
        } catch (Exception $e) {
            return 'The image URL is invalid or inaccessible.';
        }

        return null;
    }
}