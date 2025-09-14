<?php

namespace App\Http\Controllers\Api;

use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * @OA\Tag(
 *     name="Recipes",
 *     description="API Endpoints for Recipe Management"
 * )
 */
class RecipeController extends BaseController
{
    /**
     * @OA\Get(
     *     path="/recipes",
     *     summary="Get all recipes",
     *     tags={"Recipes"},
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         description="Page number",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="per_page",
     *         in="query",
     *         description="Items per page",
     *         @OA\Schema(type="integer", maximum=100)
     *     ),
     *     @OA\Parameter(
     *         name="difficulty",
     *         in="query",
     *         description="Filter by difficulty (easy, medium, hard)",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="cooking_time",
     *         in="query",
     *         description="Filter by cooking time (<30, 30-60, >60)",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="servings",
     *         in="query",
     *         description="Filter by servings (1, 2, 3, 4, >4)",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="q",
     *         in="query",
     *         description="Search query",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Recipes retrieved successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Recipe")),
     *                 @OA\Property(property="links", type="object"),
     *                 @OA\Property(property="meta", type="object")
     *             ),
     *             @OA\Property(property="message", type="string", example="Recipes retrieved successfully.")
     *         )
     *     )
     * )
     */
    public function index(Request $request)
    {
        $perPage = min($request->get('per_page', 20), 100);

        // Base query dengan eager loading
        $query = Recipe::with([
            'food:id,name,description,calories,protein,carbs,fat,fiber,image_path,category_id,cooking_time,is_pregnancy_safe',
            'food.category:id,name,image_path'
        ])
            ->where('is_active', true);

        // ✅ TAMBAHKAN: Apply semua filters
        $this->applyFilters($query, $request);

        // Order by latest first
        $query->orderBy('created_at', 'desc');

        $recipes = $query->paginate($perPage);

        return $this->sendResponse($recipes, 'Recipes retrieved successfully.');
    }

    /**
     * @OA\Get(
     *     path="/recipes/{id}",
     *     summary="Get recipe by ID",
     *     tags={"Recipes"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Recipe ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Recipe retrieved successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/Recipe"),
     *             @OA\Property(property="message", type="string", example="Recipe retrieved successfully.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Recipe not found",
     *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
     *     )
     * )
     */
    public function show($id)
    {
        $recipe = Recipe::with([
            'food:id,name,description,calories,protein,carbs,fat,fiber,image_path,category_id,cooking_time,is_pregnancy_safe,allergens,diet_types',
            'food.category:id,name,image_path',

        ])
            ->find($id);

        if (!$recipe) {
            return $this->sendError('Recipe not found.');
        }

        return $this->sendResponse($recipe, 'Recipe retrieved successfully.');
    }

    /**
     * @OA\Get(
     *     path="/recipes/search",
     *     summary="Search recipes",
     *     tags={"Recipes"},
     *     @OA\Parameter(
     *         name="q",
     *         in="query",
     *         required=true,
     *         description="Search query",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         description="Page number",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="difficulty",
     *         in="query",
     *         description="Filter by difficulty (easy, medium, hard)",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="cooking_time",
     *         in="query",
     *         description="Filter by cooking time (<30, 30-60, >60)",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="servings",
     *         in="query",
     *         description="Filter by servings (1, 2, 3, 4, >4)",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Search results retrieved successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Recipe")),
     *                 @OA\Property(property="links", type="object"),
     *                 @OA\Property(property="meta", type="object")
     *             ),
     *             @OA\Property(property="message", type="string", example="Search results retrieved successfully.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
     *     )
     * )
     */
    public function search(Request $request)
    {
        $query = $request->get('q');

        if (!$query) {
            return $this->sendError('Search query is required.');
        }

        $perPage = min($request->get('per_page', 20), 100);

        // Base query dengan eager loading
        $recipeQuery = Recipe::with([
            'food:id,name,description,calories,protein,carbs,fat,fiber,image_path,category_id,cooking_time,is_pregnancy_safe',
            'food.category:id,name,image_path'
        ])
            ->where('is_active', true)
            ->where(function ($q) use ($query) {
                $q->where('title', 'LIKE', "%{$query}%")
                    ->orWhereHas('food', function ($subQ) use ($query) {
                        $subQ->where('name', 'LIKE', "%{$query}%")
                            ->orWhere('description', 'LIKE', "%{$query}%");
                    });
            });

        // ✅ TAMBAHKAN: Apply filters ke search juga
        $this->applyFilters($recipeQuery, $request);

        $recipes = $recipeQuery->paginate($perPage);

        return $this->sendResponse($recipes, 'Search results retrieved successfully.');
    }

    /**
     * ✅ TAMBAHKAN: Method untuk apply semua filters
     */
    private function applyFilters($query, Request $request)
    {
        // Difficulty filter
        if ($request->has('difficulty') && $request->difficulty) {
            $query->where('difficulty', $request->difficulty);
        }

        // Cooking time filter
        if ($request->has('cooking_time') && $request->cooking_time) {
            $cookingTime = $request->cooking_time;

            switch ($cookingTime) {
                case '<30':
                    $query->whereRaw('(prep_time + cook_time) < 30');
                    break;

                case '30-60':
                    $query->whereRaw('(prep_time + cook_time) BETWEEN 30 AND 60');
                    break;

                case '>60':
                    $query->whereRaw('(prep_time + cook_time) > 60');
                    break;
            }
        }

        // Servings filter
        if ($request->has('servings') && $request->servings) {
            $servings = $request->servings;

            if ($servings === '>4') {
                $query->where('servings', '>', 4);
            } else {
                $query->where('servings', $servings);
            }
        }

        // User-specific filters
        $user = Auth::user();
        if ($user) {
            // Filter berdasarkan kehamilan
            if ($user->profile && $user->profile->is_pregnant) {
                $query->whereHas('food', function ($q) {
                    $q->where('is_pregnancy_safe', true);
                });
            }

            // Filter berdasarkan alergi
            if ($user->preferences && !empty($user->preferences->allergies) && !in_array('tidak ada', $user->preferences->allergies)) {
                $allergies = array_filter($user->preferences->allergies, function ($allergy) {
                    return $allergy !== 'tidak ada' && !empty($allergy);
                });

                foreach ($allergies as $allergy) {
                    $query->whereHas('food', function ($q) use ($allergy) {
                        $q->where(function ($subQ) use ($allergy) {
                            $subQ->whereNull('allergens')
                                ->orWhere('allergens', '[]')
                                ->orWhere('allergens', 'not like', '%"' . $allergy . '"%');
                        });
                    });
                }
            }

            // Filter berdasarkan diet preference
            if ($user->preferences && $user->preferences->diet_type && $user->preferences->diet_type !== 'no_preference') {
                $query->whereHas('food', function ($q) use ($user) {
                    $q->where(function ($subQ) use ($user) {
                        $subQ->whereNull('diet_types')
                            ->orWhere('diet_types', '[]')
                            ->orWhere('diet_types', 'like', '%"' . $user->preferences->diet_type . '"%');
                    });
                });
            }
        }
    }
}
