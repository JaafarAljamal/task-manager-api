<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProfileRequest;
use App\Models\Profile;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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
}
