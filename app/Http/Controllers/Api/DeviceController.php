<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\Device\DeviceRequest;
use App\Services\Api\DeviceService;
use Illuminate\Support\Facades\Auth;

/**
 * @OA\Tag(
 *     name="Device",
 *     description="API Endpoints for Device Integration"
 * )
 */
class DeviceController extends BaseController
{
    private $deviceService;

    public function __construct(DeviceService $deviceService)
    {
        $this->deviceService = $deviceService;
    }

    /**
     * @OA\Post(
     *     path="/device/connect",
     *     summary="Connect device to user",
     *     tags={"Device"},
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"device_uuid"},
     *             @OA\Property(property="device_uuid", type="string", example="device-123456789-abcdef")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Device connected successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="device", type="object"),
     *                 @OA\Property(property="user", ref="#/components/schemas/User")
     *             ),
     *             @OA\Property(property="message", type="string", example="Device connected successfully.")
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
    public function connect(DeviceRequest $request)
    {
        $user = Auth::user();

        try {
            $result = $this->deviceService->connectDevice(
                $request->device_uuid,
                $user
            );

            return $this->sendResponse($result, 'Device connected successfully.');
        } catch (\Exception $e) {
            return $this->sendError('Failed to connect device', [$e->getMessage()], 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/device/sync-exercise",
     *     summary="Sync exercise data from device",
     *     tags={"Device"},
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"exercise_type", "duration", "calories_burned", "start_time", "end_time"},
     *             @OA\Property(property="exercise_type", type="string", example="walking"),
     *             @OA\Property(property="duration", type="integer", example=30),
     *             @OA\Property(property="calories_burned", type="number", format="float", example=150),
     *             @OA\Property(property="start_time", type="string", format="date-time", example="2024-01-15T08:00:00Z"),
     *             @OA\Property(property="end_time", type="string", format="date-time", example="2024-01-15T08:30:00Z")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Exercise data synced successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="object"),
     *             @OA\Property(property="message", type="string", example="Exercise data synced successfully.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Device not connected"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated"
     *     )
     * )
     */
    public function syncExercise(DeviceRequest $request)
    {
        $user = Auth::user();

        try {
            $exercise = $this->deviceService->syncExercise(
                $request->validated(),
                $user
            );

            return $this->sendResponse($exercise, 'Exercise data synced successfully.');
        } catch (\Exception $e) {
            return $this->sendError('Failed to sync exercise data: ' . $e->getMessage(), [], 400);
        }
    }
}
