<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends BaseController
{
    /**
     * Update user profile
     */
    public function update(Request $request)
    {
        $userLogin = Auth::user();
        $user = User::find($userLogin->id);

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'sometimes|string|max:20|unique:users,phone,' . $user->id,
            'profile_photo' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048',

        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error', $validator->errors(), 422);
        }

        $user->update($request->except('profile_photo'));
        if ($request->hasFile('profile_photo')) {
            //detach old media if exists
            $user->clearMediaCollection('profile_photo');

            //add new media
            $user->addMediaFromRequest('profile_photo')
                ->toMediaCollection('profile_photo');
        }

        return $this->sendResponse($user, 'User updated successfully.');
    }

    /**
     * Delete user account
     */
    public function destroy(Request $request)
    {
        $userLogin = Auth::user();
        $user = User::find($userLogin->id);
        $user->delete();

        return $this->sendResponse([], 'User deleted successfully.');
    }
}
