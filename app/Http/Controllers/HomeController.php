<?php

namespace App\Http\Controllers;

use App\Appointment;
use App\User;
use App\WorkSchedule;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userId = Auth::user()->getAuthIdentifier();
        $user = User::find($userId);
        $appointments = Appointment::query();
        if($user->type == 'CUSTOMER') {
            $appointments->where('customer_id', '=', $userId);
        } else {
            $appointments->where('dentist_id', '=', $userId);
        }
        $appointments = $appointments
            ->with('customer')
            ->with('dentist')
            ->whereRaw("str_to_date(concat(appointment_date,' ',appointment_time), '%Y-%m-%d %H:%i') >= now()")
            ->orderBy('appointment_date', 'asc')
            ->orderBy('appointment_time', 'asc')
        ->get();
        if($user->type != 'CUSTOMER') {
            $schedule = WorkSchedule::where('dentist_id', '=', $user->id)
                ->whereRaw("str_to_date(concat(work_date,' ',end_time), '%Y-%m-%d %H:%i') >= now()")
                ->orderBy('work_date', 'asc')
                ->orderBy('start_time', 'asc')
                ->get();
        }
        return view('home')->with('user', $user)->with('appointments', $appointments)->with('schedules', isset($schedule) ? $schedule : null);
    }

    public function search(Request $request) {
        $query = User::query();
        if($request->has('name')) {
            $query->whereRaw('LOWER(name) like ?', strtolower('%'.$request->name.'%'));
        }
        if ($request->has('city')){
            $query->whereRaw('LOWER(city) like ?', strtolower('%'.$request->city.'%'));
        }
        return redirect()->back()->with('search_result', $query->get());
    }



    public function saveUserToBlacklist(Request $request, $reportedBy) {
        $user = Auth::user();
        $blacklist = new Blacklist();
        $blacklist->user_id = $reportedBy;
        $blacklist->reporter_id = $user->getAuthIdentifier();
        $blacklist->save();

        return redirect()->back()->with('saved_to_blacklist', 'Successfully added to blacklist!');
    }

    public function removeUserFromBlacklist(Request $request) {
        DB::table('blacklists')->where('reporter_id', '=', Auth::user()->getAuthIdentifier())->delete();
        return redirect()->back()->with('saved_to_blacklist', 'Successfully removed from blacklist!');
    }
}
