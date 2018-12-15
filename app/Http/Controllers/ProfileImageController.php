<?php

namespace App\Http\Controllers;

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

        ProfileImage::updateOrCreate([
            'user_id' => $user->id
        ], [
            'user_id' => $user->id,
            'path' => $path,
        ]);

        return response()->json(['path' => $path]);
    }
}
