<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProfileRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Models\Profile;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Create a profile for the authenticated user.
     * Returns 201 Created with the profile data or 409 if profile already exists.
     */
    public function store(StoreProfileRequest $request): JsonResponse
    {
        $user = Auth::user();
        if ($user->profile) {
            return response()->json(['message', 'Profile already exists!'], 409);
        }
        $data = $request->validated();
        $data['user_id'] = $user->id;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('my_photo', 'public');
            $data['image'] = $path;
        }
        $profile = Profile::create($data);

        return response()->json([
            'message' => 'Profile created successfully',
            'profile' => $profile,
        ], 201);
    }

    /**
     * Show the authenticated user's profile.
     * Returns 200 OK with profile data or 404 if not found.
     */
    public function show(): JsonResponse
    {
        $profile = Auth::user()->profile;

        if (! $profile) {
            return response()->json(['message' => 'Profile not found'], 404);
        }

        return response()->json($profile, 200);
    }

    /**
     * Update the authenticated user's profile.
     * Returns 200 OK with updated profile data or 404 if not found.
     */
    public function update(UpdateProfileRequest $request): JsonResponse
    {
        $user = Auth::user();
        $profile = $user->profile;

        if (! $profile) {
            return response()->json(['message' => 'Profile not found'], 404);
        }

        $data = $request->validated();
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('my_photo', 'public');
            $oldImage = $profile->image;
            if ($oldImage) {
                Storage::disk('public')->delete($oldImage);
            }

            $data['image'] = $path;
        }
        $profile->updateOrFail($data);

        return response()->json($profile, 200);
    }
}
