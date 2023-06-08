<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\User;
use App\Traits\NotificationTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NotificationService
{
    use NotificationTrait;
    protected $notification;

    public function __construct()
    {
        $this->notification = new Notification();
    }

    public function all($request)
    {
        return $this->notification->orderBy('created_at', 'desc')->app();
    }

    public function find($request)
    {
        return $this->notification->findOrFail($request->id);
    }

    public function create($request)
    {
        $notification = $this->notification->create($request->all());
        $users = User::where('enable_notification', 1)->where('role_id', 2)->get();
        foreach ($users as $user) {
            $notification->users()->attach(['user_id' => $user->id]);
            if (isset($user->device_token)) {
                $this->send_notification($user->device_token, $request->title, $request->body);
            }
        }
        return $notification;
    }

    public function update($request)
    {
        return tap($this->notification->findOrFail($request->id)->update($request->all()));
    }

    public function delete($request)
    {
        $this->notification->findOrFail($request->id)->delete();
    }

    public function seeAll($request)
    {
        DB::table('user_notification')->where('user_id', '=',  Auth::id())->update(['seen' => 1, 'seen_at' => now()]);
    }
    public function unseenCount($request)
    {
        $user = User::where('id', Auth::id())->first();
        return $user->notifications()->where('seen', 0)->orderBy('created_at', 'desc')->count();
    }
}
