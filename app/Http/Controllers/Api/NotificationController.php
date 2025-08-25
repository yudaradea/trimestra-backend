<?php

namespace App\Http\Controllers\Api;

use App\Models\AppNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends BaseController
{
    /**
     * Get user notifications
     */
    public function index(Request $request)
    {
        $notifications = Auth::user()->notifications()
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return $this->sendResponse($notifications, 'Notifications retrieved successfully.');
    }

    /**
     * Mark notification as read
     */
    public function markAsRead($id)
    {
        $notification = Auth::user()->notifications()->find($id);

        if (!$notification) {
            return $this->sendError('Notification not found.');
        }

        $notification->update(['is_read' => true]);

        return $this->sendResponse($notification, 'Notification marked as read.');
    }

    /**
     * Mark all notifications as read
     */
    public function markAllAsRead()
    {
        Auth::user()->notifications()->update(['is_read' => true]);

        return $this->sendResponse([], 'All notifications marked as read.');
    }
}
