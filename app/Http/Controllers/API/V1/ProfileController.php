<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\ChangePasswordRequest;
use App\Http\Requests\Users\ProfileUpdateRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Return the user data
     *
     * @return JsonResponse
     */
    public function profile()
    {
        $response = [
            'success' => true,
            'message' => 'User Profile',
            'data'    => auth('api')->user(),
        ];
        return response()->json($response, 200);
    }


    /**
     * Update the profile by users
     *
     * @param ProfileUpdateRequest $request
     *
     * @return JsonResponse
     */
    public function updateProfile(ProfileUpdateRequest $request)
    {
        $user = auth('api')->user();

        $user->update($request->all());

        $response = [
            'success' => true,
            'message' => 'Profile has been updated',
            'data'    => $user,
        ];
        return response()->json($response, 200);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param ChangePasswordRequest $request
     *
     * @return JsonResponse
     */
    public function changePassword(ChangePasswordRequest $request)
    {
        User::find(auth('api')->user()->id)->update(['password' => Hash::make($request->new_password)]);

        $response = [
            'success' => true,
            'data'    => [],
            'message' => 'Password Has been updated',
        ];
        return response()->json($response, 200);
    }
}
