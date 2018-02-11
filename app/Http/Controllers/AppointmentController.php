<?php

namespace App\Http\Controllers;

use App\Appointment;
use App\AppointmentDetails;
use App\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Mail;

class AppointmentController extends Controller
{
    public function cancel($appointmentId) {
        $userId = Auth::user()->getAuthIdentifier();
        $user = User::find($userId);
        $appointment = Appointment::find($appointmentId);
        $appointment->cancelled_by = $userId;
        $appointment->cancelled_on = now();
        $appointment->save();

        $appointmentTime = Carbon::createFromFormat('Y-m-d H:i:s', $appointment->appointment_date . ' ' . $appointment->appointment_time, 'Europe/Sofia');
        $now = Carbon::now('Europe/Sofia');
        if ($user->type == 'CUSTOMER' && $appointmentTime->diffInMinutes($now) < 60) {
            $fee = AppointmentDetails::create([
                'description' => 'Appointment cancellation fee.',
                'price' => '10.00',
                'appointment_id' => $appointmentId
            ]);

            $fee->save();
        }

        Mail::send('emails.cancel_appointments', ['user' => $user, 'appointment' => $appointment], function($message) use ($user, $appointment)
        {
            $message->from('amsprojectnbu@gmail.com', "amsprojectnbu");
            $message->subject("Cancelled appointment");
            $message->to($user->email);
        });

        return redirect()->back()->with('status', isset($fee) ? 'Appointment cancelled with fee 10 euro!' : 'Appointment cancelled!');
    }
}
