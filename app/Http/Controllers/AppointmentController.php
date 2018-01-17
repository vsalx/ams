<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function getAppointmentView($dentistId) {
        $dentist = User::where('id', '=', $dentistId)->first();
        return view('appointment')->with('dentist', $dentist);
    }
}
