<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

/**
 * @OA\Info(
 *     title="TRIMESTRA API",
 *     version="1.0.0",
 *     description="API Documentation for TRIMESTRA - Pregnancy Nutrition App",
 *     @OA\Contact(
 *         email="support@trimestra.test"
 *     ),
 *     @OA\License(
 *         name="MIT",
 *         url="https://opensource.org/licenses/MIT"
 *     )
 * )
 * 
 * @OA\Server(
 *     url="http://trimestra-backend.test/api/v1",
 *     description="Development Server"
 * )
 * 
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT"
 * )
 * 
 * @OA\Schema(
 *     schema="SuccessResponse",
 *     @OA\Property(property="success", type="boolean", example=true),
 *     @OA\Property(property="data", type="object"),
 *     @OA\Property(property="message", type="string")
 * )
 * 
 * @OA\Schema(
 *     schema="ErrorResponse",
 *     @OA\Property(property="success", type="boolean", example=false),
 *     @OA\Property(property="message", type="string"),
 *     @OA\Property(property="data", type="object")
 * )
 * 
 * @OA\Schema(
 *     schema="User",
 *     @OA\Property(property="id", type="integer"),
 *     @OA\Property(property="name", type="string"),
 *     @OA\Property(property="email", type="string", format="email"),
 *     @OA\Property(property="phone", type="string"),
 *     @OA\Property(property="role", type="string", enum={"admin", "user"}),
 *     @OA\Property(property="fingerprint_enabled", type="boolean"),
 *     @OA\Property(property="device_connected", type="boolean"),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 * 
 * @OA\Schema(
 *     schema="Food",
 *     @OA\Property(property="id", type="integer"),
 *     @OA\Property(property="category_id", type="integer"),
 *     @OA\Property(property="name", type="string"),
 *     @OA\Property(property="description", type="string"),
 *     @OA\Property(property="calories", type="number", format="float"),
 *     @OA\Property(property="protein", type="number", format="float"),
 *     @OA\Property(property="carbs", type="number", format="float"),
 *     @OA\Property(property="fat", type="number", format="float"),
 *     @OA\Property(property="fiber", type="number", format="float"),
 *     @OA\Property(property="serving_size", type="string"),
 *     @OA\Property(property="cooking_time", type="integer"),
 *     @OA\Property(property="is_pregnancy_safe", type="boolean"),
 *     @OA\Property(property="is_active", type="boolean"),
 *     @OA\Property(property="allergens", type="array", @OA\Items(type="string")),
 *     @OA\Property(property="diet_types", type="array", @OA\Items(type="string")),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 * 
 * @OA\Schema(
 *     schema="Recipe",
 *     @OA\Property(property="id", type="integer"),
 *     @OA\Property(property="food_id", type="integer"),
 *     @OA\Property(property="title", type="string"),
 *     @OA\Property(property="ingredients", type="array", @OA\Items(type="string")),
 *     @OA\Property(property="instructions", type="array", @OA\Items(type="string")),
 *     @OA\Property(property="prep_time", type="integer"),
 *     @OA\Property(property="cook_time", type="integer"),
 *     @OA\Property(property="servings", type="integer"),
 *     @OA\Property(property="difficulty", type="string", enum={"easy", "medium", "hard"}),
 *     @OA\Property(property="is_active", type="boolean"),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time"),
 *     @OA\Property(property="food", ref="#/components/schemas/Food")
 * )
 * 
 * @OA\Schema(
 *     schema="DiaryEntry",
 *     @OA\Property(property="id", type="integer"),
 *     @OA\Property(property="user_id", type="integer"),
 *     @OA\Property(property="date", type="string", format="date"),
 *     @OA\Property(property="meal_type", type="string", enum={"breakfast", "lunch", "dinner", "snack", "exercise"}),
 *     @OA\Property(property="food_id", type="integer", nullable=true),
 *     @OA\Property(property="recipe_id", type="integer", nullable=true),
 *     @OA\Property(property="quantity", type="number", format="float"),
 *     @OA\Property(property="calories", type="number", format="float"),
 *     @OA\Property(property="protein", type="number", format="float"),
 *     @OA\Property(property="carbs", type="number", format="float"),
 *     @OA\Property(property="fat", type="number", format="float"),
 *     @OA\Property(property="fiber", type="number", format="float"),
 *     @OA\Property(property="exercise_type", type="string", nullable=true),
 *     @OA\Property(property="exercise_duration", type="integer", nullable=true),
 *     @OA\Property(property="calories_burned", type="number", format="float", nullable=true),
 *     @OA\Property(property="device_id", type="integer", nullable=true),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 */

class BaseController extends Controller
{
    /**
     * Success response method
     */
    public function sendResponse($result, $message, $code = 200): JsonResponse
    {
        $response = [
            'success' => true,
            'data'    => $result,
            'message' => $message,
        ];

        return response()->json($response, $code);
    }

    /**
     * Return error response
     */
    public function sendError($error, $errorMessages = [], $code = 404): JsonResponse
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];

        if (!empty($errorMessages)) {
            $response['data'] = $errorMessages;
        }

        return response()->json($response, $code);
    }
}
