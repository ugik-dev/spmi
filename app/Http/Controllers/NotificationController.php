<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use App\Events\NewRequestNotification;
use Illuminate\Support\Facades\Event;

class NotificationController extends Controller
{
    public function test()
    {
        Notification::create([
            'from_user' => 999, 'to_user' => 1,
            'description' => "test notif",
            'url' => 'penganggaran/permohonan-approval/1'
        ]);

        broadcast(new NewRequestNotification(1, 'New request has been submitted.'));
        // $res =  Event::dispatch(new NewRequestNotification(1, 'New request has been submitted.'));
        dd('s');
    }
}
