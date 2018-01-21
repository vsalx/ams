<?php

namespace App\Http\Controllers;

use App\Appointment;
use App\User;
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
        ->get();
        $email = Auth::user()->email;
        Mail::to($email)->send(new DemoMail());
        return view('home')->with('user', $user)->with('appointments', $appointments);
    }
}
