<?php

namespace App\Http\Controllers;

use App\Appointment;
use App\WorkSchedule;

class InternalController extends Controller
{
    function getSchedulesByDentistId($dentistId) {
        $schedules = WorkSchedule::where('dentist_id', '=', $dentistId)->get();
        return response()->json($schedules);
    }

    function getScheduledAppointmentsByDentistId($dentistId, $date) {
        $scheduled = Appointment::where('dentist_id', '=', $dentistId)
            ->where('appointment_date', '=', $date)
            ->where('cancelled_by', '=', null)
            ->get();
        return response()->json($scheduled);
    }
}
