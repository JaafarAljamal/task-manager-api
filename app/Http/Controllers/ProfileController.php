<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Function to store a newly created profile and return a JSON response
     * with status 201 Created.
     * 
     * @param Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $profile = Profile::create([
            'user_id' => $request->user_id,
            'phone' => $request->phone,
            'address' => $request->address,
            'date_of_birth' => $request->date_of_birth,
            'bio' => $request->bio,
        ]);

        return response()->json($profile, 201);
    }
}
