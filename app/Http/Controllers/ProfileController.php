<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProfileRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Create a profile for the authenticated user.
     * Returns 201 Created with the profile data.
     */
    public function store(StoreProfileRequest $request): JsonResponse
    {
        $user = Auth::user();
        if ($user->profile) {
            return response()->json(['message', 'Profile already exists!'], 409);
        }
        $data = $request->validated();
        $data['user_id'] = $user->id;
        $profile = Profile::create($data);

        return response()->json($profile, 201);
    }

    /**
     * Display the user's profile by user ID and return a JSON response with status 200 OK.
     *
     * @param  int  $user_id
     */
    public function show($user_id): JsonResponse
    {
        $user = User::findOrFail($user_id);
        $profile = $user->profile;

        if (! $profile) {
            return response()->json(['message' => 'Profile not found'], 404);
        }

        return response()->json($profile, 200);
    }

    /**
     * Update the user's profile by user ID and return a JSON response with status 200 OK.
     *
     * @param  App\Http\Requests\UpdateProfileRequest  $request
     * @param  int  $user_id
     */
    public function update(UpdateProfileRequest $request, $user_id): JsonResponse
    {
        $profile = User::findOrFail($user_id)->profile;

        if (! $profile) {
            return response()->json(['message' => 'Profile not found'], 404);
        }

        $data = $request->validated();
        $profile->updateOrFail($data);

        return response()->json($profile, 200);
    }
}
