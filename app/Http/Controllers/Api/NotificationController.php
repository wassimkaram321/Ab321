<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use App\Services\NotificationControllerService;
use App\Http\Traits\NotificationTrait;
use App\Models\User;

class NotificationController extends Controller
{
    use NotificationTrait;

    public function sentNotification(Request $request)
    {
        $users = User::where('role_id', 2)->get();
        foreach ($users as $user) {
            if (isset($user->device_token)) {
                $this->send_notification($user->device_token, $request->title, $request->body);
            }
        }

        return $this->success(['title' =>  $request->title, 'body' =>  $request->body], 'success');
    }
}
