<?php

namespace App\Http\Controllers;

use App\Appointment;
use App\Review;
use App\User;
use App\WorkSchedule;
use App\Blacklist;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Mail;
use DB;

class DentistController extends Controller
{
    public function getDentistProfile($dentistId){
        $dentist = User::with('reviews.reviewer')
            ->where('id', '=', $dentistId)
            ->where('type', '!=', 'CUSTOMER')
            ->first();
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
        
        Mail::send('emails.create_appointment', ['user' => $user, 'appointment' => $appointment], function($message) use ($user, $appointment)
        {
            $message->from('amsprojectnbu@gmail.com', "amsprojectnbu");
            $message->subject("Created appointment");
            $message->to($user->email);
        });
        
        $dentistObject = User::find( $dentistId);
        Mail::send('emails.dentist_appointment', ['dentistObject' => $dentistObject, 'appointment' => $appointment], function($message) use ($dentistObject, $appointment)
        {
            $message->from('amsprojectnbu@gmail.com', "amsprojectnbu");
            $message->subject("Created appointment");
            $message->to($dentistObject->email);
        });

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

    public function createSchedule(Request $request, $dentistId) {
        $validator = Validator::make($request->all(), [
            'date' => 'required',
            'start_time' => 'required',
            'end_time' => 'required'
        ]);

        if($validator->fails()) {
            return redirect()->back()->with('schedule_validation', 'All fields are required!');
        }

        $startTime = Carbon::createFromFormat('Y-m-d H:i', $request->date . ' ' . $request->start_time, 'Europe/Sofia');
        $endTime = Carbon::createFromFormat('Y-m-d H:i', $request->date . ' ' . $request->end_time, 'Europe/Sofia');

        if($startTime->gte($endTime)) {
            return redirect()->back()->with('schedule_validation', 'End time should be after start time!');
        }

        $schedule = WorkSchedule::create([
            'dentist_id' => Auth::user()->getAuthIdentifier(),
            'work_date' => $request->date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time
        ]);

        $schedule->save();

        return redirect()->back()->with('schedule_created', 'Schedule created successfuly!');
    }

    public function saveDentistToBlacklist(Request $request, $reportedBy) {
        $user = Auth::user();
        $blacklist = new Blacklist();
        $blacklist->user_id = $reportedBy;
        $blacklist->reporter_id = $user->getAuthIdentifier();
        $blacklist->save();

        return redirect()->back()->with('saved_to_blacklist', 'Successfully added to blacklist!');
    }

    public function removeDentistFromBlacklist(Request $request) {
        DB::table('blacklists')->where('reporter_id', '=', Auth::user()->getAuthIdentifier())->delete();
        return redirect()->back()->with('remove_from_blacklist', 'Successfully removed from blacklist!');
    }
}
