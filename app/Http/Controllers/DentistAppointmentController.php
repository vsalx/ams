<?php

namespace App\Http\Controllers;

use App\Appointment;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DentistAppointmentController extends Controller
{
    public function getAppointmentView($dentistId) {
        $dentist = User::where('id', '=', $dentistId)->first();
        return view('appointment')->with('dentist', $dentist);
    }

    public function createAppointment(Request $request, $dentistId) {
        $user = Auth::user();
        $appointment = new Appointment();
        $appointment->appointment_date = $request->date;
        $appointment->appointment_time = $request->time;
        $appointment->dentist_id = $dentistId;
        $appointment->customer_id = $user->getAuthIdentifier();
        $appointment->save();

        return redirect('/');
    }
}
