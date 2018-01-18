<?php

namespace App\Http\Controllers;

use App\Review;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DentistController extends Controller
{
    public function getDentistProfile($dentistId){
        $dentist = User::with('reviews.reviewer')->where('id', '=', $dentistId)->where('type', '!=', 'CUSTOMER')->first();
        if($dentist == null) {
            return abort(404);
        }
        return view('profile/dentist')->with('dentist', $dentist);
    }

    public function createAppointment(Request $request, $dentistId) {
        $user = Auth::user();
        $appointment = new Appointment();
        $appointment->appointment_date = $request->date;
        $appointment->appointment_time = $request->time;
        $appointment->dentist_id = $dentistId;
        $appointment->customer_id = $user->getAuthIdentifier();
        $appointment->save();

        return redirect()->back()->with('message','Часът беше запазен успешно!');
    }

    public function createReview(Request $request, $dentistId){
        $reviewer = Auth::user();
        $review = new Review();
        $review->user_id = $dentistId;
        $review->reviewer_id = $reviewer->getAuthIdentifier();
        $review->comment = $request->comment;
        $review->rating = $request->rating;
        $review->save();

        return redirect()->back();
    }
}
