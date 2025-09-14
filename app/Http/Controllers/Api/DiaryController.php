<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\Diary\DiaryEntryRequest;
use App\Models\DiaryEntry;
use App\Services\Api\DiaryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * @OA\Tag(
 *     name="Diary",
 *     description="API Endpoints for Diary Management"
 * )
 */
class DiaryController extends BaseController
{
    private $diaryService;

    public function __construct(DiaryService $diaryService)
    {
        $this->diaryService = $diaryService;
    }

    /**
     * @OA\Get(
     *     path="/diary",
     *     summary="Get diary entries for a date",
     *     tags={"Diary"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="date",
     *         in="query",
     *         description="Date in Y-m-d format",
     *         @OA\Schema(type="string", format="date")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Diary entries retrieved successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="entries", type="array", @OA\Items(ref="#/components/schemas/DiaryEntry")),
     *                 @OA\Property(property="summary", type="object"),
     *                 @OA\Property(property="date", type="string", format="date")
     *             ),
     *             @OA\Property(property="message", type="string", example="Diary entries retrieved successfully.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated"
     *     )
     * )
     */
    public function index(Request $request)
    {
        $date = $request->get('date', date('Y-m-d'));
        $user = Auth::user();

        try {
            $entries = $this->diaryService->getRecentDiaryEntries($user->id, $date);
            $summary = $this->diaryService->getDailySummary($user->id, $date);

            $data = [
                'entries' => $entries,
                'summary' => $summary,
                'date' => $date
            ];

            return $this->sendResponse($data, 'Diary entries retrieved successfully.');
        } catch (\Exception $e) {
            return $this->sendError('Failed to retrieve diary entries: ' . $e->getMessage());
        }
    }

    /**
     * @OA\Post(
     *     path="/diary",
     *     summary="Add diary entry",
     *     tags={"Diary"},
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"date", "meal_type"},
     *             @OA\Property(property="date", type="string", format="date", example="2024-01-15"),
     *             @OA\Property(property="meal_type", type="string", enum={"breakfast", "lunch", "dinner", "snack", "exercise"}),
     *             @OA\Property(property="food_id", type="integer", example=1),
     *             @OA\Property(property="recipe_id", type="integer", example=1),
     *             @OA\Property(property="quantity", type="number", format="float", example=1.5),
     *             @OA\Property(property="exercise_type", type="string", example="walking"),
     *             @OA\Property(property="exercise_duration", type="integer", example=30)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Diary entry added successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/DiaryEntry"),
     *             @OA\Property(property="message", type="string", example="Diary entry added successfully.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated"
     *     )
     * )
     */
    public function store(DiaryEntryRequest $request)
    {
        $user = Auth::user();

        try {
            $entry = $this->diaryService->createDiaryEntry(
                $request->validated(),
                $user
            );

            return $this->sendResponse($entry, 'Diary entry added successfully.');
        } catch (\Exception $e) {
            return $this->sendError('Failed to create diary entry', [$e->getMessage()], 500);
        }
    }

    /**
     * Delete diary entry
     */
    public function destroy($id)
    {
        $user = Auth::user();

        try {
            $entry = DiaryEntry::where('user_id', $user->id)->find($id);

            if (!$entry) {
                return $this->sendError('Diary entry not found.');
            }

            $date = $entry->date;
            $entry->delete();

            // Update daily summary after deletion
            $this->diaryService->updateDailySummary($user->id, $date);

            return $this->sendResponse([], 'Diary entry deleted successfully.');
        } catch (\Exception $e) {
            return $this->sendError('Failed to delete diary entry: ' . $e->getMessage());
        }
    }

    /**
     * @OA\Get(
     *     path="/diary/summary",
     *     summary="Get daily summary",
     *     tags={"Diary"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="date",
     *         in="query",
     *         description="Date in Y-m-d format",
     *         @OA\Schema(type="string", format="date")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Daily summary retrieved successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="id", type="integer"),
     *                 @OA\Property(property="user_id", type="integer"),
     *                 @OA\Property(property="date", type="string", format="date"),
     *                 @OA\Property(property="total_calories_intake", type="number", format="float"),
     *                 @OA\Property(property="total_calories_burned", type="number", format="float"),
     *                 @OA\Property(property="total_protein", type="number", format="float"),
     *                 @OA\Property(property="total_carbs", type="number", format="float"),
     *                 @OA\Property(property="total_fat", type="number", format="float"),
     *                 @OA\Property(property="total_fiber", type="number", format="float"),
     *                 @OA\Property(property="target_calories", type="number", format="float")
     *             ),
     *             @OA\Property(property="message", type="string", example="Daily summary retrieved successfully.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated"
     *     )
     * )
     */
    public function summary(Request $request)
    {
        $date = $request->get('date', date('Y-m-d'));
        $user = Auth::user();

        try {
            // Always get fresh summary with current target
            $summary = $this->diaryService->getDailySummary($user->id, $date);

            return $this->sendResponse($summary, 'Daily summary retrieved successfully.');
        } catch (\Exception $e) {
            return $this->sendError('Failed to retrieve daily summary: ' . $e->getMessage());
        }
    }

    // ✅ TAMBAHKAN: Endpoint untuk sync target calories
    public function syncTargetCalories(Request $request)
    {
        $user = Auth::user();
        $date = $request->get('date', date('Y-m-d'));

        try {
            $targetCalories = $this->diaryService->syncTargetCalories($user->id, $date);

            // Get updated summary
            $summary = $this->diaryService->getDailySummary($user->id, $date);

            return $this->sendResponse($summary, 'Target calories synced successfully.');
        } catch (\Exception $e) {
            return $this->sendError('Failed to sync target calories: ' . $e->getMessage());
        }
    }
}
