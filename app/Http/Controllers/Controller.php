<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\SessionReminderMail;
use App\Models\Session;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests,DispatchesJobs;

    
    

    protected function sendReminders()
    {
        $tomorrow = Carbon::tomorrow()->toDateString();
    
        // Get sessions for tomorrow where reminder email has not been sent
        $sessions = Session::whereDate('date', $tomorrow)
                            ->where('reminder_sent', false) // Only unsent reminders
                            ->get();
    
        foreach ($sessions as $session) {
            $userEmail = $session->case->customer->user->email;
    
            // Send the email
            Mail::to($userEmail)->send(new SessionReminderMail($session));
    
            // Update the reminder_sent flag
            $session->reminder_sent = true;
            $session->save();
        }
    }
    
    
}
