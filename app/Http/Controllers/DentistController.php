<?php

namespace App\Http\Controllers;

use App\Appointment;
use App\Review;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

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

        $validator = Validator::make($request->all(), [
            'time' => 'required',
            'date' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = Auth::user();
        $appointment = new Appointment();
        $appointment->appointment_date = $request->date;
        $appointment->appointment_time = $request->time;
        $appointment->dentist_id = $dentistId;
        $appointment->customer_id = $user->getAuthIdentifier();
        $appointment->save();

        return redirect()->back()->with('appointment_status','Appointment created successfuly!');
    }

    public function createReview(Request $request, $dentistId){
        $validator = Validator::make($request->all(), [
            'comment' => 'required|max:255',
            'rating' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $reviewer = Auth::user();
        $review = new Review();
        $review->user_id = $dentistId;
        $review->reviewer_id = $reviewer->getAuthIdentifier();
        $review->comment = $request->comment;
        $review->rating = $request->rating;
        $review->save();

        return redirect()->back();
    }

    public function search(Request $request) {
        $query = User::query();
        if($request->has('name')) {
            $query->whereRaw('LOWER(name) like ?', strtolower('%'.$request->name.'%'));
        }
        if ($request->has('city')){
            $query->whereRaw('LOWER(city) like ?', strtolower('%'.$request->city.'%'));
        }
        if($request->has('type')){
            $query->where('type', '=', $request->type);
        } else {
            $query->where('type', '!=', 'CUSTOMER');
        }
        if($request->has('rating')) {
            //todo make it work :D
            $query->with('reviews.rating')->groupBy('reviews.rating')->havingRaw('AVG(reviews.rating >='.$request->rating);
        }

        return redirect()->back()->with('search_result', $query->get());
    }
}
