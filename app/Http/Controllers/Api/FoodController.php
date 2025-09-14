<?php

namespace App\Http\Controllers\Api;

use App\Services\Api\FoodRecommendationService;
use App\Models\Food;
use App\Models\FoodCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

/**
 * @OA\Tag(
 *     name="Foods",
 *     description="API Endpoints for Food Management"
 * )
 */
class FoodController extends BaseController
{
    private $recommendationService;

    public function __construct(FoodRecommendationService $recommendationService)
    {
        $this->recommendationService = $recommendationService;
    }

    /**
     * Get all foods with pagination (optimized)
     */
    public function index(Request $request)
    {
        $perPage = min($request->get('per_page', 20), 100); // Limit max per page

        $foods = Food::with('category:id,name,image_path') // Select only needed fields
            ->active()
            ->paginate($perPage);

        return $this->sendResponse($foods, 'Foods retrieved successfully.');
    }


    /**
     * @OA\Get(
     *     path="/foods/{id}",
     *     summary="Get food by ID",
     *     tags={"Foods"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Food ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Food retrieved successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/Food"),
     *             @OA\Property(property="message", type="string", example="Food retrieved successfully.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Food not found"
     *     )
     * )
     */
    public function search(Request $request)
    {
        $query = $request->get('q');
        $perPage = min($request->get('per_page', 20), 100);

        if (!$query) {
            return $this->sendError('Search query is required.');
        }

        // Optimized search with select
        $foods = Food::with('category:id,name,image_path')
            ->active()
            ->where(function ($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%")
                    ->orWhere('description', 'LIKE', "%{$query}%");
            })
            ->select(['id', 'category_id', 'name', 'description', 'calories', 'protein', 'carbs', 'fat', 'fiber', 'created_at']) // Select only needed fields
            ->paginate($perPage);

        return $this->sendResponse($foods, 'Search results retrieved successfully.');
    }

    /**
     * Get food by ID
     */
    public function show($id)
    {
        // Use cache key for individual food items
        $food = Food::with('category:id,name,image_path')
            ->select(['id', 'category_id', 'name', 'description', 'calories', 'protein', 'carbs', 'fat', 'fiber', 'serving_size', 'cooking_time', 'is_pregnancy_safe', 'is_active', 'allergens', 'diet_types', 'created_at', 'updated_at', 'image_path'])
            ->find($id);

        if (!$food) {
            return $this->sendError('Food not found.');
        }

        $foodData = $food->toArray();
        $foodData['image_path'] = $food->image_path;

        return $this->sendResponse($foodData, 'Food retrieved successfully.');
    }

    /**
     * @OA\Get(
     *     path="/foods/category/{categoryId}",
     *     summary="Get foods by category",
     *     tags={"Foods"},
     *     @OA\Parameter(
     *         name="categoryId",
     *         in="path",
     *         required=true,
     *         description="Category ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Foods by category retrieved successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Food")),
     *                 @OA\Property(property="links", type="object"),
     *                 @OA\Property(property="meta", type="object")
     *             ),
     *             @OA\Property(property="message", type="string", example="Foods by category retrieved successfully.")
     *         )
     *     )
     * )
     */
    public function byCategory($categoryId)
    {
        $foods = Food::with('category:id,name,image_path')
            ->byCategory($categoryId)
            ->active()
            ->paginate(20);

        return $this->sendResponse($foods, 'Foods by category retrieved successfully.');
    }

    /**
     * @OA\Get(
     *     path="/categories",
     *     summary="Get all food categories",
     *     tags={"Foods"},
     *     @OA\Response(
     *         response=200,
     *         description="Categories retrieved successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="id", type="integer"),
     *                     @OA\Property(property="name", type="string"),
     *                     @OA\Property(property="icon", type="string")
     *                 )
     *             ),
     *             @OA\Property(property="message", type="string", example="Categories retrieved successfully.")
     *         )
     *     )
     * )
     */
    public function categories()
    {
        $categories = Cache::remember('food_categories', 3600, function () {
            return FoodCategory::select(['id', 'name', 'image_path'])->get();
        });

        return $this->sendResponse($categories, 'Categories retrieved successfully.');
    }

    /**
     * @OA\Get(
     *     path="/foods/recommended",
     *     summary="Get recommended foods for user",
     *     tags={"Foods"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Recommended foods retrieved successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="foods", type="array", @OA\Items(ref="#/components/schemas/Food")),
     *                 @OA\Property(property="total_results", type="integer")
     *             ),
     *             @OA\Property(property="message", type="string", example="Recommended foods retrieved successfully.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated"
     *     )
     * )
     */
    public function recommended(Request $request)
    {
        $user = Auth::user();
        $foods = $this->recommendationService->getRecommendedFoods($user);

        $responseData = [
            'foods' => $foods,
            'total_results' => $foods->count()
        ];

        return $this->sendResponse($responseData, 'Recommended foods retrieved successfully.');
    }
}
