<?php

namespace App\Http\Controllers;

use App\Appointment;
use Illuminate\Http\Request;
use App\WorkSchedule;

class InternalController extends Controller
{
    function getSchedulesByDentistId($dentistId) {
        $schedules = WorkSchedule::where('dentist_id', '=', $dentistId)->get();
        return response()->json($schedules);
    }

    function getScheduledAppointmentsByDentistId($dentistId, $date) {
        $scheduled = Appointment::where('dentist_id', '=', $dentistId)->where('appointment_date', '=', $date)->get();
        return response()->json($scheduled);
    }
}
