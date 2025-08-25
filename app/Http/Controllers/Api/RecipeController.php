<?php

namespace App\Http\Controllers\Api;

use App\Models\Recipe;
use Illuminate\Http\Request;

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

        $recipes = Recipe::with('food:id,name,description,calories,protein,carbs,fat,fiber')
            ->where('is_active', true)
            ->paginate($perPage);

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
        $recipe = Recipe::with('food:id,name,description,calories,protein,carbs,fat,fiber')
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

        $recipes = Recipe::with('food:id,name,description,calories,protein,carbs,fat,fiber')
            ->where('is_active', true)
            ->where(function ($q) use ($query) {
                $q->where('title', 'LIKE', "%{$query}%")
                    ->orWhereHas('food', function ($subQ) use ($query) {
                        $subQ->where('name', 'LIKE', "%{$query}%")
                            ->orWhere('description', 'LIKE', "%{$query}%");
                    });
            })
            ->paginate(20);

        return $this->sendResponse($recipes, 'Search results retrieved successfully.');
    }
}
