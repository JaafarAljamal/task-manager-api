<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProfileRequest;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Function to store a newly created profile and return a JSON response
     * with status 201 Created.
     * 
     * @param App\Http\Requests\StoreProfileRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreProfileRequest $request): JsonResponse
    {
        $data = $request->validated();
        $profile = Profile::create($data);
        return response()->json($profile, 201);
    }

    /**
     * Function to view the user's profile by user ID and return 
     * a JSON response with status 200 OK.
     * 
     * @param $user_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($user_id): JsonResponse
    {
        $user = User::findOrFail($user_id);
        $profile = $user->profile;

        if (! $profile) {
            return response()->json(['message' => 'Profile not found', 404]);
        }

        return response()->json($profile, 200);
    }
}
