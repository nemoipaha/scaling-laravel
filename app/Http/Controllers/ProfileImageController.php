<?php

namespace App\Http\Controllers;

use App\Http\Responses\S3FileStream;
use App\ProfileImage;
use Illuminate\Http\Request;

class ProfileImageController extends Controller
{
    /**
     * ProfileImageController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'profile' => 'required|image'
        ]);

        $path = $request->file('profile')->store('profile', 's3');

        $user = auth()->user();

        $image = ProfileImage::updateOrCreate([
            'user_id' => $user->id
        ], [
            'user_id' => $user->id,
            'path' => $path,
        ]);

        return response()->json($image);
    }

    public function show(string $id)
    {
        $image = ProfileImage::where('user_id', auth()->user()->id)
            ->findOrFail($id);

        // Stream to browser
        return (new S3FileStream($image))->output();
    }
}
