<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\UserFavorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserFavoriteController extends BaseController
{
    /**
     * Get user favorites
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $favorites = $user->favorites()
            ->with(['food', 'recipe'])
            ->paginate(20);

        return $this->sendResponse($favorites, 'Favorites retrieved successfully.');
    }

    /**
     * Add to favorites
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type' => 'required|in:food,recipe,fruit,drink',
            'food_id' => 'required_if:type,food,fruit,drink|exists:food,id',
            'recipe_id' => 'required_if:type,recipe|exists:recipes,id',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error', $validator->errors(), 422);
        }

        $user = Auth::user();
        $favorite = $user->favorites()->create($request->all());

        return $this->sendResponse($favorite, 'Added to favorites successfully.');
    }

    /**
     * Remove from favorites
     */
    public function destroy($id)
    {
        $user = Auth::user();
        $favorite = $user->favorites()->find($id);

        if (!$favorite) {
            return $this->sendError('Favorite not found.');
        }

        $favorite->delete();

        return $this->sendResponse([], 'Removed from favorites successfully.');
    }
}
